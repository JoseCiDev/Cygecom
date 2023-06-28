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
        'payday',
        'description',
        'hours_performed',
        'start_date',
        'contract_id',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
}
