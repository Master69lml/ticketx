<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AmazonSesServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // This provider is kept for future SES integration
        // Currently, Laravel 5.2 uses native Swift Mailer configuration
    }
}
