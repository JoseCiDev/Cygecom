<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierLog extends Model
{
    use HasFactory;

    protected $table = 'suppliers_log';

    protected $fillable = [
        'changed_supplier_id',
        'action',
        'user_id',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];
}
