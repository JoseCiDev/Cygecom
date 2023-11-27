<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function abilities()
    {
        return $this->belongsToMany(Ability::class, 'abilities_profiles', 'user_profile_id', 'ability_id');
    }
}
