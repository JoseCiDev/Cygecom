<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->unsignedInteger('supplies_user_id')->nullable();
            $table->foreign('supplies_user_id')->references('id')->on('users')->onDelete('set null');
            $table->dateTime('responsibility_marked_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->dropForeign(['supplies_user_id']);
            $table->dropColumn('supplies_user_id');
            $table->dropColumn('responsibility_marked_at');
        });
    }
};
