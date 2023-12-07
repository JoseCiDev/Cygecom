<?php

namespace App\View\Components;

use App\Enums\{PurchaseRequestStatus, PurchaseRequestType, CompanyGroup};
use App\Providers\{PurchaseRequestService, SupplierService};
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuppliesServiceList extends Component
{
    public function __construct(
        private PurchaseRequestService $purchaseRequestService,
        private SupplierService $supplierService,
        private CompanyGroup|null $suppliesGroup,
        private array|null $status
    ) {
    }

    public function render(): View|Closure|string
    {
        $params = [
            'suppliesGroup' => $this->suppliesGroup,
            'status' => $this->status,
        ];

        if ($this->status) {
            $purchaseRequests = $this->purchaseRequestService->requestsByStatus($this->status)->whereNotIn('status', [PurchaseRequestStatus::RASCUNHO->value])->get();
        } else {
            $purchaseRequests = $this->purchaseRequestService->allPurchaseRequests()
                ->where('status', PurchaseRequestStatus::PENDENTE->value)
                ->whereNull('deleted_at')->get();
        }

        $services = $purchaseRequests->filter(function ($item) {
            $validType = $item->type->value === PurchaseRequestType::SERVICE->value;

            if ($validType) {
                return $item;
            }
        });

        if ($this->suppliesGroup) {
            $services = $this->supplierService->filterRequestByCompanyGroup($services, $this->suppliesGroup);
        }

        $params['services'] = $services;

        return view('components.supplies.service.list', $params);
    }
}
