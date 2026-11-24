<?php

namespace App\Support;

use App\Models\ArchitecturalDesign;
use App\Models\House;
use App\Models\Land;
use Illuminate\Support\Collection;

/**
 * Normalises houses, lands and architectural designs into one array shape so
 * every public listing page can share the same card, filters and sorting.
 */
class Listing
{
    public const WHATSAPP = '250796511725';

    public static function house(House $h): array
    {
        $img = $h->relationLoaded('images') ? $h->images->first() : $h->images()->first();
        $url = route('front.buy.home.details', $h);

        return [
            'kind'      => 'house',
            'kind_label'=> ucfirst(str_replace(['_', '-'], ' ', $h->type ?: 'House')),
            'id'        => $h->id,
            'title'     => $h->title ?: 'House',
            'url'       => $url,
            'image'     => $img ? asset('image/houses/' . $img->image_path) : null,
            'price'     => (float) $h->price,
            'currency'  => $h->currency ?: 'RWF',
            'condition' => $h->condition ?: 'for_sale',
            'location'  => self::location($h->sector, $h->district, $h->province),
            'province'  => (string) $h->province,
            'meta'      => array_filter([
                'beds'  => $h->bedrooms ? $h->bedrooms . ' bd' : null,
                'baths' => $h->bathrooms ? $h->bathrooms . ' ba' : null,
                'area'  => $h->area_sqft ? number_format($h->area_sqft) . ' sqft' : null,
            ]),
            'bedrooms'  => (int) $h->bedrooms,
            'lat'       => is_numeric($h->latitude) ? (float) $h->latitude : null,
            'lng'       => is_numeric($h->longitude) ? (float) $h->longitude : null,
            'featured'  => self::featured($h),
            'negotiable'=> $h->negotiable === 'negotiable',
            'created'   => optional($h->created_at)->timestamp ?? 0,
            'is_new'    => $h->created_at && $h->created_at->gt(now()->subDays(7)),
            'wa'        => self::whatsapp($h->title, $url),
        ];
    }

    public static function land(Land $l): array
    {
        $img = $l->relationLoaded('images') ? $l->images->first() : $l->images()->first();
        $url = route('front.buy.land.details', $l);

        return [
            'kind'      => 'land',
            'kind_label'=> $l->zoning ? 'Land · ' . $l->zoning : 'Land',
            'id'        => $l->id,
            'title'     => $l->title ?: 'Plot',
            'url'       => $url,
            'image'     => $img ? asset('image/lands/' . $img->image_path) : null,
            'price'     => (float) $l->price,
            'currency'  => $l->currency ?: 'RWF',
            'condition' => $l->condition ?: 'for_sale',
            'location'  => self::location($l->sector, $l->district, $l->province),
            'province'  => (string) $l->province,
            'meta'      => array_filter([
                'area'   => $l->size_sqm ? number_format($l->size_sqm) . ' m²' : null,
                'zoning' => $l->land_use ?: null,
            ]),
            'bedrooms'  => 0,
            'lat'       => is_numeric($l->latitude) ? (float) $l->latitude : null,
            'lng'       => is_numeric($l->longitude) ? (float) $l->longitude : null,
            'featured'  => self::featured($l),
            'negotiable'=> $l->negotiable === 'negotiable',
            'created'   => optional($l->created_at)->timestamp ?? 0,
            'is_new'    => $l->created_at && $l->created_at->gt(now()->subDays(7)),
            'wa'        => self::whatsapp($l->title, $url),
        ];
    }

    public static function design(ArchitecturalDesign $d): array
    {
        $img = $d->relationLoaded('images') ? $d->images->first() : $d->images()->first();
        $image = $img
            ? asset('image/architectural_designs/images/' . $img->image_path)
            : ($d->preview_image ? asset('storage/' . $d->preview_image) : null);

        return [
            'kind'      => 'design',
            'kind_label'=> optional($d->category)->name ?: 'Design',
            'id'        => $d->id,
            'title'     => $d->title ?: 'Architectural design',
            'url'       => route('front.buy.design.show', $d->slug),
            'image'     => $image,
            'price'     => $d->is_free ? 0.0 : (float) $d->price,
            'currency'  => $d->currency ?: 'RWF',
            'condition' => 'for_sale',
            'location'  => optional($d->category)->name ?: 'Architectural design',
            'province'  => '',
            'meta'      => array_filter([
                'format'    => $d->design_file ? strtoupper(pathinfo($d->design_file, PATHINFO_EXTENSION)) : null,
                'downloads' => $d->download_count ? number_format($d->download_count) . ' downloads' : null,
            ]),
            'bedrooms'  => 0,
            'free'      => (bool) $d->is_free,
            'featured'  => (bool) $d->featured || self::featured($d),
            'negotiable'=> false,
            'created'   => optional($d->created_at)->timestamp ?? 0,
            'is_new'    => $d->created_at && $d->created_at->gt(now()->subDays(7)),
            'wa'        => null,
        ];
    }

    /** Map a mixed collection of models to listing arrays, featured first then newest. */
    public static function collect(iterable ...$groups): Collection
    {
        $items = collect();
        foreach ($groups as $group) {
            foreach ($group as $model) {
                $items->push(match (true) {
                    $model instanceof House => self::house($model),
                    $model instanceof Land => self::land($model),
                    $model instanceof ArchitecturalDesign => self::design($model),
                });
            }
        }

        return $items->sort(fn ($a, $b) => [$b['featured'], $b['created']] <=> [$a['featured'], $a['created']])->values();
    }

    public static function price(array $item): string
    {
        if (($item['free'] ?? false) || $item['price'] <= 0) {
            return ($item['free'] ?? false) ? 'Free' : 'Price on request';
        }

        return number_format($item['price']);
    }

    private static function featured($model): bool
    {
        // Featured = currently running a premium package.
        $promo = $model->relationLoaded('activePromotion') ? $model->activePromotion : $model->activePromotion()->first();

        return $promo?->tier === 'premium';
    }

    private static function location(...$parts): string
    {
        return collect($parts)->filter()->unique()->take(2)->implode(', ') ?: 'Rwanda';
    }

    private static function whatsapp(?string $title, string $url): string
    {
        $message = "Hi, I'm interested in \"{$title}\" ({$url}). Could you share more details?";

        return 'https://wa.me/' . self::WHATSAPP . '?text=' . rawurlencode($message);
    }
}
