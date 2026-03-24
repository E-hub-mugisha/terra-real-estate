<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Agent;
use App\Models\Announcement;
use App\Models\ArchitecturalDesign;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\DesignCategory;
use App\Models\Facility;
use App\Models\House;
use App\Models\Land;
use App\Models\Partner;
use App\Models\Province;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Tender;
use App\Models\TerraJob;
use App\Models\TerraJobApplication;
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
            ->select('province', DB::raw('count(*) as total'))
            ->groupBy('province')
            ->pluck('total', 'province');

        // GROUP LANDS
        $groupLands = Land::where('is_approved', true)
            ->where('status', 'available')
            ->select('province', DB::raw('count(*) as total'))
            ->groupBy('province')
            ->pluck('total', 'province');

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
            ->take(5) // optional
            ->get();

        $partners = Partner::latest()->get();
        return view('front.index', compact(
            'houses',
            'lands',
            'forRentHouses',
            'forSellHouses',
            'districts',
            'agents',
            'designs',
            'serviceCategories',
            'partners'
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

        $houses = collect();
        $lands = collect();

        if ($agent->user) {
            $houses = $agent->user->houses()
                ->where('is_approved', true)
                ->where('status', 'available')
                ->latest()
                ->get();

            $lands = $agent->user->lands()
                ->where('is_approved', true)
                ->where('status', 'available')
                ->latest()
                ->get();
        }
        return view('front.agent-details', compact('agent', 'reviews', 'averageRating', 'houses', 'lands'));
    }

    public function homes()
    {
        $homes = House::where('is_approved', true)->with('images')->where('status', 'available')->get();
        return view('front.buy.homes', compact('homes'));
    }

    public function homeDetails(House $home)
    {
        $relatedHomes = House::where('service_id', $home->service_id)
            ->where('id', '!=', $home->id)
            ->where('status', 'available') // optional
            ->with('images')
            ->latest()
            ->limit(4)
            ->get();
        return view('front.buy.home-details', compact('home', 'relatedHomes'));
    }

    public function lands()
    {
        $lands = Land::where('is_approved', true)->with('images')->where('status', 'available')->get();
        return view('front.buy.lands', compact('lands'));
    }

    public function landDetails(Land $land)
    {
        $relatedLands = Land::where('service_id', $land->service_id)
            ->where('id', '!=', $land->id)
            ->where('status', 'available') // optional
            ->with('images')
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
        $provinces = Province::all();
        return view('front.properties.add-house', compact('facilities', 'services', 'provinces'));
    }

    public function addArch()
    {
        $categories = DesignCategory::orderBy('name')->get();
        $services = Service::all();

        return view('front.properties.add-arch', compact('categories', 'services'));
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
            ->where('district', 'LIKE', '%' . $area . '%')
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

    public function serviceDetails($id)
    {
        $category = ServiceCategory::with([
            'services',
            'subcategories.services'
        ])->findOrFail($id);

        return view('front.service-detail', compact('category'));
    }

    // BUY LISTINGS
    public function buy(Request $request)
    {
        // Pass each collection separately — the view handles mixed display
        $homes = House::with('service')
            ->latest()
            ->get();

        $lands = Land::with('service')
            ->latest()
            ->get();

        $designs = ArchitecturalDesign::with(['service', 'category'])
            ->latest()
            ->get();

        return view('front.properties.buy', compact('homes', 'lands', 'designs'));
    }


    // ─────────────────────────────────────────────────────────────────────────────
    // OPTIONAL — If you want server-side filtering/search via AJAX:
    // Add this extra method and wire it to a route like: GET /api/properties/search
    // ─────────────────────────────────────────────────────────────────────────────

    public function search(Request $request)
    {
        $q     = $request->input('q', '');
        $type  = $request->input('type', 'all');
        $sort  = $request->input('sort', 'newest');
        $prMin = $request->input('price_min');
        $prMax = $request->input('price_max');

        $orderBy    = in_array($sort, ['price-asc', 'price-desc']) ? 'price'      : 'created_at';
        $orderDir   = in_array($sort, ['price-asc', 'oldest'])     ? 'asc'        : 'desc';

        $results = collect();

        if ($type === 'all' || $type === 'home') {
            $query = House::with('service')
                ->when($q, fn($q2) => $q2->where('title', 'like', "%$q%")->orWhere('address', 'like', "%$q%"))
                ->when($prMin, fn($q2) => $q2->where('price', '>=', $prMin))
                ->when($prMax, fn($q2) => $q2->where('price', '<=', $prMax))
                ->orderBy($orderBy, $orderDir)
                ->get()
                ->map(fn($h) => array_merge($h->toArray(), ['_type' => 'home']));
            $results = $results->merge($query);
        }

        if ($type === 'all' || $type === 'land') {
            $query = Land::with('service')
                ->when($q, fn($q2) => $q2->where('title', 'like', "%$q%")
                    ->orWhere('sector', 'like', "%$q%")
                    ->orWhere('district', 'like', "%$q%"))
                ->when($prMin, fn($q2) => $q2->where('price', '>=', $prMin))
                ->when($prMax, fn($q2) => $q2->where('price', '<=', $prMax))
                ->orderBy($orderBy, $orderDir)
                ->get()
                ->map(fn($l) => array_merge($l->toArray(), ['_type' => 'land']));
            $results = $results->merge($query);
        }

        if ($type === 'all' || $type === 'design') {
            $query = ArchitecturalDesign::with(['service', 'category'])
                ->when($q, fn($q2) => $q2->where('title', 'like', "%$q%"))
                ->when($prMin, fn($q2) => $q2->where('price', '>=', $prMin))
                ->when($prMax, fn($q2) => $q2->where('price', '<=', $prMax))
                ->orderBy($orderBy, $orderDir)
                ->get()
                ->map(fn($d) => array_merge($d->toArray(), ['_type' => 'design']));
            $results = $results->merge($query);
        }

        return response()->json([
            'count'   => $results->count(),
            'results' => $results->values(),
        ]);
    }

    // RENT LISTINGS
    public function rent()
    {
        $homes = House::where('is_approved', true)->where('status', 'available')->where('condition', 'for_rent')->get();
        return view('front.rent.homes', compact('homes'));
    }

    public function news()
    {
        $blogs = Blog::where('is_published', 1)->latest()->paginate(9);

        return view('front.blog.index', compact('blogs'));
    }

    public function newsDetails($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $blog->increment('views');

        $related = Blog::where('blog_category_id', $blog->blog_category_id)
            ->where('id', '!=', $blog->id)
            ->take(3)
            ->get();
        // fetch all blog categories with blogs
        $blogCategories = BlogCategory::with('blogs')->get();
        return view('front.blog.show', compact('blog', 'related', 'blogCategories'));
    }

    // tender
    public function tenders()
    {
        $tenders = Tender::where('is_open', 1)->latest()->paginate(9);
        $featuredTenders = Tender::where('is_open', 1)->latest()->take(3)->get();
        // pluck location
        $locations = $tenders->pluck('location')->unique();
        return view('front.tender.index', compact('tenders', 'featuredTenders', 'locations'));
    }

    public function tendersDetails($id)
    {
        $tender = Tender::where('id', $id)->firstOrFail();
        return view('front.tender.show', compact('tender'));
    }

    // Send inquiry to the seller
    public function sendLandInquiry(Request $request)
    {
        $request->validate([
            'land_id' => 'required|exists:lands,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        $land = Land::findOrFail($request->land_id);

        // Example: send email to the seller
        Mail::to($land->user->email)->send(new \App\Mail\LandInquiryMail($request->all(), $land));

        // SweetAlert success
        return redirect()->back()->with('success', 'Your inquiry has been sent successfully!');
    }

    public function categoryView($categoryId)
    {
        $homes = House::where('is_approved', true)
            ->where('status', 'available')
            ->whereHas('service', function ($query) use ($categoryId) {
                $query->where('service_category_id', $categoryId);
            })
            ->get();

        $lands = Land::where('is_approved', true)
            ->where('status', 'available')
            ->whereHas('service', function ($query) use ($categoryId) {
                $query->where('service_category_id', $categoryId);
            })
            ->get();

        $category = ServiceCategory::findOrFail($categoryId);
        return view('front.properties.category', compact('homes', 'lands', 'categoryId', 'category'));
    }

    public function propertiesByProvince($province)
    {
        $homes = House::where('province', $province)->where('is_approved', true)->where('status', 'available')->get();
        $lands = Land::where('province', $province)->where('is_approved', true)->where('status', 'available')->get();

        return view('front.properties.by_province', compact('province', 'homes', 'lands'));
    }

    public function showAdvertisements()
    {
        $advertisements = Advertisement::with(['agent.user'])->where('status', 'approved')->orderBy('created_at', 'desc')->paginate(9);
        return view('front.advertisements', compact('advertisements'));
    }

    public function showAnnouncements()
    {
        $announcements = Announcement::where('status', 'active')->orderBy('created_at', 'desc')->paginate(10);
        return view('front.announcements', compact('announcements'));
    }
    public function showAnnouncementDetail($slug)
    {
        $announcement = Announcement::where('slug', $slug)->where('status', 'active')->firstOrFail();
        return view('front.announcement-detail', compact('announcement'));
    }

    // tender
    public function jobs()
    {
        $jobs = TerraJob::where('is_active', 1)->latest()->paginate(9);
        $featuredJobs = TerraJob::where('is_active', 1)->latest()->take(3)->get();
        // pluck location
        $locations = $jobs->pluck('location')->unique();
        return view('front.jobs.index', compact('jobs', 'featuredJobs', 'locations'));
    }

    public function jobsDetails($id)
    {
        $job = TerraJob::where('id', $id)->firstOrFail();
        return view('front.jobs.show', compact('job'));
    }
    public function apply(Request $request, TerraJob $job)
    {
        $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string'
        ]);

        // Prevent duplicate applications
        if (TerraJobApplication::where('job_id', $job->id)
            ->where('user_id', auth()->id())->exists()
        ) {
            return back()->with('error', 'You already applied.');
        }

        $cvPath = $request->file('cv')->store('cvs', 'public');

        TerraJobApplication::create([
            'job_id' => $job->id,
            'user_id' => auth()->id(),
            'cv' => $cvPath,
            'cover_letter' => $request->cover_letter
        ]);

        return back()->with('success', 'Application submitted!');
    }
}
