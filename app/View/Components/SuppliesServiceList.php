<?php

namespace App\View\Components;

use App\Enums\CompanyGroup;
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
        private CompanyGroup|null $filter
    ) {
    }

    public function render(): View|Closure|string
    {
        $purchaseRequests = $this->purchaseRequestService->purchaseRequests();

        $services = $purchaseRequests->filter(function ($item) {
            if ($item->type->value === PurchaseRequestType::SERVICE->value) {
                return $item;
            }
        });

        if ($this->filter) {
            $services = $this->supplierService->filterRequestByCompanyGroup($services, $this->filter);
        }

        return view('components.supplies.service-content.supplies-service-list', ['services' => $services]);
    }
}
