<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('corporate_name')->unique();
            $table->string('cpf_cnpj', 20)->unique();
            $table->enum('entity_type', ['PF', 'PJ'])->default('PJ');
            $table->boolean('is_service_provider')->default(true);
            $table->boolean('is_raw_material_provider')->default(false);
            $table->boolean('is_national_market')->default(true);
            $table->boolean('it_foreign_market')->default(false);
            $table->boolean('is_qualified')->default(false);

            $table->unsignedInteger('address_id')->unique();
            $table->foreign('address_id')->references('id')->on('addresses');

            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('state_registration')->nullable();
            $table->string('company_representative')->nullable();
            $table->string('email')->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
