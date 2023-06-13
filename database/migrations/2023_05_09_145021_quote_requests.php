<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();

            $table->enum('status', ['pending', 'processing', 'completed'])->default('pending');
            $table->boolean('is_supplies_quote')->default(false);
            $table->boolean('is_comex')->default(false);
            $table->boolean('is_service')->default(false);
            $table->text('local_description');
            $table->text('reason');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->text('description')->nullable()->when('is_supplies_quote', function ($query) {
                $query->requiredIf(true);
            });

            $table->date('desired_date')->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
