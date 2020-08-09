<?php

namespace hala\Press;

use hala\Press\Console\ProcessCommand;
use hala\Press\Facades\Press;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;


class PressBaseServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publish();
        }
        $this->registerResources();
    }

    public function register()
    {
        $this->commands([
            ProcessCommand::class
        ]);

    }

    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'press');
        $this->registerFacade();
        $this->registerRoutes();
        $this->registerFields();
    }

    private function publish()
    {
        $this->publishes([
            __DIR__ . '/../config/press.php' => config_path('press.php')
        ], 'config-press');

        $this->publishes([
            __DIR__ . '/Console/stubs/PressServiceProvider.stub' => app_path('Providers/PressServiceProvider.php')
        ], 'provider-press');
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfig(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    protected function routeConfig()
    {
        return [
            'namespace' => 'hala\Press\Http\Controllers',
        ];
    }

    protected function registerFacade()
    {
        $this->app->singleton('Press', function ($app) {
            return new \hala\Press\Press();
        });
    }

    private function registerFields()
    {
        Press::fields([
            Fields\Body::class,
            Fields\Date::class,
            Fields\Title::class,
            Fields\Description::class,
            Fields\Extra::class,
        ]);
    }
}