<?php

use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{Schema, DB};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('payment_infos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->text('description')->nullable();
            $table->enum('payment_method', ['pix', 'boleto', 'cheque', 'dinheiro', 'deposito_bancario', 'cartao_credito', 'cartao_debito', 'internacional'])->nullable();
            $table->enum('payment_terms', ['anticipated', 'in_cash', 'installment'])->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_infos');
    }
};
