<?php

namespace App\View\Components;

use App\Models\{Company, CostCenter, Supplier, Person};
use App\Enums\{PaymentMethod, PaymentTerm};
use App\Providers\PurchaseRequestService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class PurchaseRequestFormService extends Component
{
    public function __construct(
        private PurchaseRequestService $purchaseRequestService,
        private ?int $id = null,
        private ?bool $isCopy = false,
        private Collection | array | null $files = null
    ) {
        $this->purchaseRequestService = $purchaseRequestService;
        $this->isCopy = $isCopy;
        $this->id = $id;
        $this->files = $files;
    }

    public function render(): View|Closure|string
    {
        $companies       = Company::all();
        $suppliers = Supplier::all();
        $people = Person::whereNull('deleted_at')->get();
        $userCostCenters = auth()->user()->userCostCenterPermission;
        $paymentMethods = PaymentMethod::cases();
        $paymentTerms = PaymentTerm::cases();
        $costCenters     = CostCenter::whereIn('id', $userCostCenters->pluck('cost_center_id'))->get();
        $statusValues    = [
            ['id' => 1, 'description' => 'PAGO',],
            ['id' => 2, 'description' => 'EM ATRASO',],
            ['id' => 3, 'description' => 'PENDENTE',],
        ];

        $params = [
            'companies' => $companies,
            'costCenters' => $costCenters,
            "paymentMethods" => $paymentMethods,
            "paymentTerms" => $paymentTerms,
            'suppliers' => $suppliers,
            'people' => $people,
            'statusValues' => $statusValues
        ];

        if ($this->id) {
            $params['id'] = $this->id;
            $params['purchaseRequest'] = $this->purchaseRequestService->purchaseRequestById($this->id);
            $params['isCopy'] = $this->isCopy;
            $params['files'] = $this->files;
        }

        return view('components.purchase-request.purchase-request-form-service', $params);
    }
}
