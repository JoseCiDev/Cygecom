<?php

namespace App\View\Components;

use Closure;
use App\Models\Person;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Providers\PurchaseRequestService;
use Illuminate\Database\Eloquent\Collection;
use App\Models\{Company, CostCenter, Supplier};
use App\Enums\{PaymentMethod, PaymentTerm, ContractRecurrence};

class PurchaseRequestFormContract extends Component
{
    private $purchaseRequestService;

    private $id;

    private $isCopy;

    private $files;

    public function __construct(PurchaseRequestService $purchaseRequestService, int $id  = null, $isCopy = false, Collection | array | null $files = null)
    {
        $this->purchaseRequestService = $purchaseRequestService;
        $this->isCopy                 = $isCopy;
        $this->id                     = $id;
        $this->files               = $files;
    }

    public function render(): View|Closure|string
    {
        $companies       = Company::all();
        $suppliers       = Supplier::all();
        $people = Person::whereNull('deleted_at')->get();
        $userCostCenters = auth()->user()->userCostCenterPermission;
        $paymentMethods = PaymentMethod::cases();
        $paymentTerms = PaymentTerm::cases();
        $recurrenceOptions = ContractRecurrence::cases();
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
            'companies'    => $companies,
            'costCenters'  => $costCenters,
            'suppliers'    => $suppliers,
            'people' => $people,
            "paymentMethods" => $paymentMethods,
            "paymentTerms" => $paymentTerms,
            "recurrenceOptions" => $recurrenceOptions,
            'statusValues' => $statusValues,
        ];

        if ($this->id) {
            $params['id']              = $this->id;
            $params['purchaseRequest'] = $this->purchaseRequestService->purchaseRequestById($this->id);
            $params['isCopy']          = $this->isCopy;
            $params['files']        = $this->files;
        }

        return view('components.purchase-request.purchase-request-form-contract', $params);
    }
}
