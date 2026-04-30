@extends('layouts.guest')

@section('title', $advertisement->title . ' — Terra Real Estate')
@section('meta_description', Str::limit(strip_tags($advertisement->description), 155))

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

<style>
    :root {
        --gold: #C8873A;
        --gold-hover: #b5762e;
        --gold-pale: #faf3ea;
        --gold-mid: rgba(200, 135, 58, .15);
        --navy: #19265d;
        --navy-mid: #243478;
        --navy-pale: #f0f2f9;
        --ink: #111827;
        --body: #374151;
        --muted: #6b7280;
        --line: rgba(25, 38, 93, .09);
        --surface: #ffffff;
        --bg: #f8f6f2;
        --r: 16px;
        --r-sm: 10px;
        --sh: 0 4px 24px rgba(25, 38, 93, .09);
        --sh-lg: 0 16px 56px rgba(25, 38, 93, .14);
        --font-serif: 'Cormorant Garamond', Georgia, serif;
        --font-sans: 'DM Sans', sans-serif;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: var(--font-sans);
        background: var(--bg);
        color: var(--ink);
        -webkit-font-smoothing: antialiased;
    }

    /* ═══════════════════════════════════════════════════════
   GALLERY HERO
═══════════════════════════════════════════════════════ */
    .hero {
        position: relative;
        background: var(--navy);
        height: 72vh;
        min-height: 460px;
        max-height: 680px;
        overflow: hidden;
    }

    .hero__slides {
        position: absolute;
        inset: 0;
    }

    .hero__slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity .6s ease;
    }

    .hero__slide.is-active {
        opacity: 1;
    }

    .hero__slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* gradient scrim */
    .hero__scrim {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(to top, rgba(17, 14, 10, .82) 0%, transparent 55%),
            linear-gradient(to right, rgba(17, 14, 10, .35) 0%, transparent 60%);
        z-index: 2;
    }

    /* no-image fallback */
    .hero--empty {
        height: 320px;
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
    }

    .hero--empty .hero__scrim {
        background: none;
    }

    /* thumbnail strip */
    .hero__thumbstrip {
        position: absolute;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
        display: flex;
        gap: 8px;
    }

    .hero__thumb {
        width: 52px;
        height: 36px;
        border-radius: 6px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color .2s, transform .2s;
        flex-shrink: 0;
    }

    .hero__thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero__thumb.is-active {
        border-color: var(--gold);
        transform: scale(1.08);
    }

    /* arrow controls */
    .hero__arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .12);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, .2);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background .2s;
    }

    .hero__arrow:hover {
        background: rgba(200, 135, 58, .6);
    }

    .hero__arrow--prev {
        left: 20px;
    }

    .hero__arrow--next {
        right: 20px;
    }

    /* image counter */
    .hero__counter {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 10;
        background: rgba(0, 0, 0, .45);
        backdrop-filter: blur(4px);
        color: #fff;
        font-size: 12px;
        letter-spacing: .05em;
        padding: 5px 12px;
        border-radius: 100px;
    }

    /* hero copy */
    .hero__copy {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 5;
        padding: 48px 56px 40px;
    }

    .hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--gold);
        color: #fff;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: .1em;
        text-transform: uppercase;
        padding: 5px 14px 5px 10px;
        border-radius: 100px;
        margin-bottom: 14px;
    }

    .hero__eyebrow svg {
        opacity: .8;
    }

    .hero__title {
        font-family: var(--font-serif);
        font-size: clamp(30px, 4.5vw, 54px);
        font-weight: 500;
        color: #fff;
        line-height: 1.1;
        max-width: 720px;
        margin-bottom: 18px;
        text-shadow: 0 2px 16px rgba(0, 0, 0, .3);
    }

    .hero__chips {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        align-items: center;
    }

    .hero__chip {
        display: flex;
        align-items: center;
        gap: 6px;
        color: rgba(255, 255, 255, .8);
        font-size: 14px;
    }

    .hero__price {
        font-family: var(--font-serif);
        font-size: 26px;
        font-weight: 600;
        color: #f5c882;
        margin-right: 6px;
    }

    .hero__divider {
        width: 1px;
        height: 18px;
        background: rgba(255, 255, 255, .25);
    }

    @media (max-width: 768px) {
        .hero__copy {
            padding: 32px 20px 28px;
        }

        .hero__thumbstrip {
            display: none;
        }

        .hero__arrow {
            display: none;
        }
    }

    /* ═══════════════════════════════════════════════════════
   BODY LAYOUT
═══════════════════════════════════════════════════════ */
    .page-wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 44px 32px 100px;
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 36px;
        align-items: start;
    }

    @media (max-width: 960px) {
        .page-wrap {
            grid-template-columns: 1fr;
            padding: 28px 16px 80px;
        }
    }

    /* ═══════════════════════════════════════════════════════
   BREADCRUMB
═══════════════════════════════════════════════════════ */
    .breadcrumb {
        padding: 16px 56px 0;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--muted);
        flex-wrap: wrap;
    }

    .breadcrumb a {
        color: var(--navy);
        text-decoration: none;
        transition: color .15s;
    }

    .breadcrumb a:hover {
        color: var(--gold);
    }

    @media (max-width: 768px) {
        .breadcrumb {
            padding: 12px 20px 0;
        }
    }

    /* ═══════════════════════════════════════════════════════
   SHARED CARD
═══════════════════════════════════════════════════════ */
    .card {
        background: var(--surface);
        border-radius: var(--r);
        border: 1px solid var(--line);
        box-shadow: var(--sh);
        overflow: hidden;
        animation: revealUp .5s ease both;
    }

    .card+.card {
        margin-top: 24px;
    }

    .card__head {
        padding: 20px 28px 18px;
        border-bottom: 1px solid var(--line);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card__icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        background: var(--gold-pale);
        color: var(--gold);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .card__title {
        font-family: var(--font-serif);
        font-size: 20px;
        font-weight: 600;
        color: var(--navy);
    }

    .card__body {
        padding: 26px 28px;
    }

    /* delay helpers */
    .card:nth-child(1) {
        animation-delay: .06s;
    }

    .card:nth-child(2) {
        animation-delay: .12s;
    }

    .card:nth-child(3) {
        animation-delay: .18s;
    }

    .card:nth-child(4) {
        animation-delay: .24s;
    }

    .card:nth-child(5) {
        animation-delay: .30s;
    }

    /* ═══════════════════════════════════════════════════════
   DESCRIPTION
═══════════════════════════════════════════════════════ */
    .ad-description {
        font-size: 15.5px;
        line-height: 1.8;
        color: var(--body);
        white-space: pre-line;
    }

    /* ═══════════════════════════════════════════════════════
   PROPERTY SNAPSHOT — the star section
═══════════════════════════════════════════════════════ */
    .property-snap {
        border-radius: var(--r);
        overflow: hidden;
        border: 1px solid var(--line);
        box-shadow: var(--sh);
        background: var(--surface);
    }

    .property-snap__cover {
        position: relative;
        height: 220px;
        background: var(--navy);
        overflow: hidden;
    }

    .property-snap__cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }

    .property-snap:hover .property-snap__cover img {
        transform: scale(1.04);
    }

    .property-snap__cover-scrim {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(17, 14, 10, .7) 0%, transparent 60%);
    }

    .property-snap__type-pill {
        position: absolute;
        top: 14px;
        left: 14px;
        background: var(--gold);
        color: #fff;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: .08em;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 100px;
    }

    .property-snap__cover-title {
        position: absolute;
        bottom: 14px;
        left: 16px;
        right: 16px;
        font-family: var(--font-serif);
        font-size: 20px;
        font-weight: 500;
        color: #fff;
        line-height: 1.2;
        text-shadow: 0 1px 8px rgba(0, 0, 0, .4);
    }

    .property-snap__body {
        padding: 20px 22px 6px;
    }

    .property-snap__attrs {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px 16px;
        margin-bottom: 18px;
    }

    .prop-attr {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .prop-attr__label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--muted);
    }

    .prop-attr__value {
        font-size: 14px;
        font-weight: 500;
        color: var(--ink);
    }

    .prop-attr__value--price {
        font-family: var(--font-serif);
        font-size: 18px;
        color: var(--gold);
        font-weight: 600;
    }

    .property-snap__divider {
        height: 1px;
        background: var(--line);
        margin: 0 -22px 18px;
    }

    .property-snap__cta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 0 22px;
        gap: 10px;
    }

    .btn-view-property {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 22px;
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-hover) 100%);
        color: #fff;
        font-family: var(--font-sans);
        font-size: 14px;
        font-weight: 500;
        border-radius: var(--r-sm);
        text-decoration: none;
        flex: 1;
        justify-content: center;
        transition: transform .15s, box-shadow .2s;
        box-shadow: 0 4px 14px rgba(200, 135, 58, .35);
    }

    .btn-view-property:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(200, 135, 58, .45);
        color: #fff;
    }

    .btn-save-property {
        width: 44px;
        height: 44px;
        border-radius: var(--r-sm);
        border: 1.5px solid var(--line);
        background: var(--surface);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        cursor: pointer;
        transition: border-color .2s, color .2s, background .2s;
        flex-shrink: 0;
    }

    .btn-save-property:hover {
        border-color: var(--gold);
        color: var(--gold);
        background: var(--gold-pale);
    }

    /* ═══════════════════════════════════════════════════════
   FEATURE PILLS (property quick facts)
═══════════════════════════════════════════════════════ */
    .feature-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: var(--navy-pale);
        color: var(--navy);
        border-radius: 100px;
        font-size: 13px;
        font-weight: 400;
        border: 1px solid rgba(25, 38, 93, .08);
    }

    .pill svg {
        color: var(--gold);
        flex-shrink: 0;
    }

    /* ═══════════════════════════════════════════════════════
   CONTACT SIDEBAR CARD
═══════════════════════════════════════════════════════ */
    .contact-card-design {
        background: var(--surface);
        border-radius: var(--r);
        border: 1px solid var(--line);
        box-shadow: var(--sh);
        overflow: hidden;
        animation: revealUp .5s ease .1s both;
    }

    .contact-card-design {
        /* display: flex; */
        align-items: center;
        gap: 1rem;
        /* padding: 1rem 1.2rem; */
        border-radius: 6px;
        border: 1px solid rgba(255, 255, 255, .06);
        background: rgba(255, 255, 255, .03);
        cursor: pointer;
        transition: background .2s, border-color .2s, transform .15s;
        text-decoration: none;
        margin-bottom: .75rem;
    }

    .contact-card__head {
        padding: 22px 24px 18px;
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
        position: relative;
        overflow: hidden;
    }

    .contact-card__head::after {
        content: '';
        position: absolute;
        right: -20px;
        bottom: -20px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(200, 135, 58, .15);
    }

    .contact-card__label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .12em;
        color: rgba(255, 255, 255, .5);
        margin-bottom: 6px;
    }

    .contact-card__poster-name {
        font-family: var(--font-serif);
        font-size: 22px;
        font-weight: 500;
        color: #fff;
        margin-bottom: 3px;
    }

    .contact-card__posted {
        font-size: 12px;
        color: rgba(255, 255, 255, .5);
    }

    .contact-card__body {
        padding: 22px 24px;
    }

    .contact-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: var(--r-sm);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        font-family: var(--font-sans);
        transition: transform .15s, box-shadow .2s;
        width: 100%;
        border: none;
        cursor: pointer;
    }

    .contact-btn+.contact-btn {
        margin-top: 10px;
    }

    .contact-btn:hover {
        transform: translateY(-1px);
        box-shadow: var(--sh-lg);
    }

    .contact-btn--phone {
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-hover) 100%);
        color: #fff;
        box-shadow: 0 4px 16px rgba(200, 135, 58, .3);
    }

    .contact-btn--email {
        background: var(--navy-pale);
        color: var(--navy);
        border: 1.5px solid var(--line);
    }

    .contact-btn__icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .contact-btn--phone .contact-btn__icon {
        background: rgba(255, 255, 255, .2);
        color: #fff;
    }

    .contact-btn--email .contact-btn__icon {
        background: var(--gold-mid);
        color: var(--gold);
    }

    .contact-btn__text {
        line-height: 1.3;
    }

    .contact-btn__text small {
        display: block;
        font-size: 11px;
        opacity: .65;
        font-weight: 400;
    }

    /* ═══════════════════════════════════════════════════════
   SIDEBAR INFO LIST
═══════════════════════════════════════════════════════ */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        font-size: 14px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--line);
    }

    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-row__label {
        color: var(--muted);
        flex-shrink: 0;
    }

    .info-row__value {
        color: var(--ink);
        font-weight: 500;
        text-align: right;
    }

    /* ═══════════════════════════════════════════════════════
   SHARE STRIP
═══════════════════════════════════════════════════════ */
    .share-strip {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 16px 24px;
        background: var(--gold-pale);
        border-top: 1px solid rgba(200, 135, 58, .15);
    }

    .share-strip__label {
        font-size: 12px;
        color: var(--muted);
        margin-right: 4px;
    }

    .share-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1.5px solid var(--line);
        background: var(--surface);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--navy);
        cursor: pointer;
        text-decoration: none;
        transition: background .15s, border-color .15s, color .15s;
    }

    .share-btn:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    /* ═══════════════════════════════════════════════════════
   RELATED LISTINGS
═══════════════════════════════════════════════════════ */
    .related-section {
        max-width: 1200px;
        margin: 0 auto 80px;
        padding: 0 32px;
    }

    .related-section__head {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 28px;
    }

    .related-section__title {
        font-family: var(--font-serif);
        font-size: 30px;
        font-weight: 500;
        color: var(--navy);
    }

    .related-section__link {
        font-size: 13px;
        color: var(--gold);
        text-decoration: none;
        font-weight: 500;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    @media (max-width: 900px) {
        .related-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 580px) {
        .related-grid {
            grid-template-columns: 1fr;
        }
    }

    .related-card {
        border-radius: var(--r);
        overflow: hidden;
        border: 1px solid var(--line);
        background: var(--surface);
        box-shadow: var(--sh);
        text-decoration: none;
        display: block;
        transition: transform .2s, box-shadow .2s;
    }

    .related-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--sh-lg);
    }

    .related-card__img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
        background: var(--navy);
    }

    .related-card__body {
        padding: 16px 18px 18px;
    }

    .related-card__type {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--gold);
        font-weight: 500;
        margin-bottom: 4px;
    }

    .related-card__title {
        font-family: var(--font-serif);
        font-size: 17px;
        font-weight: 500;
        color: var(--navy);
        line-height: 1.3;
        margin-bottom: 8px;
    }

    .related-card__meta {
        font-size: 13px;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* ═══════════════════════════════════════════════════════
   ANIMATIONS
═══════════════════════════════════════════════════════ */
    @keyframes revealUp {
        from {
            opacity: 0;
            transform: translateY(22px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ═══════════════════════════════════════════════════════
   VIDEO
═══════════════════════════════════════════════════════ */
    .ad-video {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
        border-radius: var(--r-sm);
        display: block;
    }

    /* ═══════════════════════════════════════════════════════
   BADGE
═══════════════════════════════════════════════════════ */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: .03em;
    }

    .badge-success {
        background: #d1fae5;
        color: #065f46;
    }

    /* ═══════════════════════════════════════════════════════
   STICKY SIDEBAR
═══════════════════════════════════════════════════════ */
    .sidebar-sticky {
        position: sticky;
        top: 24px;
    }

    @media (max-width: 960px) {
        .sidebar-sticky {
            position: static;
        }
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

    .view-chip svg {
        width: 14px;
        height: 14px;
        opacity: .7;
    }
</style>

<section
    class="hero {{ empty($advertisement->images) ? 'hero--empty' : '' }}"
    id="adHero"
    aria-label="Advertisement images">
    @if (!empty($advertisement->images))
    <div class="hero__slides" id="heroSlides">
        @foreach ($advertisement->images as $i => $img)
        <div class="hero__slide {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}">
            <img
                src="{{ asset($img) }}"
                alt="{{ $advertisement->title }} — image {{ $i + 1 }}"
                loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
        </div>
        @endforeach
    </div>

    @if (count($advertisement->images) > 1)
    <button class="hero__arrow hero__arrow--prev" id="heroPrev" aria-label="Previous image">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="15 18 9 12 15 6" />
        </svg>
    </button>
    <button class="hero__arrow hero__arrow--next" id="heroNext" aria-label="Next image">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="9 18 15 12 9 6" />
        </svg>
    </button>

    <div class="hero__thumbstrip">
        @foreach ($advertisement->images as $i => $img)
        <div class="hero__thumb {{ $i === 0 ? 'is-active' : '' }}" data-go="{{ $i }}">
            <img src="{{ asset($img) }}" alt="thumb {{ $i + 1 }}" loading="lazy">
        </div>
        @endforeach
    </div>

    <div class="hero__counter" id="heroCounter">
        1 / {{ count($advertisement->images) }}
    </div>
    @endif
    @endif

    <div class="hero__scrim"></div>

    <div class="hero__copy">
        @if ($advertisement->advertisable_type_label)
        <div class="hero__eyebrow">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor" opacity=".7">
                <circle cx="5" cy="5" r="4" />
            </svg>
            {{ $advertisement->advertisable_type_label }} &nbsp;·&nbsp; Advertisement
        </div>
        @endif

        <h1 class="hero__title">{{ $advertisement->title }}</h1>

        <div class="hero__chips">
            @if ($advertisement->location)
            <span class="hero__chip">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z" />
                    <circle cx="12" cy="10" r="3" />
                </svg>
                {{ $advertisement->location }}
            </span>
            <span class="hero__divider"></span>
            @endif

            @if ($advertisement->price_amount)
            <span class="hero__price">
                {{ number_format($advertisement->price_amount) }} {{ $advertisement->currency ?? 'RWF' }}
            </span>
            <span class="hero__divider"></span>
            @endif

            <span class="hero__chip">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
                Posted {{ $advertisement->created_at->diffForHumans() }}
            </span>

            @if ($advertisement->listingPackage)
            <span class="hero__divider"></span>
            <span class="badge badge-success">
                ★ {{ $advertisement->listingPackage->name }}
            </span>
            @endif

            {{-- ── View count (total, human-formatted) ── --}}
            @if($advertisement->views_count > 0)
            <span class="view-chip">
                {{-- Eye icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                </svg>
                {{ number_format($advertisement->views_count) }} {{ Str::plural('view', $advertisement->views_count) }}
            </span>
            @endif
        </div>
    </div>
</section>

{{-- Breadcrumb --}}
<nav class="breadcrumb" aria-label="Breadcrumb">
    <a href="{{ route('front.home') }}">Home</a>
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="9 18 15 12 9 6" />
    </svg>
    <a href="{{ route('advertisements.index') }}">Advertisements</a>
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="9 18 15 12 9 6" />
    </svg>
    <span>{{ Str::limit($advertisement->title, 45) }}</span>
</nav>

{{-- ════════════════════════════════════════════════════════
     MAIN CONTENT + SIDEBAR
═════════════════════════════════════════════════════════ --}}
<div class="page-wrap">

    {{-- ── LEFT: Main column ─────────────────────────────── --}}
    <div>

        {{-- Description --}}
        <div class="card">
            <div class="card__head">
                <div class="card__icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                    </svg>
                </div>
                <h2 class="card__title">About This Listing</h2>
            </div>
            <div class="card__body">
                <p class="ad-description">{{ $advertisement->description ?: 'No description provided.' }}</p>
            </div>
        </div>

        {{-- ── PROPERTY SNAPSHOT ────────────────────────── --}}
        @if ($advertisement->advertisable)
        @php $prop = $advertisement->advertisable; @endphp

        <div class="card">
            <div class="card__head">
                <div class="card__icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </div>
                <h2 class="card__title">Property Overview</h2>
            </div>
            <div class="card__body" style="padding:0;">

                <div class="property-snap">

                    {{-- Cover image --}}
                    <div class="property-snap__cover">
                        @php
                        $coverImages = $prop->images ?? ($prop->photos ?? []);
                        $coverSrc = !empty($coverImages) ? Storage::url($coverImages[0]) : null;
                        @endphp

                        @if ($coverSrc)
                        <img src="{{ $coverSrc }}" alt="{{ $prop->title ?? 'Property' }}">
                        @else
                        <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--navy),var(--navy-mid));"></div>
                        @endif

                        <div class="property-snap__cover-scrim"></div>

                        <span class="property-snap__type-pill">
                            {{ $advertisement->advertisable_type_label }}
                        </span>

                        @if ($prop->title ?? false)
                        <div class="property-snap__cover-title">{{ $prop->title }}</div>
                        @endif
                    </div>

                    <div class="property-snap__body">

                        {{-- Key attributes grid --}}
                        <div class="property-snap__attrs">

                            @if ($prop->price ?? false)
                            <div class="prop-attr">
                                <span class="prop-attr__label">Price</span>
                                <span class="prop-attr__value prop-attr__value--price">
                                    {{ number_format($prop->price) }}
                                    {{ $prop->currency ?? 'RWF' }}
                                </span>
                            </div>
                            @endif

                            @if ($prop->location ?? ($prop->district ?? false))
                            <div class="prop-attr">
                                <span class="prop-attr__label">Location</span>
                                <span class="prop-attr__value">{{ $prop->location ?? $prop->district }}</span>
                            </div>
                            @endif

                            @if ($prop->size ?? ($prop->area ?? false))
                            <div class="prop-attr">
                                <span class="prop-attr__label">Size</span>
                                <span class="prop-attr__value">
                                    {{ number_format($prop->size ?? $prop->area) }}
                                    {{ $prop->size_unit ?? 'm²' }}
                                </span>
                            </div>
                            @endif

                            @if ($prop->bedrooms ?? false)
                            <div class="prop-attr">
                                <span class="prop-attr__label">Bedrooms</span>
                                <span class="prop-attr__value">{{ $prop->bedrooms }}</span>
                            </div>
                            @endif

                            @if ($prop->bathrooms ?? false)
                            <div class="prop-attr">
                                <span class="prop-attr__label">Bathrooms</span>
                                <span class="prop-attr__value">{{ $prop->bathrooms }}</span>
                            </div>
                            @endif

                            @if ($prop->status ?? ($prop->listing_status ?? false))
                            <div class="prop-attr">
                                <span class="prop-attr__label">Status</span>
                                <span class="prop-attr__value">{{ ucfirst($prop->status ?? $prop->listing_status) }}</span>
                            </div>
                            @endif

                        </div>

                        {{-- Feature pills --}}
                        @php
                        $features = collect([
                        $prop->property_type ?? null,
                        isset($prop->is_furnished) ? ($prop->is_furnished ? 'Furnished' : 'Unfurnished') : null,
                        isset($prop->has_parking) && $prop->has_parking ? 'Parking' : null,
                        isset($prop->has_pool) && $prop->has_pool ? 'Swimming Pool' : null,
                        isset($prop->has_garden) && $prop->has_garden ? 'Garden' : null,
                        isset($prop->has_security) && $prop->has_security ? 'Security' : null,
                        $prop->tenure ?? null,
                        ])->filter();
                        @endphp

                        @if ($features->isNotEmpty())
                        <div class="feature-pills" style="margin-bottom:20px;">
                            @foreach ($features as $feat)
                            <span class="pill">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                {{ $feat }}
                            </span>
                            @endforeach
                        </div>
                        @endif

                        <div class="property-snap__divider"></div>

                        <div class="property-snap__cta">
                            <a
                                href="{{ $advertisement->advertisable_url }}"
                                class="btn-view-property">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                View Full Property Details
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            </a>

                            <button class="btn-save-property" title="Save property" id="saveBtn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                </svg>
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        @endif

        {{-- Video --}}
        {{-- Video --}}
        @if ($advertisement->video_path)
        @php
        $videoPath = $advertisement->video_path;

        // Extract YouTube video ID from any common URL format
        $youtubeId = null;
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $videoPath, $ytMatch)) {
        $youtubeId = $ytMatch[1];
        }

        $posterUrl = !empty($advertisement->images) ? asset($advertisement->images[0]) : null;
        @endphp
        <div class="card">
            <div class="card__head">
                <div class="card__icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="23 7 16 12 23 17 23 7" />
                        <rect x="1" y="5" width="15" height="14" rx="2" />
                    </svg>
                </div>
                <h2 class="card__title">Video Tour</h2>
            </div>
            <div class="card__body">
                @if ($youtubeId)
                <iframe
                    class="ad-video"
                    src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=1&mute=1&rel=0&modestbranding=1"
                    title="{{ $advertisement->title }} — Video Tour"
                    frameborder="0"
                    allow="autoplay; encrypted-media; picture-in-picture"
                    allowfullscreen
                    loading="lazy">
                </iframe>
                @else
                <video class="ad-video" controls autoplay muted preload="auto"
                    poster="{{ $posterUrl ?? '' }}">
                    <source src="{{ Storage::url($videoPath) }}">
                    Your browser does not support the video tag.
                </video>
                @endif
            </div>
        </div>
        @endif

    </div>

    {{-- ── RIGHT: Sidebar ────────────────────────────────── --}}
    <div class="sidebar-sticky">

        {{-- Contact card --}}
        <div class="contact-card-design">
            <div class="contact-card__head">
                <div class="contact-card__label">Advertised by</div>
                <div class="contact-card__poster-name">
                    {{ $advertisement->owner_name ?? 'Terra Agent' }}
                </div>
                <div class="contact-card__posted">
                    Listed {{ $advertisement->created_at->format('d M Y') }}
                </div>
            </div>

            <div class="contact-card__body">

                @if ($advertisement->contact_phone)
                <a href="tel:{{ $advertisement->contact_phone }}" class="contact-btn contact-btn--phone">
                    <div class="contact-btn__icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.05 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z" />
                        </svg>
                    </div>
                    <div class="contact-btn__text">
                        {{ $advertisement->contact_phone }}
                        <small>Call advertiser</small>
                    </div>
                </a>
                @endif

                @if ($advertisement->contact_email)
                <a href="mailto:{{ $advertisement->contact_email }}" class="contact-btn contact-btn--email">
                    <div class="contact-btn__icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </div>
                    <div class="contact-btn__text">
                        {{ Str::limit($advertisement->contact_email, 26) }}
                        <small>Send email</small>
                    </div>
                </a>
                @endif

            </div>

            <div class="share-strip">
                <span class="share-strip__label">Share:</span>

                <a href="https://wa.me/?text={{ urlencode($advertisement->title . ' — ' . request()->url()) }}"
                    target="_blank" rel="noopener" class="share-btn" title="Share on WhatsApp">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.109.549 4.09 1.508 5.815L.057 23.776a.5.5 0 0 0 .624.624l5.961-1.451A11.946 11.946 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.946 9.946 0 0 1-5.071-1.385l-.364-.215-3.775.918.934-3.682-.236-.38A9.953 9.953 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                    </svg>
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                    target="_blank" rel="noopener" class="share-btn" title="Share on Facebook">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                    </svg>
                </a>

                <button class="share-btn" id="copyLinkBtn" title="Copy link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Ad details info --}}
        <div class="card" style="margin-top:20px;">
            <div class="card__head">
                <div class="card__icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                </div>
                <h3 class="card__title" style="font-size:17px;">Listing Details</h3>
            </div>
            <div class="card__body">
                <div class="info-list">
                    @if ($advertisement->advertisable_type_label)
                    <div class="info-row">
                        <span class="info-row__label">Category</span>
                        <span class="info-row__value">{{ $advertisement->advertisable_type_label }}</span>
                    </div>
                    @endif
                    @if ($advertisement->location)
                    <div class="info-row">
                        <span class="info-row__label">Location</span>
                        <span class="info-row__value">{{ $advertisement->location }}</span>
                    </div>
                    @endif
                    <div class="info-row">
                        <span class="info-row__label">Posted</span>
                        <span class="info-row__value">{{ $advertisement->created_at->format('d M Y') }}</span>
                    </div>
                    @if ($advertisement->expires_at)
                    <div class="info-row">
                        <span class="info-row__label">Expires</span>
                        <span class="info-row__value">{{ $advertisement->expires_at->format('d M Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ════════════════════════════════════════════════════════
     RELATED ADVERTISEMENTS
═════════════════════════════════════════════════════════ --}}
@if (isset($related) && $related->isNotEmpty())
<section class="related-section">
    <div class="related-section__head">
        <h2 class="related-section__title">Similar Listings</h2>
        <a href="{{ route('advertisements.index') }}" class="related-section__link">
            View all →
        </a>
    </div>

    <div class="related-grid">
        @foreach ($related as $rel)
        <a href="{{ route('advertisements.show', $rel) }}" class="related-card">
            @if(!empty($rel->images) && isset($rel->images[0]))
            <img class="related-card__img" src="{{ asset($rel->images[0]) }}" alt="{{ $rel->title }}" loading="lazy">
            @else
            <div class="related-card__img" style="background:linear-gradient(135deg,var(--navy),var(--navy-mid));"></div>
            @endif
            <div class="related-card__body">
                <div class="related-card__type">{{ $rel->advertisable_type_label ?? 'Property' }}</div>
                <div class="related-card__title">{{ Str::limit($rel->title, 55) }}</div>
                <div class="related-card__meta">
                    @if ($rel->location)
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    {{ $rel->location }}
                    ·
                    @endif
                    @if ($rel->price_amount)
                    {{ number_format($rel->price_amount) }} {{ $rel->currency ?? 'RWF' }}
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif


<script>
    document.addEventListener('DOMContentLoaded', () => {

        /* ── Gallery ──────────────────────────────────────── */
        const slides = Array.from(document.querySelectorAll('.hero__slide'));
        const thumbs = Array.from(document.querySelectorAll('.hero__thumb'));
        const counter = document.getElementById('heroCounter');
        let current = 0;
        let timer;

        if (slides.length > 1) {
            const go = (n) => {
                slides[current].classList.remove('is-active');
                thumbs[current]?.classList.remove('is-active');
                current = (n + slides.length) % slides.length;
                slides[current].classList.add('is-active');
                thumbs[current]?.classList.add('is-active');
                if (counter) counter.textContent = `${current + 1} / ${slides.length}`;
                clearInterval(timer);
                timer = setInterval(() => go(current + 1), 5500);
            };

            document.getElementById('heroPrev')?.addEventListener('click', () => go(current - 1));
            document.getElementById('heroNext')?.addEventListener('click', () => go(current + 1));
            thumbs.forEach((t, i) => t.addEventListener('click', () => go(i)));
            timer = setInterval(() => go(current + 1), 5500);

            /* swipe support */
            let touchStartX = 0;
            const hero = document.getElementById('adHero');
            hero?.addEventListener('touchstart', e => {
                touchStartX = e.touches[0].clientX;
            }, {
                passive: true
            });
            hero?.addEventListener('touchend', e => {
                const dx = e.changedTouches[0].clientX - touchStartX;
                if (Math.abs(dx) > 50) go(dx < 0 ? current + 1 : current - 1);
            });
        }

        /* ── Save / heart toggle ─────────────────────────── */
        const saveBtn = document.getElementById('saveBtn');
        saveBtn?.addEventListener('click', () => {
            const filled = saveBtn.querySelector('path').getAttribute('fill') === 'var(--gold)';
            saveBtn.querySelector('path').setAttribute('fill', filled ? 'none' : 'var(--gold)');
            saveBtn.querySelector('path').setAttribute('stroke', filled ? 'currentColor' : 'var(--gold)');
            saveBtn.style.borderColor = filled ? '' : 'var(--gold)';
            saveBtn.style.color = filled ? '' : 'var(--gold)';
        });

        /* ── Copy link ───────────────────────────────────── */
        document.getElementById('copyLinkBtn')?.addEventListener('click', () => {
            navigator.clipboard.writeText(window.location.href).then(() => {
                const btn = document.getElementById('copyLinkBtn');
                btn.style.background = 'var(--gold)';
                btn.style.color = '#fff';
                btn.style.border = 'none';
                setTimeout(() => {
                    btn.style.background = '';
                    btn.style.color = '';
                    btn.style.border = '';
                }, 1800);
            });
        });

    });
</script>
@endsection