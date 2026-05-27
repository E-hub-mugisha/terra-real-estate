<?php

namespace App\Mail;

use App\Models\PropertyRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PropertyRequestAdminNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly PropertyRequest $propertyRequest
    ) {}

    public function envelope(): Envelope
    {
        $urgencyLabel = strtoupper($this->propertyRequest->urgency);

        return new Envelope(
            subject: "[{$urgencyLabel}] New Property Request — {$this->propertyRequest->reference_number}",
            replyTo: [$this->propertyRequest->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.property-request.admin-notification',
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