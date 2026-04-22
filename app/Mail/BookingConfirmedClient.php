<?php

namespace App\Mail;

use App\Models\ConsultantBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmedClient extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ConsultantBooking $booking) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your Consultation is Confirmed – {$this->booking->reference}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-confirmed-client',
        );
    }
}
