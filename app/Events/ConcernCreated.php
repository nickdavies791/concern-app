<?php

namespace App\Events;

use App\Concern;
use Illuminate\Http\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConcernCreated
{
    use SerializesModels;

    public $request;

    public $concern;

    /**
     * Create a new event instance.
     *
     * @param Concern $concern
     * @param Request $request
     */
    public function __construct(Concern $concern, Request $request)
    {
        $this->request = $request;
        $this->concern = $concern;
    }
}
