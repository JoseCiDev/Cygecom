<?php

use App\Models\Service;
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{Schema, DB};

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_installments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->decimal('value', 14, 2)->nullable();
            $table->date('expire_date')->nullable();
            $table->text('observation')->nullable();
            $table->text('status')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreignIdFor(Service::class)->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_installments');
    }
};
