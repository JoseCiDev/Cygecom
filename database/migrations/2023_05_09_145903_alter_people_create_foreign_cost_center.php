<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->unsignedInteger('cost_center_id')->nullable();
            $table->foreign('cost_center_id')->references('id')->on('cost_centers');
        });
    }

    public function down()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropForeign(['cost_center_id']);
            $table->dropColumn('cost_center_id');
        });
    }
};
