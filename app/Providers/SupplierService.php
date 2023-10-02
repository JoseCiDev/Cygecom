<?php

namespace App\Providers;

use App\Enums\CompanyGroup;
use App\Models\{Address, Phone, Supplier};
use Carbon\Carbon;
use Illuminate\Support\{Collection, Facades\DB, ServiceProvider};

class SupplierService extends ServiceProvider
{
    /**
     * @return mixed Retorna fornecedores com suas relações, exceto deletados.
     */
    public function getSuppliers()
    {
        return Supplier::with(['address', 'phone', 'deletedByUser', 'updatedByUser'])->whereNull('deleted_at');
    }

    /**
     * @return Supplier Retorna fornecedor pelo ID com suas relações, exceto deletados.
     */
    public function getSupplierById(int $id)
    {
        return Supplier::with(
            [
                'address',
                'phone',
                'deletedByUser',
                'updatedByUser',
                'service.purchaseRequest',
                'contract.purchaseRequest',
                'purchaseRequestProduct.purchaseRequest',

            ])->where('id', $id)
                ->whereNull('deleted_at')
                ->firstOrFail();
    }

    /**
     * @abstract Cria e retorna fornecedor com endereço e telefone.
     */
    public function registerSupplier(array $data)
    {
        return DB::transaction(function () use ($data) {
            $supplier = Supplier::create($data);
            $supplier->address_id = $this->createAddress($data);

            if ($data['number'] !== null) {
                $supplier->phone_id = $this->createPhone($data);
            }

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
            $supplier->fill(array_merge($data, ['updated_by' => auth()->user()->id]));
            $supplier->save();

            $this->updateOrCreateAddress($supplier->address(), $data);

            if ($data['number'] !== null) {
                $this->updateOrCreatePhone($supplier, $data);
            }
        });
    }

    public function deleteSupplier(int $id): void
    {
        $supplier = Supplier::find($id);
        $supplier->deleted_at = Carbon::now();
        $supplier->deleted_by = auth()->user()->id;
        $supplier->save();
    }

    public function filterRequestByCompanyGroup(Collection $requests, CompanyGroup $companyGroup)
    {
        return $requests->filter(function ($item) use ($companyGroup) {
            $costCenterApportionments = $item->costCenterApportionment;
            return $costCenterApportionments->contains(function ($apportionment) use ($companyGroup) {
                return $apportionment->costCenter->company->group->value === $companyGroup->value;
            });
        });
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

    private function updateOrCreateAddress($addressRelation, $data)
    {
        $addressRelation->updateOrCreate([], $data);
    }

    private function updateOrCreatePhone(?Supplier $supplier, $data)
    {
        if ($supplier->phone !== null) {
            $supplier->phone->update($data);
        } else {
            $newPhone = $supplier->phone()->create($data);
            $supplier->phone_id = $newPhone->id;
            $supplier->save();
        }
    }
}
