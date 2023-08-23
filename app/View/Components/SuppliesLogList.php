<?php

namespace App\View\Components;

use Closure;
use App\Models\PurchaseRequestsLog;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuppliesLogList extends Component
{

    public function __construct(private PurchaseRequestsLog $purchaseRequestsLog, private int $purchaseRequestId)
    {
    }

    public function render(): View|Closure|string
    {
        $logs = PurchaseRequestsLog::where('purchase_request_id', $this->purchaseRequestId)->get();
        return view('components.supplies.supplies-log-list', ['logs' => $logs]);
    }
}
