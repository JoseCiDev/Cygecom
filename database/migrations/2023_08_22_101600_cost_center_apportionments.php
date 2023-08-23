<?php

use App\Models\{CostCenter, PurchaseRequest, User};
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('cost_center_apportionments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->string('apportionment_percentage', 20)->nullable();
            $table->decimal('apportionment_currency', 14, 2)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreignIdFor(PurchaseRequest::class)->constrained('purchase_requests');
            $table->foreignIdFor(CostCenter::class)->constrained();

            $table->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained('users');
            $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained('users');

            $table->unique(['purchase_request_id', 'cost_center_id'], 'unique_purchase_request_cost_center');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cost_center_apportionments');
    }
};
