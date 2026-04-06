<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\AdvertisementPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdvertisementController extends Controller
{
    // ─── Public ───────────────────────────────────────────────────────────────

    /**
     * Public advertisements page — /get/advertisements
     */
    public function index(Request $request)
    {
        $ads = Advertisement::active()
            ->with(['package', 'user'])
            ->when($request->type, function ($q, $type) {
                $q->where(function ($q) use ($type) {
                    $q->where('advertisable_type', 'like', "%{$type}%")
                      ->orWhereNull('advertisable_type');
                });
            })
            ->orderByDesc('created_at')
            ->paginate(12);

        $featured = Advertisement::featured()
            ->with(['package'])
            ->limit(6)
            ->get();

        return view('front.advertisements.index', compact('ads', 'featured'));
    }

    /**
     * Public single ad view — /advertisements/{id}
     */
    public function show(Advertisement $advertisement)
    {
        abort_if($advertisement->status !== 'active', 404);
        $advertisement->recordImpression();
        $advertisement->load(['package', 'user', 'advertisable']);

        return view('front.advertisements.show', compact('advertisement'));
    }

    // ─── User: Create flow ────────────────────────────────────────────────────

    /**
     * Step 1: Select package — /advertise/packages
     */
    public function packages()
    {
        $packages = AdvertisementPackage::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('front.advertisements.packages', compact('packages'));
    }

    /**
     * Step 2: Create ad form — /advertise/create?package={slug}
     */
    public function create(Request $request)
    {
        $package = AdvertisementPackage::where('slug', $request->package)
            ->where('is_active', true)
            ->firstOrFail();

        // Fetch the user's own listings to optionally link
        $user    = Auth::user();
        $houses  = $user->houses()->select('id', 'title', 'district')->get();
        $lands   = $user->lands()->select('id', 'title', 'district')->get();
        $designs = $user->architecturalDesigns()->select('id', 'title')->get();

        return view('front.advertisements.create', compact('package', 'houses', 'lands', 'designs'));
    }

    /**
     * Step 2 store — POST /advertise
     */
    public function store(Request $request)
    {
        $package = AdvertisementPackage::findOrFail($request->advertisement_package_id);

        $validated = $request->validate([
            'advertisement_package_id' => 'required|exists:advertisement_packages,id',
            'listing_type'             => ['nullable', Rule::in(['house', 'land', 'design', 'custom'])],
            'listing_id'               => 'nullable|integer',
            'title'                    => 'required|string|max:150',
            'description'              => 'required|string|max:2000',
            'contact_phone'            => 'nullable|string|max:20',
            'contact_email'            => 'nullable|email|max:100',
            'location'                 => 'nullable|string|max:100',
            'price_amount'             => 'nullable|numeric|min:0',
            'images.*'                 => "nullable|image|mimes:jpg,jpeg,png,webp|max:5120",
            'video'                    => $package->allows_video
                                            ? 'nullable|mimetypes:video/mp4,video/quicktime|max:102400'
                                            : 'prohibited',
        ]);

        // Resolve polymorphic target
        [$advertisableType, $advertisableId] = $this->resolveAdvertisable(
            $request->listing_type,
            $request->listing_id
        );

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            $files = array_slice($request->file('images'), 0, $package->max_images);
            foreach ($files as $image) {
                $imagePaths[] = $image->store('advertisements/images', 'public');
            }
        }

        // Handle video upload
        $videoPath = null;
        if ($package->allows_video && $request->hasFile('video')) {
            $videoPath = $request->file('video')->store('advertisements/videos', 'public');
        }

        $ad = Advertisement::create([
            'user_id'                   => Auth::id(),
            'advertisement_package_id'  => $package->id,
            'advertisable_type'         => $advertisableType,
            'advertisable_id'           => $advertisableId,
            'title'                     => $validated['title'],
            'description'               => $validated['description'],
            'contact_phone'             => $validated['contact_phone'] ?? null,
            'contact_email'             => $validated['contact_email'] ?? null,
            'location'                  => $validated['location'] ?? null,
            'price_amount'              => $validated['price_amount'] ?? null,
            'images'                    => $imagePaths,
            'video_path'                => $videoPath,
            'status'                    => 'draft',
        ]);

        return redirect()->route('advertisements.checkout', $ad)
            ->with('success', 'Your ad details have been saved. Complete your payment to go live.');
    }

    /**
     * Step 3: Payment — GET /advertise/{ad}/checkout
     */
    public function checkout(Advertisement $advertisement)
    {
        return view('front.advertisements.checkout', [
            'advertisement' => $advertisement->load('package'),
        ]);
    }

    /**
     * Step 3 submit MoMo — POST /advertise/{ad}/pay
     */
    public function submitPayment(Request $request, Advertisement $advertisement)
    {
        $validated = $request->validate([
            'momo_phone'          => 'required|string|regex:/^(07[2389]\d{7})$/',
            'momo_transaction_id' => 'nullable|string|max:60',
        ]);

        $advertisement->update([
            'momo_phone'            => $validated['momo_phone'],
            'momo_transaction_id'   => $validated['momo_transaction_id'] ?? null,
            'payment_submitted_at'  => now(),
            'status'                => 'pending_review',
        ]);

        return redirect()->route('advertisements.my')
            ->with('success', 'Payment submitted! Our team will verify and activate your ad shortly.');
    }

    /**
     * User's own ads — /my/advertisements
     */
    public function myAds()
    {
        $ads = Advertisement::where('user_id', Auth::id())
            ->with('package')
            ->latest()
            ->paginate(10);

        return view('front.advertisements.my', compact('ads'));
    }

    /**
     * Track click — POST /advertisements/{id}/click
     */
    public function trackClick(Advertisement $advertisement)
    {
        $advertisement->recordClick();
        return response()->json(['ok' => true]);
    }

    // ─── Admin ────────────────────────────────────────────────────────────────

    /**
     * Admin: all ads — /admin/advertisements
     */
    public function adminIndex(Request $request)
    {
        $ads = Advertisement::with(['user', 'package'])
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->payment, fn ($q, $p) => $q->where('payment_status', $p))
            ->latest()
            ->paginate(20);

        $stats = [
            'pending'  => Advertisement::where('status', 'pending_review')->count(),
            'active'   => Advertisement::where('status', 'active')->count(),
            'expired'  => Advertisement::where('status', 'expired')->count(),
            'rejected' => Advertisement::where('status', 'rejected')->count(),
        ];

        return view('admin.advertisements.index', compact('ads', 'stats'));
    }

    /**
     * Admin: confirm payment → activate ad
     */
    public function confirm(Advertisement $advertisement)
    {
        abort_if($advertisement->payment_status === 'confirmed', 409, 'Already confirmed.');

        $advertisement->activate(Auth::id());

        return back()->with('success', "Ad #{$advertisement->id} is now live.");
    }

    /**
     * Admin: reject ad
     */
    public function reject(Request $request, Advertisement $advertisement)
    {
        $request->validate(['reason' => 'required|string|max:500']);

        $advertisement->reject($request->reason, Auth::id());

        return back()->with('success', "Ad #{$advertisement->id} has been rejected.");
    }

    /**
     * Admin: expire ad manually
     */
    public function expire(Advertisement $advertisement)
    {
        $advertisement->update(['status' => 'expired', 'expires_at' => now()]);

        return back()->with('success', "Ad #{$advertisement->id} has been expired.");
    }

    // ─── Private helpers ──────────────────────────────────────────────────────

    private function resolveAdvertisable(?string $type, ?int $id): array
    {
        if (! $type || ! $id || $type === 'custom') {
            return [null, null];
        }

        $map = [
            'house'  => \App\Models\House::class,
            'land'   => \App\Models\Land::class,
            'design' => \App\Models\ArchitecturalDesign::class,
        ];

        $class = $map[$type] ?? null;
        if (! $class) return [null, null];

        // Ensure the listing belongs to the current user
        $listing = $class::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        return $listing ? [$class, $listing->id] : [null, null];
    }
}