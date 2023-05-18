<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'deleted_by', 'updated_by'];

    public function person()
    {
        return $this->hasMany(Person::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
