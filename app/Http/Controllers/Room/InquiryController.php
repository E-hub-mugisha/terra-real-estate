<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $box = $request->query('box', $user->isClient() ? 'sent' : 'received');

        $query = $box === 'sent' ? $user->inquiriesSent() : $user->inquiriesReceived();
        $inquiries = $query->with(['listable', 'sender', 'recipient'])
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->latest()->paginate(15)->withQueryString();

        $counts = [
            'received' => $user->inquiriesReceived()->count(),
            'new' => $user->inquiriesReceived()->where('status', 'new')->count(),
            'sent' => $user->inquiriesSent()->count(),
        ];

        return view('room.inquiries.index', compact('inquiries', 'box', 'counts'));
    }

    /** Reply opens (or continues) a direct conversation with the sender. */
    public function reply(Request $request, Inquiry $inquiry)
    {
        $user = $request->user();
        abort_unless($inquiry->recipient_id === $user->id || $user->isStaff(), 403);
        $data = $request->validate(['body' => 'required|string|max:3000']);

        $sender = $inquiry->sender ?? User::where('email', $inquiry->email)->first();
        if (!$sender) {
            return back()->with('warning', 'This person does not have a Terra account yet — reply by phone, WhatsApp or email.');
        }

        $conversation = Conversation::between($user, $sender, $inquiry->listable);
        $conversation->messages()->create(['user_id' => $user->id, 'body' => $data['body']]);
        $conversation->update(['last_message_at' => now()]);
        $conversation->participants()->updateExistingPivot($user->id, ['last_read_at' => now()]);
        $inquiry->update(['status' => 'replied', 'conversation_id' => $conversation->id]);

        return redirect()->route('room.messages.show', $conversation)->with('success', 'Reply sent.');
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        abort_unless($inquiry->recipient_id === $request->user()->id || $request->user()->isStaff(), 403);
        $inquiry->update($request->validate(['status' => 'required|in:new,replied,closed']));

        return back()->with('success', 'Inquiry updated.');
    }
}
