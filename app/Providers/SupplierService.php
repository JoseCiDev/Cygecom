<?php

namespace App\Providers;

use App\Enums\CompanyGroup;
use App\Models\{Address, Phone, Supplier};
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class SupplierService extends ServiceProvider
{
    /**
     * @return Supplier Retorna fornecedor com suas relações, exceto deletados.
     */
    public function getSupplierById(int $id)
    {
        return Supplier::with(['address', 'phone', 'deletedByUser', 'updatedByUser'])->where('id', $id)->whereNull('deleted_at')->first();
    }

    /**
     * @abstract Cria e retorna fornecedor com endereço e telefone.
     */
    public function registerSupplier(array $data)
    {
        return DB::transaction(function () use ($data) {
            $addressId = $this->createAddress($data);
            $phoneId   = $this->createPhone($data);
            $supplier  = new Supplier();
            $supplier->fill($data);
            $supplier->address_id = $addressId;
            $supplier->phone_id   = $phoneId;
            $supplier->save();
            return $supplier;
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
        $supplier             = Supplier::find($id);
        $supplier->deleted_at = Carbon::now();
        $supplier->deleted_by = auth()->user()->id;
        $supplier->save();
    }

    public function filterRequestByCompanyGroup(Collection $requests, CompanyGroup $companyGroup)
    {
        return $requests->filter(function ($item) use ($companyGroup) {
            $costCenterApportionments = $item->CostCenterApportionment;
            return $costCenterApportionments->contains(function ($apportionment) use ($companyGroup) {
                return $apportionment->costCenter->Company->group->value === $companyGroup->value;
            });
        });
    }

    private function createPhone(array $data): int
    {
        $phone   = Phone::create($data);
        $phoneId = $phone->id;

        return $phoneId;
    }
    private function createAddress(array $data): int
    {
        $address   = Address::create($data);
        $addressId = $address->id;

        return $addressId;
    }
}
