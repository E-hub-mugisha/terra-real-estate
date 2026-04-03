<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProfessionalCredentialsMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User   $professional,
        public readonly string $plainPassword,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Terra — Your Login Credentials',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.professionals.credentials',
            with: [
                'name'          => $this->professional->name,
                'email'         => $this->professional->email,
                'plainPassword' => $this->plainPassword,
                'loginUrl'      => route('login'),
            ],
        );
    }
}