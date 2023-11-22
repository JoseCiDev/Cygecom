<?php

namespace App\Services;

use App\Models\Person;
use Illuminate\Database\Eloquent\Builder;

class PersonService
{
    public function byUserId(int $id): Builder
    {
        return Person::whereHas('user', fn ($query) => $query->where('id', $id));
    }
}
