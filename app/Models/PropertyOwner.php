<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyOwner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'owner_type',
        'phone',
        'alternate_phone',
        'national_id',
        'tin_number',
        'company_name',
        'province',
        'district',
        'sector',
        'address',
        'verification_status',
        'status',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'property_owner_id');
    }
}