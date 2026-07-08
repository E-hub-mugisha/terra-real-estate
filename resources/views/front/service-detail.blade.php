@extends('layouts.guest')
@section('title', $category->name)
@section('content')

@php
// Pre-build the JS-safe services array (never pass raw Eloquent collections/closures to @json)
$servicesForJs = $category->services->map(function ($s) {
return [
'id' => $s->id,
'title' => $s->title,
'description' => \Illuminate\Support\Str::limit($s->description, 100),
];
})->values();
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --surface: #FFFFFF;
        --dark: #19265d;
        --border: rgba(0, 0, 0, .08);
        --border2: rgba(0, 0, 0, .14);
        --gold: #D05208;
        --gold-lt: #E5A55E;
        --gold-bg: rgba(200, 135, 58, .07);
        --gold-bd: rgba(200, 135, 58, .22);
        --text: #19265d;
        --muted: #6B6560;
        --dim: #9E9890;
        --green: #1E7A5A;
        --green-bg: rgba(30, 122, 90, .07);
        --green-bd: rgba(30, 122, 90, .2);
        --red: #C0392B;
        --red-bg: rgba(192, 57, 43, .08);
        --red-bd: rgba(192, 57, 43, .2);
        --r: 13px;
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

    /* ══════════════════════════
   BREADCRUMB
══════════════════════════ */
    .sc-breadcrumb {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 12px 0;
    }

    .sc-bc-inner {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: .75rem;
        color: var(--dim);
        flex-wrap: wrap;
    }

    .sc-bc-inner a {
        color: var(--muted);
        transition: color var(--t);
    }

    .sc-bc-inner a:hover {
        color: var(--gold);
    }

    .sc-bc-inner svg {
        width: 12px;
        height: 12px;
        color: var(--dim);
    }

    .sc-bc-inner .cur {
        color: var(--text);
        font-weight: 500;
    }

    /* ══════════════════════════
   HERO — CATEGORY HEADER
══════════════════════════ */
    .sc-hero {
        background: var(--dark);
        position: relative;
        overflow: hidden;
        padding: 72px 0 64px;
    }

    .sc-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        /* background:
            radial-gradient(ellipse 55% 60% at 5% 50%, rgba(200, 135, 58, .13) 0%, transparent 65%),
            radial-gradient(ellipse 40% 55% at 95% 25%, rgba(200, 135, 58, .06) 0%, transparent 55%); */
        pointer-events: none;
    }

    .sc-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        /* background-image:
            repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255, 255, 255, .018) 39px, rgba(255, 255, 255, .018) 40px),
            repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255, 255, 255, .012) 79px, rgba(255, 255, 255, .012) 80px); */
        pointer-events: none;
    }

    .sc-hero .container {
        position: relative;
        z-index: 2;
    }

    .sc-hero-layout {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 56px;
        align-items: center;
    }

    @media (max-width: 900px) {
        .sc-hero-layout {
            grid-template-columns: 1fr;
        }

        .sc-hero-imgs {
            display: none;
        }
    }

    /* Text side */
    .sc-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .7rem;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold-lt);
        margin-bottom: 14px;
    }

    .sc-eyebrow::before {
        content: '';
        width: 18px;
        height: 1px;
        background: var(--gold);
        opacity: .6;
    }

    .sc-hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2rem, 5vw, 1.4rem);
        font-weight: 500;
        line-height: 1.1;
        letter-spacing: -.02em;
        color: #F0EDE8;
        margin-bottom: 16px;
    }

    .sc-hero-title em {
        font-style: italic;
        color: var(--gold-lt);
    }

    .sc-hero-desc {
        font-size: .88rem;
        color: rgba(240, 237, 232, .45);
        line-height: 1.8;
        margin-bottom: 28px;
        max-width: 480px;
    }

    .sc-hero-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .sc-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 12px 22px;
        border-radius: 9px;
        background: var(--gold);
        border: none;
        color: #fff;
        font-size: .84rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background var(--t), transform var(--t);
        text-decoration: none;
    }

    .sc-btn-primary:hover {
        background: #a06828;
        transform: translateY(-1px);
        color: #fff;
    }

    .sc-btn-primary svg {
        width: 14px;
        height: 14px;
    }

    .sc-btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 12px 22px;
        border-radius: 9px;
        background: rgba(255, 255, 255, .08);
        color: rgba(240, 237, 232, .7);
        border: 1px solid rgba(255, 255, 255, .15);
        font-size: .84rem;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        transition: all var(--t);
        text-decoration: none;
        cursor: pointer;
    }

    .sc-btn-outline:hover {
        background: rgba(255, 255, 255, .14);
        color: #F0EDE8;
    }

    .sc-btn-outline svg {
        width: 14px;
        height: 14px;
    }

    /* Image mosaic */
    .sc-hero-imgs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 200px 160px;
        gap: 8px;
    }

    .sc-img {
        border-radius: var(--r);
        overflow: hidden;
        background: rgba(255, 255, 255, .06);
        border: 1px solid rgba(255, 255, 255, .08);
    }

    .sc-img:first-child {
        grid-row: 1 / 3;
    }

    .sc-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        opacity: .7;
    }

    /* ══════════════════════════
   SERVICES SECTION
══════════════════════════ */
    .sc-services {
        padding: 72px 0 80px;
    }

    .sc-section-head {
        margin-bottom: 40px;
    }

    .sc-section-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .68rem;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 8px;
    }

    .sc-section-eyebrow::before {
        content: '';
        width: 16px;
        height: 1px;
        background: var(--gold);
        opacity: .5;
    }

    .sc-section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        font-weight: 500;
        letter-spacing: -.02em;
        color: var(--text);
    }

    .sc-section-title em {
        font-style: italic;
        color: var(--gold);
    }

    .sc-section-sub {
        font-size: .85rem;
        color: var(--muted);
        margin-top: 6px;
        line-height: 1.7;
    }

    /* ── Service Card ── */
    .sc-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        padding: 24px 20px 20px;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        overflow: hidden;
        transition: transform var(--t), border-color var(--t), box-shadow var(--t);
        animation: scFu .4s ease both;
        cursor: pointer;
    }

    .sc-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--gold) 0%, transparent 100%);
        opacity: 0;
        transition: opacity var(--t);
    }

    .sc-card:hover {
        transform: translateY(-5px);
        border-color: var(--gold-bd);
        box-shadow: 0 12px 32px rgba(0, 0, 0, .08), 0 0 0 1px rgba(200, 135, 58, .08);
    }

    .sc-card:hover::before {
        opacity: 1;
    }

    @keyframes scFu {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Ghost number */
    .sc-card-num {
        position: absolute;
        top: 14px;
        right: 16px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.6rem;
        font-weight: 600;
        color: rgba(0, 0, 0, .04);
        line-height: 1;
        letter-spacing: -.04em;
        user-select: none;
        pointer-events: none;
        transition: color var(--t);
    }

    .sc-card:hover .sc-card-num {
        color: rgba(200, 135, 58, .06);
    }

    /* Icon */
    .sc-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 11px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        flex-shrink: 0;
        transition: background var(--t), border-color var(--t);
    }

    .sc-card-icon svg {
        width: 20px;
        height: 20px;
        color: var(--gold);
        transition: color var(--t);
    }

    .sc-card:hover .sc-card-icon {
        background: var(--gold);
        border-color: var(--gold);
    }

    .sc-card:hover .sc-card-icon svg {
        color: #fff;
    }

    .sc-card-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 600;
        letter-spacing: -.01em;
        color: var(--text);
        margin-bottom: 8px;
        line-height: 1.25;
    }

    .sc-card-desc {
        font-size: .81rem;
        color: var(--muted);
        line-height: 1.75;
        flex: 1;
        margin-bottom: 16px;
    }

    /* Status / meta */
    .sc-card-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-top: 12px;
        border-top: 1px solid var(--border);
        margin-top: auto;
    }

    .sc-card-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 5px;
        font-size: .67rem;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        background: var(--green-bg);
        border: 1px solid var(--green-bd);
        color: var(--green);
    }

    .sc-card-badge::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--green);
    }

    .sc-card-cta {
        margin-left: auto;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: .78rem;
        font-weight: 600;
        color: var(--gold);
        transition: gap var(--t);
        background: none;
        border: none;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
    }

    .sc-card:hover .sc-card-cta {
        gap: 8px;
    }

    .sc-card-cta svg {
        width: 12px;
        height: 12px;
    }

    /* ── Empty state ── */
    .sc-empty {
        text-align: center;
        padding: 64px 20px;
        color: var(--dim);
    }

    .sc-empty svg {
        width: 44px;
        height: 44px;
        margin-bottom: 14px;
        opacity: .3;
    }

    .sc-empty h3 {
        font-size: .95rem;
        color: var(--muted);
        margin-bottom: 6px;
    }

    .sc-empty p {
        font-size: .82rem;
    }

    /* ══════════════════════════
   CTA SECTION
══════════════════════════ */
    .sc-cta {
        background: var(--dark);
        position: relative;
        overflow: hidden;
        padding: 72px 0;
    }

    .sc-cta::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 50% at 20% 50%, rgba(200, 135, 58, .14) 0%, transparent 60%),
            radial-gradient(ellipse 40% 60% at 85% 30%, rgba(200, 135, 58, .07) 0%, transparent 55%);
        pointer-events: none;
    }

    .sc-cta::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255, 255, 255, .02) 39px, rgba(255, 255, 255, .02) 40px),
            repeating-linear-gradient(90deg, transparent, transparent 39px, rgba(255, 255, 255, .02) 39px, rgba(255, 255, 255, .02) 40px);
        pointer-events: none;
    }

    .sc-cta .container {
        position: relative;
        z-index: 2;
    }

    .sc-cta-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        flex-wrap: wrap;
    }

    .sc-cta-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--gold-lt);
        margin-bottom: 10px;
    }

    .sc-cta-eyebrow::before {
        content: '';
        width: 16px;
        height: 1px;
        background: var(--gold);
        opacity: .6;
    }

    .sc-cta-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.8rem, 3.5vw, 2.6rem);
        font-weight: 500;
        line-height: 1.15;
        letter-spacing: -.02em;
        color: #F0EDE8;
    }

    .sc-cta-title em {
        font-style: italic;
        color: var(--gold-lt);
    }

    .sc-cta-sub {
        font-size: .85rem;
        color: rgba(240, 237, 232, .4);
        line-height: 1.75;
        margin-top: 10px;
        max-width: 440px;
    }

    .sc-cta-btns {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    .sc-cta-btn {
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

    .sc-cta-btn svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
    }

    .sc-btn-email {
        background: var(--gold);
        color: #fff;
    }

    .sc-btn-email:hover {
        background: #a06828;
        color: #fff;
        transform: translateY(-1px);
    }

    .sc-btn-wa {
        background: rgba(37, 211, 102, .12);
        color: #25D366;
        border: 1px solid rgba(37, 211, 102, .25);
    }

    .sc-btn-wa:hover {
        background: #25D366;
        color: #fff;
    }

    .sc-btn-call {
        background: rgba(255, 255, 255, .08);
        color: #F0EDE8;
        border: 1px solid rgba(255, 255, 255, .15);
    }

    .sc-btn-call:hover {
        background: rgba(255, 255, 255, .16);
        color: #fff;
    }

    /* ══════════════════════════
   REQUEST SERVICE MODAL
══════════════════════════ */
    .srm-overlay {
        position: fixed;
        inset: 0;
        z-index: 1200;
        background: rgba(15, 20, 40, .55);
        backdrop-filter: blur(3px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        visibility: hidden;
        transition: opacity var(--t), visibility var(--t);
    }

    .srm-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .srm-modal {
        background: var(--surface);
        border-radius: 16px;
        width: 100%;
        max-width: 560px;
        max-height: 88vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 30px 70px rgba(0, 0, 0, .35);
        transform: translateY(16px) scale(.98);
        transition: transform var(--t);
    }

    .srm-overlay.active .srm-modal {
        transform: translateY(0) scale(1);
    }

    .srm-modal-header {
        background: var(--dark);
        padding: 22px 24px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .srm-modal-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 100% at 0% 0%, rgba(200, 135, 58, .18) 0%, transparent 60%);
        pointer-events: none;
    }

    .srm-modal-title-wrap {
        position: relative;
        z-index: 1;
    }

    .srm-modal-eyebrow {
        display: block;
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--gold-lt);
        margin-bottom: 6px;
    }

    .srm-modal-title {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 500;
        font-size: 1.5rem;
        color: #F0EDE8;
        line-height: 1.2;
    }

    .srm-close {
        position: relative;
        z-index: 1;
        width: 30px;
        height: 30px;
        border-radius: 8px;
        flex-shrink: 0;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .14);
        color: rgba(240, 237, 232, .75);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all var(--t);
    }

    .srm-close:hover {
        background: rgba(255, 255, 255, .16);
        color: #fff;
    }

    .srm-close svg {
        width: 15px;
        height: 15px;
    }

    .srm-body {
        padding: 20px 24px 24px;
        overflow-y: auto;
    }

    /* Search view */
    .srm-search-wrap {
        position: relative;
        margin-bottom: 14px;
    }

    .srm-search-wrap svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: var(--dim);
        pointer-events: none;
    }

    .srm-search-wrap input {
        width: 100%;
        padding: 12px 14px 12px 40px;
        border: 1px solid var(--border2);
        border-radius: 10px;
        font-size: .86rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        background: var(--bg);
        transition: border-color var(--t);
    }

    .srm-search-wrap input:focus {
        outline: none;
        border-color: var(--gold);
        background: #fff;
    }

    .srm-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: 340px;
        overflow-y: auto;
    }

    .srm-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: 11px;
        cursor: pointer;
        transition: all var(--t);
        background: var(--surface);
    }

    .srm-item:hover {
        border-color: var(--gold-bd);
        background: var(--gold-bg);
    }

    .srm-item-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        flex-shrink: 0;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .srm-item-icon svg {
        width: 16px;
        height: 16px;
        color: var(--gold);
    }

    .srm-item-text {
        flex: 1;
        min-width: 0;
    }

    .srm-item-title {
        font-size: .87rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 2px;
    }

    .srm-item-desc {
        font-size: .76rem;
        color: var(--muted);
        line-height: 1.5;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .srm-item>svg:last-child {
        width: 13px;
        height: 13px;
        color: var(--dim);
        flex-shrink: 0;
    }

    .srm-empty-list {
        text-align: center;
        padding: 30px 10px;
        color: var(--dim);
        font-size: .84rem;
    }

    /* Form view */
    .srm-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: .78rem;
        font-weight: 600;
        color: var(--muted);
        font-family: 'DM Sans', sans-serif;
        margin-bottom: 14px;
        transition: color var(--t);
    }

    .srm-back:hover {
        color: var(--gold);
    }

    .srm-back svg {
        width: 13px;
        height: 13px;
    }

    .srm-selected-service {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 11px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        margin-bottom: 18px;
    }

    .srm-selected-service-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        flex-shrink: 0;
        background: var(--gold);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .srm-selected-service-icon svg {
        width: 16px;
        height: 16px;
        color: #fff;
    }

    .srm-selected-service-title {
        font-size: .85rem;
        font-weight: 600;
        color: var(--text);
    }

    .srm-selected-service-label {
        font-size: .68rem;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .srm-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .srm-field {
        margin-bottom: 14px;
    }

    .srm-field.full {
        grid-column: 1 / -1;
    }

    .srm-field label {
        display: block;
        font-size: .74rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 6px;
    }

    .srm-field label .opt {
        font-weight: 400;
        color: var(--dim);
        text-transform: none;
        letter-spacing: 0;
    }

    .srm-field input,
    .srm-field textarea {
        width: 100%;
        padding: 10px 13px;
        border: 1px solid var(--border2);
        border-radius: 9px;
        font-size: .84rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        background: var(--bg);
        transition: border-color var(--t);
    }

    .srm-field input:focus,
    .srm-field textarea:focus {
        outline: none;
        border-color: var(--gold);
        background: #fff;
    }

    .srm-field textarea {
        resize: vertical;
        min-height: 70px;
    }

    .srm-alert {
        padding: 10px 13px;
        border-radius: 9px;
        margin-bottom: 14px;
        font-size: .79rem;
        line-height: 1.6;
        background: var(--red-bg);
        border: 1px solid var(--red-bd);
        color: var(--red);
    }

    .srm-submit {
        width: 100%;
        padding: 13px;
        border: none;
        border-radius: 10px;
        background: var(--gold);
        color: #fff;
        font-size: .87rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background var(--t), opacity var(--t);
    }

    .srm-submit:hover:not(:disabled) {
        background: #a06828;
    }

    .srm-submit:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    /* Success view */
    .srm-success {
        text-align: center;
        padding: 20px 10px 6px;
    }

    .srm-success-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--green-bg);
        border: 1px solid var(--green-bd);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
    }

    .srm-success-icon svg {
        width: 26px;
        height: 26px;
        color: var(--green);
    }

    .srm-success h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.35rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 8px;
    }

    .srm-success p {
        font-size: .84rem;
        color: var(--muted);
        line-height: 1.7;
        margin-bottom: 22px;
    }

    @media (max-width: 560px) {
        .srm-grid {
            grid-template-columns: 1fr;
        }

        .srm-modal {
            max-height: 92vh;
        }
    }
    .sc-list-search-wrap { position: relative; max-width: 420px; margin-bottom: 32px; }
.sc-list-search-wrap svg {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    width: 16px; height: 16px; color: var(--dim); pointer-events: none;
}
.sc-list-search-wrap input {
    width: 100%; padding: 12px 14px 12px 40px;
    border: 1px solid var(--border2); border-radius: 10px;
    font-size: .85rem; font-family: 'DM Sans', sans-serif; color: var(--text);
    background: var(--surface); transition: border-color var(--t), box-shadow var(--t);
}
.sc-list-search-wrap input:focus { outline: none; border-color: var(--gold); box-shadow: 0 0 0 3px rgba(200,135,58,.1); }

.sc-no-results { text-align: center; padding: 50px 20px; color: var(--dim); }
.sc-no-results svg { width: 38px; height: 38px; margin-bottom: 12px; opacity: .3; }
.sc-no-results h3 { font-size: .92rem; color: var(--muted); margin-bottom: 4px; }
.sc-no-results p { font-size: .8rem; }
</style>

{{-- ── Breadcrumb ── --}}
<div class="sc-breadcrumb">
    <div class="container">
        <div class="sc-bc-inner">
            <a href="{{ route('front.home') }}">Home</a>
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 6l6 6-6 6" />
            </svg>
            <a href="{{ route('front.our.services') }}">Services</a>
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 6l6 6-6 6" />
            </svg>
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
                    <button type="button" class="sc-btn-primary" onclick="openServiceRequestModal()">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                        </svg>
                        Request a Service
                    </button>
                    @endif
                    <a href="{{ route('front.contact') }}" class="sc-btn-outline">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
                        </svg>
                        Contact Us
                    </a>
                </div>
            </div>

            {{-- Image mosaic --}}
            <!-- <div class="sc-hero-imgs">
                <div class="sc-img">
                    <img src="{{ asset('front/assets/img/all-images/about/about-img3.png') }}" alt="{{ $category->name }}">
                </div>
                <div class="sc-img">
                    <img src="{{ asset('front/assets/img/all-images/about/about-img4.png') }}" alt="{{ $category->name }}">
                </div>
                <div class="sc-img">
                    <img src="{{ asset('front/assets/img/all-images/about/about-img5.png') }}" alt="{{ $category->name }}">
                </div>
            </div> -->

        </div>
    </div>
</section>

{{-- ── Services under this category ── --}}
@if($category->services->count() > 0)
<section class="sc-services" id="sc-services">
    <div class="container">

        <!-- <div class="sc-section-head">
            <div class="sc-section-eyebrow">What's Included</div>
            <h2 class="sc-section-title">Our <em>{{ $category->name }}</em> services</h2>
            <p class="sc-section-sub">Browse all services available under this category, or search and request one directly.</p>
        </div> -->

        <div class="sc-list-search-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
            <input type="text" id="scListSearchInput" placeholder="Search {{ $category->name }} services..." oninput="filterServiceCards()" autocomplete="off">
        </div>

        <div class="row g-4" id="scCardsGrid">
            @foreach($category->services as $i => $service)
            <div class="col-xl-4 col-lg-4 col-md-6 col-12 sc-card-col" data-search="{{ strtolower($service->title . ' ' . $service->description) }}">
                <div class="sc-card" style="animation-delay:{{ $i * 0.06 }}s" onclick="openServiceRequestModal({{ $service->id }})">

                    <!-- <div class="sc-card-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>

                    <div class="sc-card-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                        </svg>
                    </div> -->

                    <div class="sc-card-title">{{ $service->title }}</div>
                    <p class="sc-card-desc">
                        {{ Str::limit($service->description, 130) }}
                    </p>

                    <div class="sc-card-meta">
                        <span class="sc-card-badge">
                            @if ($service->is_active)
                            Available
                            @else
                            Unavailable
                            @endif
                        </span>
                        <button type="button" class="sc-card-cta" onclick="event.stopPropagation(); openServiceRequestModal({{ $service->id }})">
                            Request service
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="sc-no-results" id="scNoResults" style="display:none;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
            <h3>No services found</h3>
            <p>Try a different search term.</p>
        </div>

    </div>
</section>
@else
<section class="sc-services">
    <div class="container">
        <div class="sc-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
            </svg>
            <h3>No services listed yet</h3>
            <p>Services for this category will appear here soon.</p>
        </div>
    </div>
</section>
@endif


{{-- ══════════════════════════
     REQUEST SERVICE MODAL
══════════════════════════ --}}
<div class="srm-overlay" id="srmOverlay" onclick="if(event.target===this) closeServiceRequestModal()">
    <div class="srm-modal">

        <div class="srm-modal-header">
            <div class="srm-modal-title-wrap">
                <span class="srm-modal-eyebrow" id="srmEyebrow">Request a Service</span>
                <h3 class="srm-modal-title" id="srmTitle">Find a service</h3>
            </div>
            <button type="button" class="srm-close" onclick="closeServiceRequestModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="srm-body">

            {{-- ── Search / List view ── --}}
            <div id="srmSearchView" class="srm-view">
                <div class="srm-search-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7" />
                        <path d="M21 21l-4.3-4.3" />
                    </svg>
                    <input type="text" id="srmSearchInput" placeholder="Search services..." oninput="filterServices()" autocomplete="off">
                </div>
                <div class="srm-list" id="srmList"></div>
                <div class="srm-empty-list" id="srmEmptyList" style="display:none;">No services match your search.</div>
            </div>

            {{-- ── Form view ── --}}
            <div id="srmFormView" class="srm-view" style="display:none;">
                <button type="button" class="srm-back" onclick="showSearchView()">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10.828 12l4.95 4.95-1.414 1.414L8 12l6.364-6.364 1.414 1.414z" />
                    </svg>
                    Back to services
                </button>

                <div class="srm-selected-service">
                    <div class="srm-selected-service-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                        </svg>
                    </div>
                    <div>
                        <div class="srm-selected-service-label">Requesting</div>
                        <div class="srm-selected-service-title" id="srmSelectedTitle">—</div>
                    </div>
                </div>

                <div class="srm-alert" id="srmAlert" style="display:none;"></div>

                <form id="srmForm" novalidate>
                    @csrf
                    <input type="hidden" name="service_id" id="srmServiceId">

                    <div class="srm-grid">
                        <div class="srm-field">
                            <label for="srmFullName">Full name</label>
                            <input type="text" id="srmFullName" name="full_name" placeholder="e.g. Jean Bosco" required>
                        </div>
                        <div class="srm-field">
                            <label for="srmPhone">Phone number</label>
                            <input type="tel" id="srmPhone" name="phone" placeholder="078X XXX XXX" required>
                        </div>
                    </div>

                    <div class="srm-field">
                        <label for="srmEmail">Email <span class="opt">(optional)</span></label>
                        <input type="email" id="srmEmail" name="email" placeholder="you@example.com">
                    </div>

                    <div class="srm-field">
                        <label for="srmLocation">Location <span class="opt">(optional)</span></label>
                        <input type="text" id="srmLocation" name="location" placeholder="e.g. Kicukiro, Kigali">
                    </div>

                    <div class="srm-grid">
                        <div class="srm-field">
                            <label for="srmDate">Preferred date <span class="opt">(optional)</span></label>
                            <input type="date" id="srmDate" name="preferred_date">
                        </div>
                        <div class="srm-field">
                            <label for="srmTime">Preferred time <span class="opt">(optional)</span></label>
                            <input type="time" id="srmTime" name="preferred_time">
                        </div>
                    </div>

                    <div class="srm-field full">
                        <label for="srmMessage">Message <span class="opt">(optional)</span></label>
                        <textarea id="srmMessage" name="message" placeholder="Tell us a bit more about what you need..."></textarea>
                    </div>

                    <button type="submit" class="srm-submit" id="srmSubmitBtn">Submit Request</button>
                </form>
            </div>

            {{-- ── Success view ── --}}
            <div id="srmSuccessView" class="srm-view srm-success" style="display:none;">
                <div class="srm-success-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M20 6L9 17l-5-5" />
                    </svg>
                </div>
                <h4>Request sent</h4>
                <p>Thanks — our team will reach out to confirm the details shortly.</p>
                <button type="button" class="srm-submit" onclick="closeServiceRequestModal()">Close</button>
            </div>

        </div>
    </div>
</div>

<script>
    const SRM_SERVICES = @json($servicesForJs);
    let srmSelectedServiceId = null;

    function srmEscapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str ?? '';
        return div.innerHTML;
    }

    function renderServiceList(list) {
        const listEl = document.getElementById('srmList');
        const emptyEl = document.getElementById('srmEmptyList');

        if (!list.length) {
            listEl.innerHTML = '';
            emptyEl.style.display = 'block';
            return;
        }
        emptyEl.style.display = 'none';

        listEl.innerHTML = list.map(function(s) {
            return `
            <div class="srm-item" onclick="selectService(${s.id})">
                <div class="srm-item-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                </div>
                <div class="srm-item-text">
                    <div class="srm-item-title">${srmEscapeHtml(s.title)}</div>
                    <div class="srm-item-desc">${srmEscapeHtml(s.description)}</div>
                </div>
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z"/></svg>
            </div>
        `;
        }).join('');
    }

    function filterServices() {
        const q = document.getElementById('srmSearchInput').value.toLowerCase().trim();
        const filtered = q ?
            SRM_SERVICES.filter(s => s.title.toLowerCase().includes(q) || (s.description || '').toLowerCase().includes(q)) :
            SRM_SERVICES;
        renderServiceList(filtered);
    }

    function showSearchView() {
        document.getElementById('srmSearchView').style.display = 'block';
        document.getElementById('srmFormView').style.display = 'none';
        document.getElementById('srmSuccessView').style.display = 'none';
        document.getElementById('srmEyebrow').textContent = 'Request a Service';
        document.getElementById('srmTitle').textContent = 'Find a service';
        document.getElementById('srmSearchInput').value = '';
        renderServiceList(SRM_SERVICES);
        setTimeout(() => document.getElementById('srmSearchInput').focus(), 50);
    }

    function selectService(id) {
        const service = SRM_SERVICES.find(s => s.id === id);
        if (!service) return;

        srmSelectedServiceId = id;
        document.getElementById('srmServiceId').value = id;
        document.getElementById('srmSelectedTitle').textContent = service.title;

        document.getElementById('srmSearchView').style.display = 'none';
        document.getElementById('srmSuccessView').style.display = 'none';
        document.getElementById('srmFormView').style.display = 'block';

        document.getElementById('srmEyebrow').textContent = 'Requesting';
        document.getElementById('srmTitle').textContent = service.title;

        document.getElementById('srmAlert').style.display = 'none';
    }

    function openServiceRequestModal(serviceId = null) {
        document.getElementById('srmOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';

        if (serviceId) {
            selectService(serviceId);
        } else {
            showSearchView();
        }
    }

    function closeServiceRequestModal() {
        document.getElementById('srmOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeServiceRequestModal();
    });

    document.getElementById('srmForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const btn = document.getElementById('srmSubmitBtn');
        const alertEl = document.getElementById('srmAlert');

        alertEl.style.display = 'none';
        btn.disabled = true;
        btn.textContent = 'Submitting...';

        const formData = new FormData(form);
        const token = document.querySelector('meta[name="csrf-token"]')?.content ||
            document.querySelector('input[name="_token"]')?.value;

        fetch("{{ route('service-requests.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
            .then(async function(res) {
                const data = await res.json().catch(() => ({}));
                if (!res.ok) throw data;
                return data;
            })
            .then(function() {
                form.reset();
                document.getElementById('srmFormView').style.display = 'none';
                document.getElementById('srmSuccessView').style.display = 'block';
                document.getElementById('srmEyebrow').textContent = 'Success';
                document.getElementById('srmTitle').textContent = 'Request sent';
            })
            .catch(function(err) {
                alertEl.style.display = 'block';
                if (err && err.errors) {
                    alertEl.innerHTML = Object.values(err.errors).flat().join('<br>');
                } else if (err && err.message) {
                    alertEl.textContent = err.message;
                } else {
                    alertEl.textContent = 'Something went wrong. Please try again or contact us directly.';
                }
            })
            .finally(function() {
                btn.disabled = false;
                btn.textContent = 'Submit Request';
            });
    });

    function filterServiceCards() {
    const q = document.getElementById('scListSearchInput').value.toLowerCase().trim();
    const cols = document.querySelectorAll('.sc-card-col');
    let visibleCount = 0;

    cols.forEach(function (col) {
        const match = col.dataset.search.includes(q);
        col.style.display = match ? '' : 'none';
        if (match) visibleCount++;
    });

    document.getElementById('scNoResults').style.display = visibleCount === 0 ? 'block' : 'none';
    document.getElementById('scCardsGrid').style.display = visibleCount === 0 ? 'none' : '';
}
</script>

@endsection