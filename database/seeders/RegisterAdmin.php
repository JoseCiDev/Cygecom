<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegisterAdmin extends Seeder
{
    public function run(): void
    {
        $personId = DB::table('people')->insertGetId(['name' => 'Administrador']);

        DB::table('addresses')->insert([
            'street'        => 'Rua Jair Hamms',
            'street_number' => 38,
            'neighborhood'  => 'Pedra Branca',
            'postal_code'   => '88137084',
            'city'          => 'Palhoça',
            'state'         => 'SC',
            'country'       => 'Brasil',
            'person_id'     => $personId,
        ]);

        DB::table('identification_documents')->insert([
            'identification' => '01234567812',
            'type'           => 'cpf',
            'person_id'      => $personId,
        ]);

        DB::table('phones')->insert([
            'number'     => '48912345678',
            'phone_type' => 'commercial',
            'person_id'  => $personId,
        ]);

        DB::table('users')->insert([
            'email'      => 'admin@essentia.com.br',
            'password'   => '$2y$10$ZV1gao3lgBrZZkuK6fqaFu3aSKBuzyVsJ0ny8QQCH5THPweL1fHKS',
            'profile_id' => 1,
            'person_id'  => $personId,
        ]);
    }
}
