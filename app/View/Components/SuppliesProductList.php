<?php

namespace App\View\Components;

use App\Providers\PurchaseRequestService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuppliesProductList extends Component
{
    public function __construct(private PurchaseRequestService $purchaseRequestService)
    {
    }

    public function render(): View|Closure|string
    {
        $purchaseRequests = $this->purchaseRequestService->purchaseRequests();

        $productList = $purchaseRequests->filter(function ($item) {
            if ($item->type->label() === "Produto") {
                return $item;
            }
        });

        return view('components.supplies.supplies-product-list', ['productList' => $productList]);
    }
}
