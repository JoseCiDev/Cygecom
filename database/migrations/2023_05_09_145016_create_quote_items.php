<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_items', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->integer('quantity')->default(1);

            $table->unsignedInteger('purchase_quote_id')->unique();
            $table->foreign('purchase_quote_id')->references('id')->on('purchase_quotes');

            $table->unsignedInteger('product_id')->unique();
            $table->foreign('product_id')->references('id')->on('products');

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->unsignedInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');

            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_items');
    }
};
