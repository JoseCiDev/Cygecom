<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    public function person()
    {
        return $this->belongsToMany(Person::class);
    }
    public function supplier()
    {
        return $this->belongsToMany(Supplier::class);
    }
    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    protected $fillable = [
        'number',
        'phone_type',
    ];
}
