<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestToJoin extends Mailable
{
    use Queueable, SerializesModels;
    public $requesterName;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($completeName, $url)
    {
        //
        $this->requesterName = $completeName;
        $this->url = $url;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->subject('Solicitud de ingreso al equipo - Héroes Digitales')
                  ->view('emails.request-to-join');
    }
}
