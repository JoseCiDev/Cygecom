<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegisterDefaultAddress extends Seeder
{
    public function run(): void
    {
        DB::table('addresses')->insert([
            'street'        => 'Rua Jair Hamms',
            'street_number' => 38,
            'neighborhood'  => 'Pedra Branca',
            'postal_code'   => '88137084',
            'city'          => 'Palhoça',
            'state'         => 'SC',
            'country'       => 'Brasil',
        ]);
    }
}
