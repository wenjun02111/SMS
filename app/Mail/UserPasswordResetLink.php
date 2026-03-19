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
        public string $systemName,
        public string $subjectLine = 'Reset your SQL SMS password',
        public string $introLine = 'We received a request to reset your password.',
        public string $instructionLine = 'Click the link below to set a new password:',
        public string $buttonLabel = 'Reset password',
        public string $expiryLine = 'This link will expire in 15 minutes.',
        public string $ignoreLine = 'If you did not request this, please ignore this email.'
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
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
