<?php

namespace App\View\Components;

use App\Enums\{LogAction, PurchaseRequestStatus};
use App\Models\{PurchaseRequest, Log};
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
        $purchaseRequest = PurchaseRequest::find($this->purchaseRequestId);

        $type = null;
        $foreignId = null;

        if ($purchaseRequest->product) {
            $type = 'products';
            $foreignId = $purchaseRequest->product->id;
        } elseif ($purchaseRequest->service) {
            $type = 'services';
            $foreignId = $purchaseRequest->service->id;
        } elseif ($purchaseRequest->contract) {
            $type = 'contracts';
            $foreignId = $purchaseRequest->contract->id;
        }

        $logs = $this->getLogsForType('purchase_requests', $this->purchaseRequestId);
        $typeLogs = $this->getLogsForType($type, $foreignId);
        $allLogs = $logs->concat($typeLogs);

        $statusChangeTime = $logs->first(
            fn ($log) => isset($log->changes['status']) && PurchaseRequestStatus::tryFrom($log->changes['status']) === PurchaseRequestStatus::PENDENTE
        )?->created_at;

        $filteredLogs = $allLogs->filter(fn ($log) => $log->created_at > $statusChangeTime)->sortBy('created_at')->values();

        return view('components.supplies.supplies-log-list', ['logs' => $filteredLogs]);
    }

    private function getLogsForType($table, $id)
    {
        return Log::where('table', $table)
            ->where('foreign_id', $id)
            ->where('action', '!=', LogAction::CREATE)
            ->get();
    }
}
