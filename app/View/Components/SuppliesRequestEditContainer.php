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
    public array $allowedResponsables;
    public bool $requestIsFromLogged;
    public string $inputName;

    public function __construct(
        public PurchaseRequestType $requestType,
        public PurchaseRequestStatus $requestStatus,
        public int $requestId,
        public int $requestUserId,
        public ?string $amount,
    ) {
        $this->route = "supplies.request." . $this->requestType->value . ".update";
        $this->allRequestStatus = PurchaseRequestStatus::cases();
        $this->requestIsFromLogged = $this->requestUserId === auth()->user()->id;
        $this->inputName = $this->requestType->value === PurchaseRequestType::SERVICE->value
            ? (PurchaseRequestType::SERVICE->value . "[price]")
            : ($this->requestType->value . "[amount]");
        $this->allowedResponsables = [
            ["id" => auth()->user()->id, "name" => auth()->user()->person->name]
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.supplies.request-edit-container');
    }
}
