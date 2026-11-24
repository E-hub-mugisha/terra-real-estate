<?php

namespace App\Support;

use App\Models\ArchitecturalDesign;
use App\Models\DesignCategory;
use App\Models\House;
use App\Models\Land;
use Illuminate\Support\Facades\Cache;

/**
 * Categories for the public "Explore" panel, with live counts.
 *
 * Only the counts are cached (10 minutes). Links are built on every request so they
 * always match the host the visitor is using (php artisan serve, Apache, a subfolder…);
 * caching URLs generated from the CLI would pin them to APP_URL.
 */
class ExploreMenu
{
    public static function data(): array
    {
        $c = static::counts();

        return [
            'sections' => [
                [
                    'title' => __('Buy'),
                    'items' => [
                        ['icon' => 'home', 'label' => __('Houses for sale'), 'sub' => __('Villas, apartments, family homes'), 'url' => route('front.properties.buy', ['kind' => 'house', 'condition' => 'for_sale']), 'count' => $c['houses_sale']],
                        ['icon' => 'land', 'label' => __('Land for sale'), 'sub' => __('Residential, commercial, farm plots'), 'url' => route('front.properties.buy', ['kind' => 'land', 'condition' => 'for_sale']), 'count' => $c['land_sale']],
                    ],
                ],
                [
                    'title' => __('Rent'),
                    'items' => [
                        ['icon' => 'home', 'label' => __('Houses for rent'), 'sub' => __('Long-term homes'), 'url' => route('front.properties.buy', ['kind' => 'house', 'condition' => 'for_rent']), 'count' => $c['houses_rent']],
                        ['icon' => 'building', 'label' => __('Apartments'), 'sub' => __('Flats and serviced apartments'), 'url' => route('front.rent.apartments'), 'count' => $c['apartments_rent']],
                        ['icon' => 'land', 'label' => __('Land for rent'), 'sub' => __('Lease plots'), 'url' => route('front.properties.buy', ['kind' => 'land', 'condition' => 'for_rent']), 'count' => $c['land_rent']],
                    ],
                ],
            ],
            'types' => collect($c['types'])->map(fn ($n, $type) => ['label' => $type, 'count' => $n, 'url' => route('front.properties.buy', ['kind' => 'house', 'q' => $type])])->values()->all(),
            'designs' => [
                'total' => $c['designs'],
                'url' => route('front.properties.architecture'),
                'categories' => collect($c['design_categories'])->map(fn ($cat) => ['label' => $cat['name'], 'count' => $cat['count'], 'url' => route('front.properties.architecture', ['category' => $cat['id']])])->all(),
            ],
            'areas' => collect($c['areas'])->map(fn ($n, $area) => ['label' => $area, 'count' => $n, 'url' => route('front.properties.buy', ['q' => $area])])->values()->all(),
        ];
    }

    /** Plain numbers and names only, safe to cache. */
    private static function counts(): array
    {
        return Cache::remember('terra.explore.counts.v2', 600, function () {
            $houses = fn () => House::publiclyVisible();
            $lands = fn () => Land::publiclyVisible();

            return [
                'houses_sale' => $houses()->where('condition', 'for_sale')->count(),
                'houses_rent' => $houses()->where('condition', 'for_rent')->count(),
                'apartments_rent' => $houses()->where('condition', 'for_rent')->where('type', 'like', '%apartment%')->count(),
                'land_sale' => $lands()->where('condition', 'for_sale')->count(),
                'land_rent' => $lands()->where('condition', 'for_rent')->count(),
                'designs' => ArchitecturalDesign::publiclyVisible()->count(),
                'types' => $houses()->selectRaw('type, count(*) as total')->whereNotNull('type')->groupBy('type')->orderByDesc('total')->take(8)->pluck('total', 'type')->all(),
                'design_categories' => DesignCategory::withCount(['designs' => fn ($q) => $q->where('status', 'approved')])
                    ->orderByDesc('designs_count')->orderBy('name')->get()
                    ->map(fn ($cat) => ['id' => $cat->id, 'name' => $cat->name, 'count' => $cat->designs_count])->all(),
                'areas' => $houses()->pluck('district')->merge($lands()->pluck('district'))->filter()->countBy()->sortDesc()->take(8)->all(),
            ];
        });
    }
}
