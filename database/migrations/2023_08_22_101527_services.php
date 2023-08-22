<?php

use App\Models\{PaymentInfo, Supplier, User, PurchaseRequest};
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->boolean('already_provided')->default(false);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->decimal('price', 14, 2)->nullable();
            $table->unsignedInteger('quantity_of_installments')->nullable();
            $table->string('hours_performed')->nullable()->default(null);
            $table->string('seller')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreignIdFor(PurchaseRequest::class)->constrained('purchase_requests');

            $table->foreignIdFor(Supplier::class)->nullable()->constrained();
            $table->foreignIdFor(PaymentInfo::class)->nullable()->constrained();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained('users');
            $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
