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
        $changes = [];

        $dirtyAttributes = $purchaseRequest->getDirty();

        $attributesToTrack = [
            'status' => $purchaseRequest->status->value,
            'supplies_user_id' => $purchaseRequest->supplies_user_id,
            'deleted_at' => $purchaseRequest->deleted_at,
        ];

        foreach ($attributesToTrack as $attribute => $value) {
            if (array_key_exists($attribute, $dirtyAttributes)) {
                $changes[$attribute] = $value;
            }
        }

        if (!empty($changes)) {
            $isDelete = $purchaseRequest->wasChanged('deleted_at') && $purchaseRequest->deleted_at !== null;

            if ($isDelete) {
                $this->createLog('soft-delete', $purchaseRequest, $changes, $isDelete);
            } else {
                $this->createLog('update', $purchaseRequest, $changes);
            }
        }
    }

    private function createLog($action, $purchaseRequest, ?array $changes = null, ?bool $isDelete = null)
    {
        PurchaseRequestsLog::create([
            'purchase_request_id' => $purchaseRequest->id,
            'action' => $action,
            'user_id' => Auth::id(),
            'changes' => $changes,
        ]);
    }
}
