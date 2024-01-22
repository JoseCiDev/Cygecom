<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    use HasFactory, LogObserverTrait;

    public function profiles()
    {
        return $this->belongsToMany(UserProfile::class, 'abilities_profiles', 'ability_id', 'user_profile_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'abilities_users', 'ability_id', 'user_id');
    }

    protected $fillable = ['id', 'name', 'description'];

    public $timestamps = false;
}
