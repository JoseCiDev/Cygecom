<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('number', 15);
            $table->enum('phone_type', ['personal', 'commercial'])->nullable();

            $table->unsignedInteger('person_id')->nullable();
            $table->foreign('person_id')->references('id')->on('people');

            $table->unsignedInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            $table->unsignedInteger('cost_center_id')->nullable();
            $table->foreign('cost_center_id')->references('id')->on('cost_centers');

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->unsignedInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');

            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phones');
    }
};
