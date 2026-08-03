<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MaterialCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (MaterialCategory $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function materialSubcategories(): HasMany
    {
        return $this->hasMany(MaterialSubcategory::class)->orderBy('order');
    }

    public function activeSubcategories(): HasMany
    {
        return $this->materialSubcategories()->where('is_active', true);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(MaterialProduct::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
