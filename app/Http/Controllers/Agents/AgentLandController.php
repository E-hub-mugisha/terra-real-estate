<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Land;
use App\Models\LandImage;
use App\Models\ListingPackage;
use App\Models\Service;
use App\Services\CommissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentLandController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $lands = Land::where('user_id', $user->id)->latest()->paginate(10);
        return view('agents.property.land.index', compact('lands'));
    }

    public function create()
    {
        $packages   = ListingPackage::where('listing_type', 'land')
            ->orderByRaw("FIELD(package_tier,'basic','medium','standard')")
            ->get();

        $clients = Client::all();
        return view('agents.property.land.create', compact('packages', 'clients'));
    }
    public function store(Request $request, CommissionService $commissions)
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
            'owner_name'         => 'required|string|max:255',
            'owner_email'        => 'nullable|email|max:255',
            'owner_phone'        => 'required|string|max:30',
            'owner_id_number'    => 'nullable|string|max:50',
            'client_id'          => 'nullable|exists:clients,id',
        ]);

        if ($request->hasFile('title_doc')) {
            $data['title_doc_path'] = $request->file('title_doc')->store('land_titles', 'public');
        }

        // Resolve the agent record for the logged-in user
        $agent = Agent::where('user_id', Auth::id())->firstOrFail();

        $data['user_id'] = auth()->id();
        $data['agent_id'] = $agent->id;
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

        // ── Commission ─────────────────────────────────────────────
        // Listing fee commission (from ListingPackage + DurationDiscount)
        $commissions->recordListingCommission(
            agent: $agent,
            model: $land,
            type: 'land',
            listingDays: (int) $data['listing_days'],
            packageId: (int) $data['listing_package_id'],
        );

        // Increment referral count → auto-upgrade agent level if threshold met
        $agent->increment('total_referrals');
        $agent->checkAndUpgradeLevel();

        // ── Resolve listing fee from the chosen package ────────────────────────
        $package    = \App\Models\ListingPackage::findOrFail($data['listing_package_id']);
        $listingFee = $package->price_per_day * $data['listing_days']; // e.g. 15000 RWF

        // ── Create the pending payment record ─────────────────────────────────
        $payment = \App\Models\ListingPayment::create([
            'payable_type'    => Land::class,       // polymorphic type
            'payable_id'      => $land->id,         // polymorphic id
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
        $land = Land::with([
            'user',
            'images',
            'service',
            'planOrders.plan',
            'planOrders.payment'
        ])->findOrFail($id);
        return view('agents.property.land.show', compact('land'));
    }

    /**
     * Upload images for a land property.
     */
    public function uploadImages(Request $request, Land $land)
    {
        $request->validate([
            'images'   => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

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

        return back()->with('success', count($request->file('images')) . ' photo(s) uploaded successfully.');
    }
}
