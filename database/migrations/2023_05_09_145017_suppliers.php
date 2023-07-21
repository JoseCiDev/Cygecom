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
            $table->string('supplier_indication')->default('Matéria prima'); // M: Matéria prima; S: Serviço; A: Ambos
            $table->enum('qualification', ['em_analise', 'qualificado', 'nao_qualificado'])->default('em_analise');

            $table->string('market_type')->default('nacional')->nullable(); // nacional; exterior; prospect(prospecção)
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('state_registration')->nullable();
            $table->string('representative')->nullable();
            $table->string('email')->nullable();
            $table->string('callisto_code')->nullable();
            $table->string('senior_code')->nullable();
            $table->string('supplier_type_callisto')->nullable();
            $table->string('payment_type_callisto')->nullable();

            $table->unsignedInteger('address_id')->unique()->nullable();
            $table->foreign('address_id')->references('id')->on('addresses');

            $table->unsignedInteger('phone_id')->unique()->nullable();
            $table->foreign('phone_id')->references('id')->on('phones');

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
