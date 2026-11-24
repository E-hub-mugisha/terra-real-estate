<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Offer extends Model
{
    protected $fillable = [
        'listable_type',
        'listable_id',
        'client_id',
        'recipient_id',
        'amount',
        'currency',
        'message',
        'counter_amount',
        'response_note',
        'status',
        'responded_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'counter_amount' => 'decimal:2',
        'responded_at' => 'datetime',
    ];

    public const STATUSES = ['pending', 'countered', 'accepted', 'rejected', 'withdrawn'];

    public function listable(): MorphTo
    {
        return $this->morphTo();
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function isOpen(): bool
    {
        return in_array($this->status, ['pending', 'countered'], true);
    }
}
