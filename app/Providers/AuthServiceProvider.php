<?php

namespace App\Providers;

use App\Models\{User, Ability};
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $abilities = Ability::all();
        foreach ($abilities as $ability) {
            Gate::define($ability->name, function (User $user) use ($ability) {
                $hasProfileAbility = $user->profile->abilities->pluck('name')->contains($ability->name);
                $hasUserAbility = $user->abilities->pluck('name')->contains($ability->name);
                return $hasProfileAbility || $hasUserAbility;
            });
        }
    }
}
