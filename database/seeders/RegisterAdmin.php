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
            'street'        => 'default',
            'street_number' => 1,
            'neighborhood'  => 'default',
            'postal_code'   => 'default',
            'city'          => 'default',
            'state'         => 'SC',
            'country'       => 'Brasil',
            'person_id'     => $personId,
        ]);

        DB::table('identification_documents')->insert([
            'identification' => '1',
            'person_id'      => $personId,
        ]);

        DB::table('phones')->insert([
            'number'     => 'default',
            'phone_type' => 'commercial',
            'person_id'  => $personId,
        ]);

        $adminId = DB::table('user_profiles')->insertGetId(['name' => 'admin']);
        DB::table('user_profiles')->insert(['name' => 'normal']);

        $costCenterId = DB::table('cost_centers')->insertGetId(['name' => 'Suprimentos']);

        DB::table('users')->insert([
            'email'          => 'admin@essentia.com.br',
            'password'       => '$2y$10$ZV1gao3lgBrZZkuK6fqaFu3aSKBuzyVsJ0ny8QQCH5THPweL1fHKS',
            'profile_id'     => $adminId,
            'person_id'      => $personId,
            'cost_center_id' => $costCenterId,
        ]);
    }
}
