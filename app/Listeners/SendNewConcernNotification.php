<?php

namespace App\Listeners;

use App\Events\ConcernCreated;
use App\Mail\NewConcernCreated;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendNewConcernNotification
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
        // Get each of the groups selected
        foreach ($event->concern->groups as $group)
        {
            // Loop through each of the users in the group
            $group->users->each(function($user) use($event)
            {
                // Dispatch mail to the job queue
                Mail::to($user->email)->queue(
                    new NewConcernCreated($event->concern, $user
                ));
            });
        }
    }
}
