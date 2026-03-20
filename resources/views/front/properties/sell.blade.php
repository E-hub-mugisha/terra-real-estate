@extends('layouts.guest')
@section('title', 'List Your Property')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

:root {
    --bg:       #F7F5F2;
    --surface:  #FFFFFF;
    --dark:     #19265d;
    --border:   rgba(0,0,0,.08);
    --border2:  rgba(0,0,0,.14);
    --gold:     #C8873A;
    --gold-lt:  #E5A55E;
    --gold-bg:  rgba(200,135,58,.07);
    --gold-bd:  rgba(200,135,58,.22);
    --text:     #19265d;
    --muted:    #6B6560;
    --dim:      #9E9890;
    --green:    #1E7A5A;
    --r:        14px;
    --t:        .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; }
a { text-decoration: none; color: inherit; }

/* ══════════════════════════
   HERO BANNER
══════════════════════════ */
.sp-hero {
    background: var(--dark);
    position: relative;
    overflow: hidden;
    padding: 80px 0 72px;
    text-align: center;
}
.sp-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 60% 50% at 50% 0%, rgba(200,135,58,.15) 0%, transparent 65%),
        radial-gradient(ellipse 40% 60% at 15% 80%, rgba(200,135,58,.06) 0%, transparent 55%);
    pointer-events: none;
}
.sp-hero::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px);
    pointer-events: none;
}
.sp-hero .container { position: relative; z-index: 2; }

.sp-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .7rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold-lt); margin-bottom: 16px;
}
.sp-eyebrow::before, .sp-eyebrow::after {
    content: ''; width: 20px; height: 1px; background: var(--gold); opacity: .6;
}
.sp-hero h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.2rem, 5vw, 3.8rem);
    font-weight: 500; line-height: 1.1;
    letter-spacing: -.02em; color: #F0EDE8;
    margin-bottom: 16px;
}
.sp-hero h1 em { font-style: italic; color: var(--gold-lt); }
.sp-hero p {
    font-size: .92rem; color: rgba(240,237,232,.5);
    max-width: 520px; margin: 0 auto; line-height: 1.75;
}

/* Steps bar */
.sp-steps {
    display: flex; align-items: center; justify-content: center;
    gap: 0; margin-top: 40px; flex-wrap: wrap;
}
.sp-step {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 18px;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1);
}
.sp-step:first-child { border-radius: 10px 0 0 10px; }
.sp-step:last-child  { border-radius: 0 10px 10px 0; border-left: none; }
.sp-step:not(:first-child):not(:last-child) { border-left: none; }
.sp-step-num {
    width: 24px; height: 24px; border-radius: 50%;
    background: var(--gold); display: grid; place-items: center;
    font-size: .68rem; font-weight: 700; color: #fff; flex-shrink: 0;
}
.sp-step-text { font-size: .75rem; color: rgba(240,237,232,.6); }
.sp-step-text strong { color: #F0EDE8; font-weight: 500; display: block; }
@media (max-width: 640px) {
    .sp-step { border-radius: 8px !important; border: 1px solid rgba(255,255,255,.1) !important; margin: 3px; }
}

/* ══════════════════════════
   LISTING TYPES SECTION
══════════════════════════ */
.sp-cards-section { padding: 72px 0 80px; }

.sp-section-head { text-align: center; margin-bottom: 52px; }
.sp-section-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .7rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 10px;
}
.sp-section-eyebrow::before, .sp-section-eyebrow::after {
    content: ''; width: 18px; height: 1px; background: var(--gold); opacity: .5;
}
.sp-section-head h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 500; letter-spacing: -.02em; color: var(--text);
}
.sp-section-head h2 em { font-style: italic; color: var(--gold); }
.sp-section-head p { font-size: .86rem; color: var(--muted); margin-top: 8px; }

/* Cards grid */
.sp-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
@media (max-width: 900px) { .sp-cards { grid-template-columns: 1fr; max-width: 520px; margin: 0 auto; } }

/* ── Listing Card ── */
.sp-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    display: flex; flex-direction: column;
    transition: transform var(--t), border-color var(--t), box-shadow var(--t);
}
.sp-card:hover {
    transform: translateY(-6px);
    border-color: var(--gold-bd);
    box-shadow: 0 16px 40px rgba(0,0,0,.1), 0 0 0 1px rgba(200,135,58,.1);
}

/* Card image strip */
.sp-card-img {
    height: 180px;
    position: relative; overflow: hidden;
    background: var(--dark);
}
.sp-card-img img {
    width: 100%; height: 100%;
    object-fit: cover; opacity: .6;
    transition: transform .5s ease, opacity .4s ease;
}
.sp-card:hover .sp-card-img img { transform: scale(1.06); opacity: .75; }
.sp-card-img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, transparent 30%, rgba(14,14,12,.7) 100%);
}
.sp-card-badge {
    position: absolute; top: 14px; left: 14px;
    padding: 4px 10px; border-radius: 6px;
    font-size: .66rem; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
    color: #fff; z-index: 2;
}
.badge-house  { background: rgba(59,138,110,.85); }
.badge-land   { background: rgba(139,105,20,.85); }
.badge-design { background: rgba(90,59,138,.85); }

/* Card body */
.sp-card-body { padding: 22px 22px 0; flex: 1; }
.sp-card-icon {
    width: 44px; height: 44px; border-radius: 11px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: grid; place-items: center; margin-bottom: 14px;
}
.sp-card-icon svg { width: 20px; height: 20px; color: var(--gold); }
.sp-card-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.25rem; font-weight: 600; letter-spacing: -.01em;
    color: var(--text); margin-bottom: 8px;
}
.sp-card-desc {
    font-size: .82rem; color: var(--muted); line-height: 1.7; margin-bottom: 16px;
}

/* Feature list */
.sp-card-features {
    list-style: none; padding: 0; margin: 0 0 20px;
    display: flex; flex-direction: column; gap: 7px;
    padding-top: 16px; border-top: 1px solid var(--border);
}
.sp-card-feature {
    display: flex; align-items: flex-start; gap: 8px;
    font-size: .79rem; color: var(--muted); line-height: 1.45;
}
.sp-feat-dot {
    width: 16px; height: 16px; border-radius: 50%;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: grid; place-items: center; flex-shrink: 0; margin-top: 1px;
}
.sp-feat-dot svg { width: 9px; height: 9px; color: var(--gold); }

/* Card CTA */
.sp-card-cta {
    padding: 16px 22px 22px;
}
.sp-cta-btn {
    display: flex; align-items: center; justify-content: space-between;
    padding: 13px 18px; border-radius: 10px;
    background: var(--gold-bg); border: 1.5px solid var(--gold-bd);
    color: var(--gold); font-size: .86rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    transition: all var(--t); cursor: pointer; width: 100%;
    text-decoration: none;
}
.sp-cta-btn:hover {
    background: var(--gold); border-color: var(--gold); color: #fff;
}
.sp-cta-btn .cta-right {
    display: flex; align-items: center; gap: 6px; font-size: .75rem; opacity: .7;
}
.sp-cta-btn:hover .cta-right { opacity: 1; }
.sp-cta-btn svg { width: 15px; height: 15px; transition: transform var(--t); }
.sp-cta-btn:hover svg { transform: translateX(4px); }

/* ══════════════════════════
   HOW IT WORKS
══════════════════════════ */
.sp-how { background: var(--surface); padding: 72px 0; }
.sp-how-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    margin-top: 48px;
}
@media (max-width: 860px) { .sp-how-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 480px) { .sp-how-grid { grid-template-columns: 1fr; } }

.sp-how-item { text-align: center; padding: 8px; }
.sp-how-num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 3rem; font-weight: 600; color: var(--gold-bd);
    line-height: 1; margin-bottom: 14px; letter-spacing: -.04em;
}
.sp-how-icon {
    width: 52px; height: 52px; border-radius: 13px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: grid; place-items: center; margin: 0 auto 14px;
}
.sp-how-icon svg { width: 22px; height: 22px; color: var(--gold); }
.sp-how-title { font-size: .92rem; font-weight: 600; color: var(--text); margin-bottom: 6px; }
.sp-how-desc  { font-size: .78rem; color: var(--muted); line-height: 1.65; }

/* ══════════════════════════
   FAQ / NOTICE STRIP
══════════════════════════ */
.sp-notice {
    background: var(--dark);
    position: relative; overflow: hidden;
    padding: 52px 0;
}
.sp-notice::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 50% 60% at 80% 50%, rgba(200,135,58,.1) 0%, transparent 65%);
    pointer-events: none;
}
.sp-notice-inner {
    position: relative; z-index: 2;
    display: flex; align-items: center; justify-content: space-between;
    gap: 32px; flex-wrap: wrap;
}
.sp-notice-text h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem; font-weight: 500; color: #F0EDE8;
    letter-spacing: -.01em; margin-bottom: 6px;
}
.sp-notice-text h3 em { font-style: italic; color: var(--gold-lt); }
.sp-notice-text p { font-size: .83rem; color: rgba(240,237,232,.45); line-height: 1.7; }
.sp-notice-pills { display: flex; gap: 8px; flex-wrap: wrap; flex-shrink: 0; }
.sp-notice-pill {
    display: flex; align-items: center; gap: 7px;
    padding: 9px 16px; border-radius: 9px;
    background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.12);
    font-size: .78rem; color: rgba(240,237,232,.7);
    transition: background var(--t);
}
.sp-notice-pill:hover { background: rgba(255,255,255,.13); }
.sp-notice-pill svg { width: 14px; height: 14px; color: var(--gold); flex-shrink: 0; }

/* ── Animation ── */
@keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
.fu  { animation: fadeUp .45s ease both; }
.fu2 { animation: fadeUp .45s ease .1s both; }
.fu3 { animation: fadeUp .45s ease .2s both; }
</style>

{{-- ══ HERO ══ --}}
<section class="sp-hero">
    <div class="container">
        <div class="sp-eyebrow">Terra Marketplace</div>
        <h1>List your property,<br><em>reach more buyers</em></h1>
        <p>Whether you're selling a house, a plot of land, or an architectural design — Terra connects you with thousands of verified buyers across Rwanda.</p>

        <div class="sp-steps">
            <div class="sp-step">
                <div class="sp-step-num">1</div>
                <div class="sp-step-text"><strong>Choose type</strong>House, Land or Design</div>
            </div>
            <div class="sp-step">
                <div class="sp-step-num">2</div>
                <div class="sp-step-text"><strong>Fill details</strong>Photos, price &amp; info</div>
            </div>
            <div class="sp-step">
                <div class="sp-step-num">3</div>
                <div class="sp-step-text"><strong>Get reviewed</strong>We verify your listing</div>
            </div>
            <div class="sp-step">
                <div class="sp-step-num">4</div>
                <div class="sp-step-text"><strong>Go live</strong>Buyers see your property</div>
            </div>
        </div>
    </div>
</section>

{{-- ══ LISTING TYPE CARDS ══ --}}
<section class="sp-cards-section">
    <div class="container">
        <div class="sp-section-head">
            <div class="sp-section-eyebrow">What are you listing?</div>
            <h2>Choose your <em>listing type</em></h2>
            <p>Select the category that best describes your property and we'll guide you through the rest.</p>
        </div>

        <div class="sp-cards">

            {{-- ── HOUSE ── --}}
            <div class="sp-card fu">
                <div class="sp-card-img">
                    <img src="{{ asset('front/assets/img/all-images/hero/image-1.png') }}" alt="House listing">
                    <div class="sp-card-img-overlay"></div>
                    <span class="sp-card-badge badge-house">House</span>
                </div>
                <div class="sp-card-body">
                    <div class="sp-card-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                    </div>
                    <h3 class="sp-card-title">Sell or Rent a House</h3>
                    <p class="sp-card-desc">List your residential property — from apartments to villas. Reach thousands of buyers and renters searching across Rwanda.</p>
                    <ul class="sp-card-features">
                        <li class="sp-card-feature">
                            <div class="sp-feat-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                            Upload multiple property photos
                        </li>
                        <li class="sp-card-feature">
                            <div class="sp-feat-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                            Set bedrooms, bathrooms &amp; amenities
                        </li>
                        <li class="sp-card-feature">
                            <div class="sp-feat-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                            Choose For Sale or For Rent
                        </li>
                        <li class="sp-card-feature">
                            <div class="sp-feat-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                            Verified listing badge after review
                        </li>
                    </ul>
                </div>
                <div class="sp-card-cta">
                    <a href="{{ route('front.add.property.house') }}" class="sp-cta-btn">
                        List a House
                        <span class="cta-right">
                            Get started
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </span>
                    </a>
                </div>
            </div>

            {{-- ── LAND ── --}}
            <div class="sp-card fu2">
                <div class="sp-card-img">
                    <img src="{{ asset('front/assets/img/all-images/hero/plot.png') }}" alt="Land listing">
                    <div class="sp-card-img-overlay"></div>
                    <span class="sp-card-badge badge-land">Land</span>
                </div>
                <div class="sp-card-body">
                    <div class="sp-card-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z"/></svg>
                    </div>
                    <h3 class="sp-card-title">Sell a Plot of Land</h3>
                    <p class="sp-card-desc">List your land with UPI verification, zoning classification, and full location details. Serious buyers browse our verified plots daily.</p>
                    <ul class="sp-card-features">
                        <li class="sp-card-feature">
                            <div class="sp-feat-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                            Enter UPI &amp; upload title document
                        </li>
                        <li class="sp-card-feature">
                            <div class="sp-feat-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                            Select zoning (R1, R2, Commercial…)
                        </li>
                        <li class="sp-card-feature">
                            <div class="sp-feat-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                            Province → Village location cascade
                        </li>
                        <li class="sp-card-feature">
                            <div class="sp-feat-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                            Ownership verified before going live
                        </li>
                    </ul>
                </div>
                <div class="sp-card-cta">
                    <a href="{{ route('front.add.property.land') }}" class="sp-cta-btn">
                        List a Plot
                        <span class="cta-right">
                            Get started
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </span>
                    </a>
                </div>
            </div>

            {{-- ── DESIGN ── --}}
            <div class="sp-card fu3">
                <div class="sp-card-img">
                    <img src="{{ asset('front/assets/img/all-images/hero/consultant.png') }}" alt="Design listing">
                    <div class="sp-card-img-overlay"></div>
                    <span class="sp-card-badge badge-design">Design</span>
                </div>
                <div class="sp-card-body">
                    <div class="sp-card-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                    </div>
                    <h3 class="sp-card-title">Sell an Architectural Design</h3>
                    <p class="sp-card-desc">Monetise your architectural drawings and floor plans. Upload PDF, DWG or ZIP files and sell or share them for free on the Terra marketplace.</p>
                    <ul class="sp-card-features">
                        <li class="sp-card-feature">
                            <div class="sp-feat-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                            Upload PDF, DWG, DXF or ZIP files
                        </li>
                        <li class="sp-card-feature">
                            <div class="sp-feat-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                            Set paid price or offer for free
                        </li>
                        <li class="sp-card-feature">
                            <div class="sp-feat-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                            Add a preview thumbnail image
                        </li>
                        <li class="sp-card-feature">
                            <div class="sp-feat-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                            Featured listing option available
                        </li>
                    </ul>
                </div>
                <div class="sp-card-cta">
                    <a href="{{ route('front.add.property.arch') }}" class="sp-cta-btn">
                        List a Design
                        <span class="cta-right">
                            Get started
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══ HOW IT WORKS ══ --}}
<section class="sp-how">
    <div class="container">
        <div class="sp-section-head">
            <div class="sp-section-eyebrow">The Process</div>
            <h2>How <em>listing works</em></h2>
            <p>From submission to live listing in as little as 24 hours.</p>
        </div>
        <div class="sp-how-grid">
            <div class="sp-how-item">
                <div class="sp-how-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/><path d="M14 2v6h6M12 11v6M9 14l3-3 3 3"/></svg>
                </div>
                <div class="sp-how-title">Submit your listing</div>
                <p class="sp-how-desc">Fill in property details, upload photos, set your price and submit through our guided form.</p>
            </div>
            <div class="sp-how-item">
                <div class="sp-how-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="sp-how-title">We verify it</div>
                <p class="sp-how-desc">Our team reviews all listings within 24 hours to ensure accuracy and legal compliance.</p>
            </div>
            <div class="sp-how-item">
                <div class="sp-how-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/></svg>
                </div>
                <div class="sp-how-title">Listing goes live</div>
                <p class="sp-how-desc">Once approved, your property appears on the Terra marketplace and search results.</p>
            </div>
            <div class="sp-how-item">
                <div class="sp-how-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                </div>
                <div class="sp-how-title">Buyers contact you</div>
                <p class="sp-how-desc">Interested buyers send enquiries directly to you. No middlemen, no hidden fees.</p>
            </div>
        </div>
    </div>
</section>

{{-- ══ NOTICE STRIP ══ --}}
<section class="sp-notice">
    <div class="container">
        <div class="sp-notice-inner">
            <div class="sp-notice-text">
                <h3>Need help <em>getting started?</em></h3>
                <p>Our team is available Monday to Friday, 9am – 6pm to assist you with your listing.</p>
            </div>
            <div class="sp-notice-pills">
                <a href="https://wa.me/250782390919" target="_blank" class="sp-notice-pill">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/><path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z"/></svg>
                    WhatsApp Us
                </a>
                <a href="tel:+250782390919" class="sp-notice-pill">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
                    Call Us
                </a>
                <a href="{{ route('front.our.services') }}" class="sp-notice-pill">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    View All Services
                </a>
            </div>
        </div>
    </div>
</section>

@endsection