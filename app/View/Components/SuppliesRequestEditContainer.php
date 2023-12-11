<?php

namespace App\View\Components;

use Closure;
use App\Models\User;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Enums\{PurchaseRequestStatus, PurchaseRequestType};

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

        $this->allowedResponsables = User::with('person')
            ->whereIn('user_profile_id', [1, 3, 4])
            ->get()
            ->toArray();
    }

    public function render(): View|Closure|string
    {
        return view('components.supplies.request-edit-container');
    }
}
