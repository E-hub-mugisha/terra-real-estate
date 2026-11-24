<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Facility;
use App\Models\House;
use App\Models\HouseImage;
use App\Models\ListingPackage;
use App\Support\ListingImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentHouseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $houses = House::managedBy($user)->latest()->paginate(10);

        return view('agents.property.house.index', compact('houses'));
    }

    public function create()
    {
        $facilities = Facility::all();
        $packages   = ListingPackage::where('listing_type', ['house_sale', 'house_rent'])
            ->orderByRaw("FIELD(package_tier,'basic','medium','premium')")
            ->get();
        return view('agents.property.house.create', compact('facilities', 'packages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'upi'         => 'nullable|string|max:255',
            'type'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'area_sqft'   => 'nullable|integer|min:1',
            'condition'   => 'required|in:for_rent,for_sale',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'garages'     => 'required|integer|min:0',
            'description' => 'required|string',
            'negotiable'  => 'required|in:negotiable,non_negotiable',
            'currency'    => 'required|string|max:10',

            'province'    => 'required|string|max:100',
            'district'    => 'nullable|string|max:100',
            'sector'      => 'nullable|string|max:20',
            'cell'        => 'required|string|max:100',
            'village'     => 'required|string|max:255',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',

            'images.*'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'facilities'   => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'video_url'    => ['nullable', 'url', 'max:500'],

            // ── new fields ────────────────────────────────────────────
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',

            // owner info
            'client_id'          => 'nullable|exists:clients,id',
            // duplicate 'currency' rule removed — it was declared twice above
        ]);

        // Get agent
        // Agents, property owners and partners can all list; only agents carry an agent profile.
        $agent = Auth::user()->agent;

        // NOTE: $payment must be captured by reference so it's visible after the closure runs
        $payment = null;

        $house = DB::transaction(function () use ($request, $data, $agent, &$payment) {

            $house = House::create([
                'user_id'     => auth()->id(),
                'title'       => $data['title'],
                'upi'         => $data['upi'],
                'type'        => $data['type'],
                'condition'   => $data['condition'],
                'price'       => $data['price'],
                'area_sqft'   => $data['area_sqft'],
                'bedrooms'    => $data['bedrooms'],
                'bathrooms'   => $data['bathrooms'],
                'garages'     => $data['garages'],
                'description' => $data['description'],
                'province'    => $data['province'],
                'district'    => $data['district'] ?? null,
                'sector'      => $data['sector'] ?? null,
                'cell'        => $data['cell'],
                'village'     => $data['village'],
                'agent_id'    => $agent?->id,
                'owner_user_id' => Auth::user()->isOwner() ? Auth::id() : null,
                'partner_id'    => Auth::user()->isPartner() ? Auth::id() : null,
                'added_by'    => Auth::id(),
                'listing_status' => 'pending_payment',

                'negotiable'  => $data['negotiable'],
                'latitude'    => $data['latitude'] ?? null,
                'longitude'   => $data['longitude'] ?? null,
                'video_url'   => $data['video_url'] ?? null,
                'client_id'   => $data['client_id'] ?? null,
                'currency'    => $data['currency'],
                'listing_package_id' => $data['listing_package_id'],
                'listing_days'       => $data['listing_days'],
            ]);

            // Facilities
            if ($request->filled('facilities')) {
                $house->facilities()->sync($request->facilities);
            }

            // Upload images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $destinationPath = 'image/houses/';

                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $image->move($destinationPath, $filename);

                    HouseImage::create([
                        'house_id'   => $house->id,
                        'image_path' => $filename,
                    ]);
                }
            }

            // ── Resolve listing fee from the chosen package ─────────────────
            $package    = \App\Models\ListingPackage::findOrFail($data['listing_package_id']);
            $listingFee = $package->price_per_day * $data['listing_days'];

            // ── Create the pending payment record ───────────────────────────
            $payment = \App\Models\ListingPayment::create([
                'payable_type'    => House::class,
                'payable_id'      => $house->id,
                'listing_package_id' => $house->listing_package_id,
                'days'               => $house->listing_days,
                'user_id'         => auth()->id(),
                'payment_purpose' => 'listing_fee',
                'amount'          => $listingFee,
                'currency'        => $data['currency'],
                'status'          => 'pending',
            ]);

            return $house;
        });

        // ── Redirect to payment page ─────────────────────────────────────────
        return redirect()
            ->route('payment.show', $payment->reference)
            ->with('success', 'House listing saved! Complete your payment to publish it.');
    }

    public function show(string $id)
    {
        $house = House::with(['images', 'facilities'])->findOrFail($id);
        $this->authorizeOwner($house);

        return view('agents.property.house.show', compact('house'));
    }

    public function edit(House $house)
    {
        $this->authorizeOwner($house);
        $house->load(['images', 'facilities']);
        $facilities = Facility::orderBy('name')->get();

        return view('agents.property.house.edit', compact('house', 'facilities'));
    }

    public function update(Request $request, House $house)
    {
        $this->authorizeOwner($house);

        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'upi'           => 'nullable|string|max:255',
            'type'          => 'required|string|max:100',
            'condition'     => 'required|in:for_rent,for_sale',
            'status'        => 'required|in:available,reserved,sold,rented',
            'price'         => 'required|numeric|min:0',
            'currency'      => 'required|string|max:10',
            'negotiable'    => 'required|in:negotiable,non_negotiable',
            'area_sqft'     => 'nullable|integer|min:1',
            'bedrooms'      => 'required|integer|min:0|max:50',
            'bathrooms'     => 'required|integer|min:0|max:50',
            'garages'       => 'required|integer|min:0|max:50',
            'description'   => 'required|string',
            'province'      => 'required|string|max:100',
            'district'      => 'nullable|string|max:100',
            'sector'        => 'nullable|string|max:100',
            'cell'          => 'required|string|max:100',
            'village'       => 'required|string|max:255',
            'latitude'      => 'nullable|numeric|between:-90,90',
            'longitude'     => 'nullable|numeric|between:-180,180',
            'video_url'     => 'nullable|url|max:500',
            'facilities'    => 'nullable|array',
            'facilities.*'  => 'exists:facilities,id',
            'images'        => 'nullable|array|max:20',
            'images.*'      => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer',
        ]);

        DB::transaction(function () use ($request, $house, $data) {
            // Price/description changes on a live listing go back to review.
            $needsReview = $house->is_approved && (
                (float) $house->price !== (float) $data['price'] || $house->title !== $data['title']
            );

            $house->update(collect($data)->except(['facilities', 'images', 'delete_images'])->all()
                + ($needsReview ? ['is_approved' => false] : []));

            $house->facilities()->sync($request->input('facilities', []));

            $house->images()->whereIn('id', $request->input('delete_images', []))->get()
                ->each(fn ($img) => ListingImages::delete($img, self::IMAGE_DIR));

            ListingImages::store($request->file('images', []), self::IMAGE_DIR,
                fn ($filename) => HouseImage::create(['house_id' => $house->id, 'image_path' => $filename]));
        });

        $message = $house->is_approved ? 'House updated.' : 'House updated and sent to the Terra team for review.';

        return redirect()->route('agent.properties.houses.show', $house->id)->with('success', $message);
    }

    public function destroy(House $house)
    {
        $this->authorizeOwner($house);

        DB::transaction(function () use ($house) {
            $house->images->each(fn ($img) => ListingImages::delete($img, self::IMAGE_DIR));
            $house->facilities()->detach();
            $house->delete();
        });

        return redirect()->route('agent.properties.houses.index')->with('success', 'House deleted.');
    }

    public function uploadImages(Request $request, House $house)
    {
        $this->authorizeOwner($house);
        $request->validate([
            'images'   => 'required|array|min:1|max:20',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $count = ListingImages::store($request->file('images', []), self::IMAGE_DIR,
            fn ($filename) => HouseImage::create(['house_id' => $house->id, 'image_path' => $filename]));

        return back()->with('success', $count . ' ' . \Illuminate\Support\Str::plural('photo', $count) . ' uploaded.');
    }

    public function downloadImages(House $house)
    {
        $this->authorizeOwner($house);

        return ListingImages::zip($house->images, self::IMAGE_DIR, 'house-' . $house->id . '-' . $house->title)
            ?? back()->with('error', 'This house has no photos to download yet.');
    }

    public function deleteImage(Request $request, House $house, HouseImage $image)
    {
        $this->authorizeOwner($house);
        abort_unless($image->house_id === $house->id, 404);

        ListingImages::delete($image, self::IMAGE_DIR);

        return $request->expectsJson()
            ? response()->json(['success' => true])
            : back()->with('success', 'Photo removed.');
    }

    private const IMAGE_DIR = 'image/houses';

    private function authorizeOwner(House $house): void
    {
        abort_unless($house->isManagedBy(Auth::user()), 403, 'You can only manage your own listings.');
    }
}
