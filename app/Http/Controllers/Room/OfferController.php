<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Support\ListingRef;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $box = $request->query('box', $user->isClient() ? 'made' : 'received');
        $query = $box === 'made' ? $user->offersMade() : $user->offersReceived();

        $offers = $query->with(['listable', 'client', 'recipient'])
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->latest()->paginate(15)->withQueryString();

        $counts = [
            'received' => $user->offersReceived()->count(),
            'open' => $user->offersReceived()->whereIn('status', ['pending'])->count(),
            'made' => $user->offersMade()->count(),
        ];

        return view('room.offers.index', compact('offers', 'box', 'counts'));
    }

    public function store(Request $request, string $type, int $id)
    {
        $user = $request->user();
        $listing = ListingRef::resolve($type, $id);
        $recipient = $listing->contactUser();
        abort_if($recipient && $recipient->id === $user->id, 422, 'You cannot make an offer on your own listing.');

        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string|max:1000',
        ]);

        if (Offer::where('listable_type', $listing->getMorphClass())->where('listable_id', $listing->getKey())
            ->where('client_id', $user->id)->whereIn('status', ['pending', 'countered'])->exists()) {
            return redirect()->route('room.offers.index', ['box' => 'made'])->with('warning', 'You already have an open offer on this listing.');
        }

        Offer::create([
            'listable_type' => $listing->getMorphClass(),
            'listable_id' => $listing->getKey(),
            'client_id' => $user->id,
            'recipient_id' => $recipient?->id,
            'amount' => $data['amount'],
            'currency' => $listing->currency ?: 'RWF',
            'message' => $data['message'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('room.offers.index', ['box' => 'made'])->with('success', 'Offer sent. You will see the reply here.');
    }

    public function update(Request $request, Offer $offer)
    {
        $user = $request->user();
        $data = $request->validate([
            'action' => 'required|in:accept,reject,counter,withdraw,accept_counter,decline_counter',
            'counter_amount' => 'required_if:action,counter|nullable|numeric|min:1',
            'response_note' => 'nullable|string|max:1000',
        ]);

        $isRecipient = $offer->recipient_id === $user->id || $user->isStaff();
        $isClient = $offer->client_id === $user->id;

        [$allowed, $status] = match ($data['action']) {
            'accept' => [$isRecipient && $offer->status === 'pending', 'accepted'],
            'reject' => [$isRecipient && $offer->isOpen(), 'rejected'],
            'counter' => [$isRecipient && $offer->status === 'pending', 'countered'],
            'withdraw' => [$isClient && $offer->isOpen(), 'withdrawn'],
            'accept_counter' => [$isClient && $offer->status === 'countered', 'accepted'],
            'decline_counter' => [$isClient && $offer->status === 'countered', 'rejected'],
        };
        abort_unless($allowed, 403);

        $updates = ['status' => $status, 'responded_at' => now()];
        if ($data['action'] === 'counter') {
            $updates['counter_amount'] = $data['counter_amount'];
        }
        if ($data['action'] === 'accept_counter') {
            $updates['amount'] = $offer->counter_amount;
        }
        if (!empty($data['response_note'])) {
            $updates['response_note'] = $data['response_note'];
        }
        $offer->update($updates);

        return back()->with('success', 'Offer ' . str_replace('_', ' ', $status) . '.');
    }
}
