<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class () extends Migration {
    public function up(): void
    {
        // Schema::create('products', function (Blueprint $table) {
        //     $table->unsignedInteger('id')->autoIncrement();
        //     $table->string('name');
        //     $table->decimal('unit_price', 14, 2)->nullable();

        //     $table->text('description')->nullable();

        //     $table->unsignedInteger('product_categorie_id')->nullable()->default(null);
        //     $table->foreign('product_categorie_id')->references('id')->on('product_categories');

        //     $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        //     $table->dateTime('updated_at')->nullable();
        //     $table->dateTime('deleted_at')->nullable();

        //     $table->unique(['name', 'product_categorie_id']);
        // });
    }

    public function down(): void
    {
        // Schema::dropIfExists('products');
    }
};
