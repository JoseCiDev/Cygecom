<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function purchaseQuote()
    {
        return $this->belongsTo(PurchaseQuote::class);
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
