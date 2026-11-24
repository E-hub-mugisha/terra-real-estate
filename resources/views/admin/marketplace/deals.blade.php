@extends('layouts.app')
@section('title', 'Viewings & offers')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Viewings & offers</h1>
        <p>Follow deals between owners and clients. Record a sale or rental to create agent and partner commissions.</p>
    </div>
</div>

<div class="tp-stats">
    @foreach ([['Offers', $counts['offers'], 'tag'], ['Accepted offers', $counts['accepted'], 'check'], ['Viewings', $counts['viewings'], 'calendar'], ['Upcoming confirmed', $counts['upcoming'], 'clock']] as [$label, $v, $icon])
        <div class="tp-stat"><div class="tp-stat-top"><span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span></div><div><div class="tp-stat-val">{{ number_format($v) }}</div><div class="tp-stat-label">{{ $label }}</div></div></div>
    @endforeach
</div>

<div class="tp-toolbar">
    <nav class="tp-box-tabs" aria-label="Section">
        <a href="{{ route('admin.marketplace.deals', ['tab' => 'offers']) }}" class="{{ $tab === 'offers' ? 'is-active' : '' }}">Offers</a>
        <a href="{{ route('admin.marketplace.deals', ['tab' => 'viewings']) }}" class="{{ $tab === 'viewings' ? 'is-active' : '' }}">Viewings</a>
    </nav>
    @if ($tab === 'offers')
        @include('admin.marketplace._tabs', ['param' => 'status', 'current' => request('status', ''), 'options' => ['' => 'All'] + array_combine(\App\Models\Offer::STATUSES, array_map('ucfirst', \App\Models\Offer::STATUSES))])
    @else
        @include('admin.marketplace._tabs', ['param' => 'status', 'current' => request('status', ''), 'options' => ['' => 'All'] + array_combine(\App\Models\Viewing::STATUSES, array_map('ucfirst', \App\Models\Viewing::STATUSES))])
    @endif
</div>

@php $rows = $tab === 'offers' ? $offers : $viewings; @endphp
@if ($rows->isEmpty())
    @include('room._empty', ['icon' => $tab === 'offers' ? 'tag' : 'calendar', 'title' => 'Nothing yet', 'text' => 'No ' . $tab . ' match this filter.'])
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                @if ($tab === 'offers')
                    <thead><tr><th>Listing</th><th>Client</th><th>To</th><th class="text-end">Offer</th><th class="text-end">Counter</th><th>Status</th><th class="text-end"></th></tr></thead>
                    <tbody>
                        @foreach ($offers as $o)
                            <tr>
                                <td>@include('room._listing', ['listing' => $o->listable])</td>
                                <td style="font-size:.84rem">{{ $o->client->name ?? '—' }}</td>
                                <td style="font-size:.84rem">{{ $o->recipient->name ?? 'Terra' }}</td>
                                <td class="text-end" style="font-weight:800;color:var(--tu-ink);white-space:nowrap">{{ number_format($o->amount) }} <small>{{ $o->currency }}</small></td>
                                <td class="text-end" style="white-space:nowrap">{{ $o->counter_amount ? number_format($o->counter_amount) : '—' }}</td>
                                <td>@include('room._status', ['status' => $o->status])<div style="font-size:.72rem;color:var(--tu-subtle)">{{ $o->created_at->format('j M') }}</div></td>
                                <td class="text-end">
                                    @if ($o->status === 'accepted' && $o->listable && \App\Support\ListingRef::type($o->listable) !== 'design' && !in_array($o->listable->status, ['sold', 'rented'], true))
                                        <button type="button" class="tu-btn tu-btn-dark tu-btn-sm" data-modal-open="dealModal" data-action="{{ route('admin.marketplace.deal', [\App\Support\ListingRef::type($o->listable), $o->listable->id]) }}" data-field-value="{{ (int) $o->amount }}">Record deal</button>
                                    @elseif ($o->listable && in_array($o->listable->status, ['sold', 'rented'], true))
                                        <span class="tu-badge tu-badge-success">{{ ucfirst($o->listable->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <thead><tr><th>When</th><th>Listing</th><th>Client</th><th>Host</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach ($viewings as $v)
                            <tr>
                                <td style="white-space:nowrap"><strong style="color:var(--tu-ink)">{{ $v->scheduled_at->format('j M Y') }}</strong><div style="font-size:.76rem;color:var(--tu-muted)">{{ $v->scheduled_at->format('D H:i') }}</div></td>
                                <td>@include('room._listing', ['listing' => $v->listable])</td>
                                <td style="font-size:.84rem">{{ $v->client->name ?? '—' }}</td>
                                <td style="font-size:.84rem">{{ $v->host->name ?? 'Terra' }}</td>
                                <td>@include('room._status', ['status' => $v->status])</td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $rows->links() }}</div>
@endif

@include('admin.marketplace._deal-modal')
@endsection
