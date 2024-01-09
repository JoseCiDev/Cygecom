<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_request_products', function (Blueprint $table) {
            $table->text('link')->nullable()->after('size');
        });
    }

    public function down(): void
    {
        Schema::table('purchase_request_products', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
};
