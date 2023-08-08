<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_infos', function (Blueprint $table) {
            $table->enum('payment_method', ['pix', 'boleto', 'dinheiro', 'deposito_bancario', 'cartao_credito', 'cartao_debito'])->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('payment_infos', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->change();
        });
    }
};
