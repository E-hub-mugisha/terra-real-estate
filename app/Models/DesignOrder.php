<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignOrder extends Model
{
    protected $fillable = [
        'user_id',
        'architectural_design_id',
        'amount',
        'payment_status',
    ];

    /**
     * Order belongs to a buyer (user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order belongs to an architectural design
     */
    public function design()
    {
        return $this->belongsTo(ArchitecturalDesign::class, 'architectural_design_id');
    }

 
    // ── Scopes ───────────────────────────────────────────────────────────
 
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
 
    // ── Accessors ────────────────────────────────────────────────────────
 
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending'     => 'badge-warning',
            'in_progress' => 'badge-info',
            'completed'   => 'badge-success',
            'cancelled'   => 'badge-danger',
            default       => 'badge-secondary',
        };
    }
 
    public function getStatusLabelAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->status));
    }
}
