<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_request_products', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->text('name');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 14, 2)->nullable();

            $table->text('description')->nullable();
            $table->string('model')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->unsignedInteger('purchase_request_id');
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');

            $table->unsignedInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            $table->unsignedInteger('product_category_id')->nullable();
            $table->foreign('product_category_id')->references('id')->on('product_categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_request_products');
    }
};
