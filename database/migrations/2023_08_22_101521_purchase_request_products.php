<?php

use App\Models\{ProductCategory, Supplier, PurchaseRequest};
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{DB, Schema};

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_request_products', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->integer('quantity')->default(1);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->decimal('unit_price', 14, 2)->nullable();
            $table->string('model')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreignIdFor(PurchaseRequest::class)->constrained('purchase_requests');

            $table->foreignIdFor(Supplier::class)->nullable()->constrained();
            $table->foreignIdFor(ProductCategory::class)->nullable()->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_request_products');
    }
};
