<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public function person()
    {
        return $this->belongsTo(Person::class);
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