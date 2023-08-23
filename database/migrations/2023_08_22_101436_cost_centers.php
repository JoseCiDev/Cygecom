<?php

use App\Models\Company;
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('cost_centers', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->foreignIdFor(Company::class)->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cost_centers');
    }
};
