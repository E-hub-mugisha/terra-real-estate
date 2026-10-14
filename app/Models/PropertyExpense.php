<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyExpense extends Model
{
    protected $fillable = [
        'managed_property_id',
        'unit_id',
        'recorded_by',
        'expense_reference',
        'category',
        'description',
        'amount',
        'currency',
        'expense_date',
        'vendor_name',
        'receipt_path',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'expense_date' => 'date',
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

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}