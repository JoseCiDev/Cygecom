<?php

namespace App\Observers;

use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestsLog;
use Illuminate\Support\Facades\Auth;

class PurchaseRequestObserver
{
    /**
     * Handle the PurchaseRequest "created" event.
     */
    public function created(PurchaseRequest $purchaseRequest): void
    {
        $this->createLog('create', $purchaseRequest);
    }

    /**
     * Handle the PurchaseRequest "updated" event.
     */
    public function updated(PurchaseRequest $purchaseRequest): void
    {
        $currentStatus = $purchaseRequest?->status;
        $newSuppliesUser = $purchaseRequest?->supplies_user_id;

        $this->createLog('update', $purchaseRequest, $currentStatus, $newSuppliesUser);
    }

    private function createLog($action, $purchaseRequest, $newStatus = null, ?int $newSuppliesUser = null)
    {
        $changes = [
            'status' => $newStatus ? $newStatus->value : null,
            'supplies_user_id' => $newSuppliesUser,
        ];

        PurchaseRequestsLog::create([
            'purchase_request_id' => $purchaseRequest->id,
            'action' => $action,
            'user_id' => Auth::id(),
            'changes' => $changes,
        ]);
    }
}
