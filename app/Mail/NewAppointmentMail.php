<?php

namespace App\Mail;

use App\Models\ConsultantAppointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ConsultantAppointment $appointment
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📅 New Appointment Booking — ' . $this->appointment->consultant->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.appointment.new',
            with: [
                'appointment' => $this->appointment,
                'consultant'  => $this->appointment->consultant,
            ],
        );
    }
}