<?php

namespace Database\Seeders\Inserts;

use App\Models\CostCenter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertOnCostCenters extends Seeder
{
    public function run(): void
    {
        $newCostCenters = require(__DIR__ . "/data/cost-centers-to-insert.php");

        DB::transaction(function () use ($newCostCenters) {
            foreach ($newCostCenters as $newCostCenter) {
                CostCenter::updateOrCreate(['id' => $newCostCenter['id']], $newCostCenter);
            }
        });
    }
}
