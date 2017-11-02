<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailInvitation extends Mailable
{
    use Queueable, SerializesModels;
    public $url;
    public $team;
    public $leadername;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($leadername, $teamname, $url)
    {
        //
        $this->url = $url;
        $this->team = $teamname;
        $this->leadername = $leadername;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->from('info@heroesdigitales.org')
                  ->sender('info@heroesdigitales.org', 'Héroes Digitales')
                  ->subject('Invitación a equipo - Héroes Digitales')
                  ->view('emails.email-invitation');
    }
}
