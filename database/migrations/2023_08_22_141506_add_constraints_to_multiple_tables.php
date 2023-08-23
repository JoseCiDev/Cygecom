<?php

use App\Models\User;
use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $tables = ['people', 'suppliers', 'addresses', 'phones'];

    public function up()
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained('users');
                $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained('users');
            });
        }
    }

    public function down()
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropForeign(['deleted_by']);
                $table->dropForeign(['updated_by']);
            });
        }
    }
};
