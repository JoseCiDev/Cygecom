<?php

namespace Database\Seeders\Inserts;

use App\Models\Company;
use Database\Seeders\Inserts\Data\CompaniesToInsert;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertOnCompanies extends Seeder
{
    public function run(): void
    {
        $newCompanies = CompaniesToInsert::getArray();

        DB::transaction(function () use ($newCompanies) {
            foreach ($newCompanies as $newCompany) {
                Company::updateOrCreate(['id' => $newCompany['id']], $newCompany);
            }
        });
    }
}
