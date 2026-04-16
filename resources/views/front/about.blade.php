@extends('layouts.guest')
@section('title', 'About Terra Real Estate')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

:root {
    --bg:       #F7F5F2;
    --surface:  #FFFFFF;
    --dark:     #19265d;
    --dark2:    #19265d;
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
    --green-bg: rgba(30,122,90,.07);
    --green-bd: rgba(30,122,90,.2);
    --r:        13px;
    --t:        .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; }
a { text-decoration: none; color: inherit; }

/* ── Shared utils ── */
.eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .7rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold);
}
.eyebrow::before, .eyebrow::after {
    content: ''; width: 18px; height: 1px; background: var(--gold); opacity: .5;
}
.eyebrow-lt { color: var(--gold-lt); }
.eyebrow-lt::before, .eyebrow-lt::after { background: var(--gold); opacity: .6; }

.section-title {
    font-family: 'Cormorant Garamond', serif;
    font-weight: 500; letter-spacing: -.02em; color: var(--text);
}
.section-title em { font-style: italic; color: var(--gold); }

@keyframes fadeUp {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
}
.fu  { animation: fadeUp .5s ease both; }
.fu2 { animation: fadeUp .5s ease .1s both; }
.fu3 { animation: fadeUp .5s ease .2s both; }
.fu4 { animation: fadeUp .5s ease .3s both; }

/* ══════════════════════════════════════
   HERO
══════════════════════════════════════ */
.ab-hero {
    background: var(--dark);
    position: relative; overflow: hidden;
    padding: 88px 0 80px;
}
.ab-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 55% 60% at 0% 50%,  rgba(200,135,58,.13) 0%, transparent 65%),
        radial-gradient(ellipse 40% 55% at 100% 20%, rgba(200,135,58,.06) 0%, transparent 55%),
        radial-gradient(ellipse 30% 40% at 50% 100%, rgba(200,135,58,.04) 0%, transparent 55%);
    pointer-events: none;
}
.ab-hero::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg,  transparent, transparent 39px, rgba(255,255,255,.018) 39px, rgba(255,255,255,.018) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255,255,255,.012) 79px, rgba(255,255,255,.012) 80px);
    pointer-events: none;
}
.ab-hero .container { position: relative; z-index: 2; }

.ab-hero-grid {
    display: grid; grid-template-columns: 1fr 420px;
    gap: 60px; align-items: center;
}
@media (max-width: 900px) { .ab-hero-grid { grid-template-columns: 1fr; } .ab-hero-imgs { display: none; } }

.ab-hero-tag {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 4px 12px; border-radius: 20px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    font-size: .68rem; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; color: var(--gold-lt);
    margin-bottom: 18px;
}
.ab-hero-tag::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--gold); }

.ab-hero h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.4rem, 5.5vw, 4rem);
    font-weight: 500; line-height: 1.08;
    letter-spacing: -.025em; color: #F0EDE8;
    margin-bottom: 20px;
}
.ab-hero h1 em { font-style: italic; color: var(--gold-lt); }

.ab-hero-desc {
    font-size: .9rem; color: rgba(240,237,232,.45);
    line-height: 1.8; margin-bottom: 32px; max-width: 500px;
}

.ab-hero-btns { display: flex; gap: 10px; flex-wrap: wrap; }
.ab-btn-primary {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 12px 24px; border-radius: 9px;
    background: var(--gold); border: none; color: #fff;
    font-size: .85rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: background var(--t), transform var(--t); text-decoration: none;
}
.ab-btn-primary:hover { background: #a06828; transform: translateY(-1px); color: #fff; }
.ab-btn-primary svg { width: 14px; height: 14px; }
.ab-btn-outline {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 12px 24px; border-radius: 9px;
    background: rgba(255,255,255,.08); color: rgba(240,237,232,.7);
    border: 1px solid rgba(255,255,255,.15);
    font-size: .85rem; font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    transition: all var(--t); text-decoration: none;
}
.ab-btn-outline:hover { background: rgba(255,255,255,.14); color: #F0EDE8; }
.ab-btn-outline svg { width: 14px; height: 14px; }

/* Hero image mosaic */
.ab-hero-imgs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 220px 150px;
    gap: 8px;
}
.ab-hi {
    border-radius: var(--r); overflow: hidden;
    background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08);
}
.ab-hi:first-child { grid-row: 1 / 3; }
.ab-hi img { width: 100%; height: 100%; object-fit: cover; display: block; opacity: .68; }

/* Hero stats strip */
.ab-hero-stats {
    display: flex; gap: 28px; margin-top: 36px; flex-wrap: wrap;
}
.ab-hstat { }
.ab-hstat-val {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.6rem; font-weight: 600; color: #F0EDE8;
    line-height: 1; letter-spacing: -.02em;
}
.ab-hstat-val em { color: var(--gold-lt); font-style: normal; }
.ab-hstat-lbl { font-size: .7rem; color: rgba(240,237,232,.3); text-transform: uppercase; letter-spacing: .08em; margin-top: 3px; }

/* ══════════════════════════════════════
   MISSION & VISION
══════════════════════════════════════ */
.ab-mission { background: var(--surface); padding: 80px 0; }

.ab-mission-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 28px; margin-top: 48px;
}
@media (max-width: 640px) { .ab-mission-grid { grid-template-columns: 1fr; } }

.ab-mv-card {
    border-radius: 16px; padding: 32px 28px;
    position: relative; overflow: hidden;
}
.ab-mv-card.mission { background: var(--dark); }
.ab-mv-card.vision  { background: var(--bg); border: 1px solid var(--border); }
.ab-mv-card.mission::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 70% 70% at 0% 0%, rgba(200,135,58,.16) 0%, transparent 60%);
    pointer-events: none;
}
.ab-mv-icon {
    width: 48px; height: 48px; border-radius: 12px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: grid; place-items: center; margin-bottom: 20px;
}
.ab-mv-icon svg { width: 22px; height: 22px; color: var(--gold); }
.ab-mv-card.mission .ab-mv-icon { background: rgba(200,135,58,.12); border-color: rgba(200,135,58,.3); }
.ab-mv-label {
    font-size: .68rem; font-weight: 700; letter-spacing: .12em;
    text-transform: uppercase; color: var(--gold);
    margin-bottom: 10px; display: block;
}
.ab-mv-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.4rem; font-weight: 500; letter-spacing: -.01em;
    margin-bottom: 12px; line-height: 1.2;
}
.ab-mv-card.mission .ab-mv-title { color: #F0EDE8; }
.ab-mv-card.vision  .ab-mv-title { color: var(--text); }
.ab-mv-text { font-size: .84rem; line-height: 1.8; }
.ab-mv-card.mission .ab-mv-text { color: rgba(240,237,232,.45); }
.ab-mv-card.vision  .ab-mv-text { color: var(--muted); }

/* ══════════════════════════════════════
   STORY
══════════════════════════════════════ */
.ab-story { padding: 80px 0; background: var(--bg); }

.ab-story-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 60px; align-items: center; margin-top: 52px;
}
@media (max-width: 800px) { .ab-story-grid { grid-template-columns: 1fr; } }

.ab-story-img-wrap {
    position: relative; border-radius: 16px; overflow: hidden;
    aspect-ratio: 4/5;
}
.ab-story-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }

/* Floating stat card */
.ab-story-float {
    position: absolute; bottom: 20px; left: 20px;
    background: rgba(14,14,12,.82); backdrop-filter: blur(12px);
    border: 1px solid rgba(200,135,58,.25);
    border-radius: 12px; padding: 16px 20px;
}
.ab-story-float-val {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.6rem; font-weight: 600; color: #F0EDE8;
    letter-spacing: -.02em; line-height: 1;
}
.ab-story-float-val em { color: var(--gold-lt); font-style: normal; }
.ab-story-float-lbl { font-size: .7rem; color: rgba(240,237,232,.4); margin-top: 3px; text-transform: uppercase; letter-spacing: .07em; }

.ab-story-text { display: flex; flex-direction: column; gap: 18px; }
.ab-story-text p { font-size: .88rem; color: var(--muted); line-height: 1.85; }
.ab-story-text p strong { color: var(--text); font-weight: 600; }

/* Values list */
.ab-values-list { display: flex; flex-direction: column; gap: 12px; margin-top: 6px; }
.ab-value-item {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 14px 16px; border-radius: 10px;
    background: var(--surface); border: 1px solid var(--border);
    transition: border-color var(--t), box-shadow var(--t);
}
.ab-value-item:hover { border-color: var(--gold-bd); box-shadow: 0 4px 14px rgba(0,0,0,.06); }
.ab-value-dot {
    width: 32px; height: 32px; border-radius: 8px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: grid; place-items: center; flex-shrink: 0; margin-top: 1px;
}
.ab-value-dot svg { width: 14px; height: 14px; color: var(--gold); }
.ab-value-title { font-size: .88rem; font-weight: 600; color: var(--text); margin-bottom: 2px; }
.ab-value-desc  { font-size: .78rem; color: var(--muted); line-height: 1.6; }

/* ══════════════════════════════════════
   STATS SECTION
══════════════════════════════════════ */
.ab-stats {
    background: var(--dark);
    position: relative; overflow: hidden;
    padding: 72px 0;
}
.ab-stats::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 50% 60% at 20% 50%, rgba(200,135,58,.11) 0%, transparent 60%),
        radial-gradient(ellipse 35% 50% at 80% 30%, rgba(200,135,58,.07) 0%, transparent 55%);
    pointer-events: none;
}
.ab-stats .container { position: relative; z-index: 2; }

.ab-stats-header { text-align: center; margin-bottom: 52px; }
.ab-stats-header h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 500; color: #F0EDE8; letter-spacing: -.02em;
}
.ab-stats-header h2 em { font-style: italic; color: var(--gold-lt); }
.ab-stats-header p { font-size: .86rem; color: rgba(240,237,232,.35); margin-top: 8px; }

.ab-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px; background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.06); border-radius: 14px; overflow: hidden;
}
@media (max-width: 700px) { .ab-stats-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 400px) { .ab-stats-grid { grid-template-columns: 1fr; } }

.ab-stat-cell {
    padding: 32px 24px; text-align: center;
    background: rgba(14,14,12,.6);
    transition: background var(--t);
}
.ab-stat-cell:hover { background: rgba(200,135,58,.08); }
.ab-stat-val {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.4rem; font-weight: 600; color: #F0EDE8;
    line-height: 1; letter-spacing: -.02em;
}
.ab-stat-val em { color: var(--gold-lt); font-style: normal; }
.ab-stat-icon { margin-bottom: 10px; }
.ab-stat-icon svg { width: 22px; height: 22px; color: var(--gold); }
.ab-stat-lbl { font-size: .72rem; color: rgba(240,237,232,.35); text-transform: uppercase; letter-spacing: .09em; margin-top: 6px; }

/* ══════════════════════════════════════
   WHY TERRA
══════════════════════════════════════ */
.ab-why { padding: 80px 0; background: var(--surface); }
.ab-why-header { text-align: center; margin-bottom: 52px; }

.ab-why-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
@media (max-width: 800px) { .ab-why-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .ab-why-grid { grid-template-columns: 1fr; } }

.ab-why-card {
    background: var(--bg); border: 1px solid var(--border);
    border-radius: var(--r); padding: 24px 20px;
    transition: border-color var(--t), box-shadow var(--t), transform var(--t);
    position: relative; overflow: hidden;
}
.ab-why-card::after {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: var(--gold); opacity: 0; transition: opacity var(--t);
}
.ab-why-card:hover {
    border-color: var(--gold-bd);
    box-shadow: 0 8px 24px rgba(0,0,0,.07);
    transform: translateY(-3px);
}
.ab-why-card:hover::after { opacity: 1; }
.ab-why-icon {
    width: 44px; height: 44px; border-radius: 11px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: grid; place-items: center; margin-bottom: 16px;
}
.ab-why-icon svg { width: 20px; height: 20px; color: var(--gold); }
.ab-why-title { font-size: .95rem; font-weight: 600; color: var(--text); margin-bottom: 7px; }
.ab-why-desc  { font-size: .8rem; color: var(--muted); line-height: 1.75; }

/* ══════════════════════════════════════
   TEAM
══════════════════════════════════════ */
.ab-team { padding: 80px 0; background: var(--bg); }
.ab-team-header { text-align: center; margin-bottom: 48px; }

.ab-team-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r); overflow: hidden;
    height: 100%;
    transition: transform var(--t), border-color var(--t), box-shadow var(--t);
}
.ab-team-card:hover {
    transform: translateY(-4px);
    border-color: var(--gold-bd);
    box-shadow: 0 10px 28px rgba(0,0,0,.09);
}
.ab-team-photo {
    position: relative; aspect-ratio: 3/2; overflow: hidden; background: var(--bg);
}
.ab-team-photo img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s ease; }
.ab-team-card:hover .ab-team-photo img { transform: scale(1.05); }
.ab-team-role-badge {
    position: absolute; top: 9px; left: 9px; z-index: 2;
    padding: 3px 9px; border-radius: 6px;
    background: rgba(14,14,12,.75); backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,.12);
    font-size: .64rem; font-weight: 700; letter-spacing: .06em;
    text-transform: uppercase; color: rgba(240,237,232,.8);
}
.ab-team-body { padding: 16px 16px 18px; }
.ab-team-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem; font-weight: 600; color: var(--text);
    letter-spacing: -.01em; margin-bottom: 3px;
}
.ab-team-title { font-size: .77rem; color: var(--gold); font-weight: 500; margin-bottom: 8px; }
.ab-team-bio   { font-size: .78rem; color: var(--muted); line-height: 1.65;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.ab-team-social { display: flex; gap: 6px; margin-top: 12px; padding-top: 10px; border-top: 1px solid var(--border); }
.ab-tsoc {
    width: 30px; height: 30px; border-radius: 7px;
    border: 1px solid var(--border); background: var(--bg);
    display: grid; place-items: center; color: var(--dim);
    font-size: .7rem; transition: all var(--t);
}
.ab-tsoc:hover { background: var(--gold); border-color: var(--gold); color: #fff; }

/* ══════════════════════════════════════
   TIMELINE
══════════════════════════════════════ */
.ab-timeline { background: var(--surface); padding: 80px 0; }
.ab-timeline-header { text-align: center; margin-bottom: 52px; }

.ab-timeline-track {
    position: relative; max-width: 720px; margin: 0 auto;
}
.ab-timeline-track::before {
    content: '';
    position: absolute; left: 50%; top: 0; bottom: 0;
    width: 1px; background: var(--border2);
    transform: translateX(-50%);
}
@media (max-width: 600px) {
    .ab-timeline-track::before { left: 18px; }
}

.ab-tl-item {
    display: flex; gap: 32px; align-items: flex-start;
    margin-bottom: 40px; position: relative;
}
.ab-tl-item:last-child { margin-bottom: 0; }
.ab-tl-item:nth-child(even) { flex-direction: row-reverse; }
@media (max-width: 600px) { .ab-tl-item, .ab-tl-item:nth-child(even) { flex-direction: row; padding-left: 44px; } }

.ab-tl-side { flex: 1; }
.ab-tl-side.right { text-align: right; }
@media (max-width: 600px) { .ab-tl-side.right { text-align: left; } }

.ab-tl-dot {
    width: 36px; height: 36px; border-radius: 50%;
    background: var(--surface); border: 2px solid var(--gold);
    display: grid; place-items: center;
    position: absolute; left: 50%; top: 0;
    transform: translateX(-50%); z-index: 2; flex-shrink: 0;
}
.ab-tl-dot svg { width: 14px; height: 14px; color: var(--gold); }
@media (max-width: 600px) { .ab-tl-dot { left: 0; transform: none; } }

.ab-tl-year {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.15rem; font-weight: 600; color: var(--gold);
    letter-spacing: -.01em; margin-bottom: 4px;
}
.ab-tl-title { font-size: .9rem; font-weight: 600; color: var(--text); margin-bottom: 5px; }
.ab-tl-desc  { font-size: .8rem; color: var(--muted); line-height: 1.7; }

/* ══════════════════════════════════════
   CTA
══════════════════════════════════════ */
.ab-cta {
    background: var(--dark); position: relative; overflow: hidden; padding: 80px 0;
}
.ab-cta::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 60% 50% at 20% 50%, rgba(200,135,58,.14) 0%, transparent 60%),
        radial-gradient(ellipse 40% 60% at 85% 30%, rgba(200,135,58,.07) 0%, transparent 55%);
    pointer-events: none;
}
.ab-cta::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg,  transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px);
    pointer-events: none;
}
.ab-cta .container { position: relative; z-index: 2; text-align: center; }
.ab-cta h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2rem, 4.5vw, 3.2rem);
    font-weight: 500; line-height: 1.1;
    letter-spacing: -.02em; color: #F0EDE8; margin-bottom: 14px;
}
.ab-cta h2 em { font-style: italic; color: var(--gold-lt); }
.ab-cta p { font-size: .88rem; color: rgba(240,237,232,.4); max-width: 480px; margin: 0 auto 32px; line-height: 1.8; }
.ab-cta-btns {
    display: flex; align-items: center; justify-content: center; gap: 10px; flex-wrap: wrap;
}
.ab-cta-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 13px 24px; border-radius: 10px;
    font-size: .86rem; font-weight: 500;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: all var(--t); border: none; text-decoration: none;
}
.ab-cta-btn svg { width: 15px; height: 15px; flex-shrink: 0; }
.ab-btn-gold  { background: var(--gold); color: #fff; }
.ab-btn-gold:hover  { background: #a06828; color: #fff; transform: translateY(-1px); }
.ab-btn-wa   { background: rgba(37,211,102,.12); color: #25D366; border: 1px solid rgba(37,211,102,.25); }
.ab-btn-wa:hover   { background: #25D366; color: #fff; }
.ab-btn-ghost { background: rgba(255,255,255,.08); color: #F0EDE8; border: 1px solid rgba(255,255,255,.15); }
.ab-btn-ghost:hover { background: rgba(255,255,255,.16); color: #fff; }
</style>

{{-- ══ HERO ══ --}}
<section class="ab-hero">
    <div class="container">
        <div class="ab-hero-grid">
            <div class="fu">
                <div class="ab-hero-tag">Est. 2020 · Kigali, Rwanda</div>
                <h1>Rwanda's trusted<br><em>real estate partner</em></h1>
                <p class="ab-hero-desc">
                    Terra Real Estate is Rwanda's premier one-stop property platform — connecting buyers, sellers, agents, consultants, and investors across every district. We believe great real estate isn't just about property; it's about people, communities, and futures.
                </p>
                <div class="ab-hero-btns">
                    <a href="{{ route('front.our.services') }}" class="ab-btn-primary">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                        Explore Services
                    </a>
                    <a href="{{ route('front.contact') }}" class="ab-btn-outline">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                        Get in Touch
                    </a>
                </div>
                <div class="ab-hero-stats">
                    <div class="ab-hstat">
                        <div class="ab-hstat-val">500<em>+</em></div>
                        <div class="ab-hstat-lbl">Properties Listed</div>
                    </div>
                    <div class="ab-hstat">
                        <div class="ab-hstat-val">120<em>+</em></div>
                        <div class="ab-hstat-lbl">Verified Agents</div>
                    </div>
                    <div class="ab-hstat">
                        <div class="ab-hstat-val">30<em>+</em></div>
                        <div class="ab-hstat-lbl">Districts</div>
                    </div>
                    <div class="ab-hstat">
                        <div class="ab-hstat-val">98<em>%</em></div>
                        <div class="ab-hstat-lbl">Satisfaction</div>
                    </div>
                </div>
            </div>

            <div class="ab-hero-imgs fu2">
                <div class="ab-hi">
                    <img src="{{ asset('front/assets/img/all-images/about/about-img1.png') }}" alt="Terra Real Estate">
                </div>
                <div class="ab-hi">
                    <img src="{{ asset('front/assets/img/all-images/about/about-img2.png') }}" alt="Terra Properties">
                </div>
                <div class="ab-hi">
                    <img src="{{ asset('front/assets/img/all-images/about/about-img3.png') }}" alt="Terra Team">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ MISSION & VISION ══ --}}
<section class="ab-mission">
    <div class="container">
        <div class="text-center">
            <div class="eyebrow mb-2">Our Purpose</div>
            <h2 class="section-title" style="font-size:clamp(1.8rem,3.5vw,2.6rem)">Driven by a <em>clear mission</em></h2>
        </div>
        <div class="ab-mission-grid">
            <div class="ab-mv-card mission fu">
                <div class="ab-mv-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                </div>
                <span class="ab-mv-label">Our Mission</span>
                <h3 class="ab-mv-title">Simplify real estate for every Rwandan</h3>
                <p class="ab-mv-text">To provide innovative, transparent, and accessible real estate solutions that connect buyers, sellers, agents, and consultants — making property transactions straightforward, trustworthy, and empowering for everyone across Rwanda.</p>
            </div>
            <div class="ab-mv-card vision fu2">
                <div class="ab-mv-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                </div>
                <span class="ab-mv-label">Our Vision</span>
                <h3 class="ab-mv-title">Rwanda's most trusted property platform</h3>
                <p class="ab-mv-text">To become the leading real estate ecosystem in East Africa — a digital platform where property discovery, verification, consultation, and transaction happen seamlessly, setting the standard for honest and professional real estate practice across the region.</p>
            </div>
        </div>
    </div>
</section>

{{-- ══ STORY ══ --}}
<section class="ab-story">
    <div class="container">
        <div class="eyebrow mb-2">Our Story</div>
        <h2 class="section-title" style="font-size:clamp(1.8rem,3.5vw,2.6rem)">How Terra <em>came to be</em></h2>

        <div class="ab-story-grid">
            <div class="ab-story-img-wrap fu">
                <img src="{{ asset('front/assets/img/all-images/about/about-img4.png') }}" alt="Terra Story">
                <div class="ab-story-float">
                    <div class="ab-story-float-val">4<em>+ yrs</em></div>
                    <div class="ab-story-float-lbl">Serving Rwanda</div>
                </div>
            </div>

            <div class="ab-story-text fu2">
                <p>Terra Real Estate was founded with a simple but powerful belief: <strong>every Rwandan deserves access to transparent, professional real estate services</strong> — regardless of whether they're buying their first home, selling land, or looking for investment opportunities.</p>

                <p>We started as a small consultancy in Kigali, noticing how fragmented and opaque the property market was. Finding verified agents, understanding land regulations, or even browsing available properties was unnecessarily difficult. We set out to fix that.</p>

                <p>Today, Terra is Rwanda's most comprehensive real estate platform — bringing together <strong>homes, land, architectural designs, agents, consultants, tenders, and news</strong> under a single trusted roof, built for the way Rwandans actually live and do business.</p>

                <div class="ab-values-list">
                    <div class="ab-value-item">
                        <div class="ab-value-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                        <div>
                            <div class="ab-value-title">Transparency</div>
                            <div class="ab-value-desc">Every listing, agent, and transaction is verified and clearly presented — no hidden fees, no ambiguity.</div>
                        </div>
                    </div>
                    <div class="ab-value-item">
                        <div class="ab-value-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg></div>
                        <div>
                            <div class="ab-value-title">Local Expertise</div>
                            <div class="ab-value-desc">Deep knowledge of Rwanda's land laws, zoning regulations, and district-level property markets.</div>
                        </div>
                    </div>
                    <div class="ab-value-item">
                        <div class="ab-value-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg></div>
                        <div>
                            <div class="ab-value-title">People First</div>
                            <div class="ab-value-desc">Every decision we make starts with the people we serve — buyers, sellers, agents, and communities.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ STATS ══ --}}
<section class="ab-stats">
    <div class="container">
        <div class="ab-stats-header">
            <div class="eyebrow eyebrow-lt mb-2">Terra by Numbers</div>
            <h2>The impact we've <em>built together</em></h2>
            <p>Real numbers that reflect real trust — updated monthly.</p>
        </div>
        <div class="ab-stats-grid">
            <div class="ab-stat-cell">
                <div class="ab-stat-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>
                <div class="ab-stat-val">500<em>+</em></div>
                <div class="ab-stat-lbl">Properties Listed</div>
            </div>
            <div class="ab-stat-cell">
                <div class="ab-stat-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg></div>
                <div class="ab-stat-val">120<em>+</em></div>
                <div class="ab-stat-lbl">Verified Agents</div>
            </div>
            <div class="ab-stat-cell">
                <div class="ab-stat-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <div class="ab-stat-val">9<em>K+</em></div>
                <div class="ab-stat-lbl">Happy Clients</div>
            </div>
            <div class="ab-stat-cell">
                <div class="ab-stat-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg></div>
                <div class="ab-stat-val">30<em>+</em></div>
                <div class="ab-stat-lbl">Districts Covered</div>
            </div>
        </div>
    </div>
</section>

{{-- ══ WHY TERRA ══ --}}
<section class="ab-why">
    <div class="container">
        <div class="ab-why-header">
            <div class="eyebrow mb-2">Why Choose Us</div>
            <h2 class="section-title" style="font-size:clamp(1.8rem,3.5vw,2.6rem)">What makes <em>Terra different</em></h2>
            <p style="font-size:.88rem;color:var(--muted);max-width:480px;margin:.8rem auto 0;line-height:1.7">
                We're not just a listing platform — we're a full real estate ecosystem built for Rwanda.
            </p>
        </div>
        <div class="ab-why-grid">
            <div class="ab-why-card fu">
                <div class="ab-why-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <div class="ab-why-title">Verified Listings</div>
                <p class="ab-why-desc">Every property is reviewed by our team before going live. No duplicates, no phantom listings — only genuine opportunities.</p>
            </div>
            <div class="ab-why-card fu2">
                <div class="ab-why-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg></div>
                <div class="ab-why-title">Nationwide Coverage</div>
                <p class="ab-why-desc">Properties across all 30 districts of Rwanda — from Kigali city to rural agricultural plots in the Western Province.</p>
            </div>
            <div class="ab-why-card fu3">
                <div class="ab-why-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg></div>
                <div class="ab-why-title">Certified Professionals</div>
                <p class="ab-why-desc">Our agent and consultant network is fully screened. Every professional listed on Terra meets our strict certification standards.</p>
            </div>
            <div class="ab-why-card fu">
                <div class="ab-why-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg></div>
                <div class="ab-why-title">Design Marketplace</div>
                <p class="ab-why-desc">Rwanda's only platform where you can browse, buy, and download architectural designs alongside real property listings.</p>
            </div>
            <div class="ab-why-card fu2">
                <div class="ab-why-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg></div>
                <div class="ab-why-title">Free Consultation</div>
                <p class="ab-why-desc">Not sure where to start? Our team offers free first consultations to help buyers and sellers understand their options.</p>
            </div>
            <div class="ab-why-card fu3">
                <div class="ab-why-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg></div>
                <div class="ab-why-title">Secure & Transparent</div>
                <p class="ab-why-desc">UPI verification for land, identity checks for agents, and clear pricing — every step of your journey is protected and transparent.</p>
            </div>
        </div>
    </div>
</section>

{{-- ══ TEAM ══ --}}
<section class="ab-team">
    <div class="container">
        <div class="ab-team-header">
            <div class="eyebrow mb-2">Our People</div>
            <h2 class="section-title" style="font-size:clamp(1.8rem,3.5vw,2.6rem)">The team <em>behind Terra</em></h2>
            <p style="font-size:.88rem;color:var(--muted);max-width:460px;margin:.8rem auto 0;line-height:1.7">Experienced professionals dedicated to making your real estate journey seamless.</p>
        </div>
        <div class="row g-4">
            @php
            $team = App\Models\Staff::all();
            @endphp
            @foreach($team as $i => $member)
            <div class="col-lg-3 col-md-6 col-12">
                <div class="ab-team-card" style="animation: fadeUp .4s ease {{ $i * 0.08 }}s both">
                    <!-- <div class="ab-team-photo">
                        <span class="ab-team-role-badge">{{ $member->department->name }}</span>
                        <img src="{{ asset('front/assets/img/all-images/team/team-img1.png') }}" alt="{{ $member->user->name }}">
                    </div> -->
                    <div class="ab-team-body">
                        <div class="ab-team-name">{{ $member->user->name }}</div>
                        <div class="ab-team-title">{{ $member->department->name }} - {{ $member->position }}</div>
                        <p class="ab-team-bio">
                            A team player in position of {{ $member->position }} dedicated to providing the best service. and ensuring client satisfaction.
                        </p>
                        <div class="ab-team-social">
                            <a href="#" class="ab-tsoc"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#" class="ab-tsoc"><i class="fa-brands fa-twitter"></i></a>
                            <a href="mailto:#" class="ab-tsoc"><i class="fa-solid fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ TIMELINE ══ --}}
<!-- <section class="ab-timeline">
    <div class="container">
        <div class="ab-timeline-header">
            <div class="eyebrow mb-2">Our Journey</div>
            <h2 class="section-title" style="font-size:clamp(1.8rem,3.5vw,2.6rem)">How we've <em>grown</em></h2>
        </div>

        <div class="ab-timeline-track">
            <div class="ab-tl-item">
                <div class="ab-tl-side">
                    <div class="ab-tl-year">2020</div>
                    <div class="ab-tl-title">Founded in Kigali</div>
                    <p class="ab-tl-desc">Terra was established as a small real estate consultancy focused on helping first-time buyers navigate Kigali's property market.</p>
                </div>
                <div class="ab-tl-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg></div>
                <div class="ab-tl-side right"></div>
            </div>

            <div class="ab-tl-item">
                <div class="ab-tl-side"></div>
                <div class="ab-tl-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>
                <div class="ab-tl-side right">
                    <div class="ab-tl-year">2021</div>
                    <div class="ab-tl-title">Platform Launch</div>
                    <p class="ab-tl-desc">Launched the Terra online platform with the first 100 verified property listings and a network of 20 certified agents across Kigali.</p>
                </div>
            </div>

            <div class="ab-tl-item">
                <div class="ab-tl-side">
                    <div class="ab-tl-year">2022</div>
                    <div class="ab-tl-title">Nationwide Expansion</div>
                    <p class="ab-tl-desc">Expanded coverage to all five provinces of Rwanda, adding land listings, architectural designs, and consultant services to the platform.</p>
                </div>
                <div class="ab-tl-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5z"/></svg></div>
                <div class="ab-tl-side right"></div>
            </div>

            <div class="ab-tl-item">
                <div class="ab-tl-side"></div>
                <div class="ab-tl-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
                <div class="ab-tl-side right">
                    <div class="ab-tl-year">2024</div>
                    <div class="ab-tl-title">500+ Listings & Growing</div>
                    <p class="ab-tl-desc">Reached 500+ active property listings, 120+ verified agents, and 9,000+ satisfied clients — cementing Terra as Rwanda's leading real estate platform.</p>
                </div>
            </div>
        </div>
    </div>
</section> -->

{{-- ══ CTA ══ --}}
<section class="ab-cta">
    <div class="container">
        <div class="eyebrow eyebrow-lt mb-3">Start Today</div>
        <h2>Ready to find your<br><em>perfect property?</em></h2>
        <p>Whether you're buying, selling, or just exploring — Terra is here to guide you every step of the way.</p>
        <div class="ab-cta-btns">
            <a href="{{ route('front.properties.buy') }}" class="ab-cta-btn ab-btn-gold">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                Browse Properties
            </a>
            <a href="https://wa.me/25079796511725" target="_blank" class="ab-cta-btn ab-btn-wa">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/><path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z"/></svg>
                WhatsApp Us
            </a>
            <a href="{{ route('front.contact') }}" class="ab-cta-btn ab-btn-ghost">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                Contact Us
            </a>
        </div>
    </div>
</section>

@endsection