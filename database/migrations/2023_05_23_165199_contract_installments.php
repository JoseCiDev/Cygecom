<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('contract_installments', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->decimal('value', 14, 2)->nullable();
            $table->boolean('already_provided')->default(false);

            $table->date('expire_date')->nullable();
            $table->text('observation')->nullable();
            $table->text('status')->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->unsignedInteger('contract_id');
            $table->foreign('contract_id')->references('id')->on('contracts');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_installments');
    }
};