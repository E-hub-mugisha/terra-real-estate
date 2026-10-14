<?php

namespace App\Services;

use App\Models\NotificationDelivery;
use App\Models\NotificationPreference;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    /**
     * Create an in-app notification and record its delivery.
     *
     * Required:
     * user, event_key, title, message
     *
     * Optional:
     * priority, related_type, related_id, data,
     * action_url, dedupe_key
     */
    public function sendInApp(
        User $user,
        array $payload
    ): ?UserNotification {
        $preference = $user->notificationPreference;

        if ($preference && ! $preference->in_app_enabled) {
            return null;
        }

        return DB::transaction(function () use ($user, $payload) {
            $dedupeKey = $payload['dedupe_key'] ?? null;

            if ($dedupeKey) {
                $existing = UserNotification::query()
                    ->where('dedupe_key', $dedupeKey)
                    ->first();

                if ($existing) {
                    return $existing;
                }
            }

            $notification = UserNotification::create([
                'user_id' => $user->id,
                'event_key' => $payload['event_key'],
                'title' => $payload['title'],
                'message' => $payload['message'],
                'priority' => $payload['priority'] ?? 'normal',
                'related_type' => $payload['related_type'] ?? null,
                'related_id' => $payload['related_id'] ?? null,
                'data' => $payload['data'] ?? null,
                'action_url' => $payload['action_url'] ?? null,
                'dedupe_key' => $dedupeKey,
            ]);

            NotificationDelivery::create([
                'user_notification_id' => $notification->id,
                'channel' => 'in_app',
                'status' => 'sent',
                'attempts' => 1,
                'queued_at' => now(),
                'sent_at' => now(),
            ]);

            return $notification;
        });
    }

    /**
     * Create default preferences the first time they are needed.
     */
    public function preferencesFor(User $user): NotificationPreference
    {
        return NotificationPreference::firstOrCreate(
            ['user_id' => $user->id],
            [
                'in_app_enabled' => true,
                'email_enabled' => true,
                'sms_enabled' => false,
                'push_enabled' => false,
                'whatsapp_enabled' => false,
            ]
        );
    }
}