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
        private CompanyGroup|null $filter
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

        if ($this->filter) {
            $products = $this->supplierService->filterRequestByCompanyGroup($products, $this->filter);
        }

        return view('components.supplies.product-content.supplies-product-list', ['products' => $products]);
    }
}
