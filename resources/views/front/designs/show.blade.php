@extends('layouts.guest')
@section('title', $design->title)
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
        --text: #1A1714;
        --muted: #6B6560;
        --dim: #9E9890;
        --green: #1E7A5A;
        --green-bg: rgba(30, 122, 90, .07);
        --green-bd: rgba(30, 122, 90, .2);
        --purple: #5A3B8C;
        --purple-bg: rgba(90, 59, 140, .08);
        --purple-bd: rgba(90, 59, 140, .22);
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
    .dd-breadcrumb {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 12px 0;
    }

    .dd-bc-inner {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: .75rem;
        color: var(--dim);
        flex-wrap: wrap;
    }

    .dd-bc-inner a {
        color: var(--muted);
        transition: color var(--t);
    }

    .dd-bc-inner a:hover {
        color: var(--gold);
    }

    .dd-bc-inner svg {
        width: 12px;
        height: 12px;
    }

    .dd-bc-inner .cur {
        color: var(--text);
        font-weight: 500;
    }

    /* ── Page layout ── */
    .dd-page {
        padding: 28px 0 80px;
    }

    .dd-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 960px) {
        .dd-layout {
            grid-template-columns: 1fr;
        }
    }

    /* ── Panel ── */
    .dd-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        margin-bottom: 16px;
    }

    .dd-panel-head {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dd-panel-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .dd-panel-icon svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
    }

    .dd-panel-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: -.01em;
        color: var(--text);
        margin: 0;
    }

    .dd-panel-body {
        padding: 18px 20px;
    }

    /* ── Gallery ── */
    .dd-gallery {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 280px 180px;
        gap: 8px;
        border-radius: var(--r);
        overflow: hidden;
        margin-bottom: 32px;
    }

    @media (max-width: 680px) {
        .dd-gallery {
            grid-template-columns: 1fr;
            grid-template-rows: 220px 140px 140px;
        }
    }

    .dd-gal-main {
        grid-row: 1 / 3;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        background: var(--bg);
    }

    .dd-gal-thumb {
        position: relative;
        overflow: hidden;
        cursor: pointer;
        background: var(--bg);
    }

    .dd-gal-main img,
    .dd-gal-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .5s ease;
    }

    .dd-gal-main:hover img,
    .dd-gal-thumb:hover img {
        transform: scale(1.04);
    }

    .dd-gal-counter {
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
    .dd-lb {
        position: fixed;
        inset: 0;
        z-index: 2000;
        background: rgba(0, 0, 0, .92);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .dd-lb.open {
        display: flex;
    }

    .dd-lb-img {
        max-width: 900px;
        max-height: 80vh;
        border-radius: 8px;
        display: block;
    }

    .dd-lb-close {
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

    .dd-lb-close svg {
        width: 18px;
        height: 18px;
    }

    .dd-lb-prev,
    .dd-lb-next {
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

    .dd-lb-prev:hover,
    .dd-lb-next:hover {
        background: rgba(255, 255, 255, .22);
    }

    .dd-lb-prev {
        left: 20px;
    }

    .dd-lb-next {
        right: 20px;
    }

    .dd-lb-prev svg,
    .dd-lb-next svg {
        width: 18px;
        height: 18px;
    }

    /* ── Title block ── */
    .dd-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        border-radius: 6px;
        background: var(--purple-bg);
        border: 1px solid var(--purple-bd);
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--purple);
        margin-bottom: 10px;
    }

    .dd-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        font-weight: 500;
        line-height: 1.15;
        letter-spacing: -.02em;
        color: var(--text);
        margin-bottom: 10px;
    }

    .dd-service {
        font-size: .82rem;
        color: var(--gold);
        font-weight: 500;
        margin-bottom: 4px;
    }

    /* Price + share row */
    .dd-price-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        padding: 16px 20px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        margin: 14px 0 16px;
    }

    .dd-price-main {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--gold);
        line-height: 1;
        letter-spacing: -.02em;
    }

    .dd-price-main.free {
        color: var(--green);
    }

    .dd-price-main span {
        font-size: .85rem;
        font-weight: 400;
        color: var(--muted);
        font-family: 'DM Sans', sans-serif;
        margin-left: 4px;
    }

    .dd-share-btns {
        display: flex;
        gap: 6px;
    }

    .dd-share-btn {
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

    .dd-share-btn:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    .dd-share-btn svg {
        width: 14px;
        height: 14px;
    }

    /* Spec chips */
    .dd-specs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .dd-spec {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        border-radius: 9px;
        background: var(--bg);
        border: 1px solid var(--border);
        font-size: .8rem;
        color: var(--muted);
        font-weight: 500;
    }

    .dd-spec svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
    }

    .dd-spec strong {
        color: var(--text);
        margin-left: 2px;
    }

    /* Description */
    .dd-desc {
        font-size: .85rem;
        color: var(--muted);
        line-height: 1.8;
    }

    /* Details table */
    .dd-table {
        display: flex;
        flex-direction: column;
    }

    .dd-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--border);
        font-size: .82rem;
    }

    .dd-row:last-child {
        border-bottom: none;
    }

    .dd-row-label {
        color: var(--dim);
        font-weight: 500;
    }

    .dd-row-val {
        color: var(--text);
        font-weight: 600;
        text-align: right;
    }

    /* Amenity grid */
    .dd-amenity-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .dd-amenity {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 9px;
        background: var(--bg);
        border: 1px solid var(--border);
        font-size: .8rem;
        color: var(--muted);
        transition: border-color var(--t), background var(--t);
    }

    .dd-amenity:hover {
        border-color: var(--gold-bd);
        background: var(--gold-bg);
    }

    .dd-amenity-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .dd-amenity-icon svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
    }

    /* File download row */
    .dd-file-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 14px;
        border-radius: 9px;
        border: 1px solid var(--border);
        background: var(--bg);
        transition: border-color var(--t), background var(--t);
        margin-bottom: 8px;
    }

    .dd-file-row:hover {
        border-color: var(--gold-bd);
        background: var(--gold-bg);
    }

    .dd-file-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: rgba(220, 38, 38, .08);
        border: 1px solid rgba(220, 38, 38, .2);
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .dd-file-icon svg {
        width: 15px;
        height: 15px;
        color: #dc2626;
    }

    .dd-file-name {
        font-size: .82rem;
        font-weight: 500;
        color: var(--text);
    }

    .dd-file-sub {
        font-size: .72rem;
        color: var(--dim);
    }

    .dd-file-dl {
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

    .dd-file-row:hover .dd-file-dl {
        gap: 8px;
    }

    .dd-file-dl svg {
        width: 13px;
        height: 13px;
    }

    /* Notice */
    .dd-notice {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        padding: 12px 14px;
        border-radius: var(--r);
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        font-size: .8rem;
        color: var(--muted);
        line-height: 1.6;
        margin-top: 12px;
    }

    .dd-notice svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* ══ SIDEBAR ══ */
    .dd-sidebar {
        position: sticky;
        top: 24px;
    }

    /* Price card */
    .dd-sb-price {
        background: var(--dark);
        border-radius: var(--r);
        overflow: hidden;
        margin-bottom: 14px;
        position: relative;
    }

    .dd-sb-price::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 70% 60% at 20% 50%, rgba(200, 135, 58, .16) 0%, transparent 65%);
        pointer-events: none;
    }

    .dd-sb-price-inner {
        position: relative;
        z-index: 1;
        padding: 22px 20px;
    }

    .dd-sb-label {
        font-size: .68rem;
        color: rgba(240, 237, 232, .4);
        text-transform: uppercase;
        letter-spacing: .1em;
        margin-bottom: 6px;
    }

    .dd-sb-val {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.7rem;
        font-weight: 600;
        letter-spacing: -.02em;
        line-height: 1;
        margin-bottom: 4px;
    }

    .dd-sb-val.free {
        color: #4ade80;
    }

    .dd-sb-val.paid {
        color: #F0EDE8;
    }

    .dd-sb-unit {
        font-size: .75rem;
        color: rgba(240, 237, 232, .4);
    }

    .dd-sb-status {
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
    }

    .dd-sb-status.free {
        background: rgba(74, 222, 128, .15);
        border: 1px solid rgba(74, 222, 128, .25);
        color: #4ade80;
    }

    .dd-sb-status.paid {
        background: rgba(200, 135, 58, .12);
        border: 1px solid rgba(200, 135, 58, .3);
        color: var(--gold-lt);
    }

    .dd-sb-status::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* Action buttons */
    .dd-sb-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-top: 14px;
    }

    .dd-btn-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 13px 16px;
        border-radius: 9px;
        background: var(--gold);
        border: none;
        color: #fff;
        font-size: .86rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background var(--t), transform var(--t);
        width: 100%;
    }

    .dd-btn-primary:hover {
        background: #a06828;
        transform: translateY(-1px);
    }

    .dd-btn-primary.dl {
        background: var(--green);
    }

    .dd-btn-primary.dl:hover {
        background: #155c3e;
    }

    .dd-btn-primary svg {
        width: 15px;
        height: 15px;
    }

    .dd-contact-row {
        display: flex;
        gap: 8px;
    }

    .dd-contact-btn {
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

    .dd-contact-btn:hover {
        border-color: var(--gold-bd);
        color: var(--gold);
    }

    .dd-contact-btn svg {
        width: 13px;
        height: 13px;
    }

    /* ══ RELATED ══ */
    .dd-related {
        padding: 48px 0 0;
    }

    .dd-related-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .dd-related-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 500;
        color: var(--text);
        margin: 0;
    }

    .dd-related-title em {
        font-style: italic;
        color: var(--gold);
    }

    .dd-see-all {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .78rem;
        color: var(--gold);
        font-weight: 500;
        border-bottom: 1px solid var(--gold-bd);
        transition: gap var(--t);
    }

    .dd-see-all:hover {
        gap: 9px;
    }

    .dd-see-all svg {
        width: 12px;
        height: 12px;
    }

    .dd-related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 14px;
    }

    .dd-rcard {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform var(--t), border-color var(--t), box-shadow var(--t);
        color: var(--text);
    }

    .dd-rcard:hover {
        transform: translateY(-4px);
        border-color: var(--gold-bd);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .09);
        color: var(--text);
    }

    .dd-rcard-img {
        position: relative;
        aspect-ratio: 16/10;
        overflow: hidden;
        background: var(--bg);
    }

    .dd-rcard-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .45s ease;
    }

    .dd-rcard:hover .dd-rcard-img img {
        transform: scale(1.06);
    }

    .dd-rcard-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        padding: 2px 7px;
        border-radius: 5px;
        font-size: .64rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        background: var(--purple);
        color: #fff;
        z-index: 2;
    }

    .dd-rcard-free {
        position: absolute;
        top: 8px;
        right: 8px;
        padding: 2px 7px;
        border-radius: 5px;
        font-size: .62rem;
        font-weight: 700;
        background: rgba(30, 122, 90, .85);
        color: #fff;
        z-index: 2;
    }

    .dd-rcard-body {
        padding: 11px 13px 13px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .dd-rcard-title {
        font-size: .86rem;
        font-weight: 600;
        color: var(--text);
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .dd-rcard-cat {
        font-size: .72rem;
        color: var(--gold);
        font-weight: 500;
    }

    .dd-rcard-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid var(--border);
        padding-top: 8px;
        margin-top: auto;
    }

    .dd-rcard-price {
        font-size: .86rem;
        font-weight: 700;
        color: var(--gold);
    }

    .dd-rcard-price.free {
        color: var(--green);
    }

    .dd-rcard-cta {
        font-size: .73rem;
        font-weight: 600;
        color: var(--gold);
        display: flex;
        align-items: center;
        gap: 3px;
        transition: gap var(--t);
    }

    .dd-rcard:hover .dd-rcard-cta {
        gap: 7px;
    }

    .dd-rcard-cta svg {
        width: 11px;
        height: 11px;
    }

    /* ══ INQUIRY MODAL ══ */
    .dd-modal-overlay {
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

    .dd-modal-overlay.open {
        display: flex;
    }

    .dd-modal-box {
        background: var(--surface);
        border-radius: 16px;
        width: 100%;
        max-width: 480px;
        overflow: hidden;
        box-shadow: 0 28px 72px rgba(0, 0, 0, .18);
        animation: ddMIn .3s ease both;
    }

    @keyframes ddMIn {
        from {
            opacity: 0;
            transform: scale(.96) translateY(8px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .dd-modal-head {
        background: var(--dark);
        padding: 22px 24px;
        position: relative;
        overflow: hidden;
    }

    .dd-modal-head::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 65% 80% at 15% 50%, rgba(200, 135, 58, .15) 0%, transparent 65%);
        pointer-events: none;
    }

    .dd-modal-head-inner {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

    .dd-modal-head h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 500;
        color: #F0EDE8;
        margin: 0;
    }

    .dd-modal-head p {
        font-size: .73rem;
        color: rgba(240, 237, 232, .4);
        margin-top: 2px;
    }

    .dd-modal-close {
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

    .dd-modal-close:hover {
        background: rgba(255, 255, 255, .2);
    }

    .dd-modal-close svg {
        width: 15px;
        height: 15px;
    }

    .dd-modal-body {
        padding: 20px 22px 22px;
    }

    .dd-modal-field {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 13px;
    }

    .dd-modal-field label {
        font-size: .7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--muted);
    }

    .dd-modal-field input,
    .dd-modal-field textarea {
        padding: 10px 12px;
        background: var(--bg);
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-size: .84rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        transition: border-color var(--t);
        width: 100%;
    }

    .dd-modal-field input:focus,
    .dd-modal-field textarea:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(200, 135, 58, .1);
    }

    .dd-modal-field textarea {
        resize: vertical;
        min-height: 90px;
    }

    .dd-modal-submit {
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

    .dd-modal-submit:hover {
        background: #a06828;
    }

    .dd-modal-submit svg {
        width: 14px;
        height: 14px;
    }

    /* ══ CTA ══ */
    .dd-cta {
        background: var(--dark);
        position: relative;
        overflow: hidden;
        padding: 64px 0;
        margin-top: 40px;
    }

    .dd-cta::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 50% at 20% 50%, rgba(200, 135, 58, .14) 0%, transparent 60%),
            radial-gradient(ellipse 40% 60% at 85% 30%, rgba(200, 135, 58, .07) 0%, transparent 55%);
        pointer-events: none;
    }

    .dd-cta .container {
        position: relative;
        z-index: 2;
    }

    .dd-cta-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        flex-wrap: wrap;
    }

    .dd-cta-eyebrow {
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--gold-lt);
        margin-bottom: 8px;
        display: block;
    }

    .dd-cta-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.8rem, 3.5vw, 2.6rem);
        font-weight: 500;
        line-height: 1.15;
        letter-spacing: -.02em;
        color: #F0EDE8;
    }

    .dd-cta-title em {
        font-style: italic;
        color: var(--gold-lt);
    }

    .dd-cta-sub {
        font-size: .85rem;
        color: rgba(240, 237, 232, .4);
        line-height: 1.75;
        margin-top: 8px;
        max-width: 440px;
    }

    .dd-cta-btns {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    .dd-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 22px;
        border-radius: 10px;
        font-size: .84rem;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: all var(--t);
        border: none;
        text-decoration: none;
    }

    .dd-cta-btn svg {
        width: 15px;
        height: 15px;
    }

    .dd-btn-gold {
        background: var(--gold);
        color: #fff;
    }

    .dd-btn-gold:hover {
        background: #a06828;
        color: #fff;
        transform: translateY(-1px);
    }

    .dd-btn-ghost {
        background: rgba(255, 255, 255, .08);
        color: #F0EDE8;
        border: 1px solid rgba(255, 255, 255, .15);
    }

    .dd-btn-ghost:hover {
        background: rgba(255, 255, 255, .16);
        color: #fff;
    }
</style>

{{-- ── Breadcrumb ── --}}
<div class="dd-breadcrumb">
    <div class="container">
        <div class="dd-bc-inner">
            <a href="{{ route('front.home') }}">Home</a>
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 6l6 6-6 6" />
            </svg>
            <a href="{{ route('front.buy.design') }}">Designs</a>
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 6l6 6-6 6" />
            </svg>
            <span class="cur">{{ Str::limit($design->title, 40) }}</span>
        </div>
    </div>
</div>

<div class="dd-page">
    <div class="container">

        {{-- ── Gallery ── --}}
        @php
        $preview = $design->preview_image
        ? asset('storage/'.$design->preview_image)
        : asset('front/assets/img/all-images/properties/property-img1.png');
        $imgs = [$preview,
        asset('front/assets/img/all-images/properties/property-img36.png'),
        asset('front/assets/img/all-images/properties/property-img37.png')];
        @endphp

        <div class="dd-gallery" id="dd-gallery">
            <div class="dd-gal-main" onclick="openLb(0)">
                <img src="{{ $imgs[0] }}" alt="{{ $design->title }}">
            </div>
            <div class="dd-gal-thumb" onclick="openLb(1)">
                <img src="{{ $imgs[1] }}" alt="{{ $design->title }}">
            </div>
            <div class="dd-gal-thumb" onclick="openLb(2)" style="position:relative">
                <img src="{{ $imgs[2] }}" alt="{{ $design->title }}">
                <div class="dd-gal-counter">View all</div>
            </div>
        </div>

        {{-- Lightbox --}}
        <div class="dd-lb" id="dd-lb" onclick="closeLbBg(event)">
            <button class="dd-lb-close" onclick="closeLb()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" />
                </svg>
            </button>
            <button class="dd-lb-prev" onclick="lbNav(-1)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </button>
            <img class="dd-lb-img" id="dd-lb-img" src="" alt="">
            <button class="dd-lb-next" onclick="lbNav(1)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </button>
        </div>

        {{-- ── Layout ── --}}
        <div class="dd-layout">

            {{-- ══ LEFT ══ --}}
            <div>

                {{-- Title ── --}}
                <div class="dd-type-badge">
                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:11px;height:11px">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                    </svg>
                    {{ $design->category?->name ?? 'Architectural Design' }}
                </div>
                <h1 class="dd-title">{{ $design->title }}</h1>
                @if($design->service)
                <div class="dd-service">{{ $design->service->title }}</div>
                @endif

                <div class="dd-price-row">
                    <div>
                        @if($design->is_free)
                        <div class="dd-price-main free">Free<span>Download</span></div>
                        @else
                        <div class="dd-price-main">{{ number_format($design->price ?? 0) }}<span>RWF</span></div>
                        @endif
                    </div>
                    <div class="dd-share-btns">
                        <button class="dd-share-btn" title="Save">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                            </svg>
                        </button>
                        <button class="dd-share-btn" title="Share">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M13.1202 17.0228L8.92129 14.7324C8.19135 15.5125 7.15261 16 6 16C3.79086 16 2 14.2091 2 12C2 9.79086 3.79086 8 6 8C7.15255 8 8.19125 8.48746 8.92118 9.26746L13.1202 6.97713C13.0417 6.66441 13 6.33707 13 6C13 3.79086 14.7909 2 17 2C19.2091 2 21 3.79086 21 6C21 8.20914 19.2091 10 17 10C15.8474 10 14.8087 9.51251 14.0787 8.73246L9.87977 11.0228C9.9583 11.3355 10 11.6629 10 12C10 12.3371 9.95831 12.6644 9.87981 12.9771L14.0788 15.2675C14.8087 14.4875 15.8474 14 17 14C19.2091 14 21 15.7909 21 18C21 20.2091 19.2091 22 17 22C14.7909 22 13 20.2091 13 18C13 17.6629 13.0417 17.3355 13.1202 17.0228Z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Spec chips ── --}}
                <div class="dd-specs">
                    <div class="dd-spec">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
                        </svg>
                        <strong>{{ $design->category?->name ?? '—' }}</strong>
                    </div>
                    <div class="dd-spec">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                        </svg>
                        <strong>{{ strtoupper(pathinfo($design->design_file ?? '', PATHINFO_EXTENSION) ?: 'PDF') }}</strong>
                    </div>
                    <div class="dd-spec">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <strong>{{ ucfirst($design->status ?? 'Approved') }}</strong>
                    </div>
                    @if($design->featured)
                    <div class="dd-spec">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        <strong>Featured</strong>
                    </div>
                    @endif
                </div>

                {{-- Description ── --}}
                @if($design->description)
                <div class="dd-panel">
                    <div class="dd-panel-head">
                        <div class="dd-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                            </svg></div>
                        <p class="dd-panel-title">About This Design</p>
                    </div>
                    <div class="dd-panel-body">
                        <p class="dd-desc">{{ $design->description }}</p>
                    </div>
                </div>
                @endif

                {{-- Details table ── --}}
                <div class="dd-panel">
                    <div class="dd-panel-head">
                        <div class="dd-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                            </svg></div>
                        <p class="dd-panel-title">Design Details</p>
                    </div>
                    <div class="dd-panel-body">
                        <div class="dd-table">
                            <div class="dd-row"><span class="dd-row-label">Title</span><span class="dd-row-val">{{ $design->title }}</span></div>
                            <div class="dd-row"><span class="dd-row-label">Category</span><span class="dd-row-val">{{ $design->category?->name ?? '—' }}</span></div>
                            <div class="dd-row"><span class="dd-row-label">Service</span><span class="dd-row-val">{{ $design->service?->title ?? '—' }}</span></div>
                            <div class="dd-row"><span class="dd-row-label">Uploaded by</span><span class="dd-row-val">{{ $design->user?->name ?? 'Terra Admin' }}</span></div>
                            <div class="dd-row"><span class="dd-row-label">Status</span><span class="dd-row-val">{{ ucfirst($design->status ?? 'Approved') }}</span></div>
                            <div class="dd-row"><span class="dd-row-label">Price</span><span class="dd-row-val">{{ $design->is_free ? 'Free' : number_format($design->price).' RWF' }}</span></div>
                            <div class="dd-row"><span class="dd-row-label">Downloads</span><span class="dd-row-val">{{ $design->download_count ?? 0 }}</span></div>
                            <div class="dd-row"><span class="dd-row-label">Featured</span><span class="dd-row-val">{{ $design->featured ? 'Yes' : 'No' }}</span></div>
                        </div>
                    </div>
                </div>

                {{-- Amenities ── --}}
                <div class="dd-panel">
                    <div class="dd-panel-head">
                        <div class="dd-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg></div>
                        <p class="dd-panel-title">Design Features</p>
                    </div>
                    <div class="dd-panel-body">
                        <div class="dd-amenity-grid">
                            <div class="dd-amenity">
                                <div class="dd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                                    </svg></div>Lock on Bedroom
                            </div>
                            <div class="dd-amenity">
                                <div class="dd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A4.49 4.49 0 008 20C19 20 22 3 22 3c-1 2-8 2-9 0-2-2-3-4-3-4z" />
                                    </svg></div>Outdoor Dining Area
                            </div>
                            <div class="dd-amenity">
                                <div class="dd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                                    </svg></div>Air Conditioning
                            </div>
                            <div class="dd-amenity">
                                <div class="dd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                    </svg></div>Patio or Balcony
                            </div>
                            <div class="dd-amenity">
                                <div class="dd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z" />
                                    </svg></div>Building Wifi
                            </div>
                            <div class="dd-amenity">
                                <div class="dd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2c.45 2.33 1.79 4.33 3.62 5.65L6.23 20.07c-2.48-1.72-4.24-4.41-4.23-7.07zm18 0h2c-.45 2.33-1.79 4.33-3.62 5.65l1.39 1.42c2.48-1.72 4.24-4.41 4.23-7.07zM12 2c.56 0 1 .44 1 1v2.08A8.023 8.023 0 0119.92 12H22v-1a10 10 0 00-10-10z" />
                                    </svg></div>Sun Loungers
                            </div>
                            <div class="dd-amenity">
                                <div class="dd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20 7H4V5h16v2zm-2-4H6v2h12V3zm4 11v2l-1 5H3l-1-5v-2a2 2 0 012-2h16a2 2 0 012 2zm-2.72 7l.72-3.44-.37-.56H4.37l-.37.56L4.72 21z" />
                                    </svg></div>Private Entrance
                            </div>
                            <div class="dd-amenity">
                                <div class="dd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17.93V18h-2v1.93C7.06 19.44 4.56 16.94 4.07 14H6v-2H4.07C4.56 9.06 7.06 6.56 10 6.07V8h2V6.07c2.94.49 5.44 2.99 5.93 5.93H16v2h1.93c-.49 2.94-2.99 5.44-5.93 5.93z" />
                                    </svg></div>Smoke Alarm
                            </div>
                        </div>
                    </div>
                </div>

                {{-- File download ── --}}
                @if($design->design_file)
                <div class="dd-panel">
                    <div class="dd-panel-head">
                        <div class="dd-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                                <path d="M14 2v6h6" />
                            </svg></div>
                        <p class="dd-panel-title">Design File</p>
                    </div>
                    <div class="dd-panel-body">
                        @if($design->is_free)
                        <a href="{{ asset('storage/'.$design->design_file) }}" download class="dd-file-row" style="display:flex">
                            <div class="dd-file-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                                </svg></div>
                            <div>
                                <div class="dd-file-name">{{ $design->title }} — Design File</div>
                                <div class="dd-file-sub">Free download · {{ strtoupper(pathinfo($design->design_file, PATHINFO_EXTENSION)) }}</div>
                            </div>
                            <div class="dd-file-dl">Download <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                                </svg></div>
                        </a>
                        @else
                        <div class="dd-file-row" style="display:flex">
                            <div class="dd-file-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                                </svg></div>
                            <div>
                                <div class="dd-file-name">{{ $design->title }} — Design File</div>
                                <div class="dd-file-sub">Purchase required · {{ strtoupper(pathinfo($design->design_file, PATHINFO_EXTENSION)) }}</div>
                            </div>
                            <div class="dd-file-dl" style="color:var(--dim)">Locked <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                                </svg></div>
                        </div>
                        @endif
                        <div class="dd-notice">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-2h2v2zm0-4H11V8h2v4z" />
                            </svg>
                            <span>{{ $design->is_free ? 'This design is available for free download. Files include all architectural drawings and specifications.' : 'Purchase this design to access all architectural drawings, floor plans, and specifications.' }}</span>
                        </div>
                    </div>
                </div>
                @endif

            </div>{{-- /left --}}

            {{-- ══ SIDEBAR ══ --}}
            <aside class="dd-sidebar">

                {{-- Price card ── --}}
                <div class="dd-sb-price">
                    <div class="dd-sb-price-inner">
                        <div class="dd-sb-label">{{ $design->is_free ? 'Available For' : 'Price' }}</div>
                        @if($design->is_free)
                        <div class="dd-sb-val free">Free</div>
                        <div class="dd-sb-unit">Download instantly, no payment needed</div>
                        @else
                        <div class="dd-sb-val paid">{{ number_format($design->price ?? 0) }}</div>
                        <div class="dd-sb-unit">Rwandan Francs (RWF)</div>
                        @endif
                        <div class="dd-sb-status {{ $design->is_free ? 'free' : 'paid' }}">
                            {{ $design->is_free ? 'Free Download' : 'Paid Design' }}
                        </div>
                    </div>
                </div>

                {{-- Details card ── --}}
                <div class="dd-panel">
                    <div class="dd-panel-head">
                        <p class="dd-panel-title">Design Info</p>
                    </div>
                    <div class="dd-panel-body">
                        <div class="dd-table">
                            <div class="dd-row"><span class="dd-row-label">Category</span><span class="dd-row-val">{{ $design->category?->name ?? '—' }}</span></div>
                            <div class="dd-row"><span class="dd-row-label">Author</span><span class="dd-row-val">{{ $design->user?->name ?? 'Terra Admin' }}</span></div>
                            <div class="dd-row"><span class="dd-row-label">Status</span><span class="dd-row-val">{{ ucfirst($design->status ?? 'Approved') }}</span></div>
                            <div class="dd-row" style="border-bottom:none"><span class="dd-row-label">Downloads</span><span class="dd-row-val">{{ $design->download_count ?? 0 }}</span></div>
                        </div>

                        <div class="dd-sb-actions">
                            @if($design->is_free)
                            <a href="{{ route('front.buy.design.download', $design->slug) }}"
                                class="dd-btn-primary dl"
                                onclick="handleFreeDownload(event, this.href)">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                                </svg>
                                Download Free
                            </a>
                            @else
                            <button class="dd-btn-primary" onclick="document.getElementById('dd-inq-modal').classList.add('open');document.body.style.overflow='hidden'">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM5.82 5H21v2l-2.27 4.54c-.27.53-.84.87-1.46.87H9.26L8.4 14H19v2H8c-1.32 0-2-.9-2-2.12l1.1-2.2L4 4H2V2h2.27L5.82 5z" />
                                </svg>
                                Buy Now — {{ number_format($design->price ?? 0) }} RWF
                            </button>
                            @endif
                            <div class="dd-contact-row">
                                <a href="{{ route('front.contact') }}" class="dd-contact-btn">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
                                    </svg>
                                    Enquire
                                </a>
                                <a href="https://wa.me/250782390919" target="_blank" class="dd-contact-btn">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
                                        <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" />
                                    </svg>
                                    WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </aside>
        </div>{{-- /layout --}}

        {{-- ── Related Designs ── --}}
        @if(isset($relatedDesigns) && $relatedDesigns->count())
        <div class="dd-related">
            <div class="dd-related-head">
                <h2 class="dd-related-title">Related <em>designs</em></h2>
                <a href="{{ route('front.buy.design') }}" class="dd-see-all">
                    See all designs
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="dd-related-grid">
                @foreach($relatedDesigns as $r)
                <a href="{{ route('front.buy.design.show', $r->slug) }}" class="dd-rcard">
                    <div class="dd-rcard-img">
                        <span class="dd-rcard-badge">{{ $r->category?->name ?? 'Design' }}</span>
                        @if($r->is_free)<span class="dd-rcard-free">Free</span>@endif
                        @if($r->preview_image)
                        <img src="{{ asset('storage/'.$r->preview_image) }}" alt="{{ $r->title }}" loading="lazy">
                        @else
                        <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png') }}" alt="{{ $r->title }}" loading="lazy">
                        @endif
                    </div>
                    <div class="dd-rcard-body">
                        <p class="dd-rcard-title">{{ $r->title }}</p>
                        @if($r->category)<div class="dd-rcard-cat">{{ $r->category->name }}</div>@endif
                        <div class="dd-rcard-foot">
                            <p class="dd-rcard-price {{ $r->is_free ? 'free' : '' }}">
                                {{ $r->is_free ? 'Free' : number_format($r->price).' RWF' }}
                            </p>
                            <span class="dd-rcard-cta">View<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
</div>{{-- /dd-page --}}

{{-- ══ INQUIRY MODAL ══ --}}
<div class="dd-modal-overlay" id="dd-inq-modal" onclick="closeInqBg(event)">
    <div class="dd-modal-box">
        <div class="dd-modal-head">
            <div class="dd-modal-head-inner">
                <div>
                    <h4>Purchase Inquiry</h4>
                    <p>Interested in {{ $design->title }}</p>
                </div>
                <button class="dd-modal-close" onclick="document.getElementById('dd-inq-modal').classList.remove('open');document.body.style.overflow=''">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <form method="POST" action="{{ route('front.buy.design.inquiry') }}" class="dd-modal-body" id="dd-inq-form">
            @csrf
            <input type="hidden" name="design_id" value="{{ $design->id }}">
            <div class="dd-modal-field">
                <label>Your Name</label>
                <input type="text" name="name" placeholder="Amina Uwimana" required>
            </div>
            <div class="dd-modal-field">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="you@email.com" required>
            </div>
            <div class="dd-modal-field">
                <label>Message</label>
                <textarea name="message" required>Hi, I am interested in purchasing your design: {{ $design->title }}</textarea>
            </div>
            <button type="button" class="dd-modal-submit" onclick="submitInq()">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                </svg>
                Send Inquiry
            </button>
        </form>
    </div>
</div>

{{-- ══ CTA ══ --}}
<section class="dd-cta">
    <div class="container">
        <div class="dd-cta-inner">
            <div>
                <span class="dd-cta-eyebrow">Free Consultation</span>
                <h2 class="dd-cta-title">Need a custom <em>design?</em></h2>
                <p class="dd-cta-sub">Contact our team of certified architects and consultants for a bespoke design tailored to your land, budget, and vision.</p>
            </div>
            <div class="dd-cta-btns">
                <a href="{{ route('front.contact') }}" class="dd-cta-btn dd-btn-gold">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
                    </svg>
                    Contact Us
                </a>
                <a href="{{ route('front.buy.design') }}" class="dd-cta-btn dd-btn-ghost">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                    Browse All Designs
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    /* ── Lightbox ── */
    const lbImgs = @json($imgs);
    let lbCur = 0;
    const lbEl = document.getElementById('dd-lb');
    const lbImg = document.getElementById('dd-lb-img');

    function setLb(n) {
        lbCur = (n + lbImgs.length) % lbImgs.length;
        lbImg.src = lbImgs[lbCur];
    }
    window.openLb = n => {
        setLb(n);
        lbEl.classList.add('open');
        document.body.style.overflow = 'hidden';
    };
    window.closeLb = () => {
        lbEl.classList.remove('open');
        document.body.style.overflow = '';
    };
    window.closeLbBg = e => {
        if (e.target === lbEl) closeLb();
    };
    window.lbNav = d => setLb(lbCur + d);
    document.addEventListener('keydown', e => {
        if (!lbEl.classList.contains('open')) return;
        if (e.key === 'ArrowLeft') lbNav(-1);
        if (e.key === 'ArrowRight') lbNav(1);
        if (e.key === 'Escape') closeLb();
    });

    /* ── Inquiry modal ── */
    window.closeInqBg = e => {
        if (e.target === document.getElementById('dd-inq-modal')) {
            document.getElementById('dd-inq-modal').classList.remove('open');
            document.body.style.overflow = '';
        }
    };
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.getElementById('dd-inq-modal').classList.remove('open');
            document.body.style.overflow = '';
        }
    });
    window.submitInq = function() {
        const form = document.getElementById('dd-inq-form');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                    title: 'Send Inquiry?',
                    text: 'This will notify the designer about your interest.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, send it',
                    confirmButtonColor: '#C8873A'
                })
                .then(r => {
                    if (r.isConfirmed) form.submit();
                });
        } else {
            form.submit();
        }
    };

    /* ── Free download ── */
    window.handleFreeDownload = function(e, url) {
        e.preventDefault();
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Download Started',
                text: 'Your free design is downloading now.',
                confirmButtonColor: '#C8873A'
            });
        }
        setTimeout(() => {
            window.location.href = url;
        }, 800);
    };
</script>

@endsection