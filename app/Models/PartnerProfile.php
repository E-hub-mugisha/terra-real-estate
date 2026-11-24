<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'phone',
        'whatsapp',
        'areas',
        'bio',
        'status',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
