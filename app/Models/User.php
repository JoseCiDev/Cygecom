<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_user_id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function profile()
    {
        return $this->belongsTo(UserProfile::class, 'profile_id');
    }

    public function quoteRequest()
    {
        return $this->hasMany(QuoteRequest::class);
    }

    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedMany()
    {
        return $this->hasMany(User::class);
    }
    public function updatedMany()
    {
        return $this->hasMany(User::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'is_buyer',
        'profile_id',
        'person_id',
        'approver_user_id',
        'approve_limit',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
