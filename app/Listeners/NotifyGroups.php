<?php

namespace App\Listeners;

use App\Events\ConcernCreated;
use App\Mail\NotifyConcernGroups;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyGroups
{
    use InteractsWithQueue, SerializesModels;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ConcernCreated  $event
     * @return void
     */
    public function handle(ConcernCreated $event)
    {
        foreach ($event->concern->groups as $group) {
            $group->users->each(function($user) use($event){
                \Mail::to($user->email)
                ->queue(new NotifyConcernGroups($event->concern, $user));
            });
        }
    }
}
