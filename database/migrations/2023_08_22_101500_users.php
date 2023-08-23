<?php

use App\Models\{Person, User, UserProfile};
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_buyer')->default(false);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->decimal('approve_limit', 14, 2)->nullable()->default(100);
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreignIdFor(UserProfile::class)->constrained();
            $table->foreignIdFor(Person::class)->unique()->constrained();
            $table->foreignIdFor(User::class, 'approver_user_id')->nullable()->constrained('users');

            $table->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained('users');
            $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
