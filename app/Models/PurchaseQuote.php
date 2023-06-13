<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseQuote extends Model
{
    use HasFactory;

    public function quoteFile()
    {
        return $this->hasMany(QuoteFile::class);
    }
    public function quoteItem()
    {
        return $this->hasMany(QuoteItem::class);
    }
    public function service()
    {
        return $this->hasMany(Service::class);
    }

    public function quoteRequest()
    {
        return $this->belongsTo(QuoteRequest::class);
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
        'quote_request_id',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
}
