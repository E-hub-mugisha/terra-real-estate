<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ListingPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payable_type',
        'payable_id',
        'user_id',
        'payment_purpose',
        'amount',
        'currency',
        'payment_method',
        'phone_number',
        'gateway_reference',
        'transaction_id',
        'gateway_response',
        'reference',
        'status',
        'paid_at',
        'failure_reason',
        'listing_package_id',
        'days',
        'verified_by',
    ];

    protected $casts = [
        'amount'   => 'decimal:2',
        'paid_at'  => 'datetime',
    ];

    // ── Boot: auto-generate reference ─────────────────────────────────────
    protected static function booted(): void
    {
        static::creating(function (ListingPayment $payment) {
            $payment->reference = 'PAY-' . strtoupper(Str::random(8));
        });
    }
 
    // ── Relations ─────────────────────────────────────────────────────────

    /** The thing being paid for (Land, House, ArchitecturalDesign) */
    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function markCompleted(string $transactionId, ?string $gatewayResponse = null): void
    {
        $this->update([
            'status'           => 'completed',
            'transaction_id'   => $transactionId,
            'gateway_response' => $gatewayResponse,
            'paid_at'          => now(),
        ]);
    }

    /** The payer entered a transaction ID; an admin must verify it before the package starts. */
    public function markAwaitingVerification(string $transactionId, ?string $note = null): void
    {
        $this->update([
            'status'           => 'processing',
            'transaction_id'   => $transactionId,
            'gateway_response' => $note ? json_encode(['note' => $note]) : $this->gateway_response,
        ]);
    }

    public function isAwaitingVerification(): bool
    {
        return $this->status === 'processing' && filled($this->transaction_id);
    }

    public function promotion(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ListingPromotion::class, 'listing_payment_id');
    }

    public function markFailed(string $reason, ?string $gatewayResponse = null): void
    {
        $this->update([
            'status'           => 'failed',
            'failure_reason'   => $reason,
            'gateway_response' => $gatewayResponse,
        ]);
    }

    /** Human-readable label for what is being paid for */
    public function payableLabel(): string
    {
        return match (true) {
            $this->payable instanceof \App\Models\Land               => 'Land Listing',
            $this->payable instanceof \App\Models\House              => 'House Listing',
            $this->payable instanceof \App\Models\ArchitecturalDesign => 'Architectural Design',
            default                                                   => 'Property Listing',
        };
    }

    // app/Models/ListingPayment.php
    public function listingPackage(): BelongsTo
    {
        return $this->belongsTo(ListingPackage::class, 'listing_package_id');
    }
}
