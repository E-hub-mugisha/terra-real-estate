@extends('layouts.ai-search')

@section('title', 'AI Search — Terra')

@section('content')
<style>
    .ai-page {
        --nav-h: 68px;
        background: var(--ai-bg);
        font-family: 'DM Sans', sans-serif;
        min-height: calc(100vh - var(--nav-h));
        display: flex;
    }

    /* ══════════════════════════════════════
       LEFT — Assistant panel
    ══════════════════════════════════════ */
    .ai-panel {
        width: 380px;
        flex-shrink: 0;
        background: var(--ai-surface);
        border-right: 1px solid var(--ai-border);
        display: flex;
        flex-direction: column;
        height: calc(100vh - var(--nav-h));
        position: sticky;
        top: var(--nav-h);
    }

    .ai-panel-head {
        padding: 24px 22px 18px;
        border-bottom: 1px solid var(--ai-border);
    }

    .ai-brand-sub {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: 'DM Mono', monospace;
        font-size: .68rem;
        font-weight: 500;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--ai-orange);
        margin-bottom: 10px;
    }

    .ai-brand-sub::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--ai-orange);
        flex-shrink: 0;
    }

    .ai-panel-instructions {
        font-size: .82rem;
        color: var(--ai-text-soft);
        line-height: 1.55;
        margin: 0 0 12px;
    }

    /* Signature element: a small strip of language pills showing the
       assistant reads more than one language. Real information (these are
       the languages it actually understands), not decoration. */
    .ai-lang-strip {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .ai-lang-pill {
        font-family: 'DM Mono', monospace;
        font-size: .66rem;
        font-weight: 500;
        letter-spacing: .03em;
        padding: 3px 9px;
        border-radius: 20px;
        border: 1px solid var(--ai-border);
        color: var(--ai-text-soft);
        background: var(--ai-bg);
    }

    /* Scrollable middle: example chips + transcript */
    .ai-panel-body {
        flex: 1;
        overflow-y: auto;
        padding: 18px 22px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .ai-examples-label {
        font-family: 'DM Mono', monospace;
        font-size: .66rem;
        font-weight: 500;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--ai-text-soft);
        margin: 4px 0 4px;
    }

    .ai-chip {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        text-align: left;
        padding: 11px 14px;
        border-radius: 11px;
        border: 1px solid var(--ai-border);
        background: var(--ai-bg);
        color: var(--ai-text);
        font-size: .8rem;
        font-weight: 500;
        cursor: pointer;
        transition: border-color .15s ease, color .15s ease, background .15s ease, transform .15s ease;
    }

    .ai-chip:hover,
    .ai-chip:focus-visible {
        border-color: var(--ai-orange);
        color: var(--ai-orange);
        background: rgba(208, 82, 8, .06);
        transform: translateX(2px);
    }

    .ai-chip:focus-visible {
        outline: 2px solid var(--ai-orange);
        outline-offset: 2px;
    }

    .ai-chip-lang {
        flex-shrink: 0;
        font-family: 'DM Mono', monospace;
        font-size: .62rem;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: var(--ai-text-soft);
        border: 1px solid var(--ai-border);
        border-radius: 6px;
        padding: 1px 5px;
    }

    .ai-chip:hover .ai-chip-lang,
    .ai-chip:focus-visible .ai-chip-lang {
        color: var(--ai-orange);
        border-color: rgba(208, 82, 8, .35);
    }

    /* Transcript entries (query asked + short AI response) */
    .ai-turn {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-top: 4px;
        animation: aiTurnIn .25s ease both;
    }

    @keyframes aiTurnIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .ai-msg-user {
        align-self: flex-end;
        max-width: 92%;
        background: var(--ai-orange);
        color: #fff;
        padding: 10px 13px;
        border-radius: 14px 14px 3px 14px;
        font-size: .84rem;
        line-height: 1.4;
    }

    .ai-msg-ai {
        display: flex;
        gap: 8px;
        max-width: 100%;
    }

    .ai-msg-ai-avatar {
        flex-shrink: 0;
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--ai-navy), #2a3a82);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'DM Mono', monospace;
        font-size: .62rem;
        font-weight: 500;
        letter-spacing: .02em;
    }

    .ai-msg-ai-col {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .ai-msg-ai-body {
        background: var(--ai-bg);
        border: 1px solid var(--ai-border);
        border-radius: 3px 12px 12px 12px;
        padding: 10px 12px;
        font-size: .8rem;
        color: var(--ai-text);
        line-height: 1.45;
    }

    .ai-msg-ai-body strong { color: var(--ai-orange); }

    /* Tiny "understood in <language>" tag under the AI's reply — the
       signature element made visible per-turn, not just once. */
    .ai-msg-ai-lang {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-family: 'DM Mono', monospace;
        font-size: .64rem;
        font-weight: 500;
        letter-spacing: .02em;
        color: var(--ai-text-soft);
        padding-left: 2px;
    }

    .ai-msg-ai-lang::before {
        content: '';
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: var(--ai-orange);
        flex-shrink: 0;
    }

    /* Typing indicator */
    .ai-typing {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 2px 0;
    }

    .ai-typing span {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--ai-text-soft);
        animation: aiTypingBounce 1.2s infinite ease-in-out;
    }

    .ai-typing span:nth-child(2) { animation-delay: .15s; }
    .ai-typing span:nth-child(3) { animation-delay: .3s; }

    @keyframes aiTypingBounce {
        0%, 60%, 100% { transform: translateY(0); opacity: .4; }
        30% { transform: translateY(-3px); opacity: 1; }
    }

    /* Input bar pinned to bottom of panel */
    .ai-search-box {
        flex-shrink: 0;
        border-top: 1px solid var(--ai-border);
        padding: 14px 22px 18px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .ai-search-field {
        background: var(--ai-bg);
        border: 1.5px solid var(--ai-border);
        border-radius: 14px;
        padding: 10px 12px;
        display: flex;
        align-items: flex-end;
        gap: 8px;
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    .ai-search-field:focus-within {
        border-color: var(--ai-orange);
        box-shadow: 0 0 0 3px rgba(208, 82, 8, .1);
    }

    .ai-search-field textarea {
        flex: 1;
        border: none;
        outline: none;
        resize: none;
        background: transparent;
        font-family: 'DM Sans', sans-serif;
        font-size: .86rem;
        color: var(--ai-text);
        max-height: 100px;
        min-height: 22px;
    }

    .ai-search-field textarea::placeholder { color: var(--ai-text-soft); }

    .ai-search-submit {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 42px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, var(--ai-orange), var(--ai-gold));
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: .84rem;
        font-weight: 700;
        letter-spacing: .01em;
        cursor: pointer;
        transition: filter .15s ease, transform .15s ease;
    }

    .ai-search-submit:hover { filter: brightness(.94); }
    .ai-search-submit:active { transform: scale(.99); }
    .ai-search-submit:disabled { opacity: .55; cursor: default; filter: none; transform: none; }
    .ai-search-submit:focus-visible {
        outline: 2px solid var(--ai-navy);
        outline-offset: 2px;
    }

    /* ══════════════════════════════════════
       RIGHT — Live matched feed
    ══════════════════════════════════════ */
    .ai-feed {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .ai-feed-head {
        position: sticky;
        top: var(--nav-h);
        z-index: 2;
        background: var(--ai-bg);
        padding: 22px 28px 16px;
        border-bottom: 1px solid var(--ai-border);
    }

    .ai-feed-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .ai-feed-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Syne', sans-serif;
        font-size: 1.15rem;
        color: var(--ai-text);
    }

    .ai-feed-count {
        font-family: 'DM Mono', monospace;
        font-size: .72rem;
        font-weight: 500;
        padding: 2px 10px;
        border-radius: 20px;
        background: var(--ai-border);
        color: var(--ai-text);
    }

    /* Feed-level "understood in <language>" badge — appears once a query
       has run, tucked next to the title instead of competing with it. */
    .ai-feed-lang-badge {
        display: none;
        align-items: center;
        gap: 6px;
        font-family: 'DM Mono', monospace;
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: .03em;
        text-transform: uppercase;
        color: var(--ai-orange);
        background: rgba(208, 82, 8, .1);
        border-radius: 20px;
        padding: 4px 11px;
    }

    .ai-feed-lang-badge.is-visible { display: inline-flex; }

    .ai-feed-sub {
        font-size: .8rem;
        color: var(--ai-text-soft);
        margin-top: 4px;
    }

    .ai-live-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #2d8a4e;
        flex-shrink: 0;
        animation: aiLivePulse 1.6s ease-in-out infinite;
    }

    @keyframes aiLivePulse {
        0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(45,138,78,.4); }
        50% { opacity: .6; box-shadow: 0 0 0 4px rgba(45,138,78,0); }
    }

    .ai-feed-body {
        flex: 1;
        padding: 22px 28px 40px;
    }

    /* Empty state before any query */
    .ai-feed-empty {
        height: 100%;
        min-height: 320px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 24px;
    }

    .ai-feed-empty h3 {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Syne', sans-serif;
        font-size: 1rem;
        color: var(--ai-text);
        margin: 0 0 6px;
    }

    .ai-feed-empty h3::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--ai-orange), var(--ai-gold));
        flex-shrink: 0;
    }

    .ai-feed-empty p {
        font-size: .85rem;
        color: var(--ai-text-soft);
        max-width: 340px;
        margin: 0;
        line-height: 1.55;
    }

    /* Sections/grids inside the feed */
    .ai-section {
        margin-bottom: 26px;
        animation: aiSectionIn .3s ease both;
    }
    .ai-section:last-child { margin-bottom: 0; }

    @keyframes aiSectionIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .ai-section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Syne', sans-serif;
        font-size: .95rem;
        color: var(--ai-text);
        margin-bottom: 12px;
    }

    .ai-section-title span {
        font-family: 'DM Mono', monospace;
        background: var(--ai-border);
        color: var(--ai-text);
        font-size: .68rem;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 10px;
    }

    /* Badge on the section the AI thinks is the best-fit match for the query */
    .ai-section-title .ai-primary-badge {
        font-family: 'DM Mono', monospace;
        background: rgba(208, 82, 8, .12);
        color: var(--ai-orange);
        font-size: .64rem;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
        padding: 2px 8px;
        border-radius: 10px;
    }

    .ai-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 14px;
    }

    .ai-card {
        display: block;
        position: relative;
        background: var(--ai-surface);
        border: 1px solid var(--ai-border);
        border-radius: 13px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        transition: box-shadow .18s ease, transform .18s ease, border-color .18s ease;
    }

    .ai-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--ai-orange), var(--ai-gold));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .2s ease;
    }

    .ai-card:hover,
    .ai-card:focus-visible {
        box-shadow: 0 14px 28px rgba(25, 38, 93, .12);
        transform: translateY(-3px);
        border-color: rgba(208, 82, 8, .25);
    }

    .ai-card:focus-visible {
        outline: 2px solid var(--ai-orange);
        outline-offset: 2px;
    }

    .ai-card:hover::before,
    .ai-card:focus-visible::before { transform: scaleX(1); }

    .ai-card-img {
        height: 120px;
        background: var(--ai-border) center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--ai-text-soft);
        font-family: 'Syne', sans-serif;
        font-size: .8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    /* Agents / consultants / professionals: circular avatar or initials,
       centered in the same image slot, instead of a rectangular photo. */
    .ai-card-img--avatar {
        background: var(--ai-bg);
    }

    .ai-avatar-circle {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        display: block;
    }

    .ai-avatar-initials {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--ai-navy), #2a3a82);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'DM Mono', monospace;
        font-weight: 500;
        font-size: .95rem;
        letter-spacing: .02em;
    }

    .ai-card-body { padding: 11px 13px 13px; }

    .ai-card-title {
        font-size: .82rem;
        font-weight: 700;
        color: var(--ai-text);
        margin: 0 0 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .ai-card-meta {
        font-size: .72rem;
        color: var(--ai-text-soft);
        margin: 0 0 7px;
    }

    .ai-card-price {
        font-family: 'DM Mono', monospace;
        font-size: .76rem;
        font-weight: 500;
        color: var(--ai-orange);
    }

    .ai-feed-error {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        text-align: center;
        padding: 40px 24px;
    }

    .ai-feed-error p {
        font-size: .85rem;
        color: var(--ai-text-soft);
        max-width: 320px;
        margin: 0;
        line-height: 1.5;
    }

    .ai-feed-error-retry {
        font-family: 'DM Sans', sans-serif;
        font-size: .8rem;
        font-weight: 700;
        color: #fff;
        background: var(--ai-navy);
        border: none;
        border-radius: 10px;
        padding: 9px 16px;
        cursor: pointer;
    }

    .ai-feed-error-retry:hover { filter: brightness(1.1); }

    /* Respect reduced-motion preference */
    @media (prefers-reduced-motion: reduce) {
        .ai-turn, .ai-section, .ai-live-dot, .ai-typing span {
            animation: none !important;
        }
    }

    /* ── Responsive ── */
    @media (max-width: 880px) {
        .ai-page { flex-direction: column; }

        .ai-panel {
            width: 100%;
            height: auto;
            max-height: 60vh;
            position: relative;
            top: 0;
            border-right: none;
            border-bottom: 1px solid var(--ai-border);
        }

        .ai-feed-head { top: 0; }
    }

    @media (max-width: 640px) {
        .ai-page { --nav-h: 58px; }

        .ai-panel-head { padding: 18px 16px 14px; }
        .ai-panel-body { padding: 14px 16px; }
        .ai-search-box { padding: 12px 16px 14px; }

        .ai-feed-head { padding: 16px 16px 12px; }
        .ai-feed-body { padding: 16px 16px 30px; }

        .ai-feed-title { font-size: 1rem; }

        .ai-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }

        .ai-chip { font-size: .76rem; padding: 9px 11px; }
    }

    @media (max-width: 420px) {
        .ai-grid { grid-template-columns: 1fr 1fr; }
        .ai-msg-user, .ai-msg-ai-body { font-size: .78rem; }
    }
</style>

<div class="ai-page" id="ai-page">

    {{-- ════════════════════════════
         LEFT — Assistant panel
    ════════════════════════════ --}}
    <div class="ai-panel">
        <div class="ai-panel-head">
            <div class="ai-brand-sub">{{ __('Property Assistant') }}</div>
            <p class="ai-panel-instructions">{{ __('Ask in any language, full sentence or a single keyword — a district, "villa", or an agent\'s name.') }}</p>
            <div class="ai-lang-strip" aria-label="{{ __('Languages understood') }}">
                <span class="ai-lang-pill">English</span>
                <span class="ai-lang-pill">Ikinyarwanda</span>
                <span class="ai-lang-pill">Français</span>
                <span class="ai-lang-pill">Kiswahili</span>
            </div>
        </div>

        <div class="ai-panel-body" id="ai-panel-body">
            <div class="ai-examples-label" id="ai-examples-label">{{ __('Try asking') }}</div>
            <button type="button" class="ai-chip" data-q="3 bedroom house for sale in Kacyiru under 80 million RWF">
                <span>3 bedroom house in Kacyiru, under 80M RWF</span>
                <span class="ai-chip-lang">EN</span>
            </button>
            <button type="button" class="ai-chip" data-q="Inzu ifite ibyumba 3 muri Kacyiru munsi ya miliyoni 80">
                <span>Inzu 3 by'ibyumba muri Kacyiru</span>
                <span class="ai-chip-lang">RW</span>
            </button>
            <button type="button" class="ai-chip" data-q="Terrain résidentiel à vendre à Rwamagana moins de 20 millions">
                <span>Terrain résidentiel à Rwamagana</span>
                <span class="ai-chip-lang">FR</span>
            </button>
            <button type="button" class="ai-chip" data-q="Real estate agents in Kigali">
                <span>Real estate agents in Kigali</span>
                <span class="ai-chip-lang">EN</span>
            </button>
            <button type="button" class="ai-chip" data-q="Uburyo bwo gushinga umushinga w'inzu igezweho">
                <span>Ubwubatsi bw'inzu igezweho</span>
                <span class="ai-chip-lang">RW</span>
            </button>
            <button type="button" class="ai-chip" data-q="villa">
                <span>villa</span>
                <span class="ai-chip-lang">EN</span>
            </button>
        </div>

        <form id="ai-search-form" class="ai-search-box">
            <div class="ai-search-field">
                <textarea
                    id="ai-search-input"
                    rows="1"
                    placeholder='{{ __('e.g. "3 bedroom house in Kacyiru under 80M" or "inzu muri Kacyiru"') }}'
                    required></textarea>
            </div>
            <button type="submit" class="ai-search-submit" id="ai-search-btn">
                {{ __('Submit') }}
            </button>
        </form>
    </div>

    {{-- ════════════════════════════
         RIGHT — Live matched feed
    ════════════════════════════ --}}
    <div class="ai-feed">
        <div class="ai-feed-head">
            <div class="ai-feed-title-row">
                <div class="ai-feed-title">
                    <span class="ai-live-dot"></span>
                    {{ __('Live Matched Feed') }}
                    <span class="ai-feed-count" id="ai-feed-count">0</span>
                </div>
                <span class="ai-feed-lang-badge" id="ai-feed-lang-badge"></span>
            </div>
            <p class="ai-feed-sub">{{ __('Real-time listings matching your prompt, across every category') }}</p>
        </div>
        <div class="ai-feed-body" id="ai-feed-body">
            <div class="ai-feed-empty" id="ai-feed-empty">
                <h3>{{ __('No active items in view') }}</h3>
                <p>{{ __('Ask the assistant on the left for houses, land, agents, or listings — in whatever language is easiest — and matching results will appear here dynamically.') }}</p>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
(function () {
    const panelBody   = document.getElementById('ai-panel-body');
    const examplesLbl = document.getElementById('ai-examples-label');
    const form        = document.getElementById('ai-search-form');
    const input       = document.getElementById('ai-search-input');
    const submitBtn   = document.getElementById('ai-search-btn');
    const feedBody    = document.getElementById('ai-feed-body');
    const feedCount   = document.getElementById('ai-feed-count');
    const feedLangBadge = document.getElementById('ai-feed-lang-badge');

    const QUERY_URL = "{{ route('front.ai.search.query') }}";
    const CSRF = "{{ csrf_token() }}";
    const ASSET_BASE = "{{ rtrim(asset('/'), '/') }}";

    // Friendly display names for the languages Claude tells us it detected.
    // Falls back to the raw ISO code (uppercased) for anything not listed here,
    // so a language we didn't anticipate still shows something reasonable.
    const LANGUAGE_NAMES = {
        en: 'English',
        rw: 'Ikinyarwanda',
        fr: 'Français',
        sw: 'Kiswahili',
    };

    function languageLabel(code) {
        if (!code) return null;
        const key = String(code).trim().toLowerCase();
        return LANGUAGE_NAMES[key] || key.toUpperCase();
    }

    // Each result type stores its image differently and under a different
    // public path — mirrors the folder/disk layout used on the main search
    // results page, so the same record resolves to the same image here.
    const IMAGE_RESOLVERS = {
        houses: (item) => {
            const first = item.images && item.images.length ? item.images[0] : null;
            const path = first ? (first.image_path || first.path) : null;
            return path ? `${ASSET_BASE}/image/houses/${path}` : null;
        },
        lands: (item) => {
            const first = item.images && item.images.length ? item.images[0] : null;
            const path = first ? (first.image_path || first.path) : null;
            return path ? `${ASSET_BASE}/image/lands/${path}` : null;
        },
        architectural_designs: (item) => {
            return item.preview_image ? `${ASSET_BASE}/${item.preview_image}` : null;
        },
        agents: (item) => {
            return item.profile_image ? `${ASSET_BASE}/storage/${item.profile_image}` : null;
        },
        consultants: (item) => {
            return item.photo ? `${ASSET_BASE}/storage/${item.photo}` : null;
        },
        professionals: (item) => {
            return item.photo ? `${ASSET_BASE}/storage/${item.photo}` : null;
        },
        news: (item) => {
            return item.featured_image ? `${ASSET_BASE}/storage/${item.featured_image}` : null;
        },
        jobs: (item) => {
            return item.company_logo ? `${ASSET_BASE}/storage/${item.company_logo}` : null;
        },
        advertisements: (item) => {
            const imgs = Array.isArray(item.images) ? item.images : [];
            const thumb = imgs[0];
            return thumb ? `${ASSET_BASE}/storage/${thumb}` : null;
        },
        // announcements and tenders show icon-only rows on the main search
        // page too — no thumbnail field to resolve.
    };

    // Route templates, one per result type, so every card links somewhere real.
    // Passed positionally (not as a named ['param' => ...] array) so this doesn't
    // depend on what the route's parameter is actually called (e.g. front.buy.home.details
    // expects {home}, not {id}) — a placeholder string is swapped in client-side per item.
    const ROUTE_TEMPLATES = {
        houses:                "{{ route('front.buy.home.details', ':id') }}",
        lands:                 "{{ route('front.buy.land.details', ':id') }}",
        architectural_designs: "{{ route('front.buy.design.purchase', ':slug') }}",
        agents:                "{{ route('front.agent.details', ':id') }}",
        consultants:           "{{ route('front.consultant.details', ':id') }}",
        professionals:         "{{ route('front.professional.details', ':id') }}",
        news:                  "{{ route('front.news.details', ':slug') }}",
        announcements:         "{{ route('front.announcements.show', ':slug') }}",
        jobs:                  "{{ route('front.jobs.show', ':slug') }}",
        tenders:               "{{ route('front.tenders.details', ':slug') }}",
    };

    const ADVERTISEMENTS_FALLBACK_URL = "{{ route('advertisements.index') }}";

    const SECTIONS = {
        houses:                { label: '{{ __('Houses') }}' },
        lands:                 { label: '{{ __('Land') }}' },
        architectural_designs: { label: '{{ __('Architectural Designs') }}' },
        agents:                { label: '{{ __('Agents') }}' },
        consultants:           { label: '{{ __('Consultants') }}' },
        professionals:         { label: '{{ __('Professionals') }}' },
        news:                  { label: '{{ __('News') }}' },
        announcements:         { label: '{{ __('Announcements') }}' },
        tenders:               { label: '{{ __('Tenders') }}' },
        jobs:                  { label: '{{ __('Jobs') }}' },
        advertisements:        { label: '{{ __('Advertisements') }}' },
    };

    let turnCounter = 0;

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str ?? '';
        return div.innerHTML;
    }

    function firstImage(key, item) {
        const resolve = IMAGE_RESOLVERS[key];
        return resolve ? resolve(item) : null;
    }

    function initials(name) {
        const parts = (name || '').trim().split(/\s+/).filter(Boolean);
        if (!parts.length) return '?';
        return (parts[0][0] + (parts[1] ? parts[1][0] : '')).toUpperCase();
    }

    function money(v) {
        if (v === null || v === undefined || v === '') return null;
        const n = Number(v);
        if (Number.isNaN(n)) return null;
        return 'RWF ' + n.toLocaleString();
    }

    function location(item) {
        return [item.sector, item.district, item.province].filter(Boolean).join(', ');
    }

    // Builds a real, clickable destination for a result item. Returns null only
    // if a record is missing the id/slug a route needs — never render a link that
    // silently goes nowhere.
    function urlFor(key, item) {
        if (key === 'advertisements') {
            return item.advertisable_url || ADVERTISEMENTS_FALLBACK_URL;
        }

        const tpl = ROUTE_TEMPLATES[key];
        if (!tpl) return null;

        if (tpl.includes(':slug')) {
            const slug = item.slug || item.id;
            return slug ? tpl.replace(':slug', encodeURIComponent(slug)) : null;
        }

        return item.id ? tpl.replace(':id', encodeURIComponent(item.id)) : null;
    }

    function cardFor(key, item) {
        const img = firstImage(key, item);
        const href = urlFor(key, item);
        const isPerson = ['agents', 'consultants', 'professionals'].includes(key);
        let title, meta, price = null;

        if (['houses', 'lands', 'architectural_designs'].includes(key)) {
            title = item.title;
            meta = location(item) || (item.type || '');
            price = money(item.price);
        } else if (isPerson) {
            title = item.full_name || item.name;
            meta = item.office_location || item.title || location(item);
        } else if (key === 'jobs') {
            title = item.title;
            meta = [item.company_name, item.location].filter(Boolean).join(' • ');
        } else {
            title = item.title;
            meta = item.location || '';
        }

        const tag = href ? 'a' : 'div';
        const hrefAttr = href ? `href="${escapeHtml(href)}"` : '';
        const placeholderLabel = (SECTIONS[key] && SECTIONS[key].label) ? SECTIONS[key].label : '';

        // People cards get a circular avatar (photo or initials); everything
        // else gets a rectangular thumb (photo or the section label).
        const imgBlock = isPerson
            ? `
                <div class="ai-card-img ai-card-img--avatar">
                    ${img
                        ? `<img class="ai-avatar-circle" src="${escapeHtml(img)}" alt="">`
                        : `<div class="ai-avatar-initials">${escapeHtml(initials(title))}</div>`}
                </div>
            `
            : `
                <div class="ai-card-img" ${img ? `style="background-image:url('${escapeHtml(img)}')"` : ''}>
                    ${img ? '' : escapeHtml(placeholderLabel)}
                </div>
            `;

        return `
            <${tag} class="ai-card" ${hrefAttr}>
                ${imgBlock}
                <div class="ai-card-body">
                    <p class="ai-card-title">${escapeHtml(title || 'Untitled')}</p>
                    ${meta ? `<p class="ai-card-meta">${escapeHtml(meta)}</p>` : ''}
                    ${price ? `<p class="ai-card-price">${escapeHtml(price)}</p>` : ''}
                </div>
            </${tag}>
        `;
    }

    // Every category is always searched server-side now (see AiSearchService).
    // Here we just decide DISPLAY ORDER: whichever category the AI thinks is
    // the best fit for the query (data.filters.category) is shown first and
    // gets a "best match" badge — everything else still appears below it,
    // instead of being hidden the way a hard filter would.
    function buildSectionsHtml(data) {
        const results = data.results || {};
        let keysWithData = Object.keys(SECTIONS).filter(k => (results[k] || []).length > 0);

        if (!keysWithData.length) {
            return null;
        }

        const primary = data.filters && data.filters.category;
        if (primary && primary !== 'all' && keysWithData.includes(primary)) {
            keysWithData = [primary, ...keysWithData.filter(k => k !== primary)];
        }

        return keysWithData.map(key => {
            const items = results[key];
            const isPrimary = key === primary;
            return `
                <div class="ai-section">
                    <div class="ai-section-title">
                        ${SECTIONS[key].label}
                        <span>${items.length}</span>
                        ${isPrimary ? `<span class="ai-primary-badge">{{ __('Best match') }}</span>` : ''}
                    </div>
                    <div class="ai-grid">
                        ${items.map(item => cardFor(key, item)).join('')}
                    </div>
                </div>
            `;
        }).join('');
    }

    function scrollPanelToBottom() {
        panelBody.scrollTop = panelBody.scrollHeight;
    }

    // Appends the user's query + a "thinking" AI bubble to the left transcript.
    function appendTranscriptTurn(query) {
        turnCounter += 1;
        const turnId = 'turn-' + turnCounter;

        if (examplesLbl) examplesLbl.style.display = 'none';
        document.querySelectorAll('.ai-panel-body > .ai-chip').forEach(chip => chip.style.display = 'none');

        const turnEl = document.createElement('div');
        turnEl.className = 'ai-turn';
        turnEl.id = turnId;
        turnEl.innerHTML = `
            <div class="ai-msg-user">${escapeHtml(query)}</div>
            <div class="ai-msg-ai">
                <div class="ai-msg-ai-avatar">AI</div>
                <div class="ai-msg-ai-col">
                    <div class="ai-msg-ai-body" id="${turnId}-body">
                        <div class="ai-typing"><span></span><span></span><span></span></div>
                    </div>
                    <span class="ai-msg-ai-lang" id="${turnId}-lang" style="display:none"></span>
                </div>
            </div>
        `;

        panelBody.appendChild(turnEl);
        scrollPanelToBottom();

        return turnId;
    }

    function renderFeedLangBadge(code) {
        const label = languageLabel(code);
        if (!label) {
            feedLangBadge.classList.remove('is-visible');
            feedLangBadge.textContent = '';
            return;
        }
        feedLangBadge.textContent = '{{ __('Understood in') }}: ' + label;
        feedLangBadge.classList.add('is-visible');
    }

    function runSearch(q) {
        const turnId = appendTranscriptTurn(q);
        submitBtn.disabled = true;

        // Reset the feed to a live "searching" state.
        feedBody.innerHTML = `<div class="ai-feed-empty"><div class="ai-typing"><span></span><span></span><span></span></div></div>`;

        fetch(QUERY_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF,
            },
            body: JSON.stringify({ q }),
        })
            .then(r => {
                if (!r.ok) throw new Error('Request failed: ' + r.status);
                return r.json();
            })
            .then(data => {
                const total = data.total ?? 0;
                const bodyEl = document.getElementById(turnId + '-body');
                const langEl = document.getElementById(turnId + '-lang');

                if (bodyEl) {
                    bodyEl.innerHTML = `${escapeHtml(data.summary || '')} — <strong>${total} {{ __('result') }}${total === 1 ? '' : 's'}</strong>`;
                }

                const detectedLabel = data.filters ? languageLabel(data.filters.detected_language) : null;
                if (langEl) {
                    if (detectedLabel) {
                        langEl.textContent = '{{ __('Understood in') }} ' + detectedLabel;
                        langEl.style.display = 'inline-flex';
                    } else {
                        langEl.style.display = 'none';
                    }
                }
                renderFeedLangBadge(data.filters && data.filters.detected_language);

                feedCount.textContent = total;

                const sectionsHtml = buildSectionsHtml(data);
                feedBody.innerHTML = sectionsHtml || `
                    <div class="ai-feed-empty">
                        <h3>{{ __('No active items in view') }}</h3>
                        <p>{{ __('No matches yet — try rephrasing, or broaden your query (drop the price or location).') }}</p>
                    </div>
                `;

                scrollPanelToBottom();
            })
            .catch(() => {
                const bodyEl = document.getElementById(turnId + '-body');
                if (bodyEl) {
                    bodyEl.innerHTML = `{{ __('Search didn\'t go through. Try again.') }}`;
                }
                feedBody.innerHTML = `
                    <div class="ai-feed-error">
                        <p>{{ __('Search didn\'t go through — the connection to AI search dropped.') }}</p>
                        <button type="button" class="ai-feed-error-retry" id="ai-feed-retry-btn">{{ __('Try again') }}</button>
                    </div>
                `;
                const retryBtn = document.getElementById('ai-feed-retry-btn');
                if (retryBtn) {
                    retryBtn.addEventListener('click', () => runSearch(q));
                }
            })
            .finally(() => {
                submitBtn.disabled = false;
            });
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const q = input.value.trim();
        if (!q) return;
        input.value = '';
        input.style.height = 'auto';
        runSearch(q);
    });

    document.querySelectorAll('.ai-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            runSearch(chip.dataset.q);
        });
    });

    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 100) + 'px';
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            form.requestSubmit();
        }
    });

    // If the page was loaded with ?q=... (like the reference implementation),
    // run that search automatically on load.
    const params = new URLSearchParams(window.location.search);
    const initialQ = params.get('q');
    if (initialQ) {
        input.value = '';
        runSearch(initialQ);
    }
})();
</script>
@endpush
@endsection