<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent;
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
        return view('agents.property.land.create', compact('packages'));
    }
    public function store(Request $request, CommissionService $commissions)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'    => 'required|numeric|min:0',
            'size_sqm'     => 'required|numeric|min:1',
            'zoning'       => 'required|in:R1,R2,R3,Commercial,Industrial,Agricultural',
            'land_use'     => 'nullable|string|max:100',
            'province'     => 'required|string|max:100',
            'district'     => 'required|string|max:100',
            'sector'       => 'required|string|max:100',
            'cell'         => 'required|string|max:100',
            'village'      => 'nullable|string|max:100',

            'upi' => 'nullable|string|max:100',
            'title_doc'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'status'       => 'required|in:available,reserved,sold',

            // ── new fields ────────────────────────────────────────────
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',

            // owner info
            'owner_name'         => 'required|string|max:255',
            'owner_email'        => 'nullable|email|max:255',
            'owner_phone'        => 'required|string|max:30',
            'owner_id_number'    => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('title_doc')) {
            $data['title_doc_path'] = $request->file('title_doc')->store('land_titles', 'public');
        }

        // Resolve the agent record for the logged-in user
        $agent = Agent::where('user_id', Auth::id())->with('level')->firstOrFail();

        $data['user_id'] = auth()->id();
        $data['agent_id'] = $agent->id;
        $data['added_by'] = Auth::id();
        $data['status'] = 'available';

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

        return redirect()->route(
            'plans.select',
            [
                'id' => $land->id,
                'type' => 'land'
            ]
        )->with('success', '🌍 Land listed successfully and sent for approval.');
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
}
