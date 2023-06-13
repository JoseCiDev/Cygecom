<?php

namespace App\Providers;

use App\Providers\{ProductService, UserService, ValidatorService};
use App\Services\QuotationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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

        $this->app->singleton(QuotationService::class, function ($app) {
            return new QuotationService($app);
        });
    }
}
