<?php

namespace App\Mail;

use App\Concern;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewCommentCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The Concern instance.
     */
    public $concern;

    /**
     * The recipient of the email.
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param Concern $concern
     * @param User $user
     */
    public function __construct(Concern $concern, User $user)
    {
        $this->concern = $concern;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.comments.notify');
    }
}
