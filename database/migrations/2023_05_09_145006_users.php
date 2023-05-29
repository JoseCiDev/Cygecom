<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_buyer')->default(false);

            $table->unsignedInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('user_profiles');

            $table->unsignedInteger('person_id')->unique();
            $table->foreign('person_id')->references('id')->on('people');

            $table->unsignedInteger('approver_user_id')->nullable();
            $table->foreign('approver_user_id')->references('id')->on('users');

            $table->decimal('approve_limit', 14, 2)->nullable()->default(null);

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
        Schema::dropIfExists('users');
    }
};
