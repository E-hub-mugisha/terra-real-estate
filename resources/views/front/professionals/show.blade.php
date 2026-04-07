@extends('layouts.guest')
@section('title', $professional->full_name . ' — Professional Profile')
@section('content')

@php
$expYears = (int)($professional->years_experience ?? 0);
$rating = (float)($professional->rating ?? 0);
$services = $professional->professionalServices ?? collect();
$cats = $professional->serviceCategories ?? collect();
$languages = collect(json_decode($professional->languages ?? '[]', true));
$imgSrc = $professional->profile_image
? asset('storage/' . $professional->profile_image)
: asset('front/assets/img/all-images/team/team-img1.png');
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --surface: #FFFFFF;
        --dark: #19265d;
        --border: rgba(0, 0, 0, .08);
        --border2: rgba(0, 0, 0, .14);
        --gold: #C8873A;
        --gold-lt: #E5A55E;
        --gold-bg: rgba(200, 135, 58, .07);
        --gold-bd: rgba(200, 135, 58, .22);
        --text: #19265d;
        --muted: #6B6560;
        --dim: #9E9890;
        --green: #1E7A5A;
        --green-bg: rgba(30, 122, 90, .08);
        --green-bd: rgba(30, 122, 90, .22);
        --r: 13px;
        --t: .22s cubic-bezier(.4, 0, .2, 1);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
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

    /* ══ BREADCRUMB ══ */
    .pd-breadcrumb {
        background: var(--dark);
        padding: 14px 0;
        border-bottom: 1px solid rgba(255, 255, 255, .07);
    }

    .pd-breadcrumb-inner {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .75rem;
        color: rgba(240, 237, 232, .4);
    }

    .pd-breadcrumb a {
        color: rgba(240, 237, 232, .55);
        transition: color var(--t);
    }

    .pd-breadcrumb a:hover {
        color: var(--gold-lt);
    }

    .pd-breadcrumb svg {
        width: 12px;
        height: 12px;
        opacity: .4;
    }

    .pd-breadcrumb span {
        color: var(--gold-lt);
    }

    /* ══ HERO BANNER ══ */
    .pd-hero {
        background: var(--dark);
        position: relative;
        overflow: hidden;
        padding: 52px 0 0;
    }

    .pd-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 50% 70% at 0% 100%, rgba(200, 135, 58, .13) 0%, transparent 60%),
            radial-gradient(ellipse 40% 50% at 100% 0%, rgba(200, 135, 58, .07) 0%, transparent 55%);
        pointer-events: none;
    }

    .pd-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255, 255, 255, .015) 39px, rgba(255, 255, 255, .015) 40px),
            repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255, 255, 255, .01) 79px, rgba(255, 255, 255, .01) 80px);
        pointer-events: none;
    }

    .pd-hero-inner {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 200px 1fr auto;
        gap: 36px;
        align-items: flex-end;
        padding-bottom: 0;
    }

    @media (max-width: 900px) {
        .pd-hero-inner {
            grid-template-columns: 140px 1fr;
        }

        .pd-hero-actions-col {
            grid-column: 1/-1;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding-bottom: 28px;
        }
    }

    @media (max-width: 560px) {
        .pd-hero-inner {
            grid-template-columns: 1fr;
        }

        .pd-avatar-wrap {
            width: 120px;
        }
    }

    /* Avatar */
    .pd-avatar-wrap {
        position: relative;
        width: 200px;
        align-self: flex-end;
        flex-shrink: 0;
    }

    .pd-avatar-wrap img {
        width: 100%;
        aspect-ratio: 3/4;
        object-fit: cover;
        display: block;
        border-radius: 12px 12px 0 0;
        border: 3px solid rgba(255, 255, 255, .12);
        border-bottom: none;
    }

    @media (max-width: 900px) {
        .pd-avatar-wrap {
            width: 140px;
        }
    }

    .pd-verified-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        background: rgba(30, 122, 90, .85);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, .15);
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: #fff;
    }

    .pd-verified-badge svg {
        width: 11px;
        height: 11px;
    }

    /* Hero text */
    .pd-hero-text {
        padding-bottom: 36px;
    }

    .pd-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .7rem;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold-lt);
        margin-bottom: 10px;
    }

    .pd-eyebrow::before {
        content: '';
        width: 16px;
        height: 1px;
        background: var(--gold);
        opacity: .6;
    }

    .pd-hero-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.8rem, 4vw, 3rem);
        font-weight: 500;
        line-height: 1.05;
        letter-spacing: -.025em;
        color: #F0EDE8;
        margin-bottom: 6px;
    }

    .pd-hero-profession {
        font-size: .88rem;
        color: var(--gold-lt);
        font-weight: 500;
        margin-bottom: 18px;
    }

    .pd-hero-meta {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
    }

    .pd-hero-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: .78rem;
        color: rgba(240, 237, 232, .45);
    }

    .pd-hero-meta-item svg {
        width: 13px;
        height: 13px;
        color: var(--gold);
        opacity: .7;
    }

    .pd-stars {
        display: flex;
        gap: 2px;
    }

    .pd-stars svg {
        width: 12px;
        height: 12px;
    }

    .pd-star-on {
        color: var(--gold);
    }

    .pd-star-off {
        color: rgba(255, 255, 255, .18);
    }

    /* Actions column */
    .pd-hero-actions-col {
        padding-bottom: 36px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }

    .pd-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 20px;
        border-radius: 9px;
        font-size: .83rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: all var(--t);
        white-space: nowrap;
        text-decoration: none;
        border: none;
        width: 100%;
    }

    .pd-action-btn svg {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
    }

    .pd-action-btn.gold {
        background: var(--gold);
        color: #fff;
    }

    .pd-action-btn.gold:hover {
        background: #a06828;
        transform: translateY(-1px);
        color: #fff;
    }

    .pd-action-btn.ghost {
        background: rgba(255, 255, 255, .09);
        color: rgba(240, 237, 232, .7);
        border: 1px solid rgba(255, 255, 255, .15);
    }

    .pd-action-btn.ghost:hover {
        background: rgba(255, 255, 255, .15);
        color: #F0EDE8;
    }

    .pd-action-btn.wa {
        background: #25D366;
        color: #fff;
    }

    .pd-action-btn.wa:hover {
        background: #1ebe5b;
        transform: translateY(-1px);
        color: #fff;
    }

    /* License tag */
    .pd-license {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 6px;
        background: rgba(200, 135, 58, .12);
        border: 1px solid rgba(200, 135, 58, .25);
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .05em;
        color: var(--gold-lt);
    }

    .pd-license svg {
        width: 11px;
        height: 11px;
    }

    /* ══ BODY LAYOUT ══ */
    .pd-body {
        padding: 48px 0 80px;
    }

    .pd-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 28px;
        align-items: start;
    }

    @media (max-width: 960px) {
        .pd-layout {
            grid-template-columns: 1fr;
        }
    }

    /* Section blocks */
    .pd-block {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .pd-block-header {
        padding: 18px 22px 14px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .pd-block-header svg {
        width: 16px;
        height: 16px;
        color: var(--gold);
    }

    .pd-block-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text);
    }

    .pd-block-body {
        padding: 20px 22px;
    }

    /* Bio */
    .pd-bio {
        font-size: .875rem;
        color: var(--muted);
        line-height: 1.85;
    }

    /* Services */
    .pd-services-grid {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pd-service-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 13px;
        border-radius: 8px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        font-size: .76rem;
        font-weight: 500;
        color: var(--text);
    }

    .pd-service-pill svg {
        width: 11px;
        height: 11px;
        color: var(--gold);
    }

    /* Service categories */
    .pd-cats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 10px;
    }

    .pd-cat-card {
        padding: 14px 14px;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: var(--bg);
        text-align: center;
        font-size: .78rem;
        font-weight: 600;
        color: var(--muted);
        transition: border-color var(--t), background var(--t);
    }

    .pd-cat-card:hover {
        border-color: var(--gold-bd);
        background: var(--gold-bg);
        color: var(--text);
    }

    .pd-cat-card svg {
        width: 22px;
        height: 22px;
        color: var(--gold);
        margin-bottom: 6px;
        display: block;
        margin-inline: auto;
    }

    /* Stats row */
    .pd-stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .pd-stat {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 18px 14px;
        text-align: center;
    }

    .pd-stat-val {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.9rem;
        font-weight: 600;
        color: var(--gold);
        line-height: 1;
        letter-spacing: -.02em;
    }

    .pd-stat-lbl {
        font-size: .7rem;
        color: var(--muted);
        margin-top: 4px;
    }

    /* Sidebar cards */
    .pd-side-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        margin-bottom: 16px;
        overflow: hidden;
    }

    .pd-side-header {
        padding: 15px 18px 12px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .pd-side-header svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
    }

    .pd-side-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text);
    }

    .pd-side-body {
        padding: 16px 18px;
    }

    /* Contact list */
    .pd-contact-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .pd-contact-item {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .pd-contact-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .pd-contact-icon svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
    }

    .pd-contact-label {
        font-size: .67rem;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--dim);
        margin-bottom: 2px;
    }

    .pd-contact-val {
        font-size: .82rem;
        font-weight: 500;
        color: var(--text);
    }

    .pd-contact-val a {
        color: var(--text);
        transition: color var(--t);
    }

    .pd-contact-val a:hover {
        color: var(--gold);
    }

    /* Info rows */
    .pd-info-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .pd-info-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .pd-info-row svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
        margin-top: 2px;
        flex-shrink: 0;
    }

    .pd-info-key {
        font-size: .7rem;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--dim);
    }

    .pd-info-val {
        font-size: .82rem;
        font-weight: 500;
        color: var(--text);
    }

    /* Language pills */
    .pd-lang-pills {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .pd-lang {
        padding: 3px 10px;
        border-radius: 20px;
        background: var(--bg);
        border: 1px solid var(--border2);
        font-size: .73rem;
        font-weight: 500;
        color: var(--muted);
    }

    /* Sidebar CTA */
    .pd-cta-card {
        background: var(--dark);
        border-radius: var(--r);
        padding: 24px 20px;
        position: relative;
        overflow: hidden;
    }

    .pd-cta-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 80% 70% at 100% 0%, rgba(200, 135, 58, .14) 0%, transparent 60%);
        pointer-events: none;
    }

    .pd-cta-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 500;
        color: #F0EDE8;
        margin-bottom: 6px;
        line-height: 1.2;
        position: relative;
    }

    .pd-cta-title em {
        font-style: italic;
        color: var(--gold-lt);
    }

    .pd-cta-desc {
        font-size: .78rem;
        color: rgba(240, 237, 232, .4);
        margin-bottom: 16px;
        line-height: 1.6;
        position: relative;
    }

    .pd-cta-btn {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 11px 18px;
        border-radius: 9px;
        background: var(--gold);
        border: none;
        color: #fff;
        font-size: .84rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background var(--t);
        text-decoration: none;
    }

    .pd-cta-btn:hover {
        background: #a06828;
        color: #fff;
    }

    .pd-cta-btn svg {
        width: 14px;
        height: 14px;
    }

    /* Back link */
    .pd-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: .78rem;
        color: var(--muted);
        margin-bottom: 22px;
        transition: color var(--t);
    }

    .pd-back:hover {
        color: var(--gold);
    }

    .pd-back svg {
        width: 14px;
        height: 14px;
    }

    /* Portfolio link */
    .pd-portfolio-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: .82rem;
        font-weight: 600;
        color: var(--gold);
        transition: gap var(--t);
    }

    .pd-portfolio-link:hover {
        gap: 10px;
    }

    .pd-portfolio-link svg {
        width: 13px;
        height: 13px;
    }

    /* Social links row */
    .pd-social-row {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pd-soc {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 14px;
        border-radius: 8px;
        border: 1.5px solid var(--border);
        font-size: .78rem;
        font-weight: 500;
        color: var(--muted);
        transition: all var(--t);
        text-decoration: none;
    }

    .pd-soc svg {
        width: 14px;
        height: 14px;
    }

    .pd-soc:hover {
        border-color: var(--gold-bd);
        color: var(--gold);
        background: var(--gold-bg);
    }

    .pd-soc.wa:hover {
        border-color: rgba(37, 211, 102, .3);
        color: #25D366;
        background: rgba(37, 211, 102, .06);
    }

    /* Verified inline */
    .pd-inline-verified {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 20px;
        background: var(--green-bg);
        border: 1px solid var(--green-bd);
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--green);
    }

    .pd-inline-verified svg {
        width: 11px;
        height: 11px;
    }
    /* ── View count chip ── */
    .view-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .75rem;
        font-weight: 600;
        color: var(--clr-muted);
    }

    .view-chip svg { width: 14px; height: 14px; opacity: .7; }
</style>

{{-- BREADCRUMB --}}
<div class="pd-breadcrumb">
    <div class="container">
        <div class="pd-breadcrumb-inner">
            <a href="{{ url('/') }}">Home</a>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6" />
            </svg>
            <a href="{{ route('front.professionals.index') }}">Professionals</a>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6" />
            </svg>
            <span>{{ $professional->full_name }}</span>
        </div>
    </div>
</div>

{{-- HERO BANNER --}}
<div class="pd-hero">
    <div class="container">
        <div class="pd-hero-inner">

            {{-- Avatar --}}
            <div class="pd-avatar-wrap">
                @if($professional->is_verified)
                <div class="pd-verified-badge">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Verified
                </div>
                @endif
                <img src="{{ $imgSrc }}" alt="{{ $professional->full_name }}">
            </div>

            {{-- Hero text --}}
            <div class="pd-hero-text">
                <div class="pd-eyebrow">{{ $professional->profession ?? 'Real Estate Professional' }}</div>
                <h1 class="pd-hero-name">{{ $professional->full_name }}</h1>
                <div class="pd-hero-profession">{{ $professional->profession }}</div>

                <div class="pd-hero-meta">
                    @if($rating > 0)
                    <div class="pd-hero-meta-item">
                        <div class="pd-stars">
                            @for($s = 1; $s <= 5; $s++)
                                <svg viewBox="0 0 24 24" fill="currentColor" class="{{ $s <= round($rating) ? 'pd-star-on' : 'pd-star-off' }}">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" /></svg>
                                @endfor
                        </div>
                        <span>{{ number_format($rating, 1) }} rating</span>
                    </div>
                    @endif

                    @if($expYears)
                    <div class="pd-hero-meta-item">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z" />
                        </svg>
                        {{ $expYears }} years experience
                    </div>
                    @endif

                    @if($professional->office_location)
                    <div class="pd-hero-meta-item">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                        </svg>
                        {{ $professional->office_location }}
                    </div>
                    @endif

                    @if($professional->license_number)
                    <div class="pd-license">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-3z" />
                        </svg>
                        Lic. {{ $professional->license_number }}
                    </div>
                    @endif
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="pd-hero-actions-col">
                @if($professional->phone)
                <a href="tel:{{ $professional->phone }}" class="pd-action-btn gold">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                    </svg>
                    Call Now
                </a>
                @endif
                @if($professional->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/\D+/','',$professional->whatsapp) }}" target="_blank" class="pd-action-btn wa">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51A10.45 10.45 0 009 5.99c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
                        <path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.52 3.66 1.428 5.18L2 22l4.975-1.395A10 10 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z" />
                    </svg>
                    WhatsApp
                </a>
                @endif
                @if($professional->email)
                <a href="mailto:{{ $professional->email }}" class="pd-action-btn ghost">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                    </svg>
                    Send Email
                </a>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- BODY --}}
<div class="pd-body">
    <div class="container">
        <a href="{{ route('front.professionals.index') }}" class="pd-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Back to all professionals
        </a>

        <div class="pd-layout">

            {{-- LEFT COLUMN --}}
            <div>

                {{-- Stats --}}
                <div class="pd-block">
                    <div class="pd-block-body" style="padding-bottom:22px;">
                        <div class="pd-stats-row">
                            <div class="pd-stat">
                                <div class="pd-stat-val">{{ $expYears ?: '—' }}</div>
                                <div class="pd-stat-lbl">Years Experience</div>
                            </div>
                            <div class="pd-stat">
                                <div class="pd-stat-val">{{ $rating > 0 ? number_format($rating,1) : '—' }}</div>
                                <div class="pd-stat-lbl">Rating</div>
                            </div>
                            <div class="pd-stat">
                                <div class="pd-stat-val">{{ $services->count() ?: '—' }}</div>
                                <div class="pd-stat-lbl">Services</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- About --}}
                @if($professional->bio)
                <div class="pd-block">
                    <div class="pd-block-header">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                        </svg>
                        <h2 class="pd-block-title">About</h2>
                    </div>
                    <div class="pd-block-body">
                        <p class="pd-bio">{{ $professional->bio }}</p>
                    </div>
                </div>
                @endif

                {{-- Services --}}
                @if($services->isNotEmpty())
                <div class="pd-block">
                    <div class="pd-block-header">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                        </svg>
                        <h2 class="pd-block-title">Services Offered</h2>
                    </div>
                    <div class="pd-block-body">
                        <div class="pd-services-grid">
                            @foreach($services as $svc)
                            <div class="pd-service-pill">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $svc->title }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{-- Service Categories --}}
                @if($cats->isNotEmpty())
                <div class="pd-block">
                    <div class="pd-block-header">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                        </svg>
                        <h2 class="pd-block-title">Areas of Expertise</h2>
                    </div>
                    <div class="pd-block-body">
                        <div class="pd-cats-grid">
                            @foreach($cats as $cat)
                            <div class="pd-cat-card">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    <polyline points="9 22 9 12 15 12 15 22" />
                                </svg>
                                {{ $cat->name }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{-- Social & Portfolio links --}}
                @if($professional->linkedin || $professional->website || $professional->portfolio_url)
                <div class="pd-block">
                    <div class="pd-block-header">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <h2 class="pd-block-title">Links &amp; Portfolio</h2>
                    </div>
                    <div class="pd-block-body">
                        <div class="pd-social-row">
                            @if($professional->linkedin)
                            <a href="{{ $professional->linkedin }}" target="_blank" class="pd-soc">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z" />
                                    <circle cx="4" cy="4" r="2" />
                                </svg>
                                LinkedIn
                            </a>
                            @endif
                            @if($professional->website)
                            <a href="{{ $professional->website }}" target="_blank" class="pd-soc">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="2" y1="12" x2="22" y2="12" />
                                    <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z" />
                                </svg>
                                Website
                            </a>
                            @endif
                            @if($professional->portfolio_url)
                            <a href="{{ $professional->portfolio_url }}" target="_blank" class="pd-soc">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
                                    <line x1="8" y1="21" x2="16" y2="21" />
                                    <line x1="12" y1="17" x2="12" y2="21" />
                                </svg>
                                Portfolio
                            </a>
                            @endif
                            @if($professional->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/\D+/','',$professional->whatsapp) }}" target="_blank" class="pd-soc wa">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51A10.45 10.45 0 009 5.99c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
                                    <path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.52 3.66 1.428 5.18L2 22l4.975-1.395A10 10 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z" />
                                </svg>
                                WhatsApp
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

            </div>{{-- /left --}}

            {{-- RIGHT SIDEBAR --}}
            <div>

                {{-- Contact card --}}
                <div class="pd-side-card">
                    <div class="pd-side-header">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                        </svg>
                        <span class="pd-side-title">Contact Details</span>
                    </div>
                    <div class="pd-side-body">
                        <div class="pd-contact-list">
                            @if($professional->phone)
                            <div class="pd-contact-item">
                                <div class="pd-contact-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="pd-contact-label">Phone</div>
                                    <div class="pd-contact-val"><a href="tel:{{ $professional->phone }}">{{ $professional->phone }}</a></div>
                                </div>
                            </div>
                            @endif

                            @if($professional->email)
                            <div class="pd-contact-item">
                                <div class="pd-contact-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="pd-contact-label">Email</div>
                                    <div class="pd-contact-val"><a href="mailto:{{ $professional->email }}">{{ $professional->email }}</a></div>
                                </div>
                            </div>
                            @endif

                            @if($professional->office_location)
                            <div class="pd-contact-item">
                                <div class="pd-contact-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="pd-contact-label">Office</div>
                                    <div class="pd-contact-val">{{ $professional->office_location }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Professional info --}}
                <div class="pd-side-card">
                    <div class="pd-side-header">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-3z" />
                        </svg>
                        <span class="pd-side-title">Professional Info</span>
                    </div>
                    <div class="pd-side-body">
                        <div class="pd-info-list">
                            @if($professional->profession)
                            <div class="pd-info-row">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 6h-2.18c.07-.44.18-.88.18-1.34C18 2.54 15.46 0 12 0 8.54 0 6 2.54 6 4.66c0 .46.11.9.18 1.34H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-8-4c1.68 0 3.12.76 3.8 2H8.2c.68-1.24 2.12-2 3.8-2zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" />
                                </svg>
                                <div>
                                    <div class="pd-info-key">Profession</div>
                                    <div class="pd-info-val">{{ $professional->profession }}</div>
                                </div>
                            </div>
                            @endif

                            @if($professional->license_number)
                            <div class="pd-info-row">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z" />
                                </svg>
                                <div>
                                    <div class="pd-info-key">License Number</div>
                                    <div class="pd-info-val">{{ $professional->license_number }}</div>
                                </div>
                            </div>
                            @endif

                            @if($professional->years_experience)
                            <div class="pd-info-row">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z" />
                                </svg>
                                <div>
                                    <div class="pd-info-key">Experience</div>
                                    <div class="pd-info-val">{{ $professional->years_experience }} years</div>
                                </div>
                            </div>
                            @endif

                            @if($professional->is_verified)
                            <div class="pd-info-row">
                                <svg viewBox="0 0 24 24" fill="currentColor" style="color:var(--green)">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <div class="pd-info-key">Status</div>
                                    <div class="pd-info-val">
                                        <span class="pd-inline-verified">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Verified
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($languages->isNotEmpty())
                            <div class="pd-info-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="2" y1="12" x2="22" y2="12" />
                                    <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z" />
                                </svg>
                                <div>
                                    <div class="pd-info-key" style="margin-bottom:6px;">Languages</div>
                                    <div class="pd-lang-pills">
                                        @foreach($languages as $lang)
                                        <span class="pd-lang">{{ $lang }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                            {{-- ── View count (total, human-formatted) ── --}}
                            @if($professional->views_count > 0)
                            <span class="view-chip">
                                {{-- Eye icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                </svg>
                                {{ number_format($professional->views_count) }} {{ Str::plural('view', $professional->views_count) }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="pd-cta-card">
                    <div class="pd-cta-title">Need expert<br><em>property advice?</em></div>
                    <p class="pd-cta-desc">Connect with {{ $professional->full_name ?? 'this professional' }} directly for personalised guidance on Rwanda's real estate market.</p>
                    @if($professional->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/\D+/','',$professional->whatsapp) }}?text=Hello%20{{ urlencode($professional->full_name) }}%2C%20I%20found%20your%20profile%20on%20Terra%20and%20would%20like%20to%20discuss%20a%20property%20matter." target="_blank" class="pd-cta-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5 -.669-.51A10.45 10.45 0 009 5.99c -.198 0 -.52 .074 -.79２ .3７２ -.２７２ .２９７ -１.０４ １.０１６ -１.０４ ２.４７９ ０ １.４６２ １.０６５ ２.８７５ １.２１３ ３.０７４ .１４９ .１９８ ２.０９６ ３.２ ５.０７７ ４.４８７ .７０９ .３０６ １.２６２ .４８９ １.６９４ .６２５ .７１２ .２２７ １.３６ .１９５ １.８７１ .１１８ .５７１ -.０８５ １.７５８ -.７１９ ２.００６ -₁₁₃ .₂₄₈ -.₆₉₄ .₂₄₈ -₁.₈₉ .₁₇₃ -₁₁₃ z" />
                            <path d="M₁₂ ₂C₆.₇₇ ₂ ₂ ₆.₇₇ ₂ ₁₂c₀ ₁.₉ .⁵² ³.⁶ ₁²⁸ ⁵.⁸L₂ ₂²l⁴.⁷⁵ -¹.⁹⁵A₁₀ ₁₀ ₀ ᴛ₀₀₀¹² ᴛ²²c⁵²³ ᴛ₀ ᴛ¹⁰ -⁴.⁷⁷ ᴛ¹⁰ -¹₀S₁₇²³ ₂ ᴛ¹² ₂z" />
                        </svg>
                        Message on WhatsApp
                    </a>
                    @elseif($professional->phone)
                    <a href="tel:{{ $professional->phone }}" class="pd-cta-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                        </svg>
                        Call {{ Str::before($professional->full_name, ' ') }}
                    </a>
                    @endif
                </div>

            </div>{{-- /sidebar --}}
        </div>
    </div>
</div>

@endsection