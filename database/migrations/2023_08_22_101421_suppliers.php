<?php

use App\Models\{Address, Phone, User};
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('corporate_name')->unique();
            $table->enum('entity_type', ['PF', 'PJ'])->default('PJ');
            $table->string('supplier_indication')->default('Matéria prima');
            $table->enum('qualification', ['em_analise', 'qualificado', 'nao_qualificado'])->default('em_analise');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->string('cpf_cnpj', 20)->nullable();
            $table->text('tributary_observation')->nullable();
            $table->string('market_type')->default('nacional')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('state_registration')->nullable();
            $table->string('representative')->nullable();
            $table->string('email')->nullable();
            $table->string('callisto_code')->nullable();
            $table->string('senior_code')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreignIdFor(Address::class)->nullable()->constrained();
            $table->foreignIdFor(Phone::class)->nullable()->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
