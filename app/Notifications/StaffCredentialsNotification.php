<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StaffCredentialsNotification extends Notification
{
    public function __construct(public string $password) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Staff Account Credentials')
            ->greeting("Hello {$notifiable->name},")
            ->line('Your staff account has been created. Use the credentials below to log in.')
            ->line('**Email:** ' . $notifiable->email)
            ->line('**Password:** ' . $this->password)
            ->action('Login Now', url('/login'))
            ->line('Please change your password after your first login.')
            ->salutation('Terra Admin Team');
    }
}
