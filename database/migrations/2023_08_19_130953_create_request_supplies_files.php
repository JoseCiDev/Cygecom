<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_supplies_files', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();

            $table->text('path');
            $table->string('original_name')->nullable();

            $table->unsignedInteger('purchase_request_id');
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');

            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_supplies_files');
    }
};
