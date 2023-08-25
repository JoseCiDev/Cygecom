<?php

namespace App\View\Components;

use App\Enums\LogAction;
use App\Models\Log;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuppliesLogList extends Component
{

    public function __construct(private int $purchaseRequestId)
    {
    }

    public function render(): View|Closure|string
    {
        $logs = Log::where('table', 'purchase_requests')->where('foreign_id', $this->purchaseRequestId)
            ->where('action', '!=', LogAction::CREATE)
            ->get();

        return view('components.supplies.supplies-log-list', ['logs' => $logs]);
    }
}
