<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_installments', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->decimal('value', 14, 2)->nullable();

            $table->date('expire_date')->nullable();
            $table->text('observation')->nullable();
            $table->text('status')->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_installments');
    }
};
