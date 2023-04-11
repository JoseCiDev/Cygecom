<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders_requests', function (Blueprint $table) {
            $table->id();

            // $table->string('status'); // Avaliar enum
            // $table->string('priority'); // Avaliar enum
            $table->enum('status', ['pending', 'processing', 'completed']);
            $table->enum('priority', ['very low', 'low', 'medium', 'high', 'very high']);

            $table->string('description');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_requests');
    }
};
