<?php

namespace App\View\Components;

use Closure;
use App\Enums\PaymentMethod;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Providers\PurchaseRequestService;
use Illuminate\Database\Eloquent\Collection;
use App\Models\{Company, CostCenter, ProductCategory, Supplier};

class PurchaseRequestFormProduct extends Component
{
    private $purchaseRequestService;

    private $id;

    private $isCopy;

    private $files;

    public function __construct(PurchaseRequestService $purchaseRequestService, int $id = null, $isCopy = false, Collection | array | null $files = null)
    {
        $this->purchaseRequestService = $purchaseRequestService;
        $this->isCopy                 = $isCopy;
        $this->id                     = $id;
        $this->files               = $files;
    }

    public function render(): View|Closure|string
    {
        $companies         = Company::all();
        $suppliers         = Supplier::all();
        $productCategories = ProductCategory::all();
        $paymentMethods = PaymentMethod::cases();
        $userCostCenters   = auth()->user()->userCostCenterPermission;
        $costCenters       = CostCenter::whereIn('id', $userCostCenters->pluck('cost_center_id'))->get();
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
            "companies" => $companies,
            "costCenters" => $costCenters,
            'suppliers' => $suppliers,
            "productCategories" => $productCategories,
            "paymentMethods" => $paymentMethods,
            'statusValues' => $statusValues,
        ];

        if ($this->id) {
            $params['id']              = $this->id;
            $params['purchaseRequest'] = $this->purchaseRequestService->purchaseRequestById($this->id);
            $params['isCopy']          = $this->isCopy;
            $params['files']        = $this->files;
        }

        return view('components.purchase-request.purchase-request-form-product', $params);
    }
}
