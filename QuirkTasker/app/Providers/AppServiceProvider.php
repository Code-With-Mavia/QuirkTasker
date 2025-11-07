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
        $this->app->bind(\App\Interfaces\TaskRepositoryInterface::class,
                     \App\Interfaces\Repositories\TaskRepositories::class);
        $this->app->bind(\App\Interfaces\UserRepositoryInterface::class,
                     \App\Interfaces\Repositories\UserRepositories::class);
        $this->app->bind(\App\Interfaces\ActivityLoggerRepositoryInterface::class,
                     \App\Interfaces\Repositories\ActivityLoggerRepositories::class,);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
