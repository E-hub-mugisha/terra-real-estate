<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TerraTaskDocument extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'task_id',
        'submission_id',
        'uploaded_by',
        'original_name',
        'path',
        'mime_type',
        'size',
    ];
 
    protected $casts = [
        'size' => 'integer',
    ];
 
    // ── RELATIONSHIPS ──────────────────────────────────────────
 
    public function task()
    {
        return $this->belongsTo(TerraTask::class);
    }
 
    public function submission()
    {
        return $this->belongsTo(TerraTaskSubmission::class);
    }
 
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
 
    // ── HELPERS ────────────────────────────────────────────────
 
    /** Human-readable file size e.g. "1.4 MB" */
    public function humanSize(): string
    {
        $bytes = $this->size;
        if ($bytes >= 1_048_576) return round($bytes / 1_048_576, 1) . ' MB';
        if ($bytes >= 1_024)     return round($bytes / 1_024, 1) . ' KB';
        return $bytes . ' B';
    }
 
    /** File extension, lowercase */
    public function extension(): string
    {
        return strtolower(pathinfo($this->original_name, PATHINFO_EXTENSION));
    }
 
    /** Category for icon rendering: pdf | word | excel | image | archive | other */
    public function fileCategory(): string
    {
        return match(true) {
            $this->extension() === 'pdf'                          => 'pdf',
            in_array($this->extension(), ['doc', 'docx'])         => 'word',
            in_array($this->extension(), ['xls', 'xlsx'])         => 'excel',
            in_array($this->extension(), ['jpg','jpeg','png','gif','webp']) => 'image',
            in_array($this->extension(), ['zip', 'rar', '7z'])    => 'archive',
            default                                               => 'other',
        };
    }
 
    /** Generate a temporary signed download URL (private disk) */
    public function temporaryUrl(int $minutes = 5): string
    {
        return Storage::disk('private')->temporaryUrl($this->path, now()->addMinutes($minutes));
    }
 
    /** Delete file from storage when the model is deleted */
    protected static function booted(): void
    {
        static::deleting(function (TerraTaskDocument $doc) {
            Storage::disk('private')->delete($doc->path);
        });
    }
 
    // ── SCOPES ────────────────────────────────────────────────
 
    public function scopeForUser($query, int $userId)
    {
        return $query->where('uploaded_by', $userId);
    }
 
    public function scopeImages($query)
    {
        return $query->whereIn('mime_type', [
            'image/jpeg', 'image/png', 'image/gif', 'image/webp',
        ]);
    }
}
