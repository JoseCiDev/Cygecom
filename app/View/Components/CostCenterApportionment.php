<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\Component;
use App\Models\{PurchaseRequest, CostCenter};

class CostCenterApportionment extends Component
{
    public function __construct(
        private ?PurchaseRequest $purchaseRequest,
    ) {
    }

    public function render(): View|Closure|string
    {
        $currentUser = auth()->user();
        $isAdmin = Gate::allows('admin');

        $userCostCentersAllowed = $currentUser->userCostCenterPermission;
        $filteredCostCenters = CostCenter::whereIn('id', $userCostCentersAllowed->pluck('cost_center_id'))->get();
        $allCostCenters = CostCenter::All();

        $costCenters =  $isAdmin ? $allCostCenters : $filteredCostCenters;

        $params = [
            'costCenters' => $costCenters,
            'purchaseRequest' => $this->purchaseRequest,
        ];

        return view('components.purchase-request.cost-center-apportionment', $params);
    }
}
