<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public function cost_center()
    {
        return $this->hasOne(CostCenter::class);
    }
    public function supplier()
    {
        return $this->hasOne(Supplier::class);
    }

    public function deleted_by()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected $fillable = [
        'street',
        'street_number',
        'neighborhood',
        'postal_code',
        'city',
        'state',
        'country',
        'complement',
    ];
}
