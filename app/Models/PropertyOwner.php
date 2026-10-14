<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyOwner extends Model
{
    protected $fillable = [
        'user_id',
        'owner_type',
        'phone',
        'national_id',
        'company_name',
        'tin',
        'address',
        'verification_status',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(ManagedProperty::class);
    }
}