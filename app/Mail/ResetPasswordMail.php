<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ResetPasswordMail extends Mailable
{
    public $name;
    public $resetLink;

    public function __construct($name, $resetLink)
    {
        $this->name = $name;
        $this->resetLink = $resetLink;
    }

    public function build()
    {
        return $this->view('emails.reset-password')
                    ->with([
                        'name' => $this->name,
                        'resetLink' => $this->resetLink,
                    ]);
    }
}
