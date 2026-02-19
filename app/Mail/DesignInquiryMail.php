<?php

namespace App\Mail;

use App\Models\ArchitecturalDesign;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DesignInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $design;

    public function __construct(array $data, ArchitecturalDesign $design)
    {
        $this->data = $data;
        $this->design = $design;
    }

    public function build()
    {
        return $this->subject('New Design Inquiry: ' . $this->design->title)
                    ->markdown('emails.design_inquiry');
    }
}
