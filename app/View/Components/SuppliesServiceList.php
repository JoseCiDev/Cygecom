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
            $purchaseRequests = $this->purchaseRequestService->purchaseRequestsByStatus($this->status)->whereNotIn('status', ['rascunho'])->get();
        } else {
            $purchaseRequests = $this->purchaseRequestService->allPurchaseRequests()->whereNotIn('status', ['rascunho'])->whereNull('deleted_at')->get();
        }

        $services = $purchaseRequests->filter(function ($item) {
            if ($item->type->value === PurchaseRequestType::SERVICE->value) {
                return $item;
            }
        });

        if ($this->suppliesGroup) {
            $services = $this->supplierService->filterRequestByCompanyGroup($services, $this->suppliesGroup);
        }

        return view('components.supplies.service.list', ['services' => $services, 'suppliesGroup' => $this->suppliesGroup, 'status' => $this->status]);
    }
}
