<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MaterialProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id',
        'material_category_id',
        'material_subcategory_id',
        'title',
        'slug',
        'description',
        'price',
        'currency',
        'unit',
        'min_order_quantity',
        'stock_status',
        'status',
        'rejection_reason',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (MaterialProduct $product) {
            if (empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->title);
            }
        });
    }

    public static function generateUniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-" . $i++;
        }

        return $slug;
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MaterialCategory::class, 'material_category_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(MaterialSubcategory::class, 'material_subcategory_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(MaterialProductImage::class)->orderBy('order');
    }

    // MaterialProduct.php
    public function primaryImage()
    {
        if ($this->relationLoaded('images')) {
            return $this->images->firstWhere('is_primary', true) ?? $this->images->first();
        }

        return $this->images()->where('is_primary', true)->first()
            ?? $this->images()->first();
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * WhatsApp link pre-filled with this specific product, sent to the shop's number.
     */
    public function whatsappLink(): string
    {
        $number = preg_replace('/\D/', '', $this->shop->whatsapp_number);
        if (str_starts_with($number, '0')) {
            $number = '25' . $number;
        }

        $priceText = $this->price
            ? number_format((float) $this->price) . ' ' . $this->currency . ($this->unit ? " ({$this->unit})" : '')
            : 'price on request';

        $text = "Hello {$this->shop->name}, I'm interested in \"{$this->title}\" ({$priceText}) that I saw on Terra. Is it still available?";

        return 'https://wa.me/' . $number . '?text=' . urlencode($text);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved')
            ->whereHas('shop', fn($q) => $q->where('status', 'approved'));
    }

    public function scopeInCategory($query, string $categorySlug)
    {
        return $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
    }
}
