<?php

namespace App\Models;

use App\Enums\PurchaseRequestLogAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestsLog extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function purchaseRequest()
    {
        return $this->hasOne(PurchaseRequest::class);
    }

    protected $table = 'purchase_requests_log';

    protected $fillable = [
        'purchase_request_id',
        'action',
        'user_id',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
        'action' => PurchaseRequestLogAction::class,
    ];
}
