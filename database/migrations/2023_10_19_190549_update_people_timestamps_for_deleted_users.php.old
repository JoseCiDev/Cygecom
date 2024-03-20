<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('people')
            ->join('users', 'people.id', 'users.person_id')
            ->whereNotNull('users.deleted_at')
            ->update([
                'people.deleted_at' => now(),
                'people.deleted_by' => DB::raw('users.deleted_by'),
            ]);
    }

    public function down(): void
    {
        DB::table('people')
            ->update([
                'people.deleted_at' => null,
                'people.deleted_by' => null,
            ]);
    }
};
