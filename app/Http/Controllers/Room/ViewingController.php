<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\Viewing;
use App\Support\ListingRef;
use Illuminate\Http\Request;

class ViewingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $box = $request->query('box', $user->isClient() ? 'requested' : 'hosting');
        $query = $box === 'requested' ? $user->viewingsRequested() : $user->viewingsHosted();

        $viewings = $query->with(['listable', 'client', 'host'])
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->orderByRaw("FIELD(status,'requested','confirmed','completed','declined','cancelled')")
            ->orderBy('scheduled_at')
            ->paginate(15)->withQueryString();

        $counts = [
            'hosting' => $user->viewingsHosted()->count(),
            'pending' => $user->viewingsHosted()->where('status', 'requested')->count(),
            'requested' => $user->viewingsRequested()->count(),
        ];

        return view('room.viewings.index', compact('viewings', 'box', 'counts'));
    }

    /** A client asks to visit a listing (from the public listing page). */
    public function store(Request $request, string $type, int $id)
    {
        $user = $request->user();
        $listing = ListingRef::resolve($type, $id);
        $host = $listing->contactUser();
        abort_if($host && $host->id === $user->id, 422, 'You cannot book a viewing of your own listing.');

        $data = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'note' => 'nullable|string|max:500',
        ]);
        $when = \Carbon\Carbon::parse($data['date'] . ' ' . $data['time']);
        if ($when->isPast()) {
            return back()->withErrors(['time' => 'Please pick a time in the future.'])->withInput();
        }

        Viewing::create([
            'listable_type' => $listing->getMorphClass(),
            'listable_id' => $listing->getKey(),
            'client_id' => $user->id,
            'host_id' => $host?->id,
            'scheduled_at' => $when,
            'note' => $data['note'] ?? null,
            'status' => 'requested',
        ]);

        return redirect()->route('room.viewings.index', ['box' => 'requested'])
            ->with('success', 'Viewing requested for ' . $when->format('D j M, H:i') . '. You will be notified when it is confirmed.');
    }

    public function update(Request $request, Viewing $viewing)
    {
        $user = $request->user();
        $data = $request->validate([
            'action' => 'required|in:confirm,decline,complete,cancel,reschedule',
            'response_note' => 'nullable|string|max:500',
            'date' => 'required_if:action,reschedule|nullable|date|after_or_equal:today',
            'time' => 'required_if:action,reschedule|nullable|date_format:H:i',
        ]);

        $isHost = $viewing->host_id === $user->id || $user->isStaff();
        $isClient = $viewing->client_id === $user->id;

        $allowed = match ($data['action']) {
            'confirm', 'decline', 'complete' => $isHost,
            'cancel' => $isClient || $isHost,
            'reschedule' => $isHost || $isClient,
        };
        abort_unless($allowed, 403);

        $updates = ['response_note' => $data['response_note'] ?? $viewing->response_note];
        $updates['status'] = match ($data['action']) {
            'confirm' => 'confirmed',
            'decline' => 'declined',
            'complete' => 'completed',
            'cancel' => 'cancelled',
            'reschedule' => 'requested',
        };
        if ($data['action'] === 'reschedule') {
            $updates['scheduled_at'] = \Carbon\Carbon::parse($data['date'] . ' ' . $data['time']);
        }
        $viewing->update($updates);

        return back()->with('success', 'Viewing ' . ($data['action'] === 'reschedule' ? 'rescheduled' : $updates['status']) . '.');
    }
}
