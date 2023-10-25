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
                    PurchaseRequestStatus::RASCUNHO->value,
                    PurchaseRequestStatus::FINALIZADA->value,
                    PurchaseRequestStatus::CANCELADA->value
                ])->whereNull('deleted_at')->get();
        }

        $contracts = $purchaseRequests->filter(function ($item) {
            $validType = $item->type->value === PurchaseRequestType::CONTRACT->value;
            $hasUser = $item->user !== null;

            if ($validType && $hasUser) {
                return $item;
            }
        });

        if ($this->suppliesGroup) {
            $contracts = $this->supplierService->filterRequestByCompanyGroup($contracts, $this->suppliesGroup);
        }

        $params['contracts'] = $contracts;

        return view('components.supplies.contract.list', $params);
    }
}
