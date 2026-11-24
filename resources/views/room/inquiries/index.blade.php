@extends('layouts.agents')
@section('title', 'Inquiries')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Inquiries</h1>
        <p>{{ $box === 'sent' ? 'Questions you asked about listings.' : 'Questions from clients about your listings. Reply to start a direct conversation.' }}</p>
    </div>
</div>

<div class="tp-toolbar">
    <nav class="tp-box-tabs" aria-label="Inquiry box">
        <a href="{{ route('room.inquiries.index', ['box' => 'received']) }}" class="{{ $box === 'received' ? 'is-active' : '' }}">Received <small>{{ $counts['received'] }}</small></a>
        <a href="{{ route('room.inquiries.index', ['box' => 'sent']) }}" class="{{ $box === 'sent' ? 'is-active' : '' }}">Sent <small>{{ $counts['sent'] }}</small></a>
    </nav>
    @if ($box === 'received')
        <nav class="tp-box-tabs" aria-label="Filter by status">
            @foreach ([null => 'All', 'new' => 'New', 'replied' => 'Replied', 'closed' => 'Closed'] as $key => $label)
                <a href="{{ route('room.inquiries.index', array_filter(['box' => 'received', 'status' => $key ?: null])) }}" class="{{ request('status') == $key ? 'is-active' : '' }}">{{ $label }}@if ($key === 'new' && $counts['new']) <small>{{ $counts['new'] }}</small>@endif</a>
            @endforeach
        </nav>
    @endif
</div>

@if ($inquiries->isEmpty())
    @include('room._empty', [
        'icon' => 'mail',
        'title' => $box === 'sent' ? 'You have not asked anything yet' : 'No inquiries yet',
        'text' => $box === 'sent' ? 'Use “Send an inquiry” on any listing page.' : 'When a client asks about one of your listings, it shows up here.',
        'action' => $box === 'sent' ? ['Browse properties', route('front.properties.buy')] : null,
    ])
@else
    <div class="tp-cards">
        @foreach ($inquiries as $inq)
            <article class="tp-item {{ $box === 'received' && $inq->status === 'new' ? 'is-new' : '' }}">
                <div class="tp-item-media">
                    @if ($inq->listable)<img src="{{ $inq->listable->thumbUrl() }}" alt="" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('front/assets/img/all-images/properties/property-img1.png') }}'">@endif
                </div>
                <div style="min-width:0">
                    <h3 class="tp-item-title">
                        @if ($inq->listable)<a href="{{ $inq->listable->publicUrl() }}" target="_blank" rel="noopener">{{ $inq->listable->title }}</a>@else Listing removed @endif
                    </h3>
                    <div class="tp-item-meta">
                        @if ($box === 'received')
                            <span><x-tu-icon name="user" /> {{ $inq->name }}</span>
                            @if ($inq->phone)<span><x-tu-icon name="phone" /> <a href="tel:{{ $inq->phone }}">{{ $inq->phone }}</a></span>@endif
                            <span><x-tu-icon name="mail" /> <a href="mailto:{{ $inq->email }}">{{ $inq->email }}</a></span>
                        @else
                            <span><x-tu-icon name="user" /> To {{ $inq->recipient->name ?? 'the Terra team' }}</span>
                        @endif
                        <span><x-tu-icon name="clock" /> {{ $inq->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="tp-item-body">{{ $inq->message }}</p>
                </div>
                <div class="tp-item-actions">
                    @include('room._status', ['status' => $inq->status])
                    @if ($inq->conversation_id)
                        <a href="{{ route('room.messages.show', $inq->conversation_id) }}" class="tu-btn tu-btn-sm"><x-tu-icon name="list" /> Conversation</a>
                    @endif
                    @if ($box === 'received')
                        <button type="button" class="tu-btn tu-btn-primary tu-btn-sm" data-modal-open="replyModal"
                            data-action="{{ route('room.inquiries.reply', $inq) }}" data-title="Reply to {{ $inq->name }}">Reply</button>
                        @php $wa = preg_replace('/\D+/', '', (string) $inq->phone); @endphp
                        @if ($wa)
                            <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="tu-btn tu-btn-wa tu-btn-sm tu-btn-icon" aria-label="WhatsApp {{ $inq->name }}"><x-tu-icon name="whatsapp" /></a>
                        @endif
                        @if ($inq->status !== 'closed')
                            <form method="POST" action="{{ route('room.inquiries.update', $inq) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="closed">
                                <button class="tu-btn tu-btn-sm tu-btn-ghost">Close</button>
                            </form>
                        @endif
                    @endif
                </div>
            </article>
        @endforeach
    </div>
    <div class="mt-3">{{ $inquiries->links() }}</div>
@endif

<div class="tu-modal" id="replyModal" role="dialog" aria-modal="true" aria-labelledby="replyTitle">
    <div class="tu-modal-box">
        <div class="tu-modal-head">
            <div><h3 id="replyTitle" data-modal-title>Reply</h3><p>Your reply opens a direct conversation in Messages.</p></div>
            <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost tu-btn-sm" data-modal-close aria-label="Close"><x-tu-icon name="x" /></button>
        </div>
        <form method="POST" action="#" class="tu-modal-body tu-stack" style="gap:14px">
            @csrf
            <div class="tu-field">
                <label for="replyBody">Message</label>
                <textarea id="replyBody" name="body" required maxlength="3000" rows="5" placeholder="Hi, thanks for your interest…"></textarea>
            </div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-block">Send reply</button>
        </form>
    </div>
</div>
@endsection
