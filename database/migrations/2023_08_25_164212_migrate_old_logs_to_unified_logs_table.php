<?php

use Illuminate\Database\{Migrations\Migration, Schema\Blueprint};
use Illuminate\Support\Facades\{DB, Schema};

return new class extends Migration
{
    const ACTIONS = ['create', 'update', 'delete'];

    const TABLE_FOREIGN_KEYS = [
        'purchase_requests_log' => ['foreignIdKey' => 'purchase_request_id', 'tableName' => 'purchase_requests'],
        'users_log' => ['foreignIdKey' => 'changed_user_id', 'tableName' => 'users'],
        'people_log' => ['foreignIdKey' => 'changed_person_id', 'tableName' => 'people'],
        'suppliers_log' => ['foreignIdKey' => 'changed_supplier_id', 'tableName' => 'suppliers'],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->migrateTables();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->reverseMigrateTables();
    }

    protected function migrateTables()
    {
        foreach (self::TABLE_FOREIGN_KEYS as $oldTableName => $oldTableProperties) {
            $oldTableProperties = (object) $oldTableProperties;
            $foreignIdKey = $oldTableProperties->foreignIdKey;
            $oldLogs = DB::table($oldTableName)->get();

            foreach ($oldLogs as $oldLog) {
                DB::table('logs')->insert([
                    'table' => $oldTableProperties->tableName,
                    'foreign_id' => $oldLog->$foreignIdKey,
                    'user_id' => $oldLog->user_id,
                    'action' => $oldLog->action,
                    'changes' => $oldLog->changes,
                    'created_at' => $oldLog->created_at,
                ]);
            }

            Schema::dropIfExists($oldTableName);
        }
    }

    protected function reverseMigrateTables()
    {
        foreach (self::TABLE_FOREIGN_KEYS as $oldTableName => $oldTableProperties) {
            $oldTableProperties = (object) $oldTableProperties;
            $foreignIdKey = $oldTableProperties->foreignIdKey;

            Schema::create($oldTableName, function (Blueprint $table) use ($foreignIdKey) {
                $table->id();
                $table->unsignedInteger($foreignIdKey);
                $table->unsignedInteger('user_id');
                $table->enum('action', self::ACTIONS);
                $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                $table->jsonb('changes')->nullable();
            });
        }
    }
};
