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
            $table->increments('id');

            $table->string('path');
            $table->string('type');

            // $table->foreignId('file_order_request_id')->constrained('orders_requests')->onDelete('cascade'); // Método mais resumido e menos flexível
            $table->unsignedInteger('file_order_request_id');
            $table->foreign('file_order_request_id')->references('id')->on('orders_requests')->onDelete('cascade');

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
        Schema::dropIfExists('orders_requests_files');
    }
};
