<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inium\Mvcs\Common\Traits\RegisterModuleTrait;

class MvcsServiceProvider extends ServiceProvider
{
    use RegisterModuleTrait;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerModules();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
