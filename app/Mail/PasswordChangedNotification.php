<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordChangedNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function build()
    {
        return $this->view('emails.password_changed') // Make sure this view exists
            ->with([
                'client' => $this->client,
            ])
            ->subject('Votre mot de passe a été changé');
    }
}