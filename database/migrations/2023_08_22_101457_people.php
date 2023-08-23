<?php

use App\Models\{CostCenter, Phone, User};
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cpf_cnpj', 20)->unique();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->date('birthdate')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreignIdFor(CostCenter::class)->constrained();
            $table->foreignIdFor(Phone::class)->unique()->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
