<?php

namespace App\Providers;

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

        $this->app->singleton(SupplierService::class, function ($app) {
            return new SupplierService($app);
        });

        $this->app->singleton(PurchaseRequestService::class, function ($app) {
            return new PurchaseRequestService($app);
        });

        $this->app->singleton(CSVImporter::class, function ($app) {
            return new CSVImporter($app);
        });
    }
}
