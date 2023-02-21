<?php

namespace Inium\Mvcs;

use Illuminate\Support\ServiceProvider;

class MvcsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/Config/mvcs.php", "mvcs");
        $this->publishes(
            [
                __DIR__ .
                "/Publishes/Provider/MvcsServiceProvider.php" => app_path(
                    "Providers/MvcsServiceProvider.php"
                ),
            ],
            "mvcs-provider"
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([\Inium\Mvcs\Commands\CreateCommand::class]);
        }
    }
}
