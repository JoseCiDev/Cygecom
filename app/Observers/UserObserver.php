<?php

namespace App\Observers;

use App\Enums\LogAction;
use App\Models\{User, UserLog};
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
            'user_profile_id' => $user->user_profile_id,
            'person_id' => $user->person_id,
            'approver_user_id' => $user->approver_user_id,
            'approve_limit' => $user->approve_limit
        ];

        $this->createLog(LogAction::CREATE, $user, $changes);
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
            'user_profile_id' => $user->user_profile_id,
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
                $this->createLog(LogAction::DELETE, $user, $changes);
            } else {
                $this->createLog(LogAction::UPDATE, $user, $changes);
            }
        }
    }

    private function createLog(LogAction $action, $user, ?array $changes = null)
    {
        UserLog::create([
            'changed_user_id' => $user->id,
            'action' => $action->value,
            'user_id' => Auth::id(),
            'changes' => $changes,
        ]);
    }
}
