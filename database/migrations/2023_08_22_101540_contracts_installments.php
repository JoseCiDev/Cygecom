<?php

use App\Models\{Contract, User};
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('contract_installments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->decimal('value', 14, 2)->nullable();
            $table->date('expire_date')->nullable();
            $table->text('observation')->nullable();
            $table->text('status')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreignIdFor(Contract::class)->nullable()->constrained();

            $table->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained('users');
            $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_installments');
    }
};
