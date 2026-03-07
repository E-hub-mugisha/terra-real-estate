<?php

namespace App\Mail;

use App\Models\Land;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LandInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $land;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data, Land $land)
    {
        //
        $this->data = $data;
        $this->land = $land;
    }

    public function build()
    {
        return $this->subject('New land Inquiry: ' . $this->land->title)
        ->markdown('emails.land_inquiry');
    }
}
