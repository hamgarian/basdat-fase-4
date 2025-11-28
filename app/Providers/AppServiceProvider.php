<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS URLs when behind a proxy (like Coolify)
        // This ensures all asset URLs use HTTPS even if APP_URL is set incorrectly
        if (request()->header('X-Forwarded-Proto') === 'https' || 
            request()->server('HTTP_X_FORWARDED_PROTO') === 'https' ||
            request()->secure()) {
            URL::forceScheme('https');
        }
    }
}
