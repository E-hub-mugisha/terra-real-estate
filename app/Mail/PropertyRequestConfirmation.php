<?php

namespace App\Mail;

use App\Models\PropertyRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PropertyRequestConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly PropertyRequest $propertyRequest
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your Property Request is Received — {$this->propertyRequest->reference_number}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.property-request.confirmation',
        );
    }
}