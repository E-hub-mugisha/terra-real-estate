@extends('layouts.agents')
@section('title', 'Dashboard')

@section('content')

{{-- Verification gate: unverified agents can look around but are told why listings are on hold --}}
@if (!$isVerified)
    <div class="tu-modal is-open" role="dialog" aria-modal="true" aria-labelledby="verifyTitle" style="z-index:1060">
        <div class="tu-modal-box" style="max-width:440px;text-align:center">
            <div class="tu-modal-body" style="padding:34px 30px 26px">
                <div class="tu-empty-ico" style="width:64px;height:64px;border-radius:50%"><x-tu-icon name="shield" /></div>
                <h3 id="verifyTitle" class="tu-h3" style="font-size:1.2rem;margin-bottom:8px">Your account is being verified</h3>
                <p style="color:var(--tu-muted);line-height:1.7;margin:0 0 20px">
                    Hi <strong style="color:var(--tu-ink)">{{ $user->name }}</strong>, the Terra team is reviewing your agent profile.
                    You'll get an email once it's approved — usually within one working day.
                </p>
                <span class="tu-badge tu-badge-warn" style="margin-bottom:22px"><x-tu-icon name="clock" size="12" /> Awaiting approval</span>
                <div class="tu-stack">
                    <a href="https://wa.me/{{ \App\Support\Listing::WHATSAPP }}" target="_blank" rel="noopener" class="tu-btn tu-btn-wa tu-btn-block"><x-tu-icon name="whatsapp" /> Chat with Terra</a>
                    <div style="display:flex;gap:10px">
                        <a href="{{ route('front.home') }}" class="tu-btn" style="flex:1">Go to website</a>
                        <form method="POST" action="{{ route('logout') }}" style="flex:1">
                            @csrf
                            <button type="submit" class="tu-btn tu-btn-dark tu-btn-block">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@php $maxCount = max($listingChart->max('count'), 1); @endphp

<div class="tp-page-head">
    <div>
        <h1>Welcome back, {{ \Illuminate\Support\Str::before($user->name, ' ') ?: $user->name }}</h1>
        <p>Your listings at a glance.</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a href="{{ route('agent.properties.houses.create') }}" class="tu-btn tu-btn-primary tu-btn-sm"><x-tu-icon name="plus" /> List a house</a>
        <a href="{{ route('agent.properties.lands.create') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="plus" /> List land</a>
        <a href="{{ route('agent.designs.create') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="plus" /> Upload design</a>
    </div>
</div>

<div class="tp-stats">
    @foreach ([
        ['My houses', $totalHouses, 'home', route('agent.properties.houses.index')],
        ['My land', $totalLands, 'land', route('agent.properties.land.index')],
        ['My designs', $totalDesigns, 'ruler', route('agent.designs.index')],
        ['Pending approval', $pendingApproval, 'clock', null],
    ] as [$label, $value, $icon, $url])
        @if ($url)
            <a href="{{ $url }}" class="tp-stat">
                <div class="tp-stat-top"><span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span></div>
                <div><div class="tp-stat-val">{{ number_format($value) }}</div><div class="tp-stat-label">{{ $label }}</div></div>
            </a>
        @else
            <div class="tp-stat">
                <div class="tp-stat-top"><span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span></div>
                <div><div class="tp-stat-val">{{ number_format($value) }}</div><div class="tp-stat-label">{{ $label }}</div></div>
            </div>
        @endif
    @endforeach
</div>

<div class="tp-stats">
    @foreach ([
        ['New inquiries', $room['inquiries'], 'mail', route('room.inquiries.index')],
        ['Viewing requests', $room['viewings'], 'calendar', route('room.viewings.index')],
        ['Offers to answer', $room['offers'], 'tag', route('room.offers.index')],
        ['Open leads', $room['leads'], 'users', route('room.referrals.index')],
        ['Assigned to me', $room['assigned'], 'briefcase', route('room.assigned')],
        ['Earned (RWF)', $room['earned'], 'credit', route('room.earnings')],
    ] as [$label, $value, $icon, $url])
        <a href="{{ $url }}" class="tp-stat">
            <div class="tp-stat-top"><span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span>@if ($icon === 'credit' && $room['pending'])<span class="tu-badge tu-badge-warn">+{{ number_format($room['pending']) }} pending</span>@endif</div>
            <div><div class="tp-stat-val">{{ number_format($value) }}</div><div class="tp-stat-label">{{ $label }}</div></div>
        </a>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header">Listings added · last 6 months</div>
            <div class="card-body">
                <div style="display:flex;align-items:flex-end;gap:14px;height:150px">
                    @foreach ($listingChart as $i => $point)
                        @php $h = round(($point['count'] / $maxCount) * 100); @endphp
                        <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;gap:6px;height:100%">
                            <span style="font-size:.72rem;font-weight:700;color:var(--tu-muted)">{{ $point['count'] ?: '' }}</span>
                            <div title="{{ $point['label'] }}: {{ $point['count'] }}" style="width:100%;max-width:46px;height:{{ max($h, 4) }}%;border-radius:8px 8px 3px 3px;background:{{ $i === 5 ? 'var(--tu-brand)' : 'var(--tu-brand-100)' }}"></div>
                            <span style="font-size:.74rem;font-weight:700;color:var(--tu-subtle)">{{ $point['label'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="row g-3 mt-2 pt-3 border-top text-center">
                    <div class="col-6">
                        <div style="font-size:.72rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--tu-muted)">Listing fees paid</div>
                        <div style="font-size:1.1rem;font-weight:800;color:var(--tu-ink)">{{ number_format($feesPaid) }} <small style="color:var(--tu-muted)">RWF</small></div>
                    </div>
                    <div class="col-6">
                        <div style="font-size:.72rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--tu-muted)">Payments pending</div>
                        <div style="font-size:1.1rem;font-weight:800;color:{{ $pendingPayments ? 'var(--tu-warn)' : 'var(--tu-ink)' }}">{{ $pendingPayments }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="tu-agent-photo" style="margin:6px auto 12px">
                    @if ($agent?->profile_image)
                        <img src="{{ asset('image/agents/' . $agent->profile_image) }}" alt="{{ $agent->full_name }}" onerror="this.outerHTML='<span class=&quot;tu-avatar&quot;>{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>'">
                    @else
                        <span class="tu-avatar">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                    @endif
                    @if ($isVerified)<span class="tu-verified"><x-tu-icon name="check" /></span>@endif
                </div>
                <strong style="display:block;color:var(--tu-ink);font-size:1.02rem">{{ $agent?->full_name ?? $user->name }}</strong>
                <span style="font-size:.82rem;color:var(--tu-muted)">{{ $agent?->email ?? $user->email }}</span>
                <dl class="tu-kv mt-3 text-start" style="grid-template-columns:1fr">
                    <div><dt>Office</dt><dd>{{ $agent?->office_location ?: '—' }}</dd></div>
                    <div><dt>Phone</dt><dd>{{ $agent?->phone ?: '—' }}</dd></div>
                    <div><dt>Languages</dt><dd>{{ $agent?->languages ?: '—' }}</dd></div>
                </dl>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('agent.profile.view') }}" class="tu-btn tu-btn-sm" style="flex:1">Edit profile</a>
                    @if ($agent)<a href="{{ route('front.agent.details', $agent) }}" target="_blank" rel="noopener" class="tu-btn tu-btn-dark tu-btn-sm" style="flex:1">Public page</a>@endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header tp-card-head">Latest inquiries <a href="{{ route('room.inquiries.index') }}">Inbox</a></div>
            @if ($latestInquiries->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="mail" /></div><strong>No inquiries yet</strong>Client questions on your listings land here.</div>
            @else
                <ul class="tp-list">
                    @foreach ($latestInquiries as $i)
                        <li>
                            <span class="tu-avatar">{{ strtoupper(mb_substr($i->name, 0, 1)) }}</span>
                            <span class="tp-list-main"><strong>{{ $i->name }} · {{ \Illuminate\Support\Str::limit($i->listable->title ?? 'Listing', 40) }}</strong><span>{{ \Illuminate\Support\Str::limit($i->message, 90) }}</span></span>
                            @include('room._status', ['status' => $i->status])
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">Recent listings</div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead><tr><th>Title</th><th>Type</th><th>Status</th><th>Added</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($recentListings as $listing)
                            <tr>
                                <td style="font-weight:600;color:var(--tu-ink)">{{ \Illuminate\Support\Str::limit($listing['title'], 52) }}</td>
                                <td><span class="tu-badge tu-badge-{{ strtolower($listing['type']) }}">{{ $listing['type'] }}</span></td>
                                <td><span class="tu-badge {{ $listing['approved'] ? 'tu-badge-success' : 'tu-badge-warn' }}">{{ $listing['approved'] ? 'Live' : 'Pending review' }}</span></td>
                                <td style="color:var(--tu-muted)">{{ optional($listing['created'])->diffForHumans() }}</td>
                                <td class="text-end"><a href="{{ $listing['url'] }}" class="btn btn-sm btn-light">Open</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="tu-empty-ico"><x-tu-icon name="home" /></div>
                                    <strong style="display:block;color:var(--tu-ink)">No listings yet</strong>
                                    <span style="color:var(--tu-muted);font-size:.88rem">Add your first house, plot or design to start getting inquiries.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
