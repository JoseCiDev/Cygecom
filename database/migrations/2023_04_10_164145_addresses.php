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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street');
            $table->string('street_number');
            $table->string('neighborhood');
            $table->string('postal_code');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('complement')->nullable();
            // $table->unsignedBigInteger('supplier_id')->nullable();
            // $table->foreign('supplier_id')->references('id')->on('suppliers');
            // $table->unsignedBigInteger('person_id')->nullable();
            // $table->foreign('person_id')->references('id')->on('persons');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
