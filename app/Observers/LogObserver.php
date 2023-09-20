<?php

namespace App\Observers;

use App\Enums\LogAction;
use App\Models\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LogObserver
{
    /**
     * Handle the Model "created" event.
     */
    public function created(Model $model): void
    {
        $changes = $model->getAttributes();

        $this->createLog(LogAction::CREATE, $model, $changes);
    }

    /**
     * Handle the Model "updated" event.
     */
    public function updated(Model $model): void
    {
        $dirtyAttributes = $model->getDirty();

        if (!empty($dirtyAttributes)) {
            $isDelete = $model->wasChanged('deleted_at') && $model->deleted_at !== null;

            $action = $isDelete ? 'delete' : 'update';
            $action = LogAction::tryFrom($action);
            $this->createLog($action, $model, $dirtyAttributes);
        }
    }

    public function deleted(Model $model): void
    {
        $this->createLog(LogAction::DELETE, $model);
    }

    private function createLog(LogAction $action, $model, ?array $changes = null): void
    {
        $userId = Auth::id();
        if ($userId === null) {
            return;
        }

        $logData = [
            'table' => $model->getTable(),
            'foreign_id' => $model->id,
            'user_id' => Auth::id(),
            'action' => $action->value,
            'changes' => $changes,
        ];

        if ($changes !== null) {
            //trata quando 'supplies_update_reason' existe mas é null
            $hasChanges = array_key_exists('supplies_update_reason', $logData['changes']);
            $hasChangesButIsNull = $hasChanges && $logData['changes']['supplies_update_reason'] === null;

            if ($hasChangesButIsNull) {
                return;
            }

            Log::create($logData);
        }
    }
}
