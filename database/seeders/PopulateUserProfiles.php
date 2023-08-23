<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateUserProfiles extends Seeder
{
    public function run(): void
    {
        DB::table('user_profiles')->insert([
            ['name' => 'admin'],
            ['name' => 'normal'],
            ['name' => 'suprimentos_inp'],
            ['name' => 'suprimentos_hkm'],
            ['name' => 'gestor_usuarios'],
            ['name' => 'gestor_fornecedores'],
            ['name' => 'diretor'],
        ]);
    }
}
