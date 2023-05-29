<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('name');
            $table->string('cpf_cnpj');

            $table->unsignedInteger('cost_center_id');
            $table->foreign('cost_center_id')->references('id')->on('cost_centers');

            $table->date('birthdate')->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
