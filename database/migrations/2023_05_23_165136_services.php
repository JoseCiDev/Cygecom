<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->decimal('price', 14, 2)->nullable();
            $table->boolean('already_provided')->default(false);
            $table->boolean('is_finished')->default(false);
            $table->boolean('is_prepaid')->nulllable()->default(false);
            $table->unsignedInteger('quantity_of_installments')->nullable();

            $table->string('hours_performed')->nullable()->default(null);
            $table->string('seller')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->unsignedInteger('purchase_request_id');
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');

            $table->unsignedInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            $table->unsignedInteger('payment_info_id')->nullable();
            $table->foreign('payment_info_id')->references('id')->on('payment_infos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
