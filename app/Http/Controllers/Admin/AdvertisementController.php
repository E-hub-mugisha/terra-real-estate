<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\House;
use App\Models\Land;
use App\Models\ArchitecturalDesign;
use App\Models\ListingPackage;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {
        $query = Advertisement::with(['user', 'listingPackage'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%' . $request->search . '%'));
            });
        }

        $ads = $query->paginate(20)->withQueryString();

        $counts = [
            'pending_review' => Advertisement::pendingReview()->count(),
            'active'         => Advertisement::active()->count(),
            'total'          => Advertisement::count(),
        ];

        return view('admin.advertisements.index', compact('ads', 'counts'));
    }

    public function show(Advertisement $advertisement)
    {
        $advertisement->load(['user', 'listingPackage', 'advertisable', 'confirmedBy']);
        return view('admin.advertisements.show', compact('advertisement'));
    }

    /**
     * Morph map: short key → model class (single source of truth).
     */
    private array $morphMap = [
        'house'  => House::class,
        'land'   => Land::class,
        'design' => ArchitecturalDesign::class,
    ];

    // ─────────────────────────────────────────────────────────────────────────
    // Shared view data
    // ─────────────────────────────────────────────────────────────────────────

    private function viewData(): array
    {
        return [
            'packages' => ListingPackage::where('listing_type', 'advertisement')->orderBy('price_per_day')->get(),
            'houses'   => House::where('user_id', Auth::id())->orderBy('title')->get(),
            'lands'    => Land::where('user_id', Auth::id())->orderBy('title')->get(),
            'designs'  => ArchitecturalDesign::where('user_id', Auth::id())->orderBy('title')->get(),
        ];
    }

    public function create()
    {
        // User's own listings to link as the advertisable
        $houses  = House::where('user_id', Auth::id())->get(['id', 'title']);
        $lands   = Land::where('user_id', Auth::id())->get(['id', 'title']);
        $designs = ArchitecturalDesign::where('user_id', Auth::id())->get(['id', 'title']);

        $packages = ListingPackage::active()
            ->where('listing_type', 'advertisement')
            ->orderBy('price_per_day')
            ->get();

        return view('admin.advertisements.create', compact('houses', 'lands', 'designs', 'packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'required|string',
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1|max:365',
            'advertisable_type'  => 'nullable|in:house,land,design',
            'advertisable_id'    => 'nullable|integer',
            'contact_phone'      => 'nullable|string|max:20',
            'contact_email'      => 'nullable|email|max:255',
            'location'           => 'nullable|string|max:255',
            'price_amount'       => 'nullable|numeric|min:0',
            'images.*'           => 'nullable|image|max:5120',
        ]);

        [$advertisableType, $advertisableId] = $this->resolveAdvertisable($request);

        $ad = Advertisement::create([
            'user_id'            => Auth::id(),
            'listing_package_id' => $validated['listing_package_id'],
            'listing_days'       => $validated['listing_days'],
            'advertisable_type'  => $advertisableType,
            'advertisable_id'    => $advertisableId,
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
        ]);

        return redirect()->route('advertisements.payment', $ad)
            ->with('success', 'Advertisement created. Please submit your payment to proceed.');
    }

    /**
     * Show the payment submission form.
     */
    public function payment(Advertisement $advertisement)
    {
        abort_unless($advertisement->user_id === Auth::id(), 403);
        abort_if($advertisement->payment_status === 'confirmed', 403, 'Payment already confirmed.');

        return view('admin.advertisements.payment', compact('advertisement'));
    }

    /**
     * Submit MoMo payment proof.
     */
    public function submitPayment(Request $request, Advertisement $advertisement)
    {
        abort_unless($advertisement->user_id === Auth::id(), 403);

        $request->validate([
            'momo_phone'          => 'required|string|max:20',
            'momo_transaction_id' => 'required|string|max:100',
        ]);

        $advertisement->update([
            'momo_phone'          => $request->momo_phone,
            'momo_transaction_id' => $request->momo_transaction_id,
            'payment_submitted_at' => now(),
            'status'              => 'pending_review',
        ]);

        return redirect()->route('admin.advertisements.index')
            ->with('success', 'Payment submitted. We will review and activate your ad shortly.');
    }

    public function recordClick(Advertisement $advertisement)
    {
        abort_unless($advertisement->status === 'active', 404);
        $advertisement->increment('clicks');
        return response()->noContent();
    }

    // Edit
    // ─────────────────────────────────────────────────────────────────────────

    public function edit(Advertisement $advertisement)
    {
        // Reverse-map the stored morph class back to the short key for the blade
        $morphFlip              = array_flip($this->morphMap);
        $currentAdvertisableType = $morphFlip[$advertisement->advertisable_type] ?? null;

        return view('admin.advertisements.edit', array_merge(
            $this->viewData(),
            compact('advertisement', 'currentAdvertisableType')
        ));
    }

    public function update(Request $request, Advertisement $advertisement)
    {

        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'required|string',
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1|max:365',
            'advertisable_type'  => 'nullable|in:house,land,design',
            'advertisable_id'    => 'nullable|integer',
            'contact_phone'      => 'nullable|string|max:20',
            'contact_email'      => 'nullable|email|max:255',
            'location'           => 'nullable|string|max:255',
            'price_amount'       => 'nullable|numeric|min:0',
            'existing_images'    => 'nullable|array',
            'existing_images.*'  => 'nullable|string',
            'images.*'           => 'nullable|image|max:5120',
        ]);

        [$advertisableType, $advertisableId] = $this->resolveAdvertisable($request);

        // Keep only the images the user didn't remove, then append new uploads
        $keptImages   = $request->input('existing_images', []);
        $newImages    = $this->uploadImages($request);
        $mergedImages = array_values(array_merge($keptImages, $newImages));

        // Delete image files that were removed
        $removedImages = array_diff($advertisement->images ?? [], $keptImages);
        foreach ($removedImages as $path) {
            $fullPath = public_path($path);
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        $advertisement->update([
            'listing_package_id' => $validated['listing_package_id'],
            'listing_days'       => $validated['listing_days'],
            'advertisable_type'  => $advertisableType,
            'advertisable_id'    => $advertisableId,
            'title'              => $validated['title'],
            'description'        => $validated['description'],
            'contact_phone'      => $validated['contact_phone'] ?? null,
            'contact_email'      => $validated['contact_email'] ?? null,
            'location'           => $validated['location'] ?? null,
            'price_amount'       => $validated['price_amount'] ?? null,
            'images'             => $mergedImages ?: null,
        ]);

        return redirect()->route('admin.advertisements.show', $advertisement)
            ->with('success', 'Advertisement updated successfully.');
    }

    // Destroy
    // ─────────────────────────────────────────────────────────────────────────

    public function destroy(Advertisement $advertisement)
    {
        $this->authorizeOwner($advertisement);

        // Delete all associated image files
        foreach ($advertisement->images ?? [] as $path) {
            $fullPath = public_path($path);
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        $advertisement->delete();

        return redirect()->route('admin.advertisements.index')
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
    private function authorizeOwner(Advertisement $advertisement): void
    {
        abort_if($advertisement->user_id !== Auth::id(), 403, 'Unauthorized');
    }

    // Approve & activate
    // ─────────────────────────────────────────────────────────────────────────
 
    public function approve(Advertisement $advertisement)
    {
        $now = now();
 
        $advertisement->update([
            'status'           => 'active',
            'payment_status'   => 'confirmed',
            'confirmed_by'     => Auth::id(),
            'starts_at'        => $advertisement->starts_at ?? $now,
            'expires_at'       => $advertisement->expires_at ?? $now->copy()->addDays($advertisement->listing_days),
        ]);
 
        return redirect()->route('admin.advertisements.show', $advertisement)
            ->with('success', 'Advertisement approved and activated.');
    }
 
    // ─────────────────────────────────────────────────────────────────────────
    // Reject
    // ─────────────────────────────────────────────────────────────────────────
 
    public function reject(Request $request, Advertisement $advertisement)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);
 
        $advertisement->update([
            'status'       => 'rejected',
            'admin_notes'  => $request->admin_notes,
            'confirmed_by' => Auth::id(),
        ]);
 
        return redirect()->route('admin.advertisements.show', $advertisement)
            ->with('success', 'Advertisement rejected.');
    }
 
    // ─────────────────────────────────────────────────────────────────────────
    // Pause
    // ─────────────────────────────────────────────────────────────────────────
 
    public function pause(Advertisement $advertisement)
    {
        abort_if($advertisement->status !== 'active', 422, 'Only active ads can be paused.');
 
        $advertisement->update(['status' => 'paused']);
 
        return redirect()->route('admin.advertisements.show', $advertisement)
            ->with('success', 'Advertisement paused.');
    }
 
    // ─────────────────────────────────────────────────────────────────────────
    // Re-activate (paused → active)
    // ─────────────────────────────────────────────────────────────────────────
 
    public function reactivate(Advertisement $advertisement)
    {
        abort_if($advertisement->status !== 'paused', 422, 'Only paused ads can be re-activated.');
 
        $advertisement->update(['status' => 'active']);
 
        return redirect()->route('admin.advertisements.show', $advertisement)
            ->with('success', 'Advertisement re-activated.');
    }
 
    // ─────────────────────────────────────────────────────────────────────────
    // Mark paid
    // ─────────────────────────────────────────────────────────────────────────
 
    public function markPaid(Advertisement $advertisement)
    {
        $advertisement->update([
            'payment_status' => 'confirmed',
            'confirmed_by'   => Auth::id(),
        ]);
 
        return redirect()->route('admin.advertisements.show', $advertisement)
            ->with('success', 'Payment marked as received.');
    }
 
    // ─────────────────────────────────────────────────────────────────────────
    // Mark unpaid
    // ─────────────────────────────────────────────────────────────────────────
 
    public function markUnpaid(Advertisement $advertisement)
    {
        $advertisement->update(['payment_status' => 'pending']);
 
        return redirect()->route('admin.advertisements.show', $advertisement)
            ->with('success', 'Payment status reverted to pending.');
    }
}