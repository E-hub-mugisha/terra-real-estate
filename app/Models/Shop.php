<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Shop extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_PENDING   = 'pending';
    const STATUS_APPROVED  = 'approved';
    const STATUS_REJECTED  = 'rejected';
    const STATUS_SUSPENDED = 'suspended';

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'logo',
        'cover_image',
        'phone',
        'whatsapp_number',
        'email',
        'district',
        'province',
        'sector',
        'address',
        'status',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'is_featured',
        'views_count',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Shop $shop) {
            if (empty($shop->slug)) {
                $shop->slug = static::generateUniqueSlug($shop->name);
            }
        });
    }

    public static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $i = 1;

        while (static::withTrashed()->where('slug', $slug)->exists()) {
            $slug = "{$original}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePending(Builder $q): Builder
    {
        return $q->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved(Builder $q): Builder
    {
        return $q->where('status', self::STATUS_APPROVED);
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function materialProducts()
    {
        return $this->hasMany(MaterialProduct::class);
    }
}
