<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('cost_centers', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('name');

            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');

            $table->unsignedInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses');

            $table->string('senior_code')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cost_center');
    }
};
