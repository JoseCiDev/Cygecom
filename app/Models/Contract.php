<?php

namespace App\Models;

use App\Enums\ContractRecurrence;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory, LogObserverTrait;

    public function installments()
    {
        return $this->hasMany(ContractInstallment::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'foreign_id', 'id')->where('table', 'contracts');
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
        'name',
        'is_active',
        'payday',
        'start_date',
        'end_date',
        'recurrence',
        'is_fixed_payment',
        'seller',
        'phone',
        'email',
        'amount',
        'quantity_of_installments',
        'purchase_request_id',
        'supplier_id',
        'payment_info_id',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    protected $casts = [
        'recurrence' => ContractRecurrence::class,
    ];
}
