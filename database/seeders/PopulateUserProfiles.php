<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateUserProfiles extends Seeder
{
    public function run(): void
    {
        DB::table('user_profiles')->insert([
            ['name' => 'admin', 'is_admin' => null],
            ['name' => 'normal', 'is_admin' => null],
            ['name' => 'suprimentos_inp', 'is_admin' => null],
            ['name' => 'suprimentos_hkm', 'is_admin' => null],
            ['name' => 'gestor_usuarios', 'is_admin' => null],
            ['name' => 'gestor_fornecedores', 'is_admin' => null],
            ['name' => 'diretor', 'is_admin' => null],
        ]);
    }
}
