<?php

namespace App\Notifications;

use App\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ShopRejected extends Notification
{
    use Queueable;

    public function __construct(public Shop $shop) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
{
    return (new MailMessage)
        ->subject('Your Shop Has Been Rejected')
        ->line("We're sorry, but your shop '{$this->shop->name}' has been rejected.")
        ->action('View Details', route('shops.register.status'));
}

    public function toArray($notifiable): array
    {
        return ['shop_id' => $this->shop->id, 'shop_name' => $this->shop->name];
    }
}