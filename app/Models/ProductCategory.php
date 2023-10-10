<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function productSugestion()
    {
        return $this->hasOne(ProductSugestion::class);
    }

    public function purchaseRequestProduct()
    {
        return $this->belongsTo(PurchaseRequestProduct::class, 'purchase_request_id');
    }

    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
