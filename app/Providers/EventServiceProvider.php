<?php

namespace App\Providers;

use App\Events\CommentCreated;
use App\Events\ConcernCreated;
use App\Listeners\HandleConcernRelationships;
use App\Listeners\SendNewCommentNotification;
use App\Listeners\SendNewConcernNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ConcernCreated::class => [
            HandleConcernRelationships::class,
            SendNewConcernNotification::class,
        ],
        CommentCreated::class => [
            SendNewCommentNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
