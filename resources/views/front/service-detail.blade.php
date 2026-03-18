@extends('layouts.guest')
@section('title', $category->name)
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
    --text:     #1A1714;
    --muted:    #6B6560;
    --dim:      #9E9890;
    --green:    #1E7A5A;
    --green-bg: rgba(30,122,90,.07);
    --green-bd: rgba(30,122,90,.2);
    --r:        13px;
    --t:        .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; }
a { text-decoration: none; color: inherit; }

/* ══════════════════════════
   BREADCRUMB
══════════════════════════ */
.sc-breadcrumb {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 12px 0;
}
.sc-bc-inner {
    display: flex; align-items: center; gap: 7px;
    font-size: .75rem; color: var(--dim); flex-wrap: wrap;
}
.sc-bc-inner a { color: var(--muted); transition: color var(--t); }
.sc-bc-inner a:hover { color: var(--gold); }
.sc-bc-inner svg { width: 12px; height: 12px; color: var(--dim); }
.sc-bc-inner .cur { color: var(--text); font-weight: 500; }

/* ══════════════════════════
   HERO — CATEGORY HEADER
══════════════════════════ */
.sc-hero {
    background: var(--dark);
    position: relative; overflow: hidden;
    padding: 72px 0 64px;
}
.sc-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 55% 60% at 5%  50%, rgba(200,135,58,.13) 0%, transparent 65%),
        radial-gradient(ellipse 40% 55% at 95% 25%, rgba(200,135,58,.06) 0%, transparent 55%);
    pointer-events: none;
}
.sc-hero::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg,  transparent, transparent 39px, rgba(255,255,255,.018) 39px, rgba(255,255,255,.018) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255,255,255,.012) 79px, rgba(255,255,255,.012) 80px);
    pointer-events: none;
}
.sc-hero .container { position: relative; z-index: 2; }

.sc-hero-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 56px; align-items: center;
}
@media (max-width: 900px) { .sc-hero-layout { grid-template-columns: 1fr; } .sc-hero-imgs { display: none; } }

/* Text side */
.sc-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .7rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold-lt); margin-bottom: 14px;
}
.sc-eyebrow::before { content: ''; width: 18px; height: 1px; background: var(--gold); opacity: .6; }

.sc-hero-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2rem, 5vw, 3.4rem);
    font-weight: 500; line-height: 1.1;
    letter-spacing: -.02em; color: #F0EDE8; margin-bottom: 16px;
}
.sc-hero-title em { font-style: italic; color: var(--gold-lt); }
.sc-hero-desc {
    font-size: .88rem; color: rgba(240,237,232,.45);
    line-height: 1.8; margin-bottom: 28px; max-width: 480px;
}

.sc-hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }
.sc-btn-primary {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 12px 22px; border-radius: 9px;
    background: var(--gold); border: none; color: #fff;
    font-size: .84rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: background var(--t), transform var(--t); text-decoration: none;
}
.sc-btn-primary:hover { background: #a06828; transform: translateY(-1px); color: #fff; }
.sc-btn-primary svg { width: 14px; height: 14px; }
.sc-btn-outline {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 12px 22px; border-radius: 9px;
    background: rgba(255,255,255,.08); color: rgba(240,237,232,.7);
    border: 1px solid rgba(255,255,255,.15);
    font-size: .84rem; font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    transition: all var(--t); text-decoration: none;
}
.sc-btn-outline:hover { background: rgba(255,255,255,.14); color: #F0EDE8; }
.sc-btn-outline svg { width: 14px; height: 14px; }

/* Image mosaic */
.sc-hero-imgs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 200px 160px;
    gap: 8px;
}
.sc-img {
    border-radius: var(--r); overflow: hidden;
    background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08);
}
.sc-img:first-child { grid-row: 1 / 3; }
.sc-img img { width: 100%; height: 100%; object-fit: cover; display: block; opacity: .7; }

/* ══════════════════════════
   SERVICES SECTION
══════════════════════════ */
.sc-services { padding: 72px 0 80px; }

.sc-section-head { margin-bottom: 40px; }
.sc-section-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .68rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 8px;
}
.sc-section-eyebrow::before { content: ''; width: 16px; height: 1px; background: var(--gold); opacity: .5; }
.sc-section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.5rem, 3vw, 2.2rem);
    font-weight: 500; letter-spacing: -.02em; color: var(--text);
}
.sc-section-title em { font-style: italic; color: var(--gold); }
.sc-section-sub { font-size: .85rem; color: var(--muted); margin-top: 6px; line-height: 1.7; }

/* ── Service Card ── */
.sc-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r); padding: 24px 20px 20px;
    display: flex; flex-direction: column;
    height: 100%; position: relative; overflow: hidden;
    transition: transform var(--t), border-color var(--t), box-shadow var(--t);
    animation: scFu .4s ease both;
}
.sc-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, var(--gold) 0%, transparent 100%);
    opacity: 0; transition: opacity var(--t);
}
.sc-card:hover {
    transform: translateY(-5px);
    border-color: var(--gold-bd);
    box-shadow: 0 12px 32px rgba(0,0,0,.08), 0 0 0 1px rgba(200,135,58,.08);
}
.sc-card:hover::before { opacity: 1; }
@keyframes scFu { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }

/* Ghost number */
.sc-card-num {
    position: absolute; top: 14px; right: 16px;
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.6rem; font-weight: 600;
    color: rgba(0,0,0,.04); line-height: 1; letter-spacing: -.04em;
    user-select: none; pointer-events: none;
    transition: color var(--t);
}
.sc-card:hover .sc-card-num { color: rgba(200,135,58,.06); }

/* Icon */
.sc-card-icon {
    width: 44px; height: 44px; border-radius: 11px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 16px; flex-shrink: 0;
    transition: background var(--t), border-color var(--t);
}
.sc-card-icon svg { width: 20px; height: 20px; color: var(--gold); transition: color var(--t); }
.sc-card:hover .sc-card-icon { background: var(--gold); border-color: var(--gold); }
.sc-card:hover .sc-card-icon svg { color: #fff; }

.sc-card-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem; font-weight: 600; letter-spacing: -.01em;
    color: var(--text); margin-bottom: 8px; line-height: 1.25;
}
.sc-card-desc {
    font-size: .81rem; color: var(--muted); line-height: 1.75;
    flex: 1; margin-bottom: 16px;
}

/* Status / meta */
.sc-card-meta {
    display: flex; align-items: center; gap: 10px;
    padding-top: 12px; border-top: 1px solid var(--border);
    margin-top: auto;
}
.sc-card-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 2px 8px; border-radius: 5px;
    font-size: .67rem; font-weight: 700;
    letter-spacing: .05em; text-transform: uppercase;
    background: var(--green-bg); border: 1px solid var(--green-bd); color: var(--green);
}
.sc-card-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: var(--green); }

.sc-card-cta {
    margin-left: auto; display: inline-flex; align-items: center; gap: 4px;
    font-size: .78rem; font-weight: 600; color: var(--gold);
    transition: gap var(--t);
}
.sc-card:hover .sc-card-cta { gap: 8px; }
.sc-card-cta svg { width: 12px; height: 12px; }

/* ── Empty state ── */
.sc-empty {
    text-align: center; padding: 64px 20px;
    color: var(--dim);
}
.sc-empty svg { width: 44px; height: 44px; margin-bottom: 14px; opacity: .3; }
.sc-empty h3 { font-size: .95rem; color: var(--muted); margin-bottom: 6px; }
.sc-empty p  { font-size: .82rem; }

/* ══════════════════════════
   CTA SECTION
══════════════════════════ */
.sc-cta {
    background: var(--dark);
    position: relative; overflow: hidden; padding: 72px 0;
}
.sc-cta::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 60% 50% at 20% 50%, rgba(200,135,58,.14) 0%, transparent 60%),
        radial-gradient(ellipse 40% 60% at 85% 30%, rgba(200,135,58,.07) 0%, transparent 55%);
    pointer-events: none;
}
.sc-cta::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg,  transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px);
    pointer-events: none;
}
.sc-cta .container { position: relative; z-index: 2; }

.sc-cta-inner {
    display: flex; align-items: center; justify-content: space-between;
    gap: 40px; flex-wrap: wrap;
}
.sc-cta-eyebrow {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: .68rem; font-weight: 600; letter-spacing: .12em;
    text-transform: uppercase; color: var(--gold-lt); margin-bottom: 10px;
}
.sc-cta-eyebrow::before { content: ''; width: 16px; height: 1px; background: var(--gold); opacity: .6; }
.sc-cta-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 500; line-height: 1.15;
    letter-spacing: -.02em; color: #F0EDE8;
}
.sc-cta-title em { font-style: italic; color: var(--gold-lt); }
.sc-cta-sub { font-size: .85rem; color: rgba(240,237,232,.4); line-height: 1.75; margin-top: 10px; max-width: 440px; }

.sc-cta-btns { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-shrink: 0; }
.sc-cta-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 22px; border-radius: 10px;
    font-size: .84rem; font-weight: 500;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: all var(--t); border: none; text-decoration: none;
}
.sc-cta-btn svg { width: 15px; height: 15px; flex-shrink: 0; }
.sc-btn-email { background: var(--gold); color: #fff; }
.sc-btn-email:hover { background: #a06828; color: #fff; transform: translateY(-1px); }
.sc-btn-wa { background: rgba(37,211,102,.12); color: #25D366; border: 1px solid rgba(37,211,102,.25); }
.sc-btn-wa:hover { background: #25D366; color: #fff; }
.sc-btn-call { background: rgba(255,255,255,.08); color: #F0EDE8; border: 1px solid rgba(255,255,255,.15); }
.sc-btn-call:hover { background: rgba(255,255,255,.16); color: #fff; }
</style>

{{-- ── Breadcrumb ── --}}
<div class="sc-breadcrumb">
    <div class="container">
        <div class="sc-bc-inner">
            <a href="{{ route('front.home') }}">Home</a>
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 6l6 6-6 6"/></svg>
            <a href="{{ route('front.our.services') }}">Services</a>
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 6l6 6-6 6"/></svg>
            <span class="cur">{{ $category->name }}</span>
        </div>
    </div>
</div>

{{-- ── Hero ── --}}
<section class="sc-hero">
    <div class="container">
        <div class="sc-hero-layout">

            {{-- Text --}}
            <div>
                <div class="sc-eyebrow">Service Category</div>
                <h1 class="sc-hero-title">{{ $category->name }}</h1>
                <p class="sc-hero-desc">{{ $category->description }}</p>
                <div class="sc-hero-actions">
                    @if($category->services->count() > 0)
                    <a href="#sc-services" class="sc-btn-primary"
                       onclick="event.preventDefault(); document.getElementById('sc-services').scrollIntoView({behavior:'smooth'})">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                        Explore Services
                    </a>
                    @endif
                    <a href="{{ route('front.contact') }}" class="sc-btn-outline">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                        Contact Us
                    </a>
                </div>
            </div>

            {{-- Image mosaic --}}
            <div class="sc-hero-imgs">
                <div class="sc-img">
                    <img src="{{ asset('front/assets/img/all-images/about/about-img3.png') }}" alt="{{ $category->name }}">
                </div>
                <div class="sc-img">
                    <img src="{{ asset('front/assets/img/all-images/about/about-img4.png') }}" alt="{{ $category->name }}">
                </div>
                <div class="sc-img">
                    <img src="{{ asset('front/assets/img/all-images/about/about-img5.png') }}" alt="{{ $category->name }}">
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── Services under this category ── --}}
@if($category->services->count() > 0)
<section class="sc-services" id="sc-services">
    <div class="container">

        <div class="sc-section-head">
            <div class="sc-section-eyebrow">What's Included</div>
            <h2 class="sc-section-title">Our <em>{{ $category->name }}</em> services</h2>
            <p class="sc-section-sub">Browse all services available under this category and find exactly what you need.</p>
        </div>

        <div class="row g-4">
            @foreach($category->services as $i => $service)
            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                <div class="sc-card" style="animation-delay:{{ $i * 0.06 }}s">

                    <div class="sc-card-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>

                    <div class="sc-card-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                    </div>

                    <div class="sc-card-title">{{ $service->title }}</div>
                    <p class="sc-card-desc">
                        {{ Str::limit($service->description, 130) }}
                    </p>

                    <div class="sc-card-meta">
                        <span class="sc-card-badge">Available</span>
                        <span class="sc-card-cta">
                            Learn more
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z"/></svg>
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@else
<section class="sc-services">
    <div class="container">
        <div class="sc-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
            </svg>
            <h3>No services listed yet</h3>
            <p>Services for this category will appear here soon.</p>
        </div>
    </div>
</section>
@endif

{{-- ── CTA Section ── --}}
<section class="sc-cta">
    <div class="container">
        <div class="sc-cta-inner">
            <div>
                <div class="sc-cta-eyebrow">Free Consultation</div>
                <h2 class="sc-cta-title">Request a free <em>Terra consultation</em></h2>
                <p class="sc-cta-sub">At Terra real estate, we believe your next move is more than just a place — it's where your future begins.</p>
            </div>
            <div class="sc-cta-btns">
                <a href="{{ route('front.contact') }}" class="sc-cta-btn sc-btn-email">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    Send an Email
                </a>
                <a href="https://wa.me/250782390919" target="_blank" rel="noopener" class="sc-cta-btn sc-btn-wa">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/><path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z"/></svg>
                    WhatsApp Chat
                </a>
                <a href="tel:+250782390919" class="sc-cta-btn sc-btn-call">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
                    Call Now
                </a>
            </div>
        </div>
    </div>
</section>

@endsection