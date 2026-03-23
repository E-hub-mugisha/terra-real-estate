@extends('layouts.guest')
@section('title', $home->title)
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --surface: #FFFFFF;
        --border: rgba(0, 0, 0, .08);
        --border2: rgba(0, 0, 0, .15);
        --gold: #C8873A;
        --gold-bg: rgba(200, 135, 58, .08);
        --gold-bd: rgba(200, 135, 58, .22);
        --text: #19265d;
        --muted: #6B6560;
        --dim: #9E9890;
        --green: #1E7A5A;
        --r: 12px;
        --t: .2s cubic-bezier(.4, 0, .2, 1);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
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

    /* ── Breadcrumb bar ── */
    .pd-breadcrumb {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 12px 0;
        font-size: .78rem;
        color: var(--dim);
    }

    .pd-breadcrumb a {
        color: var(--muted);
    }

    .pd-breadcrumb a:hover {
        color: var(--gold);
    }

    .pd-breadcrumb span {
        color: var(--gold);
    }

    /* ══════════════════════════════════
   GALLERY
══════════════════════════════════ */
    .pd-gallery {
        /* background: #19265d; */
        padding: 50px 0;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-template-rows: 260px 180px;
        gap: 6px;
        border-radius: var(--r);
        overflow: hidden;
    }

    .gallery-cell {
        position: relative;
        overflow: hidden;
        background: #2A2520;
        cursor: pointer;
    }

    .gallery-cell img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .45s ease, filter .45s ease;
        display: block;
    }

    .gallery-cell:hover img {
        transform: scale(1.05);
        filter: brightness(.85);
    }

    .gallery-cell.main {
        grid-column: 1 / 3;
        grid-row: 1 / 3;
    }

    .gallery-cell.sm {
        grid-column: 3;
    }

    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, .0);
        transition: background var(--t);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gallery-cell:hover .gallery-overlay {
        background: rgba(0, 0, 0, .25);
    }

    .gallery-overlay svg {
        opacity: 0;
        transition: opacity var(--t);
        color: #fff;
        width: 28px;
        height: 28px;
    }

    .gallery-cell:hover .gallery-overlay svg {
        opacity: 1;
    }

    .gallery-more {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, .65);
        color: #fff;
        font-size: .75rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
        backdrop-filter: blur(4px);
        pointer-events: none;
    }

    /* Lightbox */
    .lightbox {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(0, 0, 0, .92);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .lightbox.open {
        display: flex;
    }

    .lightbox-inner {
        position: relative;
        max-width: 900px;
        width: 100%;
    }

    .lightbox-inner img {
        width: 100%;
        border-radius: 10px;
        display: block;
        max-height: 80vh;
        object-fit: contain;
    }

    .lb-close {
        position: absolute;
        top: -40px;
        right: 0;
        background: none;
        border: none;
        color: #fff;
        font-size: 1.4rem;
        cursor: pointer;
    }

    .lb-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, .12);
        border: none;
        color: #fff;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1rem;
        display: grid;
        place-items: center;
        transition: background var(--t);
    }

    .lb-nav:hover {
        background: var(--gold);
    }

    .lb-prev {
        left: -50px;
    }

    .lb-next {
        right: -50px;
    }

    .lb-counter {
        position: absolute;
        bottom: -32px;
        left: 50%;
        transform: translateX(-50%);
        color: rgba(255, 255, 255, .5);
        font-size: .8rem;
    }

    /* Thumbnail strip */
    .lb-thumbs {
        display: flex;
        gap: 6px;
        margin-top: 12px;
        overflow-x: auto;
        justify-content: center;
        padding-bottom: 4px;
    }

    .lb-thumb {
        width: 60px;
        height: 44px;
        border-radius: 5px;
        overflow: hidden;
        cursor: pointer;
        flex-shrink: 0;
        border: 2px solid transparent;
        transition: border-color var(--t);
    }

    .lb-thumb.active {
        border-color: var(--gold);
    }

    .lb-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ══════════════════════════════════
   VIDEO SECTION
══════════════════════════════════ */
    .pd-video-wrap {
        position: relative;
        border-radius: var(--r);
        overflow: hidden;
        background: #19265d;
        aspect-ratio: 16/9;
    }

    .pd-video-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: filter .3s;
    }

    .pd-video-wrap:hover .pd-video-thumb {
        filter: brightness(.7);
    }

    .pd-play-btn {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background: none;
        border: none;
    }

    .pd-play-btn .play-circle {
        width: 64px;
        height: 64px;
        background: var(--gold);
        border-radius: 50%;
        display: grid;
        place-items: center;
        transition: transform var(--t), background var(--t);
        box-shadow: 0 4px 24px rgba(200, 135, 58, .5);
    }

    .pd-play-btn:hover .play-circle {
        transform: scale(1.1);
        background: #a06828;
    }

    .pd-play-btn svg {
        width: 24px;
        height: 24px;
        color: #fff;
        margin-left: 3px;
    }

    .pd-video-label {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: rgba(0, 0, 0, .6);
        color: #fff;
        font-size: .72rem;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 5px;
        backdrop-filter: blur(4px);
        pointer-events: none;
    }

    /* Inline iframe once play is clicked */
    .pd-video-iframe {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        border: none;
        display: none;
        border-radius: var(--r);
    }

    /* ══════════════════════════════════
   LAYOUT
══════════════════════════════════ */
    .pd-body {
        padding: 36px 0 72px;
    }

    .pd-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 960px) {
        .pd-layout {
            grid-template-columns: 1fr;
        }
    }

    /* ══════════════════════════════════
   PANELS
══════════════════════════════════ */
    .panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .panel-head {
        padding: 18px 22px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .panel-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 600;
        letter-spacing: -.01em;
        color: var(--text);
        margin: 0;
    }

    .panel-title-sm {
        font-size: .7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--dim);
        margin: 0;
    }

    .panel-body {
        padding: 18px 22px 22px;
    }

    .panel-divider {
        height: 1px;
        background: var(--border);
        margin: 0 22px;
    }

    /* ══════════════════════════════════
   PROPERTY HEADER
══════════════════════════════════ */
    .pd-header {
        padding: 22px 22px 20px;
    }

    .pd-badges {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .badge-pill {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .badge-featured {
        background: var(--gold-bg);
        color: var(--gold);
        border: 1px solid var(--gold-bd);
    }

    .badge-condition {
        background: rgba(30, 122, 90, .1);
        color: var(--green);
        border: 1px solid rgba(30, 122, 90, .2);
    }

    .badge-type {
        background: rgba(0, 0, 0, .05);
        color: var(--muted);
        border: 1px solid var(--border);
    }

    .pd-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 600;
        line-height: 1.15;
        letter-spacing: -.02em;
        color: var(--text);
        margin: 0 0 12px;
    }

    .pd-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gold);
        font-family: 'DM Sans', sans-serif;
        letter-spacing: -.02em;
    }

    .pd-price span {
        font-size: .9rem;
        font-weight: 400;
        color: var(--muted);
        margin-left: 4px;
    }

    .pd-address {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: .82rem;
        color: var(--muted);
        margin-top: 8px;
    }

    .pd-address svg {
        width: 13px;
        height: 13px;
        color: var(--gold);
        flex-shrink: 0;
    }

    /* Feature chips row */
    .pd-chips {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid var(--border);
    }

    .pd-chip {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        background: var(--bg);
        border: 1px solid var(--border);
        font-size: .78rem;
        font-weight: 500;
        color: var(--muted);
    }

    .pd-chip svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
        flex-shrink: 0;
    }

    .pd-chip strong {
        color: var(--text);
    }

    /* Share row */
    .pd-share {
        display: flex;
        gap: 6px;
        margin-top: 16px;
        align-items: center;
    }

    .share-label {
        font-size: .72rem;
        color: var(--dim);
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-right: 4px;
    }

    .share-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--bg);
        display: grid;
        place-items: center;
        color: var(--muted);
        cursor: pointer;
        font-size: .78rem;
        transition: all var(--t);
    }

    .share-btn:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    .share-btn svg {
        width: 14px;
        height: 14px;
    }

    /* ══════════════════════════════════
   AMENITIES
══════════════════════════════════ */
    .amenity-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 10px;
    }

    .amenity-item {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 10px 12px;
        border-radius: 9px;
        background: var(--bg);
        border: 1px solid var(--border);
        font-size: .8rem;
        font-weight: 500;
        color: var(--text);
        transition: border-color var(--t), background var(--t);
    }

    .amenity-item:hover {
        border-color: var(--gold-bd);
        background: var(--gold-bg);
    }

    .amenity-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: var(--surface);
        border: 1px solid var(--border);
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .amenity-icon svg {
        width: 16px;
        height: 16px;
        color: var(--gold);
    }

    /* ══════════════════════════════════
   DESCRIPTION
══════════════════════════════════ */
    .pd-desc {
        font-size: .88rem;
        color: var(--muted);
        line-height: 1.8;
    }

    .pd-desc-toggle {
        background: none;
        border: none;
        font-size: .8rem;
        color: var(--gold);
        cursor: pointer;
        padding: 0;
        margin-top: 8px;
        font-family: 'DM Sans', sans-serif;
    }

    /* ══════════════════════════════════
   PROPERTY DETAILS TABLE
══════════════════════════════════ */
    .detail-table {
        width: 100%;
        border-collapse: collapse;
    }

    .detail-table tr {
        border-bottom: 1px solid var(--border);
    }

    .detail-table tr:last-child {
        border-bottom: none;
    }

    .detail-table td {
        padding: 10px 0;
        font-size: .82rem;
    }

    .detail-table td:first-child {
        color: var(--dim);
        width: 45%;
    }

    .detail-table td:last-child {
        color: var(--text);
        font-weight: 500;
    }

    /* ══════════════════════════════════
   MAP
══════════════════════════════════ */
    .pd-map iframe {
        width: 100%;
        height: 260px;
        border-radius: 10px;
        border: none;
        display: block;
    }

    /* ══════════════════════════════════
   SIDEBAR
══════════════════════════════════ */
    .pd-sidebar {
        position: sticky;
        top: 20px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Price panel */
    .price-panel-big {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--gold);
        padding: 20px 22px 0;
        letter-spacing: -.02em;
    }

    .price-panel-big span {
        font-size: 1rem;
        font-weight: 400;
        color: var(--muted);
        font-family: 'DM Sans', sans-serif;
    }

    /* Agent card inside sidebar */
    .agent-mini {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 22px;
        cursor: pointer;
        transition: background var(--t);
        border-bottom: 1px solid var(--border);
    }

    .agent-mini:hover {
        background: var(--bg);
    }

    .agent-mini-img {
        position: relative;
        flex-shrink: 0;
    }

    .agent-mini-img img {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        object-fit: cover;
        object-position: top;
        border: 2px solid var(--border);
    }

    .agent-verified-dot {
        position: absolute;
        bottom: 1px;
        right: 1px;
        width: 14px;
        height: 14px;
        background: var(--green);
        border-radius: 50%;
        border: 2px solid var(--surface);
        display: grid;
        place-items: center;
    }

    .agent-verified-dot svg {
        width: 7px;
        height: 7px;
        color: #fff;
    }

    .agent-mini-name {
        font-size: .88rem;
        font-weight: 600;
        color: var(--text);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .agent-mini-role {
        font-size: .72rem;
        color: var(--muted);
        margin: 2px 0 0;
    }

    .agent-rating {
        display: flex;
        align-items: center;
        gap: 3px;
        margin-top: 3px;
    }

    .a-star {
        width: 11px;
        height: 11px;
        color: var(--gold);
    }

    .a-star.e {
        color: #D9D4CC;
    }

    .a-rval {
        font-size: .72rem;
        color: var(--muted);
        margin-left: 2px;
    }

    /* Verified badge inline */
    .vbadge {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 1px 6px;
        border-radius: 10px;
        background: rgba(30, 122, 90, .08);
        color: var(--green);
        border: 1px solid rgba(30, 122, 90, .2);
        font-size: .62rem;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .vbadge svg {
        width: 8px;
        height: 8px;
    }

    /* Contact info rows */
    .contact-info {
        padding: 14px 22px;
    }

    .ci-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid var(--border);
        font-size: .8rem;
    }

    .ci-row:last-child {
        border-bottom: none;
    }

    .ci-row svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
        flex-shrink: 0;
    }

    .ci-label {
        color: var(--dim);
        min-width: 90px;
    }

    .ci-val {
        color: var(--text);
        font-weight: 500;
    }

    /* Action buttons */
    .action-stack {
        padding: 0 22px 20px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .ac-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 16px;
        border-radius: 10px;
        font-size: .83rem;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: all var(--t);
        border: none;
        text-decoration: none;
    }

    .ac-btn svg {
        width: 15px;
        height: 15px;
    }

    .ac-primary {
        background: var(--gold);
        color: #fff;
    }

    .ac-primary:hover {
        background: #a06828;
        color: #fff;
    }

    .ac-secondary {
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        color: var(--gold);
    }

    .ac-secondary:hover {
        background: var(--gold);
        color: #fff;
    }

    .ac-outline {
        background: var(--bg);
        border: 1px solid var(--border2);
        color: var(--text);
    }

    .ac-outline:hover {
        background: var(--text);
        color: #fff;
    }

    .ac-wa {
        background: rgba(37, 211, 102, .1);
        border: 1px solid rgba(37, 211, 102, .25);
        color: #128C7E;
    }

    .ac-wa:hover {
        background: #25D366;
        color: #fff;
        border-color: #25D366;
    }

    /* View profile link */
    .view-profile-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        font-size: .75rem;
        color: var(--gold);
        padding: 8px 22px 16px;
        transition: gap var(--t);
    }

    .view-profile-link:hover {
        gap: 8px;
        color: #a06828;
    }

    .view-profile-link svg {
        width: 12px;
        height: 12px;
    }

    /* ══════════════════════════════════
   RELATED HOMES
══════════════════════════════════ */
    .related-section {
        padding: 0 0 72px;
    }

    .related-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .related-header h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 500;
        margin: 0;
        letter-spacing: -.01em;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }

    .rel-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform var(--t), box-shadow var(--t);
        text-decoration: none;
        color: var(--text);
    }

    .rel-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .09);
        color: var(--text);
    }

    .rel-img {
        position: relative;
        aspect-ratio: 16/10;
        overflow: hidden;
        background: var(--bg);
    }

    .rel-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .4s ease;
    }

    .rel-card:hover .rel-img img {
        transform: scale(1.05);
    }

    .rel-cond {
        position: absolute;
        top: 8px;
        left: 8px;
        padding: 2px 8px;
        border-radius: 5px;
        font-size: .65rem;
        font-weight: 600;
        background: rgba(200, 135, 58, .9);
        color: #fff;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .rel-body {
        padding: 14px 16px 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .rel-title {
        font-size: .9rem;
        font-weight: 600;
        color: var(--text);
        line-height: 1.3;
    }

    .rel-addr {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .75rem;
        color: var(--muted);
    }

    .rel-addr svg {
        width: 10px;
        height: 10px;
        color: var(--gold);
        flex-shrink: 0;
    }

    .rel-stats {
        display: flex;
        gap: 10px;
    }

    .rel-stat {
        display: flex;
        align-items: center;
        gap: 3px;
        font-size: .73rem;
        color: var(--muted);
    }

    .rel-stat svg {
        width: 11px;
        height: 11px;
    }

    .rel-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 10px;
        border-top: 1px solid var(--border);
        margin-top: auto;
    }

    .rel-price {
        font-size: .95rem;
        font-weight: 700;
        color: var(--gold);
    }

    .rel-price span {
        font-size: .72rem;
        font-weight: 400;
        color: var(--dim);
    }

    /* see all btn */
    .see-all-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 16px;
        border-radius: 8px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        color: var(--gold);
        font-size: .8rem;
        font-weight: 500;
        transition: all var(--t);
    }

    .see-all-btn:hover {
        background: var(--gold);
        color: #fff;
    }

    .see-all-btn svg {
        width: 13px;
        height: 13px;
        transition: transform var(--t);
    }

    .see-all-btn:hover svg {
        transform: translateX(3px);
    }

    /* ── Animations ── */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fu {
        animation: fadeUp .4s ease both;
    }

    .fu2 {
        animation: fadeUp .4s ease .08s both;
    }

    .fu3 {
        animation: fadeUp .4s ease .16s both;
    }

    /* ── Modal ── */
    .inquiry-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 9998;
        background: rgba(0, 0, 0, .5);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        backdrop-filter: blur(4px);
    }

    .inquiry-modal-overlay.open {
        display: flex;
    }

    .inquiry-modal {
        background: var(--surface);
        border-radius: 16px;
        width: 100%;
        max-width: 480px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(0, 0, 0, .18);
    }

    .im-head {
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

    .im-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
    }

    .im-sub {
        font-size: .78rem;
        color: var(--muted);
        margin-top: 2px;
    }

    .im-close {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--muted);
        padding: 0;
    }

    .im-close svg {
        width: 20px;
        height: 20px;
    }

    .im-body {
        padding: 20px 24px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .im-field label {
        display: block;
        font-size: .75rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .im-field input,
    .im-field textarea {
        width: 100%;
        padding: 9px 13px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: .83rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        transition: border-color var(--t);
    }

    .im-field input:focus,
    .im-field textarea:focus {
        outline: none;
        border-color: var(--gold);
    }

    .im-field textarea {
        resize: vertical;
        min-height: 90px;
    }

    .im-foot {
        padding: 0 24px 20px;
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .im-cancel {
        padding: 9px 16px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--bg);
        font-size: .82rem;
        cursor: pointer;
        color: var(--muted);
        font-family: 'DM Sans', sans-serif;
        transition: all var(--t);
    }

    .im-cancel:hover {
        border-color: var(--border2);
        color: var(--text);
    }

    .im-submit {
        padding: 9px 20px;
        border-radius: 8px;
        background: var(--gold);
        border: none;
        color: #fff;
        font-size: .82rem;
        font-weight: 600;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: background var(--t);
    }

    .im-submit:hover {
        background: #a06828;
    }
</style>

{{-- ── Breadcrumb ── --}}
<div class="pd-breadcrumb">
    <div class="container">
        <a href="{{ route('front.home') }}">Home</a>
        <span class="mx-2">›</span>
        <a href="{{ route('front.buy.homes') }}">Properties</a>
        <span class="mx-2">›</span>
        <span>{{ Str::limit($home->title, 40) }}</span>
    </div>
</div>

{{-- ══════════════════ GALLERY ══════════════════ --}}
<div class="pd-gallery">
    <div class="container">
        @php $images = $home->images; $imgCount = $images->count(); @endphp

        <div class="gallery-grid">
            {{-- Main image --}}
            <div class="gallery-cell main" onclick="openLightbox(0)">
                @if($imgCount > 0)
                <img src="{{ asset($images->first()->image_path) }}" alt="{{ $home->title }}">
                @else
                <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png') }}" alt="{{ $home->title }}">
                @endif
                <div class="gallery-overlay">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3" />
                    </svg>
                </div>
            </div>
            {{-- Top right --}}
            <div class="gallery-cell sm" onclick="openLightbox(1)" style="grid-row:1">
                @if($imgCount > 1)
                <img src="{{ asset($images->skip(1)->first()->image_path) }}" alt="{{ $home->title }}">
                @else
                <img src="{{ asset('front/assets/img/all-images/properties/property-img2.png') }}" alt="{{ $home->title }}">
                @endif
                <div class="gallery-overlay">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21 15l-5-5L5 21" />
                        <path d="M21 21H3V3" />
                    </svg>
                </div>
            </div>
            {{-- Bottom right --}}
            <div class="gallery-cell sm" onclick="openLightbox(2)" style="grid-row:2">
                @if($imgCount > 2)
                <img src="{{ asset($images->skip(2)->first()->image_path) }}" alt="{{ $home->title }}">
                @else
                <img src="{{ asset('front/assets/img/all-images/properties/property-img3.png') }}" alt="{{ $home->title }}">
                @endif
                <div class="gallery-overlay">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21 15l-5-5L5 21" />
                        <path d="M21 21H3V3" />
                    </svg>
                </div>
                @if($imgCount > 3)
                <div class="gallery-more">+{{ $imgCount - 3 }} photos</div>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- ══════════════════ LIGHTBOX ══════════════════ --}}
<div class="lightbox" id="lightbox" onclick="closeLightboxOnBg(event)">
    <div class="lightbox-inner">
        <button class="lb-close" onclick="closeLightbox()">✕</button>
        <button class="lb-nav lb-prev" onclick="lbNav(-1)">‹</button>
        <button class="lb-nav lb-next" onclick="lbNav(1)">›</button>
        <img id="lb-img" src="" alt="gallery">
        <div class="lb-counter" id="lb-counter"></div>
        <div class="lb-thumbs" id="lb-thumbs"></div>
    </div>
</div>

{{-- ══════════════════ BODY ══════════════════ --}}
<div class="pd-body">
    <div class="container">
        <div class="pd-layout">

            {{-- ════ LEFT MAIN CONTENT ════ --}}
            <div class="fu">

                {{-- Property Header Panel --}}
                <div class="panel">
                    <div class="pd-header">
                        <div class="pd-badges">
                            <span class="badge-pill badge-featured">Featured</span>
                            @if($home->condition)
                            <span class="badge-pill badge-condition">{{ $home->condition }}</span>
                            @endif
                            @if($home->type)
                            <span class="badge-pill badge-type">{{ $home->type }}</span>
                            @endif
                        </div>
                        <h1 class="pd-title">{{ $home->title }}</h1>
                        <div class="pd-price">
                            {{ number_format($home->price) }}<span>RWF</span>
                        </div>
                        <div class="pd-address">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg>
                            {{ $home->address }}@if($home->city), {{ $home->city }}@endif
                        </div>
                        <div class="pd-chips">
                            @if($home->bedrooms)
                            <div class="pd-chip">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 9.556V3h-2v2H6V3H4v6.557C2.81 10.25 2 11.526 2 13v4h1v2h2v-2h14v2h2v-2h1v-4c0-1.474-.811-2.75-2-3.444zM11 9H6V7h5v2zm7 0h-5V7h5v2z" />
                                </svg>
                                <strong>{{ $home->bedrooms }}</strong> Bedrooms
                            </div>
                            @endif
                            @if($home->bathrooms)
                            <div class="pd-chip">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 10H7V7c0-1.103.897-2 2-2s2 .897 2 2h2c0-2.206-1.794-4-4-4S5 4.794 5 7v3H3a1 1 0 00-1 1v2c0 3.478 2.549 6.385 5.895 6.93L7 22h2l-.895-2h7.79L15 22h2l-.895-2.07C19.451 19.385 22 16.478 22 13v-2a1 1 0 00-1-1z" />
                                </svg>
                                <strong>{{ $home->bathrooms }}</strong> Bathrooms
                            </div>
                            @endif
                            @if($home->area_sqft)
                            <div class="pd-chip">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z" />
                                </svg>
                                <strong>{{ number_format($home->area_sqft) }}</strong> sq ft
                            </div>
                            @endif
                            @if($home->garage ?? false)
                            <div class="pd-chip">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 9.3V4h-3v2.6L12 3 2 12h3v9h5v-5h4v5h5v-9h3l-3-2.7zm-9 .7c0-1.1.9-2 2-2s2 .9 2 2H10z" />
                                </svg>
                                <strong>{{ $home->garage }}</strong> Garage
                            </div>
                            @endif
                        </div>
                        <div class="pd-share">
                            <span class="share-label">Share</span>
                            <button class="share-btn" title="Save">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                                </svg>
                            </button>
                            <button class="share-btn" title="Share" onclick="navigator.share && navigator.share({title:'{{ $home->title }}', url: window.location.href})">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13.1202 17.0228L8.92129 14.7324C8.19135 15.5125 7.15261 16 6 16C3.79086 16 2 14.2091 2 12C2 9.79086 3.79086 8 6 8C7.15255 8 8.19125 8.48746 8.92118 9.26746L13.1202 6.97713C13.0417 6.66441 13 6.33707 13 6C13 3.79086 14.7909 2 17 2C19.2091 2 21 3.79086 21 6C21 8.20914 19.2091 10 17 10C15.8474 10 14.8087 9.51251 14.0787 8.73246L9.87977 11.0228C9.9583 11.3355 10 11.6629 10 12C10 12.3371 9.95831 12.6644 9.87981 12.9771L14.0788 15.2675C14.8087 14.4875 15.8474 14 17 14C19.2091 14 21 15.7909 21 18C21 20.2091 19.2091 22 17 22C14.7909 22 13 20.2091 13 18C13 17.6629 13.0417 17.3355 13.1202 17.0228Z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @if($home->description)
                <div class="panel">
                    <div class="panel-head">
                        <p class="panel-title">About this property</p>
                    </div>
                    <div class="panel-body">
                        <p class="pd-desc" id="desc-text" style="display:-webkit-box;-webkit-line-clamp:4;-webkit-box-orient:vertical;overflow:hidden">
                            {{ $home->description }}
                        </p>
                        <button class="pd-desc-toggle" onclick="toggleDesc(this)">Read more ↓</button>
                    </div>
                </div>
                @endif

                {{-- Property Details --}}
                <div class="panel">
                    <div class="panel-head">
                        <p class="panel-title">Property Details</p>
                    </div>
                    <div class="panel-body">
                        <table class="detail-table">
                            <tr>
                                <td>Property Type</td>
                                <td>{{ $home->type ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td>Condition</td>
                                <td>{{ $home->condition ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td>Bedrooms</td>
                                <td>{{ $home->bedrooms ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td>Bathrooms</td>
                                <td>{{ $home->bathrooms ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td>Area</td>
                                <td>{{ $home->area_sqft ? number_format($home->area_sqft).' sq ft' : '—' }}</td>
                            </tr>
                            @if($home->year_built ?? false)
                            <tr>
                                <td>Year Built</td>
                                <td>{{ $home->year_built }}</td>
                            </tr>
                            @endif
                            @if($home->garage ?? false)
                            <tr>
                                <td>Garage</td>
                                <td>{{ $home->garage }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>City</td>
                                <td>{{ $home->city ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td>Zip Code</td>
                                <td>{{ $home->zip_code ?? '—' }}</td>
                            </tr>
                            @if($home->service)
                            <tr>
                                <td>Service</td>
                                <td>{{ $home->service->title }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- Amenities --}}
                @if($home->facilities->count())
                <div class="panel">
                    <div class="panel-head">
                        <p class="panel-title">Amenities & Features</p>
                        <span style="font-size:.75rem;color:var(--muted)">{{ $home->facilities->count() }} features</span>
                    </div>
                    <div class="panel-body">
                        <div class="amenity-grid">
                            @foreach($home->facilities as $facility)
                            <div class="amenity-item">
                                <div class="amenity-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                {{ $facility->name }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{-- Video --}}
                @if($home->video_url ?? false)
                <div class="panel">
                    <div class="panel-head">
                        <p class="panel-title">Property Video Tour</p>
                    </div>
                    <div class="panel-body">
                        <div class="pd-video-wrap" id="video-wrap">
                            <img class="pd-video-thumb"
                                src="{{ $home->images->first() ? asset($home->images->first()->image_path) : asset('front/assets/img/all-images/properties/property-img33.png') }}"
                                alt="video thumbnail">
                            <button class="pd-play-btn" onclick="playVideo('{{ $home->video_url }}')" aria-label="Play video">
                                <div class="play-circle">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </button>
                            <div class="pd-video-label">▶ Watch Property Tour</div>
                            <iframe class="pd-video-iframe" id="video-iframe" allowfullscreen allow="autoplay"></iframe>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Map --}}
                <div class="panel">
                    <div class="panel-head">
                        <p class="panel-title">Location</p>
                    </div>
                    <div class="panel-body pd-map">
                        <iframe
                            src="https://www.google.com/maps?q={{ urlencode($home->address . ', ' . ($home->city ?? '') . ', Rwanda') }}&output=embed"
                            loading="lazy" allowfullscreen>
                        </iframe>
                    </div>
                </div>

                {{-- Documents --}}
                @if($home->service)
                <div class="panel">
                    <div class="panel-head">
                        <p class="panel-title">Documents</p>
                    </div>
                    <div class="panel-body">
                        <div style="display:flex;flex-direction:column;gap:8px">
                            <a href="#" class="amenity-item" style="justify-content:space-between">
                                <div style="display:flex;align-items:center;gap:9px">
                                    <div class="amenity-icon">
                                        <svg viewBox="0 0 24 24" fill="currentColor" style="color:#e53e3e">
                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                                            <path d="M14 2v6h6" />
                                        </svg>
                                    </div>
                                    {{ $home->service->title }} — Document.pdf
                                </div>
                                <svg viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;color:var(--gold)">
                                    <path d="M13 10H18L12 16L6 10H11V3H13V10ZM4 19H20V12H22V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V12H4V19Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

            </div>{{-- /main --}}

            {{-- ════ RIGHT SIDEBAR ════ --}}
            <div class="pd-sidebar fu2">

                {{-- Price + Agent Panel --}}
                <div class="panel">
                    <div class="price-panel-big">
                        {{ number_format($home->price) }}<span> RWF</span>
                    </div>

                    <div class="panel-divider" style="margin-top:16px"></div>

                    {{-- Agent --}}
                    @if($home->user ?? false)
                    @php
                    $agent = $home->user;
                    $agentRating = $agent->rating ?? 4.8;
                    $agentStars = (int) round($agentRating);
                    @endphp
                    <a href="{{ isset($agent->agent) ? route('front.agent.details', $agent->agent) : '#' }}"
                        class="agent-mini">
                        <div class="agent-mini-img">
                            <img src="{{ asset('front/assets/img/all-images/team/team-img1.png') }}"
                                alt="{{ $agent->name }}">
                            @if($agent->is_verified ?? false)
                            <div class="agent-verified-dot">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 12l2 2 4-4" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div>
                            <p class="agent-mini-name">
                                {{ $agent->name }}
                                @if($agent->is_verified ?? false)
                                <span class="vbadge">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Verified
                                </span>
                                @endif
                            </p>
                            <p class="agent-mini-role">{{ $agent->role ?? 'Real Estate Agent' }}</p>
                            <div class="agent-rating">
                                @for($s = 1; $s <= 5; $s++)
                                    <svg class="a-star {{ $s > $agentStars ? 'e' : '' }}" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                    @endfor
                                    <span class="a-rval">{{ number_format($agentRating, 1) }}</span>
                            </div>
                        </div>
                    </a>

                    {{-- Contact info --}}
                    <div class="contact-info">
                        @if($agent->phone ?? false)
                        <div class="ci-row">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                            </svg>
                            <span class="ci-label">Phone</span>
                            <span class="ci-val">{{ $agent->phone }}</span>
                        </div>
                        @endif
                        <div class="ci-row">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                            </svg>
                            <span class="ci-label">Email</span>
                            <span class="ci-val" style="font-size:.75rem">{{ $agent->email }}</span>
                        </div>
                        @if($agent->website ?? false)
                        <div class="ci-row">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" />
                            </svg>
                            <span class="ci-label">Website</span>
                            <span class="ci-val" style="font-size:.75rem">{{ $agent->website }}</span>
                        </div>
                        @endif
                        <div class="ci-row">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm.5 14.5h-1v-6h1v6zm0-8h-1v-1h1v1z" />
                            </svg>
                            <span class="ci-label">Hours</span>
                            <span class="ci-val">Mon–Fri, 9am–6pm</span>
                        </div>
                    </div>
                    @endif

                    <div class="action-stack">
                        <button class="ac-btn ac-primary" onclick="document.getElementById('inquiry-overlay').classList.add('open')">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
                            </svg>
                            Send Inquiry
                        </button>
                        @if($agent->phone ?? false)
                        <a href="tel:{{ $agent->phone }}" class="ac-btn ac-secondary">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                            </svg>
                            Call Agent
                        </a>
                        @endif
                        @if($agent->whatsapp ?? $agent->phone ?? false)
                        <a href="https://wa.me/{{ $agent->whatsapp ?? $agent->phone }}" target="_blank" class="ac-btn ac-wa">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
                                <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" />
                            </svg>
                            WhatsApp
                        </a>
                        @endif
                    </div>

                    {{-- View profile --}}
                    @if($home->user ?? false)
                    <a href="{{ isset($agent->agent) ? route('front.agent.details', $agent->agent) : '#' }}"
                        class="view-profile-link">
                        View full profile
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                    @endif
                </div>

            </div>{{-- /sidebar --}}

        </div>{{-- /pd-layout --}}
    </div>
</div>

{{-- ══════════════════ RELATED HOMES ══════════════════ --}}
@if($relatedHomes->count())
<div class="related-section">
    <div class="container">
        <div class="related-header">
            <h2>Similar properties</h2>
            <a href="{{ route('front.buy.homes') }}" class="see-all-btn">
                See all
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        <div class="related-grid">
            @foreach($relatedHomes as $rel)
            <a href="{{ route('front.buy.home.details', $rel) }}" class="rel-card">
                <div class="rel-img">
                    @if($rel->images->first())
                    <img src="{{ asset($rel->images->first()->image_path) }}" alt="{{ $rel->title }}">
                    @else
                    <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png') }}" alt="{{ $rel->title }}">
                    @endif
                    @if($rel->condition)
                    <span class="rel-cond">{{ $rel->condition }}</span>
                    @endif
                </div>
                <div class="rel-body">
                    <p class="rel-title">{{ $rel->title }}</p>
                    <div class="rel-addr">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                        </svg>
                        {{ Str::limit($rel->address, 36) }}
                    </div>
                    <div class="rel-stats">
                        @if($rel->bedrooms)
                        <span class="rel-stat">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 9.556V3h-2v2H6V3H4v6.557C2.81 10.25 2 11.526 2 13v4h1v2h2v-2h14v2h2v-2h1v-4c0-1.474-.811-2.75-2-3.444zM11 9H6V7h5v2zm7 0h-5V7h5v2z" />
                            </svg>
                            {{ $rel->bedrooms }}
                        </span>
                        @endif
                        @if($rel->bathrooms)
                        <span class="rel-stat">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21 10H7V7c0-1.103.897-2 2-2s2 .897 2 2h2c0-2.206-1.794-4-4-4S5 4.794 5 7v3H3a1 1 0 00-1 1v2c0 3.478 2.549 6.385 5.895 6.93L7 22h2l-.895-2h7.79L15 22h2l-.895-2.07C19.451 19.385 22 16.478 22 13v-2a1 1 0 00-1-1z" />
                            </svg>
                            {{ $rel->bathrooms }}
                        </span>
                        @endif
                        @if($rel->area_sqft)
                        <span class="rel-stat">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z" />
                            </svg>
                            {{ number_format($rel->area_sqft) }} sq
                        </span>
                        @endif
                    </div>
                    <div class="rel-footer">
                        <span class="rel-price">{{ number_format($rel->price) }} <span>RWF</span></span>
                        <span style="font-size:.75rem;color:var(--gold)">View →</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ══════════════════ INQUIRY MODAL ══════════════════ --}}
<div class="inquiry-modal-overlay" id="inquiry-overlay" onclick="closeInquiryOnBg(event)">
    <div class="inquiry-modal">
        <div class="im-head">
            <div>
                <p class="im-title">Send Inquiry</p>
                <p class="im-sub">Interested in <strong>{{ Str::limit($home->title, 40) }}</strong>?</p>
            </div>
            <button class="im-close" onclick="document.getElementById('inquiry-overlay').classList.remove('open')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('front.buy.home.inquiry') }}">
            @csrf
            <input type="hidden" name="home_id" value="{{ $home->id }}">
            <div class="im-body">
                <div class="im-field">
                    <label>Your Name</label>
                    <input type="text" name="name" required placeholder="Enter your full name"
                        value="{{ auth()->user()->name ?? '' }}">
                </div>
                <div class="im-field">
                    <label>Your Email</label>
                    <input type="email" name="email" required placeholder="Enter your email"
                        value="{{ auth()->user()->email ?? '' }}">
                </div>
                <div class="im-field">
                    <label>Phone (optional)</label>
                    <input type="tel" name="phone" placeholder="+250 7XX XXX XXX">
                </div>
                <div class="im-field">
                    <label>Message</label>
                    <textarea name="message" required>Hi, I am interested in {{ $home->title }}. Please contact me with more details.</textarea>
                </div>
            </div>
            <div class="im-foot">
                <button type="button" class="im-cancel"
                    onclick="document.getElementById('inquiry-overlay').classList.remove('open')">
                    Cancel
                </button>
                <button type="submit" class="im-submit">Send Inquiry</button>
            </div>
        </form>
    </div>
</div>

<script>
    /* ── Gallery Lightbox ── */
    const lbImages = @json($home -> images -> pluck('image_path') -> map(fn($p) => asset($p)));
    let lbIndex = 0;

    function openLightbox(i) {
        lbIndex = Math.min(i, lbImages.length - 1);
        const lb = document.getElementById('lightbox');
        lb.classList.add('open');
        renderLb();
        buildThumbs();
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('open');
        document.body.style.overflow = '';
    }

    function closeLightboxOnBg(e) {
        if (e.target === document.getElementById('lightbox')) closeLightbox();
    }

    function lbNav(dir) {
        lbIndex = (lbIndex + dir + lbImages.length) % lbImages.length;
        renderLb();
        updateThumbs();
    }

    function renderLb() {
        document.getElementById('lb-img').src = lbImages[lbIndex];
        document.getElementById('lb-counter').textContent = (lbIndex + 1) + ' / ' + lbImages.length;
    }

    function buildThumbs() {
        const wrap = document.getElementById('lb-thumbs');
        wrap.innerHTML = lbImages.map((src, i) =>
            `<div class="lb-thumb ${i===lbIndex?'active':''}" onclick="lbGoto(${i})">
            <img src="${src}" alt="">
         </div>`
        ).join('');
    }

    function lbGoto(i) {
        lbIndex = i;
        renderLb();
        updateThumbs();
    }

    function updateThumbs() {
        document.querySelectorAll('.lb-thumb').forEach((t, i) => t.classList.toggle('active', i === lbIndex));
    }
    document.addEventListener('keydown', e => {
        if (!document.getElementById('lightbox').classList.contains('open')) return;
        if (e.key === 'ArrowRight') lbNav(1);
        if (e.key === 'ArrowLeft') lbNav(-1);
        if (e.key === 'Escape') closeLightbox();
    });

    /* ── Inline Video ── */
    function playVideo(url) {
        const wrap = document.getElementById('video-wrap');
        const iframe = document.getElementById('video-iframe');
        // Convert YouTube watch URLs to embed URLs
        let embedUrl = url.replace('watch?v=', 'embed/').replace('youtu.be/', 'www.youtube.com/embed/');
        if (!embedUrl.includes('?')) embedUrl += '?autoplay=1';
        else embedUrl += '&autoplay=1';
        iframe.src = embedUrl;
        iframe.style.display = 'block';
        wrap.querySelector('.pd-video-thumb').style.display = 'none';
        wrap.querySelector('.pd-play-btn').style.display = 'none';
        wrap.querySelector('.pd-video-label').style.display = 'none';
    }

    /* ── Description toggle ── */
    function toggleDesc(btn) {
        const el = document.getElementById('desc-text');
        const collapsed = el.style.webkitLineClamp === '4';
        el.style.webkitLineClamp = collapsed ? 'unset' : '4';
        el.style.overflow = collapsed ? 'visible' : 'hidden';
        btn.textContent = collapsed ? 'Read less ↑' : 'Read more ↓';
    }

    /* ── Inquiry modal close on bg click ── */
    function closeInquiryOnBg(e) {
        if (e.target === document.getElementById('inquiry-overlay')) {
            document.getElementById('inquiry-overlay').classList.remove('open');
        }
    }
</script>

@endsection