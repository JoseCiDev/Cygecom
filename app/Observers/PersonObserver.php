<?php

namespace App\Observers;

use App\Enums\LogAction;
use App\Models\{Person, PersonLog};
use Illuminate\Support\Facades\Auth;

class PersonObserver
{
    /**
     * Handle the Person "created" event.
     */
    public function created(Person $person): void
    {
        $changes = [
            'name' => $person->name,
            'cpf_cnpj' => $person->cpf_cnpj,
            'birthdate' => $person->birthdate,
            'cost_center_id' => $person->cost_center_id,
            'phone_id' => $person->phone_id,
        ];

        $this->createLog(LogAction::CREATE, $person, $changes);
    }

    /**
     * Handle the Person "updated" event.
     */
    public function updated(Person $person): void
    {
        $changes = [];

        $dirtyAttributes = $person->getDirty();

        $attributesToTrack = [
            'name' => $person->name,
            'cpf_cnpj' => $person->cpf_cnpj,
            'birthdate' => $person->birthdate,
            'cost_center_id' => $person->cost_center_id,
            'phone_id' => $person->phone_id,
            'deleted_at' => $person->deleted_at
        ];

        foreach ($attributesToTrack as $attribute => $value) {
            if (array_key_exists($attribute, $dirtyAttributes)) {
                $changes[$attribute] = $value;
            }
        }

        if (!empty($changes)) {
            $isDelete = $person->wasChanged('deleted_at') && $person->deleted_at !== null;

            if ($isDelete) {
                $this->createLog(LogAction::DELETE, $person, $changes);
            } else {
                $this->createLog(LogAction::UPDATE, $person, $changes);
            }
        }
    }

    private function createLog(LogAction $action, $person, ?array $changes = null)
    {
        PersonLog::create([
            'changed_person_id' => $person->id,
            'action' => $action->value,
            'user_id' => Auth::id(),
            'changes' => $changes,
        ]);
    }
}
