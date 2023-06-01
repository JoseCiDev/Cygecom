<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateUserProfiles extends Seeder
{
    public function run(): void
    {
        DB::table('user_profiles')->insert([
            ['name' => 'admin', 'isAdmin' => true],
            ['name' => 'normal',  'isAdmin' => false],
            ['name' => 'suprimentosNutrition',  'isAdmin' => false],
            ['name' => 'suprimentosPharma',  'isAdmin' => false],
        ]);
    }
}
