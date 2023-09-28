<?php

namespace App\Services;

use App\Enums\{PurchaseRequestType, PurchaseRequestStatus};
use App\Models\{User, Service, Product, Person, Contract};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ReportService
{
    public function getRequistingUsers(): Collection
    {
        $currentProfile = auth()->user()->profile->name;
        $currentUserId = auth()->user()->id;

        $requestingUsersQuery = User::with('person', 'purchaseRequest.costCenterApportionment.costCenter')
            ->whereHas('purchaseRequest', fn ($query) => $query->where('status', '!=', PurchaseRequestStatus::RASCUNHO->value));

        if ($currentProfile !== 'admin') {
            $requestingUsersQuery->where('id', $currentUserId);
        } elseif ($currentProfile === 'diretor') {
            $requestingUsersQuery->where('approver_user_id', $currentUserId);
        }

        $requestingUsers = $requestingUsersQuery->get();

        return $requestingUsers;
    }

    /**
     * @param string $requestType Recebe uma string dos tipos de solicitação separados por vírgula. Exemplo: "product,service"
     */
    public function whereInRequestTypeQuery(Builder $query, string $requestType): Builder|InvalidArgumentException
    {
        $requestTypeArray = explode(',', $requestType);
        $validRequestTypeArray  = collect($requestTypeArray)->filter(fn ($item) => PurchaseRequestType::tryFrom($item));

        if ($validRequestTypeArray->isEmpty()) {
            throw new InvalidArgumentException('Array de tipos de solicitações inválido.');
        }

        return $query->whereIn('type', $validRequestTypeArray);
    }

    /**
     * @param string $status Recebe uma string dos status de solicitação separados por vírgula. Exemplo: "pendente,em_tratativa,em_cotacao"
     */
    public function whereInStatusQuery(Builder $query, string $status): Builder|InvalidArgumentException
    {
        $statusArray = explode(',', $status);
        $validStatusArray = collect($statusArray)->filter(fn ($item) => PurchaseRequestStatus::tryFrom($item));

        if ($validStatusArray->isEmpty()) {
            throw new InvalidArgumentException('Array de status inválido.');
        }

        return $query->whereIn('status', $validStatusArray);
    }

    /**
     * @param string $requestingUsersIds Recebe uma string com ids de usuários separados por vírgula. Exemplo: "1,2,3"
     */
    public function whereInRequistingUserQuery(Builder $query, ?string $requestingUsersIds = ''): Builder
    {
        $requestingUsersIdsArray = explode(',', $requestingUsersIds);

        $validIds = collect($requestingUsersIdsArray)->filter(fn ($id) => is_numeric($id))->map(fn ($id) => (int) $id);

        if (empty($requestingUsersIds)) {
            $validIds = self::getRequistingUsers()->pluck('id');
        }

        if ($validIds->isEmpty()) {
            throw new InvalidArgumentException('Array de ids de usuários solicitantes inválido.');
        }

        return $query->whereIn('user_id', $validIds);
    }

    /**
     * @param string $costCenterIds Recebe uma string com ids de cost centers separados por vírgula. Exemplo: "1,2,3"
     */
    public function whereInCostCenterQuery(Builder $query, ?string $costCenterIds = ''): Builder
    {
        $costCenterIdsArray = explode(',', $costCenterIds);

        $validIds = collect($costCenterIdsArray)->filter(fn ($id) => is_numeric($id))->map(fn ($id) => (int) $id);

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
     * @param Builder $query Retorna query builder de PurchaseRequest para status pendente atualizado dentro do período escolhido
     */
    public function whereInLogDate(Builder $query, string $dateSince, string $dateUntil): Builder
    {
        $query->whereHas('logs', function ($query) use ($dateSince, $dateUntil) {
            $query->where(DB::raw('JSON_EXTRACT(changes, "$.status")'), '=', 'pendente')
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
    public function orderByMapped(Builder $query, int $orderColumnIndex, ?string $orderDirection = 'asc'): Builder
    {
        $latestLogSubquery = fn ($query) => $query->select('logs.created_at')
            ->from('logs')
            ->where('logs.table', 'purchase_requests')
            ->where('logs.foreign_id', '=', DB::raw('purchase_requests.id'))
            ->where(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(logs.changes, "$.status"))'), '=', 'pendente')
            ->orderBy('logs.created_at', 'asc')
            ->limit(1);

        $orderColumnMappings = [
            0 => $query->orderBy('id', $orderDirection),
            1 => $query->orderBy('type', $orderDirection),
            2 => $query->orderBy($latestLogSubquery, $orderDirection),
            3 => $query->orderBy(Person::select('name')->whereColumn('people.id', '=', 'purchase_requests.user_id'), $orderDirection),
            4 => $query->orderBy('status', $orderDirection),
            5 => $query->orderBy(Person::select('name')->whereColumn('people.id', '=', 'purchase_requests.supplies_user_id'), $orderDirection),
            10 => $query->orderBy(
                Product::select('amount')->whereColumn('products.purchase_request_id', '=', 'purchase_requests.id')
                    ->union(Service::select('price')->whereColumn('services.purchase_request_id', '=', 'purchase_requests.id'))
                    ->union(Contract::select('amount')->whereColumn('contracts.purchase_request_id', '=', 'purchase_requests.id')),
                $orderDirection
            )
        ];

        return $orderColumnMappings[$orderColumnIndex];
    }

    /**
     * @param string $searchValue Recebe uma string para busca."
     */
    public function searchValueQuery(Builder $query, string $searchValue): Builder
    {
        return $query
            ->where('id', 'like', "%{$searchValue}%")
            ->orWhereHas('user', function ($query) use ($searchValue) {
                $query->whereHas('person', function ($query) use ($searchValue) {
                    $query->where('name', 'like', "%{$searchValue}%");
                });
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
                $query->where('price', 'like', "%{$searchValue}%")
                    ->orWhereHas('supplier', function ($query) use ($searchValue) {
                        $query->where('corporate_name', 'like', "%{$searchValue}%");
                    });
            })
            ->orWhereHas('contract', function ($query) use ($searchValue) {
                $query->where('amount', 'like', "%{$searchValue}%")
                    ->orWhereHas('supplier', function ($query) use ($searchValue) {
                        $query->where('corporate_name', 'like', "%{$searchValue}%");
                    });
            });
    }
}
