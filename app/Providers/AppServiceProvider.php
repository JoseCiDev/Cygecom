<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton(ValidatorService::class, function ($app) {
            return new ValidatorService($app);
        });
        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService($app);
        });
        $this->app->singleton(SuppplierService::class, function ($app) {
            return new SuppplierService($app);
        });
        $this->app->singleton(QuoteRequestService::class, function ($app) {
            return new QuoteRequestService($app);
        });
    }
}
