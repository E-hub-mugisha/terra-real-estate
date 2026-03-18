@extends('layouts.guest')
@section('title', 'Explore Our Terra Services')
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
    --r:        13px;
    --t:        .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; }
a { text-decoration: none; color: inherit; }

/* ══════════════════════════
   HERO
══════════════════════════ */
.sv-hero {
    background: var(--dark);
    position: relative; overflow: hidden;
    padding: 80px 0 72px; text-align: center;
}
.sv-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 55% 50% at 50% 0%,  rgba(200,135,58,.14) 0%, transparent 65%),
        radial-gradient(ellipse 35% 55% at 10% 80%, rgba(200,135,58,.06) 0%, transparent 55%),
        radial-gradient(ellipse 30% 50% at 90% 30%, rgba(200,135,58,.05) 0%, transparent 55%);
    pointer-events: none;
}
.sv-hero::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg,  transparent, transparent 39px, rgba(255,255,255,.018) 39px, rgba(255,255,255,.018) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255,255,255,.012) 79px, rgba(255,255,255,.012) 80px);
    pointer-events: none;
}
.sv-hero .container { position: relative; z-index: 2; }

.sv-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .7rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold-lt); margin-bottom: 14px;
}
.sv-eyebrow::before, .sv-eyebrow::after { content: ''; width: 20px; height: 1px; background: var(--gold); opacity: .6; }

.sv-hero h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.2rem, 5vw, 3.8rem);
    font-weight: 500; line-height: 1.1;
    letter-spacing: -.02em; color: #F0EDE8; margin-bottom: 14px;
}
.sv-hero h1 em { font-style: italic; color: var(--gold-lt); }
.sv-hero p {
    font-size: .9rem; color: rgba(240,237,232,.45);
    max-width: 520px; margin: 0 auto; line-height: 1.75;
}

/* Count strip */
.sv-count-strip {
    display: flex; align-items: center; justify-content: center;
    gap: 0; margin-top: 36px; flex-wrap: wrap;
}
.sv-count-item {
    padding: 14px 28px; text-align: center;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1);
}
.sv-count-item:first-child { border-radius: 10px 0 0 10px; }
.sv-count-item:last-child  { border-radius: 0 10px 10px 0; border-left: none; }
.sv-count-item:not(:first-child):not(:last-child) { border-left: none; }
.sv-count-val {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.6rem; font-weight: 600; color: #F0EDE8;
    line-height: 1; letter-spacing: -.02em;
}
.sv-count-val em { color: var(--gold-lt); font-style: normal; }
.sv-count-lbl { font-size: .68rem; color: rgba(240,237,232,.3); text-transform: uppercase; letter-spacing: .08em; margin-top: 3px; }
@media (max-width: 540px) { .sv-count-item { border-radius: 8px !important; border: 1px solid rgba(255,255,255,.1) !important; margin: 3px; } }

/* ══════════════════════════
   SERVICES SECTION
══════════════════════════ */
.sv-section { padding: 72px 0 80px; }

.sv-section-head { text-align: center; margin-bottom: 52px; }
.sv-section-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .7rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 10px;
}
.sv-section-eyebrow::before, .sv-section-eyebrow::after {
    content: ''; width: 18px; height: 1px; background: var(--gold); opacity: .5;
}
.sv-section-head h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 500; letter-spacing: -.02em; color: var(--text);
}
.sv-section-head h2 em { font-style: italic; color: var(--gold); }
.sv-section-head p { font-size: .88rem; color: var(--muted); margin-top: 8px; max-width: 500px; margin-inline: auto; line-height: 1.7; }

/* ── Service Card ── */
.sv-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r);
    padding: 26px 22px 22px;
    display: flex; flex-direction: column;
    height: 100%;
    transition: transform var(--t), border-color var(--t), box-shadow var(--t);
    animation: svFu .4s ease both;
    position: relative; overflow: hidden;
}
.sv-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, var(--gold) 0%, transparent 100%);
    opacity: 0; transition: opacity var(--t);
}
.sv-card:hover {
    transform: translateY(-5px);
    border-color: var(--gold-bd);
    box-shadow: 0 12px 32px rgba(0,0,0,.09), 0 0 0 1px rgba(200,135,58,.08);
}
.sv-card:hover::before { opacity: 1; }
@keyframes svFu { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }

/* Card icon */
.sv-card-icon {
    width: 48px; height: 48px; border-radius: 12px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 18px; flex-shrink: 0;
    transition: background var(--t), border-color var(--t);
}
.sv-card-icon svg, .sv-card-icon i {
    width: 22px; height: 22px; font-size: 20px;
    color: var(--gold);
}
.sv-card:hover .sv-card-icon {
    background: var(--gold); border-color: var(--gold);
}
.sv-card:hover .sv-card-icon svg,
.sv-card:hover .sv-card-icon i { color: #fff; }

/* Card number */
.sv-card-num {
    position: absolute; top: 18px; right: 18px;
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.8rem; font-weight: 600;
    color: rgba(0,0,0,.04); line-height: 1; letter-spacing: -.04em;
    user-select: none; pointer-events: none;
    transition: color var(--t);
}
.sv-card:hover .sv-card-num { color: rgba(200,135,58,.06); }

/* Card content */
.sv-card-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.2rem; font-weight: 600; letter-spacing: -.01em;
    color: var(--text); margin-bottom: 8px; line-height: 1.25;
}
.sv-card-desc {
    font-size: .82rem; color: var(--muted); line-height: 1.75;
    flex: 1; margin-bottom: 18px;
}

/* Learn more */
.sv-card-cta {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .8rem; font-weight: 600; color: var(--gold);
    border-bottom: 1px solid var(--gold-bd);
    padding-bottom: 1px;
    transition: gap var(--t), border-color var(--t);
    align-self: flex-start;
}
.sv-card:hover .sv-card-cta { gap: 9px; border-color: var(--gold); }
.sv-card-cta svg { width: 13px; height: 13px; }

/* ══════════════════════════
   CTA SECTION
══════════════════════════ */
.sv-cta {
    background: var(--dark);
    position: relative; overflow: hidden;
    padding: 72px 0;
}
.sv-cta::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 60% 50% at 20% 50%, rgba(200,135,58,.14) 0%, transparent 60%),
        radial-gradient(ellipse 40% 60% at 85% 30%, rgba(200,135,58,.07) 0%, transparent 55%);
    pointer-events: none;
}
.sv-cta::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg,  transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px);
    pointer-events: none;
}
.sv-cta .container { position: relative; z-index: 2; }

.sv-cta-inner {
    display: flex; align-items: center; justify-content: space-between;
    gap: 40px; flex-wrap: wrap;
}
.sv-cta-text .sv-cta-eyebrow {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: .68rem; font-weight: 600; letter-spacing: .12em;
    text-transform: uppercase; color: var(--gold-lt); margin-bottom: 10px;
}
.sv-cta-text .sv-cta-eyebrow::before { content: ''; width: 16px; height: 1px; background: var(--gold); opacity: .6; }
.sv-cta-text h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 500; line-height: 1.15;
    letter-spacing: -.02em; color: #F0EDE8;
}
.sv-cta-text h2 em { font-style: italic; color: var(--gold-lt); }
.sv-cta-text p { font-size: .85rem; color: rgba(240,237,232,.4); line-height: 1.75; margin-top: 10px; max-width: 440px; }

.sv-cta-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex-shrink: 0; }
.sv-cta-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 22px; border-radius: 10px;
    font-size: .84rem; font-weight: 500;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: all var(--t); border: none; text-decoration: none;
}
.sv-cta-btn svg { width: 15px; height: 15px; flex-shrink: 0; }
.sv-btn-email {
    background: var(--gold); color: #fff;
}
.sv-btn-email:hover { background: #a06828; color: #fff; transform: translateY(-1px); }
.sv-btn-wa {
    background: rgba(37,211,102,.12); color: #25D366;
    border: 1px solid rgba(37,211,102,.25);
}
.sv-btn-wa:hover { background: #25D366; color: #fff; }
.sv-btn-call {
    background: rgba(255,255,255,.08); color: #F0EDE8;
    border: 1px solid rgba(255,255,255,.15);
}
.sv-btn-call:hover { background: rgba(255,255,255,.16); color: #fff; }
</style>

{{-- ══ HERO ══ --}}
<section class="sv-hero">
    <div class="container">
        <div class="sv-eyebrow">What We Offer</div>
        <h1>How can <em>Terra</em> help you?</h1>
        <p>Explore our full range of real estate services — from buying and selling property to expert consultation and architectural design.</p>

        <div class="sv-count-strip">
            <div class="sv-count-item">
                <div class="sv-count-val">{{ $serviceCategories->count() }}<em>+</em></div>
                <div class="sv-count-lbl">Service Categories</div>
            </div>
            <div class="sv-count-item">
                <div class="sv-count-val">500<em>+</em></div>
                <div class="sv-count-lbl">Properties Listed</div>
            </div>
            <div class="sv-count-item">
                <div class="sv-count-val">120<em>+</em></div>
                <div class="sv-count-lbl">Verified Agents</div>
            </div>
            <div class="sv-count-item">
                <div class="sv-count-val">98<em>%</em></div>
                <div class="sv-count-lbl">Client Satisfaction</div>
            </div>
        </div>
    </div>
</section>

{{-- ══ SERVICES GRID ══ --}}
<section class="sv-section">
    <div class="container">

        <div class="sv-section-head">
            <div class="sv-section-eyebrow">Our Services</div>
            <h2>Everything you need in <em>one place</em></h2>
            <p>From finding your dream home to listing your property or getting expert design advice — Terra covers it all.</p>
        </div>

        <div class="row g-4">
            @foreach($serviceCategories as $i => $category)
            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                <div class="sv-card" style="animation-delay:{{ $i * 0.06 }}s">

                    {{-- Background number --}}
                    <div class="sv-card-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>

                    {{-- Icon --}}
                    <div class="sv-card-icon">
                        @if($category->icon_svg)
                            {!! $category->icon_svg !!}
                        @else
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                        @endif
                    </div>

                    {{-- Content --}}
                    <a href="{{ route('services.category', $category->id) }}" class="sv-card-title">
                        {{ $category->name }}
                    </a>
                    <p class="sv-card-desc">
                        {{ Str::limit($category->description, 120) }}
                    </p>

                    <a href="{{ route('services.category', $category->id) }}" class="sv-card-cta">
                        Learn more
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ══ CTA SECTION ══ --}}
<section class="sv-cta">
    <div class="container">
        <div class="sv-cta-inner">
            <div class="sv-cta-text">
                <div class="sv-cta-eyebrow">Free Consultation</div>
                <h2>Request a free <em>Terra consultation</em></h2>
                <p>At Terra real estate, we believe your next move is more than just a place — it's where your future begins. Reach out and we'll guide you.</p>
            </div>
            <div class="sv-cta-actions">
                <a href="{{ route('front.contact') }}" class="sv-cta-btn sv-btn-email">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    Send an Email
                </a>
                <a href="https://wa.me/250782390919" target="_blank" rel="noopener" class="sv-cta-btn sv-btn-wa">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/><path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z"/></svg>
                    WhatsApp Chat
                </a>
                <a href="tel:+250782390919" class="sv-cta-btn sv-btn-call">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
                    Call Now
                </a>
            </div>
        </div>
    </div>
</section>

@endsection