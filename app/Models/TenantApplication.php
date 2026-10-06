<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'unit_id',
        'application_date',
        'preferred_move_in_date',
        'offered_rent',
        'offered_deposit',
        'status',
        'notes',
        'rejection_reason',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'application_date' => 'date',
        'preferred_move_in_date' => 'date',
        'offered_rent' => 'decimal:2',
        'offered_deposit' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function lease()
    {
        return $this->hasOne(Lease::class);
    }
}
