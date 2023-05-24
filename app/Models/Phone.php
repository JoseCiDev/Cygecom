<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    public function person()
    {
        return $this->belongsToMany(Person::class);
    }
    public function supplier()
    {
        return $this->belongsToMany(Supplier::class);
    }
    public function cost_center()
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function deleted_by()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    protected $fillable = [
        'number',
        'phone_type',
    ];
}
