<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cost_center_apportionments', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('apportionment_percentage', 20)->nullable();
            $table->decimal('apportionment_value', 14, 2)->nullable();

            $table->unsignedInteger('quote_request_id')->unique();
            $table->foreign('quote_request_id')->references('id')->on('quote_requests');

            $table->unsignedInteger('cost_center_id')->unique();
            $table->foreign('cost_center_id')->references('id')->on('cost_centers');

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->unsignedInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');

            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cost_center_apportionment');
    }
};
