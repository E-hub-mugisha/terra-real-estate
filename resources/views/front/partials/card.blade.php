{{-- Listing card. Expects $item from App\Support\Listing --}}
@php
    $fallback = asset('front/assets/img/all-images/' . match ($item['kind']) {
        'land' => 'hero/plot.png',
        'design' => 'properties/property-img26.png',
        default => 'properties/property-img1.png',
    });
    $metaIcons = ['beds' => 'bed', 'baths' => 'bath', 'area' => 'area', 'zoning' => 'tag', 'format' => 'file', 'downloads' => 'download'];
@endphp
<article class="tu-card"
    data-kind="{{ $item['kind'] }}"
    data-condition="{{ $item['condition'] }}"
    data-price="{{ $item['price'] }}"
    data-beds="{{ $item['bedrooms'] }}"
    data-created="{{ $item['created'] }}"
    data-featured="{{ $item['featured'] ? 1 : 0 }}"
    @if (!empty($item['lat']) && !empty($item['lng'])) data-lat="{{ $item['lat'] }}" data-lng="{{ $item['lng'] }}" data-title="{{ $item['title'] }}" data-url="{{ $item['url'] }}" data-price-label="{{ \App\Support\Listing::price($item) }}{{ $item['price'] > 0 ? ' ' . $item['currency'] : '' }}" data-image="{{ $item['image'] }}" @endif
    data-search="{{ \Illuminate\Support\Str::lower($item['title'] . ' ' . $item['location'] . ' ' . $item['province'] . ' ' . $item['kind_label']) }}">
    <div class="tu-card-mediawrap">
    <a href="{{ $item['url'] }}" class="tu-card-media" tabindex="-1" aria-hidden="true">
        <img src="{{ $item['image'] ?: $fallback }}" alt="" loading="lazy"
            onerror="this.onerror=null;this.src='{{ $fallback }}'">
        <div class="tu-card-badges">
            <span class="tu-badge tu-badge-{{ $item['kind'] }}" style="background:#FFFFFF">{{ $item['kind_label'] }}</span>
            @if ($item['kind'] !== 'design')
                <span class="tu-badge tu-badge-solid">{{ $item['condition'] === 'for_rent' ? 'For rent' : 'For sale' }}</span>
            @endif
            @if ($item['featured'])
                <span class="tu-badge tu-badge-featured"><x-tu-icon name="star" size="11" /> Featured</span>
            @elseif ($item['is_new'])
                <span class="tu-badge tu-badge-success" style="background:#FFFFFF">New</span>
            @endif
        </div>
    </a>
    <button type="button" class="tu-card-save" data-save-id="{{ $item['kind'] }}-{{ $item['id'] }}" data-save-title="{{ $item['title'] }}"
        aria-pressed="false" aria-label="Save listing: {{ $item['title'] }}">
        <x-tu-icon name="heart" />
    </button>
    @if ($item['wa'])
        <a href="{{ $item['wa'] }}" class="tu-card-wa" target="_blank" rel="noopener" aria-label="Ask about {{ $item['title'] }} on WhatsApp">
            <x-tu-icon name="whatsapp" />
        </a>
    @endif
    </div>
    <a href="{{ $item['url'] }}" class="tu-card-body">
        <div class="tu-card-price">
            @if (($item['free'] ?? false))
                Free
            @elseif ($item['price'] > 0)
                {{ number_format($item['price']) }}<small>{{ $item['currency'] }}</small>
                @if ($item['condition'] === 'for_rent')<span class="tu-per">/ month</span>@endif
            @else
                <span style="font-size:.95rem">Price on request</span>
            @endif
        </div>
        <h3 class="tu-card-title">{{ $item['title'] }}</h3>
        <div class="tu-card-loc"><x-tu-icon :name="$item['kind'] === 'design' ? 'ruler' : 'pin'" /> {{ $item['location'] }}</div>
        @if (count($item['meta']))
            <div class="tu-card-meta">
                @foreach ($item['meta'] as $key => $value)
                    <span><x-tu-icon :name="$metaIcons[$key] ?? 'tag'" /> {{ $value }}</span>
                @endforeach
            </div>
        @endif
    </a>
</article>
