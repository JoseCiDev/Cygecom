<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('corporate_name')->unique();
            $table->string('cnpj', 20)->unique();

            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('state_registration')->nullable();
            $table->string('senior_code')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
