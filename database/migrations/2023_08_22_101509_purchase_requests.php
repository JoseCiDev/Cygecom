<?php

use App\Models\User;
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{DB, Schema};

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();

            $table->enum('status', [
                'rascunho', 'pendente', 'em_tratativa', 'em_cotacao',
                'aguardando_aprovacao_de_compra', 'compra_efetuada', 'finalizada', 'cancelada'
            ])->default('rascunho');

            $table->enum('type', ['service', 'contract', 'product']);
            $table->boolean('is_comex')->default(false);
            $table->boolean('is_supplies_contract')->default(true);
            $table->text('description');
            $table->text('local_description');
            $table->text('reason');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->text('support_links')->nullable();
            $table->text('observation')->nullable();
            $table->date('desired_date')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->dateTime('responsibility_marked_at')->nullable();

            $table->foreignIdFor(User::class)->constrained('users');

            $table->foreignIdFor(User::class, 'supplies_user_id')->nullable()->constrained('users');
            $table->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained('users');
            $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
