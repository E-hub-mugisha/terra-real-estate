<?php

namespace App\Support;

use App\Models\ArchitecturalDesign;
use App\Models\House;
use App\Models\Land;
use Illuminate\Database\Eloquent\Model;

/**
 * Turns "house|land|design" + id into a model (and back) for URLs and forms.
 */
class ListingRef
{
    public const TYPES = [
        'house'  => House::class,
        'land'   => Land::class,
        'design' => ArchitecturalDesign::class,
    ];

    public static function resolve(string $type, int|string $id): Model
    {
        $class = self::TYPES[$type] ?? abort(404);

        return $class::findOrFail($id);
    }

    public static function type(Model $listing): string
    {
        return array_search(get_class($listing), self::TYPES, true) ?: 'house';
    }

    public static function label(Model $listing): string
    {
        return ['house' => 'House', 'land' => 'Land', 'design' => 'Design'][self::type($listing)];
    }

    /** Admin/room URL to edit a listing. */
    public static function editUrl(Model $listing): string
    {
        return match (self::type($listing)) {
            'house' => route('agent.properties.houses.edit', $listing->id),
            'land' => route('agent.properties.lands.edit', $listing->id),
            default => route('agent.designs.edit', $listing->id),
        };
    }

    public static function showUrl(Model $listing): string
    {
        return match (self::type($listing)) {
            'house' => route('agent.properties.houses.show', $listing->id),
            'land' => route('agent.properties.lands.show', $listing->id),
            default => route('agent.designs.show', $listing->id),
        };
    }

    public static function adminUrl(Model $listing): string
    {
        return match (self::type($listing)) {
            'house' => route('admin.properties.houses.show', $listing->id),
            'land' => route('admin.properties.lands.show', $listing->id),
            default => route('admin.properties.architectural-designs.show', $listing->id),
        };
    }

    /** All listings a query callback returns, across the three types. */
    public static function collect(callable $scope): \Illuminate\Support\Collection
    {
        return collect(self::TYPES)->flatMap(fn ($class) => $scope($class::query())->get());
    }
}
