<?php

namespace Database\Seeders;

use App\Models\Phone;
use Illuminate\Database\Seeder;

class PopulateDefaultPhone extends Seeder
{
    public function run(): void
    {
        Phone::create([
            'number'     => '48992109556',
            'phone_type' => 'commercial',
        ]);
    }
}
