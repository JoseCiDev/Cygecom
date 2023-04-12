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
        Schema::create('orders_requests_files', function (Blueprint $table) {
            $table->id();

            $table->string('path');
            $table->string('type'); // Avaliar enum
            // $table->enum('type', ['value1', 'value2', 'value3']);

            // $table->unsignedBigInteger('orders_requests_id');
            // $table->foreign('orders_requests_id')->references('id')->on('orders_requests');
            $table->foreignId('file_order_request_id')->constrained('orders_requests')->onDelete('cascade');

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
        Schema::dropIfExists('orders_requests_files');
    }
};
