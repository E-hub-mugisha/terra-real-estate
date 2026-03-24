@extends('layouts.guest')
@section('title', $agent->full_name)
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --surface: #FFFFFF;
        --border: rgba(0, 0, 0, .08);
        --border2: rgba(0, 0, 0, .14);
        --gold: #D05208;
        --gold-bg: rgba(200, 135, 58, .08);
        --gold-bd: rgba(200, 135, 58, .22);
        --text: #19265d;
        --muted: #6B6560;
        --dim: #9E9890;
        --green: #1E7A5A;
        --green-bg: rgba(30, 122, 90, .08);
        --r: 14px;
        --t: .2s cubic-bezier(.4, 0, .2, 1);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    /* ── Hero Banner ── */
    .ad-hero {
        position: relative;
        height: 260px;
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        overflow: hidden;
    }

    .ad-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 70% 60% at 20% 60%, rgba(200, 135, 58, .07) 0%, transparent 65%);
        pointer-events: none;
    }

    .ad-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: repeating-linear-gradient(0deg, transparent, transparent 39px,
                rgba(0, 0, 0, .025) 39px, rgba(0, 0, 0, .025) 40px),
            repeating-linear-gradient(90deg, transparent, transparent 39px,
                rgba(0, 0, 0, .025) 39px, rgba(0, 0, 0, .025) 40px);
    }

    .ad-hero-text {
        position: absolute;
        bottom: 80px;
        left: 0;
        right: 0;
        z-index: 2;
        padding: 0 24px;
    }

    .ad-hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: .68rem;
        font-weight: 500;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 10px;
    }

    .ad-hero-eyebrow::before {
        content: '';
        width: 20px;
        height: 1px;
        background: var(--gold);
        opacity: .6;
    }

    .ad-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.8rem, 4vw, 3rem);
        font-weight: 500;
        color: var(--text);
        line-height: 1.1;
        letter-spacing: -.02em;
        margin: 0;
    }

    .ad-hero h1 em {
        font-style: italic;
        color: var(--gold);
    }

    /* ── Profile Photo (overlapping hero) ── */
    .ad-avatar-wrap {
        position: relative;
        margin-top: -72px;
        display: flex;
        align-items: flex-end;
        gap: 20px;
        padding: 0 0 24px;
    }

    .ad-avatar {
        width: 144px;
        height: 144px;
        border-radius: 50%;
        object-fit: cover;
        object-position: top center;
        border: 5px solid var(--bg);
        box-shadow: 0 8px 28px rgba(0, 0, 0, .10);
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .ad-avatar-meta {
        padding-bottom: 8px;
    }

    .ad-avatar-meta h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 600;
        letter-spacing: -.01em;
        margin: 0 0 4px;
        color: var(--text);
    }

    .ad-avatar-meta p {
        font-size: .82rem;
        color: var(--muted);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .verified-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 20px;
        background: var(--green-bg);
        border: 1px solid rgba(30, 122, 90, .2);
        font-size: .68rem;
        font-weight: 600;
        color: var(--green);
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .verified-badge svg {
        width: 10px;
        height: 10px;
    }

    /* ── Layout ── */
    .ad-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 24px;
        align-items: start;
        padding-bottom: 72px;
    }

    @media (max-width: 900px) {
        .ad-layout {
            grid-template-columns: 1fr;
        }
    }

    /* ── Sidebar ── */
    .ad-sidebar {
        position: sticky;
        top: 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* ── Panels ── */
    .panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
    }

    .panel-head {
        padding: 18px 20px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .panel-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.05rem;
        font-weight: 600;
        letter-spacing: -.01em;
        color: var(--text);
        margin: 0;
    }

    .panel-body {
        padding: 16px 20px 20px;
    }

    .panel-divider {
        height: 1px;
        background: var(--border);
        margin: 0 20px;
    }

    /* ── Stat pills ── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        padding: 16px 20px;
    }

    .stat-pill {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 12px 14px;
        text-align: center;
    }

    .stat-pill .val {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text);
        line-height: 1;
        display: block;
    }

    .stat-pill .lbl {
        font-size: .68rem;
        font-weight: 500;
        color: var(--dim);
        text-transform: uppercase;
        letter-spacing: .06em;
        display: block;
        margin-top: 3px;
    }

    /* ── Meta rows ── */
    .meta-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 0;
        font-size: .82rem;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
    }

    .meta-row:last-child {
        border-bottom: none;
    }

    .meta-row svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
        flex-shrink: 0;
    }

    .meta-row strong {
        color: var(--text);
        font-weight: 500;
    }

    /* ── Contact buttons ── */
    .contact-stack {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding: 16px 20px 20px;
    }

    .c-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: .83rem;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: all var(--t);
        border: none;
        text-decoration: none;
    }

    .c-btn svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
    }

    .c-btn-call {
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        color: var(--gold);
    }

    .c-btn-call:hover {
        background: var(--gold);
        color: #fff;
    }

    .c-btn-wa {
        background: rgba(37, 211, 102, .1);
        border: 1px solid rgba(37, 211, 102, .25);
        color: #128C7E;
    }

    .c-btn-wa:hover {
        background: #25D366;
        color: #fff;
    }

    .c-btn-email {
        background: var(--bg);
        border: 1px solid var(--border2);
        color: var(--text);
    }

    .c-btn-email:hover {
        background: var(--text);
        color: #fff;
    }

    /* ── Social links ── */
    .social-row {
        display: flex;
        gap: 8px;
        padding: 14px 20px;
    }

    .soc-btn {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        border: 1px solid var(--border);
        background: var(--bg);
        display: grid;
        place-items: center;
        font-size: .8rem;
        color: var(--muted);
        transition: all var(--t);
    }

    .soc-btn:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    /* ── Tabs ── */
    .ad-tabs {
        display: flex;
        gap: 2px;
        border-bottom: 1px solid var(--border);
        background: var(--surface);
        border-radius: var(--r) var(--r) 0 0;
        padding: 0 20px;
        overflow-x: auto;
    }

    .ad-tab {
        padding: 14px 16px;
        font-size: .82rem;
        font-weight: 500;
        color: var(--muted);
        border: none;
        background: transparent;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
        white-space: nowrap;
        font-family: 'DM Sans', sans-serif;
        transition: color var(--t), border-color var(--t);
    }

    .ad-tab.on {
        color: var(--gold);
        border-bottom-color: var(--gold);
    }

    .ad-tab:hover {
        color: var(--gold);
    }

    .tab-pane {
        display: none;
        padding: 24px 20px;
    }

    .tab-pane.on {
        display: block;
    }

    /* ── About ── */
    .about-text {
        font-size: .88rem;
        color: var(--muted);
        line-height: 1.75;
    }

    .lang-pills {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-top: 14px;
    }

    .lang-pill {
        padding: 4px 12px;
        border-radius: 20px;
        background: var(--bg);
        border: 1px solid var(--border);
        font-size: .75rem;
        font-weight: 500;
        color: var(--muted);
    }

    /* ── Property cards ── */
    .prop-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 14px;
    }

    .prop-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform var(--t), box-shadow var(--t);
        text-decoration: none;
        color: var(--text);
    }

    .prop-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .09);
        color: var(--text);
        text-decoration: none;
    }

    .prop-card-img {
        position: relative;
        aspect-ratio: 16/10;
        overflow: hidden;
        background: var(--bg);
        flex-shrink: 0;
    }

    .prop-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
        display: block;
    }

    .prop-card:hover .prop-card-img img {
        transform: scale(1.05);
    }

    .prop-type-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        padding: 2px 8px;
        border-radius: 5px;
        font-size: .65rem;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        background: rgba(200, 135, 58, .9);
        color: #fff;
    }

    .prop-card-body {
        padding: 12px 14px 14px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .prop-card-title {
        font-size: .88rem;
        font-weight: 600;
        color: var(--text);
        line-height: 1.3;
    }

    .prop-card-loc {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .75rem;
        color: var(--muted);
    }

    .prop-card-loc svg {
        width: 10px;
        height: 10px;
        color: var(--gold);
        flex-shrink: 0;
    }

    .prop-card-price {
        font-size: .92rem;
        font-weight: 700;
        color: var(--gold);
        margin-top: auto;
        padding-top: 8px;
        border-top: 1px solid var(--border);
    }

    .prop-card-price span {
        font-size: .72rem;
        font-weight: 400;
        color: var(--dim);
    }

    .prop-stats {
        display: flex;
        gap: 10px;
    }

    .prop-stat {
        display: flex;
        align-items: center;
        gap: 3px;
        font-size: .72rem;
        color: var(--muted);
    }

    .prop-stat svg {
        width: 11px;
        height: 11px;
    }

    /* ── Reviews ── */
    .review-summary {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 16px 20px;
        background: var(--bg);
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .review-big-score {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3rem;
        font-weight: 600;
        color: var(--text);
        line-height: 1;
    }

    .review-stars {
        display: flex;
        gap: 2px;
        margin: 4px 0;
    }

    .rstar {
        width: 14px;
        height: 14px;
        color: var(--gold);
    }

    .rstar.empty {
        color: #D9D4CC;
    }

    .review-card {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 12px;
    }

    .review-card:last-child {
        margin-bottom: 0;
    }

    .review-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .reviewer-name {
        font-size: .85rem;
        font-weight: 600;
        color: var(--text);
    }

    .review-date {
        font-size: .72rem;
        color: var(--dim);
    }

    .review-text {
        font-size: .82rem;
        color: var(--muted);
        line-height: 1.65;
    }

    .review-stars-sm {
        display: flex;
        gap: 1px;
        margin-bottom: 6px;
    }

    .rstar-sm {
        width: 11px;
        height: 11px;
        color: var(--gold);
    }

    .rstar-sm.empty {
        color: #D9D4CC;
    }

    /* ── Map ── */
    .map-frame {
        width: 100%;
        height: 280px;
        border-radius: 10px;
        border: none;
        display: block;
    }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 48px 20px;
        color: var(--dim);
    }

    .empty-state svg {
        width: 40px;
        height: 40px;
        margin-bottom: 12px;
        opacity: .35;
    }

    .empty-state p {
        font-size: .85rem;
        margin: 0;
    }

    /* ── Animations ── */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-up {
        animation: fadeUp .4s ease both;
    }

    .fade-up:nth-child(2) {
        animation-delay: .06s;
    }

    .fade-up:nth-child(3) {
        animation-delay: .12s;
    }

    .fade-up:nth-child(4) {
        animation-delay: .18s;
    }
</style>

{{-- ── Hero Banner ── --}}
<div class="ad-hero">
    <div class="ad-hero-text container">
        <div class="ad-hero-eyebrow">Agent Profile</div>
        <h1>{{ $agent->full_name }}</h1>
    </div>
</div>

<div class="container">

    {{-- ── Avatar overlap row ── --}}
    <div class="ad-avatar-wrap">
        <img src="{{asset('image/agents/')}}/{{ $agent->profile_image }}"
            class="ad-avatar"
            alt="{{ $agent->full_name }}">
        <div class="ad-avatar-meta">
            <h2>
                {{ $agent->full_name }}
                @if($agent->is_verified)
                <span class="verified-badge ms-1">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Verified
                </span>
                @endif
            </h2>
            <p>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="color:var(--gold)">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                </svg>
                {{ $agent->office_location ?? 'Kigali, Rwanda' }}
                &nbsp;·&nbsp;
                {{ $agent->years_experience ?? 0 }}+ years experience
                &nbsp;·&nbsp;
                Real Estate Agent
            </p>
        </div>
    </div>

    {{-- ── Two-column layout ── --}}
    <div class="ad-layout">

        {{-- ═══ SIDEBAR ═══ --}}
        <aside class="ad-sidebar fade-up">

            {{-- Stats --}}
            <div class="panel">
                <div class="stat-grid">
                    <div class="stat-pill">
                        <span class="val">{{ ($houses->count() + $lands->count()) }}</span>
                        <span class="lbl">Listings</span>
                    </div>
                    <div class="stat-pill">
                        <span class="val">{{ number_format($averageRating ?? 0, 1) }}</span>
                        <span class="lbl">Rating</span>
                    </div>
                    <div class="stat-pill">
                        <span class="val">{{ $agent->years_experience ?? 0 }}y</span>
                        <span class="lbl">Experience</span>
                    </div>
                    <div class="stat-pill">
                        <span class="val">{{ $reviews->count() }}</span>
                        <span class="lbl">Reviews</span>
                    </div>
                </div>

                <div class="panel-divider"></div>

                {{-- Meta info --}}
                <div class="panel-body">
                    @if($agent->office_location)
                    <div class="meta-row">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg>
                        <span>{{ $agent->office_location }}</span>
                    </div>
                    @endif
                    @if($agent->phone)
                    <div class="meta-row">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                        </svg>
                        <span>{{ $agent->phone }}</span>
                    </div>
                    @endif
                    @if($agent->email)
                    <div class="meta-row">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                        </svg>
                        <span>{{ $agent->email }}</span>
                    </div>
                    @endif
                    @if($agent->languages)
                    <div class="meta-row">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.87 15.07l-2.54-2.51.03-.03c1.74-1.94 2.98-4.17 3.71-6.53H17V4h-7V2H8v2H1v1.99h11.17C11.5 7.92 10.44 9.75 9 11.35 8.07 10.32 7.3 9.19 6.69 8h-2c.73 1.63 1.73 3.17 2.98 4.56l-5.09 5.02L4 19l5-5 3.11 3.11.76-2.04zM18.5 10h-2L12 22h2l1.12-3h4.75L21 22h2l-4.5-12zm-2.62 7l1.62-4.33L19.12 17h-3.24z" />
                        </svg>
                        <span>{{ $agent->languages }}</span>
                    </div>
                    @endif
                    @if($agent->specialty)
                    <div class="meta-row">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                        </svg>
                        <span>{{ $agent->specialty }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Contact --}}
            <div class="panel">
                <div class="panel-head">
                    <p class="panel-title">Get in touch</p>
                </div>
                <div class="contact-stack">
                    @if($agent->phone)
                    <a href="tel:{{ $agent->phone }}" class="c-btn c-btn-call">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                        </svg>
                        Call Agent
                    </a>
                    @endif
                    @if($agent->whatsapp)
                    <a href="https://wa.me/{{ $agent->whatsapp }}" target="_blank" class="c-btn c-btn-wa">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                            <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" />
                        </svg>
                        WhatsApp
                    </a>
                    @endif
                    @if($agent->email)
                    <a href="mailto:{{ $agent->email }}" class="c-btn c-btn-email">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                        </svg>
                        Send Email
                    </a>
                    @endif
                </div>

                {{-- Social --}}
                @if($agent->facebook || $agent->linkedin || $agent->instagram)
                <div class="panel-divider"></div>
                <div class="social-row">
                    @if($agent->facebook)
                    <a href="{{ $agent->facebook }}" target="_blank" rel="noopener" class="soc-btn">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    @endif
                    @if($agent->linkedin)
                    <a href="{{ $agent->linkedin }}" target="_blank" rel="noopener" class="soc-btn">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    @endif
                    @if($agent->instagram)
                    <a href="{{ $agent->instagram }}" target="_blank" rel="noopener" class="soc-btn">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    @endif
                </div>
                @endif
            </div>

            {{-- Map --}}
            @if($agent->office_location)
            <div class="panel">
                <div class="panel-head" style="padding-bottom:14px">
                    <p class="panel-title">Office Location</p>
                </div>
                <div style="padding:0 14px 14px">
                    <iframe class="map-frame"
                        loading="lazy"
                        allowfullscreen
                        src="https://www.google.com/maps?q={{ urlencode($agent->office_location) }}&output=embed">
                    </iframe>
                </div>
            </div>
            @endif

        </aside>

        {{-- ═══ MAIN CONTENT ═══ --}}
        <main class="fade-up" style="animation-delay:.08s; min-width:0">

            {{-- Tab navigation --}}
            <div class="panel" style="border-radius: var(--r); overflow:visible">
                <div class="ad-tabs" id="ad-tabs">
                    <button class="ad-tab on" data-tab="about">About</button>
                    @if($houses->count())
                    <button class="ad-tab" data-tab="houses">
                        Houses
                        <span style="background:var(--gold-bg);color:var(--gold);font-size:.65rem;padding:1px 6px;border-radius:10px;margin-left:4px;font-weight:600">{{ $houses->count() }}</span>
                    </button>
                    @endif
                    @if($lands->count())
                    <button class="ad-tab" data-tab="lands">
                        Plots
                        <span style="background:var(--gold-bg);color:var(--gold);font-size:.65rem;padding:1px 6px;border-radius:10px;margin-left:4px;font-weight:600">{{ $lands->count() }}</span>
                    </button>
                    @endif
                    <button class="ad-tab" data-tab="reviews">
                        Reviews
                        <span style="background:var(--gold-bg);color:var(--gold);font-size:.65rem;padding:1px 6px;border-radius:10px;margin-left:4px;font-weight:600">{{ $reviews->count() }}</span>
                    </button>
                </div>

                {{-- ── About Tab ── --}}
                <div class="tab-pane on" id="tab-about">
                    <p class="about-text">{{ $agent->bio ?? 'No biography provided yet.' }}</p>
                    @if($agent->languages)
                    <div style="margin-top:20px">
                        <p style="font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.07em;color:var(--dim);margin-bottom:8px">Languages</p>
                        <div class="lang-pills">
                            @foreach(explode(',', $agent->languages) as $lang)
                            <span class="lang-pill">{{ trim($lang) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Expertise areas if specialty exists --}}
                    @if($agent->specialty)
                    <div style="margin-top:20px">
                        <p style="font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.07em;color:var(--dim);margin-bottom:8px">Specialty</p>
                        <span class="lang-pill" style="background:var(--gold-bg);border-color:var(--gold-bd);color:var(--gold)">{{ $agent->specialty }}</span>
                    </div>
                    @endif
                </div>

                {{-- ── Houses Tab ── --}}
                @if($houses->count())
                <div class="tab-pane" id="tab-houses">
                    <div class="prop-grid">
                        @foreach($houses as $home)
                        <a href="{{ route('front.buy.home.details', $home) }}" class="prop-card">
                            <div class="prop-card-img">
                                <span class="prop-type-badge">House</span>
                                <img src="{{ $home->main_image
                                                ? asset('storage/'.$home->main_image)
                                                : asset('front/assets/img/all-images/properties/property-img1.png') }}"
                                    alt="{{ $home->title }}"
                                    loading="lazy">
                            </div>
                            <div class="prop-card-body">
                                <p class="prop-card-title">{{ $home->title }}</p>
                                <div class="prop-card-loc">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                                    </svg>
                                    {{ Str::limit($home->address, 32) }}
                                </div>
                                @if($home->bedrooms || $home->bathrooms || $home->area_sqft)
                                <div class="prop-stats">
                                    @if($home->bedrooms)
                                    <span class="prop-stat">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20 9.556V3h-2v2H6V3H4v6.557C2.81 10.25 2 11.526 2 13v4h1v2h2v-2h14v2h2v-2h1v-4c0-1.474-.811-2.75-2-3.444zM11 9H6V7h5v2zm7 0h-5V7h5v2z" />
                                        </svg>
                                        {{ $home->bedrooms }}
                                    </span>
                                    @endif
                                    @if($home->bathrooms)
                                    <span class="prop-stat">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M21 10H7V7c0-1.103.897-2 2-2s2 .897 2 2h2c0-2.206-1.794-4-4-4S5 4.794 5 7v3H3a1 1 0 00-1 1v2c0 3.478 2.549 6.385 5.895 6.93L7 22h2l-.895-2h7.79L15 22h2l-.895-2.07C19.451 19.385 22 16.478 22 13v-2a1 1 0 00-1-1z" />
                                        </svg>
                                        {{ $home->bathrooms }}
                                    </span>
                                    @endif
                                    @if($home->area_sqft)
                                    <span class="prop-stat">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z" />
                                        </svg>
                                        {{ number_format($home->area_sqft) }} sq
                                    </span>
                                    @endif
                                </div>
                                @endif
                                <div class="prop-card-price">
                                    {{ number_format($home->price) }} <span>RWF</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- ── Lands Tab ── --}}
                @if($lands->count())
                <div class="tab-pane" id="tab-lands">
                    <div class="prop-grid">
                        @foreach($lands as $land)
                        <a href="{{ route('front.buy.land.details', $land) }}" class="prop-card">
                            <div class="prop-card-img">
                                <span class="prop-type-badge">Plot</span>
                                <img src="{{ $land->main_image
                                                ? asset('storage/'.$land->main_image)
                                                : asset('front/assets/img/all-images/properties/property-img2.png') }}"
                                    alt="{{ $land->title }}"
                                    loading="lazy">
                            </div>
                            <div class="prop-card-body">
                                <p class="prop-card-title">{{ $land->title }}</p>
                                <div class="prop-card-loc">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                                    </svg>
                                    {{ $land->sector }}, {{ $land->district }}
                                </div>
                                @if($land->size_sqm || $land->zoning)
                                <div class="prop-stats">
                                    @if($land->size_sqm)
                                    <span class="prop-stat">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z" />
                                        </svg>
                                        {{ number_format($land->size_sqm) }} sqm
                                    </span>
                                    @endif
                                    @if($land->zoning)
                                    <span class="prop-stat">{{ $land->zoning }}</span>
                                    @endif
                                </div>
                                @endif
                                <div class="prop-card-price">
                                    {{ number_format($land->price) }} <span>RWF</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- ── Reviews Tab ── --}}
                <div class="tab-pane" id="tab-reviews">
                    @if($reviews->count())
                    <div class="review-summary">
                        <div>
                            <div class="review-big-score">{{ number_format($averageRating ?? 0, 1) }}</div>
                            <div class="review-stars">
                                @php $avg = round($averageRating ?? 0); @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="rstar {{ $i > $avg ? 'empty' : '' }}" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                    @endfor
                            </div>
                            <p style="font-size:.75rem;color:var(--dim);margin:0">{{ $reviews->count() }} reviews</p>
                        </div>
                    </div>

                    @foreach($reviews as $review)
                    @php $rs = (int) round($review->rating ?? 0); @endphp
                    <div class="review-card">
                        <div class="review-header">
                            <span class="reviewer-name">{{ $review->user->name ?? 'Anonymous' }}</span>
                            <span class="review-date">{{ $review->created_at?->format('M Y') }}</span>
                        </div>
                        <div class="review-stars-sm">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="rstar-sm {{ $i > $rs ? 'empty' : '' }}" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                                @endfor
                        </div>
                        <p class="review-text">{{ $review->comment }}</p>
                    </div>
                    @endforeach

                    @else
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p>No reviews yet for this agent.</p>
                    </div>
                    @endif
                </div>

            </div>{{-- /panel --}}
        </main>

    </div>{{-- /ad-layout --}}
</div>{{-- /container --}}

<script>
    (function() {
        const tabs = document.querySelectorAll('.ad-tab');
        const panes = document.querySelectorAll('.tab-pane');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('on'));
                panes.forEach(p => p.classList.remove('on'));
                tab.classList.add('on');
                const target = document.getElementById('tab-' + tab.dataset.tab);
                if (target) target.classList.add('on');
            });
        });
    })();
</script>

@endsection