<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('name', 255)->unique();
            $table->boolean('is_active')->default(true);
            $table->text('description');
            $table->date('payday');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('recurrence', ['unique', 'monthly', 'yearly'])->default('monthly');
            $table->boolean('is_fixed_payment')->default(false);
            $table->boolean('is_prepaid')->default(false);
            $table->text('local_service');

            $table->decimal('total_ammount', 14, 2)->nullable();
            $table->integer('quantity_of_installments')->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->unsignedInteger('purchase_request_id');
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');

            $table->unsignedInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            $table->unsignedInteger('payment_info_id')->nullable();
            $table->foreign('payment_info_id')->references('id')->on('payment_infos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
