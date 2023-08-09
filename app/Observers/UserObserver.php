<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $changes = [
            'email' => $user->email,
            'password' => $user->password,
            'is_buyer' => $user->is_buyer,
            'profile_id' => $user->profile_id,
            'person_id' => $user->person_id,
            'approver_user_id' => $user->approver_user_id,
            'approve_limit' => $user->approve_limit
        ];

        $this->createLog('create', $user, $changes);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $changes = [];

        $dirtyAttributes = $user->getDirty();

        $attributesToTrack = [
            'email' => $user->email,
            'password' => $user->password,
            'is_buyer' => $user->is_buyer,
            'profile_id' => $user->profile_id,
            'approver_user_id' => $user->approver_user_id,
            'approve_limit' => $user->approve_limit,
            'deleted_at' => $user->deleted_at,
        ];

        foreach ($attributesToTrack as $attribute => $value) {
            if (array_key_exists($attribute, $dirtyAttributes)) {
                $changes[$attribute] = $value;
            }
        }

        if (!empty($changes)) {
            $isDelete = $user->wasChanged('deleted_at') && $user->deleted_at !== null;

            if ($isDelete) {
                $this->createLog('soft-delete', $user, $changes);
            } else {
                $this->createLog('update', $user, $changes);
            }
        }
    }

    private function createLog($action, $user, ?array $changes = null)
    {
        UserLog::create([
            'changed_user_id' => $user->id,
            'action' => $action,
            'user_id' => Auth::id(),
            'changes' => $changes,
        ]);
    }
}
