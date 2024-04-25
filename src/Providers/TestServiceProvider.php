<?php

namespace Kovyakin\Test\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Kovyakin\Test\View\Components\TestComponent;


class TestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/test.php' => config_path('test.php'),
            __DIR__ . '/../resources/views' => resource_path('views/vendor/test'),
            __DIR__ . '/../resources/js' => public_path('/js/'),
            __DIR__ . '/../resources/css' => public_path('/css/'),
//            __DIR__ . '/../public' => public_path('/'),
        ], 'test');
        Blade::component('package-test', TestComponent::class);
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'test');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/table.php');
    }
}
