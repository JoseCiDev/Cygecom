<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('name', 255)->unique()->nullable();
        });
    }

    public function down()
    {
        if (Schema::hasColumn('services', 'name'))
        {
            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }

    }
};
