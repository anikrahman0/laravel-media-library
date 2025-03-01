<?php

namespace Noobtrader\LaravelMediaLibrary;

use Illuminate\Support\ServiceProvider;

class MediaLibraryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/imagepath.php', // Path to your config file
            'imagepath' // The config key used in the application
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'laravelmedialibrary');
        $this->loadMigrationsFrom(__DIR__ . '/../src/Migrations');
        $this->publishes([
            __DIR__ . '/assets' => public_path('noobtrader/laravelmedialibrary'),
        ], 'laravelmedialibrary-assets');
    }
}
