<?php

namespace App\Mail;

use App\Concern;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyConcernGroups extends Mailable
{
    use Queueable, SerializesModels;

    public $concern;

    public $user;

    public $loggedBy;

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
        $this->loggedBy = ($this->concern->where('id', $this->concern->id)->first())->user->name;
        return $this->from('test@test.com')->markdown('emails.concerns.notify');
    }
}
