<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\{PaymentTerm, PaymentMethod};

class PaymentInfo extends Model
{
    use HasFactory, LogObserverTrait;

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function service()
    {
        return $this->hasOne(Service::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
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
        'payment_method',
        'description',
        'payment_terms',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'payment_method' => PaymentMethod::class,
        'payment_terms' => PaymentTerm::class
    ];
}
