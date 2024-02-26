<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class UpdateCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::where('cnpj', '17979609000238')
            ->update([
                'corporate_name' => 'INP INDUSTRIA DE ALIMENTOS LTDA - FILIAL PALHOÇA',
                'name' => 'INP FILIAL - PALHOÇA',
            ]);
    }
}
