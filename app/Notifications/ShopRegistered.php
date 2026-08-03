<?php

namespace App\Notifications;

use App\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ShopRegistered extends Notification
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
            ->subject('New Shop Registration Pending Approval')
            ->line("A new shop '{$this->shop->name}' has been submitted for review.")
            ->action('Review Shop', route('admin.shops.index', ['status' => 'pending']));
    }

    public function toArray($notifiable): array
    {
        return ['shop_id' => $this->shop->id, 'shop_name' => $this->shop->name];
    }
}