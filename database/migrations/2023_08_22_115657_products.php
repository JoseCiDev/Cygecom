<?php

use App\Models\{PurchaseRequest, PaymentInfo};
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{Schema, DB};

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->boolean('already_purchased')->default(false);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->string('seller')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->decimal('amount', 14, 2)->nullable();
            $table->unsignedInteger('quantity_of_installments')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreignIdFor(PurchaseRequest::class)->constrained('purchase_requests');

            $table->foreignIdFor(PaymentInfo::class)->nullable()->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
