<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerraTask extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'assigned_by',
        'status',
        'priority',
        'deadline',
    ];
 
    protected $casts = [
        'deadline' => 'date',
    ];
 
    // ── STATUS CONSTANTS ───────────────────────────────────────
    const STATUS_PENDING      = 'pending';
    const STATUS_IN_PROGRESS  = 'in_progress';
    const STATUS_UNDER_REVIEW = 'under_review';
    const STATUS_COMPLETED    = 'completed';
    const STATUS_OVERDUE      = 'overdue';
 
    const PRIORITY_LOW    = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH   = 'high';
 
    // ── RELATIONSHIPS ──────────────────────────────────────────
 
    /** The user this task is assigned to (professional / consultant / user) */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
 
    /** The admin / staff who created the task */
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
 
    /** All documents attached directly to this task */
    public function files()
    {
        return $this->hasMany(TerraTaskDocument::class);
    }
 
    /** All submission records for this task */
    public function submissions()
    {
        return $this->hasMany(TerraTaskSubmission::class)->latest();
    }
 
    /** Most recent submission */
    public function latestSubmission()
    {
        return $this->hasOne(TerraTaskSubmission::class)->latestOfMany();
    }
 
    // ── HELPERS ────────────────────────────────────────────────
 
    public function isOverdue(): bool
    {
        return $this->deadline
            && $this->deadline->isPast()
            && !in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_OVERDUE]);
    }
 
    public function isOpen(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_IN_PROGRESS]);
    }
 
    public function daysUntilDeadline(): ?int
    {
        return $this->deadline ? (int) now()->diffInDays($this->deadline, false) : null;
    }
 
    // ── SCOPES ────────────────────────────────────────────────
 
    public function scopeAssignedTo($query, int $userId)
    {
        return $query->where('assigned_to', $userId);
    }
 
    public function scopeOpen($query)
    {
        return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_IN_PROGRESS]);
    }
 
    public function scopeOverdue($query)
    {
        return $query->where('status', '!=', self::STATUS_COMPLETED)
                     ->where('deadline', '<', now());
    }
 
    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }
}
