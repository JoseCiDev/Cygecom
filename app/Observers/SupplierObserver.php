<?php

namespace App\Observers;

use App\Enums\LogAction;
use App\Models\{Supplier, SupplierLog};
use Illuminate\Support\Facades\Auth;

class SupplierObserver
{
    /**
     * Handle the Supplier "created" event.
     */
    public function created(Supplier $supplier): void
    {
        $changes = [
            'corporate_name' => $supplier->corporate_name,
            'cpf_cnpj' => $supplier->cpf_cnpj,
            'entity_type' => $supplier->entity_type,
            'market_type' => $supplier->market_type,
            'supplier_indication' => $supplier->supplier_indication,
            'qualification' => $supplier->qualification,
            'address_id' => $supplier->address_id,
            'phone_id' => $supplier->phone_id,
            'name' => $supplier->name,
            'description' => $supplier->description,
            'state_registration' => $supplier->state_registration,
            'email' => $supplier->email,
            'representative' => $supplier->representative,
            'tributary_observation' => $supplier->tributary_observation,
            'callisto_code' => $supplier->callisto_code,
            'senior_code' => $supplier->senior_code,
        ];

        $this->createLog(LogAction::CREATE, $supplier, $changes);
    }

    /**
     * Handle the Supplier "updated" event.
     */
    public function updated(Supplier $supplier): void
    {
        $changes = [];

        $dirtyAttributes = $supplier->getDirty();

        $attributesToTrack = [
            'corporate_name' => $supplier->corporate_name,
            'cpf_cnpj' => $supplier->cpf_cnpj,
            'entity_type' => $supplier->entity_type,
            'market_type' => $supplier->market_type,
            'supplier_indication' => $supplier->supplier_indication,
            'qualification' => $supplier->qualification,
            'address_id' => $supplier->address_id,
            'phone_id' => $supplier->phone_id,
            'name' => $supplier->name,
            'description' => $supplier->description,
            'state_registration' => $supplier->state_registration,
            'email' => $supplier->email,
            'representative' => $supplier->representative,
            'tributary_observation' => $supplier->tributary_observation,
            'callisto_code' => $supplier->callisto_code,
            'senior_code' => $supplier->senior_code,
            'deleted_at' => $supplier->deleted_at,
        ];

        foreach ($attributesToTrack as $attribute => $value) {
            if (array_key_exists($attribute, $dirtyAttributes)) {
                $changes[$attribute] = $value;
            }
        }

        if (!empty($changes)) {
            $isDelete = $supplier->wasChanged('deleted_at') && $supplier->deleted_at !== null;

            if ($isDelete) {
                $this->createLog(LogAction::DELETE, $supplier, $changes);
            } else {
                $this->createLog(LogAction::UPDATE, $supplier, $changes);
            }
        }
    }

    private function createLog(LogAction $action, $supplier, ?array $changes = null)
    {
        $userId = Auth::id();
        if (!$userId) {
            return;
        }

        SupplierLog::create([
            'changed_supplier_id' => $supplier->id,
            'action' => $action->value,
            'user_id' => $userId,
            'changes' => $changes,
        ]);
    }
}
