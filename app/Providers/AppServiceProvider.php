<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService($app);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
