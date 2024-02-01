<?php

use App\Enums\CompanyGroup;
use App\Models\{User, CostCenter};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('supplies_cost_centers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users');
            $table->foreignIdFor(CostCenter::class)->constrained('cost_centers');
            $table->unique(['user_id', 'cost_center_id']);
        });

        $costCentersInp = CostCenter::select('id')->whereHas('company', fn ($query) => $query->where('group', CompanyGroup::INP))->pluck('id');
        $costCentersHkm = CostCenter::select('id')->whereHas('company', fn ($query) => $query->where('group', CompanyGroup::HKM))->pluck('id');

        User::whereIn('user_profile_id', function ($query) {
            $query->select('id')->from('user_profiles')->where('name', 'suprimentos_inp');
        })->each(function ($user) use ($costCentersInp) {
            $user->suppliesCostCenters()->sync($costCentersInp);
        });

        User::whereIn('user_profile_id', function ($query) {
            $query->select('id')->from('user_profiles')->where('name', 'suprimentos_hkm');
        })->each(function ($user) use ($costCentersHkm) {
            $user->suppliesCostCenters()->sync($costCentersHkm);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplies_cost_centers');
    }
};
