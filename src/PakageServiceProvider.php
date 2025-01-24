<?php

namespace Jobayer\LaravelAppUpdater;

use Illuminate\Support\ServiceProvider;
use Jobayer\LaravelAppUpdater\Services\DatabaseManager;
use Jobayer\LaravelAppUpdater\Services\FileManager;
use Jobayer\LaravelAppUpdater\Services\LoggerService;

class PakageServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind the services to the service container
        $this->app->singleton(LoggerService::class, function ($app) {
            return new LoggerService();
        });

        $this->app->singleton(FileManager::class, function ($app) {
            return new FileManager();
        });

        $this->app->singleton(DatabaseManager::class, function ($app) {
            return new DatabaseManager();
        });
    }

    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/Jobayer/SystemUpdater'),
        ], 'views');
    }
}
