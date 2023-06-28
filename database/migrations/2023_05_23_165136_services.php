<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->text('description');
            $table->date('payday');
            $table->text('local_service');
            $table->decimal('price', 14, 2);

            $table->boolean('is_finished')->nullable()->default(false);
            $table->string('hours_performed')->nullable();
            $table->string('seller')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->unsignedInteger('purchase_request_id');
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');

            $table->unsignedInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
