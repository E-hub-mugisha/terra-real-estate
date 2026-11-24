{{-- Thumbnail + title + type for any listing (house / land / design). Expects $listing (nullable); optional $sub, $link (true = public page) --}}
@if ($listing)
    @php $kindLabel = \App\Support\ListingRef::label($listing); @endphp
    <a href="{{ ($link ?? true) ? $listing->publicUrl() : \App\Support\ListingRef::showUrl($listing) }}" class="tp-listing-cell" @if ($link ?? true) target="_blank" rel="noopener" @endif>
        <img src="{{ $listing->thumbUrl() }}" alt="" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('front/assets/img/all-images/properties/property-img1.png') }}'">
        <span style="min-width:0">
            <strong>{{ $listing->title ?: $kindLabel }}</strong>
            <span>{{ $sub ?? $kindLabel . ' · ' . ($listing->district ?? $listing->province ?? optional($listing->category ?? null)->name ?? 'Terra') }}</span>
        </span>
    </a>
@else
    <span class="tp-listing-cell"><span class="tu-badge">Listing removed</span></span>
@endif
