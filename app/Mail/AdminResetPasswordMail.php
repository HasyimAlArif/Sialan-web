<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $resetUrl;
    public string $adminName;

    public function __construct(string $resetUrl, string $adminName)
    {
        $this->resetUrl  = $resetUrl;
        $this->adminName = $adminName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password Admin - SiALAN',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-reset-password',
        );
    }
}
