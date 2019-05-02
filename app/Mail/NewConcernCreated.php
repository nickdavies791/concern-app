<?php

namespace App\Mail;

use App\Concern;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewConcernCreated extends Mailable
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
     * The author of the concern.
     */
    public $author;

    /**
     * Create a new message instance.
     *
     * @param Concern $concern
     * @param $user
     */
    public function __construct(Concern $concern, $user)
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
        $this->author = ($this->concern->where('id', $this->concern->id)->first())->user->name;

        return $this->markdown('emails.concerns.notify');
    }
}
