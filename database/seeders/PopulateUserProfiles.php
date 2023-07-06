<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateUserProfiles extends Seeder
{
    public function run(): void
    {
        DB::table('user_profiles')->insert([
            ['name' => 'admin', 'is_admin' => true],
            ['name' => 'normal',  'is_admin' => false],
            ['name' => 'suprimentosNutrition',  'is_admin' => false],
            ['name' => 'suprimentosPharma',  'is_admin' => false],
        ]);
    }
}
