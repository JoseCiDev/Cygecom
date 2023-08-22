<?php

use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
