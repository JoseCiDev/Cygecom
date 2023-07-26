<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class S3ServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('S3', function ($app) {
            return new \App\Services\S3();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
