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

class SuppliesContractList extends Component
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

        $contracts = $purchaseRequests->filter(function ($item) {
            if ($item->type->value === PurchaseRequestType::CONTRACT->value) {
                return $item;
            }
        });

        if ($this->suppliesGroup) {
            $contracts = $this->supplierService->filterRequestByCompanyGroup($contracts, $this->suppliesGroup);
        }

        return view('components.supplies.contract.list', ['contracts' => $contracts, 'suppliesGroup' => $this->suppliesGroup, 'status' => $this->status]);
    }
}
