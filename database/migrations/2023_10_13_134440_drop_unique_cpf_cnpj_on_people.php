<?php

use App\Models\Person;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropUnique('people_cpf_cnpj_UNIQUE');
        });
    }

    public function down(): void
    {
    }
};
