<?php

namespace App\Services;

use App\Enums\{PurchaseRequestType, PurchaseRequestStatus};
use App\Models\{User, Service, Product, Person, Contract};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
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
     * @param string $orderColumnIndex Recebe um index que determina o campo de ordenação com base no dicionário de mapeamento."
     */
    public function mapOrdemColumn(int $orderColumnIndex): string|bool|Builder
    {
        $orderColumnMappings = [
            0 => 'id',
            1 => 'type',
            2 => 'responsibility_marked_at',
            3 => Person::select('name')->whereColumn('people.id', '=', 'purchase_requests.user_id'),
            4 => 'status',
            5 => Person::select('name')->whereColumn('people.id', '=', 'purchase_requests.supplies_user_id'),
            10 => Product::select('amount')->whereColumn('products.purchase_request_id', '=', 'purchase_requests.id')
                ->union(Service::select('price')->whereColumn('services.purchase_request_id', '=', 'purchase_requests.id'))
                ->union(Contract::select('amount')->whereColumn('contracts.purchase_request_id', '=', 'purchase_requests.id'))
        ];

        return $orderColumnMappings[$orderColumnIndex] ?? false;
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
