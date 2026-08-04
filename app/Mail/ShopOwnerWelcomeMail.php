<?php

namespace App\Mail;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShopOwnerWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $plainPassword,
        public Shop $shop,
    ) {}

    public function build()
    {
        return $this->subject('Welcome to Terra — Your Shop Account')
            ->view('emails.shop-owner-welcome')
            ->with([
                'user' => $this->user,
                'plainPassword' => $this->plainPassword,
                'shop' => $this->shop,
                'loginUrl' => route('login'),
            ]);
    }
}
