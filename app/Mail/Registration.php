<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Registration extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $lastname;
    public $verificationUrl;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $lastname, $verificationUrl, $type)
    {
        //
        $this->name = $name;
        $this->lastname = $lastname;
        $this->verificationUrl = $verificationUrl;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->type == 'USER_MENTOR'){
            return $this->from('elemental@gmail.com')
                        ->view('emails.register-verification');
        }else if($this->type == 'JUDGE_EXPERT'){
            return $this->from('elemental@gmail.com')
                        ->view('emails.judge-expert-verification');
        }
    }
}
