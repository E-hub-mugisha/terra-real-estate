@extends('layouts.agents')
@section('title', 'My listings')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>My listings</h1>
        <p>Houses, land and designs you manage. Promote a listing to put it in front of more clients.</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a href="{{ route('agent.properties.houses.create') }}" class="tu-btn tu-btn-primary tu-btn-sm"><x-tu-icon name="plus" /> House</a>
        <a href="{{ route('agent.properties.lands.create') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="plus" /> Land</a>
        <a href="{{ route('agent.designs.create') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="plus" /> Design</a>
    </div>
</div>

<div class="tp-toolbar">
    <nav class="tp-box-tabs" aria-label="Filter listings">
        @foreach ([null => 'All', 'live' => 'Live', 'pending' => 'Pending review', 'promoted' => 'Promoted'] as $key => $label)
            <a href="{{ route('room.listings.index', array_filter(['filter' => $key ?: null])) }}" class="{{ ($filter ?: null) == ($key ?: null) ? 'is-active' : '' }}">{{ $label }}</a>
        @endforeach
    </nav>
    <span style="font-size:.84rem;color:var(--tu-muted)">{{ $listings->count() }} {{ \Illuminate\Support\Str::plural('listing', $listings->count()) }}</span>
</div>

@if ($listings->isEmpty())
    @include('room._empty', [
        'icon' => 'home',
        'title' => $filter ? 'Nothing here' : 'No listings yet',
        'text' => $filter ? 'No listings match this filter.' : 'Add a house, plot or architectural design. After Terra approves it, clients can contact you directly.',
        'action' => $filter ? ['Show all', route('room.listings.index')] : ['Add a house', route('agent.properties.houses.create')],
    ])
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Listing</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Package</th>
                        <th class="text-center" title="Views · inquiries · viewings · offers">Activity</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listings as $l)
                        @php $type = \App\Support\ListingRef::type($l); $promo = $l->activePromotion; $state = $l->reviewState(); @endphp
                        <tr>
                            <td>@include('room._listing', ['listing' => $l])</td>
                            <td style="font-weight:700;color:var(--tu-ink);white-space:nowrap">
                                {{ ($type === 'design' && $l->is_free) ? 'Free' : number_format((float) $l->price) . ' ' . ($l->currency ?: 'RWF') }}
                            </td>
                            <td>
                                @include('room._status', ['status' => $state])
                                @if ($state === 'rejected' && $l->rejection_reason)
                                    <div style="font-size:.74rem;color:var(--tu-danger);max-width:200px;margin-top:4px">{{ \Illuminate\Support\Str::limit($l->rejection_reason, 80) }}</div>
                                @endif
                            </td>
                            <td style="white-space:nowrap">
                                @if ($promo)
                                    <span class="tu-badge {{ $promo->tier === 'premium' ? 'tu-badge-featured' : 'tu-badge-success' }}">{{ ucfirst($promo->tier) }}</span>
                                    <div style="font-size:.74rem;color:var(--tu-muted);margin-top:4px">{{ $promo->daysLeft() }} days left · ads {{ $promo->adDaysLeft() }}d</div>
                                @else
                                    <span style="font-size:.8rem;color:var(--tu-muted)">No package</span>
                                @endif
                            </td>
                            <td class="text-center" style="white-space:nowrap;font-size:.82rem;color:var(--tu-muted)">
                                <span title="Views"><x-tu-icon name="eye" size="13" /> {{ number_format($l->views_count ?? 0) }}</span> ·
                                <span title="Inquiries"><x-tu-icon name="mail" size="13" /> {{ $l->inquiries_count }}</span> ·
                                <span title="Viewings"><x-tu-icon name="calendar" size="13" /> {{ $l->viewings_count }}</span> ·
                                <span title="Offers"><x-tu-icon name="tag" size="13" /> {{ $l->offers_count }}</span>
                            </td>
                            <td class="text-end">
                                <div class="tp-item-actions" style="flex-wrap:nowrap">
                                    <a href="{{ route('room.listings.promote', [$type, $l->id]) }}" class="tu-btn tu-btn-sm {{ $promo ? '' : 'tu-btn-primary' }}">{{ $promo ? 'Extend' : 'Promote' }}</a>
                                    <a href="{{ \App\Support\ListingRef::editUrl($l) }}" class="tu-btn tu-btn-sm tu-btn-icon" title="Edit" aria-label="Edit {{ $l->title }}"><x-tu-icon name="settings" /></a>
                                    <a href="{{ route('room.listings.documents', [$type, $l->id]) }}" class="tu-btn tu-btn-sm tu-btn-icon" title="Documents" aria-label="Documents for {{ $l->title }}"><x-tu-icon name="file" /></a>
                                    @if ($l->isApproved())
                                        <a href="{{ $l->publicUrl() }}" target="_blank" rel="noopener" class="tu-btn tu-btn-sm tu-btn-icon" title="View public page" aria-label="View {{ $l->title }} on Terra"><x-tu-icon name="external" /></a>
                                    @else
                                        <a href="{{ \App\Support\ListingRef::showUrl($l) }}" class="tu-btn tu-btn-sm tu-btn-icon" title="Details" aria-label="Details of {{ $l->title }}"><x-tu-icon name="eye" /></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
