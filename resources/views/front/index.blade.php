@extends('layouts.guest')
@section('title', 'Your Dream Home Awaits - Terra Real Estate')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --surface: #FFFFFF;
        --dark: #19265d;
        --dark2: #19265d;
        --border: rgba(0, 0, 0, .08);
        --gold: #D05208;
        --gold-lt: #E5A55E;
        --gold-bg: rgba(200, 135, 58, .08);
        --gold-bd: rgba(200, 135, 58, .22);
        --text: #19265d;
        --muted: #6B6560;
        --dim: #9E9890;
        --t: .22s cubic-bezier(.4, 0, .2, 1);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        overflow-x: hidden;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    /* ══════════════════════════════════════
   HERO SLIDER
══════════════════════════════════════ */
    .hero-wrap {
        position: relative;
        height: 100vh;
        min-height: 600px;
        overflow: hidden;
        background: var(--dark);
    }

    /* Slides */
    .hero-slides {
        position: absolute;
        inset: 0;
    }

    .hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 1s ease;
    }

    .hero-slide.active {
        opacity: 1;
    }

    .hero-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(.52);
        transform: scale(1.04);
        transition: transform 7s ease;
    }

    .hero-slide.active img {
        transform: scale(1);
    }

    /* Overlay gradient */
    .hero-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(to top, #19265d 0%, transparent 50%),
            linear-gradient(to right, rgba(14, 14, 12, .35) 0%, transparent 60%);
        z-index: 1;
    }

    /* Grid texture */
    .hero-grid {
        position: absolute;
        inset: 0;
        z-index: 1;
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 79px, rgba(255, 255, 255, .03) 79px, rgba(255, 255, 255, .03) 80px),
            repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255, 255, 255, .03) 79px, rgba(255, 255, 255, .03) 80px);
        pointer-events: none;
    }

    /* Content */
    .hero-content {
        position: absolute;
        inset: 0;
        z-index: 2;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 0 0 80px;
    }

    .hero-content .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .7rem;
        font-weight: 500;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: var(--gold-lt);
        margin-bottom: 18px;
        animation: heroFadeUp .8s ease .2s both;
    }

    .hero-eyebrow::before {
        content: '';
        width: 28px;
        height: 1px;
        background: var(--gold);
        opacity: .7;
    }

    .hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2.8rem, 6vw, 5.2rem);
        font-weight: 500;
        line-height: 1.05;
        letter-spacing: -.03em;
        color: #F0EDE8;
        margin-bottom: 40px;
        max-width: 700px;
        animation: heroFadeUp .8s ease .35s both;
    }

    .hero-title em {
        font-style: italic;
        color: var(--gold-lt);
    }

    .hero-sub {
        font-size: 1rem;
        color: rgba(240, 237, 232, .6);
        line-height: 1.7;
        max-width: 460px;
        margin-bottom: 40px;
        animation: heroFadeUp .8s ease .5s both;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        animation: heroFadeUp .8s ease .65s both;
        margin-bottom: 95px;
    }

    .h-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 28px;
        border-radius: 10px;
        background: var(--gold);
        color: #fff;
        font-size: .88rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        transition: background var(--t), transform var(--t);
        border: none;
        cursor: pointer;
    }

    .h-btn-primary:hover {
        background: #a06828;
        transform: translateY(-2px);
        color: #fff;
    }

    .h-btn-primary svg {
        width: 15px;
        height: 15px;
    }

    .h-btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 28px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .1);
        color: #F0EDE8;
        border: 1px solid rgba(255, 255, 255, .2);
        font-size: .88rem;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        backdrop-filter: blur(8px);
        transition: all var(--t);
    }

    .h-btn-outline:hover {
        background: rgba(255, 255, 255, .18);
        color: #fff;
        transform: translateY(-2px);
    }

    /* Slide counter + dots */
    .hero-nav {
        position: absolute;
        right: 40px;
        bottom: 80px;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .hero-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .3);
        cursor: pointer;
        transition: all var(--t);
    }

    .hero-dot.active {
        background: var(--gold);
        width: 6px;
        height: 20px;
        border-radius: 3px;
    }

    /* Prev/Next arrows */
    .hero-arrows {
        position: absolute;
        left: 60px;
        bottom: 100px;
        z-index: 3;
        display: flex;
        gap: 8px;
    }

    .h-arrow {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .2);
        display: grid;
        place-items: center;
        cursor: pointer;
        backdrop-filter: blur(8px);
        transition: all var(--t);
        color: #fff;
    }

    .h-arrow:hover {
        background: var(--gold);
        border-color: var(--gold);
    }

    .h-arrow svg {
        width: 16px;
        height: 16px;
    }

    /* Slide counter label */
    .hero-counter {
        position: absolute;
        right: 40px;
        top: 40%;
        z-index: 3;
        transform: translateY(-50%);
        writing-mode: vertical-rl;
        font-size: .7rem;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .35);
    }

    .hero-counter strong {
        color: var(--gold-lt);
        font-weight: 600;
    }

    /* Quick stat bar */
    .hero-stats {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 3;
        background: rgba(255, 255, 255, .06);
        backdrop-filter: blur(16px);
        border-top: 1px solid rgba(255, 255, 255, .1);
    }

    .hero-stats .inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }

    .h-stat {
        padding: 18px 24px;
        text-align: center;
        border-right: 1px solid rgba(255, 255, 255, .08);
    }

    .h-stat:last-child {
        border-right: none;
    }

    .h-stat-val {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.6rem;
        font-weight: 600;
        color: #F0EDE8;
        line-height: 1;
    }

    .h-stat-lbl {
        font-size: .68rem;
        color: rgba(255, 255, 255, .4);
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-top: 3px;
    }

    @media (max-width: 600px) {
        .hero-stats .inner {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Animations */
    @keyframes heroFadeUp {
        from {
            opacity: 0;
            transform: translateY(24px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ══════════════════════════════════════
   LISTINGS MODAL
══════════════════════════════════════ */
    .lm-overlay {
        position: fixed;
        inset: 0;
        z-index: 1000;
        background: rgba(10, 10, 8, .7);
        backdrop-filter: blur(6px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .lm-overlay.open {
        display: flex;
    }

    .lm-box {
        background: var(--surface);
        border-radius: 18px;
        width: 100%;
        max-width: 560px;
        overflow: hidden;
        box-shadow: 0 32px 80px rgba(0, 0, 0, .22);
        animation: modalIn .35s cubic-bezier(.4, 0, .2, 1) both;
    }

    @keyframes modalIn {
        from {
            opacity: 0;
            transform: scale(.96) translateY(12px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .lm-head {
        padding: 24px 28px 0;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

    .lm-head h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.4rem;
        font-weight: 600;
        letter-spacing: -.01em;
    }

    .lm-head p {
        font-size: .82rem;
        color: var(--muted);
        margin-top: 2px;
    }

    .lm-close {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--muted);
        transition: color var(--t);
        padding: 0;
    }

    .lm-close:hover {
        color: var(--text);
    }

    .lm-close svg {
        width: 20px;
        height: 20px;
    }

    .lm-body {
        padding: 20px 28px 28px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .lm-card {
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 22px 20px;
        text-align: center;
        transition: border-color var(--t), box-shadow var(--t), transform var(--t);
        cursor: pointer;
        display: block;
        color: inherit;
    }

    .lm-card:hover {
        border-color: var(--gold-bd);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
        transform: translateY(-3px);
        color: inherit;
    }

    .lm-icon {
        width: 52px;
        height: 52px;
        border-radius: 13px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
        margin: 0 auto 14px;
    }

    .lm-icon svg {
        width: 22px;
        height: 22px;
        color: var(--gold);
    }

    .lm-card h5 {
        font-size: .9rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 5px;
    }

    .lm-card p {
        font-size: .78rem;
        color: var(--muted);
        line-height: 1.5;
    }

    .lm-cta {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: .78rem;
        color: var(--gold);
        font-weight: 500;
        margin-top: 12px;
    }

    /* ══════════════════════════════════════
   SECTION SHARED
══════════════════════════════════════ */
    .section {
        padding: 10px 0;
    }

    .section-sm {
        padding: 8px 0;
    }

    .container-xl {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .7rem;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 12px;
    }

    .eyebrow::before,
    .eyebrow::after {
        content: '';
        width: 20px;
        height: 1px;
        background: var(--gold);
        opacity: .5;
    }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.8rem, 3.5vw, 2.8rem);
        font-weight: 500;
        line-height: 1.15;
        letter-spacing: -.02em;
        color: var(--text);
    }

    .section-title em {
        font-style: italic;
        color: var(--gold);
    }

    .section-sub {
        font-size: .88rem;
        color: var(--muted);
        line-height: 1.7;
        max-width: 500px;
        margin-top: 10px;
    }

    /* ══════════════════════════════════════
   SERVICES
══════════════════════════════════════ */
    .services-section {
        background: var(--surface);
    }

    .services-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 48px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .see-all-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .8rem;
        color: var(--gold);
        font-weight: 500;
        border-bottom: 1px solid var(--gold-bd);
        transition: gap var(--t);
    }

    .see-all-link:hover {
        gap: 10px;
    }

    .see-all-link svg {
        width: 13px;
        height: 13px;
    }

    .services-layout {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 28px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .services-layout {
            grid-template-columns: 1fr;
        }
    }

    .services-img-wrap {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 3/4;
    }

    .services-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .services-img-badge {
        position: absolute;
        bottom: 20px;
        left: 20px;
        right: 20px;
        background: rgba(14, 14, 12, .8);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(200, 135, 58, .3);
        border-radius: 12px;
        padding: 16px 18px;
        color: #F0EDE8;
    }

    .services-img-badge .sib-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 4px;
    }

    .services-img-badge .sib-sub {
        font-size: .75rem;
        color: rgba(240, 237, 232, .5);
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    @media (max-width: 540px) {
        .services-grid {
            grid-template-columns: 1fr;
        }
    }

    .service-card {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 13px;
        padding: 20px;
        transition: border-color var(--t), box-shadow var(--t), transform var(--t);
        display: block;
        color: inherit;
    }

    .service-card:hover {
        border-color: var(--gold-bd);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .07);
        transform: translateY(-3px);
        color: inherit;
    }

    .sc-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
        margin-bottom: 14px;
    }

    .sc-icon svg {
        width: 18px;
        height: 18px;
        color: var(--gold);
    }

    .sc-title {
        font-size: .9rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 4px;
    }

    .sc-sub {
        font-size: .76rem;
        color: var(--muted);
        line-height: 1.55;
    }

    .sc-arrow {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .74rem;
        color: var(--gold);
        margin-top: 12px;
        font-weight: 500;
        transition: gap var(--t);
    }

    .service-card:hover .sc-arrow {
        gap: 8px;
    }

    .sc-arrow svg {
        width: 12px;
        height: 12px;
    }

    /* ══════════════════════════════════════
   DISTRICTS / LOCATIONS
══════════════════════════════════════ */
    .locations-section {
        background: var(--bg);
    }

    .locations-header {
        text-align: center;
        margin-bottom: 48px;
    }

    .dist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 14px;
    }

    .dist-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 13px;
        padding: 22px 20px;
        transition: border-color var(--t), box-shadow var(--t), transform var(--t);
        display: block;
        color: inherit;
    }

    .dist-card:hover {
        border-color: var(--gold-bd);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .08);
        transform: translateY(-4px);
        color: inherit;
    }

    .dist-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .dist-pin {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
    }

    .dist-pin svg {
        width: 16px;
        height: 16px;
        color: var(--gold);
    }

    .dist-count {
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .05em;
        text-transform: uppercase;
        color: var(--dim);
    }

    .dist-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 4px;
    }

    .dist-props {
        font-size: .78rem;
        color: var(--muted);
    }

    .dist-link {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .75rem;
        color: var(--gold);
        margin-top: 14px;
        font-weight: 500;
        transition: gap var(--t);
    }

    .dist-card:hover .dist-link {
        gap: 8px;
    }

    .dist-link svg {
        width: 12px;
        height: 12px;
    }

    /* ══════════════════════════════════════
   CTA SECTION
══════════════════════════════════════ */
    .cta-section {
        background: var(--dark);
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 50% at 20% 50%, rgba(200, 135, 58, .14) 0%, transparent 60%),
            radial-gradient(ellipse 40% 60% at 85% 30%, rgba(200, 135, 58, .07) 0%, transparent 55%);
        pointer-events: none;
    }

    .cta-section::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255, 255, 255, .02) 39px, rgba(255, 255, 255, .02) 40px),
            repeating-linear-gradient(90deg, transparent, transparent 39px, rgba(255, 255, 255, .02) 39px, rgba(255, 255, 255, .02) 40px);
        pointer-events: none;
    }

    .cta-inner {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        flex-wrap: wrap;
    }

    .cta-text .eyebrow::before,
    .cta-text .eyebrow::after {
        background: var(--gold);
    }

    .cta-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.8rem, 3.5vw, 2.6rem);
        font-weight: 500;
        line-height: 1.15;
        letter-spacing: -.02em;
        color: #F0EDE8;
        margin-top: 8px;
    }

    .cta-title em {
        font-style: italic;
        color: var(--gold-lt);
    }

    .cta-sub {
        font-size: .85rem;
        color: rgba(240, 237, 232, .45);
        line-height: 1.7;
        margin-top: 10px;
        max-width: 440px;
    }

    .cta-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    .cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        border-radius: 10px;
        font-size: .83rem;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: all var(--t);
        border: none;
    }

    .cta-btn svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
    }

    .cta-btn-primary {
        background: var(--gold);
        color: #fff;
    }

    .cta-btn-primary:hover {
        background: #a06828;
        color: #fff;
        transform: translateY(-1px);
    }

    .cta-btn-wa {
        background: rgba(37, 211, 102, .12);
        color: #25D366;
        border: 1px solid rgba(37, 211, 102, .25);
    }

    .cta-btn-wa:hover {
        background: #25D366;
        color: #fff;
    }

    .cta-btn-call {
        background: rgba(255, 255, 255, .08);
        color: #F0EDE8;
        border: 1px solid rgba(255, 255, 255, .15);
    }

    .cta-btn-call:hover {
        background: rgba(255, 255, 255, .16);
        color: #fff;
    }

    /* ══════════════════════════════════════
   PARTNERS (existing include)
══════════════════════════════════════ */
    .partners-wrap {
        background: var(--surface);
    }

    /* ══════════════════════════════════════
   ANIMATIONS
══════════════════════════════════════ */
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

    .fu {
        animation: fadeUp .5s ease both;
    }

    .fu2 {
        animation: fadeUp .5s ease .1s both;
    }

    .fu3 {
        animation: fadeUp .5s ease .2s both;
    }

    .fu4 {
        animation: fadeUp .5s ease .3s both;
    }

    /* ══════════════════════════════════════
   RESPONSIVE FIXES
══════════════════════════════════════ */
    @media (max-width: 768px) {

        .hero-arrows,
        .hero-nav,
        .hero-counter {
            display: none;
        }

        .hero-content {
            padding-bottom: 100px;
        }

        .hero-title {
            font-size: 2.4rem;
        }

        .cta-inner {
            flex-direction: column;
        }

        .h-stat-val {
            font-size: 1.2rem;
        }
    }

    .sc-services-list {
    list-style: none;
    padding: 0;
    margin: 0.75rem 0 0;
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
}

.sc-services-list li {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.8rem;
    color: #555;
    line-height: 1.4;
}

.sc-services-list li svg {
    flex-shrink: 0;
    color: #D05208;
}
</style>

{{-- ══════════════════════════════
     HERO SLIDER
══════════════════════════════ --}}
<section class="hero-wrap" id="hero">
    <div class="hero-slides">
        <div class="hero-slide active">
            <img src="{{ asset('front/assets/img/all-images/hero/image-1.png') }}" alt="Terra Real Estate">
        </div>
        <div class="hero-slide">
            <img src="{{ asset('front/assets/img/all-images/hero/plot.png') }}" alt="Terra Plots">
        </div>
        <!-- <div class="hero-slide">
            <img src="{{ asset('front/assets/img/all-images/hero/consultant-1.png') }}" alt="Terra Consultants">
        </div> -->
    </div>

    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>

    <div class="hero-content">
        <div class="container">
            <!-- <div class="hero-eyebrow">Rwanda's Premier Real Estate Platform</div> -->
            <h1 class="hero-title">
                Your <span style="color: #D05208;">dream property</span><br>starts right here
            </h1>
            <p class="hero-sub">
                Discover homes, plots, and architectural designs across Rwanda. Buy, sell, or consult — all in one place.
            </p>
            <div class="hero-actions">
                <a href="{{ route('front.properties.buy') }}" class="h-btn-primary">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                    </svg>
                    Browse Listings
                </a>
                <a href="{{ route('front.properties.sell') }}" class="h-btn-outline">
                    Sell Your Property
                </a>
                <!-- advertisement button -->
                <a href="{{ route('advertisements.index') }}" class="h-btn-outline">
                    Advertisements
                </a>
            </div>
        </div>
    </div>

    {{-- Arrows --}}
    <div class="hero-arrows">
        <button class="h-arrow" id="h-prev" aria-label="Previous">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 18l-6-6 6-6" />
            </svg>
        </button>
        <button class="h-arrow" id="h-next" aria-label="Next">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6" />
            </svg>
        </button>
    </div>

    {{-- Dots --}}
    <div class="hero-nav" id="hero-dots"></div>

    {{-- Counter --}}
    <div class="hero-counter">
        <strong id="hero-cur">01</strong> / <span id="hero-total">03</span>
    </div>

    {{-- Stats bar --}}
    <div class="hero-stats">
        <div class="inner">
            <div class="h-stat">
                <div class="h-stat-val">500+</div>
                <div class="h-stat-lbl">Properties Listed</div>
            </div>
            <div class="h-stat">
                <div class="h-stat-val">120+</div>
                <div class="h-stat-lbl">Verified Agents</div>
            </div>
            <div class="h-stat">
                <div class="h-stat-val">30+</div>
                <div class="h-stat-lbl">Districts Covered</div>
            </div>
            <div class="h-stat">
                <div class="h-stat-val">98%</div>
                <div class="h-stat-lbl">Client Satisfaction</div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════
     LISTINGS MODAL
══════════════════════════════ --}}
<div class="lm-overlay" id="listings-modal" onclick="closeLmOnBg(event)">
    <div class="lm-box">
        <div class="lm-head">
            <div>
                <h3>Explore Listings</h3>
                <p>What would you like to do today?</p>
            </div>
            <button class="lm-close" onclick="document.getElementById('listings-modal').classList.remove('open')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="lm-body">
            <a href="{{ route('front.properties.buy') }}" class="lm-card">
                <div class="lm-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>
                </div>
                <h5>Buy or Rent</h5>
                <p>Browse hundreds of verified homes, plots, and designs.</p>
                <span class="lm-cta">View listings
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </span>
            </a>
            <a href="{{ route('front.properties.sell') }}" class="lm-card">
                <div class="lm-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z" />
                    </svg>
                </div>
                <h5>List Your Property</h5>
                <p>Reach thousands of buyers — upload and promote easily.</p>
                <span class="lm-cta">Get started
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </span>
            </a>
        </div>
    </div>
</div>

{{-- ══════════════════════════════
     SERVICES SECTION
══════════════════════════════ --}}
<section class="section services-section">
    <div class="container-xl">
        <div class="services-header">
            <div>
                <div class="eyebrow">What We Offer</div>
                <h2 class="section-title">One platform, <span style="color: #D05208;">every service</span></h2>
                <p class="section-sub">From buying your first home to listing commercial property — Terra covers it all.</p>
            </div>
            <a href="{{ route('front.our.services') }}" class="see-all-link">
                All services
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="services-layout">
            {{-- Left image --}}
            <div class="services-img-wrap fu">
                <img src="{{ asset('front/assets/img/all-images/hero/agent.png') }}" alt="Terra Services">
                <div class="services-img-badge">
                    <div class="sib-title">Expert Consultants</div>
                    <div class="sib-sub">Certified professionals across Rwanda</div>
                </div>
            </div>

            {{-- Services grid --}}
            <div class="services-grid">
                @foreach($serviceCategories as $i => $category)
                <a href="{{ route('services.category', $category->id) }}"
                    class="service-card fu"
                    style="animation-delay: {{ $i * 0.07 }}s">
                    <div class="sc-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                        </svg>
                    </div>
                    <div class="sc-title">{{ $category->name }}</div>
                    <div class="sc-sub">Explore {{ strtolower($category->name) }} services from verified professionals.</div>

                    @if($category->services->isNotEmpty())
                    <ul class="sc-services-list">
                        @foreach($category->services as $service)
                        <li>
                            <svg viewBox="0 0 24 24" fill="currentColor" width="12" height="12">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                            {{ $service->title }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════
     DISTRICTS SECTION
══════════════════════════════ --}}
<section class="section locations-section">
    <div class="container-xl">
        <div class="locations-header">
            <div class="eyebrow">Browse by Location</div>
            <h2 class="section-title">Properties across <span style="color: #D05208;">every district</span></h2>
            <p class="section-sub" style="margin: 10px auto 0">Find the perfect property in your preferred location in Rwanda.</p>
        </div>

        <div class="dist-grid">
            @foreach($districts as $district => $data)
            <a href="{{ route('properties.by.province', $district) }}" class="dist-card fu">
                <div class="dist-card-top">
                    <div class="dist-pin">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg>
                    </div>
                    <span class="dist-count">{{ $data['total'] ?? 0 }} listings</span>
                </div>
                <div class="dist-name">{{ $district }}</div>
                <div class="dist-props">{{ $data['total'] ?? 0 }} {{ ($data['total'] ?? 0) == 1 ? 'property' : 'properties' }} available</div>
                <div class="dist-link">
                    Explore
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════
     PARTNERS
══════════════════════════════ --}}
<div class="partners-wrap">
    @include('front.partners')
</div>

{{-- ══════════════════════════════
     CTA SECTION
══════════════════════════════ --}}

<div class="cta1-section-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cta-bg-area" style="background-image: url(front/assets/img/all-images/bg/cta-bg1.png); background-position: center; background-repeat: no-repeat; background-size: cover;">
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="cta-header">
                                <h2 class="text-anime-style-3" style="perspective: 400px;">
                                    Free Consultation
                                </h2>
                                <div class="space16"></div>
                                <p data-aos="fade-left" data-aos-duration="1000" class="aos-init aos-animate">Our team of experts is available Monday to Friday, 9am–6pm. Reach out and we'll guide you every step of the way.</p>
                            </div>
                        </div>
                        <div class="col-lg-7 aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1000">
                            <div class="cta-actions">
                                <a href="mailto:terraltd.rd@gmail.com" class="cta-btn cta-btn-primary">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                    </svg>
                                    Send an Email
                                </a>
                                <a href="https://wa.me/+250796511725" target="_blank" class="cta-btn cta-btn-wa">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
                                        <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" />
                                    </svg>
                                    WhatsApp Chat
                                </a>
                                <a href="tel:+250796511725" class="cta-btn cta-btn-call">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                                    </svg>
                                    Call Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        /* ── Hero Slider ── */
        const slides = document.querySelectorAll('.hero-slide');
        const dotsWrap = document.getElementById('hero-dots');
        const curEl = document.getElementById('hero-cur');
        const totalEl = document.getElementById('hero-total');
        let cur = 0,
            timer;
        const TOTAL = slides.length;

        totalEl.textContent = String(TOTAL).padStart(2, '0');

        /* Build dots */
        slides.forEach((_, i) => {
            const d = document.createElement('button');
            d.className = 'hero-dot' + (i === 0 ? ' active' : '');
            d.setAttribute('aria-label', 'Slide ' + (i + 1));
            d.onclick = () => goTo(i);
            dotsWrap.appendChild(d);
        });

        function goTo(n) {
            slides[cur].classList.remove('active');
            document.querySelectorAll('.hero-dot')[cur].classList.remove('active');
            cur = (n + TOTAL) % TOTAL;
            slides[cur].classList.add('active');
            document.querySelectorAll('.hero-dot')[cur].classList.add('active');
            curEl.textContent = String(cur + 1).padStart(2, '0');
            resetTimer();
        }

        function resetTimer() {
            clearInterval(timer);
            timer = setInterval(() => goTo(cur + 1), 5500);
        }

        document.getElementById('h-prev').onclick = () => goTo(cur - 1);
        document.getElementById('h-next').onclick = () => goTo(cur + 1);

        /* Keyboard support */
        document.addEventListener('keydown', e => {
            if (e.key === 'ArrowLeft') goTo(cur - 1);
            if (e.key === 'ArrowRight') goTo(cur + 1);
        });

        /* Touch swipe */
        let tx = 0;
        const hero = document.getElementById('hero');
        hero.addEventListener('touchstart', e => {
            tx = e.touches[0].clientX;
        }, {
            passive: true
        });
        hero.addEventListener('touchend', e => {
            const diff = tx - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) goTo(diff > 0 ? cur + 1 : cur - 1);
        });

        resetTimer();

        /* ── Modal close on background ── */
        window.closeLmOnBg = function(e) {
            if (e.target === document.getElementById('listings-modal'))
                document.getElementById('listings-modal').classList.remove('open');
        };

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape')
                document.getElementById('listings-modal').classList.remove('open');
        });

    })();
</script>

@endsection