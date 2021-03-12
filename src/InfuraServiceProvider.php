<?php

namespace InfinitySolutions\Infura;

use Illuminate\Support\ServiceProvider;

class InfuraServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'infinitysolutions');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'infinitysolutions');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/infura.php', 'infura');

        // Register the service the package provides.
        $this->app->singleton('infura', function ($app) {
            return new Infura;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['infura'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/infura.php' => config_path('infura.php'),
        ], 'infura.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/infinitysolutions'),
        ], 'infura.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/infinitysolutions'),
        ], 'infura.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/infinitysolutions'),
        ], 'infura.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
