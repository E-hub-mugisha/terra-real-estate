@extends('layouts.agents')
@section('title', 'Promote listing')

@section('content')
@php
    $shares = [
        'basic' => (int) \App\Support\Settings::number('ads.basic_share_pct'),
        'medium' => (int) \App\Support\Settings::number('ads.medium_share_pct'),
        'premium' => (int) \App\Support\Settings::number('ads.premium_share_pct'),
    ];
    $tierOf = fn ($p) => \App\Services\Marketplace\PromotionService::normaliseTier($p->package_tier);
    $default = old('listing_package_id', optional($packages->first(fn ($p) => $tierOf($p) === 'medium') ?? $packages->first())->id);
    $days = (int) old('days', 30);
@endphp

<div class="tp-page-head">
    <div>
        <a href="{{ route('room.listings.index') }}" class="tu-link-arrow" style="font-size:.82rem"><x-tu-icon name="arrow-left" size="14" /> My listings</a>
        <h1 style="margin-top:6px">Promote your listing</h1>
        <p>Pick a package and how many days. Your listing stays live for the whole period; the package decides how long it also runs in homepage ads.</p>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body" style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
        @include('room._listing', ['listing' => $listing])
        <div style="margin-left:auto;text-align:right">
            @if ($current)
                <span class="tu-badge {{ $current->tier === 'premium' ? 'tu-badge-featured' : 'tu-badge-success' }}">{{ ucfirst($current->tier) }} running</span>
                <div style="font-size:.8rem;color:var(--tu-muted);margin-top:4px">Ends {{ $current->ends_at->format('j M Y') }} · a new package starts after it</div>
            @else
                <span class="tu-badge">No active package</span>
            @endif
        </div>
    </div>
</div>

@if ($packages->isEmpty())
    @include('room._empty', ['icon' => 'package', 'title' => 'No packages available', 'text' => 'The Terra team has not published packages for this listing type yet. Please check back soon or chat with us on WhatsApp.'])
@else
<form method="POST" action="{{ route('room.listings.promote.store', [$type, $listing->id]) }}" id="promoteForm">
    @csrf
    <div class="tp-plans mb-4">
        @foreach ($packages as $p)
            @php $tier = $tierOf($p); @endphp
            <label class="tp-plan {{ $tier === 'premium' ? 'is-premium' : '' }}">
                @if ($tier === 'premium')<span class="tp-plan-flag">Homepage pop-up</span>@endif
                <input type="radio" name="listing_package_id" value="{{ $p->id }}" data-price="{{ $p->price_per_day }}" data-share="{{ $shares[$tier] ?? 0 }}" @checked($default == $p->id) required>
                <span class="tp-plan-box">
                    <span class="tp-plan-tier">{{ ucfirst($tier) }}</span>
                    <div class="tp-plan-price">{{ number_format($p->price_per_day) }} <small>RWF / day</small></div>
                    <ul>
                        <li><x-tu-icon name="check" /> Listed for every day you pay</li>
                        <li><x-tu-icon name="check" /> In homepage ads for {{ $shares[$tier] ?? 0 }}% of the days</li>
                        @if ($tier === 'premium')
                            <li><x-tu-icon name="check" /> Spotlight pop-up on the homepage</li>
                            <li><x-tu-icon name="check" /> “Featured” badge, shown first in search</li>
                        @endif
                        @foreach ((array) $p->features as $f)
                            @if (is_string($f) && $f !== '')<li><x-tu-icon name="check" /> {{ $f }}</li>@endif
                        @endforeach
                    </ul>
                </span>
            </label>
        @endforeach
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <div class="tu-field">
                        <label for="days">Number of days</label>
                        <input id="days" class="tu-input" type="number" name="days" min="1" max="365" value="{{ $days }}" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tp-seg" role="group" aria-label="Quick pick">
                        @foreach ([7, 14, 30, 60, 90] as $d)
                            <button type="button" class="tu-chip" data-days="{{ $d }}">{{ $d }} days</button>
                        @endforeach
                    </div>
                </div>
            </div>
            @error('days')<div class="tu-field-error">{{ $message }}</div>@enderror
            @error('listing_package_id')<div class="tu-field-error">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="tp-total mb-3">
        <div>
            <span>Total to pay</span><br>
            <strong data-total>—</strong>
        </div>
        <div style="text-align:right">
            <span data-summary></span><br>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg" style="margin-top:6px">Continue to payment <x-tu-icon name="arrow-right" /></button>
        </div>
    </div>
    <p class="tu-hint">Your package starts as soon as the payment is confirmed. Commissions for agents and partners are calculated automatically.</p>
</form>
@endif
@endsection

@push('scripts')
<script>
    (function () {
        const form = document.getElementById('promoteForm');
        if (!form) return;
        const days = form.querySelector('#days');
        const fmt = new Intl.NumberFormat('en-US');
        const update = () => {
            const pick = form.querySelector('input[name=listing_package_id]:checked');
            const d = Math.max(0, parseInt(days.value, 10) || 0);
            if (!pick) return;
            const share = +pick.dataset.share;
            const adDays = share > 0 ? Math.max(1, Math.round(d * share / 100)) : 0;
            form.querySelector('[data-total]').textContent = fmt.format(d * +pick.dataset.price) + ' RWF';
            form.querySelector('[data-summary]').textContent = d + ' days listed · ' + adDays + ' days in homepage ads';
            form.querySelectorAll('[data-days]').forEach(b => b.classList.toggle('is-active', +b.dataset.days === d));
        };
        form.addEventListener('change', update);
        days.addEventListener('input', update);
        form.querySelectorAll('[data-days]').forEach(b => b.addEventListener('click', () => { days.value = b.dataset.days; update(); }));
        update();
    })();
</script>
@endpush
