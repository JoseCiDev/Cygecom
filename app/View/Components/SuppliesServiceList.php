<?php

namespace App\View\Components;

use App\Enums\CompanyGroup;
use App\Enums\PurchaseRequestStatus;
use App\Enums\PurchaseRequestType;
use App\Providers\PurchaseRequestService;
use App\Providers\SupplierService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuppliesServiceList extends Component
{
    public function __construct(
        private PurchaseRequestService $purchaseRequestService,
        private SupplierService $supplierService,
        private CompanyGroup|null $suppliesGroup,
        private PurchaseRequestStatus|null $status
    ) {
    }

    public function render(): View|Closure|string
    {
        if ($this->status) {
            $purchaseRequests = $this->purchaseRequestService->purchaseRequestsByStatus($this->status);
        } else {
            $purchaseRequests = $this->purchaseRequestService->purchaseRequests();
        }

        $services = $purchaseRequests->filter(function ($item) {
            if ($item->type->value === PurchaseRequestType::SERVICE->value) {
                return $item;
            }
        });

        if ($this->suppliesGroup) {
            $services = $this->supplierService->filterRequestByCompanyGroup($services, $this->suppliesGroup);
        }

        return view('components.supplies.service-content.supplies-service-list', ['services' => $services, 'suppliesGroup' => $this->suppliesGroup, 'status' => $this->status]);
    }
}
