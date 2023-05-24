<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');

            $table->unsignedInteger('profile_id')->index();
            $table->foreign('profile_id')->references('id')->on('user_profiles');

            $table->unsignedInteger('person_id')->index();
            $table->foreign('person_id')->references('id')->on('people');

            $table->unsignedInteger('approver_user_id')->nullable();
            $table->foreign('approver_user_id')->references('id')->on('users');

            $table->decimal('approve_limit', 14, 2)->nullable()->default(0);

            $table->dateTime('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
