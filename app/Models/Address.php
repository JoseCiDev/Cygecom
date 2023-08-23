<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public function supplier()
    {
        return $this->hasOne(Supplier::class);
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
        'street',
        'street_number',
        'neighborhood',
        'postal_code',
        'city',
        'state',
        'country',
        'complement',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
}
