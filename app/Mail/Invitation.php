<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Invitation extends Mailable
{
    use Queueable, SerializesModels;
    public $teamName;
    public $acceptUrl;
    public $refuseUrl;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($team, $acceptUrl, $refuseUrl)
    {
        //
        $this->teamName = $team;
        $this->acceptUrl = $acceptUrl;
        $this->refuseUrl = $refuseUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->from('info@heroesdigitales.org')
                  ->subject('Invitación a equipo - Héroes Digitales')
                  ->view('emails.invitation-to-team');
    }
}
