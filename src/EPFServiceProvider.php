<?php

namespace Atomescrochus\EPF;

use Illuminate\Support\ServiceProvider;

class EPFServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/apple-epf.php' => config_path('apple-epf.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/apple-epf.php', 'apple-epf');
    }
}
