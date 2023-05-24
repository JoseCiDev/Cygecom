<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('corporate_name');
            $table->boolean('is_qualified')->default(false);
            $table->string('cnpj');

            $table->unsignedInteger('address_id')->unique();
            $table->foreign('address_id')->references('id')->on('addresses');

            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('state_registration')->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
