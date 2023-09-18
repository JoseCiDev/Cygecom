<?php

namespace Database\Seeders\Inserts;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertOnCompanies extends Seeder
{
    public function run(): void
    {
        $newCompanies = require(__DIR__ . "/data/companies-to-insert.php");

        DB::transaction(function () use ($newCompanies) {
            foreach ($newCompanies as $newCompany) {
                Company::updateOrCreate(['id' => $newCompany['id']], $newCompany);
            }
        });
    }
}
