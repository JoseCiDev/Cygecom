<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users_log', function (Blueprint $table) {
            $table->enum('action', ['create', 'update', 'delete'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('users_log', function (Blueprint $table) {
            $table->string('action')->change();
        });
    }
};
