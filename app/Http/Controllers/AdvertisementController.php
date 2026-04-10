<?php

namespace App\Http\Controllers;


use App\Models\House;
use App\Models\Land;
use App\Models\ArchitecturalDesign;
use App\Models\ListingPackage;
use App\Models\TerraAdvertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{

    // ─────────────────────────────────────────────────────────────────────────
    // Shared view data
    // ─────────────────────────────────────────────────────────────────────────

    private function viewData(): array
    {
        return [
            'packages' => ListingPackage::orderBy('price_per_day')->get(),
        ];
    }

    public function index()
    {
        $advertisements = TerraAdvertisement::with('listingPackage')
            ->latest()
            ->paginate(10);

        return view('front.advertisements.index', compact('advertisements'));
    }

    public function create()
    {
        $packages = ListingPackage::active()
            ->where('listing_type', 'advertisement')
            ->orderBy('price_per_day')
            ->get();

        return view('admin.advertisements.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'required|string',
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1|max:365',
            'contact_phone'      => 'nullable|string|max:20',
            'contact_email'      => 'nullable|email|max:255',
            'location'           => 'nullable|string|max:255',
            'price_amount'       => 'nullable|numeric|min:0',
            'images'             => 'nullable|array',        // ✅ added
            'images.*'           => 'nullable|image|max:5120',
            'video_path'         => 'nullable|url|max:255',
        ]);

        $ad = TerraAdvertisement::create([
            'user_id'            => Auth::id(),
            'listing_package_id' => $validated['listing_package_id'],
            'listing_days'       => $validated['listing_days'],
            'title'              => $validated['title'],
            'description'        => $validated['description'],
            'contact_phone'      => $validated['contact_phone'] ?? null,
            'contact_email'      => $validated['contact_email'] ?? null,
            'location'           => $validated['location'] ?? null,
            'price_amount'       => $validated['price_amount'] ?? null,
            'currency'           => 'RWF',
            'images'             => $this->uploadImages($request) ?: null,
            'status'             => 'draft',
            'payment_status'     => 'pending',
            'video_path'         => $validated['video_path'] ?? null,
        ]);

        return redirect()->route('advertisements.payment', $ad)
            ->with('success', 'Advertisement created. Please submit your payment to proceed.');
    }

    /**
     * Show the payment submission form.
     */
    public function payment(TerraAdvertisement $advertisement)
    {
        abort_unless($advertisement->user_id === Auth::id(), 403);
        abort_if($advertisement->payment_status === 'confirmed', 403, 'Payment already confirmed.');

        return view('admin.advertisements.payment', compact('advertisement'));
    }

    /**
     * Submit MoMo payment proof.
     */
    public function submitPayment(Request $request, TerraAdvertisement $advertisement)
    {
        abort_unless($advertisement->user_id === Auth::id(), 403);

        $request->validate([
            'momo_phone'          => 'required|string|max:20',
            'momo_transaction_id' => 'required|string|max:100',
        ]);

        $advertisement->update([
            'momo_phone'           => $request->momo_phone,
            'momo_transaction_id'  => $request->momo_transaction_id,
            'payment_submitted_at' => now(),
            'status'               => 'pending_review',
        ]);

        return redirect()->route('advertisements.index')  // ✅ user-facing route
            ->with('success', 'Payment submitted. We will review and activate your ad shortly.');
    }

    public function show(TerraAdvertisement $advertisement)
    {
        // Only published / active ads are publicly visible
        abort_unless($advertisement->status === 'active', 404);

        // Increment impression counter (fire-and-forget, no race condition concern)
        $advertisement->increment('impressions');

        // Eager-load relationships needed by the view
        $advertisement->load(['listingPackage', 'advertisable', 'user']);

        // Related ads — same property type, excluding this one, max 3
        $related = TerraAdvertisement::with(['advertisable'])
            ->active()
            ->where('id', '!=', $advertisement->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();


        return view('front.advertisements.show', compact('advertisement', 'related'));
    }

    public function recordClick(TerraAdvertisement $advertisement)
    {
        abort_unless($advertisement->status === 'active', 404);
        $advertisement->increment('clicks');
        return response()->noContent();
    }

    // Edit
    // ─────────────────────────────────────────────────────────────────────────

    public function edit(TerraAdvertisement $advertisement)
    {
        $advertisement->load('listingPackage');

        return view('admin.advertisements.edit', array_merge(
            $this->viewData(),
            compact('advertisement')   // ✅ removed undefined $currentAdvertisableType
        ));
    }

    public function update(Request $request, TerraAdvertisement $advertisement)
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'required|string',
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1|max:365',
            'contact_phone'      => 'nullable|string|max:20',
            'contact_email'      => 'nullable|email|max:255',
            'location'           => 'nullable|string|max:255',
            'price_amount'       => 'nullable|numeric|min:0',
            'existing_images'    => 'nullable|array',
            'existing_images.*'  => 'nullable|string',
            'images'             => 'nullable|array',        // ✅ added
            'images.*'           => 'nullable|image|max:5120',
            'video_path'         => 'nullable|url|max:255',
        ]);

        $keptImages    = $request->input('existing_images', []);
        $newImages     = $this->uploadImages($request);
        $mergedImages  = array_values(array_merge($keptImages, $newImages));

        $removedImages = array_diff($advertisement->images ?? [], $keptImages);
        foreach ($removedImages as $path) {
            $fullPath = public_path($path);
            if (file_exists($fullPath)) @unlink($fullPath);
        }

        $advertisement->update([
            'listing_package_id' => $validated['listing_package_id'],
            'listing_days'       => $validated['listing_days'],
            'title'              => $validated['title'],
            'description'        => $validated['description'],
            'contact_phone'      => $validated['contact_phone'] ?? null,
            'contact_email'      => $validated['contact_email'] ?? null,
            'location'           => $validated['location'] ?? null,
            'price_amount'       => $validated['price_amount'] ?? null,
            'images'             => $mergedImages ?: null,
            'video_path'         => $validated['video_path'] ?? null,
        ]);

        return redirect()->route('admin.advertisements.show', $advertisement)
            ->with('success', 'Advertisement updated successfully.');
    }

    // Destroy
    // ─────────────────────────────────────────────────────────────────────────

    public function destroy($id)
    {

        $advertisement = TerraAdvertisement::findOrFail($id);

        // Delete all associated image files
        foreach ($advertisement->images ?? [] as $path) {
            $fullPath = public_path($path);
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        $advertisement->delete();

        return redirect()->route('advertisements.index')
            ->with('success', 'Advertisement deleted.');
    }
 
    // ─────────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Resolve advertisable_type (morph class) and advertisable_id from request.
     *
     * @return array{0: string|null, 1: int|null}
     */
    private function resolveAdvertisable(Request $request): array
    {
        if ($request->filled('advertisable_type') && $request->filled('advertisable_id')) {
            return [
                $this->morphMap[$request->advertisable_type] ?? null,
                (int) $request->advertisable_id,
            ];
        }

        return [null, null];
    }

    /**
     * Upload images[] from the request and return array of stored paths.
     *
     * @return string[]
     */
    private function uploadImages(Request $request): array
    {
        $paths = [];

        if (! $request->hasFile('images')) {
            return $paths;
        }

        $destination = 'image/advertisements/';

        if (! file_exists(public_path($destination))) {
            mkdir(public_path($destination), 0755, true);
        }

        foreach ($request->file('images') as $image) {
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($destination), $filename);
            $paths[] = $destination . $filename;
        }

        return $paths;
    }

    /**
     * Abort with 403 if the authenticated user does not own the advertisement.
     */
    private function authorizeOwner(TerraAdvertisement $advertisement): void
    {
        abort_if($advertisement->user_id !== Auth::id(), 403, 'Unauthorized');
    }
    
}
