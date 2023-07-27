<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegisterAdmin extends Seeder
{
    public function run(): void
    {
        $phoneId = DB::table('phones')->insertGetId([
            'number'     => '48912345678',
            'phone_type' => 'commercial',
        ]);

        $personId = DB::table('people')->insertGetId([
            'name'           => 'Administrador',
            'cpf_cnpj'       => '012.345.678-90',
            'cost_center_id' => 1,
            'phone_id'       => $phoneId,
        ]);

        DB::table('users')->insert([
            'email'      => 'gecom_admin@essentia.com.br',
            'password'   => '$2y$10$ZV1gao3lgBrZZkuK6fqaFu3aSKBuzyVsJ0ny8QQCH5THPweL1fHKS',
            'profile_id' => 1,
            'person_id'  => $personId,
            'is_buyer'   => true,
        ]);
    }
}
