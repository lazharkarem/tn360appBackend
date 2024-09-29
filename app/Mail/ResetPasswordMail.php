<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $client;
    protected $token;
    protected $url; // Add a new property for the URL

    public function __construct($client, $token, $url) // Accept URL as a parameter
    {
        $this->client = $client;
        $this->token = $token;
        $this->url = $url; // Set the URL property
    }

    public function build()
    {
        return $this->view('emails.reset_password') // Ensure you have this view
            ->with([
                'client' => $this->client,
                'token' => $this->token,
                'url' => $this->url, // Pass the URL to the view
            ]);
    }
}
