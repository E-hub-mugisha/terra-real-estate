@extends('layouts.guest')
@section('title', $home->title)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) $home->description), 155))

@section('content')
@php
    $item = \App\Support\Listing::house($home);
    $images = $home->images->map(fn ($img) => asset('image/houses/' . $img->image_path))->all();
    $isRent = $home->condition === 'for_rent';
    $address = collect([$home->village, $home->cell, $home->sector, $home->district, $home->province])->filter()->implode(', ');
    $facts = array_filter([
        ['bed', $home->bedrooms, 'Bedrooms'],
        ['bath', $home->bathrooms, 'Bathrooms'],
        ['car', $home->garages, 'Parking'],
        ['area', $home->area_sqft ? number_format($home->area_sqft) . ' sqft' : null, 'Floor area'],
        ['home', $home->type ? ucfirst(str_replace(['_', '-'], ' ', $home->type)) : null, 'Type'],
    ], fn ($f) => filled($f[1]));
    $related = \App\Support\Listing::collect($relatedHomes);
@endphp

<div class="tu-container tu-detail">
    <ol class="tu-crumbs tu-crumbs-dark">
        <li><a href="{{ route('front.home') }}">Home</a></li>
        <li><a href="{{ $isRent ? route('front.rent.homes') : route('front.buy.homes') }}">{{ $isRent ? 'Houses for rent' : 'Houses for sale' }}</a></li>
        <li>{{ \Illuminate\Support\Str::limit($home->title, 40) }}</li>
    </ol>

    <div class="tu-detail-head">
        <div>
            <div style="display:flex;gap:6px;flex-wrap:wrap">
                <span class="tu-badge tu-badge-house">{{ $item['kind_label'] }}</span>
                <span class="tu-badge">{{ $isRent ? 'For rent' : 'For sale' }}</span>
                @if ($home->status && $home->status !== 'available')<span class="tu-badge tu-badge-warn">{{ ucfirst($home->status) }}</span>@endif
                @if ($item['featured'])<span class="tu-badge tu-badge-featured">Featured</span>@endif
            </div>
            <h1 class="tu-detail-title">{{ $home->title }}</h1>
            <div class="tu-card-loc" style="font-size:.92rem"><x-tu-icon name="pin" /> {{ $address ?: 'Rwanda' }}</div>
        </div>
        <div class="tu-detail-price">
            <strong>{{ $home->price > 0 ? number_format($home->price) . ' ' . ($home->currency ?: 'RWF') : 'Price on request' }}</strong>
            <span>{{ $isRent ? 'per month' : 'asking price' }}@if ($item['negotiable']) · negotiable @endif</span>
        </div>
    </div>

    @include('front.partials.detail-gallery', [
        'images' => $images,
        'title' => $home->title,
        'fallback' => asset('front/assets/img/all-images/properties/property-img1.png'),
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
                <h2 class="tu-panel-title">About this home</h2>
                <p class="tu-prose" style="margin:0">{{ $home->description ?: 'No description has been added yet.' }}</p>
            </div>

            @if ($home->facilities->isNotEmpty())
                <div class="tu-panel">
                    <h2 class="tu-panel-title">Amenities</h2>
                    <div class="tu-amenities">
                        @foreach ($home->facilities as $facility)
                            <span class="tu-amenity"><x-tu-icon name="check" /> {{ $facility->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="tu-panel">
                <h2 class="tu-panel-title">Details</h2>
                <dl class="tu-kv">
                    <div><dt>Listing</dt><dd>{{ $isRent ? 'For rent' : 'For sale' }}</dd></div>
                    <div><dt>Status</dt><dd>{{ ucfirst($home->status ?: 'available') }}</dd></div>
                    @if ($home->upi)<div><dt>UPI</dt><dd>{{ $home->upi }}</dd></div>@endif
                    <div><dt>Price</dt><dd>{{ $item['negotiable'] ? 'Negotiable' : 'Fixed' }}</dd></div>
                    @if ($home->district)<div><dt>District</dt><dd>{{ $home->district }}</dd></div>@endif
                    @if ($home->sector)<div><dt>Sector</dt><dd>{{ $home->sector }}</dd></div>@endif
                    <div><dt>Listed</dt><dd>{{ optional($home->created_at)->format('d M Y') }}</dd></div>
                    @if ($home->views_count)<div><dt>Views</dt><dd>{{ number_format($home->views_count) }}</dd></div>@endif
                </dl>
            </div>

            @include('front.partials.detail-media', [
                'video' => $home->video_url,
                'lat' => $home->latitude,
                'lng' => $home->longitude,
                'address' => $address,
            ])
        </div>

        <aside class="tu-sticky">
            @include('front.partials.detail-contact', [
                'listing' => $home,
                'saveId' => 'house-' . $home->id,
                'agent' => $home->agent,
                'title' => $home->title,
                'wa' => $item['wa'],
                'inquiryRoute' => route('front.buy.home.inquiry'),
                'idField' => 'home_id',
                'idValue' => $home->id,
            ])
        </aside>
    </div>

    @if ($related->isNotEmpty())
        <section style="margin-top:56px">
            <div class="tu-section-head">
                <h2 class="tu-h2">Similar homes</h2>
                <a href="{{ $isRent ? route('front.rent.homes') : route('front.buy.homes') }}" class="tu-link-arrow">See more <x-tu-icon name="arrow-right" /></a>
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
