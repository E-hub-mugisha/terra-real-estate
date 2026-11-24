<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\ArchitecturalDesign;
use App\Models\House;
use App\Models\Land;
use App\Services\Marketplace\InquiryService;
use App\Support\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        $approvedHouses = fn () => House::with(['images', 'listingPackage'])
            ->where('is_approved', true)->where('status', 'available');
        $approvedLands = fn () => Land::with(['images', 'listingPackage'])
            ->where('is_approved', true)->where('status', 'available');
        $approvedDesigns = fn () => ArchitecturalDesign::with(['images', 'category', 'listingPackage'])
            ->where('status', 'approved');

        $latest = Listing::collect(
            $approvedHouses()->latest()->take(8)->get(),
            $approvedLands()->latest()->take(4)->get(),
        )->take(8);

        $rentals = Listing::collect($approvedHouses()->where('condition', 'for_rent')->latest()->take(8)->get());
        $designs = Listing::collect($approvedDesigns()->latest()->take(8)->get());

        $counts = [
            'sale_houses' => $approvedHouses()->where('condition', 'for_sale')->count(),
            'rent_houses' => $approvedHouses()->where('condition', 'for_rent')->count(),
            'lands'       => $approvedLands()->count(),
            'designs'     => $approvedDesigns()->count(),
            'agents'      => Agent::where('is_verified', true)->count(),
        ];

        // Listings per province (houses + lands)
        $byProvince = fn ($model) => $model::where('is_approved', true)->where('status', 'available')
            ->whereNotNull('province')
            ->select('province', DB::raw('count(*) as total'))
            ->groupBy('province')
            ->pluck('total', 'province');
        $districts = $byProvince(House::class)
            ->mergeRecursive($byProvince(Land::class))
            ->map(fn ($total) => array_sum((array) $total))
            ->sortDesc();

        $agents = Agent::where('is_verified', true)
            ->with(['user' => fn ($q) => $q->withCount(['houses', 'lands'])])
            ->latest()
            ->take(4)
            ->get();

        // Paid packages: premium → homepage pop-up; premium + basic/medium within their ad days → sponsored strip.
        $promotions = app(\App\Services\Marketplace\PromotionService::class);
        $spotlight = Listing::collect($promotions->spotlight());
        $sponsored = Listing::collect($promotions->adRotation());

        // Hero carousel: premium listings; if none are running, the newest listings with photos.
        $heroPremium = $spotlight->isNotEmpty();
        $heroSlides = ($heroPremium ? $spotlight : $latest->filter(fn ($i) => $i['image']))->take(6)->values();

        return view('front.index', compact('latest', 'rentals', 'designs', 'counts', 'districts', 'agents', 'spotlight', 'sponsored', 'heroSlides', 'heroPremium'));
    }

    public function agents(Request $request)
    {
        $agents = Agent::where('is_verified', true)
            ->with(['user' => fn ($q) => $q->withCount(['houses', 'lands', 'architecturalDesigns'])])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%' . $request->q . '%';
                $query->where(fn ($q) => $q->where('full_name', 'like', $term)
                    ->orWhere('office_location', 'like', $term)
                    ->orWhere('district', 'like', $term)
                    ->orWhere('province', 'like', $term));
            })
            ->orderBy('full_name')
            ->get();

        return view('front.agents', compact('agents'));
    }

    public function agentDetails(Request $request, Agent $agent)
    {
        $houses = $lands = $designs = collect();

        if ($agent->user) {
            $houses = $agent->user->houses()->with(['images', 'listingPackage'])
                ->where('is_approved', true)->where('status', 'available')->latest()->get();
            $lands = $agent->user->lands()->with(['images', 'listingPackage'])
                ->where('is_approved', true)->where('status', 'available')->latest()->get();
            $designs = $agent->user->architecturalDesigns()->with(['images', 'category', 'listingPackage'])
                ->where('status', 'approved')->latest()->get();
        }

        $agent->recordView($request);

        return view('front.agent-details', compact('agent', 'houses', 'lands', 'designs'));
    }

    public function homes()
    {
        $homes = House::with(['listingPackage', 'images'])->where('is_approved', true)->with('images')->get();
        return view('front.buy.homes', compact('homes'));
    }

    public function homeDetails(Request $request, House $home)
    {
        $relatedHomes = House::where('condition', $home->condition)
            ->where('id', '!=', $home->id)
            ->where('status', 'available') // optional
            ->with('images')
            ->where('is_approved', true)
            ->latest()
            ->limit(4)
            ->get();

        $home->recordView($request);
        return view('front.buy.home-details', compact('home', 'relatedHomes'));
    }

    public function lands()
    {
        $lands = Land::where('is_approved', true)->with(['listingPackage', 'images'])->get();
        return view('front.buy.lands', compact('lands'));
    }

    public function landDetails(Request $request, Land $land)
    {
        $relatedLands = Land::where('condition', $land->condition)
            ->where('id', '!=', $land->id)
            ->where('status', 'available') // optional
            ->with('images')
            ->where('is_approved', true)
            ->latest()
            ->limit(4)
            ->get();
        $land->recordView($request);
        return view('front.buy.land-details', compact('land', 'relatedLands'));
    }
    // Send inquiry to the seller
    public function sendInquiry(Request $request)
    {
        $request->validate([
            'home_id' => 'required|exists:houses,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:30',
            'message' => 'required|string|max:2000',
        ]);

        $home = House::findOrFail($request->home_id);
        app(InquiryService::class)->record($home, $request, new \App\Mail\HomeInquiryMail($request->all(), $home));

        return redirect()->back()->with('success', 'Your inquiry has been sent. The owner will get back to you soon.');
    }
    public function apartmentsRent()
    {
        $homes = House::where('type', 'apartment')->where('is_approved', true)->where('status', 'available')->where('condition', 'for_rent')->get();
        return view('front.rent.apartments', compact('homes'));
    }
    public function shortStaysRent()
    {
        $homes = House::where('type', 'short-stay')->where('is_approved', true)->where('status', 'available')->where('condition', 'for_rent')->get();
        return view('front.rent.short-stays', compact('homes'));
    }
    public function rentNearMe(Request $request)
    {
        $area = $request->area;

        $homes = House::where('condition', 'for_rent')
            ->where('district', 'LIKE', '%' . $area . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('front.rent.near-me', compact('homes', 'area'));
    }
    public function agentNearMe(Request $request)
    {
        $area = $request->area;

        $agents = Agent::where('is_verified', true)
            ->with(['user' => fn ($q) => $q->withCount(['houses', 'lands', 'architecturalDesigns'])])
            ->where('office_location', 'LIKE', '%' . $area . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('front.agents.agents-near-me', compact('agents', 'area'));
    }

    // BUY LISTINGS
    public function buy(Request $request)
    {
        $homes = House::with(['listingPackage', 'images'])
            ->where('is_approved', true)
            ->latest()
            ->get();

        $lands = Land::with(['listingPackage', 'images'])
            ->where('is_approved', true)
            ->latest()
            ->get();

        $designs = ArchitecturalDesign::with(['category', 'listingPackage', 'images'])
            ->where('status', 'approved')
            ->latest()
            ->get();


        return view('front.properties.buy', compact('homes', 'lands', 'designs'));
    }


    // ─────────────────────────────────────────────────────────────────────────────
    // OPTIONAL — If you want server-side filtering/search via AJAX:
    // Add this extra method and wire it to a route like: GET /api/properties/search
    // ─────────────────────────────────────────────────────────────────────────────


    public function rentLands()
    {
        $lands = Land::where('is_approved', true)->with(['listingPackage', 'images'])->where('condition', 'for_rent')->get();

        return view('front.rent.index', compact('lands'));
    }

    public function rentHomes()
    {


        $homes = House::with(['listingPackage', 'images'])->where('is_approved', true)->with('images')->where('condition', 'for_rent')->get();

        return view('front.rent.homes', compact('homes'));
    }

    // Send inquiry to the seller
    public function sendLandInquiry(Request $request)
    {
        $request->validate([
            'land_id' => 'required|exists:lands,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:30',
            'message' => 'required|string|max:2000',
        ]);

        $land = Land::findOrFail($request->land_id);
        app(InquiryService::class)->record($land, $request, new \App\Mail\LandInquiryMail($request->all(), $land));

        return redirect()->back()->with('success', 'Your inquiry has been sent. The owner will get back to you soon.');
    }

    public function propertiesByProvince($province)
    {
        $homes = House::where('province', $province)->with('listingPackage')->where('is_approved', true)->where('status', 'available')->get();
        $lands = Land::where('province', $province)->with('listingPackage')->where('is_approved', true)->where('status', 'available')->get();


        return view('front.properties.by_province', compact('province', 'homes', 'lands'));
    }
}
