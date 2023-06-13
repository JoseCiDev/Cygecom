<?php

namespace App\View\Components;

use App\Models\{Company, CostCenter};
use App\Providers\QuoteRequestService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class QuoteRequestForm extends Component
{
    private $quoteRequestService;

    private $id;

    private $isCopy;

    public function __construct(QuoteRequestService $quoteRequestService, int $id = null, $isCopy = false)
    {
        $this->quoteRequestService = $quoteRequestService;
        $this->isCopy              = $isCopy;
        $this->id                  = $id;
    }

    public function render(): View|Closure|string
    {
        $companies       = Company::all();
        $userCostCenters = auth()->user()->userCostCenterPermission;
        $costCenters     = CostCenter::whereIn('id', $userCostCenters->pluck('cost_center_id'))->get();

        $params = ["companies" => $companies, "costCenters" => $costCenters];

        if ($this->id) {
            $params['id']           = $this->id;
            $params['quoteRequest'] = $this->quoteRequestService->quoteRequestById($this->id);
            $params['isCopy']       = $this->isCopy;
        }

        return view('components.quote-request.quote-request-form', $params);
    }
}
