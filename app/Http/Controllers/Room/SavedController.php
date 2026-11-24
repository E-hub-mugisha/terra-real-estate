<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\SavedListing;
use App\Support\Listing;
use App\Support\ListingRef;
use Illuminate\Http\Request;

/**
 * Saved properties. Signed-in users keep them on their account; the heart buttons
 * call these endpoints, and hearts saved before signing in are merged on first sync.
 */
class SavedController extends Controller
{
    public function index(Request $request)
    {
        $saved = $request->user()->savedListings()->with('listable')->latest()->get()
            ->filter(fn ($s) => $s->listable && $s->listable->isApproved());
        $items = Listing::collect($saved->map->listable);

        return view('room.saved.index', compact('items'));
    }

    /** POST {id: "house-12"} → toggles; returns the full saved id list. */
    public function toggle(Request $request)
    {
        $request->validate(['id' => ['required', 'regex:/^(house|land|design)-\d+$/']]);
        [$type, $id] = explode('-', $request->id);
        $listing = ListingRef::resolve($type, (int) $id);

        $existing = SavedListing::where('user_id', $request->user()->id)
            ->where('listable_type', $listing->getMorphClass())->where('listable_id', $listing->getKey())->first();
        $existing ? $existing->delete() : SavedListing::create([
            'user_id' => $request->user()->id, 'listable_type' => $listing->getMorphClass(), 'listable_id' => $listing->getKey(),
        ]);

        return response()->json(['saved' => !$existing, 'ids' => $this->ids($request)]);
    }

    /** POST {ids: [...]} → merges browser hearts into the account, returns the merged list. */
    public function sync(Request $request)
    {
        $request->validate(['ids' => 'array|max:200', 'ids.*' => ['regex:/^(house|land|design)-\d+$/']]);
        foreach ($request->input('ids', []) as $ref) {
            [$type, $id] = explode('-', $ref);
            $class = ListingRef::TYPES[$type];
            if ($class::whereKey($id)->exists()) {
                SavedListing::firstOrCreate(['user_id' => $request->user()->id, 'listable_type' => $class, 'listable_id' => (int) $id]);
            }
        }

        return response()->json(['ids' => $this->ids($request)]);
    }

    private function ids(Request $request): array
    {
        return $request->user()->savedListings()->get(['listable_type', 'listable_id'])
            ->map(fn ($s) => array_search($s->listable_type, ListingRef::TYPES, true) . '-' . $s->listable_id)
            ->values()->all();
    }
}
