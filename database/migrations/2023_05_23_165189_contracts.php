<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('name', 255)->unique();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('payday')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('recurrence', ['unique', 'monthly', 'yearly'])->default('monthly');
            $table->boolean('is_fixed_payment')->nullable()->default(null);
            $table->boolean('is_prepaid')->nullable()->deafult(false);

            $table->string('seller')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->decimal('amount', 14, 2)->nullable();
            $table->unsignedInteger('quantity_of_installments')->nullable();

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
        Schema::dropIfExists('contracts');
    }
};
