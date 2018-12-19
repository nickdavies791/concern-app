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
     * @return void
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
        $this->loggedBy = (\App\Concern::where('id', '=', $this->concern->id)
            ->first())
            ->user->name;
            
        return $this->markdown('emails.concerns.notify');
    }
}
