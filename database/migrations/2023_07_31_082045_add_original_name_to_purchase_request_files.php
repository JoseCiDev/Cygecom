<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('purchase_request_files', function (Blueprint $table) {
            $table->string('original_name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('purchase_request_files', function (Blueprint $table) {
            $table->dropColumn('original_name');
        });
    }
};
