<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number', 15)->index();
            $table->enum('phone_type', ['personal', 'commercial'])->nullable();

            $table->unsignedInteger('person_id')->nullable();
            $table->foreign('person_id')->references('id')->on('people');

            $table->unsignedInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            $table->dateTime('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phones');
    }
};
