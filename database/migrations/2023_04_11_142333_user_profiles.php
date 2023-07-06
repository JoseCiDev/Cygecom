<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('name')->unique();
            $table->boolean('is_admin')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
