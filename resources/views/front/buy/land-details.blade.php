@extends('layouts.guest')
@section('title', $land->title)
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --surface: #FFFFFF;
        --dark: #0E0E0C;
        --border: rgba(0, 0, 0, .08);
        --border2: rgba(0, 0, 0, .14);
        --gold: #C8873A;
        --gold-lt: #E5A55E;
        --gold-bg: rgba(200, 135, 58, .07);
        --gold-bd: rgba(200, 135, 58, .22);
        --text: #19265d;
        --muted: #6B6560;
        --dim: #9E9890;
        --amber: #8B6914;
        --amber-bg: rgba(139, 105, 20, .08);
        --amber-bd: rgba(139, 105, 20, .22);
        --green: #1E7A5A;
        --green-bg: rgba(30, 122, 90, .07);
        --green-bd: rgba(30, 122, 90, .2);
        --r: 12px;
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

    /* ── Breadcrumb ── */
    .ld-breadcrumb {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 12px 0;
    }

    .ld-bc-inner {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: .75rem;
        color: var(--dim);
        flex-wrap: wrap;
    }

    .ld-bc-inner a {
        color: var(--muted);
        transition: color var(--t);
    }

    .ld-bc-inner a:hover {
        color: var(--gold);
    }

    .ld-bc-inner svg {
        width: 12px;
        height: 12px;
        color: var(--dim);
    }

    .ld-bc-inner .cur {
        color: var(--text);
        font-weight: 500;
    }

    /* ── Gallery ── */
    .ld-gallery {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 280px 180px;
        gap: 8px;
        border-radius: var(--r);
        overflow: hidden;
        position: relative;
        margin-bottom: 32px;
    }

    @media (max-width: 768px) {
        .ld-gallery {
            grid-template-columns: 1fr;
            grid-template-rows: 240px 140px 140px;
        }
    }

    .ld-gallery-main {
        grid-row: 1 / 3;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .ld-gallery-thumb {
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .ld-gallery-main img,
    .ld-gallery-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .5s ease;
    }

    .ld-gallery-main:hover img,
    .ld-gallery-thumb:hover img {
        transform: scale(1.04);
    }

    .ld-gallery-counter {
        position: absolute;
        bottom: 12px;
        right: 12px;
        background: rgba(14, 14, 12, .72);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, .12);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: .72rem;
        color: rgba(255, 255, 255, .75);
        font-weight: 500;
        cursor: pointer;
    }

    /* Lightbox */
    .ld-lightbox {
        position: fixed;
        inset: 0;
        z-index: 2000;
        background: rgba(0, 0, 0, .92);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .ld-lightbox.active {
        display: flex;
    }

    .ld-lb-img {
        max-width: 900px;
        max-height: 80vh;
        border-radius: 8px;
        display: block;
    }

    .ld-lb-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .2);
        display: grid;
        place-items: center;
        cursor: pointer;
        color: #fff;
    }

    .ld-lb-close svg {
        width: 18px;
        height: 18px;
    }

    .ld-lb-prev,
    .ld-lb-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .15);
        display: grid;
        place-items: center;
        cursor: pointer;
        color: #fff;
        transition: background var(--t);
    }

    .ld-lb-prev:hover,
    .ld-lb-next:hover {
        background: rgba(255, 255, 255, .22);
    }

    .ld-lb-prev {
        left: 20px;
    }

    .ld-lb-next {
        right: 20px;
    }

    .ld-lb-prev svg,
    .ld-lb-next svg {
        width: 18px;
        height: 18px;
    }

    .ld-lb-strip {
        position: absolute;
        bottom: 16px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 6px;
    }

    .ld-lb-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .3);
        cursor: pointer;
    }

    .ld-lb-dot.on {
        background: var(--gold);
        width: 18px;
        border-radius: 3px;
    }

    /* ── Page layout ── */
    .ld-page {
        padding: 28px 0 80px;
    }

    .ld-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 960px) {
        .ld-layout {
            grid-template-columns: 1fr;
        }
    }

    /* ── Panel ── */
    .ld-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        margin-bottom: 16px;
    }

    .ld-panel-head {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ld-panel-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .ld-panel-icon svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
    }

    .ld-panel-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: -.01em;
        color: var(--text);
        margin: 0;
    }

    .ld-panel-body {
        padding: 18px 20px;
    }

    /* ── Title block ── */
    .ld-title-block {
        margin-bottom: 4px;
    }

    .ld-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        border-radius: 6px;
        background: var(--amber-bg);
        border: 1px solid var(--amber-bd);
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--amber);
        margin-bottom: 10px;
    }

    .ld-type-badge svg {
        width: 11px;
        height: 11px;
    }

    .ld-main-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        font-weight: 500;
        line-height: 1.15;
        letter-spacing: -.02em;
        color: var(--text);
        margin-bottom: 10px;
    }

    .ld-location-line {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: .83rem;
        color: var(--muted);
    }

    .ld-location-line svg {
        width: 13px;
        height: 13px;
        color: var(--gold);
        flex-shrink: 0;
    }

    /* Price + share */
    .ld-price-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        padding: 18px 20px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        margin-bottom: 16px;
    }

    .ld-price-main {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--gold);
        line-height: 1;
        letter-spacing: -.02em;
    }

    .ld-price-main span {
        font-size: .85rem;
        font-weight: 400;
        color: var(--muted);
        font-family: 'DM Sans', sans-serif;
        margin-left: 4px;
    }

    .ld-price-meta {
        font-size: .75rem;
        color: var(--dim);
        margin-top: 3px;
    }

    .ld-share-btns {
        display: flex;
        gap: 6px;
    }

    .ld-share-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--bg);
        display: grid;
        place-items: center;
        cursor: pointer;
        color: var(--muted);
        transition: all var(--t);
    }

    .ld-share-btn:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    .ld-share-btn svg {
        width: 14px;
        height: 14px;
    }

    /* Specs chips */
    .ld-specs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .ld-spec {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 7px 13px;
        border-radius: 9px;
        background: var(--bg);
        border: 1px solid var(--border);
        font-size: .8rem;
        color: var(--muted);
        font-weight: 500;
    }

    .ld-spec svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
    }

    .ld-spec strong {
        color: var(--text);
        margin-left: 2px;
    }

    /* Description */
    .ld-desc {
        font-size: .85rem;
        color: var(--muted);
        line-height: 1.8;
    }

    /* Details table */
    .ld-table {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .ld-table-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--border);
        font-size: .82rem;
    }

    .ld-table-row:last-child {
        border-bottom: none;
    }

    .ld-table-label {
        color: var(--dim);
        font-weight: 500;
    }

    .ld-table-val {
        color: var(--text);
        font-weight: 600;
        text-align: right;
        max-width: 60%;
    }

    /* UPI badge */
    .ld-upi {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 6px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        font-size: .78rem;
        font-weight: 700;
        color: var(--gold);
        font-family: 'DM Mono', monospace;
        letter-spacing: .04em;
    }

    /* Map */
    .ld-map {
        width: 100%;
        height: 280px;
        border: none;
        display: block;
        border-radius: var(--r);
        filter: grayscale(15%);
    }

    /* Doc download */
    .ld-doc-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 9px;
        border: 1px solid var(--border);
        background: var(--bg);
        transition: border-color var(--t), background var(--t);
        margin-bottom: 8px;
    }

    .ld-doc-row:last-child {
        margin-bottom: 0;
    }

    .ld-doc-row:hover {
        border-color: var(--gold-bd);
        background: var(--gold-bg);
    }

    .ld-doc-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: rgba(220, 38, 38, .08);
        border: 1px solid rgba(220, 38, 38, .2);
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .ld-doc-icon svg {
        width: 15px;
        height: 15px;
        color: #dc2626;
    }

    .ld-doc-name {
        font-size: .82rem;
        font-weight: 500;
        color: var(--text);
    }

    .ld-doc-sub {
        font-size: .72rem;
        color: var(--dim);
    }

    .ld-doc-dl {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .75rem;
        color: var(--gold);
        font-weight: 600;
        flex-shrink: 0;
        transition: gap var(--t);
    }

    .ld-doc-row:hover .ld-doc-dl {
        gap: 8px;
    }

    .ld-doc-dl svg {
        width: 13px;
        height: 13px;
    }

    /* ══ SIDEBAR ══ */
    .ld-sidebar {
        position: sticky;
        top: 24px;
    }

    /* Price card */
    .ld-sidebar-price {
        background: var(--dark);
        border-radius: var(--r);
        overflow: hidden;
        margin-bottom: 14px;
        position: relative;
    }

    .ld-sidebar-price::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 70% 60% at 20% 50%, rgba(200, 135, 58, .16) 0%, transparent 65%);
        pointer-events: none;
    }

    .ld-sidebar-price-inner {
        position: relative;
        z-index: 1;
        padding: 22px 20px;
    }

    .ld-sb-price-label {
        font-size: .68rem;
        color: rgba(240, 237, 232, .4);
        text-transform: uppercase;
        letter-spacing: .1em;
        margin-bottom: 6px;
    }

    .ld-sb-price-val {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.7rem;
        font-weight: 600;
        color: #F0EDE8;
        letter-spacing: -.02em;
        line-height: 1;
        margin-bottom: 4px;
    }

    .ld-sb-price-unit {
        font-size: .75rem;
        color: rgba(240, 237, 232, .4);
    }

    .ld-sb-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 9px;
        border-radius: 5px;
        margin-top: 12px;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        background: rgba(30, 122, 90, .2);
        border: 1px solid rgba(30, 122, 90, .3);
        color: #4ade80;
    }

    .ld-sb-status::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #4ade80;
    }

    /* Seller card */
    .ld-seller-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        margin-bottom: 14px;
    }

    .ld-seller-head {
        padding: 16px 18px;
        border-bottom: 1px solid var(--border);
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text);
    }

    .ld-seller-body {
        padding: 16px 18px;
    }

    .ld-seller-info {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .ld-seller-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        border: 2px solid var(--border);
        overflow: hidden;
        flex-shrink: 0;
        background: var(--bg);
    }

    .ld-seller-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .ld-seller-name {
        font-size: .88rem;
        font-weight: 600;
        color: var(--text);
    }

    .ld-seller-role {
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--gold);
        margin-top: 2px;
    }

    .ld-seller-rows {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .ld-seller-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid var(--border);
        font-size: .79rem;
    }

    .ld-seller-row:last-child {
        border-bottom: none;
    }

    .ld-seller-row-label {
        color: var(--dim);
    }

    .ld-seller-row-val {
        color: var(--text);
        font-weight: 500;
        text-align: right;
    }

    /* CTA buttons */
    .ld-cta-btns {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-top: 14px;
    }

    .ld-btn-inquiry {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 12px 16px;
        border-radius: 9px;
        background: var(--gold);
        border: none;
        color: #fff;
        font-size: .85rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background var(--t), transform var(--t);
        width: 100%;
    }

    .ld-btn-inquiry:hover {
        background: #a06828;
        transform: translateY(-1px);
    }

    .ld-btn-inquiry svg {
        width: 14px;
        height: 14px;
    }

    .ld-contact-row {
        display: flex;
        gap: 8px;
    }

    .ld-contact-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px;
        border-radius: 9px;
        border: 1px solid var(--border);
        background: var(--bg);
        font-size: .77rem;
        font-weight: 500;
        color: var(--muted);
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: all var(--t);
        text-decoration: none;
    }

    .ld-contact-btn:hover {
        border-color: var(--gold-bd);
        color: var(--gold);
    }

    .ld-contact-btn svg {
        width: 13px;
        height: 13px;
    }

    /* Notice */
    .ld-notice {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        padding: 11px 14px;
        border-radius: 9px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        font-size: .76rem;
        color: var(--muted);
        line-height: 1.6;
        margin-top: 10px;
    }

    .ld-notice svg {
        width: 13px;
        height: 13px;
        color: var(--gold);
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* ══ RELATED ══ */
    .ld-related {
        padding: 48px 0 0;
    }

    .ld-related-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .ld-related-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 500;
        color: var(--text);
        margin: 0;
    }

    .ld-related-title em {
        font-style: italic;
        color: var(--gold);
    }

    .ld-see-all {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .78rem;
        color: var(--gold);
        font-weight: 500;
        border-bottom: 1px solid var(--gold-bd);
        transition: gap var(--t);
    }

    .ld-see-all:hover {
        gap: 9px;
    }

    .ld-see-all svg {
        width: 12px;
        height: 12px;
    }

    .ld-related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 14px;
    }

    /* Related card */
    .ld-rcard {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform var(--t), border-color var(--t), box-shadow var(--t);
        color: var(--text);
    }

    .ld-rcard:hover {
        transform: translateY(-4px);
        border-color: var(--gold-bd);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .09);
        color: var(--text);
    }

    .ld-rcard-img {
        position: relative;
        aspect-ratio: 16/10;
        overflow: hidden;
        background: var(--bg);
    }

    .ld-rcard-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .45s ease;
    }

    .ld-rcard:hover .ld-rcard-img img {
        transform: scale(1.06);
    }

    .ld-rcard-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        padding: 2px 7px;
        border-radius: 5px;
        font-size: .64rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        background: var(--amber);
        color: #fff;
        z-index: 2;
    }

    .ld-rcard-body {
        padding: 12px 14px 14px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .ld-rcard-title {
        font-size: .87rem;
        font-weight: 600;
        color: var(--text);
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .ld-rcard-loc {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .73rem;
        color: var(--muted);
    }

    .ld-rcard-loc svg {
        width: 11px;
        height: 11px;
        color: var(--gold);
    }

    .ld-rcard-stats {
        display: flex;
        gap: 8px;
    }

    .ld-rcard-stat {
        font-size: .72rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .ld-rcard-stat svg {
        width: 11px;
        height: 11px;
    }

    .ld-rcard-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid var(--border);
        padding-top: 9px;
        margin-top: auto;
    }

    .ld-rcard-price {
        font-size: .88rem;
        font-weight: 700;
        color: var(--gold);
    }

    .ld-rcard-price span {
        font-size: .68rem;
        font-weight: 400;
        color: var(--dim);
    }

    .ld-rcard-cta {
        font-size: .73rem;
        font-weight: 600;
        color: var(--gold);
        display: flex;
        align-items: center;
        gap: 3px;
        transition: gap var(--t);
    }

    .ld-rcard:hover .ld-rcard-cta {
        gap: 7px;
    }

    .ld-rcard-cta svg {
        width: 11px;
        height: 11px;
    }

    /* ══ INQUIRY MODAL ══ */
    .ld-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 1000;
        background: rgba(10, 10, 8, .65);
        backdrop-filter: blur(6px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .ld-modal-overlay.open {
        display: flex;
    }

    .ld-modal-box {
        background: var(--surface);
        border-radius: 16px;
        width: 100%;
        max-width: 480px;
        overflow: hidden;
        box-shadow: 0 28px 72px rgba(0, 0, 0, .18);
        animation: ldMIn .3s ease both;
    }

    @keyframes ldMIn {
        from {
            opacity: 0;
            transform: scale(.96) translateY(8px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .ld-modal-head {
        background: var(--dark);
        padding: 22px 24px;
        position: relative;
        overflow: hidden;
    }

    .ld-modal-head::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 65% 80% at 15% 50%, rgba(200, 135, 58, .15) 0%, transparent 65%);
        pointer-events: none;
    }

    .ld-modal-head-inner {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

    .ld-modal-head h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 500;
        color: #F0EDE8;
        margin: 0;
    }

    .ld-modal-head p {
        font-size: .73rem;
        color: rgba(240, 237, 232, .4);
        margin-top: 2px;
    }

    .ld-modal-close {
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .15);
        border-radius: 7px;
        width: 30px;
        height: 30px;
        display: grid;
        place-items: center;
        cursor: pointer;
        color: #F0EDE8;
        flex-shrink: 0;
        transition: background var(--t);
    }

    .ld-modal-close:hover {
        background: rgba(255, 255, 255, .2);
    }

    .ld-modal-close svg {
        width: 15px;
        height: 15px;
    }

    .ld-modal-body {
        padding: 20px 22px 22px;
    }

    .ld-modal-field {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 13px;
    }

    .ld-modal-field label {
        font-size: .7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--muted);
    }

    .ld-modal-field input,
    .ld-modal-field textarea {
        padding: 10px 12px;
        background: var(--bg);
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-size: .84rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        transition: border-color var(--t), box-shadow var(--t), background var(--t);
        width: 100%;
    }

    .ld-modal-field input:focus,
    .ld-modal-field textarea:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(200, 135, 58, .1);
        background: var(--surface);
    }

    .ld-modal-field textarea {
        resize: vertical;
        min-height: 90px;
    }

    .ld-modal-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        padding: 12px 16px;
        border-radius: 9px;
        background: var(--gold);
        border: none;
        color: #fff;
        font-size: .85rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background var(--t);
        margin-top: 4px;
    }

    .ld-modal-submit:hover {
        background: #a06828;
    }

    .ld-modal-submit svg {
        width: 14px;
        height: 14px;
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

{{-- ── Breadcrumb ── --}}
<div class="ld-breadcrumb">
    <div class="container">
        <div class="ld-bc-inner">
            <a href="{{ route('front.home') }}">Home</a>
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 6l6 6-6 6" />
            </svg>
            <a href="{{ route('front.buy.lands') }}">Plots for Sale</a>
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 6l6 6-6 6" />
            </svg>
            <span class="cur">{{ Str::limit($land->title, 40) }}</span>
        </div>
    </div>
</div>

<div class="ld-page">
    <div class="container">

        {{-- ── Gallery ── --}}
        @php
        $imgs = $land->images->map(fn($img) => asset('image/lands/' . $img->image_path))->values();
        $placeholder = asset('assets/img/placeholder-land.jpg');
        $main = $imgs[0] ?? $placeholder;
        $thumb1 = $imgs[1] ?? $placeholder;
        $thumb2 = $imgs[2] ?? $placeholder;
        $total = $imgs->count();
        @endphp

        @if($total > 0)
        <div class="ld-gallery" id="ld-gallery">
            <div class="ld-gallery-main" onclick="openLightbox(0)" style="cursor:pointer">
                <img id="gal-main" src="{{ $main }}" alt="{{ $land->title }}">
            </div>

            @if($total > 1)
            <div class="ld-gallery-thumb" onclick="openLightbox(1)" style="cursor:pointer">
                <img src="{{ $thumb1 }}" alt="{{ $land->title }}">
            </div>
            @endif

            @if($total > 2)
            <div class="ld-gallery-thumb" onclick="openLightbox(2)" style="cursor:pointer;position:relative">
                <img src="{{ $thumb2 }}" alt="{{ $land->title }}">
                @if($total > 3)
                <div class="ld-gallery-counter" onclick="event.stopPropagation();openLightbox(0)">
                    +{{ $total - 3 }} photos
                </div>
                @endif
            </div>
            @endif
        </div>
        @else
        {{-- No images uploaded --}}
        <div class="ld-gallery-empty d-flex align-items-center justify-content-center bg-light rounded mb-4"
            style="height:260px;">
            <div class="text-center text-muted">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                    style="width:40px;height:40px;margin-bottom:.5rem;opacity:.4">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <circle cx="8.5" cy="8.5" r="1.5" />
                    <path d="M21 15l-5-5L5 21" />
                </svg>
                <p class="small mb-0">No images uploaded</p>
            </div>
        </div>
        @endif

        {{-- ── Lightbox ── --}}
        <div class="ld-lightbox" id="ld-lightbox" onclick="closeLbBg(event)">
            <button class="ld-lb-close" onclick="closeLightbox()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" />
                </svg>
            </button>
            <button class="ld-lb-prev" onclick="lbNav(-1)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </button>
            <img class="ld-lb-img" id="lb-img" src="" alt="{{ $land->title }}">
            <button class="ld-lb-next" onclick="lbNav(1)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </button>
            <div class="ld-lb-strip" id="lb-strip"></div>
        </div>

        {{-- ── Main layout ── --}}
        <div class="ld-layout">

            {{-- ══ LEFT COLUMN ══ --}}
            <div>

                {{-- Title + price ── --}}
                <div class="ld-title-block">
                    <div class="ld-type-badge">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5z" />
                        </svg>
                        Plot for Sale
                    </div>
                    <h1 class="ld-main-title">{{ $land->title }}</h1>
                    <div class="ld-location-line">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                        </svg>
                        {{ $land->village }}, {{ $land->cell }}, {{ $land->sector }}, {{ $land->district }}, {{ $land->province }}
                    </div>
                </div>

                <div class="ld-price-row" style="margin-top:14px">
                    <div>
                        <div class="ld-price-main">{{ number_format($land->price) }}<span>RWF</span></div>
                        <div class="ld-price-meta">{{ $land->service->title ?? 'For Sale' }}</div>
                    </div>
                    <div class="ld-share-btns">
                        
                        <button class="ld-share-btn" id="copyLinkBtn" title="Copy link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                    </svg>
                </button>
                    </div>
                </div>

                {{-- Specs chips --}}
                <div class="ld-specs">
                    @if($land->size_sqm)
                    <div class="ld-spec">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z" />
                        </svg>
                        <strong>{{ number_format($land->size_sqm) }}</strong> sqm
                    </div>
                    @endif
                    @if($land->zoning)
                    <div class="ld-spec">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A4.49 4.49 0 008 20C19 20 22 3 22 3c-1 2-8 2-9 0-2-2-3-4-3-4z" />
                        </svg>
                        <strong>{{ $land->zoning }}</strong>
                    </div>
                    @endif
                    @if($land->land_use)
                    <div class="ld-spec">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                        </svg>
                        <strong>{{ $land->land_use }}</strong>
                    </div>
                    @endif
                    @if($land->status)
                    <div class="ld-spec">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <strong>{{ ucfirst($land->status) }}</strong>
                    </div>
                    @endif
                    {{-- ── View count (total, human-formatted) ── --}}
                    @if($land->views_count > 0)
                    <span class="view-chip">
                        {{-- Eye icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                        {{ number_format($land->views_count) }} {{ Str::plural('view', $land->views_count) }}
                    </span>
                    @endif
                </div>

                {{-- About --}}
                @if($land->description)
                <div class="ld-panel">
                    <div class="ld-panel-head">
                        <div class="ld-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                            </svg></div>
                        <p class="ld-panel-title">About This Plot</p>
                    </div>
                    <div class="ld-panel-body">
                        <p class="ld-desc">{{ $land->description }}</p>
                    </div>
                </div>
                @endif

                {{-- Property Details ── --}}
                <div class="ld-panel">
                    <div class="ld-panel-head">
                        <div class="ld-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                            </svg></div>
                        <p class="ld-panel-title">Land Details</p>
                    </div>
                    <div class="ld-panel-body">
                        <div class="ld-table">
                            <div class="ld-table-row">
                                <span class="ld-table-label">Land UPI</span>
                                <span class="ld-table-val">
                                    @if($land->upi)
                                    <span class="ld-upi">{{ $land->upi }}</span>
                                    @else — @endif
                                </span>
                            </div>
                            <div class="ld-table-row">
                                <span class="ld-table-label">Zoning</span>
                                <span class="ld-table-val">{{ $land->zoning ?? '—' }}</span>
                            </div>
                            <div class="ld-table-row">
                                <span class="ld-table-label">Land Use</span>
                                <span class="ld-table-val">{{ $land->land_use ?? '—' }}</span>
                            </div>
                            <div class="ld-table-row">
                                <span class="ld-table-label">Size</span>
                                <span class="ld-table-val">{{ $land->size_sqm ? number_format($land->size_sqm).' sqm' : '—' }}</span>
                            </div>
                            <div class="ld-table-row">
                                <span class="ld-table-label">Status</span>
                                <span class="ld-table-val">{{ ucfirst($land->status ?? 'Available') }}</span>
                            </div>
                            <div class="ld-table-row">
                                <span class="ld-table-label">Province</span>
                                <span class="ld-table-val">{{ $land->province }}</span>
                            </div>
                            <div class="ld-table-row">
                                <span class="ld-table-label">District</span>
                                <span class="ld-table-val">{{ $land->district }}</span>
                            </div>
                            <div class="ld-table-row">
                                <span class="ld-table-label">Sector / Cell</span>
                                <span class="ld-table-val">{{ $land->sector }}, {{ $land->cell }}</span>
                            </div>
                            <div class="ld-table-row">
                                <span class="ld-table-label">Village</span>
                                <span class="ld-table-val">{{ $land->village }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Title Document ── --}}
                @if($land->title_doc)
                <div class="ld-panel">
                    <div class="ld-panel-head">
                        <div class="ld-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                                <path d="M14 2v6h6" />
                            </svg></div>
                        <p class="ld-panel-title">Documents</p>
                    </div>
                    <div class="ld-panel-body">
                        <a href="{{ asset('storage/'.$land->title_doc) }}" download class="ld-doc-row" style="display:flex">
                            <div class="ld-doc-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                                </svg>
                            </div>
                            <div>
                                <div class="ld-doc-name">{{ $land->title }} — Title Document</div>
                                <div class="ld-doc-sub">{{ $land->service->title ?? 'Land document' }}</div>
                            </div>
                            <div class="ld-doc-dl">
                                Download
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
                @endif

                {{-- Map ── --}}
                <div class="ld-panel">
                    <div class="ld-panel-head">
                        <div class="ld-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg></div>
                        <p class="ld-panel-title">Map Location</p>
                    </div>
                    <div style="overflow:hidden;border-radius:0 0 var(--r) var(--r)">
                        @if($land->latitude && $land->longitude)
                        <iframe
                            src="https://www.google.com/maps?q={{ $land->latitude }},{{ $land->longitude }}&z=15&output=embed"
                            width="100%"
                            height="250"
                            style="border:0;"
                            allowfullscreen="" loading="lazy"
                        ></iframe>
                        @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height:250px;color:var(--muted);font-size:.85rem">
                            Location not provided
                        </div>
                        @endif
                    </div>
                    <div class="ld-panel-body" style="border-top: 1px solid var(--border)">
                        <div class="ld-table">
                            <div class="ld-table-row">
                                <span class="ld-table-label">Village</span>
                                <span class="ld-table-val">{{ $land->village }}</span>
                            </div>
                            <div class="ld-table-row">
                                <span class="ld-table-label">Cell / Sector</span>
                                <span class="ld-table-val">{{ $land->cell }}, {{ $land->sector }}</span>
                            </div>
                            <div class="ld-table-row" style="border-bottom:none">
                                <span class="ld-table-label">District / Province</span>
                                <span class="ld-table-val">{{ $land->district }}, {{ $land->province }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Video -->
                <div class="ld-panel">
                    <div class="ld-panel-head">
                        <div class="ld-panel-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z" />
                            </svg>
                        </div>
                        <p class="ld-panel-title">Video</p>
                    </div>
                    <div class="ld-panel-body">
                        @if($land->video_url)
                            @php
                                $isYoutube = preg_match(
                                    '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
                                    $land->video_url,
                                    $ytMatches
                                );
                                $youtubeId = $isYoutube ? $ytMatches[1] : null;
                            @endphp

                            @if($youtubeId)
                                <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:8px;">
                                    <iframe
                                        src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                        frameborder="0"
                                        allowfullscreen
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        style="position:absolute;top:0;left:0;width:100%;height:100%;border-radius:8px;"
                                    ></iframe>
                                </div>
                            @else
                                <p class="text-muted">No video available</p>
                            @endif
                        @else
                            <p class="text-muted">No video available</p>
                        @endif
                    </div>
                </div>

            </div>{{-- /left --}}

            {{-- ══ SIDEBAR ══ --}}
            <aside class="ld-sidebar">

                {{-- Price card --}}
                <div class="ld-sidebar-price">
                    <div class="ld-sidebar-price-inner">
                        <div class="ld-sb-price-label">Asking Price</div>
                        <div class="ld-sb-price-val">{{ number_format($land->price) }}</div>
                        <div class="ld-sb-price-unit">Rwandan Francs (RWF)</div>
                        <div class="ld-sb-status">{{ ucfirst($land->status ?? 'Available') }}</div>
                    </div>
                </div>

                {{-- Seller --}}
                <div class="ld-seller-card">
                    <div class="ld-seller-head">Contact Seller</div>
                    <div class="ld-seller-body">
                        <div class="ld-seller-info">
                            <div class="ld-seller-avatar">
                                <img src="{{ asset('front/assets/img/all-images/blog/blog-img17.png') }}" alt="{{ $land->owner_name }}">
                            </div>
                            <div>
                                <div class="ld-seller-name">{{ $land->owner_name }}</div>
                                <div class="ld-seller-role">{{ ucfirst($land->user->role) }}</div>
                            </div>
                        </div>

                        <div class="ld-seller-rows">
                            <div class="ld-seller-row">
                                <span class="ld-seller-row-label">Phone</span>
                                <span class="ld-seller-row-val"><a href="tel:{{ $land->owner_phone ?? '+250796511725' }}">{{ $land->owner_phone ?? '+250796511725' }}</a></span>
                            </div>
                            <div class="ld-seller-row">
                                <span class="ld-seller-row-label">Email</span>
                                <span class="ld-seller-row-val" style="font-size:.75rem"><a href="mailto:{{ $land->owner_email ?? 'terraltd.rd@gmail.com' }}">{{ $land->owner_email }}</a></span>
                            </div>
                            <div class="ld-seller-row">
                                <span class="ld-seller-row-label">Working Hours</span>
                                <span class="ld-seller-row-val">Mon–Fri, 9am–6pm</span>
                            </div>
                        </div>

                        <div class="ld-cta-btns">
                            <button class="ld-btn-inquiry" onclick="document.getElementById('ld-inquiry-modal').classList.add('open')">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
                                </svg>
                                Send Inquiry
                            </button>
                            <div class="ld-contact-row">
                                <a href="tel:{{ $land->owner_phone ?? '+250796511725' }}" class="ld-contact-btn">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                                    </svg>
                                    Call
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/\D/','',$land->owner_phone ?? '+250796511725') }}" target="_blank" class="ld-contact-btn">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
                                        <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" />
                                    </svg>
                                    WhatsApp
                                </a>
                                <a href="mailto:{{ $land->owner_email ?? 'terraltd.rd@gmail.com' }}" class="ld-contact-btn">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                    </svg>
                                    Email
                                </a>
                            </div>
                        </div>

                        <div class="ld-notice">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-2h2v2zm0-4H11V8h2v4z" />
                            </svg>
                            <span>Always verify land ownership documents and UPI with Rwanda Land Authority before completing any transaction.</span>
                        </div>
                    </div>
                </div>

            </aside>

        </div>{{-- /layout --}}

        {{-- ── Related Lands ── --}}
        @if(isset($relatedLands) && $relatedLands->count())
        <div class="ld-related">
            <div class="ld-related-head">
                <h2 class="ld-related-title">Related <em>plots</em></h2>
                <a href="{{ route('front.buy.lands') }}" class="ld-see-all">
                    See all plots
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="ld-related-grid">
                @foreach($relatedLands as $r)
                <a href="{{ route('front.buy.land.details', $r) }}" class="ld-rcard">
                    <div class="ld-rcard-img">
                        <span class="ld-rcard-badge">{{ $r->condition}}</span>
                        @php $rImg = $r->images->first(); @endphp
<img src="{{ $rImg ? asset('image/lands/' . $rImg->image_path) : asset('assets/img/placeholder-land.jpg') }}"
     alt="{{ $r->title }}" loading="lazy">
                    </div>
                    <div class="ld-rcard-body">
                        <p class="ld-rcard-title">{{ $r->title }}</p>
                        <div class="ld-rcard-loc">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            </svg>
                            {{ $r->sector }}, {{ $r->district }}
                        </div>
                        <div class="ld-rcard-stats">
                            @if($r->zoning)
                            <span class="ld-rcard-stat"><svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A4.49 4.49 0 008 20C19 20 22 3 22 3c-1 2-8 2-9 0-2-2-3-4-3-4z" />
                                </svg>{{ $r->zoning }}</span>
                            @endif
                            @if($r->size_sqm)
                            <span class="ld-rcard-stat"><svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z" />
                                </svg>{{ number_format($r->size_sqm) }}sqm</span>
                            @endif
                        </div>
                        <div class="ld-rcard-foot">
                            <p class="ld-rcard-price">{{ number_format($r->price) }}<span> RWF</span></p>
                            <span class="ld-rcard-cta">View<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg></span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>{{-- /container --}}
</div>{{-- /ld-page --}}

{{-- ══ INQUIRY MODAL ══ --}}
<div class="ld-modal-overlay" id="ld-inquiry-modal" onclick="closeInqBg(event)">
    <div class="ld-modal-box">
        <div class="ld-modal-head">
            <div class="ld-modal-head-inner">
                <div>
                    <h4>Send Inquiry</h4>
                    <p>Interested in {{ $land->title }}</p>
                </div>
                <button class="ld-modal-close" onclick="document.getElementById('ld-inquiry-modal').classList.remove('open')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <form method="POST" action="{{ route('front.buy.land.inquiry') }}" class="ld-modal-body" id="ld-inq-form">
            @csrf
            <input type="hidden" name="land_id" value="{{ $land->id }}">
            <div class="ld-modal-field">
                <label>Your Name</label>
                <input type="text" name="name" placeholder="Amina Uwimana" required>
            </div>
            <div class="ld-modal-field">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="you@email.com" required>
            </div>
            <div class="ld-modal-field">
                <label>Message</label>
                <textarea name="message" required>Hi, I am interested in purchasing your property: {{ $land->title }}</textarea>
            </div>
            <button type="button" class="ld-modal-submit" onclick="submitInquiry()">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                </svg>
                Send Inquiry
            </button>
        </form>
    </div>
</div>

<script>
    // Pass all image URLs from PHP to JS
    const galImgs = @json($imgs->values()->all() ?? []);

    let lbIndex = 0;

    function openLightbox(index) {
        if (!galImgs.length) return;
        lbIndex = index % galImgs.length;
        document.getElementById('lb-img').src = galImgs[lbIndex];
        renderStrip();
        document.getElementById('ld-lightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('ld-lightbox').classList.remove('active');
        document.body.style.overflow = '';
    }

    function closeLbBg(e) {
        if (e.target === document.getElementById('ld-lightbox')) closeLightbox();
    }

    function lbNav(dir) {
        lbIndex = (lbIndex + dir + galImgs.length) % galImgs.length;
        document.getElementById('lb-img').src = galImgs[lbIndex];
        renderStrip();
    }

    function renderStrip() {
        const strip = document.getElementById('lb-strip');
        strip.innerHTML = galImgs.map((src, i) =>
            `<img src="${src}"
                  onclick="openLightbox(${i})"
                  class="${i === lbIndex ? 'active' : ''}"
                  style="cursor:pointer;height:54px;width:72px;object-fit:cover;border-radius:3px;
                         opacity:${i === lbIndex ? '1' : '.55'};
                         border:2px solid ${i === lbIndex ? '#C8873A' : 'transparent'};
                         transition:opacity .2s,border-color .2s;">`
        ).join('');
    }

    // Keyboard navigation
    document.addEventListener('keydown', e => {
        const lb = document.getElementById('ld-lightbox');
        if (!lb.classList.contains('active')) return;
        if (e.key === 'ArrowRight') lbNav(1);
        if (e.key === 'ArrowLeft') lbNav(-1);
        if (e.key === 'Escape') closeLightbox();
    });


    /* ── Inquiry modal ── */
    window.closeInqBg = e => {
        if (e.target === document.getElementById('ld-inquiry-modal')) document.getElementById('ld-inquiry-modal').classList.remove('open');
    };
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') document.getElementById('ld-inquiry-modal').classList.remove('open');
    });

    window.submitInquiry = function() {
        const form = document.getElementById('ld-inq-form');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Send Inquiry?',
                text: 'This will notify the seller about your interest.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, send it',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#C8873A',
            }).then(r => {
                if (r.isConfirmed) form.submit();
            });
        } else {
            form.submit();
        }
    };

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
</script>

@endsection