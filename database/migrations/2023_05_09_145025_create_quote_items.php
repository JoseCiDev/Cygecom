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

            $table->unsignedInteger('purchase_quote_id');
            $table->foreign('purchase_quote_id')->references('id')->on('purchase_quotes');

            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');

            $table->string('model')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_items');
    }
};
