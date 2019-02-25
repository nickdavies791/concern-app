<?php

namespace App\Events;

use App\Comment;
use App\Concern;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentCreated
{
    use SerializesModels;

    public $concern;

    public $comment;

	/**
	 * Create a new event instance.
	 *
	 * @param Concern $concern
	 * @param Comment $comment
	 */
    public function __construct(Concern $concern, Comment $comment)
    {
        $this->concern = $concern;
        $this->comment = $comment;
    }
}
