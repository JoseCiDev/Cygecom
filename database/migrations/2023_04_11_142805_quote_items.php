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
        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('definite_quantity');
            $table->decimal('unit_price');
            $table->decimal('quantity');

            // $table->unsignedBigInteger('purchase_quote_id')->index();
            // $table->foreign('purchase_quote_id')->references('id')->on('purchase_quotes');

            $table->foreignId('purchase_quote_id')->constrained('purchase_quotes')->onDelete('cascade');

            $table->decimal('description')->nullable();

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_items');
    }
};
