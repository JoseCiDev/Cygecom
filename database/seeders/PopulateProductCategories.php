<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateProductCategories extends Seeder
{
    public function run(): void
    {
        DB::table('product_categories')->insert([
            ['name' => 'Pharma HKM - Líquidos e Sólidos'],
            ['name' => 'Injetáveis HKM'],
            ['name' => 'Smart - Líquidos e Sólidos'],
            ['name' => 'Material de limpeza e copa'],
            ['name' => 'Material de escritório'],
        ]);
    }
}
