<?php

namespace App\Models;

use App\Enums\LogAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonLog extends Model
{
    use HasFactory;

    protected $table = 'people_log';

    public function changedPerson()
    {
        return $this->belongsTo(User::class, 'changed_person_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $fillable = [
        'changed_person_id',
        'action',
        'user_id',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
        'action' => LogAction::class,
    ];
}
