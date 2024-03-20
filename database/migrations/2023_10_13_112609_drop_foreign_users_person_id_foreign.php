<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_person_id_foreign');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('people');
        });
    }
};
