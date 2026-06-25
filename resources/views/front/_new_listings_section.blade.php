{{--
    ══════════════════════════════════════════════════════════════════════
    NEW LISTINGS SECTION — Terra Real Estate
    Include in welcome.blade.php after the hero / before services:

        @include('front.partials._new_listings_section')

    Requires: $newHouses, $newLands, $newDesigns passed from HomeController
    ══════════════════════════════════════════════════════════════════════
--}}

<style>
    /* ══════════════════════════════════════
   NEW LISTINGS — shared tokens
══════════════════════════════════════ */
    .nl-section {
        background: var(--bg);
        padding: 80px 0 90px;
        position: relative;
        overflow: hidden;
    }

    /* Subtle background pattern */
    .nl-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 59px, rgba(25, 38, 93, .03) 59px, rgba(25, 38, 93, .03) 60px),
            repeating-linear-gradient(90deg, transparent, transparent 59px, rgba(25, 38, 93, .03) 59px, rgba(25, 38, 93, .03) 60px);
        pointer-events: none;
    }

    /* ── Section header ── */
    .nl-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 48px;
        position: relative;
    }

    .nl-view-all {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .8rem;
        font-weight: 500;
        color: var(--gold);
        border-bottom: 1px solid var(--gold-bd);
        padding-bottom: 2px;
        transition: gap var(--t), border-color var(--t);
        flex-shrink: 0;
    }

    .nl-view-all:hover {
        gap: 10px;
        border-color: var(--gold);
        color: var(--gold);
    }

    .nl-view-all svg {
        width: 13px;
        height: 13px;
    }

    /* ── Category tabs ── */
    .nl-tabs {
        display: flex;
        gap: 6px;
        margin-bottom: 32px;
        flex-wrap: wrap;
        position: relative;
    }

    .nl-tab {
        padding: 7px 18px;
        border-radius: 6px;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
        border: 1.5px solid var(--border);
        background: var(--surface);
        color: var(--muted);
        cursor: pointer;
        transition: all var(--t);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .nl-tab svg {
        width: 13px;
        height: 13px;
    }

    .nl-tab:hover {
        border-color: var(--gold-bd);
        color: var(--text);
    }

    .nl-tab.active {
        background: var(--dark);
        border-color: var(--dark);
        color: #F0EDE8;
    }

    .nl-tab .nl-tab-count {
        background: rgba(240, 237, 232, .15);
        border-radius: 4px;
        padding: 1px 5px;
        font-size: .68rem;
        color: inherit;
    }

    .nl-tab.active .nl-tab-count {
        background: rgba(208, 82, 8, .35);
    }

    .nl-tab:not(.active) .nl-tab-count {
        background: var(--gold-bg);
        color: var(--gold);
    }

    /* ── Grid panel ── */
    .nl-panel {
        display: none;
    }

    .nl-panel.active {
        display: block;
    }

    .nl-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    /* ── Property card (houses / lands) ── */
    .nl-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        transition: border-color var(--t), box-shadow var(--t), transform var(--t);
        display: block;
        color: inherit;
        position: relative;
    }

    .nl-card:hover {
        border-color: var(--gold-bd);
        box-shadow: 0 12px 32px rgba(0, 0, 0, .09);
        transform: translateY(-4px);
        color: inherit;
    }

    /* Image wrapper */
    .nl-card-img {
        position: relative;
        height: 190px;
        overflow: hidden;
        background: var(--bg);
    }

    .nl-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }

    .nl-card:hover .nl-card-img img {
        transform: scale(1.04);
    }

    /* No-image placeholder */
    .nl-card-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: var(--dim);
    }

    .nl-card-img-placeholder svg {
        width: 32px;
        height: 32px;
        opacity: .4;
    }

    .nl-card-img-placeholder span {
        font-size: .72rem;
        opacity: .5;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    /* Status badge */
    .nl-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 3px 10px;
        border-radius: 5px;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        backdrop-filter: blur(8px);
    }

    .nl-badge-available {
        background: rgba(37, 183, 73, .18);
        color: #1a7a35;
    }

    .nl-badge-reserved {
        background: rgba(240, 153, 0, .18);
        color: #8a5a00;
    }

    .nl-badge-sold {
        background: rgba(200, 50, 50, .18);
        color: #8a2020;
    }

    .nl-badge-free {
        background: rgba(37, 183, 73, .18);
        color: #1a7a35;
    }

    .nl-badge-paid {
        background: rgba(208, 82, 8, .15);
        color: #a34800;
    }

    /* NEW ribbon */
    .nl-new-ribbon {
        position: absolute;
        top: 12px;
        right: 12px;
        background: var(--gold);
        color: #fff;
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        padding: 3px 8px;
        border-radius: 4px;
    }

    /* Category type pill */
    .nl-type-pill {
        position: absolute;
        bottom: 10px;
        left: 12px;
        background: rgba(25, 38, 93, .7);
        backdrop-filter: blur(8px);
        color: rgba(240, 237, 232, .9);
        font-size: .66rem;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        padding: 3px 10px;
        border-radius: 4px;
        border: 1px solid rgba(255, 255, 255, .12);
    }

    /* Card body */
    .nl-card-body {
        padding: 16px 18px 20px;
    }

    .nl-card-loc {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .73rem;
        color: var(--muted);
        margin-bottom: 7px;
    }

    .nl-card-loc svg {
        width: 12px;
        height: 12px;
        color: var(--gold);
        flex-shrink: 0;
    }

    .nl-card-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.08rem;
        font-weight: 600;
        color: var(--text);
        line-height: 1.3;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .nl-card-price {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gold);
        margin-bottom: 12px;
    }

    .nl-card-price span {
        font-family: 'DM Sans', sans-serif;
        font-size: .75rem;
        color: var(--muted);
        font-weight: 400;
        margin-left: 3px;
    }

    /* Meta chips */
    .nl-card-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 12px;
        border-top: 1px solid var(--border);
    }

    .nl-meta-chip {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .72rem;
        color: var(--muted);
    }

    .nl-meta-chip svg {
        width: 13px;
        height: 13px;
        color: var(--dim);
    }

    /* ── Design card ── */
    .nl-design-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        transition: border-color var(--t), box-shadow var(--t), transform var(--t);
        display: block;
        color: inherit;
    }

    .nl-design-card:hover {
        border-color: var(--gold-bd);
        box-shadow: 0 12px 32px rgba(0, 0, 0, .09);
        transform: translateY(-4px);
        color: inherit;
    }

    .nl-design-img {
        position: relative;
        height: 190px;
        overflow: hidden;
        background: var(--bg);
    }

    .nl-design-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }

    .nl-design-card:hover .nl-design-img img {
        transform: scale(1.04);
    }

    .nl-design-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: linear-gradient(135deg, rgba(25, 38, 93, .06), rgba(208, 82, 8, .06));
        color: var(--dim);
    }

    .nl-design-img-placeholder svg {
        width: 32px;
        height: 32px;
        opacity: .4;
    }

    .nl-design-img-placeholder span {
        font-size: .72rem;
        opacity: .5;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .nl-design-body {
        padding: 16px 18px 20px;
    }

    .nl-design-cat {
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 6px;
    }

    .nl-design-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.08rem;
        font-weight: 600;
        color: var(--text);
        line-height: 1.3;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .nl-design-price-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        padding-top: 12px;
        border-top: 1px solid var(--border);
    }

    .nl-design-price {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--gold);
    }

    .nl-design-dl {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .72rem;
        color: var(--muted);
    }

    .nl-design-dl svg {
        width: 13px;
        height: 13px;
    }

    .nl-design-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .75rem;
        font-weight: 600;
        color: var(--gold);
        margin-top: 10px;
        transition: gap var(--t);
    }

    .nl-design-card:hover .nl-design-action {
        gap: 9px;
    }

    .nl-design-action svg {
        width: 12px;
        height: 12px;
    }

    /* ── Empty state ── */
    .nl-empty {
        grid-column: 1 / -1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 56px 24px;
        gap: 12px;
        color: var(--dim);
        text-align: center;
    }

    .nl-empty svg {
        width: 44px;
        height: 44px;
        opacity: .3;
    }

    .nl-empty p {
        font-size: .85rem;
        max-width: 280px;
        line-height: 1.6;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .nl-section {
            padding: 60px 0 70px;
        }

        .nl-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .nl-grid {
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
    }

    @media (max-width: 540px) {
        .nl-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

{{-- ══════════════════════════════════════════
     NEW LISTINGS SECTION
══════════════════════════════════════════ --}}
<section class="nl-section" id="new-listings">
    <div class="container-xl" style="position:relative;">

        {{-- Header --}}
        <div class="nl-header">
            <div>
                <div class="eyebrow">Just Added</div>
                <h2 class="section-title">Latest <span style="color: #D05208;">listings</span> on Terra</h2>
                <p class="section-sub">Freshly posted properties, plots, and designs — reviewed and approved.</p>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="nl-tabs" role="tablist">
            {{-- Houses --}}
            <button class="nl-tab active" role="tab" data-panel="nl-panel-houses" aria-selected="true">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                </svg>
                Houses
                <span class="nl-tab-count">{{ $newHouses->count() }}</span>
            </button>

            {{-- Lands --}}
            <button class="nl-tab" role="tab" data-panel="nl-panel-lands" aria-selected="false">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z" />
                </svg>
                Land / Plots
                <span class="nl-tab-count">{{ $newLands->count() }}</span>
            </button>

            {{-- Designs --}}
            <button class="nl-tab" role="tab" data-panel="nl-panel-designs" aria-selected="false">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z" />
                </svg>
                Designs
                <span class="nl-tab-count">{{ $newDesigns->count() }}</span>
            </button>
        </div>

        {{-- ═══ Panel: Houses ═══ --}}
        <div class="nl-panel active" id="nl-panel-houses" role="tabpanel">
            <div class="nl-grid">
                @forelse($newHouses as $house)
                <a href="{{ route('front.buy.home.details', $house) }}" class="nl-card">
                    <div class="nl-card-img">
                        @if($house->images && $house->images->first())
                        <img src="{{ asset('image/houses/' . $house->images->first()->image_path) }}"
                            alt="{{ $house->title }}"
                            loading="lazy">
                        @else
                        <div class="nl-card-img-placeholder">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                            <span>No image</span>
                        </div>
                        @endif

                        {{-- Status badge --}}
                        <span class="nl-badge nl-badge-{{ $house->status }}">
                            {{ ucfirst($house->status) }}
                        </span>

                        {{-- NEW ribbon for listings added within 7 days --}}
                        @if($house->created_at->diffInDays(now()) <= 7)
                            <span class="nl-new-ribbon">New</span>
                            @endif

                            {{-- Type pill --}}
                            <span class="nl-type-pill">{{ $house->type }}</span>
                    </div>

                    <div class="nl-card-body">
                        <div class="nl-card-loc">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg>
                            {{ $house->district ?? $house->province }}
                        </div>

                        <div class="nl-card-title">{{ $house->title }}</div>

                        <div class="nl-card-price">
                            {{ $house->currency }} {{ number_format($house->price, 0) }}
                            @if(strtolower($house->condition) === 'for_rent')
                            <span>/ mo</span>
                            @endif
                        </div>

                        <div class="nl-card-meta">
                            {{-- Bedrooms --}}
                            <span class="nl-meta-chip">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M7 13c1.66 0 3-1.34 3-3S8.66 7 7 7s-3 1.34-3 3 1.34 3 3 3zm12-6h-8v7H3V5H1v15h2v-3h18v3h2v-9c0-2.21-1.79-4-4-4z" />
                                </svg>
                                {{ $house->bedrooms }} bed
                            </span>

                            {{-- Bathrooms --}}
                            <span class="nl-meta-chip">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M7 5.5C7 4.12 8.12 3 9.5 3S12 4.12 12 5.5V7H7V5.5zM21 12h-2V7c0-2.21-1.79-4-4-4h-1.18C13.28 1.84 11.5 1 9.5 1 7.01 1 5 3.01 5 5.5V12H2c-.55 0-1 .45-1 1s.45 1 1 1h1l1 7h16l1-7h1c.55 0 1-.45 1-1s-.45-1-1-1z" />
                                </svg>
                                {{ $house->bathrooms }} bath
                            </span>

                            {{-- Area --}}
                            <span class="nl-meta-chip">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 6H3c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-9 8c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z" />
                                </svg>
                                {{ number_format($house->area_sqft) }} sqft
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="nl-empty">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>
                    <p>No houses listed yet. Check back soon.</p>
                </div>
                @endforelse
            </div>

            @if($newHouses->count() > 0)
            <div style="text-align:center; margin-top:36px;">
                <a href="{{ route('front.buy.homes') }}" class="nl-view-all" style="font-size:.85rem; padding-bottom:3px;">
                    View all properties
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            @endif
        </div>

        {{-- ═══ Panel: Lands ═══ --}}
        <div class="nl-panel" id="nl-panel-lands" role="tabpanel">
            <div class="nl-grid">
                @forelse($newLands as $land)
                <a href="{{ route('front.buy.land.details', $land->id) }}" class="nl-card">
                    <div class="nl-card-img">
                        @if($land->images && $land->images->first())
                        <img src="{{ asset('image/lands/' . $land->images->first()->image_path) }}"
                            alt="{{ $land->title }}"
                            loading="lazy">
                        @else
                        <div class="nl-card-img-placeholder">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z" />
                            </svg>
                            <span>No image</span>
                        </div>
                        @endif

                        <span class="nl-badge nl-badge-{{ $land->status }}">
                            {{ ucfirst($land->status) }}
                        </span>

                        @if($land->created_at->diffInDays(now()) <= 7)
                            <span class="nl-new-ribbon">New</span>
                            @endif

                            <span class="nl-type-pill">{{ $land->zoning }} · {{ $land->land_use ?? 'Land' }}</span>
                    </div>

                    <div class="nl-card-body">
                        <div class="nl-card-loc">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg>
                            {{ $land->district }}, {{ $land->province }}
                        </div>

                        <div class="nl-card-title">{{ $land->title }}</div>

                        <div class="nl-card-price">
                            {{ $land->currency }} {{ number_format($land->price, 0) }}
                        </div>

                        <div class="nl-card-meta">
                            {{-- Size --}}
                            <span class="nl-meta-chip">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 6H3c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-9 8c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z" />
                                </svg>
                                {{ number_format($land->size_sqm, 0) }} m²
                            </span>

                            {{-- Title verified --}}
                            @if($land->is_title_verified)
                            <span class="nl-meta-chip" style="color: #1a7a35;">
                                <svg viewBox="0 0 24 24" fill="currentColor" style="color:#1a7a35;">
                                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z" />
                                </svg>
                                Title verified
                            </span>
                            @endif

                            {{-- UPI --}}
                            @if($land->upi)
                            <span class="nl-meta-chip">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z" />
                                </svg>
                                UPI: {{ $land->upi }}
                            </span>
                            @endif
                        </div>
                    </div>
                </a>
                @empty
                <div class="nl-empty">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z" />
                    </svg>
                    <p>No plots listed yet. Check back soon.</p>
                </div>
                @endforelse
            </div>

            @if($newLands->count() > 0)
            <div style="text-align:center; margin-top:36px;">
                <a href="{{ route('front.buy.lands') }}" class="nl-view-all" style="font-size:.85rem; padding-bottom:3px;">
                    View all plots
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            @endif
        </div>

        {{-- ═══ Panel: Designs ═══ --}}
        <div class="nl-panel" id="nl-panel-designs" role="tabpanel">
            <div class="nl-grid">
                @forelse($newDesigns as $design)
                <a href="{{ route('front.buy.design.purchase', $design->slug) }}" class="nl-design-card">
                    <div class="nl-design-img">
                        @if($design->images && $design->images->first())
                        <img src="{{ asset('image/architectural_designs/images/' . $design->images->first()->image_path) }}"
                            alt="{{ $design->title }}"
                            loading="lazy">
                        @else
                        <div class="nl-design-img-placeholder">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z" />
                            </svg>
                            <span>Preview</span>
                        </div>
                        @endif

                        @if($design->featured)
                        <span class="nl-badge" style="background:rgba(208,82,8,.18);color:#a34800;">Featured</span>
                        @endif

                        @if($design->created_at->diffInDays(now()) <= 7)
                            <span class="nl-new-ribbon">New</span>
                            @endif
                    </div>

                    <div class="nl-design-body">
                        <div class="nl-design-cat">{{ $design->category->name ?? 'Design' }}</div>
                        <div class="nl-design-title">{{ $design->title }}</div>

                        <div class="nl-design-price-row">
                            <div>
                                @if($design->is_free)
                                <span class="nl-badge nl-badge-free" style="position:static;display:inline-block;">Free Download</span>
                                @else
                                <div class="nl-design-price">RWF {{ number_format($design->price, 0) }}</div>
                                @endif
                            </div>
                            <div class="nl-design-dl">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z" />
                                </svg>
                                {{ number_format($design->download_count) }} downloads
                            </div>
                        </div>

                        <div class="nl-design-action">
                            View design
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </a>
                @empty
                <div class="nl-empty">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z" />
                    </svg>
                    <p>No designs uploaded yet. Check back soon.</p>
                </div>
                @endforelse
            </div>

            @if($newDesigns->count() > 0)
            <div style="text-align:center; margin-top:36px;">
                <a href="{{ route('front.buy.design') }}" class="nl-view-all" style="font-size:.85rem; padding-bottom:3px;">
                    View all designs
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            @endif
        </div>

    </div>{{-- /container-xl --}}
</section>

<script>
    (function() {
        const tabs = document.querySelectorAll('.nl-tab');
        const panels = document.querySelectorAll('.nl-panel');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.panel;

                tabs.forEach(t => {
                    t.classList.remove('active');
                    t.setAttribute('aria-selected', 'false');
                });
                panels.forEach(p => p.classList.remove('active'));

                tab.classList.add('active');
                tab.setAttribute('aria-selected', 'true');
                document.getElementById(target).classList.add('active');
            });
        });
    })();
</script>