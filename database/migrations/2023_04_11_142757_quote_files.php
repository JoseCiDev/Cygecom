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
        Schema::create('quote_files', function (Blueprint $table) {
            $table->id();

            $table->string('path');
            $table->string('type'); // Avaliar enum
            // $table->enum('type', ['pdf', 'doc', 'png'])->index();

            $table->unsignedBigInteger('purchase_quote_id')->index();
            $table->foreign('purchase_quote_id')->references('id')->on('purchase_quotes');

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_files');
    }
};
