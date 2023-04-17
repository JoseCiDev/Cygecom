<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\PersonService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PersonService::class, function ($app) {
            return new PersonService($app);
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
