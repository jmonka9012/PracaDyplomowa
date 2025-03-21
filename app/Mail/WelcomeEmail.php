<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
    public function build()
    {
        return $this->subject('Welcome to Our App!')
                    ->view('emails.welcome')
                    ->with([
                        'name' => $this->name,
                    ]);
    }
}