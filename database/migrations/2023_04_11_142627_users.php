<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // $table->string('name'); // Avaliar remoção
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); // Avaliar remoção
            $table->string('password');

            $table->unsignedBigInteger('profile_id')->index();
            $table->foreign('profile_id')->references('id')->on('user_profiles');

            $table->unsignedBigInteger('person_id')->index();
            $table->foreign('person_id')->references('id')->on('people');

            $table->unsignedBigInteger('approver_user_id')->nullable();
            $table->foreign('approver_user_id')->references('id')->on('users');

            $table->decimal('approve_limit');

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
