<?php

namespace DenisKisel\SMSCRU;

use Illuminate\Support\ServiceProvider;

class SMSCRUServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/smscru.php', 'smscru');

        // Register the service the package provides.
        $this->app->singleton('smscru', function ($app) {
            return new SMSCRU;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['smscru'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/smscru.php' => config_path('smscru.php'),
        ], 'smscru.config');
    }
}
