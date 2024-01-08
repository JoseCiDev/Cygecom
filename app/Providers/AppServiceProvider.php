<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
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

        $this->app->singleton(EmailService::class, function ($app) {
            return new EmailService($app);
        });

        $this->app->singleton(CSVImporter::class, function ($app) {
            return new CSVImporter($app);
        });
    }

    public function boot()
    {
        if(App::isProduction()) {
            \URL::forceScheme('https');
        }

        Carbon::macro('formatCustom', function ($format) {
            /**
             * @var Carbon $this
             */
            return $this->setTimezone(env('CUSTOM_TIMEZONE'))->format($format);
        });
    }
}
