<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();

            $table->enum('status', ['pending', 'approved', 'disapproved'])->default('pending');
            $table->enum('type', ['service', 'contract', 'product']);
            $table->boolean('is_comex')->default(false);
            $table->boolean('is_supplies_contract')->default(true);
            $table->text('description');
            $table->text('local_description');
            $table->text('reason');

            $table->text('observation')->nullable();
            $table->date('desired_date')->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
