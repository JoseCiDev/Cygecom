<?php

use App\Models\Phone;
use App\Models\CostCenter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->unsignedBigInteger('cost_center_id')->nullable()->change();
            $table->unsignedBigInteger('phone_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->unsignedBigInteger('cost_center_id')->nullable(false)->change();
            $table->unsignedBigInteger('phone_id')->nullable(false)->change();
        });
    }
};
