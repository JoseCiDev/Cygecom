<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('postal_code')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('neighborhood')->nullable()->change();
            $table->string('street')->nullable()->change();
            $table->string('street_number')->nullable()->change();
            $table->string('complement')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('postal_code')->nullable(false)->change();
            $table->string('state')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('neighborhood')->nullable(false)->change();
            $table->string('street')->nullable(false)->change();
            $table->string('street_number')->nullable(false)->change();
            $table->string('complement')->nullable(false)->change();
        });
    }
};
