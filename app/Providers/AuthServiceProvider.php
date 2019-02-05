<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Concern' => 'App\Policies\ConcernPolicy',
        'App\Comment' => 'App\Policies\CommentPolicy',
        'App\Document' => 'App\Policies\DocumentPolicy',
        'App\Tag' => 'App\Policies\TagPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Group' => 'App\Policies\GroupPolicy',
        'App\Student' => 'App\Policies\StudentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
