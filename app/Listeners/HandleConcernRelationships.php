<?php

namespace App\Listeners;

use App\Events\ConcernCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleConcernRelationships
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  ConcernCreated  $event
     * @return void
     */
    public function handle(ConcernCreated $event)
    {
        $event->concern->students()->attach($event->request->students);
        $event->concern->tags()->attach($event->request->tags);
        $event->concern->groups()->attach($event->request->groups);
    }
}
