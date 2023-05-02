<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('quote_items', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->enum('definite_quantity', ['kg', 'g', 'l', 'ml', 'und']);
            $table->decimal('unit_price', 14, 2);
            $table->decimal('quantity', 14, 2);

            $table->unsignedInteger('purchase_quote_id');
            $table->foreign('purchase_quote_id')->references('id')->on('purchase_quotes')->onDelete('cascade');

            $table->string('description')->nullable();
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
        Schema::dropIfExists('quote_items');
    }
};
