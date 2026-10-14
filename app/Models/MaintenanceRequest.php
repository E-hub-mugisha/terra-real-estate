<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaintenanceRequest extends Model
{
    protected $fillable = [
        'managed_property_id',
        'unit_id',
        'tenant_id',
        'requested_by',
        'assigned_to',
        'request_number',
        'title',
        'description',
        'category',
        'priority',
        'status',
        'requested_date',
        'scheduled_date',
        'completed_date',
        'estimated_cost',
        'actual_cost',
        'currency',
        'resolution_notes',
    ];

    protected function casts(): array
    {
        return [
            'requested_date' => 'date',
            'scheduled_date' => 'date',
            'completed_date' => 'date',
            'estimated_cost' => 'decimal:2',
            'actual_cost' => 'decimal:2',
        ];
    }

    public function managedProperty(): BelongsTo
    {
        return $this->belongsTo(ManagedProperty::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(MaintenanceRequestActivity::class)
            ->with('user')
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }
}
