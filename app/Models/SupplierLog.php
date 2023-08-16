<?php

namespace App\Models;

use App\Enums\LogAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierLog extends Model
{
    use HasFactory;

    protected $table = 'suppliers_log';

    public function changedSupplierUser()
    {
        return $this->belongsTo(User::class, 'changed_supplier_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $fillable = [
        'changed_supplier_id',
        'action',
        'user_id',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
        'action' => LogAction::class,
    ];
}
