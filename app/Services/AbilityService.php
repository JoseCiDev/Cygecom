<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class AbilityService
{
    /**
     * Separa habilidades em grupos de get, api, post, delete e authorize
     */
    public function groupAbilities(Collection $abilities): Collection
    {
        return $abilities->groupBy(function ($ability) {
            $name = $ability->name;
            if (str_contains($name, '.api.') && !str_contains($name, 'delete')) {
                return 'api';
            }

            $firstName = explode('.', $name)[0];
            return in_array($firstName, ['get', 'post', 'delete']) ? $firstName : 'authorize';
        });
    }
}
