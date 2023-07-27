<?php

namespace App\View\Components;

use App\Models\{Company, CostCenter, Supplier};
use App\Providers\PurchaseRequestService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class PurchaseRequestFormService extends Component
{
    private $purchaseRequestService;

    private $id;

    private $isCopy;

    private $files;

    public function __construct(PurchaseRequestService $purchaseRequestService, int $id = null, ?bool $isCopy = false, Collection | array | null $files = null)
    {
        $this->purchaseRequestService = $purchaseRequestService;
        $this->isCopy              = $isCopy;
        $this->id                  = $id;
        $this->files               = $files;
    }

    public function render(): View|Closure|string
    {
        $companies       = Company::all();
        $suppliers = Supplier::all();
        $userCostCenters = auth()->user()->userCostCenterPermission;
        $costCenters     = CostCenter::whereIn('id', $userCostCenters->pluck('cost_center_id'))->get();
        $statusValues    = [
            [
                'id'          => 1,
                'description' => 'PAGO',
            ],
            [
                'id'          => 2,
                'description' => 'EM ATRASO',
            ],
            [
                'id'          => 3,
                'description' => 'PENDENTE',
            ],
        ];

        $params = [
            'companies' => $companies,
            'costCenters' => $costCenters,
            'suppliers' => $suppliers,
            'statusValues' => $statusValues
        ];

        if ($this->id) {
            $params['id']           = $this->id;
            $params['purchaseRequest'] = $this->purchaseRequestService->purchaseRequestById($this->id);
            $params['isCopy']       = $this->isCopy;
            $params['files']        = $this->files;
        }

        return view('components.purchase-request.purchase-request-form-service', $params);
    }
}
