<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory;

    public function purchase_quote()
    {
        return $this->hasMany(PurchaseQuote::class);
    }
    public function quote_request_file()
    {
        return $this->hasMany(QuoteRequestFile::class);
    }
    public function cost_center_apportionment()
    {
        return $this->hasMany(CostCenterApportionment::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_id');
    }

    public function deleted_by()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
