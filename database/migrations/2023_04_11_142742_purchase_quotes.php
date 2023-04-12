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
            $table->id();

            $table->string('description');
            $table->enum('status', ['pending', 'processing', 'approved', 'declined']);

            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('quote_order_request_id')->constrained('orders_requests');

            $table->timestamp('created_at')->nullable()->default(DB::raw('NOW()'));
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
