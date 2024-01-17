<?php

namespace App\View\Components;

use Closure;
use App\Models\User;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Enums\{MainProfile, PurchaseRequestStatus, PurchaseRequestType};

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

    public function __construct(
        public PurchaseRequestType $requestType,
        public PurchaseRequestStatus $requestStatus,
        public int $requestId,
        public ?int $requestUserId,
        public ?string $amount,
        public ?string $purchaseOrder,
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
    }

    public function render(): View|Closure|string
    {
        return view('components.supplies.request-edit-container');
    }
}
