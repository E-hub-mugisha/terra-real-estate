<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRequest extends Model
{
    protected $fillable = [
        'request_number',
        'tenant_id',
        'lease_id',
        'unit_id',
        'title',
        'category',
        'description',
        'priority',
        'status',
        'attachment_path',
        'preferred_access_at',
        'assigned_to',
        'manager_notes',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'preferred_access_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function lease(): BelongsTo
    {
        return $this->belongsTo(Lease::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}