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
        Schema::create('quote_items', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->enum('definite_quantity', ['kg', 'g', 'l', 'ml', 'und']);
            $table->decimal('unit_price', 14, 2);
            $table->decimal('quantity', 14, 2);

            // $table->foreignId('purchase_quote_id')->constrained('purchase_quotes')->onDelete('cascade'); // Método mais resumido e menos flexível
            $table->unsignedInteger('purchase_quote_id');
            $table->foreign('purchase_quote_id')->references('id')->on('purchase_quotes')->onDelete('cascade');


            $table->string('description')->nullable();
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
        Schema::dropIfExists('quote_items');
    }
};
