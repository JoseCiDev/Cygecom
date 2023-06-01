<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_cost_center_permissions', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('cost_center_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cost_center_id')->references('id')->on('cost_centers')->onDelete('cascade');

            $table->unique(['user_id', 'cost_center_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_cost_center_permissions');
    }
};
