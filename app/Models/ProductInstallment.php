<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInstallment extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
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
        'value',
        'already_provided',
        'expire_date',
        'observation',
        'status',
        'product_id',
    ];
}
