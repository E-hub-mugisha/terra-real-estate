<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Land;
use App\Models\LandImage;
use App\Models\ListingPackage;
use App\Support\ListingImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AgentLandController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $lands = Land::managedBy($user)->latest()->paginate(10);
        return view('agents.property.land.index', compact('lands'));
    }

    public function create()
    {
        $packages   = ListingPackage::where('listing_type', ['land_sale', 'land_rent'])
            ->orderByRaw("FIELD(package_tier,'basic','medium','premium')")
            ->get();

        $clients = Client::all();
        return view('agents.property.land.create', compact('packages', 'clients'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'    => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'size_sqm'     => 'required|numeric|min:1',
            'zoning'       => 'required|in:R1,R2,R3,R4,Commercial,Industrial,Agricultural',
            'land_use'     => 'nullable|string|max:100',
            'province'     => 'required|string|max:100',
            'district'     => 'required|string|max:100',
            'sector'       => 'required|string|max:100',
            'cell'         => 'required|string|max:100',
            'village'      => 'nullable|string|max:100',
            'video_url'   => 'nullable|url|max:500',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',

            'upi' => 'nullable|string|max:100',
            'title_doc'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'condition'       => 'required',
            'negotiable'  => 'required|in:negotiable,non_negotiable',

            // ── new fields ────────────────────────────────────────────
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',

            // owner info
            
            'client_id'          => 'nullable|exists:clients,id',
        ]);

        if ($request->hasFile('title_doc')) {
            $data['title_doc_path'] = $request->file('title_doc')->store('land_titles', 'public');
        }

        // Resolve the agent record for the logged-in user
        // Agents, property owners and partners can all list; only agents carry an agent profile.
        $agent = Auth::user()->agent;

        $data['user_id'] = auth()->id();
        $data['agent_id'] = $agent?->id;
        $data['owner_user_id'] = Auth::user()->isOwner() ? Auth::id() : null;
        $data['partner_id'] = Auth::user()->isPartner() ? Auth::id() : null;
        $data['added_by'] = Auth::id();
        $data['status'] = 'available';
        $data['listing_status'] = 'pending_payment'; // ← locked until paid

        $land = Land::create($data);

        // ✅ Upload images (FIXED FOR SHARED HOSTING)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {  // ✅ removed the bad assignment
                $destinationPath = 'image/lands/';

                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $image->move($destinationPath, $filename);  // ✅ now correctly calls move() on the single file

                LandImage::create([
                    'land_id'   => $land->id,
                    'image_path' => $filename
                ]);
            }
        }

        // ── Resolve listing fee from the chosen package ────────────────────────
        $package    = \App\Models\ListingPackage::findOrFail($data['listing_package_id']);
        $listingFee = $package->price_per_day * $data['listing_days']; // e.g. 15000 RWF

        // ── Create the pending payment record ─────────────────────────────────
        $payment = \App\Models\ListingPayment::create([
            'payable_type'    => Land::class,       // polymorphic type
            'payable_id'      => $land->id,
            'listing_package_id' => $land->listing_package_id,
            'days'               => $land->listing_days,
            'user_id'         => auth()->id(),
            'payment_purpose' => 'listing_fee',
            'amount'          => $listingFee,
            'currency'        => $data['currency'],
            'status'          => 'pending',
        ]);

        // ── Redirect to payment page ───────────────────────────────────────────
        return redirect()
            ->route('payment.show', $payment->reference)
            ->with('success', 'Land listing saved! Complete your payment to publish it.');
    }
    public function show(string $id)
    {
        $land = Land::with(['user', 'images', 'planOrders.plan', 'planOrders.payment'])->findOrFail($id);
        $this->authorizeOwner($land);

        return view('agents.property.land.show', compact('land'));
    }

    public function edit(Land $land)
    {
        $this->authorizeOwner($land);
        $land->load('images');

        return view('agents.property.land.edit', compact('land'));
    }

    public function update(Request $request, Land $land)
    {
        $this->authorizeOwner($land);

        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'upi'             => 'nullable|string|max:100',
            'condition'       => 'required|in:for_rent,for_sale',
            'status'          => 'required|in:available,reserved,sold,rented',
            'price'           => 'required|numeric|min:0',
            'currency'        => 'required|string|max:10',
            'negotiable'      => 'required|in:negotiable,non_negotiable',
            'size_sqm'        => 'required|numeric|min:1',
            'zoning'          => 'required|in:R1,R2,R3,R4,Commercial,Industrial,Agricultural',
            'land_use'        => 'nullable|string|max:100',
            'description'     => 'nullable|string',
            'province'        => 'required|string|max:100',
            'district'        => 'required|string|max:100',
            'sector'          => 'required|string|max:100',
            'cell'            => 'required|string|max:100',
            'village'         => 'nullable|string|max:100',
            'latitude'        => 'nullable|numeric|between:-90,90',
            'longitude'       => 'nullable|numeric|between:-180,180',
            'video_url'       => 'nullable|url|max:500',
            'images'          => 'nullable|array|max:20',
            'images.*'        => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'delete_images'   => 'nullable|array',
            'delete_images.*' => 'integer',
        ]);

        DB::transaction(function () use ($request, $land, $data) {
            $needsReview = $land->is_approved && (
                (float) $land->price !== (float) $data['price'] || $land->title !== $data['title']
            );

            $land->update(collect($data)->except(['images', 'delete_images'])->all()
                + ($needsReview ? ['is_approved' => false] : []));

            $land->images()->whereIn('id', $request->input('delete_images', []))->get()
                ->each(fn ($img) => ListingImages::delete($img, self::IMAGE_DIR));

            ListingImages::store($request->file('images', []), self::IMAGE_DIR,
                fn ($filename) => LandImage::create(['land_id' => $land->id, 'image_path' => $filename]));
        });

        $message = $land->is_approved ? 'Land updated.' : 'Land updated and sent to the Terra team for review.';

        return redirect()->route('agent.properties.lands.show', $land->id)->with('success', $message);
    }

    public function destroy(Land $land)
    {
        $this->authorizeOwner($land);

        DB::transaction(function () use ($land) {
            $land->images->each(fn ($img) => ListingImages::delete($img, self::IMAGE_DIR));
            $land->delete();
        });

        return redirect()->route('agent.properties.land.index')->with('success', 'Land deleted.');
    }

    public function uploadImages(Request $request, Land $land)
    {
        $this->authorizeOwner($land);
        $request->validate([
            'images'   => 'required|array|min:1|max:20',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $count = ListingImages::store($request->file('images', []), self::IMAGE_DIR,
            fn ($filename) => LandImage::create(['land_id' => $land->id, 'image_path' => $filename]));

        return back()->with('success', $count . ' ' . Str::plural('photo', $count) . ' uploaded.');
    }

    public function downloadImages(Land $land)
    {
        $this->authorizeOwner($land);

        return ListingImages::zip($land->images, self::IMAGE_DIR, 'land-' . $land->id . '-' . $land->title)
            ?? back()->with('error', 'This plot has no photos to download yet.');
    }

    public function deleteImage(Request $request, Land $land, LandImage $image)
    {
        $this->authorizeOwner($land);
        abort_unless($image->land_id === $land->id, 404);

        ListingImages::delete($image, self::IMAGE_DIR);

        return $request->expectsJson()
            ? response()->json(['success' => true])
            : back()->with('success', 'Photo removed.');
    }

    private const IMAGE_DIR = 'image/lands';

    private function authorizeOwner(Land $land): void
    {
        abort_unless($land->isManagedBy(Auth::user()), 403, 'You can only manage your own listings.');
    }
}
