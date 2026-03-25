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
            'type'        => 'required|string|max:100',
            'upi'         => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'area_sqft'   => 'required|integer|min:1',
            'status'      => 'required|in:available,reserved,sold',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'garages'     => 'required|integer|min:0',
            'description' => 'required|string',

            'province'    => 'required|string|max:100',
            'district'    => 'nullable|string|max:100',
            'sector'      => 'nullable|string|max:20',
            'cell'        => 'required|string|max:100',
            'village'     => 'required|string|max:255',

            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'facilities'  => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'service_id'  => 'required|exists:services,id',

            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',

            'owner_name'      => 'required|string|max:255',
            'owner_email'     => 'nullable|email|max:255',
            'owner_phone'     => 'required|string|max:30',
            'owner_id_number' => 'nullable|string|max:50',
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
                'service_id'  => $data['service_id'],
                'agent_id'    => $agent->id,
                'added_by'    => Auth::id(),

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
            if (!empty($data['facilities'])) {
                $house->facilities()->sync($data['facilities']);
            }

            // Images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('houses', 'public');

                    $house->images()->create([
                        'image_path' => $path
                    ]);
                }
            }

            return $house;
        });

        return redirect()->route('plans.select', [
            'type' => 'house',
            'id'   => $house->id
        ])->with('success', 'Property added successfully and sent for approval!');
    }

    public function show(string $id)
    {
        $house = House::with(['images', 'facilities'])->findOrFail($id);
        return view('agents.property.house.show', compact('house'));
    }
}
