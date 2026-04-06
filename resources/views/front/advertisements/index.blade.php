@extends('layouts.guest')

@section('title', 'Advertisements — Terra Real Estate')

@section('content')

<style>
    .section-tag {
        display: inline-block;
        background: rgba(0, 166, 103, .1);
        color: #00a667;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        padding: 5px 14px;
        border-radius: 20px;
        margin-bottom: 10px;
    }

    .section-title {
        font-size: 28px;
        font-weight: 700;
        color: #051321;
    }

    /* ── Featured ── */
    .ads-featured {
        background: #f8fafc;
        padding: 56px 0 48px;
    }

    .ads-featured__header {
        margin-bottom: 28px;
    }

    .featured-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .featured-card {
        text-decoration: none;
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        border: 1.5px solid #e5e7eb;
        transition: box-shadow .2s, transform .2s;
        display: block;
    }

    .featured-card:hover {
        box-shadow: 0 8px 28px rgba(5, 19, 33, .1);
        transform: translateY(-2px);
    }

    .featured-card__media {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: #f3f4f6;
    }

    .featured-card__img,
    .featured-card__video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .featured-card__body {
        padding: 16px;
    }

    .featured-card__type {
        font-size: 11px;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .featured-card__title {
        font-size: 16px;
        font-weight: 700;
        color: #051321;
        margin: 4px 0 8px;
    }

    .featured-card__loc {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 13px;
        color: #6b7280;
    }

    .featured-card__loc svg {
        width: 13px;
        height: 13px;
    }

    .featured-card__price {
        font-size: 17px;
        font-weight: 800;
        color: #00a667;
        margin-top: 6px;
    }

    /* ── All ads ── */
    .section-pad {
        padding: 60px 0;
    }

    .ads-all__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .ads-filters {
        display: flex;
        gap: 8px;
    }

    .ads-filter {
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        color: #6b7280;
        border: 1px solid #e5e7eb;
        transition: all .15s;
    }

    .ads-filter:hover {
        border-color: #00a667;
        color: #00a667;
    }

    .ads-filter--active {
        background: #051321;
        color: #fff;
        border-color: #051321;
    }

    .ads-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }

    .ad-card {
        text-decoration: none;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        transition: box-shadow .2s;
        display: block;
    }

    .ad-card:hover {
        box-shadow: 0 4px 20px rgba(5, 19, 33, .08);
    }

    .ad-card__media {
        position: relative;
        height: 180px;
        overflow: hidden;
        background: #f3f4f6;
    }

    .ad-card__img,
    .ad-card__video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .3s;
    }

    .ad-card:hover .ad-card__img {
        transform: scale(1.03);
    }

    .ad-card__placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ad-card__placeholder svg {
        width: 40px;
        height: 40px;
        color: #d1d5db;
    }

    .ad-card__type-badge {
        position: absolute;
        bottom: 8px;
        left: 8px;
        background: #051321;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .ad-card__body {
        padding: 14px;
    }

    .ad-card__title {
        font-size: 15px;
        font-weight: 700;
        color: #051321;
        margin-bottom: 4px;
    }

    .ad-card__loc {
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 6px;
    }

    .ad-card__price {
        font-size: 16px;
        font-weight: 800;
        color: #00a667;
        margin-bottom: 6px;
    }

    .ad-card__desc {
        font-size: 12px;
        color: #6b7280;
        line-height: 1.5;
    }

    .media-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        letter-spacing: .05em;
    }

    .media-badge--video {
        background: rgba(124, 58, 237, .9);
        color: #fff;
    }

    .media-badge--premium {
        background: rgba(245, 158, 11, .95);
        color: #fff;
    }

    .ads-empty {
        text-align: center;
        padding: 60px;
    }

    .ads-empty p {
        color: #6b7280;
        margin-bottom: 16px;
    }

    .btn {
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: #00a667;
        color: #fff;
    }

    .btn-primary:hover {
        background: #008f57;
    }

    .ads-cta {
        margin-top: 60px;
        background: #051321;
        border-radius: 16px;
        padding: 48px;
        text-align: center;
    }

    .ads-cta h3 {
        color: #fff;
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .ads-cta p {
        color: rgba(255, 255, 255, .65);
        font-size: 16px;
        margin-bottom: 24px;
    }

    .btn-white {
        background: #fff;
        color: #051321;
    }

    .btn-white:hover {
        background: #f3f4f6;
    }
</style>

@if($featured->count())
<section class="ads-featured">
    <div class="container">
        <div class="ads-featured__header">
            <span class="section-tag">Featured</span>
            <h2 class="section-title">Sponsored Listings</h2>
        </div>
        <div class="featured-grid">
            @foreach ($featured as $ad)
            <a href="{{ route('advertisements.show', $ad) }}"
                onclick="fetch('{{ route('advertisements.click', $ad) }}', {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}})"
                class="featured-card">
                <div class="featured-card__media">
                    @if($ad->video_path)
                    <video src="{{ $ad->video_url }}" muted autoplay loop playsinline class="featured-card__video"></video>
                    <span class="media-badge media-badge--video">VIDEO</span>
                    @elseif($ad->first_image_url)
                    <img src="{{ $ad->first_image_url }}" alt="{{ $ad->title }}" class="featured-card__img">
                    @endif

                    @if($ad->package->featured_homepage)
                    <span class="media-badge media-badge--premium">Premium</span>
                    @endif
                </div>
                <div class="featured-card__body">
                    <span class="featured-card__type">{{ $ad->listing_type }}</span>
                    <h3 class="featured-card__title">{{ Str::limit($ad->title, 55) }}</h3>
                    @if($ad->location)
                    <p class="featured-card__loc">
                        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor">
                            <path d="M8 1.5A4.5 4.5 0 018 10.5S3.5 14 8 14V1.5z" stroke-width="1.2" />
                            <circle cx="8" cy="6" r="2" stroke-width="1.2" />
                        </svg>
                        {{ $ad->location }}
                    </p>
                    @endif
                    @if($ad->price_amount)
                    <p class="featured-card__price">{{ number_format($ad->price_amount) }} {{ $ad->currency }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── All ads ────────────────────────────────────────────────────────────────── --}}
<section class="ads-all section-pad">
    <div class="container">
        <div class="ads-all__header">
            <h2 class="section-title">All Advertisements</h2>

            {{-- Filter tabs --}}
            <div class="ads-filters">
                @foreach (['', 'house', 'land', 'design'] as $type)
                <a href="{{ route('advertisements.index', $type ? ['type' => $type] : []) }}"
                    class="ads-filter {{ request('type') === $type || (!request('type') && $type === '') ? 'ads-filter--active' : '' }}">
                    {{ $type ? ucfirst($type) : 'All' }}
                </a>
                @endforeach
            </div>
        </div>

        @if($ads->isEmpty())
        <div class="ads-empty">
            <p>No advertisements found for this category.</p>
            <a href="{{ route('advertisements.packages') }}" class="btn btn-primary">Be the first to advertise →</a>
        </div>
        @else
        <div class="ads-grid">
            @foreach ($ads as $ad)
            <a href="{{ route('advertisements.show', $ad) }}"
                onclick="fetch('{{ route('advertisements.click', $ad) }}', {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}})"
                class="ad-card">
                <div class="ad-card__media">
                    @if($ad->video_path)
                    <video src="{{ $ad->video_url }}" muted loop playsinline class="ad-card__video"
                        onmouseenter="this.play()" onmouseleave="this.pause()"></video>
                    <span class="media-badge media-badge--video">VIDEO</span>
                    @elseif($ad->first_image_url)
                    <img src="{{ $ad->first_image_url }}" alt="{{ $ad->title }}" class="ad-card__img" loading="lazy">
                    @else
                    <div class="ad-card__placeholder">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    @endif
                    <span class="ad-card__type-badge">{{ $ad->listing_type }}</span>
                </div>
                <div class="ad-card__body">
                    <h3 class="ad-card__title">{{ Str::limit($ad->title, 60) }}</h3>
                    @if($ad->location)
                    <p class="ad-card__loc">{{ $ad->location }}</p>
                    @endif
                    @if($ad->price_amount)
                    <p class="ad-card__price">{{ number_format($ad->price_amount) }} {{ $ad->currency }}</p>
                    @endif
                    <p class="ad-card__desc">{{ Str::limit($ad->description, 80) }}</p>
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-6">{{ $ads->withQueryString()->links() }}</div>
        @endif

        {{-- CTA to advertise --}}
        <div class="ads-cta">
            <div class="ads-cta__inner">
                <h3>Have a property to advertise?</h3>
                <p>Reach thousands of buyers — choose a package and go live today.</p>
                <a href="{{ route('advertisements.packages') }}" class="btn btn-white">View Packages</a>
            </div>
        </div>
    </div>
</section>
@endsection



