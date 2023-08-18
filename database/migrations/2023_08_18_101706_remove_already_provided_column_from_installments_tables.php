<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_installments', function (Blueprint $table) {
            $table->dropColumn('already_provided');
        });

        Schema::table('contract_installments', function (Blueprint $table) {
            $table->dropColumn('already_provided');
        });
    }

    public function down(): void
    {
        Schema::table('service_installments', function (Blueprint $table) {
            $table->boolean('already_provided')->default(false);
        });

        Schema::table('contract_installments', function (Blueprint $table) {
            $table->boolean('already_provided')->default(false);
        });
    }
};
