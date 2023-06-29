<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Providers\CSVImporter;
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
        // $csvPath = base_path('database/seeders/import/csv/cadastro-fornecedores-callisto.csv');
        // $outputPath = base_path('database/seeders/import/data/suppliers-callisto.php');

        // $csvPath = base_path('database/seeders/import/csv/Fornecedor-HKM-filtrado.csv');
        // $outputPath = base_path('database/seeders/import/data/suppliers-hkm.php');

        // $csvImporter = new CSVImporter($csvPath);
        // $csvImporter->generateArrayFile($outputPath);

        $requireSuppliersCallistoData = require('database/seeders/import/data/suppliers-callisto.php');
        $requireSuppliersHkmData = require('database/seeders/import/data/suppliers-hkm.php');

        foreach ($requireSuppliersCallistoData as $value) {
            $supplier = new Supplier;
            $supplier->cpf_cnpj = trim($value['cpf_cnpj']);
            $supplier->name = trim($value['name']);
            $supplier->corporate_name = trim($value['corporate_name']);
            $supplier->state_registration = trim($value['state_registration']);
            dd($value, $supplier->toArray());
        }

        foreach ($requireSuppliersHkmData as $value) {
            $supplier = new Supplier;
            $supplier->cpf_cnpj = trim($value['cpf_cnpj']);
            $supplier->name = trim($value['name']);
            $supplier->corporate_name = trim($value['corporate_name']);
            $supplier->email = trim($value['email']);
            dd($value, $supplier->toArray());
        }

        // DB::table('suppliers')->insert($requireSuppliersCallistoData);
        // DB::table('suppliers')->insert($requireSuppliersHkmData);
    }
}
