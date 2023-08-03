<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();

            $table->boolean('is_prepaid')->nullable();

            $table->string('seller')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->decimal('amount', 14, 2)->nullable();
            $table->unsignedInteger('quantity_of_installments')->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            // Chaves estrangeiras
            $table->unsignedInteger('purchase_request_id');
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');

            $table->unsignedInteger('payment_info_id')->nullable();
            $table->foreign('payment_info_id')->references('id')->on('payment_infos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
