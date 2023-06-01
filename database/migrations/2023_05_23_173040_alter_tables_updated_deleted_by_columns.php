<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private function addAuditColumns($table)
    {
        $table->unsignedInteger('deleted_by')->nullable();
        $table->unsignedInteger('updated_by')->nullable();
        $table->foreign('deleted_by')->references('id')->on('users');
        $table->foreign('updated_by')->references('id')->on('users');
    }

    private function dropAuditColumns($table)
    {
        $table->dropForeign(['deleted_by']);
        $table->dropForeign(['updated_by']);
        $table->dropColumn('deleted_by');
        $table->dropColumn('updated_by');
    }

    private function applyChangesToTable($tableName, $changes)
    {
        Schema::table($tableName, function (Blueprint $table) use ($changes) {
            $changes($table);
        });
    }

    public function up()
    {
        $tables = [
            'addresses', 'suppliers', 'people', 'quote_requests', 'quote_request_files',
            'purchase_quotes', 'quote_files', 'phones', 'products', 'services',
            'cost_center_apportionments', 'quote_items',
        ];

        foreach ($tables as $table) {
            $this->applyChangesToTable($table, function (Blueprint $table) {
                $this->addAuditColumns($table);
            });
        }
    }

    public function down()
    {
        $tables = [
            'addresses', 'suppliers', 'people', 'quote_requests', 'quote_request_files',
            'purchase_quotes', 'quote_files', 'phones', 'products', 'services',
            'cost_center_apportionments', 'quote_items',
        ];

        foreach ($tables as $table) {
            $this->applyChangesToTable($table, function (Blueprint $table) {
                $this->dropAuditColumns($table);
            });
        }
    }
};
