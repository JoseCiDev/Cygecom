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
                ->whereNotIn('status', [
                    PurchaseRequestStatus::RASCUNHO,
                    PurchaseRequestStatus::FINALIZADA,
                    PurchaseRequestStatus::CANCELADA
                ])->whereNull('deleted_at')->get();
        }

        $products = $purchaseRequests->filter(function ($item) {
            $validType = $item->type->value === PurchaseRequestType::PRODUCT->value;

            if ($validType) {
                return $item;
            }
        });

        if ($this->suppliesGroup) {
            $products = $this->supplierService->filterRequestByCompanyGroup($products, $this->suppliesGroup);
        }

        $params['products'] = $products;

        return view('components.supplies.product.list', $params);
    }
}
