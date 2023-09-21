<?php

namespace App\Services;

use App\Enums\{PurchaseRequestType, PurchaseRequestStatus};
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class ReportService
{
    public function getRequistingUsers(): Collection
    {
        $currentProfile = auth()->user()->profile->name;
        $currentUserId = auth()->user()->id;

        $requestingUsersQuery = User::with('person')
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
    public function whereInRequestTypeQuery($query, string $requestType): Builder|InvalidArgumentException
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
    public function whereInStatusQuery($query, string $status): Builder|InvalidArgumentException
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
    public function whereInRequistingUserQuery($query, ?string $requestingUsersIds = ''): Builder
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
}
