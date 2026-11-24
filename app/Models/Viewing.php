<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Viewing extends Model
{
    protected $fillable = [
        'listable_type',
        'listable_id',
        'client_id',
        'host_id',
        'scheduled_at',
        'status',
        'note',
        'response_note',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public const STATUSES = ['requested', 'confirmed', 'declined', 'completed', 'cancelled'];

    public function listable(): MorphTo
    {
        return $this->morphTo();
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }
}
