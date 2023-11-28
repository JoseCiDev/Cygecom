<?php

namespace App\Models;

use App\Enums\{PurchaseRequestStatus, PurchaseRequestType};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory, LogObserverTrait;

    public function purchaseRequestFile()
    {
        return $this->hasMany(PurchaseRequestFile::class);
    }

    public function requestSuppliesFiles()
    {
        return $this->hasMany(RequestSuppliesFiles::class);
    }

    public function service()
    {
        return $this->hasOne(Service::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }

    public function costCenterApportionment()
    {
        return $this->hasMany(CostCenterApportionment::class, 'purchase_request_id');
    }

    public function purchaseRequestProduct()
    {
        return $this->hasMany(PurchaseRequestProduct::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'foreign_id', 'id')->where('table', 'purchase_requests');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function suppliesUser()
    {
        return $this->belongsTo(User::class, 'supplies_user_id');
    }

    public function requester()
    {
        return $this->belongsTo(Person::class, 'requester_person_id');
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
        'is_comex',
        'local_description',
        'is_supplies_contract',
        'reason',
        'user_id',
        'description',
        'observation',
        'desired_date',
        'support_links',
        'supplies_user_id',
        'supplies_update_reason',
        'responsibility_marked_at',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'is_only_quotation',
        'requester_person_id',
        'purchase_order'
    ];

    protected $casts = [
        'status' => PurchaseRequestStatus::class,
        'type' => PurchaseRequestType::class,
    ];
}
