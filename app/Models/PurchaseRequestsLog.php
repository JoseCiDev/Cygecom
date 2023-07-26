<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestsLog extends Model
{
    use HasFactory;

    protected $table = 'purchase_requests_log';

    protected $fillable = [
        'purchase_request_id',
        'action',
        'user_id',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];
}
