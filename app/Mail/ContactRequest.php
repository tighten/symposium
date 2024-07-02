<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactRequest extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $email;

    public $name;

    public $userMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name, $userMessage)
    {
        $this->email = $email;
        $this->name = $name;
        $this->userMessage = $userMessage;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        return $this->subject('Contact from your Symposium public profile page')
                    ->view('emails.public-profile-contact');
    }
}
