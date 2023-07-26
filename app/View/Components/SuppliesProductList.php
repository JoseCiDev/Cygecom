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

class SuppliesProductList extends Component
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

        $products = $purchaseRequests->filter(function ($item) {
            if ($item->type->value === PurchaseRequestType::PRODUCT->value) {
                return $item;
            }
        });

        if ($this->suppliesGroup) {
            $products = $this->supplierService->filterRequestByCompanyGroup($products, $this->suppliesGroup);
        }

        return view('components.supplies.product-content.supplies-product-list', ['products' => $products, 'suppliesGroup' => $this->suppliesGroup, 'status' => $this->status]);
    }
}
