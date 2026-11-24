<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ListingDocument extends Model
{
    public const TYPES = [
        'title_deed' => 'Title deed',
        'permit'     => 'Building permit',
        'plan'       => 'Plans / drawings',
        'survey'     => 'Survey / UPI map',
        'other'      => 'Other',
    ];

    protected $fillable = [
        'listable_type', 'listable_id', 'user_id', 'title', 'type', 'path',
        'original_name', 'size', 'is_public', 'status',
    ];

    protected $casts = ['is_public' => 'boolean'];

    public function listable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function typeLabel(): string
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }
}
