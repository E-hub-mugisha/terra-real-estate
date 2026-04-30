<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'email',
        'location',
        'transaction_type',
        'rating',
        'review',
        'avatar_initials',
        'status',
        'featured',
        'source',
        'admin_note',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'featured'    => 'boolean',
        'approved_at' => 'datetime',
        'rating'      => 'integer',
    ];

    // ── Relationships ─────────────────────────────────────────
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ── Scopes ────────────────────────────────────────────────
    public function scopeApproved(Builder $q): Builder
    {
        return $q->where('status', 'approved');
    }

    public function scopePending(Builder $q): Builder
    {
        return $q->where('status', 'pending');
    }

    public function scopeFeatured(Builder $q): Builder
    {
        return $q->where('featured', true);
    }

    // ── Helpers ───────────────────────────────────────────────
    public static function transactionLabels(): array
    {
        return [
            'bought_home'       => 'Bought a home',
            'sold_property'     => 'Sold property',
            'rented_home'       => 'Rented a home',
            'listed_property'   => 'Listed property',
            'hired_professional' => 'Hired a professional',
            'used_consultant'   => 'Used a consultant',
        ];
    }

    public function getTransactionLabelAttribute(): string
    {
        return self::transactionLabels()[$this->transaction_type] ?? $this->transaction_type;
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'badge-approved',
            'rejected' => 'badge-rejected',
            default    => 'badge-pending',
        };
    }

    public static function generateInitials(string $name): string
    {
        $words = explode(' ', trim($name));
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(mb_substr($word, 0, 1));
        }
        return $initials ?: 'TT';
    }
}
