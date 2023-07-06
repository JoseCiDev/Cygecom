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
            PopulateDefaultPhone::class,
            PopulateCompanies::class,
            PopulateUserProfiles::class,
            PopulateProductCategories::class,
            // PopulateProducts::class,
            PopulateCostCenters::class,
            RegisterAdmin::class,
            PopulateUserCostCenterPermissionDefault::class,
        ]);
    }
}
