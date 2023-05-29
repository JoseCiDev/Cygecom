<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RegisterDefaultAddress::class,
            PopulateCompanies::class,
            PopulateCostCenters::class,
            PopulateUserProfiles::class,
            PopulateProductCategories::class,
            PopulateProducts::class,
            RegisterAdmin::class,
        ]);
    }
}
