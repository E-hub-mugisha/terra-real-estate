@extends('layouts.agents')
@section('title', 'Offers')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Offers</h1>
        <p>{{ $box === 'made' ? 'Offers you made on properties.' : 'Offers from clients. Accept, reject or send a counter offer.' }}</p>
    </div>
</div>

<div class="tp-toolbar">
    <nav class="tp-box-tabs" aria-label="Offer box">
        @unless (auth()->user()->isClient() && !$counts['received'])
            <a href="{{ route('room.offers.index', ['box' => 'received']) }}" class="{{ $box === 'received' ? 'is-active' : '' }}">Received <small>{{ $counts['received'] }}</small></a>
        @endunless
        <a href="{{ route('room.offers.index', ['box' => 'made']) }}" class="{{ $box === 'made' ? 'is-active' : '' }}">Made by me <small>{{ $counts['made'] }}</small></a>
    </nav>
    <nav class="tp-box-tabs" aria-label="Filter by status">
        @foreach ([null => 'All', 'pending' => 'Pending', 'countered' => 'Countered', 'accepted' => 'Accepted', 'rejected' => 'Rejected'] as $key => $label)
            <a href="{{ route('room.offers.index', array_filter(['box' => $box, 'status' => $key ?: null])) }}" class="{{ request('status') == $key ? 'is-active' : '' }}">{{ $label }}</a>
        @endforeach
    </nav>
</div>

@if ($offers->isEmpty())
    @include('room._empty', [
        'icon' => 'tag',
        'title' => 'No offers',
        'text' => $box === 'made' ? 'Found the right property? Use “Make an offer” on its page.' : 'Offers from clients on your listings appear here.',
        'action' => $box === 'made' ? ['Browse properties', route('front.properties.buy')] : null,
    ])
@else
    <div class="tp-cards">
        @foreach ($offers as $o)
            @php $received = $box === 'received'; $asking = (float) ($o->listable->price ?? 0); $diff = $asking > 0 ? round(($o->amount - $asking) / $asking * 100) : null; @endphp
            <article class="tp-item {{ $received && $o->status === 'pending' ? 'is-new' : '' }}">
                <div class="tp-item-media">@if ($o->listable)<img src="{{ $o->listable->thumbUrl() }}" alt="" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('front/assets/img/all-images/properties/property-img1.png') }}'">@endif</div>
                <div style="min-width:0">
                    <h3 class="tp-item-title">
                        @if ($o->listable)<a href="{{ $o->listable->publicUrl() }}" target="_blank" rel="noopener">{{ $o->listable->title }}</a>@else Listing removed @endif
                    </h3>
                    <div class="tp-item-meta">
                        <span><x-tu-icon name="user" /> {{ $received ? 'From ' . ($o->client->name ?? 'client') : 'To ' . ($o->recipient->name ?? 'the Terra team') }}</span>
                        <span><x-tu-icon name="clock" /> {{ $o->created_at->diffForHumans() }}</span>
                        @if ($asking > 0)<span>Asking {{ number_format($asking) }} {{ $o->listable->currency ?: 'RWF' }}</span>@endif
                    </div>
                    <div style="display:flex;gap:18px;flex-wrap:wrap;margin-top:10px">
                        <div><div class="tp-stat-label" style="margin:0 0 2px">Offer</div><div class="tp-amount">{{ number_format($o->amount) }} <small>{{ $o->currency }}</small>
                            @if ($diff !== null)<span class="tu-badge {{ $diff >= 0 ? 'tu-badge-success' : 'tu-badge-warn' }}" style="vertical-align:3px">{{ $diff > 0 ? '+' : '' }}{{ $diff }}%</span>@endif</div></div>
                        @if ($o->counter_amount)
                            <div><div class="tp-stat-label" style="margin:0 0 2px">Counter offer</div><div class="tp-amount" style="color:var(--tu-brand)">{{ number_format($o->counter_amount) }} <small>{{ $o->currency }}</small></div></div>
                        @endif
                    </div>
                    @if ($o->message)<div class="tp-quote">{{ $o->message }}</div>@endif
                    @if ($o->response_note)<div class="tp-quote"><strong>Reply:</strong> {{ $o->response_note }}</div>@endif
                </div>
                <div class="tp-item-actions">
                    @include('room._status', ['status' => $o->status])
                    @if ($received && $o->status === 'pending')
                        <form method="POST" action="{{ route('room.offers.update', $o) }}" onsubmit="return confirm('Accept this offer?')">@csrf @method('PATCH')<input type="hidden" name="action" value="accept"><button class="tu-btn tu-btn-primary tu-btn-sm"><x-tu-icon name="check" /> Accept</button></form>
                        <button type="button" class="tu-btn tu-btn-sm" data-modal-open="counterModal" data-action="{{ route('room.offers.update', $o) }}" data-field-counter_amount="{{ (int) ($asking ?: $o->amount) }}">Counter</button>
                    @endif
                    @if ($received && $o->isOpen())
                        <form method="POST" action="{{ route('room.offers.update', $o) }}">@csrf @method('PATCH')<input type="hidden" name="action" value="reject"><button class="tu-btn tu-btn-sm tu-btn-ghost">Reject</button></form>
                    @endif
                    @if (!$received && $o->status === 'countered')
                        <form method="POST" action="{{ route('room.offers.update', $o) }}">@csrf @method('PATCH')<input type="hidden" name="action" value="accept_counter"><button class="tu-btn tu-btn-primary tu-btn-sm">Accept {{ number_format($o->counter_amount) }}</button></form>
                        <form method="POST" action="{{ route('room.offers.update', $o) }}">@csrf @method('PATCH')<input type="hidden" name="action" value="decline_counter"><button class="tu-btn tu-btn-sm">Decline</button></form>
                    @endif
                    @if (!$received && $o->isOpen())
                        <form method="POST" action="{{ route('room.offers.update', $o) }}" onsubmit="return confirm('Withdraw your offer?')">@csrf @method('PATCH')<input type="hidden" name="action" value="withdraw"><button class="tu-btn tu-btn-sm tu-btn-ghost">Withdraw</button></form>
                    @endif
                    @if (!$received && $o->listable && $o->recipient)
                        <form method="POST" action="{{ route('listing.message', [\App\Support\ListingRef::type($o->listable), $o->listable->id]) }}">
                            @csrf<input type="hidden" name="body" value="Hi, about my offer on {{ $o->listable->title }}…">
                            <button class="tu-btn tu-btn-sm tu-btn-icon" title="Message the owner" aria-label="Message the owner about this offer"><x-tu-icon name="mail" /></button>
                        </form>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
    <div class="mt-3">{{ $offers->links() }}</div>
@endif

<div class="tu-modal" id="counterModal" role="dialog" aria-modal="true" aria-labelledby="counterTitle">
    <div class="tu-modal-box">
        <div class="tu-modal-head">
            <div><h3 id="counterTitle">Send a counter offer</h3><p>The client can accept or decline your price.</p></div>
            <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost tu-btn-sm" data-modal-close aria-label="Close"><x-tu-icon name="x" /></button>
        </div>
        <form method="POST" action="#" class="tu-modal-body tu-stack" style="gap:14px">
            @csrf @method('PATCH')
            <input type="hidden" name="action" value="counter">
            <div class="tu-field"><label for="ctAmount">Your price</label><input id="ctAmount" class="tu-input" type="number" name="counter_amount" min="1" step="1" required></div>
            <div class="tu-field"><label for="ctNote">Message <span class="tu-hint">(optional)</span></label><textarea id="ctNote" name="response_note" maxlength="1000" rows="3"></textarea></div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-block">Send counter offer</button>
        </form>
    </div>
</div>
@endsection
