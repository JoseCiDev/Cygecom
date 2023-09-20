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

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public $timestamps = false;
    protected $fillable = ['name', 'company_id'];
}
