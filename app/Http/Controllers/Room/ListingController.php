<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\ListingDocument;
use App\Models\ListingPackage;
use App\Models\ListingPayment;
use App\Services\Marketplace\PromotionService;
use App\Support\ListingRef;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * "My listings" for owners, agents and partners: one list across houses, land and
 * designs, package promotion (buy / renew) and property documents.
 */
class ListingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $listings = ListingRef::collect(fn ($q) => $q->managedBy($user)
            ->with(['activePromotion'])
            ->withCount(['inquiries', 'viewings', 'offers', 'saves']))
            ->sortByDesc('created_at')
            ->values();

        $filter = $request->query('filter');
        if ($filter === 'live') {
            $listings = $listings->filter->isApproved()->values();
        } elseif ($filter === 'pending') {
            $listings = $listings->reject->isApproved()->values();
        } elseif ($filter === 'promoted') {
            $listings = $listings->filter(fn ($l) => $l->activePromotion)->values();
        }

        return view('room.listings.index', compact('listings', 'filter'));
    }

    public function promote(Request $request, string $type, int $id)
    {
        $listing = $this->managed($request, $type, $id);
        $packages = $this->packagesFor($type);
        $current = $listing->activePromotion;

        return view('room.listings.promote', compact('listing', 'type', 'packages', 'current'));
    }

    public function storePromotion(Request $request, string $type, int $id)
    {
        $listing = $this->managed($request, $type, $id);
        $data = $request->validate([
            'listing_package_id' => 'required|exists:listing_packages,id',
            'days' => 'required|integer|min:1|max:365',
        ]);
        $package = ListingPackage::findOrFail($data['listing_package_id']);
        abort_unless($this->packagesFor($type)->contains('id', $package->id), 422, 'This package is not available for this listing type.');

        $payment = ListingPayment::create([
            'payable_type' => $listing->getMorphClass(),
            'payable_id' => $listing->getKey(),
            'user_id' => $request->user()->id,
            'payment_purpose' => 'listing_fee',
            'amount' => $package->price_per_day * $data['days'],
            'currency' => 'RWF',
            'status' => 'pending',
            'listing_package_id' => $package->id,
            'days' => $data['days'],
        ]);
        $listing->forceFill(['listing_package_id' => $package->id, 'listing_days' => $data['days']])->save();

        return redirect()->route('payment.show', $payment->reference)
            ->with('success', ucfirst(PromotionService::normaliseTier($package->package_tier)) . ' package selected. Complete the payment to start it.');
    }

    public function documents(Request $request, string $type, int $id)
    {
        $listing = $this->managed($request, $type, $id);
        $documents = $listing->documents()->latest()->get();

        return view('room.listings.documents', compact('listing', 'type', 'documents'));
    }

    public function storeDocument(Request $request, string $type, int $id)
    {
        $listing = $this->managed($request, $type, $id);
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'type' => 'required|in:' . implode(',', array_keys(ListingDocument::TYPES)),
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,webp,doc,docx|max:10240',
            'is_public' => 'nullable|boolean',
        ]);
        $file = $request->file('file');
        $listing->documents()->create([
            'user_id' => $request->user()->id,
            'title' => $data['title'],
            'type' => $data['type'],
            'path' => $file->store('listing-documents/' . $type . '-' . $listing->id, 'local'),
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'is_public' => $request->boolean('is_public'),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Document uploaded. The Terra team will verify it.');
    }

    public function downloadDocument(Request $request, ListingDocument $document)
    {
        $listing = $document->listable;
        $user = $request->user();
        $allowed = $document->is_public && $document->status === 'verified'
            || ($listing && $listing->isManagedBy($user));
        abort_unless($allowed, 403);
        abort_unless(Storage::disk('local')->exists($document->path), 404);

        return Storage::disk('local')->download($document->path, $document->original_name ?: basename($document->path));
    }

    public function destroyDocument(Request $request, ListingDocument $document)
    {
        abort_unless($document->listable && $document->listable->isManagedBy($request->user()), 403);
        Storage::disk('local')->delete($document->path);
        $document->delete();

        return back()->with('success', 'Document removed.');
    }

    private function managed(Request $request, string $type, int $id)
    {
        $listing = ListingRef::resolve($type, $id);
        abort_unless($listing->isManagedBy($request->user()), 403, 'You can only manage your own listings.');

        return $listing;
    }

    private function packagesFor(string $type)
    {
        $types = match ($type) {
            'house' => ['house', 'house_sale', 'house_rent'],
            'land' => ['land', 'land_sale', 'land_rent'],
            default => ['design'],
        };

        return ListingPackage::whereIn('listing_type', $types)->where('is_active', true)
            ->orderByRaw("FIELD(package_tier,'basic','medium','premium')")->get();
    }
}
