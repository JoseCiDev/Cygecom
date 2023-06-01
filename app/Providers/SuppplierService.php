<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Phone;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class SuppplierService extends ServiceProvider
{
    /**
     * @return Supplier Retorna fornecedor com suas relações, exceto deletados.
     */
    public function getSupplierById(int $id)
    {
        return Supplier::with(['address', 'phone', 'deletedByUser', 'updatedByUser'])->where('id', $id)->whereNull('deleted_at')->first();
    }

    /**
     * @abstract Cria endereço, telefone e fornecedor com suas relações.
     */
    public function registerSupplier(array $data): void
    {
        DB::transaction(function () use ($data) {
            $addressId = $this->createAddress($data);
            $phoneId = $this->createPhone($data);
            $supplier = new Supplier();
            $supplier->fill($data);
            $supplier->address_id = $addressId;
            $supplier->phone_id = $phoneId;
            $supplier->save();
        });
    }

    /**
     * @abstract Atualiza fornecedor e suas relações
     */
    public function updateSupplier(array $data, int $id): void
    {
        DB::transaction(function () use ($data, $id) {
            $supplier = $this->getSupplierById($id);
            $supplier->fill($data);
            $supplier->updated_by = auth()->user()->id;
            $supplier->save();

            $supplier->address->update($data);
            $supplier->phone->update($data);
        });
    }

    public function deleteSupplier(int $id): void
    {
        $supplier = Supplier::find($id);
        $supplier->deleted_at = Carbon::now();
        $supplier->deleted_by = auth()->user()->id;
        $supplier->save();
    }

    private function createPhone(array $data): int
    {
        $phone = Phone::create($data);
        $phoneId = $phone->id;
        return $phoneId;
    }
    private function createAddress(array $data): int
    {
        $address = Address::create($data);
        $addressId = $address->id;
        return $addressId;
    }
}
