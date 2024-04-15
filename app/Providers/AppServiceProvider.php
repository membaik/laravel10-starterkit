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
        if (strpos(url()->to(""), "localhost") === false && strpos(url()->to(""), "127.0.0.1") === false && strpos(url()->to(""), "0.0.0.0") === false) {
            \URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
