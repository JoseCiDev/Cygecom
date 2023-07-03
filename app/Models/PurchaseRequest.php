<?php

namespace App\Models;

use App\Enums\{PurchaseRequestStatus, PurchaseRequestType};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    public function purchaseRequestFile()
    {
        return $this->hasMany(PurchaseRequestFile::class);
    }

    public function service()
    {
        return $this->hasMany(Service::class);
    }

    public function contract()
    {
        return $this->hasMany(Contract::class);
    }

    public function costCenterApportionment()
    {
        return $this->hasMany(CostCenterApportionment::class);
    }

    public function purchaseRequestProduct()
    {
        return $this->belongsTo(PurchaseRequestProduct::class, 'purchase_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
        'status',
        'type',
        'is_supplies_quote',
        'is_comex',
        'local_description',
        'is_supplies_contract',
        'reason',
        'user_id',
        'description',
        'observation',
        'desired_date',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    protected $casts = [
        'status' => PurchaseRequestStatus::class,
        'type' => PurchaseRequestType::class,
    ];
}
