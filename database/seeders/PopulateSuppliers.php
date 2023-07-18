<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Phone;
use App\Models\Supplier;
use App\Providers\ValidatorService;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PopulateSuppliers extends Seeder
{
    public function __construct(private ValidatorService $validatorService)
    {
    }

    /**
     * @throws ErrorException
     */
    public function run(): void
    {
        $suppliersData = require('database/seeders/import/data/suppliers.php');

        if ($suppliersData) {
            DB::transaction(function () use ($suppliersData) {
                try {
                    foreach ($suppliersData as $data) {
                        $validator = $this->validatorService->supplier($data);
                        if ($validator->fails()) {
                            continue;
                        }

                        if ((bool)$data['number']) {
                            $phoneData = ['number' => $data['number'], 'phone_type' => 'commercial'];
                            $phone = Phone::create($phoneData);
                            $data['phone_id'] = $phone->id;
                        }

                        $address = new Address;
                        $fillableData = array_intersect_key($data, array_flip($address->getFillable()));
                        $address->fill($fillableData);
                        $address->save();

                        $data['address_id'] = $address->id;

                        $supplier = new Supplier;
                        $fillableData = array_intersect_key($data, array_flip($supplier->getFillable()));
                        $supplier->fill($fillableData);
                        $supplier->qualification = 'qualificado';
                        $supplier->save();
                    }
                } catch (QueryException $error) {
                    DB::rollback();
                    Log::error('Ocorreu um erro ao executar a transação: ' . $error->getMessage());
                }
            });
        }
    }
}
