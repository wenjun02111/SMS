<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserPasswordResetLink extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $toEmail,
        public string $recipientName,
        public string $resetUrl,
        public string $systemName
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset your SQL SMS password',
            to: [$this->toEmail],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user_password_reset_link',
        );
    }
}
