<?php

namespace App\View\Components;

use App\Enums\CompanyGroup;
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
        private CompanyGroup|null $suppliesGroup
    ) {
    }

    public function render(): View|Closure|string
    {
        $purchaseRequests = $this->purchaseRequestService->purchaseRequests();

        $products = $purchaseRequests->filter(function ($item) {
            if ($item->type->label() === "Produto") {
                return $item;
            }
        });

        if ($this->suppliesGroup) {
            $products = $this->supplierService->filterRequestByCompanyGroup($products, $this->suppliesGroup);
        }

        return view('components.supplies.product-content.supplies-product-list', ['products' => $products]);
    }
}
