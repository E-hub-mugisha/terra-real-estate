<?php

namespace App\Models\Concerns;

use App\Models\ListingPayment;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Add this trait to Land, House, and ArchitecturalDesign models.
 *
 * Usage:
 *   use App\Models\Concerns\HasPayments;
 *   class Land extends Model { use HasPayments; ... }
 */
trait HasPayments
{
    public function payments(): MorphMany
    {
        return $this->morphMany(ListingPayment::class, 'payable');
    }

    public function latestPayment(): ?ListingPayment
    {
        return $this->payments()->latest()->first();
    }

    public function hasPendingPayment(): bool
    {
        return $this->payments()->where('status', 'pending')->exists();
    }

    public function hasCompletedPayment(): bool
    {
        return $this->payments()->where('status', 'completed')->exists();
    }
}