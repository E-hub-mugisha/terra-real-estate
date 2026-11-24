@extends('layouts.agents')
@section('title', 'My dashboard')

@section('content')
@php $first = \Illuminate\Support\Str::before($user->name, ' ') ?: $user->name; @endphp

<div class="tp-page-head">
    <div>
        <h1>Welcome, {{ $first }}</h1>
        <p>Track the homes and plots you like, and talk to owners directly.</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a href="{{ route('front.properties.buy') }}" class="tu-btn tu-btn-primary tu-btn-sm"><x-tu-icon name="search" /> Browse properties</a>
        <a href="{{ route('room.saved.index') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="heart" /> Saved</a>
    </div>
</div>

<div class="tp-stats">
    @foreach ([
        ['Saved properties', $stats['saved'], 'heart', route('room.saved.index')],
        ['Inquiries sent', $stats['inquiries'], 'mail', route('room.inquiries.index', ['box' => 'sent'])],
        ['Upcoming viewings', $stats['viewings'], 'calendar', route('room.viewings.index', ['box' => 'requested'])],
        ['Open offers', $stats['offers'], 'tag', route('room.offers.index', ['box' => 'made'])],
        ['Unread messages', $stats['messages'], 'list', route('room.messages.index')],
    ] as [$label, $value, $icon, $url])
        <a href="{{ $url }}" class="tp-stat">
            <div class="tp-stat-top"><span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span></div>
            <div><div class="tp-stat-val">{{ number_format($value) }}</div><div class="tp-stat-label">{{ $label }}</div></div>
        </a>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-xl-6">
        <div class="card h-100">
            <div class="card-header tp-card-head">My viewings <a href="{{ route('room.viewings.index', ['box' => 'requested']) }}">All viewings</a></div>
            @if ($viewings->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="calendar" /></div><strong>No viewings yet</strong>Open a listing and choose “Book a viewing”.</div>
            @else
                <ul class="tp-list">
                    @foreach ($viewings as $v)
                        <li>
                            <span class="tp-date"><b>{{ $v->scheduled_at->format('M') }}</b><strong>{{ $v->scheduled_at->format('j') }}</strong><span>{{ $v->scheduled_at->format('H:i') }}</span></span>
                            <span class="tp-list-main">
                                <strong>{{ $v->listable->title ?? 'Listing' }}</strong>
                                <span>With {{ $v->host->name ?? 'the Terra team' }} · {{ $v->scheduled_at->diffForHumans() }}</span>
                            </span>
                            @include('room._status', ['status' => $v->status])
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card h-100">
            <div class="card-header tp-card-head">My offers <a href="{{ route('room.offers.index', ['box' => 'made']) }}">All offers</a></div>
            @if ($offers->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="tag" /></div><strong>No offers yet</strong>Found the one? Make an offer from the listing page.</div>
            @else
                <ul class="tp-list">
                    @foreach ($offers as $o)
                        <li>
                            <span class="tp-list-main">
                                <strong>{{ number_format($o->amount) }} {{ $o->currency }} · {{ \Illuminate\Support\Str::limit($o->listable->title ?? 'Listing', 30) }}</strong>
                                <span>
                                    @if ($o->status === 'countered')
                                        Counter offer: <b style="color:var(--tu-ink)">{{ number_format($o->counter_amount) }} {{ $o->currency }}</b>
                                    @else
                                        Sent {{ $o->created_at->diffForHumans() }}
                                    @endif
                                </span>
                            </span>
                            @include('room._status', ['status' => $o->status])
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

<div class="tp-toolbar" style="margin:28px 0 14px">
    <h2 class="tu-h3" style="margin:0;font-size:1.1rem">Saved properties</h2>
    <a href="{{ route('room.saved.index') }}" class="tu-link-arrow">See all <x-tu-icon name="arrow-right" size="14" /></a>
</div>
@if ($saved->isEmpty())
    <div class="card"><div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="heart" /></div><strong>Nothing saved yet</strong>Tap the heart on any listing to keep it here.</div></div>
@else
    <div class="tu-grid">
        @foreach ($saved as $item)
            @include('front.partials.card', ['item' => $item])
        @endforeach
    </div>
@endif

@if ($recommended->isNotEmpty())
    <div class="tp-toolbar" style="margin:28px 0 14px">
        <h2 class="tu-h3" style="margin:0;font-size:1.1rem">New on Terra</h2>
        <a href="{{ route('front.properties.buy') }}" class="tu-link-arrow">Browse all <x-tu-icon name="arrow-right" size="14" /></a>
    </div>
    <div class="tu-grid">
        @foreach ($recommended as $item)
            @include('front.partials.card', ['item' => $item])
        @endforeach
    </div>
@endif
@endsection
