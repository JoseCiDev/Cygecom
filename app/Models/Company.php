<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function costCenter()
    {
        return $this->hasMany(CostCenter::class);
    }
}
