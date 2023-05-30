<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    use HasFactory;

    public function purchaseQuote()
    {
        return $this->belongsTo(PurchaseQuote::class, 'purchase_quote_id');
    }
    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_id');
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
