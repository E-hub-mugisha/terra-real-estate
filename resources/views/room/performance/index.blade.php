@extends('layouts.agents')
@section('title', 'Listing performance')

@section('content')
@php $maxViews = max($listings->max('views_count') ?: 0, 1); @endphp
<div class="tp-page-head">
    <div>
        <h1>Listing performance</h1>
        <p>How clients engage with each of your listings.</p>
    </div>
</div>

<div class="tp-stats">
    @foreach ([
        ['Views', $totals['views'], 'eye'],
        ['Unique visitors', $totals['unique'], 'users'],
        ['Saves', $totals['saves'], 'heart'],
        ['Inquiries', $totals['inquiries'], 'mail'],
        ['Viewings', $totals['viewings'], 'calendar'],
        ['Offers', $totals['offers'], 'tag'],
    ] as [$label, $value, $icon])
        <div class="tp-stat">
            <div class="tp-stat-top"><span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span></div>
            <div><div class="tp-stat-val">{{ number_format($value) }}</div><div class="tp-stat-label">{{ $label }}</div></div>
        </div>
    @endforeach
    <div class="tp-stat">
        <div class="tp-stat-top"><span class="tp-stat-ico"><x-tu-icon name="percent" /></span></div>
        <div><div class="tp-stat-val">{{ $totals['conversion'] }}%</div><div class="tp-stat-label">Views → inquiries</div></div>
    </div>
</div>

@if ($listings->isEmpty())
    @include('room._empty', ['icon' => 'trending', 'title' => 'No listings to measure', 'text' => 'Once you list a property, its views, saves and inquiries are tracked here.', 'action' => ['Add a property', route('agent.properties.houses.create')]])
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Listing</th><th style="min-width:160px">Views</th><th class="text-end">Saves</th><th class="text-end">Inquiries</th><th class="text-end">Viewings</th><th class="text-end">Offers</th><th>Package</th></tr></thead>
                <tbody>
                    @foreach ($listings as $l)
                        <tr>
                            <td>@include('room._listing', ['listing' => $l])</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="tp-meter" style="flex:1"><i style="width:{{ round(($l->views_count ?? 0) / $maxViews * 100) }}%"></i></div>
                                    <strong style="font-size:.84rem;color:var(--tu-ink);min-width:36px;text-align:right">{{ number_format($l->views_count ?? 0) }}</strong>
                                </div>
                            </td>
                            <td class="text-end">{{ $l->saves_count }}</td>
                            <td class="text-end">{{ $l->inquiries_count }}</td>
                            <td class="text-end">{{ $l->viewings_count }}</td>
                            <td class="text-end">{{ $l->offers_count }}</td>
                            <td>
                                @if ($l->activePromotion)
                                    <span class="tu-badge {{ $l->activePromotion->tier === 'premium' ? 'tu-badge-featured' : 'tu-badge-success' }}">{{ ucfirst($l->activePromotion->tier) }}</span>
                                @else
                                    <a href="{{ route('room.listings.promote', [\App\Support\ListingRef::type($l), $l->id]) }}" style="font-size:.8rem;font-weight:700;color:var(--tu-brand)">Boost</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
