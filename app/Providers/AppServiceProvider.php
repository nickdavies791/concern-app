<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('admin', function () {
            return auth()->user()->isAdmin();
        });
        Blade::if('safeguarding', function () {
            return auth()->user()->isSafeguarding();
        });
        Blade::if('staff', function () {
            return auth()->user()->isStaff();
        });
        Blade::if('user', function () {
            return auth()->user()->isUser();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
