@extends('layouts.agents')
@section('title', 'Messages')

@section('content')
@php $me = auth()->user(); @endphp
<div class="tp-chat {{ $active ? 'has-active' : '' }}">
    <aside class="tp-chat-list" aria-label="Conversations">
        <div class="tp-chat-list-head">Messages</div>
        @forelse ($conversations as $c)
            @php $other = $c->other; $last = $c->latestMessage; @endphp
            <a href="{{ route('room.messages.show', $c) }}" class="tp-convo {{ $active && $active->id === $c->id ? 'is-active' : '' }} {{ $c->unread ? 'is-unread' : '' }}">
                <span class="tu-avatar">{{ strtoupper(mb_substr($other->name ?? 'T', 0, 1)) }}</span>
                <span class="tp-convo-main">
                    <span class="tp-convo-top">
                        <strong>{{ $other->name ?? 'Terra user' }}</strong>
                        <time>{{ optional($c->last_message_at)->diffForHumans(null, true, true) }}</time>
                    </span>
                    @if ($c->listable)<span class="tp-convo-sub">{{ $c->listable->title }}</span>@elseif ($c->subject)<span class="tp-convo-sub">{{ $c->subject }}</span>@endif
                    <span class="tp-convo-last">
                        <span>{{ $last ? ($last->user_id === $me->id ? 'You: ' : '') . $last->body : 'No messages yet' }}</span>
                        @if ($c->unread)<b class="tp-badge">{{ $c->unread }}</b>@endif
                    </span>
                </span>
            </a>
        @empty
            <div class="tp-card-empty">
                <div class="tu-empty-ico"><x-tu-icon name="mail" /></div>
                <strong>No conversations yet</strong>
                {{ $me->isClient() ? 'Message an owner from any listing page.' : 'Replies to inquiries and client messages appear here.' }}
            </div>
        @endforelse
    </aside>

    <section class="tp-chat-main">
        @if ($active)
            @php $other = $active->otherParticipant($me); @endphp
            <header class="tp-chat-head">
                <a href="{{ route('room.messages.index', ['list' => 1]) }}" class="tp-icon-btn tp-chat-back" aria-label="Back to conversations"><x-tu-icon name="arrow-left" /></a>
                <span class="tu-avatar">{{ strtoupper(mb_substr($other->name ?? 'T', 0, 1)) }}</span>
                <span style="min-width:0">
                    <strong>{{ $other->name ?? 'Terra user' }}</strong>
                    <span>{{ $other?->roleLabel() }}@if ($other?->last_seen_at) · active {{ $other->last_seen_at->diffForHumans() }}@endif</span>
                </span>
                @if ($active->listable)
                    @include('room._listing', ['listing' => $active->listable])
                @endif
            </header>
            <div class="tp-chat-thread" id="chatThread" aria-live="polite">
                @include('room.messages._thread', ['messages' => $messages, 'me' => $me])
            </div>
            <form method="POST" action="{{ route('room.messages.store', $active) }}" class="tp-chat-form" id="chatForm">
                @csrf
                <label for="chatBody" class="tu-sr">Message</label>
                <textarea id="chatBody" name="body" required maxlength="3000" placeholder="Write a message…" autocomplete="off"></textarea>
                <button type="submit" class="tu-btn tu-btn-primary" aria-label="Send">Send <x-tu-icon name="arrow-right" /></button>
            </form>
        @else
            <div class="tp-chat-empty">
                <div>
                    <div class="tu-empty-ico"><x-tu-icon name="mail" /></div>
                    <strong style="color:var(--tu-ink)">Select a conversation</strong>
                    <p style="margin:4px 0 0;font-size:.88rem">Owners and clients talk directly here, with no middleman.</p>
                </div>
            </div>
        @endif
    </section>
</div>
@endsection

@if ($active)
@push('scripts')
<script>
    (function () {
        const thread = document.getElementById('chatThread');
        const form = document.getElementById('chatForm');
        const box = form.querySelector('textarea');
        const url = @json(route('room.messages.show', $active));
        const csrf = form.querySelector('[name=_token]').value;
        let count = thread.querySelectorAll('.tp-msg[data-msg-id]').length;
        const toBottom = () => { thread.scrollTop = thread.scrollHeight; };
        toBottom();

        const refresh = () => fetch(url, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
            .then(r => r.ok ? r.json() : null)
            .then(d => {
                if (!d || d.count === count) return;
                const near = thread.scrollHeight - thread.scrollTop - thread.clientHeight < 120;
                thread.innerHTML = d.html; count = d.count;
                if (near) toBottom();
            }).catch(() => {});

        box.addEventListener('input', () => { box.style.height = 'auto'; box.style.height = Math.min(box.scrollHeight, 140) + 'px'; });
        box.addEventListener('keydown', (e) => { if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); form.requestSubmit(); } });
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const body = box.value.trim();
            if (!body) return;
            box.value = ''; box.style.height = '';
            fetch(form.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                credentials: 'same-origin',
                body: JSON.stringify({ body }),
            }).then(r => { if (!r.ok) throw r; return refresh(); }).then(toBottom)
              .catch(() => { box.value = body; alert('Message not sent. Please try again.'); });
        });
        setInterval(() => { if (!document.hidden) refresh(); }, 8000);
    })();
</script>
@endpush
@endif
