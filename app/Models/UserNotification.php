<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserNotification extends Model
{
    protected $fillable = [
        'user_id',
        'event_key',
        'title',
        'message',
        'priority',
        'related_type',
        'related_id',
        'data',
        'action_url',
        'dedupe_key',
        'read_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'read_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(NotificationDelivery::class);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}