@extends('layouts.guest')
@section('title', $consultant->name)


<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    /* ─── CSS Variables ──────────────────────────────── */
    :root {
        --ink: #0e1117;
        --ink-soft: #3a3f4b;
        --muted: #7a8090;
        --border: #e4e6eb;
        --surface: #f7f8fa;
        --white: #ffffff;
        --gold: #c9a44a;
        --gold-pale: #f5ead0;
        --green: #1a7a4a;
        --green-bg: #ecf7f1;
        --radius-sm: 8px;
        --radius-md: 16px;
        --radius-lg: 24px;
        --shadow-sm: 0 2px 8px rgba(14, 17, 23, .06);
        --shadow-md: 0 8px 32px rgba(14, 17, 23, .10);
        --shadow-lg: 0 20px 60px rgba(14, 17, 23, .14);
        --transition: 0.28s cubic-bezier(.4, 0, .2, 1);
    }

    body {
        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
        background: var(--surface);
    }

    /* ─── Hero Band ──────────────────────────────────── */
    .c-hero-band {
        /* background: var(--ink); */
        height: 120px;
        position: relative;
        overflow: hidden;
    }

    .c-hero-band::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 70% 120% at 80% -20%, rgba(201, 164, 74, .18) 0%, transparent 60%),
            radial-gradient(ellipse 40% 80% at 10% 110%, rgba(201, 164, 74, .10) 0%, transparent 55%);
    }

    .c-hero-band::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        background: linear-gradient(to bottom, transparent, var(--surface));
    }

    .c-deco-lines {
        position: absolute;
        inset: 0;
        overflow: hidden;
        opacity: .07;
    }

    .c-deco-lines span {
        display: block;
        position: absolute;
        height: 1px;
        background: var(--gold);
    }

    .c-deco-lines span:nth-child(1) {
        width: 45%;
        top: 30%;
        left: -5%;
        transform: rotate(-8deg);
    }

    .c-deco-lines span:nth-child(2) {
        width: 30%;
        top: 55%;
        left: 60%;
        transform: rotate(-8deg);
    }

    .c-deco-lines span:nth-child(3) {
        width: 20%;
        top: 70%;
        left: 20%;
        transform: rotate(-8deg);
    }

    /* ─── Layout ─────────────────────────────────────── */
    .c-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 20px 80px;
    }

    .c-grid {
        display: grid;
        grid-template-columns: 310px 1fr;
        gap: 24px;
        align-items: start;
        margin-top: -80px;
        position: relative;
        z-index: 2;
    }

    @media (max-width: 860px) {
        .c-grid {
            grid-template-columns: 1fr;
            margin-top: -80px;
        }
    }

    /* ─── Profile Card ───────────────────────────────── */
    .c-profile-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        padding: 32px 24px;
        text-align: center;
        animation: fadeUp .55s ease both;
    }

    .c-avatar-wrap {
        display: inline-block;
        position: relative;
        margin-bottom: 16px;
    }

    .c-avatar-wrap img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--white);
        box-shadow: 0 4px 24px rgba(0, 0, 0, .18);
        display: block;
    }

    .c-avatar-ring {
        position: absolute;
        inset: -7px;
        border-radius: 50%;
        border: 2px solid var(--gold);
        opacity: .5;
        animation: pulse-ring 3s ease-in-out infinite;
    }

    @keyframes pulse-ring {

        0%,
        100% {
            transform: scale(1);
            opacity: .5;
        }

        50% {
            transform: scale(1.06);
            opacity: .2;
        }
    }

    .c-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.7rem;
        font-weight: 600;
        letter-spacing: -.02em;
        margin: 0 0 4px;
        line-height: 1.2;
    }

    .c-role {
        font-size: .72rem;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--muted);
        font-weight: 500;
    }

    .c-verified-dot {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        font-size: .65rem;
        font-weight: 700;
        color: var(--green);
        background: var(--green-bg);
        padding: 2px 8px;
        border-radius: 50px;
        vertical-align: middle;
        font-family: 'DM Sans', sans-serif;
        letter-spacing: .04em;
    }

    .c-badge-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
        margin: 14px 0;
    }

    .c-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: .74rem;
        font-weight: 600;
    }

    .c-badge--gold {
        background: var(--gold-pale);
        color: #7a5a10;
    }

    .c-divider {
        border: none;
        border-top: 1px solid var(--border);
        margin: 18px 0;
    }

    .c-lang-label {
        font-size: .7rem;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 8px;
        font-weight: 600;
    }

    .c-lang-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: center;
    }

    .c-lang-chip {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 50px;
        padding: 3px 12px;
        font-size: .75rem;
        color: var(--ink-soft);
    }

    /* ─── CTA Buttons ────────────────────────────────── */
    .c-cta-stack {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
    }

    .c-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 20px;
        border-radius: var(--radius-sm);
        font-size: .85rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: var(--transition);
        letter-spacing: .01em;
        font-family: 'DM Sans', sans-serif;
    }

    .c-btn--outline {
        background: transparent;
        border: 1.5px solid var(--border);
        color: var(--ink-soft);
    }

    .c-btn--outline:hover {
        border-color: var(--ink);
        color: var(--ink);
        background: var(--surface);
    }

    .c-btn--whatsapp {
        background: #25D366;
        color: #fff;
    }

    .c-btn--whatsapp:hover {
        background: #1ebe5d;
        color: #fff;
    }

    .c-btn--gold {
        background: var(--gold);
        color: var(--ink);
        font-weight: 700;
    }

    .c-btn--gold:hover {
        background: #b8922e;
    }

    .c-btn--ghost {
        background: transparent;
        color: var(--muted);
    }

    /* ─── Detail Panel ───────────────────────────────── */
    .c-detail-panel {
        display: flex;
        flex-direction: column;
        gap: 20px;
        animation: fadeUp .55s .1s ease both;
    }

    .c-section {
        background: var(--white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        padding: 26px 28px;
        transition: box-shadow var(--transition);
    }

    .c-section:hover {
        box-shadow: var(--shadow-md);
    }

    .c-section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.2rem;
        font-weight: 600;
        letter-spacing: -.01em;
        margin: 0 0 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .c-section-title .icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: var(--gold-pale);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .95rem;
        flex-shrink: 0;
    }

    .c-bio {
        font-size: .9rem;
        line-height: 1.85;
        color: var(--ink-soft);
        margin: 0;
    }

    /* ─── Contact Grid ───────────────────────────────── */
    .c-contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media (max-width: 500px) {
        .c-contact-grid {
            grid-template-columns: 1fr;
        }
    }

    .c-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px;
        border-radius: var(--radius-sm);
        background: var(--surface);
        transition: background var(--transition);
    }

    .c-contact-item:hover {
        background: var(--gold-pale);
    }

    .ci-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
        box-shadow: var(--shadow-sm);
    }

    .ci-label {
        font-size: .68rem;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
        font-weight: 600;
        margin-bottom: 3px;
    }

    .ci-value {
        font-size: .85rem;
        color: var(--ink);
        font-weight: 500;
        word-break: break-all;
    }

    /* ─── Social ─────────────────────────────────────── */
    .c-social-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .c-social-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: .8rem;
        font-weight: 600;
        text-decoration: none;
        border: 1.5px solid var(--border);
        color: var(--ink-soft);
        transition: var(--transition);
    }

    .c-social-btn:hover {
        border-color: var(--gold);
        color: var(--ink);
        background: var(--gold-pale);
    }

    /* ─── Reviews ────────────────────────────────────── */
    .c-rating-hero {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
        padding: 16px;
        background: var(--surface);
        border-radius: var(--radius-sm);
    }

    .c-rating-hero .big-score {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.8rem;
        font-weight: 600;
        line-height: 1;
    }

    .c-rating-hero .stars {
        font-size: 1.1rem;
        color: var(--gold);
        letter-spacing: 2px;
        margin-bottom: 4px;
    }

    .c-rating-hero .count {
        font-size: .8rem;
        color: var(--muted);
    }

    .c-review-card {
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 16px 18px;
        margin-bottom: 12px;
        transition: border-color var(--transition), box-shadow var(--transition);
    }

    .c-review-card:last-child {
        margin-bottom: 0;
    }

    .c-review-card:hover {
        border-color: var(--gold);
        box-shadow: 0 4px 16px rgba(201, 164, 74, .10);
    }

    .c-review-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .c-reviewer-name {
        font-weight: 600;
        font-size: .88rem;
    }

    .c-review-stars {
        color: var(--gold);
        font-size: .88rem;
    }

    .c-review-text {
        font-size: .85rem;
        color: var(--ink-soft);
        line-height: 1.65;
        margin: 0;
    }

    /* ─── Map ────────────────────────────────────────── */
    .c-map-wrap {
        border-radius: var(--radius-sm);
        overflow: hidden;
        border: 1px solid var(--border);
    }

    .c-map-wrap iframe {
        display: block;
    }

    /* ─── Bottom row ─────────────────────────────────── */
    .c-bottom-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-top: 24px;
    }

    @media (max-width: 768px) {
        .c-bottom-row {
            grid-template-columns: 1fr;
        }
    }

    /* ─── Modal ──────────────────────────────────────── */
    .c-modal .modal-content {
        border: none;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    .c-modal .modal-header {
        background: var(--ink);
        color: var(--white);
        padding: 20px 24px;
        border-bottom: none;
    }

    .c-modal .modal-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.3rem;
        font-weight: 600;
    }

    .c-modal .btn-close {
        filter: invert(1);
        opacity: .7;
    }

    .c-modal .modal-body {
        padding: 24px;
    }

    .c-modal .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        justify-content: space-between;
    }

    .c-input {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif;
        font-size: .88rem;
        color: var(--ink);
        background: var(--surface);
        transition: border-color var(--transition), box-shadow var(--transition);
        outline: none;
    }

    .c-input:focus {
        border-color: var(--gold);
        background: var(--white);
        box-shadow: 0 0 0 3px rgba(201, 164, 74, .12);
    }

    .c-input::placeholder {
        color: var(--muted);
    }

    .c-label {
        display: block;
        font-size: .7rem;
        letter-spacing: .08em;
        text-transform: uppercase;
        font-weight: 600;
        color: var(--muted);
        margin-bottom: 5px;
    }

    .c-field {
        margin-bottom: 14px;
    }

    .c-field:last-child {
        margin-bottom: 0;
    }

    .c-input-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    /* ─── Animations ─────────────────────────────────── */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
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

    .view-chip svg { width: 14px; height: 14px; opacity: .7; }
</style>

@section('content')

{{-- ─── Hero Band ─────────────────────────────────── --}}
<div class="c-hero-band">
    <div class="c-deco-lines">
        <span></span><span></span><span></span>
    </div>
</div>

<div class="c-page">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom:16px;">
        ✅ {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    {{-- ─── Two-column grid ────────────────────────── --}}
    <div class="c-grid">

        {{-- ══ LEFT: Profile Card ══ --}}
        <aside class="c-profile-card">

            <div class="c-avatar-wrap">
                <div class="c-avatar-ring"></div>
                <img
                    src="{{ $consultant->photo
        ? asset('image/consultant/' . $consultant->photo)
        : asset('front/assets/img/avatar.png') }}"
                    alt="{{ $consultant->name }}">
            </div>

            <h1 class="c-name">
                {{ $consultant->name }}
                @if($consultant->is_verified)
                <span class="c-verified-dot">✓ Verified</span>
                @endif
            </h1>
            <p class="c-role">{{ $consultant->role ?? 'Real Estate Consultant' }}</p>

            <div class="c-badge-row">
                <span class="c-badge c-badge--gold">
                    ★ {{ $consultant->years_experience }}+ yrs experience
                </span>

            </div>
            {{-- ── View count (total, human-formatted) ── --}}
            @if($consultant->views_count > 0)
            <span class="view-chip">
                {{-- Eye icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                </svg>
                {{ number_format($consultant->views_count) }} {{ Str::plural('view', $consultant->views_count) }}
            </span>
            @endif
            @if($consultant->languages)
            <hr class="c-divider">
            <p class="c-lang-label">Languages</p>
            <div class="c-lang-chips">
                @foreach(explode(',', $consultant->languages) as $lang)
                <span class="c-lang-chip">{{ trim($lang) }}</span>
                @endforeach
            </div>
            @endif

            <div class="c-cta-stack">
                <a href="tel:{{ $consultant->phone }}" class="c-btn c-btn--outline">
                    📞 Call Consultant
                </a>
                @if($consultant->whatsapp)
                <a href="https://wa.me/{{ $consultant->whatsapp }}" target="_blank" class="c-btn c-btn--whatsapp">
                    💬 WhatsApp
                </a>
                @endif
                <button class="c-btn c-btn--gold" data-bs-toggle="modal" data-bs-target="#appointmentModal">
                    📆 Book Appointment
                </button>
            </div>

        </aside>

        {{-- ══ RIGHT: Details ══ --}}
        <div class="c-detail-panel">

            {{-- About --}}
            <div class="c-section">
                <h2 class="c-section-title">
                    <span class="icon">✦</span> About {{ $consultant->name }}
                </h2>
                <p class="c-bio">{{ $consultant->bio ?? 'No biography provided.' }}</p>
            </div>

            {{-- Contact Info --}}
            <div class="c-section">
                <h2 class="c-section-title">
                    <span class="icon">📋</span> Contact Information
                </h2>
                <div class="c-contact-grid">
                    <div class="c-contact-item">
                        <div class="ci-icon">✉️</div>
                        <div>
                            <div class="ci-label">Email</div>
                            <div class="ci-value">{{ $consultant->email }}</div>
                        </div>
                    </div>
                    <div class="c-contact-item">
                        <div class="ci-icon">📱</div>
                        <div>
                            <div class="ci-label">Phone</div>
                            <div class="ci-value">{{ $consultant->phone }}</div>
                        </div>
                    </div>
                    @if($consultant->office_location)
                    <div class="c-contact-item" style="grid-column: 1 / -1;">
                        <div class="ci-icon">📍</div>
                        <div>
                            <div class="ci-label">Office Location</div>
                            <div class="ci-value">{{ $consultant->office_location }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Social Links --}}
            @if($consultant->linkedin || $consultant->facebook || $consultant->instagram || $consultant->twitter)
            <div class="c-section">
                <h2 class="c-section-title">
                    <span class="icon">🔗</span> Connect
                </h2>
                <div class="c-social-row">
                    @if($consultant->linkedin)
                    <a href="{{ $consultant->linkedin }}" target="_blank" class="c-social-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                        LinkedIn
                    </a>
                    @endif
                    @if($consultant->facebook)
                    <a href="{{ $consultant->facebook }}" target="_blank" class="c-social-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        Facebook
                    </a>
                    @endif
                    @if($consultant->instagram)
                    <a href="{{ $consultant->instagram }}" target="_blank" class="c-social-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                        </svg>
                        Instagram
                    </a>
                    @endif
                    @if($consultant->twitter)
                    <a href="{{ $consultant->twitter }}" target="_blank" class="c-social-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.261 5.636 5.903-5.636zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                        Twitter / X
                    </a>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- ─── Reviews + Map (bottom two-col) ────────── --}}
    <div class="c-bottom-row">

        {{-- Reviews --}}
        <div class="c-section">
            <h2 class="c-section-title">
                <span class="icon">⭐</span> Client Reviews
            </h2>

            <div class="c-rating-hero">
                <div class="big-score">{{ number_format($averageRating, 1) }}</div>
                <div>
                    <div class="stars">
                        @for($i=1;$i<=5;$i++){{ $i <= round($averageRating) ? '★' : '☆' }}@endfor
                            </div>
                            <div class="count">{{ $reviews->count() }} {{ Str::plural('review', $reviews->count()) }}</div>
                    </div>
                </div>

                @forelse($reviews as $review)
                <div class="c-review-card">
                    <div class="c-review-header">
                        <span class="c-reviewer-name">{{ $review->user->name ?? 'Anonymous' }}</span>
                        <span class="c-review-stars">
                            @for($i=1;$i<=5;$i++){{ $i <= $review->rating ? '★' : '☆' }}@endfor
                                </span>
                    </div>
                    <p class="c-review-text">{{ $review->comment }}</p>
                </div>
                @empty
                <p style="color:var(--muted);font-size:.88rem;margin:0;">No reviews yet.</p>
                @endforelse
            </div>

            {{-- Map --}}
            <div class="c-section">
                <h2 class="c-section-title">
                    <span class="icon">📍</span> Office Location
                </h2>
                @if($consultant->office_location)
                <div class="c-map-wrap">
                    <iframe
                        width="100%"
                        height="340"
                        frameborder="0"
                        style="border:0"
                        loading="lazy"
                        allowfullscreen
                        src="https://www.google.com/maps?q={{ urlencode($consultant->office_location) }}&output=embed">
                    </iframe>
                </div>
                @else
                <p style="color:var(--muted);font-size:.88rem;margin:0;">No office location provided.</p>
                @endif
            </div>

        </div>
    </div>

    {{-- ─── Appointment Modal ───────────────────────── --}}
    <div class="modal fade c-modal" id="appointmentModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('front.consultants.appointment', $consultant) }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Book an Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="c-input-row" style="margin-bottom:14px;">
                        <div class="c-field">
                            <label class="c-label">Your Name</label>
                            <input class="c-input" name="name" placeholder="Full name" required>
                        </div>
                        <div class="c-field">
                            <label class="c-label">Email</label>
                            <input class="c-input" name="email" type="email" placeholder="you@email.com" required>
                        </div>
                    </div>
                    <div class="c-input-row" style="margin-bottom:14px;">
                        <div class="c-field">
                            <label class="c-label">Preferred Date</label>
                            <input class="c-input" name="date" type="date" required style="margin-bottom:0">
                        </div>
                        <div class="c-field">
                            <label class="c-label">Preferred Time</label>
                            <input class="c-input" name="time" type="time" required style="margin-bottom:0">
                        </div>
                    </div>
                    <div class="c-field" style="margin-bottom:0">
                        <label class="c-label">Message (optional)</label>
                        <textarea class="c-input" name="message" rows="3" placeholder="Describe what you're looking for…" style="resize:vertical;margin-bottom:0"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="c-btn c-btn--outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="c-btn c-btn--gold">Confirm Booking →</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection