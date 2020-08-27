<?php

namespace Laraditz\Xenopay;

use Illuminate\Support\ServiceProvider;

class XenopayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/xenopay.php' => config_path('xenopay.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/xenopay.php', 'xenopay');

        // Register the service the package provides.
        $this->app->singleton('Xenopay', function ($app) {
            return new Xenopay;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Xenopay'];
    }
}
