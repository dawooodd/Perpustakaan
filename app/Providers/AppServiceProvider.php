<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paksa Laravel menggunakan HTTPS di Cloud (Railway/Vercel)
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}