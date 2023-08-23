<?php

use App\Models\ProductCategory;
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{DB, Schema};

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_suggestions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreignIdFor(ProductCategory::class)->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_suggestions');
    }
};
