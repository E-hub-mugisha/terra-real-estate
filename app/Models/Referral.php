<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Referral extends Model
{
    protected $fillable = [
        'referrer_id',
        'type',
        'name',
        'phone',
        'email',
        'interest',
        'notes',
        'status',
        'converted_user_id',
        'listable_type',
        'listable_id',
    ];

    public const STATUSES = ['new', 'contacted', 'qualified', 'converted', 'lost'];

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function convertedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'converted_user_id');
    }

    public function listable(): MorphTo
    {
        return $this->morphTo();
    }
}
