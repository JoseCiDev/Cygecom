<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractInstallment extends Model
{
    use HasFactory;

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
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
        'payment_day',
        'description',
        'hours_performed',
        'already_provided',
        'contract_id',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
}
