<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function installments()
    {
        return $this->hasMany(ServiceInstallment::class);
    }

    public function paymentInfo()
    {
        return $this->belongsTo(PaymentInfo::class, 'payment_info_id');
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
        'is_prepaid',
        'already_provided',
        'local_service',
        'price',
        'quantity_of_installments',
        'hours_performed',
        'seller',
        'email',
        'phone',
        'purchase_request_id',
        'supplier_id',
        'payment_info_id',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
}
