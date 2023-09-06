<?php

namespace App\Models;

use App\Observers\LogObserver;

trait LogObserverTrait
{
    public static function boot(): void
    {
        parent::boot();
        self::observe(LogObserver::class);
    }
}
