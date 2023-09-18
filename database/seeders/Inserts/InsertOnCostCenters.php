<?php

namespace Database\Seeders\Inserts;

use App\Models\CostCenter;
use Database\Seeders\Inserts\Data\CostCenterToInsert;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertOnCostCenters extends Seeder
{
    public function run(): void
    {
        $newCostCenters = CostCenterToInsert::getArray();

        DB::transaction(function () use ($newCostCenters) {
            foreach ($newCostCenters as $newCostCenter) {
                CostCenter::updateOrCreate(['id' => $newCostCenter['id']], $newCostCenter);
            }
        });
    }
}
