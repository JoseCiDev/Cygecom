<?php

use App\Models\{PaymentInfo, PurchaseRequest, Supplier, User};
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->boolean('is_active')->default(true);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->unsignedInteger('payday')->nullable();
            $table->unsignedInteger('quantity_of_installments')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('recurrence', ['unique', 'monthly', 'yearly'])->nullable();
            $table->boolean('is_fixed_payment')->nullable()->default(null);
            $table->string('seller')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->decimal('amount', 14, 2)->nullable();
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
        Schema::dropIfExists('contracts');
    }
};
