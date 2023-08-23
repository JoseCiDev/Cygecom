<?php

use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('corporate_name')->unique();
            $table->string('cnpj', 20)->unique();
            $table->enum('group', ['inp', 'hkm'])->default('hkm');

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
