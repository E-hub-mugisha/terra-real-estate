<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerraTaskSubmission extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'task_id',
        'submitted_by',
        'submission_type',
        'subject',
        'notes',
        'status',
    ];
 
    // ── CONSTANTS ──────────────────────────────────────────────
 
    const TYPE_PROGRESS    = 'progress_update';
    const TYPE_FINAL       = 'final_delivery';
    const TYPE_DOCUMENTS   = 'additional_documents';
    const TYPE_REVISION    = 'revision';
 
    const STATUS_UNDER_REVIEW = 'under_review';
    const STATUS_APPROVED     = 'approved';
    const STATUS_REJECTED     = 'rejected';
 
    // ── RELATIONSHIPS ──────────────────────────────────────────
 
    public function task()
    {
        return $this->belongsTo(TerraTask::class);
    }
 
    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
 
    /** Documents attached specifically to this submission */
    public function files()
    {
        return $this->hasMany(TerraTaskDocument::class, 'submission_id');
    }
 
    // ── HELPERS ────────────────────────────────────────────────
 
    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }
 
    public function isPending(): bool
    {
        return $this->status === self::STATUS_UNDER_REVIEW;
    }
 
    public function typeLabel(): string
    {
        return match($this->submission_type) {
            self::TYPE_PROGRESS  => 'Progress Update',
            self::TYPE_FINAL     => 'Final Delivery',
            self::TYPE_DOCUMENTS => 'Additional Documents',
            self::TYPE_REVISION  => 'Revision',
            default              => ucfirst($this->submission_type),
        };
    }
 
    // ── SCOPES ────────────────────────────────────────────────
 
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_UNDER_REVIEW);
    }
 
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }
}
