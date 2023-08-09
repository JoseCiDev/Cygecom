<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonLog extends Model
{
    use HasFactory;

    protected $table = 'people_log';

    protected $fillable = [
        'changed_person_id',
        'action',
        'user_id',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];
}
