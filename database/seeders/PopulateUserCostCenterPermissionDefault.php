<?php

namespace Database\Seeders;

use App\Models\UserCostCenterPermission;
use Illuminate\Database\Seeder;

class PopulateUserCostCenterPermissionDefault extends Seeder
{
    /**
     * @abstract Para userId = 1 (administrador) dá acesso a todos centros de custos
     */
    public function run(): void
    {
        $userId = 1;
        $costCenterIds = range(1, 70);

        $userCostCenterPermissions = array_map(function ($costCenterId) use ($userId) {
            return [
                'user_id' => $userId,
                'cost_center_id' => $costCenterId,
            ];
        }, $costCenterIds);

        UserCostCenterPermission::insert($userCostCenterPermissions);
    }
}
