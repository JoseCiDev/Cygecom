<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_quotes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->enum('status', ['pending', 'processing', 'approved', 'declined']);

            $table->unsignedInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            $table->unsignedInteger('quote_order_request_id')->nullable();
            $table->foreign('quote_order_request_id')->references('id')->on('orders_requests');

            $table->dateTime('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->unsignedInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('no action');
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_quotes');
    }
};
