<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Support\ListingRef;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $conversations = $this->conversationsFor($request);

        // Open the most recent conversation, unless the list alone was asked for (phones).
        if ($conversations->isNotEmpty() && !$request->boolean('list')) {
            return redirect()->route('room.messages.show', $conversations->first());
        }

        return view('room.messages.index', ['conversations' => $conversations, 'active' => null, 'messages' => collect()]);
    }

    public function show(Request $request, Conversation $conversation)
    {
        $user = $request->user();
        abort_unless($conversation->participants()->where('users.id', $user->id)->exists(), 403);

        $conversation->participants()->updateExistingPivot($user->id, ['last_read_at' => now()]);
        $messages = $conversation->messages()->with('user')->get();

        if ($request->expectsJson()) {
            return response()->json([
                'html' => view('room.messages._thread', ['messages' => $messages, 'me' => $user])->render(),
                'count' => $messages->count(),
            ]);
        }

        return view('room.messages.index', [
            'conversations' => $this->conversationsFor($request),
            'active' => $conversation->load(['participants', 'listable']),
            'messages' => $messages,
        ]);
    }

    public function store(Request $request, Conversation $conversation)
    {
        $user = $request->user();
        abort_unless($conversation->participants()->where('users.id', $user->id)->exists(), 403);
        $data = $request->validate(['body' => 'required|string|max:3000']);

        $message = $conversation->messages()->create(['user_id' => $user->id, 'body' => trim($data['body'])]);
        $conversation->update(['last_message_at' => now()]);
        $conversation->participants()->updateExistingPivot($user->id, ['last_read_at' => now()]);

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'id' => $message->id]);
        }

        return redirect()->route('room.messages.show', $conversation);
    }

    /** Start a conversation with whoever handles a listing (from the public listing page). */
    public function start(Request $request, string $type, int $id)
    {
        $user = $request->user();
        $listing = ListingRef::resolve($type, $id);
        $contact = $listing->contactUser();
        abort_unless($contact, 404, 'This listing has no contact person yet.');
        if ($contact->id === $user->id) {
            return redirect()->route('room.messages.index')->with('info', 'This is your own listing.');
        }

        $data = $request->validate(['body' => 'required|string|max:3000']);
        $conversation = Conversation::between($user, $contact, $listing);
        $conversation->messages()->create(['user_id' => $user->id, 'body' => trim($data['body'])]);
        $conversation->update(['last_message_at' => now()]);
        $conversation->participants()->updateExistingPivot($user->id, ['last_read_at' => now()]);

        return redirect()->route('room.messages.show', $conversation)->with('success', 'Message sent to ' . $contact->name . '.');
    }

    private function conversationsFor(Request $request)
    {
        $user = $request->user();

        return $user->conversations()
            ->with(['participants', 'latestMessage', 'listable'])
            ->orderByDesc('last_message_at')
            ->get()
            ->each(function ($c) use ($user) {
                $c->other = $c->otherParticipant($user);
                $c->unread = $c->unreadFor($user);
            });
    }
}
