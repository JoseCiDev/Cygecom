<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory;

    public function purchaseQuote()
    {
        return $this->hasMany(PurchaseQuote::class);
    }
    public function quoteRequestFile()
    {
        return $this->hasMany(QuoteRequestFile::class);
    }
    public function costCenterApportionment()
    {
        return $this->hasMany(CostCenterApportionment::class);
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
        'is_supplies_quote',
        'is_comex',
        'is_service',
        'local_description',
        'reason',
        'user_id',
        'description',
        'desired_date',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
}
