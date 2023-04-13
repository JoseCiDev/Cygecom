<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_quotes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('description');
            $table->enum('status', ['pending', 'processing', 'approved', 'declined']);

            // $table->foreignId('supplier_id')->constrained('suppliers'); // Método mais resumido e menos flexível
            $table->unsignedInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers');


            // $table->foreignId('quote_order_request_id')->constrained('orders_requests'); // Método mais resumido e menos flexível
            $table->unsignedInteger('quote_order_request_id');
            $table->foreign('quote_order_request_id')->references('id')->on('orders_requests');

            $table->dateTime('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_quotes');
    }
};
