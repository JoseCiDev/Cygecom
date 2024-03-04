<?php

namespace App\Services;

use Closure;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{DB, Gate};
use App\Enums\{PurchaseRequestType, PurchaseRequestStatus};
use App\Models\User;

class ReportService
{
    public function getRequistingUsers(): Collection
    {
        $currentUserId = auth()->user()->id;

        $requestingUsersQuery = User::with('person', 'purchaseRequest.costCenterApportionment.costCenter');

        if (!Gate::allows('admin') && !Gate::allows('diretor')) {
            $requestingUsersQuery->where('id', $currentUserId);
        } elseif (Gate::allows('diretor') && !Gate::allows('admin')) {
            $requestingUsersQuery
                ->where('id', $currentUserId)
                ->orWhere('approver_user_id', $currentUserId);
        }

        $requestingUsersQuery->whereHas('purchaseRequest', fn ($query) => $query->where('status', '!=', PurchaseRequestStatus::RASCUNHO->value));

        $requestingUsers = $requestingUsersQuery->get();
        return $requestingUsers;
    }

    /**
     * @return Builder query para consulta de usuários que possuem solicitações diferentes de status rascunho
     */
    public function productivityRequestingUsers(): Builder
    {
        $requestingUsersQuery = User::with('person', 'purchaseRequest.costCenterApportionment.costCenter')
            ->whereHas('purchaseRequest', fn ($query) => $query->where('status', '!=', PurchaseRequestStatus::RASCUNHO->value));
        return $requestingUsersQuery;
    }

    /**
     * @param array $requestType Recebe um array dos tipos de solicitação. Exemplo: ['product','service']
     */
    public function whereInRequestTypeQuery(Builder $query, array $requestType): Builder|InvalidArgumentException
    {
        $validRequestTypeArray  = collect($requestType)->filter(fn ($item) => PurchaseRequestType::tryFrom($item));

        if ($validRequestTypeArray->isEmpty()) {
            throw new InvalidArgumentException('Array de tipos de solicitações inválido.');
        }

        return $query->whereIn('type', $validRequestTypeArray);
    }

    /**
     * @param array $status Recebe uma array dos status de solicitação. Exemplo: ['pendente','em_tratativa','em_cotacao']
     */
    public function whereInStatusQuery(Builder $query, array $status): Builder|InvalidArgumentException
    {
        $validStatusArray = collect($status)->filter(fn ($item) => PurchaseRequestStatus::tryFrom($item));

        if ($validStatusArray->isEmpty()) {
            throw new InvalidArgumentException('Array de status inválido.');
        }

        return $query->whereIn('status', $validStatusArray);
    }

    /**
     * @param array $requestingUsersIds Recebe um array com ids de usuários.
     */
    public function whereInRequistingUserQuery(Builder $query, array $requestingUsersIds, $hasOwnRequests = true): Builder
    {
        $validIds = collect($requestingUsersIds)->filter(fn ($id) => is_numeric($id))->map(fn ($id) => (int) $id);

        if (empty($requestingUsersIds)) {
            $validIds = self::getRequistingUsers()->pluck('id');
        }

        $isAdmin = Gate::allows('admin');
        $isDirector = Gate::allows('diretor');
        $hasOwnRequestsFiltered = filter_var($hasOwnRequests, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $removeCurrentUserId = !$hasOwnRequestsFiltered && ($isAdmin || $isDirector);
        if ($removeCurrentUserId) {
            $currentUserId = auth()->user()->id;
            $validIds = $validIds->filter(fn ($id) => $id !== $currentUserId);
        }

        return $query->whereIn('user_id', $validIds);
    }

    /**
     * @param Builder $query Recebe query builder
     * @param array $requestingUsersIds Recebe array ids de usuários
     */
    public function requesterProductivityQuery(Builder $query, array $requestingUsersIds): Builder
    {
        $validIds = collect($requestingUsersIds)->filter(fn ($id) => is_numeric($id))->map(fn ($id) => (int) $id);

        if ($validIds->isEmpty()) {
            $validIds = User::whereHas('purchaseRequest', fn ($query) => $query->where('status', '!=', PurchaseRequestStatus::RASCUNHO->value))
                ->get()->pluck('id');
        }

        return $query->whereIn('user_id', $validIds);
    }

    /**
     * @param Builder $query
     * @param array $costCenterIds Recebe uma array com ids de cost centers.
     * @return Builder
     */
    public function whereInCostCenterQuery(Builder $query, array $costCenterIds): Builder
    {
        $validIds = collect($costCenterIds)->filter(fn ($id) => is_numeric($id))->map(fn ($id) => (int) $id);

        if ($validIds->isEmpty()) {
            throw new InvalidArgumentException('Array de ids de centros de custos inválido.');
        }

        $query->whereHas(
            'costCenterApportionment',
            fn ($query) => $query->whereHas(
                'costCenter',
                fn ($query) => $query->whereIn('id', $validIds)
            )
        );

        return $query;
    }

    /**
     * @param string $dateSince Recebe uma string com a data inicial do período. Exemplo: "2023-09-20"
     * @param string $dateUntil Recebe uma string com a data final do período. Exemplo: "2023-09-28"
     * @param Builder $query Receber query builder de PurchaseRequest
     * @param PurchaseRequestStatus $status
     * @return Builder Retorna query builder de PurchaseRequest para status escolhido atualizado dentro do período escolhido
     */
    public function whereInLogDate(Builder $query, string $dateSince, string $dateUntil, PurchaseRequestStatus $status = PurchaseRequestStatus::PENDENTE): Builder
    {
        $query->whereHas('logs', function ($query) use ($dateSince, $dateUntil, $status) {
            $query->where(DB::raw('JSON_EXTRACT(changes, "$.status")'), '=', $status)
                ->orderBy('created_at', 'asc')
                ->whereDate('created_at', '>=', $dateSince)
                ->whereDate('created_at', '<=', $dateUntil)
                ->limit(1);
        });

        return $query;
    }

    /**
     * @param string $orderColumnIndex Recebe um index que determina o campo de ordenação com base no dicionário de mapeamento."
     * @param string $orderDirection Recebe o tipo de ordenação, sendo 'asc' ou 'desc'.
     */
    public function orderByMapped(Builder $query, int $orderColumnIndex): string|Closure
    {
        $latestLogSubquery = fn ($query) => $query->select('logs.created_at')
            ->from('logs')
            ->where('logs.table', 'purchase_requests')
            ->where('logs.foreign_id', '=', DB::raw('purchase_requests.id'))
            ->where(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(logs.changes, "$.status"))'), '=', 'pendente')
            ->orderBy('logs.created_at', 'asc')
            ->limit(1);

        $getPersonName = fn ($query) => $query->select('people.name')
            ->from('people')
            ->join('users', 'users.person_id', '=', 'people.id')
            ->where('users.id', DB::raw('purchase_requests.user_id'));

        $getPersonRequester = fn ($query) => $query->select('people.name')
            ->from('people')
            ->where('people.id', DB::raw('purchase_requests.requester_person_id'));

        $getPersonSupplies = fn ($query) => $query->select('people.name')
            ->from('people')
            ->where('people.id', DB::raw('purchase_requests.supplies_user_id'));

        $orderColumnMappings = match ($orderColumnIndex) {
            0 => 'purchase_requests.id',
            1 => 'purchase_requests.type',
            2 => $latestLogSubquery,
            3 => $getPersonSupplies,
            4 => 'purchase_requests.responsibility_marked_at',
            6 => 'purchase_requests.is_supplies_contract',
            7 => $getPersonName,
            8 => $getPersonRequester,
            9 => 'purchase_requests.status',
            16 => 'total_amount'
        };

        return $orderColumnMappings;
    }

    /**
     * @param string $orderColumnIndex Recebe um index que determina o campo de ordenação com base no dicionário de mapeamento."
     * @param string $orderDirection Recebe o tipo de ordenação, sendo 'asc' ou 'desc'.
     */
    public function productivityOrder(Builder $query, int $orderColumnIndex): string|Closure
    {
        $latestLogSubquery = fn ($query) => $query->select('logs.created_at')
            ->from('logs')
            ->where('logs.table', 'purchase_requests')
            ->where('logs.foreign_id', '=', DB::raw('purchase_requests.id'))
            ->where(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(logs.changes, "$.status"))'), '=', 'pendente')
            ->orderBy('logs.created_at', 'asc')
            ->limit(1);

        $getPersonName = fn ($query) => $query->select('people.name')
            ->from('people')
            ->join('users', 'users.person_id', '=', 'people.id')
            ->where('users.id', DB::raw('purchase_requests.user_id'));

        $getPersonRequester = fn ($query) => $query->select('people.name')
            ->from('people')
            ->where('people.id', DB::raw('purchase_requests.requester_person_id'));

        $getPersonSupplies = fn ($query) => $query->select('people.name')
            ->from('people')
            ->where('people.id', DB::raw('purchase_requests.supplies_user_id'));

        $orderColumnMappings = match ($orderColumnIndex) {
            0 => 'purchase_requests.id',
            1 => 'purchase_requests.type',
            2 => $latestLogSubquery,
            3 => $getPersonName,
            4 => $getPersonRequester,
            5 => 'purchase_requests.status',
            6 => $getPersonSupplies,
            8 => 'purchase_requests.is_supplies_contract',
            9 => 'purchase_requests.desired_date',
        };

        return $orderColumnMappings;
    }

    /**
     * @param string $searchValue Recebe uma string para busca."
     */
    public function searchValueQuery(Builder $query, string $searchValue): Builder
    {
        return $query->where(function ($query) use ($searchValue) {
            $query->where('purchase_requests.id', 'like', "%{$searchValue}%")
                ->orWhereHas('user', function ($query) use ($searchValue) {
                    $query->whereHas('person', function ($query) use ($searchValue) {
                        $query->where('name', 'like', "%{$searchValue}%");
                    });
                })
                ->orWhereHas('requester', function ($query) use ($searchValue) {
                    $query->where('name', 'like', "%{$searchValue}%");
                })
                ->orWhereHas('suppliesUser', function ($query) use ($searchValue) {
                    $query->whereHas('person', function ($query) use ($searchValue) {
                        $query->where('name', 'like', "%{$searchValue}%");
                    });
                })
                ->orWhereHas('costCenterApportionment', function ($query) use ($searchValue) {
                    $query->whereHas('costCenter', function ($query) use ($searchValue) {
                        $query->where('name', 'like', "%{$searchValue}%");
                    });
                })
                ->orWhereHas('product', function ($query) use ($searchValue) {
                    $query->where('amount', 'like', "%{$searchValue}%");
                })
                ->orWhereHas('purchaseRequestProduct', function ($query) use ($searchValue) {
                    $query->whereHas('supplier', function ($query) use ($searchValue) {
                        $query->where('corporate_name', 'like', "%{$searchValue}%");
                    });
                })
                ->orWhereHas('service', function ($query) use ($searchValue) {
                    $query->where('name', 'like', "%{$searchValue}%")
                        ->orWhere('price', 'like', "%{$searchValue}%")
                        ->orWhereHas('supplier', function ($query) use ($searchValue) {
                            $query->where('corporate_name', 'like', "%{$searchValue}%");
                        });
                })
                ->orWhereHas('contract', function ($query) use ($searchValue) {
                    $query->where('name', 'like', "%{$searchValue}%")
                        ->orWhere('amount', 'like', "%{$searchValue}%")
                        ->orWhereHas('supplier', function ($query) use ($searchValue) {
                            $query->where('corporate_name', 'like', "%{$searchValue}%");
                        });
                });
        });
    }
}
