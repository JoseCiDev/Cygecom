<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // remove a coluna 'is_prepaid' das colunas pre existentes
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('is_prepaid');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_prepaid');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('is_prepaid');
        });

        // troca por um enum em payment_infos
        Schema::table('payment_infos', function (Blueprint $table) {
            $table->enum('payment_terms', ['anticipated', 'in_cash', 'installment'])->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->boolean('is_prepaid')->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_prepaid')->nullable();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->boolean('is_prepaid')->nullable();
        });

        Schema::table('payment_infos', function (Blueprint $table) {
            $table->dropColumn('payment_terms');
        });
    }
};
