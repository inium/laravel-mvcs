<?php

namespace Inium\Multier;

use Illuminate\Support\ServiceProvider;

class MultierServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/Config/multier.php", "multier");
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([\Inium\Multier\Commands\CreateCommand::class]);
        }
    }
}
