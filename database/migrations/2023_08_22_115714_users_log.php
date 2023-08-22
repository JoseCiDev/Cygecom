<?php

use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{Schema, DB};

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('changed_user_id');
            $table->unsignedInteger('user_id');
            $table->enum('action', ['create', 'update', 'delete']);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->jsonb('changes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_log');
    }
};
