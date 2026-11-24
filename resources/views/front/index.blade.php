@extends('layouts.guest')
@section('title', 'Houses, land & designs in Rwanda')

@section('content')
@php
    $img = fn ($p) => asset('front/assets/img/all-images/' . $p);
    $categories = [
        ['route' => route('front.buy.homes'),               'title' => 'Houses for sale', 'sub' => 'Homes, villas & apartments', 'count' => $counts['sale_houses'], 'img' => $img('properties/property-img20.png')],
        ['route' => route('front.rent.homes'),               'title' => 'Houses for rent', 'sub' => 'Long & short stays',         'count' => $counts['rent_houses'], 'img' => $img('properties/property-img12.png')],
        ['route' => route('front.buy.lands'),                'title' => 'Land & plots',    'sub' => 'Residential to agricultural', 'count' => $counts['lands'],      'img' => $img('hero/plot.png')],
        ['route' => route('front.properties.architecture'),  'title' => 'House designs',   'sub' => 'Ready-made plans',           'count' => $counts['designs'],     'img' => $img('properties/property-img26.png')],
    ];
    $totalListings = $counts['sale_houses'] + $counts['rent_houses'] + $counts['lands'] + $counts['designs'];
@endphp

{{-- ── Hero & search ─────────────────────────────────────────── --}}
<section class="tu-hero">
    <img class="tu-hero-bg" src="{{ $img('hero/hero2-img1.png') }}" alt="" fetchpriority="high">
    <div class="tu-container tu-hero-grid {{ $heroSlides->isNotEmpty() ? 'has-slider' : '' }}">
        <div class="tu-hero-copy">
        <div class="tu-eyebrow" style="color:#D05208">Rwanda's property marketplace</div>
        <h1 class="tu-h1">Find a home, a plot <em>or the plan</em> to build one.</h1>
        <p class="tu-hero-sub">Browse verified houses, land and architectural designs from trusted agents in every district of Rwanda.</p>

        <div class="tu-hero-tabs" role="tablist" aria-label="What are you looking for?">
            <button type="button" class="tu-hero-tab is-active" data-mode="buy" role="tab" aria-selected="true">Buy</button>
            <button type="button" class="tu-hero-tab" data-mode="rent" role="tab" aria-selected="false">Rent</button>
            <button type="button" class="tu-hero-tab" data-mode="design" role="tab" aria-selected="false">Designs</button>
        </div>

        <form class="tu-search" action="{{ route('front.properties.buy') }}" method="GET" id="tuHeroSearch" role="search">
            <input type="hidden" name="condition" value="for_sale">
            <div class="tu-search-field" style="flex:1.6">
                <label for="heroQ">Location or keyword</label>
                <input id="heroQ" type="search" name="q" placeholder="Kigali, Gasabo, 4-bedroom villa…" autocomplete="off">
            </div>
            <div class="tu-search-field" id="heroKindField">
                <label for="heroKind">Property type</label>
                <select id="heroKind" name="kind">
                    <option value="">Any type</option>
                    <option value="house">House</option>
                    <option value="land">Land</option>
                </select>
            </div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg"><x-tu-icon name="search" /> Search</button>
        </form>

        <div class="tu-quick" aria-label="Popular searches">
            <span>Popular:</span>
            <a href="{{ route('front.properties.buy', ['q' => 'Kigali', 'kind' => 'house']) }}"><x-tu-icon name="home" size="14" /> Houses in Kigali</a>
            <a href="{{ route('front.properties.buy', ['q' => 'Gasabo', 'kind' => 'land']) }}"><x-tu-icon name="land" size="14" /> Plots in Gasabo</a>
            <a href="{{ route('front.rent.apartments') }}"><x-tu-icon name="building" size="14" /> Apartments for rent</a>
            <a href="{{ route('front.properties.architecture') }}"><x-tu-icon name="ruler" size="14" /> House plans</a>
        </div>

        <div class="tu-hero-stats">
            <div class="tu-hero-stat"><strong data-count="{{ $totalListings }}">{{ number_format($totalListings) }}</strong><span>Active listings</span></div>
            <div class="tu-hero-stat"><strong data-count="{{ $counts['agents'] }}">{{ number_format($counts['agents']) }}</strong><span>Verified agents</span></div>
            <div class="tu-hero-stat"><strong data-count="{{ max($districts->count(), 1) }}">{{ max($districts->count(), 1) }}</strong><span>Provinces covered</span></div>
        </div>
        </div>

        @if ($heroSlides->isNotEmpty())
            @include('front.partials.hero-slider', ['slides' => $heroSlides, 'premium' => $heroPremium])
        @endif
    </div>
</section>

{{-- ── Categories ───────────────────────────────────────────── --}}
<section class="tu-section-tight" style="margin-top:-48px;position:relative;z-index:2">
    <div class="tu-container">
        <div class="tu-cats">
            @foreach ($categories as $cat)
                <a href="{{ $cat['route'] }}" class="tu-cat">
                    <img src="{{ $cat['img'] }}" alt="" loading="lazy">
                    <span class="tu-cat-count tu-badge tu-badge-solid">{{ number_format($cat['count']) }} listings</span>
                    <span class="tu-cat-title">{{ $cat['title'] }}</span>
                    <span class="tu-cat-sub">{{ $cat['sub'] }}</span>
                </a>
            @endforeach
        </div>

        <div class="tu-trust" style="margin-top:28px">
            <div><span class="tu-menu-ico"><x-tu-icon name="shield" /></span><span><strong>Verified listings</strong><span>Checked by the Terra team</span></span></div>
            <div><span class="tu-menu-ico"><x-tu-icon name="badge" /></span><span><strong>Trusted agents</strong><span>Every agent is reviewed</span></span></div>
            <div><span class="tu-menu-ico"><x-tu-icon name="whatsapp" /></span><span><strong>Direct contact</strong><span>Chat with agents instantly</span></span></div>
            <div><span class="tu-menu-ico"><x-tu-icon name="tag" /></span><span><strong>Free to browse</strong><span>No fees for buyers</span></span></div>
        </div>
    </div>
</section>

@include('front.partials.sponsored', ['sponsored' => $sponsored, 'spotlight' => $spotlight])

{{-- ── Latest listings ──────────────────────────────────────── --}}
<section class="tu-section">
    <div class="tu-container">
        <div class="tu-section-head">
            <div>
                <div class="tu-eyebrow">Just listed</div>
                <h2 class="tu-h2">New on the market</h2>
                <p class="tu-lead">Fresh houses and plots added by our agents.</p>
            </div>
            <a href="{{ route('front.properties.buy') }}" class="tu-link-arrow">View all listings <x-tu-icon name="arrow-right" /></a>
        </div>
        @if ($latest->isEmpty())
            <div class="tu-empty">
                <div class="tu-empty-ico"><x-tu-icon name="home" /></div>
                <h3>Listings are on their way</h3>
                <p>Our agents are adding new properties. Check back soon or talk to an agent today.</p>
                <a href="{{ route('front.agents') }}" class="tu-btn tu-btn-primary">Find an agent</a>
            </div>
        @else
            <div class="tu-grid">
                @foreach ($latest as $item)
                    @include('front.partials.card', ['item' => $item])
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ── Rentals ──────────────────────────────────────────────── --}}
@if ($rentals->isNotEmpty())
<section class="tu-section" style="background:var(--tu-card);border-block:1px solid var(--tu-line)">
    <div class="tu-container">
        <div class="tu-section-head">
            <div>
                <div class="tu-eyebrow">Rent</div>
                <h2 class="tu-h2">Homes ready to move into</h2>
            </div>
            <a href="{{ route('front.rent.homes') }}" class="tu-link-arrow">All rentals <x-tu-icon name="arrow-right" /></a>
        </div>
        <div class="tu-scroller">
            @foreach ($rentals as $item)
                @include('front.partials.card', ['item' => $item])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── Designs ──────────────────────────────────────────────── --}}
@if ($designs->isNotEmpty())
<section class="tu-section">
    <div class="tu-container">
        <div class="tu-section-head">
            <div>
                <div class="tu-eyebrow">Architectural designs</div>
                <h2 class="tu-h2">Plans to build on your plot</h2>
                <p class="tu-lead">Complete drawing sets from local architects — some free to download.</p>
            </div>
            <a href="{{ route('front.properties.architecture') }}" class="tu-link-arrow">Browse designs <x-tu-icon name="arrow-right" /></a>
        </div>
        <div class="tu-scroller">
            @foreach ($designs as $item)
                @include('front.partials.card', ['item' => $item])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── Locations ────────────────────────────────────────────── --}}
@if ($districts->isNotEmpty())
<section class="tu-section" style="padding-top:0">
    <div class="tu-container">
        <div class="tu-section-head">
            <div>
                <div class="tu-eyebrow">Browse by location</div>
                <h2 class="tu-h2">Where do you want to live?</h2>
            </div>
        </div>
        <div class="tu-areas">
            @foreach ($districts as $province => $total)
                <a href="{{ route('properties.by.province', $province) }}" class="tu-area">
                    <span style="display:flex;align-items:center;gap:10px;color:var(--tu-ink);font-size:.95rem;font-weight:700">
                        <span class="tu-menu-ico" style="width:34px;height:34px"><x-tu-icon name="pin" /></span>{{ $province }}
                    </span>
                    <span>{{ $total }} {{ \Illuminate\Support\Str::plural('listing', $total) }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── How it works ─────────────────────────────────────────── --}}
<section class="tu-section" style="background:var(--tu-card);border-block:1px solid var(--tu-line)">
    <div class="tu-container">
        <div class="tu-section-head">
            <div>
                <div class="tu-eyebrow">How it works</div>
                <h2 class="tu-h2">From first search to your keys</h2>
                <p class="tu-lead">No account needed to browse. Save the listings you like and talk to the agent when you're ready.</p>
            </div>
            <a href="{{ route('front.properties.buy') }}" class="tu-btn tu-btn-dark">Start browsing <x-tu-icon name="arrow-right" /></a>
        </div>
        <div class="tu-steps">
            <div class="tu-step">
                <h3>Search &amp; shortlist</h3>
                <p>Filter houses, plots and designs by area, price and size. Tap the heart to save the ones you like.</p>
            </div>
            <div class="tu-step">
                <h3>Talk to a verified agent</h3>
                <p>Message the listing agent on WhatsApp or send an inquiry — every agent on Terra has been reviewed.</p>
            </div>
            <div class="tu-step">
                <h3>Visit, buy or build</h3>
                <p>Arrange a viewing, agree the deal — or buy the plot and pick a ready-made design to build on it.</p>
            </div>
        </div>
    </div>
</section>

{{-- ── Agents ───────────────────────────────────────────────── --}}
@if ($agents->isNotEmpty())
<section class="tu-section">
    <div class="tu-container">
        <div class="tu-section-head">
            <div>
                <div class="tu-eyebrow">Agents</div>
                <h2 class="tu-h2">Work with a verified agent</h2>
            </div>
            <a href="{{ route('front.agents') }}" class="tu-link-arrow">All agents <x-tu-icon name="arrow-right" /></a>
        </div>
        <div class="tu-grid">
            @foreach ($agents as $agent)
                @include('front.partials.agent-card', ['agent' => $agent])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── CTA ──────────────────────────────────────────────────── --}}
<section class="tu-section" style="padding-top:0">
    <div class="tu-container">
        <div class="tu-cta">
            <div>
                <div class="tu-eyebrow" style="color:#D05208">For agents</div>
                <h2 class="tu-h2">List your properties where buyers are looking.</h2>
                <p>Create a free agent account, add houses, land and designs, and reach buyers across Rwanda.</p>
            </div>
            <div class="tu-cta-actions">
                <a href="{{ route('front.agents.register') }}" class="tu-btn tu-btn-primary tu-btn-lg"><x-tu-icon name="plus" /> Become an agent</a>
                <a href="https://wa.me/{{ \App\Support\Listing::WHATSAPP }}" target="_blank" rel="noopener" class="tu-btn tu-btn-light tu-btn-lg"><x-tu-icon name="whatsapp" /> Talk to us</a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    (function () {
        const form = document.getElementById('tuHeroSearch');
        const condition = form.querySelector('[name=condition]');
        const kindField = document.getElementById('heroKindField');
        const kind = document.getElementById('heroKind');
        const q = document.getElementById('heroQ');
        const targets = {
            buy:    { action: @json(route('front.properties.buy')), condition: 'for_sale', placeholder: 'Kigali, Gasabo, 4-bedroom villa…' },
            rent:   { action: @json(route('front.properties.buy')), condition: 'for_rent', placeholder: 'Kimihurura, apartment, furnished…' },
            design: { action: @json(route('front.properties.architecture')), condition: '', placeholder: 'Bungalow, duplex, 3 bedrooms…' },
        };
        document.querySelectorAll('.tu-hero-tab').forEach(tab => tab.addEventListener('click', () => {
            const mode = tab.dataset.mode;
            document.querySelectorAll('.tu-hero-tab').forEach(t => { t.classList.toggle('is-active', t === tab); t.setAttribute('aria-selected', t === tab); });
            const t = targets[mode];
            form.action = t.action;
            q.placeholder = t.placeholder;
            q.name = mode === 'design' ? 'search' : 'q';
            condition.disabled = !t.condition;
            condition.value = t.condition;
            kindField.style.display = mode === 'design' ? 'none' : '';
            kind.disabled = mode === 'design';
        }));
        form.addEventListener('submit', () => { if (!kind.value) kind.disabled = true; });
    })();
</script>
@endpush
