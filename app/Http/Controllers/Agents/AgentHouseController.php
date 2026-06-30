<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Facility;
use App\Models\House;
use App\Models\ListingPackage;
use App\Models\Service;
use App\Services\CommissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentHouseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $houses = House::where('user_id', $user->id)->latest()->paginate(10);

        return view('agents.property.house.index', compact('houses'));
    }

    public function create()
    {
        $facilities = Facility::all();
        $services = Service::all();
        $packages   = ListingPackage::where('listing_type', 'land')
                          ->orderByRaw("FIELD(package_tier,'basic','medium','standard')")
                          ->get();
        return view('agents.property.house.create', compact('facilities', 'services','packages'));
    }

    public function store(Request $request, CommissionService $commissions)
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
            'negotiable'  => 'required|in:negotiable,non-negotiable',
            'currency'    => 'required|string|max:10',

            'province'    => 'required|string|max:100',
            'district'    => 'nullable|string|max:100',
            'sector'      => 'nullable|string|max:20',
            'cell'        => 'required|string|max:100',
            'village'     => 'required|string|max:255',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',

            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'facilities'  => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'video_url' => ['nullable', 'url', 'max:500'],

            // ── new fields ────────────────────────────────────────────
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',

            // owner info
            'client_id'          => 'nullable|exists:clients,id',
            'currency'           => 'required|string|max:10',
        ]);

        // Get agent
        $agent = Agent::where('user_id', Auth::id())
            ->with('level')
            ->firstOrFail();

        $house = DB::transaction(function () use ($request, $data, $agent, $commissions) {

            $house = House::create([
                'user_id'     => auth()->id(),
                'title'       => $data['title'],
                'upi'         => $data['upi'],
                'type'        => $data['type'],
                'price'       => $data['price'],
                'area_sqft'   => $data['area_sqft'],
                'status'      => $data['status'],
                'bedrooms'    => $data['bedrooms'],
                'bathrooms'   => $data['bathrooms'],
                'garages'     => $data['garages'],
                'description' => $data['description'],
                'province'    => $data['province'],
                'district'    => $data['district'] ?? null,
                'sector'      => $data['sector'] ?? null,
                'cell'        => $data['cell'],
                'village'     => $data['village'],
                'agent_id'    => $agent->id,
                'added_by'    => Auth::id(),
                'listing_status' => 'pending_payment',

                // ✅ Include owner fields (you forgot these)
                'owner_name'      => $data['owner_name'],
                'owner_email'     => $data['owner_email'] ?? null,
                'owner_phone'     => $data['owner_phone'],
                'owner_id_number' => $data['owner_id_number'] ?? null,
            ]);

            // Commission
            $commissions->recordListingCommission(
                agent: $agent,
                model: $house,
                type: 'house',
                listingDays: (int) $data['listing_days'],
                packageId: (int) $data['listing_package_id'],
            );

            // Agent progression
            $agent->increment('total_referrals');
            $agent->checkAndUpgradeLevel();

            // Facilities
        if ($request->filled('facilities')) {
            $house->facilities()->sync($request->facilities);
        }

        // ✅ Upload images (FIXED FOR SHARED HOSTING)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {  // ✅ removed the bad assignment
                $destinationPath = 'image/houses/';

                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $image->move($destinationPath, $filename);  // ✅ now correctly calls move() on the single file

                HouseImage::create([
                    'house_id'   => $house->id,
                    'image_path' => $filename
                ]);
            }
        }

        // ── Resolve listing fee from the chosen package ────────────────────────
        $package    = \App\Models\ListingPackage::findOrFail($data['listing_package_id']);
        $listingFee = $package->price_per_day * $data['listing_days']; // e.g. 15000 RWF

        // ── Create the pending payment record ─────────────────────────────────
        $payment = \App\Models\ListingPayment::create([
            'payable_type'    => House::class,       // polymorphic type
            'payable_id'      => $house->id,         // polymorphic id
            'user_id'         => auth()->id(),
            'payment_purpose' => 'listing_fee',
            'amount'          => $listingFee,
            'currency'        => $data['currency'],
            'status'          => 'pending',
        ]);

            return $house;
        });

        // ── Redirect to payment page ───────────────────────────────────────────
        return redirect()
            ->route('payment.show', $payment->reference)
            ->with('success', 'house listing saved! Complete your payment to publish it.');
    }

    public function show(string $id)
    {
        $house = House::with(['images', 'facilities'])->findOrFail($id);
        return view('agents.property.house.show', compact('house'));
    }
}
