<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $names;
    public $lastnames;
    public $verificationUrl;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($names, $lastnames, $verifUrl)
    {
        $this->names = $names;
        $this->lastnames = $lastnames;
        $this->verificationUrl = $verifUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reestablecer contraseña - Héroes Digitales')
                    ->view('emails.reset-password');
    }
}
