<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantApplication extends Model
{
    protected $fillable = [
        'tenant_id',
        'unit_id',
        'reviewed_by',
        'application_number',
        'application_date',
        'desired_move_in_date',
        'number_of_occupants',
        'offered_monthly_rent',
        'currency',
        'employment_status',
        'additional_information',
        'status',
        'reviewed_at',
        'decision_notes',
    ];

    protected function casts(): array
    {
        return [
            'application_date' => 'date',
            'desired_move_in_date' => 'date',
            'reviewed_at' => 'datetime',
            'number_of_occupants' => 'integer',
            'offered_monthly_rent' => 'decimal:2',
        ];
    }

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
}