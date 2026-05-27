<?php

namespace App\Mail;

use App\Models\PropertyRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PropertyRequestAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly PropertyRequest $propertyRequest
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[{$this->propertyRequest->reference_number}] New Property Request — {$this->propertyRequest->request_type_label}",
            replyTo: [$this->propertyRequest->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.property-request.admin',
        );
    }
}