<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequestFile extends Model
{
    use HasFactory;

    public function quoteRequest()
    {
        return $this->belongsTo(QuoteRequest::class);
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
        'path',
        'quote_request_id',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];
}
