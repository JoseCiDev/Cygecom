<?php

namespace App\View\Components;

use App\Models\CostCenter;
use App\Models\PurchaseRequest;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CostCenterApportionment extends Component
{
    public function __construct(
        private ?PurchaseRequest $purchaseRequest,
    ) {
    }

    public function render(): View|Closure|string
    {
        $userCostCentersAllowed = auth()->user()->userCostCenterPermission;
        $costCenters = CostCenter::whereIn('id', $userCostCentersAllowed->pluck('cost_center_id'))->get();
        $params = [
            'costCenters' => $costCenters,
            'purchaseRequest' => $this->purchaseRequest,
        ];

        return view('components.purchase-request.cost-center-apportionment', $params);
    }
}
