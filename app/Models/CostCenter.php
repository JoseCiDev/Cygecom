<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory, LogObserverTrait;

    public function person()
    {
        return $this->hasMany(Person::class);
    }

    public function userCostCenterPermission()
    {
        return $this->hasMany(UserCostCenterPermission::class);
    }

    public function userPermissions()
    {
        return $this->belongsToMany(CostCenter::class, 'user_cost_center_permissions', 'cost_center_id', 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function suppliesUsers()
    {
        return $this->belongsToMany(CostCenter::class, 'supplies_cost_centers', 'cost_center_id', 'user_id');
    }

    public $timestamps = false;
    protected $fillable = ['name', 'company_id'];
}
