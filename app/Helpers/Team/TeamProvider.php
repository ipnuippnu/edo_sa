<?php

namespace App\Helpers\Team;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class TeamProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Team::class, function (Application $application){

            return new Team;

        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        app('team')->
    }
}
