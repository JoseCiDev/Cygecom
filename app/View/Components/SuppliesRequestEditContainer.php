<?php

namespace App\View\Components;

use App\Enums\{PurchaseRequestStatus, PurchaseRequestType};
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuppliesRequestEditContainer extends Component
{
    public string $route;

    /**
     * @var PurchaseRequestStatus[] $allRequestStatus
     */
    public array $allRequestStatus;
    public bool $requestIsFromLogged;
    public string $inputName;

    public function __construct(
        public PurchaseRequestType $requestType,
        public PurchaseRequestStatus $requestStatus,
        public int $requestId,
        public ?string $amount,
    ) {
        $this->route = "supplies.request." . $this->requestType->value . ".update";
        $this->allRequestStatus = PurchaseRequestStatus::cases();
        $this->requestIsFromLogged = $this->requestId === auth()->user()->id;
        $this->inputName = $this->requestType->value === PurchaseRequestType::SERVICE->value
            ? (PurchaseRequestType::SERVICE->value . "[price]")
            : ($this->requestType->value . "[amount]");
    }

    public function render(): View|Closure|string
    {
        return view('components.supplies.request-edit-container');
    }
}
