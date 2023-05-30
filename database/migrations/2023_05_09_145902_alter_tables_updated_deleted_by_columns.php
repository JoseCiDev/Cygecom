<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->unsignedInteger('deleted_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->unsignedInteger('deleted_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::table('people', function (Blueprint $table) {
            $table->unsignedInteger('deleted_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['deleted_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn('deleted_by');
            $table->dropColumn('updated_by');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropForeign(['deleted_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn('deleted_by');
            $table->dropColumn('updated_by');
        });

        Schema::table('people', function (Blueprint $table) {
            $table->dropForeign(['deleted_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn('deleted_by');
            $table->dropColumn('updated_by');
        });
    }
};
