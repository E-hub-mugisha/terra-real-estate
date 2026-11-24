<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Conversation extends Model
{
    protected $fillable = [
        'listable_type',
        'listable_id',
        'subject',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function listable(): MorphTo
    {
        return $this->morphTo();
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_participants')->withPivot('last_read_at')->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function otherParticipant(User $me): ?User
    {
        return $this->participants->firstWhere('id', '!=', $me->id);
    }

    public function unreadFor(User $user): int
    {
        $read = optional($this->participants->firstWhere('id', $user->id))->pivot?->last_read_at;

        return $this->messages()->where('user_id', '!=', $user->id)
            ->when($read, fn ($q) => $q->where('created_at', '>', $read))
            ->count();
    }

    /** Find or create the 1:1 conversation between two users about a listing. */
    public static function between(User $a, User $b, $listing = null, ?string $subject = null): self
    {
        $existing = static::query()
            ->whereHas('participants', fn ($q) => $q->where('users.id', $a->id))
            ->whereHas('participants', fn ($q) => $q->where('users.id', $b->id))
            ->when($listing, fn ($q) => $q->where('listable_type', $listing->getMorphClass())->where('listable_id', $listing->getKey()))
            ->first();
        if ($existing) {
            return $existing;
        }
        $conversation = static::create([
            'listable_type' => $listing?->getMorphClass(),
            'listable_id' => $listing?->getKey(),
            'subject' => $subject ?? $listing?->title,
        ]);
        $conversation->participants()->attach([$a->id, $b->id]);

        return $conversation;
    }
}
