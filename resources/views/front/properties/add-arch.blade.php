@extends('layouts.guest')
@section('title', 'Add Architectural Design')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --surface: #FFFFFF;
        --border: rgba(0, 0, 0, .08);
        --border2: rgba(0, 0, 0, .15);
        --gold: #C8873A;
        --gold-bg: rgba(200, 135, 58, .07);
        --gold-bd: rgba(200, 135, 58, .22);
        --text: #19265d;
        --muted: #6B6560;
        --dim: #9E9890;
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

    /* ── Page shell ── */
    .ad-page {
        padding: 44px 0 80px;
    }

    .ad-page-header {
        margin-bottom: 32px;
    }

    .ad-eyebrow {
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

    .ad-eyebrow::before {
        content: '';
        width: 18px;
        height: 1px;
        background: var(--gold);
        opacity: .5;
    }

    .ad-page-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.6rem, 3vw, 2.4rem);
        font-weight: 500;
        letter-spacing: -.02em;
        color: var(--text);
    }

    .ad-page-header h1 em {
        font-style: italic;
        color: var(--gold);
    }

    .ad-page-header p {
        font-size: .83rem;
        color: var(--muted);
        margin-top: 6px;
    }

    /* ── Errors ── */
    .ad-errors {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: var(--r);
        padding: 14px 18px;
        margin-bottom: 24px;
    }

    .ad-errors ul {
        margin: 0;
        padding-left: 18px;
    }

    .ad-errors li {
        font-size: .8rem;
        color: #dc2626;
    }

    /* ── Two-column layout ── */
    .ad-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .ad-layout {
            grid-template-columns: 1fr;
        }
    }

    /* ── Panels ── */
    .ad-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        margin-bottom: 16px;
    }

    .ad-panel-head {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ad-panel-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .ad-panel-icon svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
    }

    .ad-panel-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: -.01em;
        color: var(--text);
    }

    .ad-panel-body {
        padding: 18px 20px 22px;
    }

    /* ── Fields ── */
    .ad-field {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 14px;
    }

    .ad-field:last-child {
        margin-bottom: 0;
    }

    .ad-field label {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--muted);
    }

    .ad-field label .req {
        color: #dc2626;
        margin-left: 2px;
    }

    .ad-field input,
    .ad-field textarea,
    .ad-field select {
        padding: 10px 13px;
        background: var(--bg);
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-size: .84rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        transition: border-color var(--t), box-shadow var(--t), background var(--t);
        width: 100%;
    }

    .ad-field input::placeholder,
    .ad-field textarea::placeholder {
        color: var(--dim);
    }

    .ad-field input:focus,
    .ad-field textarea:focus,
    .ad-field select:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(200, 135, 58, .1);
        background: var(--surface);
    }

    .ad-field textarea {
        resize: vertical;
        min-height: 110px;
    }

    .ad-field .hint {
        font-size: .71rem;
        color: var(--dim);
    }

    .ad-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media (max-width: 520px) {
        .ad-row {
            grid-template-columns: 1fr;
        }
    }

    /* ── File zones ── */
    .ad-file-zone {
        border: 2px dashed var(--border2);
        border-radius: var(--r);
        padding: 22px 16px;
        text-align: center;
        cursor: pointer;
        transition: border-color var(--t), background var(--t);
        background: var(--bg);
        position: relative;
    }

    .ad-file-zone:hover {
        border-color: var(--gold);
        background: var(--gold-bg);
    }

    .ad-file-zone input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .ad-file-zone svg {
        width: 24px;
        height: 24px;
        color: var(--dim);
        margin-bottom: 7px;
    }

    .ad-file-zone .fz-title {
        font-size: .8rem;
        color: var(--muted);
        font-weight: 500;
    }

    .ad-file-zone .fz-sub {
        font-size: .7rem;
        color: var(--dim);
        margin-top: 2px;
    }

    .ad-file-picked {
        display: none;
        align-items: center;
        justify-content: center;
        gap: 7px;
        font-size: .8rem;
        color: var(--green);
        font-weight: 500;
    }

    .ad-file-picked svg {
        width: 14px;
        height: 14px;
    }

    /* Preview */
    .ad-preview-img {
        width: 100%;
        aspect-ratio: 16/10;
        object-fit: cover;
        display: none;
        border-radius: 10px;
        border: 1px solid var(--border);
        margin-bottom: 10px;
    }

    .ad-preview-img.show {
        display: block;
    }

    /* ── Fee calculator ── */
    .ad-fee-box {
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        border-radius: 10px;
        padding: 14px 16px;
        display: none;
        margin-top: 14px;
    }

    .ad-fee-box.visible {
        display: block;
    }

    .ad-fee-row {
        display: flex;
        justify-content: space-between;
        font-size: .8rem;
        color: var(--muted);
        margin-bottom: 6px;
    }

    .ad-fee-row:last-child {
        margin-bottom: 0;
    }

    .ad-fee-row .val {
        font-weight: 600;
        color: var(--text);
    }

    .ad-fee-total {
        display: flex;
        justify-content: space-between;
        font-size: .88rem;
        font-weight: 700;
        color: var(--gold);
        border-top: 1px solid var(--gold-bd);
        padding-top: 8px;
        margin-top: 8px;
    }

    /* ── Pricing toggle ── */
    .ad-free-toggle {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ad-free-toggle input[type="checkbox"] {
        display: none;
    }

    .ad-free-btn,
    .ad-paid-btn {
        padding: 7px 16px;
        border-radius: 8px;
        border: 1.5px solid var(--border);
        background: var(--bg);
        font-size: .78rem;
        font-weight: 600;
        color: var(--muted);
        cursor: pointer;
        transition: all var(--t);
        font-family: 'DM Sans', sans-serif;
    }

    .ad-free-btn.on {
        background: var(--green-bg);
        border-color: var(--green-bd);
        color: var(--green);
    }

    .ad-paid-btn.on {
        background: var(--gold-bg);
        border-color: var(--gold-bd);
        color: var(--gold);
    }

    /* Price with currency prefix */
    .ad-price-wrap {
        position: relative;
    }

    .ad-price-wrap .currency {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: .75rem;
        font-weight: 600;
        color: var(--dim);
        pointer-events: none;
    }

    .ad-price-wrap input {
        padding-left: 50px;
    }

    /* ── Featured toggle ── */
    .ad-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        border-radius: 10px;
        background: var(--bg);
        border: 1.5px solid var(--border);
        cursor: pointer;
        transition: border-color var(--t), background var(--t);
    }

    .ad-toggle-row:hover,
    .ad-toggle-row.checked {
        border-color: var(--gold-bd);
        background: var(--gold-bg);
    }

    .ad-toggle-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ad-toggle-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: var(--surface);
        border: 1px solid var(--border);
        display: grid;
        place-items: center;
    }

    .ad-toggle-icon svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
    }

    .ad-toggle-label {
        font-size: .85rem;
        font-weight: 600;
        color: var(--text);
    }

    .ad-toggle-sub {
        font-size: .73rem;
        color: var(--muted);
        margin-top: 1px;
    }

    .ad-toggle-input {
        display: none;
    }

    .ad-toggle-switch {
        width: 40px;
        height: 22px;
        border-radius: 11px;
        background: var(--border2);
        position: relative;
        transition: background var(--t);
        flex-shrink: 0;
    }

    .ad-toggle-switch::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #fff;
        top: 3px;
        left: 3px;
        transition: left var(--t);
        box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
    }

    .ad-toggle-row.checked .ad-toggle-switch {
        background: var(--gold);
    }

    .ad-toggle-row.checked .ad-toggle-switch::after {
        left: 21px;
    }

    /* ── Notice ── */
    .ad-notice {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        padding: 12px 14px;
        border-radius: var(--r);
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        font-size: .78rem;
        color: var(--muted);
        line-height: 1.6;
    }

    .ad-notice svg {
        width: 14px;
        height: 14px;
        color: var(--gold);
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* ── Submit ── */
    .ad-submit-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 13px 20px;
        border-radius: 10px;
        background: var(--gold);
        border: none;
        color: #fff;
        font-size: .88rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background var(--t), transform var(--t);
        width: 100%;
    }

    .ad-submit-btn:hover {
        background: #a06828;
        transform: translateY(-1px);
    }

    .ad-submit-btn svg {
        width: 16px;
        height: 16px;
    }

    /* ── Discount badge ── */
    .ad-discount-hint {
        font-size: .71rem;
        color: var(--green);
        background: var(--green-bg);
        border: 1px solid var(--green-bd);
        border-radius: 6px;
        padding: 3px 8px;
        display: inline-block;
        margin-top: 4px;
    }
</style>

<div class="ad-page">
    <div class="container">

        {{-- Header --}}
        <div class="ad-page-header">
            <div class="ad-eyebrow">Design Marketplace</div>
            <h1>Add an <em>architectural design</em></h1>
            <p>Upload your design files, set pricing, and reach buyers across Rwanda.</p>
        </div>

        {{-- Errors --}}
        @if($errors->any())
        <div class="ad-errors">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('user.properties.arch.store') }}"
            method="POST" enctype="multipart/form-data" id="ad-form">
            @csrf

            <div class="ad-layout">

                {{-- ══════════════ LEFT COLUMN ══════════════ --}}
                <div>

                    {{-- Design Information --}}
                    <div class="ad-panel">
                        <div class="ad-panel-head">
                            <div class="ad-panel-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                                </svg>
                            </div>
                            <p class="ad-panel-title">Design Information</p>
                        </div>
                        <div class="ad-panel-body">
                            <div class="ad-row">
                                <div class="ad-field">
                                    <label>Design Title <span class="req">*</span></label>
                                    <input type="text" name="title"
                                        value="{{ old('title') }}"
                                        placeholder="e.g. Modern 3-Bedroom Bungalow Plan" required>
                                </div>

                                <div class="ad-field">
                                    <label>Category <span class="req">*</span></label>
                                    <select name="category_id" required>
                                        <option value="">Select category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="ad-field">
                                <label>Description</label>
                                <textarea name="description"
                                    placeholder="Describe the design — style, floor plan, number of rooms, suitability…">{{ old('description') }}</textarea>
                                <span class="hint">A clear description helps buyers understand the design before purchasing.</span>
                            </div>

                        </div>
                    </div>

                    {{-- Listing Package & Duration --}}
                    <div class="ad-panel">
                        <div class="ad-panel-head">
                            <div class="ad-panel-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z" />
                                </svg>
                            </div>
                            <p class="ad-panel-title">Listing Package</p>
                        </div>
                        <div class="ad-panel-body">

                            <div class="ad-row">
                                <div class="ad-field">
                                    <label>Package <span class="req">*</span></label>
                                    <select name="listing_package_id" onchange="recalcFee()" required>
                                        <option value="">Select a package</option>
                                        @foreach($packages as $pkg)
                                        <option value="{{ $pkg->id }}"
                                            data-price="{{ $pkg->price_per_day }}"
                                            data-agent-pct="{{ $pkg->agent_commission_pct }}"
                                            data-terra-pct="{{ $pkg->terra_share_pct }}"
                                            {{ old('listing_package_id') == $pkg->id ? 'selected' : '' }}>
                                            {{ ucfirst($pkg->package_tier) }} — RWF {{ number_format($pkg->price_per_day) }}/day
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('listing_package_id')
                                    <span class="hint" style="color:#dc2626">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="ad-field">
                                    <label>Duration (days) <span class="req">*</span></label>
                                    <input type="number" name="listing_days"
                                        value="{{ old('listing_days', 30) }}"
                                        min="1" oninput="recalcFee()" required>
                                    <span class="hint">31–59 days: 10% off · 60–89: 15% off · 90+: 20% off</span>
                                    @error('listing_days')
                                    <span class="hint" style="color:#dc2626">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Fee breakdown box --}}
                            <div class="ad-fee-box" id="fee-box">
                                <div class="ad-fee-row">
                                    <span>Price / day</span>
                                    <span class="val" id="fee-ppd">—</span>
                                </div>
                                <div class="ad-fee-row">
                                    <span>Duration</span>
                                    <span class="val" id="fee-days">—</span>
                                </div>
                                <div class="ad-fee-row" id="fee-disc-row" style="display:none">
                                    <span>Discount</span>
                                    <span class="val" id="fee-disc" style="color:var(--green)">—</span>
                                </div>
                                <div class="ad-fee-total">
                                    <span>Listing Fee</span>
                                    <span id="fee-total">—</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Design File --}}
                    <div class="ad-panel">
                        <div class="ad-panel-head">
                            <div class="ad-panel-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                                    <path d="M14 2v6h6" />
                                </svg>
                            </div>
                            <p class="ad-panel-title">Design File</p>
                        </div>
                        <div class="ad-panel-body">
                            <div class="ad-file-zone" id="design-zone">
                                <input type="file" name="design_file" required
                                    accept=".pdf,.zip,.dwg,.dxf,.rvt"
                                    onchange="handleDesignFile(this)">
                                <div id="df-placeholder">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12" />
                                    </svg>
                                    <p class="fz-title">Click to upload design file</p>
                                    <p class="fz-sub">PDF, ZIP, DWG, DXF or RVT — Max 50MB</p>
                                </div>
                                <div class="ad-file-picked" id="df-picked">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span id="df-name"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Preview Image --}}
                    <div class="ad-panel">
                        <div class="ad-panel-head">
                            <div class="ad-panel-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                                </svg>
                            </div>
                            <p class="ad-panel-title">Preview Image</p>
                        </div>
                        <div class="ad-panel-body">
                            <img id="preview-img" class="ad-preview-img" src="" alt="preview">
                            <div class="ad-file-zone" id="preview-zone">
                                <input type="file" name="preview_image"
                                    accept="image/*"
                                    onchange="previewImg(this)">
                                <div>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <path d="M21 15l-5-5L5 21" />
                                    </svg>
                                    <p class="fz-title">Upload a preview thumbnail</p>
                                    <p class="fz-sub">JPG or PNG — shown on the listing card</p>
                                </div>
                            </div>
                            <span class="hint" style="margin-top:8px;display:block">
                                This image is shown on the marketplace listing card.
                            </span>
                        </div>
                    </div>

                    {{-- Owner / Agent Details --}}
                    <div class="ad-panel">
                        <div class="ad-panel-head">
                            <div class="ad-panel-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </div>
                            <p class="ad-panel-title">Owner / Agent Details</p>
                        </div>
                        <div class="ad-panel-body">
                            <div class="ad-row">
                                <div class="ad-field">
                                    <label>Full Name <span class="req">*</span></label>
                                    <input type="text" name="name"
                                        value="{{ old('name') }}"
                                        placeholder="e.g. Amina Uwimana" required>
                                </div>
                                <div class="ad-field">
                                    <label>Email <span class="req">*</span></label>
                                    <input type="email" name="email"
                                        value="{{ old('email') }}"
                                        placeholder="you@email.com" required>
                                </div>
                            </div>
                            <div class="ad-notice" style="margin-top:4px">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-2h2v2zm0-4H11V8h2v4z" />
                                </svg>
                                <span>Your listing will be reviewed before it goes live. You'll be notified once approved.</span>
                            </div>
                        </div>
                    </div>

                </div>{{-- /LEFT COLUMN --}}

                {{-- ══════════════ RIGHT COLUMN ══════════════ --}}
                <div>

                    {{-- Pricing --}}
                    <div class="ad-panel">
                        <div class="ad-panel-head">
                            <div class="ad-panel-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.5 14.5h-1v-1.74c-1.43-.33-2.5-1.6-2.5-3.26h1.5c0 1 .75 1.85 1.67 1.97V11l-2-.5C8.95 10.2 8 9.2 8 8c0-1.68 1.07-2.93 2.5-3.26V3h1v1.74c1.43.33 2.5 1.6 2.5 3.26h-1.5c0-1-.75-1.84-1.67-1.97V8.5l2 .5c1.17.3 2.17 1.3 2.17 2.5 0 1.68-1.07 2.93-2.5 3.26V16.5z" />
                                </svg>
                            </div>
                            <p class="ad-panel-title">Pricing</p>
                        </div>
                        <div class="ad-panel-body">
                            <div class="ad-field">
                                <label>Listing Type</label>
                                <div class="ad-free-toggle">
                                    <input type="checkbox" name="is_free" id="is_free_check"
                                        {{ old('is_free') ? 'checked' : '' }}>
                                    <button type="button"
                                        class="ad-free-btn {{ old('is_free') ? 'on' : '' }}"
                                        id="free-btn" onclick="setPricing(true)">
                                        Free Download
                                    </button>
                                    <button type="button"
                                        class="ad-paid-btn {{ !old('is_free') ? 'on' : '' }}"
                                        id="paid-btn" onclick="setPricing(false)">
                                        Paid
                                    </button>
                                </div>
                            </div>

                            <div class="ad-field" id="price-field"
                                style="{{ old('is_free') ? 'display:none' : '' }}">
                                <label>Price (RWF)</label>
                                <div class="ad-price-wrap">
                                    <span class="currency">RWF</span>
                                    <input type="number" name="price" id="price-input"
                                        value="{{ old('price', 0) }}"
                                        min="0" step="1000"
                                        placeholder="e.g. 250000">
                                </div>
                                <span class="hint">Enter the selling price in Rwandan Francs.</span>
                            </div>
                        </div>
                    </div>

                    {{-- Featured toggle --}}
                    <div class="ad-panel">
                        <div class="ad-panel-body" style="padding:16px 18px">
                            <div class="ad-toggle-row {{ old('featured') ? 'checked' : '' }}"
                                id="featured-row" onclick="toggleFeatured()">
                                <div class="ad-toggle-left">
                                    <div class="ad-toggle-icon">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="ad-toggle-label">Featured Listing</div>
                                        <div class="ad-toggle-sub">Show in featured section on homepage</div>
                                    </div>
                                </div>
                                <input type="checkbox" name="featured" id="featured-check"
                                    class="ad-toggle-input"
                                    {{ old('featured') ? 'checked' : '' }}>
                                <div class="ad-toggle-switch"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="ad-panel">
                        <div class="ad-panel-body" style="display:flex;flex-direction:column;gap:12px">
                            <div class="ad-notice">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>After submitting, you'll be redirected to complete the listing fee payment before your design goes live.</span>
                            </div>
                            <button type="submit" class="ad-submit-btn">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z" />
                                </svg>
                                Save & Continue to Payment
                            </button>
                            <a href="{{ url()->previous() }}"
                                style="text-align:center;font-size:.78rem;color:var(--muted);text-decoration:none">
                                ← Cancel
                            </a>
                        </div>
                    </div>

                </div>{{-- /RIGHT COLUMN --}}

            </div>{{-- /ad-layout --}}
        </form>

    </div>
</div>

<script>
    /* ── Pricing toggle ── */
    window.setPricing = function(isFree) {
        document.getElementById('is_free_check').checked = isFree;
        document.getElementById('free-btn').classList.toggle('on', isFree);
        document.getElementById('paid-btn').classList.toggle('on', !isFree);
        document.getElementById('price-field').style.display = isFree ? 'none' : '';
        if (isFree) document.getElementById('price-input').value = 0;
    };

    /* ── Featured toggle ── */
    window.toggleFeatured = function() {
        const row = document.getElementById('featured-row');
        const check = document.getElementById('featured-check');
        check.checked = !check.checked;
        row.classList.toggle('checked', check.checked);
    };

    /* ── Design file label ── */
    window.handleDesignFile = function(input) {
        if (!input.files || !input.files[0]) return;
        document.getElementById('df-placeholder').style.display = 'none';
        document.getElementById('df-name').textContent = input.files[0].name;
        document.getElementById('df-picked').style.display = 'flex';
    };

    /* ── Preview image ── */
    window.previewImg = function(input) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('preview-img');
            img.src = e.target.result;
            img.classList.add('show');
            document.getElementById('preview-zone').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    };

    /* ── Fee calculator ── */
    window.recalcFee = function() {
        const pkgSel = document.querySelector('[name="listing_package_id"]');
        const days = parseInt(document.querySelector('[name="listing_days"]')?.value) || 0;
        const opt = pkgSel?.options[pkgSel.selectedIndex];

        if (!opt || !opt.dataset.price || days < 1) {
            document.getElementById('fee-box').classList.remove('visible');
            return;
        }

        const ppd = parseInt(opt.dataset.price);
        const base = ppd * days;

        // Discount tiers
        let discPct = 0;
        if (days >= 90) discPct = 20;
        else if (days >= 60) discPct = 15;
        else if (days >= 31) discPct = 10;

        const discAmt = Math.round(base * discPct / 100);
        const total = base - discAmt;

        document.getElementById('fee-ppd').textContent = 'RWF ' + ppd.toLocaleString();
        document.getElementById('fee-days').textContent = days + ' days';
        document.getElementById('fee-total').textContent = 'RWF ' + total.toLocaleString();

        const discRow = document.getElementById('fee-disc-row');
        if (discPct > 0) {
            discRow.style.display = 'flex';
            document.getElementById('fee-disc').textContent = '−' + discPct + '% (−RWF ' + discAmt.toLocaleString() + ')';
        } else {
            discRow.style.display = 'none';
        }

        document.getElementById('fee-box').classList.add('visible');
    };

    // Run on page load if old() values are set
    document.addEventListener('DOMContentLoaded', recalcFee);
</script>

@endsection