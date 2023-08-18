<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceInstallment extends Model
{
    use HasFactory;

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
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
        'expire_date',
        'value',
        'observation',
        'status',
        'service_id',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
}
