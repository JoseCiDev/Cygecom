<?php

namespace App\View\Components;

use App\Models\{Company, CostCenter, ProductCategory, Supplier};
use App\Providers\PurchaseRequestService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PurchaseRequestFormProduct extends Component
{
    private $purchaseRequestService;

    private $id;

    private $isCopy;

    public function __construct(PurchaseRequestService $purchaseRequestService, int $id = null, $isCopy = false)
    {
        $this->purchaseRequestService = $purchaseRequestService;
        $this->isCopy                 = $isCopy;
        $this->id                     = $id;
    }

    public function render(): View|Closure|string
    {
        $companies         = Company::all();
        $suppliers         = Supplier::all();
        $productCategories = ProductCategory::all();
        $userCostCenters   = auth()->user()->userCostCenterPermission;
        $costCenters       = CostCenter::whereIn('id', $userCostCenters->pluck('cost_center_id'))->get();

        $params = ["companies" => $companies, "costCenters" => $costCenters, 'suppliers' => $suppliers, "productCategories" => $productCategories];

        if ($this->id) {
            $params['id']              = $this->id;
            $params['purchaseRequest'] = $this->purchaseRequestService->purchaseRequestById($this->id);
            $params['isCopy']          = $this->isCopy;
        }

        return view('components.purchase-request.purchase-request-form-product', $params);
    }
}
