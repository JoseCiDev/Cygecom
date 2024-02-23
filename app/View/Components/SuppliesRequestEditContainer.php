<?php

namespace App\View\Components;

use Closure;
use App\Models\User;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Enums\{MainProfile, ERP, PurchaseRequestStatus, PurchaseRequestType};
use Illuminate\Database\Eloquent\Collection;

class SuppliesRequestEditContainer extends Component
{
    public string $route;

    /**
     * @var PurchaseRequestStatus[] $allRequestStatus
     */
    public array $allRequestStatus;
    public array $allowedResponsables;
    public bool $requestIsFromLogged;
    public string $inputName;
    public bool $hasUpdateOnAmount;

    public function __construct(
        public PurchaseRequestType $requestType,
        public PurchaseRequestStatus $requestStatus,
        public int $requestId,
        public ?int $requestUserId,
        public ?string $amount,
        public ?string $purchaseOrder,
        public ?ERP $erp,
        public ?Collection $requestTypeLogs,
    ) {
        $this->route = "supplies." . $this->requestType->value . ".update";
        $this->allRequestStatus = PurchaseRequestStatus::cases();
        $this->requestIsFromLogged = $this->requestUserId === auth()->user()->id;

        $this->inputName = $this->requestType->value === PurchaseRequestType::SERVICE->value
            ? (PurchaseRequestType::SERVICE->value . "[price]")
            : ($this->requestType->value . "[amount]");

        $allowedProfiles = [MainProfile::SUPRIMENTOS_HKM->value, MainProfile::SUPRIMENTOS_INP->value];
        $users = User::with('person', 'profile.abilities', 'abilities')
            ->whereHas('profile.abilities', fn ($subQuery) => $subQuery->whereIn('name', $allowedProfiles))
            ->whereDoesntHave('profile.abilities', fn ($subQuery) => $subQuery->where('name', 'admin'))
            ->orWhereHas('abilities', fn ($subQuery) => $subQuery->whereIn('name', $allowedProfiles))
            ->whereDoesntHave('abilities', fn ($subQuery) => $subQuery->where('name', 'admin'))
            ->get()
            ->toArray();

        $this->allowedResponsables = $users;

        $amountType = [
            PurchaseRequestType::SERVICE->value => 'price',
            PurchaseRequestType::CONTRACT->value => 'amount',
            PurchaseRequestType::PRODUCT->value => 'amount'
        ][$this->requestType->value];

        $updateOnAmount = $this->requestTypeLogs?->filter(function ($log) use ($amountType) {
            $updatedBySupplies = $log->user_id !== $this->requestUserId;
            $hasUpdateOnAmount = isset($log->changes[$amountType]);

            return $updatedBySupplies && $hasUpdateOnAmount;
        }) ?? collect();
        $this->hasUpdateOnAmount = $updateOnAmount->isNotEmpty();
    }

    public function render(): View|Closure|string
    {
        return view('components.supplies.request-edit-container');
    }
}
