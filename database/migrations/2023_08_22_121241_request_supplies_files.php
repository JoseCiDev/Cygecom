<?php

use App\Models\{User, PurchaseRequest};
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{DB, Schema};

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_supplies_files', function (Blueprint $table) {
            $table->id();
            $table->text('path');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->string('original_name')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreignIdFor(PurchaseRequest::class)->constrained('purchase_requests');
            $table->foreignIdFor(User::class, 'updated_by')->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_supplies_files');
    }
};
