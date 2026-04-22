<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdvertisementPackage extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'duration_days', 'price',
        'allows_video', 'max_images', 'featured_homepage',
        'featured_listings', 'priority_placement', 'badge_label',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'allows_video'        => 'boolean',
        'featured_homepage'   => 'boolean',
        'featured_listings'   => 'boolean',
        'priority_placement'  => 'boolean',
        'is_active'           => 'boolean',
        'badge_label'         => 'array',
    ];

    public function advertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'RWF ' . number_format($this->price);
    }

    /**
     * Seed the three default packages.
     * Call from DatabaseSeeder or a dedicated AdvertisementPackageSeeder.
     */
    public static function seedDefaults(): void
    {
        $packages = [
            [
                'name'               => 'Basic',
                'slug'               => 'basic',
                'description'        => 'Get your property noticed with a standard listing placement for 7 days.',
                'duration_days'      => 7,
                'price'              => 10000,
                'allows_video'       => false,
                'max_images'         => 3,
                'featured_homepage'  => false,
                'featured_listings'  => false,
                'priority_placement' => false,
                'badge_label'        => null,
                'sort_order'         => 1,
            ],
            [
                'name'               => 'Standard',
                'slug'               => 'standard',
                'description'        => 'Feature your listing with images and video for 14 days in the featured section.',
                'duration_days'      => 14,
                'price'              => 25000,
                'allows_video'       => true,
                'max_images'         => 6,
                'featured_homepage'  => false,
                'featured_listings'  => true,
                'priority_placement' => false,
                'badge_label'        => ['text' => 'Popular', 'color' => 'green'],
                'sort_order'         => 2,
            ],
            [
                'name'               => 'Premium',
                'slug'               => 'premium',
                'description'        => 'Maximum exposure — homepage feature, priority placement, images & video for 30 days.',
                'duration_days'      => 30,
                'price'              => 50000,
                'allows_video'       => true,
                'max_images'         => 10,
                'featured_homepage'  => true,
                'featured_listings'  => true,
                'priority_placement' => true,
                'badge_label'        => ['text' => 'Best Value', 'color' => 'amber'],
                'sort_order'         => 3,
            ],
        ];

        foreach ($packages as $pkg) {
            static::updateOrCreate(['slug' => $pkg['slug']], $pkg);
        }
    }
}