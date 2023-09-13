<?php

use App\Models\CostCenter;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        CostCenter::create([
            'name' => 'Limpeza',
            'company_id' => 12,
        ]);
    }

    public function down()
    {
        CostCenter::where('name', 'Limpeza')->delete();
    }
};
