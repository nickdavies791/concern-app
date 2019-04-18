<?php

namespace App\Providers;

use App\Services\Interfaces\MISInterface;
use App\Services\SIMS\Assembly;
use Illuminate\Support\ServiceProvider;

class AssemblyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MISInterface::class, function () {
            return new Assembly(
                config('services.assembly.client_id'),
                config('services.assembly.client_secret')
            );
        });
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
