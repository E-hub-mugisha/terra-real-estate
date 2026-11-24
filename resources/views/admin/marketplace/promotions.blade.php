@extends('layouts.app')
@section('title', 'Promotions & ads')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Promotions & ads</h1>
        <p>Packages running now. Premium gets the homepage pop-up; basic and medium appear in the ads strip for their share of paid days.</p>
    </div>
    <a href="{{ route('admin.marketplace.settings') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="settings" /> Ad timing settings</a>
</div>

<div class="tp-stats">
    @foreach ([['Active packages', $counts['active'], 'package'], ['In homepage ads now', $counts['ads'], 'star'], ['In spotlight pop-up', $counts['spotlight'], 'sparkle']] as [$label, $v, $icon])
        <div class="tp-stat"><div class="tp-stat-top"><span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span></div><div><div class="tp-stat-val">{{ $v }}</div><div class="tp-stat-label">{{ $label }}</div></div></div>
    @endforeach
</div>

<div class="tp-toolbar">
    @include('admin.marketplace._tabs', ['param' => 'state', 'current' => $state, 'options' => ['active' => 'Active', 'ads' => 'In ads now', 'ended' => 'Ended / cancelled', 'all' => 'All']])
</div>

@if ($promotions->isEmpty())
    @include('room._empty', ['icon' => 'star', 'title' => 'No promotions', 'text' => 'Promotions start when a listing payment is confirmed.'])
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Listing</th><th>Tier</th><th>Period</th><th>In ads until</th><th>Spotlight</th><th>Status</th><th class="text-end"></th></tr></thead>
                <tbody>
                    @foreach ($promotions as $p)
                        @php $live = $p->status === 'active' && $p->ends_at->isFuture(); @endphp
                        <tr>
                            <td>@include('room._listing', ['listing' => $p->listable])</td>
                            <td><span class="tu-badge {{ $p->tier === 'premium' ? 'tu-badge-featured' : ($p->tier === 'medium' ? 'tu-badge-success' : '') }}">{{ ucfirst($p->tier) }}</span><div style="font-size:.72rem;color:var(--tu-subtle)">{{ $p->days }} days</div></td>
                            <td style="font-size:.82rem;white-space:nowrap">{{ $p->starts_at->format('j M') }} → {{ $p->ends_at->format('j M Y') }}@if ($live)<div style="font-size:.72rem;color:var(--tu-muted)">{{ $p->daysLeft() }} days left</div>@endif</td>
                            <td style="font-size:.82rem;white-space:nowrap">{{ $p->ad_ends_at ? $p->ad_ends_at->format('j M Y') : '—' }}@if ($live && $p->ad_ends_at)<div style="font-size:.72rem;color:var(--tu-muted)">{{ $p->adDaysLeft() }} days</div>@endif</td>
                            <td>{!! $p->spotlight ? '<span class="tu-badge tu-badge-featured">On</span>' : '<span style="color:var(--tu-subtle)">—</span>' !!}</td>
                            <td>@include('room._status', ['status' => $live ? 'active' : ($p->status === 'cancelled' ? 'cancelled' : 'completed')])</td>
                            <td class="text-end">
                                @if ($live)
                                    <div class="tp-item-actions" style="flex-wrap:nowrap">
                                        <form method="POST" action="{{ route('admin.marketplace.promotions.update', $p) }}">@csrf @method('PATCH')<input type="hidden" name="action" value="{{ $p->spotlight ? 'spotlight_off' : 'spotlight_on' }}"><button class="tu-btn tu-btn-sm">{{ $p->spotlight ? 'Remove pop-up' : 'Add to pop-up' }}</button></form>
                                        @if ($p->ad_ends_at && $p->ad_ends_at->isFuture())
                                            <form method="POST" action="{{ route('admin.marketplace.promotions.update', $p) }}">@csrf @method('PATCH')<input type="hidden" name="action" value="end_ads"><button class="tu-btn tu-btn-sm">End ads</button></form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.marketplace.promotions.update', $p) }}" onsubmit="return confirm('Cancel this promotion?')">@csrf @method('PATCH')<input type="hidden" name="action" value="cancel"><button class="tu-btn tu-btn-sm tu-btn-ghost" style="color:var(--tu-danger)">Cancel</button></form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $promotions->links() }}</div>
@endif
@endsection
