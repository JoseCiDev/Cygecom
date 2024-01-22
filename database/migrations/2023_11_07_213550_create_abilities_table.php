<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{User, UserProfile, Ability};

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abilities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
        });

        Schema::create('abilities_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(UserProfile::class)->constrained('user_profiles')->onDelete('cascade');
            $table->foreignIdFor(Ability::class)->constrained('abilities')->onDelete('cascade');

            $table->unique(['user_profile_id', 'ability_id']);
        });

        Schema::create('abilities_users', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->constrained('users');
            $table->foreignIdFor(Ability::class)->constrained('abilities');

            $table->unique(['user_id', 'ability_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abilities_profiles');
        Schema::dropIfExists('abilities_users');
        Schema::dropIfExists('abilities');
    }
};
