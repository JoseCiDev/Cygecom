<?php

use App\Models\{CostCenter, User};
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('user_cost_center_permissions', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->constrained('users');
            $table->foreignIdFor(CostCenter::class)->constrained();

            $table->unique(['user_id', 'cost_center_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_cost_center_permissions');
    }
};
