<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Phone;
use App\Models\Supplier;
use ErrorException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateSuppliers extends Seeder
{
    /**
     * @throws ErrorException
     */
    public function run(): void
    {
        $suppliersData = require('database/seeders/import/data/suppliers.php');

        if ($suppliersData) {
            DB::transaction(function () use ($suppliersData) {
                foreach ($suppliersData as $data) {
                    $phoneData = ['number' => $data['phone[number]']];
                    $phone = Phone::create($phoneData);

                    $address = new Address;
                    $fillableData = array_intersect_key($data, array_flip($address->getFillable()));
                    $address->fill($fillableData);
                    $address->save();

                    $data['phone_id'] = $phone->id;
                    $data['address_id'] = $address->id;

                    $supplier = new Supplier;
                    $fillableData = array_intersect_key($data, array_flip($supplier->getFillable()));
                    $supplier->fill($fillableData);
                    $supplier->save();

                    dd($supplier->toArray());
                }
            });
        }
    }
}
