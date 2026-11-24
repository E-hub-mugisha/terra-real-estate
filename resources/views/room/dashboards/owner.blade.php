@extends('layouts.agents')
@section('title', 'Owner dashboard')

@section('content')
@php $first = \Illuminate\Support\Str::before($user->name, ' ') ?: $user->name; @endphp

<div class="tp-page-head">
    <div>
        <h1>Hello, {{ $first }}</h1>
        <p>Your properties, buyers and tenants, all in one place.</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a href="{{ route('agent.properties.houses.create') }}" class="tu-btn tu-btn-primary tu-btn-sm"><x-tu-icon name="plus" /> List a house</a>
        <a href="{{ route('agent.properties.lands.create') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="plus" /> List land</a>
        <a href="{{ route('agent.designs.create') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="plus" /> Upload design</a>
    </div>
</div>

<div class="tp-stats">
    @foreach ([
        ['My listings', $stats['listings'], 'layers', route('room.listings.index'), $stats['live'] . ' live'],
        ['New inquiries', $stats['inquiries'], 'mail', route('room.inquiries.index'), null],
        ['Viewing requests', $stats['viewings'], 'calendar', route('room.viewings.index'), null],
        ['Open offers', $stats['offers'], 'tag', route('room.offers.index'), null],
        ['Unread messages', $stats['messages'], 'list', route('room.messages.index'), null],
        ['Listing views', $stats['views'], 'eye', route('room.performance'), null],
    ] as [$label, $value, $icon, $url, $hint])
        <a href="{{ $url }}" class="tp-stat">
            <div class="tp-stat-top">
                <span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span>
                @if ($hint)<span class="tu-badge tu-badge-success">{{ $hint }}</span>@endif
            </div>
            <div><div class="tp-stat-val">{{ number_format($value) }}</div><div class="tp-stat-label">{{ $label }}</div></div>
        </a>
    @endforeach
</div>

@if ($stats['listings'] === 0)
    <div class="card mb-3" style="background:linear-gradient(120deg,var(--tu-navy),var(--tu-navy-800));border:0!important;color:#FFFFFF">
        <div class="card-body" style="padding:28px;display:flex;gap:20px;align-items:center;flex-wrap:wrap">
            <div style="flex:1;min-width:240px">
                <h2 style="color:#FFFFFF;font-size:1.25rem;font-weight:800;margin:0 0 6px">List your first property</h2>
                <p style="margin:0;color:rgba(255, 255, 255,.75);font-size:.9rem">Add photos, a price and the location. Once Terra approves it, clients can message you, book viewings and make offers directly.</p>
            </div>
            <a href="{{ route('agent.properties.houses.create') }}" class="tu-btn tu-btn-primary tu-btn-lg"><x-tu-icon name="plus" /> Add a property</a>
        </div>
    </div>
@endif

<div class="row g-3">
    <div class="col-xl-7">
        <div class="card h-100">
            <div class="card-header tp-card-head">Upcoming viewings <a href="{{ route('room.viewings.index') }}">All viewings</a></div>
            @if ($viewings->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="calendar" /></div><strong>No viewings booked</strong>Clients can request a visit from your listing page.</div>
            @else
                <ul class="tp-list">
                    @foreach ($viewings as $v)
                        <li>
                            <span class="tp-date"><b>{{ $v->scheduled_at->format('M') }}</b><strong>{{ $v->scheduled_at->format('j') }}</strong><span>{{ $v->scheduled_at->format('H:i') }}</span></span>
                            <span class="tp-list-main">
                                <strong>{{ $v->client->name ?? 'Client' }} · {{ $v->listable->title ?? 'Listing' }}</strong>
                                <span>{{ $v->scheduled_at->format('l') }} · {{ $v->scheduled_at->diffForHumans() }}</span>
                            </span>
                            @include('room._status', ['status' => $v->status])
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card h-100">
            <div class="card-header tp-card-head">Offers to review <a href="{{ route('room.offers.index') }}">All offers</a></div>
            @if ($offers->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="tag" /></div><strong>No open offers</strong>Offers from clients will appear here.</div>
            @else
                <ul class="tp-list">
                    @foreach ($offers as $o)
                        <li>
                            <span class="tp-list-main">
                                <strong>{{ number_format($o->amount) }} {{ $o->currency }}</strong>
                                <span>{{ $o->client->name ?? 'Client' }} · {{ \Illuminate\Support\Str::limit($o->listable->title ?? 'Listing', 34) }}</span>
                            </span>
                            @include('room._status', ['status' => $o->status])
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="col-xl-7">
        <div class="card h-100">
            <div class="card-header tp-card-head">My listings <a href="{{ route('room.listings.index') }}">Manage all</a></div>
            @if ($listings->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="home" /></div><strong>Nothing listed yet</strong>Your houses, land and designs will show here.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th>Listing</th><th>Status</th><th>Package</th><th class="text-end">Inquiries</th></tr></thead>
                        <tbody>
                            @foreach ($listings as $l)
                                <tr>
                                    <td>@include('room._listing', ['listing' => $l])</td>
                                    <td>@include('room._status', ['status' => $l->reviewState()])</td>
                                    <td>
                                        @if ($l->activePromotion)
                                            <span class="tu-badge {{ $l->activePromotion->tier === 'premium' ? 'tu-badge-featured' : '' }}">{{ ucfirst($l->activePromotion->tier) }} · {{ $l->activePromotion->daysLeft() }}d</span>
                                        @else
                                            <a href="{{ route('room.listings.promote', [\App\Support\ListingRef::type($l), $l->id]) }}" class="tu-btn tu-btn-sm">Promote</a>
                                        @endif
                                    </td>
                                    <td class="text-end" style="font-weight:700">{{ $l->inquiries_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card h-100">
            <div class="card-header tp-card-head">Latest inquiries <a href="{{ route('room.inquiries.index') }}">Inbox</a></div>
            @if ($inquiries->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="mail" /></div><strong>No inquiries yet</strong>Questions about your listings land here.</div>
            @else
                <ul class="tp-list">
                    @foreach ($inquiries as $i)
                        <li>
                            <span class="tu-avatar">{{ strtoupper(mb_substr($i->name, 0, 1)) }}</span>
                            <span class="tp-list-main">
                                <strong>{{ $i->name }}</strong>
                                <span>{{ \Illuminate\Support\Str::limit($i->message, 60) }}</span>
                            </span>
                            @include('room._status', ['status' => $i->status])
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
