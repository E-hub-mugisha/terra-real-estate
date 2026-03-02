<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\ArchitecturalDesign;
use App\Models\Facility;
use App\Models\House;
use App\Models\Land;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        $houses = House::where('is_approved', true)
            ->where('status', 'available')
            ->get();

        $lands = Land::where('is_approved', true)
            ->where('status', 'available')
            ->get();

        $forRentHouses = House::where('condition', 'for_rent')
            ->where('is_approved', true)
            ->where('status', 'available')
            ->get();

        $forSellHouses = House::where('condition', 'for_sale')
            ->where('is_approved', true)
            ->where('status', 'available')
            ->get();

        // GROUP HOUSES
        $groupHouses = House::where('is_approved', true)
            ->where('status', 'available')
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->pluck('total', 'city');

        // GROUP LANDS
        $groupLands = Land::where('is_approved', true)
            ->where('status', 'available')
            ->select('district', DB::raw('count(*) as total'))
            ->groupBy('district')
            ->pluck('total', 'district');

        // Merge districts
        $allDistricts = $groupHouses->keys()
            ->merge($groupLands->keys())
            ->unique();

        $districts = $allDistricts->mapWithKeys(function ($district) use ($groupHouses, $groupLands) {
            return [
                $district => [
                    'houses' => $groupHouses[$district] ?? 0,
                    'lands'  => $groupLands[$district] ?? 0,
                    'total'  => ($groupHouses[$district] ?? 0) + ($groupLands[$district] ?? 0),
                ]
            ];
        });

        $agents = Agent::where('is_verified', true)->get();

        $designs = ArchitecturalDesign::with('category')
            ->where('status', 'approved')->get();

        $serviceCategories = ServiceCategory::where('is_active', 1)
            ->take(4) // optional
            ->get();

        return view('front.index', compact(
            'houses',
            'lands',
            'forRentHouses',
            'forSellHouses',
            'districts',
            'agents',
            'designs',
            'serviceCategories'
        ));
    }

    public function about()
    {
        return view('front.about');
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function agents()
    {
        $agents = Agent::where('is_verified', true)->get();

        return view('front.agents', compact('agents'));
    }

    public function agentDetails(Agent $agent)
    {
        $reviews = $agent->reviews()->latest()->get();
        $averageRating = round($agent->reviews()->avg('rating'), 1);
        return view('front.agent-details', compact('agent', 'reviews', 'averageRating'));
    }

    public function homes()
    {
        $homes = House::where('type', 'house')->where('is_approved', true)->where('status', 'available')->get();
        return view('front.buy.homes', compact('homes'));
    }

    public function homeDetails(House $home)
    {
        $relatedHomes = House::where('service_id', $home->service_id)
            ->where('id', '!=', $home->id)
            ->where('status', 'available') // optional
            ->latest()
            ->limit(4)
            ->get();
        return view('front.buy.home-details', compact('home', 'relatedHomes'));
    }

    public function lands()
    {
        $lands = Land::where('is_approved', true)->where('status', 'available')->get();
        return view('front.buy.lands', compact('lands'));
    }

    public function landDetails(Land $land)
    {
        $relatedLands = Land::where('service_id', $land->service_id)
            ->where('id', '!=', $land->id)
            ->where('status', 'available') // optional
            ->latest()
            ->limit(4)
            ->get();
        return view('front.buy.land-details', compact('land', 'relatedLands'));
    }

    public function addLand()
    {
        $services = Service::all();
        return view('front.properties.add-land', compact('services'));
    }

    public function addHouse()
    {
        $facilities = Facility::all();
        $services = Service::all();
        return view('front.properties.add-house', compact('facilities', 'services'));
    }

    public function addProperty()
    {
        $facilities = Facility::all();
        $services = Service::all();
        return view('front.properties.add', compact('facilities', 'services'));
    }
    // Send inquiry to the seller
    public function sendInquiry(Request $request)
    {
        $request->validate([
            'home_id' => 'required|exists:houses,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        $home = House::findOrFail($request->home_id);

        // Example: send email to the seller
        Mail::to($home->user->email)->send(new \App\Mail\HomeInquiryMail($request->all(), $home));

        // SweetAlert success
        return redirect()->back()->with('success', 'Your inquiry has been sent successfully!');
    }

    public function homesRent()
    {
        $homes = House::where('type', 'house')->where('is_approved', true)->where('status', 'available')->where('condition', 'for_rent')->get();
        return view('front.rent.homes', compact('homes'));
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
            ->where('address', 'LIKE', '%' . $area . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('front.rent.near-me', compact('homes', 'area'));
    }
    public function agentNearMe(Request $request)
    {
        $area = $request->area;

        $agents = Agent::where('is_verified', true)
            ->where('office_location', 'LIKE', '%' . $area . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('front.agents.agents-near-me', compact('agents', 'area'));
    }

    public function ourServices()
    {
        $serviceCategories = ServiceCategory::where('is_active', 1)->get();
        return view('front.our-service', compact('serviceCategories'));
    }
}
