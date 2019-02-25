<?php

namespace App\Mail;

use App\Comment;
use App\Concern;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyConcernAuthor extends Mailable
{
    use Queueable, SerializesModels;

    public $concern;

    public $comment;

    public $author;

	/**
	 * Create a new message instance.
	 *
	 * @param Concern $concern
	 * @param Comment $comment
	 * @param User $author
	 */
    public function __construct(Concern $concern, Comment $comment, User $author)
    {
        $this->concern = $concern;
        $this->comment = $comment;
        $this->author = $author;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.comments.notify-author');
    }
}
