<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentPayment extends Model
{
    protected $fillable = [
        'lease_id',
        'recorded_by',
        'receipt_number',
        'transaction_reference',
        'amount',
        'currency',
        'payment_method',
        'payment_date',
        'period_start',
        'period_end',
        'payment_type',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'payment_date' => 'date',
            'period_start' => 'date',
            'period_end' => 'date',
        ];
    }

    public function lease(): BelongsTo
    {
        return $this->belongsTo(Lease::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}