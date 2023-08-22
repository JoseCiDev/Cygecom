<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payment_infos', function (Blueprint $table) {
            $table->enum('payment_method', ['pix', 'boleto', 'cheque', 'dinheiro', 'deposito_bancario', 'cartao_credito', 'cartao_debito', 'internacional'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_infos', function (Blueprint $table) {
            $table->enum('payment_method', ['pix', 'boleto', 'cheque', 'dinheiro', 'deposito_bancario', 'cartao_credito', 'cartao_debito'])->nullable()->change();
        });
    }
};
