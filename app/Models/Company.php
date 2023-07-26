<?php

namespace App\Models;

use App\Enums\CompanyGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function costCenter()
    {
        return $this->hasMany(CostCenter::class);
    }

    protected $casts = [
        'group' => CompanyGroup::class,
    ];
}
