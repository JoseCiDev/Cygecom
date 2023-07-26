<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->enum('status', [
                'rascunho', 'pendente', 'em_tratativa', 'em_cotacao',
                'aguardando_aprovacao_de_compra', 'compra_efetuada', 'finalizada', 'cancelada'
            ])->default('rascunho');
        });
    }

    public function down(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->enum('status', [
                'pendente', 'em_tratativa', 'em_cotacao', 'aguardando_aprovacao_de_compra',
                'compra_efetuada', 'finalizada', 'cancelada'
            ])->default('pendente');
        });
    }
};
