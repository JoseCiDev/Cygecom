<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function servicePaymentInfo()
    {
        return $this->hasMany(ServicePaymentInfo::class);
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
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
        'description',
        'payday',
        'is_finished',
        'local_service',
        'price',
        'hours_performed',
        'purchase_request_id',
        'supplier_id',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
}
