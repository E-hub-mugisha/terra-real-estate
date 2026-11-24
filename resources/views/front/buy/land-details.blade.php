@extends('layouts.guest')
@section('title', $land->title)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) $land->description), 155))

@section('content')
@php
    $item = \App\Support\Listing::land($land);
    $images = $land->images->map(fn ($img) => asset('image/lands/' . $img->image_path))->all();
    $isRent = $land->condition === 'for_rent';
    $address = collect([$land->village, $land->cell, $land->sector, $land->district, $land->province])->filter()->implode(', ');
    $doc = $land->title_doc_path ?? $land->title_doc ?? null;
    $pricePerSqm = ($land->price > 0 && $land->size_sqm > 0) ? $land->price / $land->size_sqm : null;
    $facts = array_filter([
        ['area', $land->size_sqm ? number_format($land->size_sqm) . ' m²' : null, 'Plot size'],
        ['tag', $land->zoning, 'Zoning'],
        ['land', $land->land_use, 'Land use'],
        ['percent', $pricePerSqm ? number_format($pricePerSqm) . ' / m²' : null, 'Price per m²'],
    ], fn ($f) => filled($f[1]));
    $related = \App\Support\Listing::collect($relatedLands);
@endphp

<div class="tu-container tu-detail">
    <ol class="tu-crumbs tu-crumbs-dark">
        <li><a href="{{ route('front.home') }}">Home</a></li>
        <li><a href="{{ $isRent ? route('front.rent.lands') : route('front.buy.lands') }}">{{ $isRent ? 'Land for rent' : 'Land for sale' }}</a></li>
        <li>{{ \Illuminate\Support\Str::limit($land->title, 40) }}</li>
    </ol>

    <div class="tu-detail-head">
        <div>
            <div style="display:flex;gap:6px;flex-wrap:wrap">
                <span class="tu-badge tu-badge-land">{{ $item['kind_label'] }}</span>
                <span class="tu-badge">{{ $isRent ? 'For rent' : 'For sale' }}</span>
                @if ($land->status && $land->status !== 'available')<span class="tu-badge tu-badge-warn">{{ ucfirst($land->status) }}</span>@endif
                @if ($item['featured'])<span class="tu-badge tu-badge-featured">Featured</span>@endif
            </div>
            <h1 class="tu-detail-title">{{ $land->title }}</h1>
            <div class="tu-card-loc" style="font-size:.92rem"><x-tu-icon name="pin" /> {{ $address ?: 'Rwanda' }}</div>
        </div>
        <div class="tu-detail-price">
            <strong>{{ $land->price > 0 ? number_format($land->price) . ' ' . ($land->currency ?: 'RWF') : 'Price on request' }}</strong>
            <span>{{ $isRent ? 'per month' : 'asking price' }}@if ($item['negotiable']) · negotiable @endif</span>
        </div>
    </div>

    @include('front.partials.detail-gallery', [
        'images' => $images,
        'title' => $land->title,
        'fallback' => asset('front/assets/img/all-images/hero/plot.png'),
    ])

    <div class="tu-detail-grid">
        <div>
            @if ($facts)
                <div class="tu-panel">
                    <div class="tu-facts">
                        @foreach ($facts as [$icon, $value, $label])
                            <div class="tu-fact">
                                <span class="tu-fact-ico"><x-tu-icon :name="$icon" /></span>
                                <span><strong>{{ $value }}</strong><span>{{ $label }}</span></span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="tu-panel">
                <h2 class="tu-panel-title">About this plot</h2>
                <p class="tu-prose" style="margin:0">{{ $land->description ?: 'No description has been added yet.' }}</p>
            </div>

            <div class="tu-panel">
                <h2 class="tu-panel-title">Details</h2>
                <dl class="tu-kv">
                    <div><dt>Listing</dt><dd>{{ $isRent ? 'For rent' : 'For sale' }}</dd></div>
                    <div><dt>Status</dt><dd>{{ ucfirst($land->status ?: 'available') }}</dd></div>
                    @if ($land->upi)<div><dt>UPI</dt><dd>{{ $land->upi }}</dd></div>@endif
                    <div><dt>Price</dt><dd>{{ $item['negotiable'] ? 'Negotiable' : 'Fixed' }}</dd></div>
                    @if ($land->district)<div><dt>District</dt><dd>{{ $land->district }}</dd></div>@endif
                    @if ($land->sector)<div><dt>Sector</dt><dd>{{ $land->sector }}</dd></div>@endif
                    @if ($land->cell)<div><dt>Cell</dt><dd>{{ $land->cell }}</dd></div>@endif
                    <div><dt>Listed</dt><dd>{{ optional($land->created_at)->format('d M Y') }}</dd></div>
                </dl>
                @if ($doc)
                    <a href="{{ asset('storage/' . $doc) }}" target="_blank" rel="noopener" class="tu-btn" style="margin-top:18px">
                        <x-tu-icon name="file" /> View land title document
                    </a>
                @endif
            </div>

            @include('front.partials.detail-media', [
                'video' => $land->video_url,
                'lat' => $land->latitude,
                'lng' => $land->longitude,
                'address' => $address,
            ])
        </div>

        <aside class="tu-sticky">
            @include('front.partials.detail-contact', [
                'listing' => $land,
                'saveId' => 'land-' . $land->id,
                'agent' => $land->agent,
                'title' => $land->title,
                'wa' => $item['wa'],
                'inquiryRoute' => route('front.buy.land.inquiry'),
                'idField' => 'land_id',
                'idValue' => $land->id,
            ])
            <div class="tu-panel">
                <h2 class="tu-panel-title" style="font-size:.95rem">Planning to build?</h2>
                <p class="tu-hint" style="font-size:.86rem;margin:0 0 14px">Browse ready-made architectural designs that suit a plot like this one.</p>
                <a href="{{ route('front.properties.architecture') }}" class="tu-btn tu-btn-block"><x-tu-icon name="ruler" /> Browse designs</a>
            </div>
        </aside>
    </div>

    @if ($related->isNotEmpty())
        <section style="margin-top:56px">
            <div class="tu-section-head">
                <h2 class="tu-h2">Similar plots</h2>
                <a href="{{ $isRent ? route('front.rent.lands') : route('front.buy.lands') }}" class="tu-link-arrow">See more <x-tu-icon name="arrow-right" /></a>
            </div>
            <div class="tu-grid">
                @foreach ($related as $rel)
                    @include('front.partials.card', ['item' => $rel])
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
