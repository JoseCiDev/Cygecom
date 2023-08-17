<?php

namespace App\Models;

use App\Enums\LogAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $table = 'users_log';

    public function changedUser()
    {
        return $this->belongsTo(User::class, 'changed_user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $fillable = [
        'changed_user_id',
        'action',
        'user_id',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
        'action' => LogAction::class,
    ];
}
