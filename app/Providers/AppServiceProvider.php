<?php

namespace App\Providers;

use App\Token;
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
        Blade::if('adminOrSafeguarding', function () {
            return auth()->user()->isAdmin() || auth()->user()->isSafeguarding();
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
        Blade::if('tokenExists', function () {
            $token = new Token;
            return $token->exists();
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
