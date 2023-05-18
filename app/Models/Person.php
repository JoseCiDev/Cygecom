<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function address()
    {
        return $this->hasOne(Address::class);
    }
    public function phone()
    {
        return $this->hasOne(Phone::class);
    }
    public function identification()
    {
        return $this->hasOne(IdentificationDocuments::class);
    }
    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }

    protected $fillable = [
        'name',
        'birthdate',
        'cost_center_id',
    ];
}
