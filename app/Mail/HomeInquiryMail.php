<?php

namespace App\Mail;

use App\Models\House;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HomeInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $home;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data, House $home)
    {
        //
        $this->data = $data;
        $this->home = $home;
    }

    public function build()
    {
        return $this->subject('New Home Inquiry: ' . $this->home->title)
        ->markdown('emails.home_inquiry');
    }
}
