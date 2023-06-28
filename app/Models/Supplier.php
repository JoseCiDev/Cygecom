<?php

namespace App\Models;

use App\Enums\SupplierQualificationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    public function purchaseRequestProduct()
    {
        return $this->belongsTo(PurchaseRequestProduct::class, 'purchase_request_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function phone()
    {
        return $this->belongsTo(Phone::class, 'phone_id');
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
        'corporate_name',
        'cpf_cnpj',
        'entity_type',
        'market_type',
        'supplier_indication',
        'qualification',
        'address_id',
        'phone_id',
        'name',
        'description',
        'state_registration',
        'email',
        'representative',
        'supplier_type_callisto',
        'payment_type_callisto',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    protected $casts = [
        'qualification' => SupplierQualificationStatus::class,
    ];
}
