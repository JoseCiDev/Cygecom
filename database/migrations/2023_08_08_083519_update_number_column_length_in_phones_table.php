<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('phones', function (Blueprint $table) {
            $table->string('number', 20)->change();
            $table->boolean('isInternational')->default(false);
        });
    }

    public function down()
    {
        Schema::table('phones', function (Blueprint $table) {
            $table->string('number', 15)->change();
            $table->dropColumn('isInternational');
        });
    }
};
