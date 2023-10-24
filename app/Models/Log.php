<?php

namespace App\Models;

use App\Enums\LogAction;
use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};

class Log extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    protected $fillable = [
        'table',
        'foreign_id',
        'user_id',
        'action',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
        'action' => LogAction::class,
        'created_at' => 'datetime',
    ];

    public $timestamps = false;
}
