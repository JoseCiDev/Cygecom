<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $personId = DB::table('people')->insertGetId(['name' => 'Administrador']);

        DB::table('addresses')->insert([
            'street' => 'default',
            'street_number' => 'default',
            'neighborhood' => 'default',
            'postal_code' => 'default',
            'city' => 'default',
            'state' => 'SC',
            'country' => 'Brasil',
            'person_id' => $personId,
        ]);

        DB::table('identification_documents')->insert([
            'identification' => '1',
            'person_id' => $personId,
        ]);

        DB::table('phones')->insert([
            'number' => 'default',
            'phone_type' => 'commercial',
            'person_id' => $personId,
        ]);

        $adminId = DB::table('user_profiles')->insertGetId(['profile_name' => 'admin']);
        DB::table('user_profiles')->insert(['profile_name' => 'normal']);

        DB::table('users')->insert([
            'email' => 'admin@essentia.com.br',
            'password' => '$2y$10$ZV1gao3lgBrZZkuK6fqaFu3aSKBuzyVsJ0ny8QQCH5THPweL1fHKS',
            'profile_id' => $adminId,
            'person_id' => $personId,
        ]);
    }
}
