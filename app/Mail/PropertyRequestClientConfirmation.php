<?php

namespace App\Mail;

use App\Models\PropertyRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PropertyRequestClientConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly PropertyRequest $propertyRequest
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "We received your property request — {$this->propertyRequest->reference_number}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.property-request.client-confirmation',
            with: [
                'req' => $this->propertyRequest,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}