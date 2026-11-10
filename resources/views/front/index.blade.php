@extends('layouts.guest')
@section('title', 'Terra Rwanda Property Exchange - Terra Real Estate')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');

    :root {
        --bg: #F6F7FA;
        --surface: #FFFFFF;
        --dark: #19265d;
        --dark2: #19265d;
        --border: rgba(25, 38, 93, .09);
        --gold: #D05208;
        --gold-lt: #F59A62;
        --gold-bg: rgba(208, 82, 8, .08);
        --gold-bd: rgba(208, 82, 8, .24);
        --rent: #2f8a5b;
        --rent-bg: rgba(47, 138, 91, .1);
        --rent-bd: rgba(47, 138, 91, .28);
        --service: #2f6f8a;
        --text: #19265d;
        --muted: #6B7285;
        --dim: #9AA0B0;
        --whatsapp: #25D366;
        --whatsapp-dark: #1DA851;
        --font: 'Montserrat', system-ui, sans-serif;
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
        font-family: var(--font);
        font-size: 13px;
        line-height: 1.6;
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    button,
    input,
    select {
        font-family: var(--font);
    }

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
        font-size: 10px;
        font-weight: 600;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 10px;
    }

    .eyebrow::before,
    .eyebrow::after {
        content: '';
        width: 18px;
        height: 1px;
        background: var(--gold);
        opacity: .5;
    }

    .section-title {
        font-family: var(--font);
        font-size: clamp(17px, 2vw, 22px);
        font-weight: 600;
        line-height: 1.25;
        letter-spacing: -.02em;
        color: var(--text);
    }

    .section-sub {
        font-size: 12px;
        color: var(--muted);
        line-height: 1.7;
        max-width: 460px;
        margin-top: 8px;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(16px);
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
       HERO — compact property carousel
    ══════════════════════════════════════ */
    .mkt-hero {
        position: relative;
        background: var(--dark);
        overflow: hidden;
        padding: 16px 0 18px;
    }

    .hero-carousel {
        position: relative;
        z-index: 2;
    }

    .hero-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 12px;
    }

    .mkt-hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 9.5px;
        font-weight: 600;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: var(--gold-lt);
        margin-bottom: 3px;
    }

    .mkt-hero-eyebrow::before {
        content: '';
        width: 20px;
        height: 1px;
        background: var(--gold);
    }

    .mkt-hero-kicker-title {
        font-family: var(--font);
        font-size: clamp(14px, 1.5vw, 17px);
        font-weight: 600;
        line-height: 1.25;
        letter-spacing: -.02em;
        color: #F4F5FA;
    }

    .h-btn-primary,
    .h-btn-outline,
    .h-btn-whatsapp {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 13px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        transition: background var(--t), transform var(--t);
    }

    .h-btn-primary {
        background: var(--gold);
        color: #fff;
    }

    .h-btn-primary:hover {
        background: #AD4307;
        transform: translateY(-2px);
        color: #fff;
    }

    .h-btn-outline {
        background: rgba(255, 255, 255, .1);
        color: #F4F5FA;
        border: 1px solid rgba(255, 255, 255, .2);
        font-weight: 500;
    }

    .h-btn-outline:hover {
        background: rgba(255, 255, 255, .18);
        color: #fff;
        transform: translateY(-2px);
    }

    .h-btn-whatsapp {
        background: rgba(37, 211, 102, .16);
        color: #d7ffe6;
        border: 1px solid rgba(37, 211, 102, .38);
    }

    .h-btn-whatsapp:hover {
        background: var(--whatsapp);
        color: #fff;
        transform: translateY(-2px);
    }

    .h-btn-primary svg,
    .h-btn-outline svg,
    .h-btn-whatsapp svg {
        width: 12px;
        height: 12px;
    }

    .hero-carousel-viewport {
        overflow: hidden;
        border-radius: 14px;
    }

    .hero-carousel-track {
        display: flex;
        transition: transform .55s cubic-bezier(.4, 0, .2, 1);
    }

    /* fixed, viewport-aware height so the hero always fits the screen */
    .hero-slide {
        flex: 0 0 100%;
        min-width: 0;
        display: grid;
        grid-template-columns: 0.85fr 1.15fr;
        height: clamp(200px, 32vh, 280px);
        background: rgba(255, 255, 255, .05);
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 14px;
        overflow: hidden;
    }

    .hero-slide-image {
        position: relative;
        min-height: 0;
        background: rgba(0, 0, 0, .2);
    }

    .hero-slide-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .hero-slide-badge-row {
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        display: flex;
        justify-content: space-between;
        gap: 6px;
    }

    .hero-slide-badge {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        padding: 4px 9px;
        border-radius: 999px;
        backdrop-filter: blur(6px);
    }

    .hero-badge-type {
        background: rgba(25, 38, 93, .85);
        color: #fff;
    }

    .hero-badge-type.land {
        background: rgba(208, 82, 8, .85);
    }

    .hero-badge-type.design {
        background: rgba(107, 114, 133, .85);
    }

    .hero-badge-new {
        background: var(--gold);
        color: #fff;
    }

    .hero-badge-condition {
        background: rgba(255, 255, 255, .92);
        color: var(--dark);
    }

    .hero-badge-condition.for_rent {
        color: var(--rent);
    }

    .hero-slide-details {
        padding: 14px 18px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 7px;
        color: #F4F5FA;
        min-width: 0;
    }

    .hero-slide-eyebrow {
        font-size: 9px;
        font-weight: 600;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold-lt);
    }

    .hero-slide-title {
        font-family: var(--font);
        font-weight: 600;
        font-size: clamp(14px, 1.4vw, 17px);
        line-height: 1.3;
        letter-spacing: -.01em;
        color: #fff;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .hero-slide-loc {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        color: rgba(244, 245, 250, .68);
    }

    .hero-slide-loc svg {
        width: 12px;
        height: 12px;
        color: var(--gold-lt);
        flex-shrink: 0;
    }

    .hero-slide-price {
        font-size: 15px;
        font-weight: 700;
        color: var(--gold-lt);
    }

    .hero-slide-price span {
        font-size: 10px;
        font-weight: 500;
        color: rgba(244, 245, 250, .6);
    }

    .hero-slide-meta {
        display: flex;
        gap: 12px;
        font-size: 11px;
        color: rgba(244, 245, 250, .65);
        flex-wrap: wrap;
    }

    .hero-slide-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 4px;
    }

    .hero-slide-empty {
        grid-template-columns: 1fr;
    }

    .hero-slide-empty .hero-slide-details {
        padding: 24px 26px;
    }

    .hero-carousel-nav {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .hero-nav-btn {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, .22);
        background: rgba(255, 255, 255, .08);
        color: #F4F5FA;
        font-size: 15px;
        line-height: 1;
        cursor: pointer;
        display: grid;
        place-items: center;
        transition: all var(--t);
    }

    .hero-nav-btn:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    .hero-dots {
        display: flex;
        gap: 6px;
    }

    .hero-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .28);
        cursor: pointer;
        transition: all var(--t);
    }

    .hero-dot.active {
        background: var(--gold);
        width: 18px;
        border-radius: 4px;
    }

    @media (max-width: 680px) {
        .mkt-hero {
            padding: 14px 0;
        }

        .hero-dots {
            display: none;
        }

        .hero-slide {
            grid-template-columns: 1fr;
            grid-template-rows: 130px auto;
            height: auto;
        }

        .hero-slide-details {
            padding: 12px 14px;
            gap: 5px;
        }

        .hero-slide-eyebrow,
        .hero-slide-meta,
        .h-btn-outline {
            display: none;
        }
    }

    /* ══════════════════════════════════════
       FILTER BAR
    ══════════════════════════════════════ */
    .mkt-filter-section {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        position: sticky;
        top: 0;
        z-index: 40;
    }

    .mkt-filter-inner {
        padding: 10px 0;
    }

    .mkt-tabs {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
        margin-bottom: 8px;
    }

    .mkt-tab {
        font-size: 11px;
        font-weight: 600;
        padding: 5px 13px;
        border-radius: 999px;
        cursor: pointer;
        background: var(--bg);
        border: 1px solid var(--border);
        color: var(--muted);
        transition: all var(--t);
    }

    .mkt-tab.active {
        background: var(--dark);
        border-color: var(--dark);
        color: #fff;
    }

    .mkt-tab:hover:not(.active) {
        border-color: var(--gold-bd);
        color: var(--text);
    }

    .mkt-filter-row {
        display: flex;
        gap: 6px;
        align-items: center;
        flex-wrap: nowrap;
        overflow-x: auto;
        scrollbar-width: thin;
        padding-bottom: 2px;
    }

    .mkt-filter-row::-webkit-scrollbar {
        height: 3px;
    }

    .mkt-filter-row::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 3px;
    }

    .mkt-filter-row select,
    .mkt-filter-row input[type="text"] {
        font-size: 11px;
        color: var(--text);
        border: 1px solid var(--border);
        border-radius: 8px;
        background: var(--bg);
        padding: 5px 9px;
        outline: none;
        transition: border-color var(--t);
        white-space: nowrap;
        flex-shrink: 0;
        height: 30px;
    }

    .mkt-filter-row select:hover,
    .mkt-filter-row input:hover {
        border-color: var(--gold-bd);
    }

    .mkt-filter-row select:focus,
    .mkt-filter-row input:focus {
        border-color: var(--gold);
    }

    .mkt-filter-row select:disabled {
        opacity: .55;
        cursor: not-allowed;
    }

    .mkt-search-wrap {
        position: relative;
        flex: 0 0 170px;
        min-width: 130px;
        flex-shrink: 0;
    }

    .mkt-search-wrap input {
        width: 100%;
        padding-left: 28px;
        height: 30px;
        border-radius: 15px;
        font-size: 11px;
    }

    .mkt-search-wrap svg {
        position: absolute;
        left: 9px;
        top: 50%;
        transform: translateY(-50%);
        width: 12px;
        height: 12px;
        color: var(--dim);
        pointer-events: none;
    }

    .mkt-clear-btn {
        font-size: 11px;
        font-weight: 600;
        color: var(--gold);
        background: none;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        padding: 6px 8px;
        flex-shrink: 0;
    }

    .mkt-filter-toggle-btn {
        display: none;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--bg);
        color: var(--text);
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        flex-shrink: 0;
        height: 30px;
        transition: all var(--t);
    }

    .mkt-filter-toggle-btn svg {
        width: 12px;
        height: 12px;
        color: var(--gold);
    }

    .mkt-filter-toggle-btn.is-open {
        border-color: var(--gold);
        color: var(--gold);
        background: var(--gold-bg);
    }

    @media (max-width: 640px) {

        .mkt-filter-row select,
        .mkt-filter-row input[type="text"] {
            width: 100%;
        }

        .mkt-search-wrap {
            min-width: 0;
            flex: 1 1 120px;
        }

        .mkt-filter-toggle-btn {
            display: inline-flex;
        }

        #mktPropertyFilters {
            display: none;
            flex-wrap: wrap;
            overflow-x: visible;
            margin-top: 8px;
            gap: 6px;
        }

        #mktPropertyFilters.mkt-filters-open {
            display: flex;
        }

        #mktPropertyFilters select {
            flex: 1 1 calc(50% - 6px);
            min-width: 0;
        }
    }

    /* ══════════════════════════════════════
       LISTINGS GRID
    ══════════════════════════════════════ */
    .mkt-listings-section {
        background: var(--bg);
    }

    .mkt-results-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .mkt-results-count {
        font-size: 12px;
        color: var(--muted);
    }

    .mkt-results-count strong {
        color: var(--text);
    }

    .mkt-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 16px;
    }

    .mkt-card {
        position: relative;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        transition: transform var(--t), box-shadow var(--t), border-color var(--t);
        display: flex;
        flex-direction: column;
    }

    .mkt-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(25, 38, 93, .1);
        border-color: var(--gold-bd);
    }

    .mkt-card-img-wrap {
        position: relative;
        aspect-ratio: 16/11;
        overflow: hidden;
        background: var(--bg);
    }

    .mkt-card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .5s ease;
    }

    .mkt-card:hover .mkt-card-img-wrap img {
        transform: scale(1.06);
    }

    .mkt-badge-row {
        position: absolute;
        top: 9px;
        left: 9px;
        right: 9px;
        display: flex;
        justify-content: space-between;
        gap: 6px;
    }

    .mkt-badge {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        padding: 4px 9px;
        border-radius: 999px;
        backdrop-filter: blur(6px);
    }

    .mkt-badge-type {
        background: rgba(25, 38, 93, .85);
        color: #fff;
    }

    .mkt-badge-type.land {
        background: rgba(208, 82, 8, .85);
    }

    .mkt-badge-type.design {
        background: rgba(107, 114, 133, .85);
    }

    .mkt-badge-new {
        background: var(--gold);
        color: #fff;
    }

    .mkt-badge-condition {
        background: rgba(255, 255, 255, .92);
        color: var(--text);
    }

    .mkt-badge-condition.for_rent {
        color: var(--rent);
    }

    .mkt-badge-condition.for_sale {
        color: var(--dark);
    }

    .mkt-card-body {
        padding: 13px 14px 14px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        flex: 1;
    }

    .mkt-card-price {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
    }

    .mkt-card-price span {
        font-size: 10px;
        font-weight: 500;
        color: var(--muted);
    }

    .mkt-card-title {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text);
        line-height: 1.4;
    }

    .mkt-card-loc {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        color: var(--muted);
    }

    .mkt-card-loc svg {
        width: 12px;
        height: 12px;
        color: var(--gold);
        flex-shrink: 0;
    }

    .mkt-card-meta {
        display: flex;
        align-items: center;
        gap: 11px;
        font-size: 11px;
        color: var(--muted);
        flex-wrap: wrap;
    }

    .mkt-card-meta span {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .mkt-card-meta svg {
        width: 12px;
        height: 12px;
        color: var(--gold);
    }

    .mkt-card-footer {
        margin-top: auto;
        padding-top: 9px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .mkt-card-cta {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 600;
        color: var(--gold);
        transition: gap var(--t);
    }

    .mkt-card:hover .mkt-card-cta {
        gap: 9px;
    }

    .mkt-card-cta svg {
        width: 11px;
        height: 11px;
    }

    .mkt-card-wa-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(37, 211, 102, .12);
        border: 1px solid rgba(37, 211, 102, .3);
        color: var(--whatsapp-dark);
        flex-shrink: 0;
        cursor: pointer;
        transition: background var(--t), color var(--t), transform var(--t);
    }

    .mkt-card-wa-btn:hover,
    .mkt-card-wa-btn:focus-visible {
        background: var(--whatsapp);
        color: #fff;
        transform: scale(1.08);
    }

    .mkt-card-wa-btn svg {
        width: 14px;
        height: 14px;
    }

    .mkt-empty {
        display: none;
        text-align: center;
        padding: 50px 20px;
        color: var(--muted);
    }

    .mkt-empty svg {
        width: 34px;
        height: 34px;
        color: var(--dim);
        margin-bottom: 10px;
    }

    .mkt-empty p {
        font-size: 12px;
    }

    .mkt-empty.show {
        display: block;
    }

    .mkt-loadmore-wrap {
        text-align: center;
        margin-top: 26px;
    }

    .mkt-loadmore-wrap.hide {
        display: none;
    }

    .mkt-load-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 22px;
        border-radius: 999px;
        border: 1px solid var(--gold-bd);
        background: transparent;
        color: var(--gold);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all var(--t);
    }

    .mkt-load-more-btn:hover {
        background: var(--gold);
        color: #fff;
    }

    .mkt-load-more-btn svg {
        width: 12px;
        height: 12px;
    }

    /* ══════════════════════════════════════
       TRUST / FEATURES
    ══════════════════════════════════════ */
    .trust-stats-bar {
        background: var(--dark);
        border-radius: 16px;
        padding: 24px 28px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 36px;
    }

    .trust-stat {
        text-align: center;
        border-right: 1px solid rgba(255, 255, 255, .1);
    }

    .trust-stat:last-child {
        border-right: none;
    }

    .trust-stat-num {
        font-size: 22px;
        font-weight: 600;
        color: #F4F5FA;
    }

    .trust-stat-label {
        font-size: 11px;
        color: rgba(244, 245, 250, .6);
        margin-top: 4px;
    }

    .trust-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    .trust-card {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 20px 18px;
        transition: all var(--t);
    }

    .trust-card:hover {
        border-color: var(--gold-bd);
        transform: translateY(-3px);
    }

    .trust-card-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
        margin-bottom: 12px;
    }

    .trust-card-icon svg {
        width: 16px;
        height: 16px;
        color: var(--gold);
    }

    .trust-card-title {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 5px;
    }

    .trust-card-sub {
        font-size: 11.5px;
        color: var(--muted);
        line-height: 1.55;
    }

    @media (max-width: 900px) {
        .trust-stats-bar {
            grid-template-columns: repeat(2, 1fr);
        }

        .trust-stat:nth-child(2) {
            border-right: none;
        }

        .trust-stat {
            padding-bottom: 12px;
        }

        .trust-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* ══════════════════════════════════════
       DISTRICTS
    ══════════════════════════════════════ */
    .district-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
    }

    .district-card {
        display: block;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 13px;
        padding: 16px;
        color: inherit;
        transition: all var(--t);
    }

    .district-card:hover {
        border-color: var(--gold-bd);
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(25, 38, 93, .08);
    }

    .district-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .district-ico {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
    }

    .district-count {
        font-size: 9.5px;
        font-weight: 600;
        letter-spacing: .05em;
        text-transform: uppercase;
        color: var(--dim);
    }

    .district-name {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 3px;
    }

    .district-sub {
        font-size: 11px;
        color: var(--muted);
    }

    /* ══════════════════════════════════════
       CTA ACTIONS
    ══════════════════════════════════════ */
    .cta-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .cta-act {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 14px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .cta-act svg {
        width: 13px;
        height: 13px;
    }

    .cta-act.mail {
        background: var(--gold);
        color: #fff;
    }

    .cta-act.wa {
        background: rgba(37, 211, 102, .12);
        color: #25D366;
        border: 1px solid rgba(37, 211, 102, .25);
    }

    .cta-act.call {
        background: rgba(255, 255, 255, .08);
        color: #F4F5FA;
        border: 1px solid rgba(255, 255, 255, .15);
    }
</style>

@php
    $waNumber = '250796511725';

    $terraWaLink = function (string $phone, string $itemTitle, string $url): string {
        $message = "Hello, I'm interested in {$itemTitle}. Could you share more details?\n\n{$url}";
        return 'https://wa.me/' . preg_replace('/\D/', '', $phone) . '?text=' . rawurlencode($message);
    };

    // Combined, normalized marketplace items
    $marketplaceItems = collect();

    foreach ($newHouses as $h) {
        $houseUrl = route('front.buy.home.details', $h);
        $houseImg = $h->images->first();

        $marketplaceItems->push([
            'type' => 'house',
            'condition' => $h->condition ?? 'for_sale',
            'title' => $h->title ?? 'House Listing',
            'district' => $h->district ?? '',
            'province' => $h->province ?? '',
            'price' => (float) ($h->price ?? 0),
            'currency' => $h->currency ?? 'RWF',
            'image' => $houseImg ? asset('image/houses/' . $houseImg->image_path) : null,
            'created_at' => $h->created_at,
            'bedrooms' => (int) ($h->bedrooms ?? 0),
            'bathrooms' => (int) ($h->bathrooms ?? 0),
            'size_sqm' => null,
            'property_type' => strtolower($h->type ?? ''),
            'service' => $h->service_id ?? null,
            'url' => $houseUrl,
            'wa_link' => $terraWaLink($waNumber, $h->title ?? 'this house', $houseUrl),
        ]);
    }

    foreach ($newLands as $l) {
        $landUrl = route('front.buy.land.details', $l->id);
        $landImg = $l->images->first();

        $marketplaceItems->push([
            'type' => 'land',
            'condition' => 'for_sale',
            'title' => $l->title ?? 'Land / Plot',
            'district' => $l->district ?? '',
            'province' => $l->province ?? '',
            'price' => (float) ($l->price ?? 0),
            'currency' => $l->currency ?? 'RWF',
            'image' => $landImg ? asset('image/lands/' . $landImg->image_path) : null,
            'created_at' => $l->created_at,
            'bedrooms' => 0,
            'bathrooms' => 0,
            'size_sqm' => $l->size ?? $l->size_sqm ?? null,
            'property_type' => '',
            'service' => $l->service_id ?? null,
            'url' => $landUrl,
            'wa_link' => $terraWaLink($waNumber, $l->title ?? 'this plot', $landUrl),
        ]);
    }

    foreach ($newDesigns as $d) {
        $designUrl = ($d->is_free ?? false) ? '#' : route('front.buy.design.show', $d->slug);
        $designImg = $d->images->first();

        $marketplaceItems->push([
            'type' => 'design',
            'condition' => 'for_sale',
            'title' => $d->title ?? 'Architectural Design',
            'district' => optional($d->category)->name ?? '',
            'province' => '',
            'price' => (float) ($d->price ?? 0),
            'currency' => $d->currency ?? 'RWF',
            'image' => $designImg ? asset('image/architectural_designs/images/' . $designImg->image_path) : null,
            'created_at' => $d->created_at,
            'bedrooms' => 0,
            'bathrooms' => 0,
            'size_sqm' => null,
            'property_type' => '',
            'service' => $d->service_id ?? null,
            'url' => $designUrl,
            'wa_link' => $terraWaLink($waNumber, $d->title ?? 'this design', $designUrl),
        ]);
    }

    $marketplaceItems = $marketplaceItems->sortByDesc('created_at')->values();

    $heroItems = $marketplaceItems->take(8);

    $fallbackImg = asset('front/assets/img/all-images/hero/image-1.png');

    $totalListings = $marketplaceItems->count();
    $totalDistricts = count($districts);
    $totalServiceCount = collect($serviceCategories)
        ->flatMap(fn($cat) => $cat->subCategories ?? [])
        ->flatMap(fn($sub) => $sub->services ?? [])
        ->count();
    $totalCategories = count($serviceCategories);
@endphp

{{-- ══════════════════════════════
     HERO — compact new-listings carousel
══════════════════════════════ --}}
<section class="mkt-hero">
    <div class="container-xl hero-carousel" id="heroCarousel">

        <div class="hero-head">
            <div>
                <div class="mkt-hero-eyebrow">Terra Marketplace</div>
                <h1 class="mkt-hero-kicker-title">Newly added homes, plots &amp; designs in Rwanda</h1>
            </div>

            @if($heroItems->count() > 1)
            <div class="hero-carousel-nav">
                <button type="button" class="hero-nav-btn" id="heroPrev" aria-label="Previous">‹</button>
                <div class="hero-dots" id="heroDots">
                    @foreach($heroItems as $i => $item)
                    <div class="hero-dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"></div>
                    @endforeach
                </div>
                <button type="button" class="hero-nav-btn" id="heroNext" aria-label="Next">›</button>
            </div>
            @endif
        </div>

        <div class="hero-carousel-viewport">
            <div class="hero-carousel-track" id="heroTrack">
                @forelse($heroItems as $i => $item)
                @php
                $isNew = $item['created_at'] && \Carbon\Carbon::parse($item['created_at'])->gt(now()->subDays(7));
                @endphp
                <div class="hero-slide">
                    <div class="hero-slide-image">
                        <img src="{{ $item['image'] ?: $fallbackImg }}" alt="{{ $item['title'] }}" loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                        <div class="hero-slide-badge-row">
                            <span class="hero-slide-badge hero-badge-type {{ $item['type'] }}">{{ ucfirst($item['type']) }}</span>
                            @if($isNew)
                            <span class="hero-slide-badge hero-badge-new">New</span>
                            @endif
                        </div>
                        @if(in_array($item['type'], ['house', 'land']))
                        <div class="hero-slide-badge-row" style="top: auto; bottom: 10px;">
                            <span class="hero-slide-badge hero-badge-condition {{ $item['condition'] }}">{{ $item['condition'] === 'for_rent' ? 'For Rent' : 'For Sale' }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="hero-slide-details">
                        <div class="hero-slide-eyebrow">Recently added</div>
                        <h2 class="hero-slide-title">{{ $item['title'] }}</h2>
                        @if($item['district'] || $item['province'])
                        <div class="hero-slide-loc">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg>
                            {{ $item['district'] }}{{ $item['district'] && $item['province'] ? ', ' : '' }}{{ $item['province'] }}
                        </div>
                        @endif
                        <div class="hero-slide-price">
                            @if($item['price'] > 0)
                            {{ number_format($item['price']) }} <span>{{ $item['currency'] }}</span>
                            @else
                            <span style="font-size:12px;">Get a Quote</span>
                            @endif
                        </div>
                        @if($item['bedrooms'] > 0 || $item['bathrooms'] > 0 || $item['property_type'] || $item['size_sqm'])
                        <div class="hero-slide-meta">
                            @if($item['bedrooms'] > 0)<span>{{ $item['bedrooms'] }} Bedrooms</span>@endif
                            @if($item['bathrooms'] > 0)<span>{{ $item['bathrooms'] }} Bathrooms</span>@endif
                            @if($item['property_type'])<span>{{ ucfirst($item['property_type']) }}</span>@endif
                            @if($item['size_sqm'])<span>{{ $item['size_sqm'] }} sqm plot</span>@endif
                        </div>
                        @endif
                        <div class="hero-slide-actions">
                            <a href="{{ $item['url'] }}" class="h-btn-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                                View Details
                            </a>
                            @if(in_array($item['type'], ['house', 'land']))
                            <a href="{{ $item['wa_link'] }}" target="_blank" rel="noopener" class="h-btn-whatsapp">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
                                    <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" />
                                </svg>
                                WhatsApp
                            </a>
                            @endif
                            <a href="{{ route('front.properties.buy') }}" class="h-btn-outline">Browse All</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="hero-slide hero-slide-empty">
                    <div class="hero-slide-details">
                        <h2 class="hero-slide-title">Find your next home, plot or service in Rwanda</h2>
                        <p style="font-size:12px; color:rgba(244,245,250,.65); max-width:480px; line-height:1.7;">Browse verified houses, plots, architectural designs and real estate services from trusted professionals across Rwanda.</p>
                        <div class="hero-slide-actions">
                            <a href="{{ route('front.properties.buy') }}" class="h-btn-primary">Browse Properties</a>
                            <a href="{{ route('front.properties.sell') }}" class="h-btn-outline">Sell Your Property</a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════
     LIVE FILTER BAR
══════════════════════════════ --}}
<section class="mkt-filter-section">
    <div class="container-xl mkt-filter-inner">
        <div class="mkt-tabs" id="mktTabs">
            <button type="button" class="mkt-tab active" data-type="all">All</button>
            <button type="button" class="mkt-tab" data-type="house">Houses</button>
            <button type="button" class="mkt-tab" data-type="land">Land / Plots</button>
            <button type="button" class="mkt-tab" data-type="design">Designs</button>
        </div>

        <div class="mkt-filter-row" id="mktPropertyFilters">
            <div class="mkt-search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" id="mktSearch" placeholder="Search…" autocomplete="off">
            </div>

            <select id="mktCondition">
                <option value="all">Any Condition</option>
                <option value="for_sale">For Sale</option>
                <option value="for_rent">For Rent</option>
            </select>

            <select id="mktProvince">
                <option value="all">All Provinces</option>
                @foreach($districts as $district => $data)
                <option value="{{ strtolower($district) }}">{{ $district }}</option>
                @endforeach
            </select>

            <select id="mktPrice">
                <option value="all">Any Price</option>
                <option value="0-20000000">Under 20M RWF</option>
                <option value="20000000-50000000">20M – 50M RWF</option>
                <option value="50000000-100000000">50M – 100M RWF</option>
                <option value="100000000-999999999999">Above 100M RWF</option>
            </select>

            <select id="mktBedrooms">
                <option value="all">Any Beds</option>
                <option value="1">1+ Beds</option>
                <option value="2">2+ Beds</option>
                <option value="3">3+ Beds</option>
                <option value="4">4+ Beds</option>
                <option value="5">5+ Beds</option>
            </select>

            <select id="mktPropertyType">
                <option value="all">Any Type</option>
                @foreach(($propertyTypes ?? ['Apartment', 'Villa', 'Bungalow', 'Duplex', 'Studio', 'Commercial']) as $type)
                <option value="{{ strtolower($type) }}">{{ $type }}</option>
                @endforeach
            </select>

            <select id="mktServiceSelect">
                <option value="">Any Service</option>
                @foreach($serviceCategories as $category)
                @foreach(($category->subCategories ?? []) as $sub)
                @foreach(($sub->services ?? []) as $service)
                <option value="{{ $service->id }}">{{ $service->title ?? $service->name ?? 'Service' }}</option>
                @endforeach
                @endforeach
                @endforeach
            </select>

            <select id="mktSort">
                <option value="newest">Newest</option>
                <option value="price_low">Price ↑</option>
                <option value="price_high">Price ↓</option>
            </select>

            <button type="button" class="mkt-clear-btn" id="mktClear">Clear</button>
        </div>

        {{-- Mobile-only: filter toggle + separate search row --}}
        <div class="mkt-filter-row d-flex d-md-none" style="margin-top:8px; overflow:visible; flex-wrap:wrap;">
            <div class="mkt-search-wrap" style="flex:1 1 120px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" id="mktSearchMobile" placeholder="Search…" autocomplete="off">
            </div>
            <button type="button" class="mkt-filter-toggle-btn" id="mktFilterToggle" aria-expanded="false">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 6h16M7 12h10M10 18h4" />
                </svg>
                Filters
            </button>
        </div>
    </div>
</section>

{{-- ══════════════════════════════
     LISTINGS GRID
══════════════════════════════ --}}
<section class="section mkt-listings-section">
    <div class="container-xl">
        <div class="mkt-results-bar">
            <div class="mkt-results-count"><strong id="mktCount">0</strong> results found</div>
        </div>

        <div class="mkt-grid" id="mktGrid">
            @forelse($marketplaceItems as $item)
            @php
            $isNew = $item['created_at'] && \Carbon\Carbon::parse($item['created_at'])->gt(now()->subDays(7));
            @endphp
            <div class="mkt-card"
                data-type="{{ $item['type'] }}"
                data-condition="{{ $item['condition'] }}"
                data-province="{{ strtolower($item['province']) }}"
                data-price="{{ $item['price'] }}"
                data-bedrooms="{{ $item['bedrooms'] }}"
                data-propertytype="{{ $item['property_type'] }}"
                data-service="{{ $item['service'] ?? '' }}"
                data-title="{{ strtolower($item['title'] . ' ' . $item['district'] . ' ' . $item['province']) }}"
                data-created="{{ $item['created_at'] ? \Carbon\Carbon::parse($item['created_at'])->timestamp : 0 }}">
                <a href="{{ $item['url'] }}" class="mkt-card-img-wrap" style="display:block;">
                    <img src="{{ $item['image'] ?: $fallbackImg }}" alt="{{ $item['title'] }}" loading="lazy">
                    <div class="mkt-badge-row">
                        <span class="mkt-badge mkt-badge-type {{ $item['type'] }}">{{ ucfirst($item['type']) }}</span>
                        @if($isNew)
                        <span class="mkt-badge mkt-badge-new">New</span>
                        @endif
                    </div>
                    @if(in_array($item['type'], ['house', 'land']))
                    <div class="mkt-badge-row" style="top: auto; bottom: 9px;">
                        <span class="mkt-badge mkt-badge-condition {{ $item['condition'] }}">{{ $item['condition'] === 'for_rent' ? 'For Rent' : 'For Sale' }}</span>
                    </div>
                    @endif
                </a>
                <a href="{{ $item['url'] }}" class="mkt-card-body" style="display:flex;">
                    <div class="mkt-card-price">
                        @if($item['price'] > 0)
                        {{ number_format($item['price']) }} <span>{{ $item['currency'] }}</span>
                        @else
                        <span style="font-size:12px; font-weight:600; color:var(--service);">Get a Quote</span>
                        @endif
                    </div>
                    <div class="mkt-card-title">{{ $item['title'] }}</div>
                    <div class="mkt-card-loc">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg>
                        {{ $item['district'] }}{{ $item['district'] && $item['province'] ? ', ' : '' }}{{ $item['province'] }}
                    </div>

                    @if($item['type'] === 'house' && ($item['bedrooms'] > 0 || $item['bathrooms'] > 0 || $item['property_type']))
                    <div class="mkt-card-meta">
                        @if($item['bedrooms'] > 0)
                        <span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 18v-6a2 2 0 012-2h14a2 2 0 012 2v6M3 18h18M3 18v2M21 18v2M5 10V7a2 2 0 012-2h3" /></svg>
                            {{ $item['bedrooms'] }} Bed{{ $item['bedrooms'] > 1 ? 's' : '' }}
                        </span>
                        @endif
                        @if($item['bathrooms'] > 0)
                        <span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12h16M6 12V6a2 2 0 012-2h1M6 12v7a1 1 0 001 1h10a1 1 0 001-1v-7" /></svg>
                            {{ $item['bathrooms'] }} Bath{{ $item['bathrooms'] > 1 ? 's' : '' }}
                        </span>
                        @endif
                        @if($item['property_type'])
                        <span>{{ ucfirst($item['property_type']) }}</span>
                        @endif
                    </div>
                    @elseif($item['type'] === 'land')
                    <div class="mkt-card-meta">
                        <span>{{ $item['size_sqm'] ? number_format((float) $item['size_sqm']) . ' sqm plot' : 'Land / Plot' }}</span>
                    </div>
                    @endif

                    <div class="mkt-card-footer">
                        <span class="mkt-card-cta">
                            View Details
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </span>

                        @if(in_array($item['type'], ['house', 'land']))
                        <span class="mkt-card-wa-btn"
                              role="button"
                              tabindex="0"
                              title="Ask about this {{ $item['type'] }} on WhatsApp"
                              aria-label="Ask about this {{ $item['type'] }} on WhatsApp"
                              onclick="event.preventDefault(); event.stopPropagation(); window.open('{{ $item['wa_link'] }}', '_blank', 'noopener');"
                              onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault(); event.stopPropagation(); window.open('{{ $item['wa_link'] }}', '_blank', 'noopener');}">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
                                <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" />
                            </svg>
                        </span>
                        @endif
                    </div>
                </a>
            </div>
            @empty
            <p style="color: var(--muted); font-size: 12px;">No listings yet.</p>
            @endforelse
        </div>

        <div class="mkt-empty" id="mktEmpty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8" />
                <path d="M21 21l-4.35-4.35" />
            </svg>
            <p>Nothing matches your filters. Try adjusting them.</p>
        </div>

        <div class="mkt-loadmore-wrap" id="mktLoadMoreWrap">
            <button type="button" class="mkt-load-more-btn" id="mktLoadMore">
                Load More
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14" />
                </svg>
            </button>
        </div>
    </div>
</section>


@include('property-request._recent')

{{-- ══════════════════════════════
     DISTRICTS SECTION
══════════════════════════════ --}}
<section class="section" style="background: var(--bg);">
    <div class="container-xl">
        <div style="text-align:center; margin-bottom:32px;">
            <div class="eyebrow">Browse by Location</div>
            <h2 class="section-title">Properties across every district</h2>
            <p class="section-sub" style="margin: 8px auto 0">Find the perfect property in your preferred location in Rwanda.</p>
        </div>

        <div class="district-grid">
            @foreach($districts as $district => $data)
            <a href="{{ route('properties.by.province', $district) }}" class="district-card fu">
                <div class="district-top">
                    <div class="district-ico">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="var(--gold)">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg>
                    </div>
                    <span class="district-count">{{ $data['total'] ?? 0 }} listings</span>
                </div>
                <div class="district-name">{{ $district }}</div>
                <div class="district-sub">{{ $data['total'] ?? 0 }} {{ ($data['total'] ?? 0) == 1 ? 'property' : 'properties' }} available</div>
            </a>
            @endforeach
        </div>
    </div>
</section>


@include('front.testimonials._section')

{{-- ══════════════════════════════
     CTA SECTION
══════════════════════════════ --}}
<div class="cta1-section-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cta-bg-area" style="background-image: url(front/assets/img/all-images/bg/cta-bg1.png); background-position: center; background-repeat: no-repeat; background-size: cover;">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <div class="cta-header">
                                <h2 class="text-anime-style-3" style="perspective: 400px; font-family: var(--font); font-size: clamp(20px, 2.6vw, 28px); font-weight: 600;">Real Estate Consultation</h2>
                                <div class="space16"></div>
                                <p data-aos="fade-left" data-aos-duration="1000" class="aos-init aos-animate" style="font-size:13px;">Our team of experts is available Monday to Friday, 9am–6pm. Reach out and we'll guide you every step of the way.</p>
                            </div>
                        </div>
                        <div class="col-lg-5 aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1000">
                            <div class="cta-actions">
                                <a href="mailto:terraltd.rd@gmail.com" class="cta-act mail">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                    </svg>
                                    Send an Email
                                </a>
                                <a href="https://wa.me/+{{ $waNumber }}" target="_blank" rel="noopener" class="cta-act wa">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
                                        <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" />
                                    </svg>
                                    WhatsApp Chat
                                </a>
                                <a href="tel:+{{ $waNumber }}" class="cta-act call">
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
        /* ── Hero property carousel ── */
        const heroTrack = document.getElementById('heroTrack');
        if (heroTrack) {
            const slides = Array.from(heroTrack.children);
            const dotsWrap = document.getElementById('heroDots');
            const dots = dotsWrap ? Array.from(dotsWrap.children) : [];
            const prevBtn = document.getElementById('heroPrev');
            const nextBtn = document.getElementById('heroNext');
            let current = 0;
            let timer = null;

            function goTo(i) {
                current = (i + slides.length) % slides.length;
                heroTrack.style.transform = `translateX(-${current * 100}%)`;
                dots.forEach((d, idx) => d.classList.toggle('active', idx === current));
            }

            function next() { goTo(current + 1); }
            function prev() { goTo(current - 1); }

            function startAutoplay() {
                if (slides.length <= 1) return;
                stopAutoplay();
                timer = setInterval(next, 6000);
            }

            function stopAutoplay() {
                if (timer) clearInterval(timer);
                timer = null;
            }

            if (nextBtn) nextBtn.addEventListener('click', () => { next(); startAutoplay(); });
            if (prevBtn) prevBtn.addEventListener('click', () => { prev(); startAutoplay(); });
            dots.forEach((dot, idx) => dot.addEventListener('click', () => { goTo(idx); startAutoplay(); }));

            const carouselEl = document.getElementById('heroCarousel');
            if (carouselEl) {
                carouselEl.addEventListener('mouseenter', stopAutoplay);
                carouselEl.addEventListener('mouseleave', startAutoplay);
            }

            goTo(0);
            startAutoplay();
        }

        /* ── Mobile filter panel toggle ── */
        const filterToggleBtn = document.getElementById('mktFilterToggle');
        const propertyFiltersRow = document.getElementById('mktPropertyFilters');
        if (filterToggleBtn && propertyFiltersRow) {
            filterToggleBtn.addEventListener('click', () => {
                const isOpen = propertyFiltersRow.classList.toggle('mkt-filters-open');
                filterToggleBtn.classList.toggle('is-open', isOpen);
                filterToggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        }

        /* ── Sync mobile search with main search ── */
        const mktSearch = document.getElementById('mktSearch');
        const mktSearchMobile = document.getElementById('mktSearchMobile');
        if (mktSearch && mktSearchMobile) {
            mktSearchMobile.addEventListener('input', () => { mktSearch.value = mktSearchMobile.value; mktSearch.dispatchEvent(new Event('input')); });
            mktSearch.addEventListener('input', () => { mktSearchMobile.value = mktSearch.value; });
        }

        /* ── Listings filter grid ── */
        const PAGE_SIZE = 9;

        const grid = document.getElementById('mktGrid');
        const countEl = document.getElementById('mktCount');
        const emptyEl = document.getElementById('mktEmpty');
        const loadMoreWrap = document.getElementById('mktLoadMoreWrap');
        const loadMoreBtn = document.getElementById('mktLoadMore');

        if (!grid) return;

        const allCards = Array.from(grid.querySelectorAll('.mkt-card'));
        let visibleCards = [...allCards];
        let shown = 0;

        function activeTab() {
            const btn = document.querySelector('.mkt-tab.active');
            return btn ? btn.dataset.type : 'all';
        }

        function applyFilters() {
            const tab = activeTab();
            const search = (mktSearch ? mktSearch.value : '').toLowerCase().trim();
            const condition = document.getElementById('mktCondition')?.value || 'all';
            const province = document.getElementById('mktProvince')?.value || 'all';
            const price = document.getElementById('mktPrice')?.value || 'all';
            const bedrooms = document.getElementById('mktBedrooms')?.value || 'all';
            const propertyType = document.getElementById('mktPropertyType')?.value || 'all';
            const serviceId = document.getElementById('mktServiceSelect')?.value || '';
            const sort = document.getElementById('mktSort')?.value || 'newest';

            visibleCards = allCards.filter(card => {
                if (tab !== 'all' && card.dataset.type !== tab) return false;
                if (condition !== 'all' && card.dataset.condition !== condition) return false;
                if (province !== 'all' && card.dataset.province !== province) return false;
                if (bedrooms !== 'all' && parseInt(card.dataset.bedrooms) < parseInt(bedrooms)) return false;
                if (propertyType !== 'all' && card.dataset.propertytype !== propertyType) return false;
                if (serviceId && card.dataset.service !== serviceId) return false;

                if (price !== 'all') {
                    const [min, max] = price.split('-').map(Number);
                    const p = parseFloat(card.dataset.price);
                    if (p < min || p > max) return false;
                }

                if (search && !card.dataset.title.includes(search)) return false;

                return true;
            });

            visibleCards.sort((a, b) => {
                if (sort === 'price_low') return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                if (sort === 'price_high') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                return parseInt(b.dataset.created) - parseInt(a.dataset.created);
            });

            if (countEl) countEl.textContent = visibleCards.length;

            allCards.forEach(c => { c.style.display = 'none'; c.style.order = ''; });
            visibleCards.forEach((c, i) => { c.style.order = i; });

            shown = 0;
            showMore();

            if (emptyEl) emptyEl.classList.toggle('show', visibleCards.length === 0);
        }

        function showMore() {
            const next = Math.min(shown + PAGE_SIZE, visibleCards.length);
            for (let i = shown; i < next; i++) {
                visibleCards[i].style.display = '';
            }
            shown = next;
            if (loadMoreWrap) loadMoreWrap.classList.toggle('hide', shown >= visibleCards.length);
        }

        /* tabs */
        document.querySelectorAll('.mkt-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.mkt-tab.active').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                applyFilters();
            });
        });

        /* selects */
        ['mktCondition', 'mktProvince', 'mktPrice', 'mktBedrooms', 'mktPropertyType', 'mktServiceSelect', 'mktSort'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('change', applyFilters);
        });

        /* search */
        if (mktSearch) mktSearch.addEventListener('input', applyFilters);

        /* clear */
        const clearBtn = document.getElementById('mktClear');
        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                document.querySelectorAll('.mkt-tab.active').forEach(t => t.classList.remove('active'));
                document.querySelector('.mkt-tab[data-type="all"]').classList.add('active');
                if (mktSearch) mktSearch.value = '';
                if (mktSearchMobile) mktSearchMobile.value = '';
                ['mktCondition', 'mktProvince', 'mktPrice', 'mktBedrooms', 'mktPropertyType', 'mktServiceSelect'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.selectedIndex = 0;
                });
                const sortEl = document.getElementById('mktSort');
                if (sortEl) sortEl.value = 'newest';
                applyFilters();
            });
        }

        /* load more */
        if (loadMoreBtn) loadMoreBtn.addEventListener('click', showMore);

        /* initial render */
        applyFilters();
    })();
</script>
@endsection