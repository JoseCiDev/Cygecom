<?php

use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{Schema, DB};

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('changed_person_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('action', ['create', 'update', 'delete']);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable()->default(onUpdateCurrentTimestamp());
            $table->text('changes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people_log');
    }
};