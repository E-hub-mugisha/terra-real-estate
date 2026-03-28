@extends('layouts.guest')
@section('title', 'List your Land')
@section('content')

<!--===== DASHBOARD AREA STARTS =======-->
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
        --r: 12px;
        --t: .22s cubic-bezier(.4, 0, .2, 1);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    .ah-page {
        background: var(--bg);
        min-height: 100vh;
        padding: 40px 0 80px;
        font-family: 'DM Sans', sans-serif;
    }

    /* ── Page header ── */
    .ah-page-header {
        margin-bottom: 36px;
    }

    .ah-eyebrow {
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

    .ah-eyebrow::before {
        content: '';
        width: 18px;
        height: 1px;
        background: var(--gold);
        opacity: .5;
    }

    .ah-page-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.6rem, 3vw, 2.4rem);
        font-weight: 500;
        letter-spacing: -.02em;
        color: var(--text);
        margin: 0;
    }

    .ah-page-header h1 em {
        font-style: italic;
        color: var(--gold);
    }

    .ah-page-header p {
        font-size: .83rem;
        color: var(--muted);
        margin-top: 6px;
    }

    /* ── Errors ── */
    .ah-errors {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: var(--r);
        padding: 14px 18px;
        margin-bottom: 24px;
    }

    .ah-errors ul {
        margin: 0;
        padding-left: 18px;
    }

    .ah-errors li {
        font-size: .8rem;
        color: #dc2626;
    }

    /* ── Layout ── */
    .ah-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 28px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .ah-layout {
            grid-template-columns: 1fr;
        }
    }

    /* ── Sidebar ── */
    .ah-sidebar {
        position: sticky;
        top: 24px;
    }

    .ah-step-nav {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .ah-nav-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 12px 0;
        cursor: pointer;
        position: relative;
    }

    .ah-nav-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 14px;
        top: 40px;
        width: 1px;
        height: calc(100% - 16px);
        background: var(--border);
    }

    .ah-nav-item.active:not(:last-child)::after {
        background: rgba(200, 135, 58, .3);
    }

    .ah-nav-item.done:not(:last-child)::after {
        background: rgba(200, 135, 58, .5);
    }

    .ah-nav-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        font-size: .72rem;
        font-weight: 700;
        border: 1.5px solid var(--border2);
        color: var(--dim);
        transition: all var(--t);
        position: relative;
        z-index: 1;
        background: var(--surface);
    }

    .ah-nav-item.active .ah-nav-circle {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
        box-shadow: 0 0 0 4px rgba(200, 135, 58, .15);
    }

    .ah-nav-item.done .ah-nav-circle {
        background: var(--green);
        border-color: var(--green);
        color: #fff;
    }

    .ah-nav-circle svg {
        width: 12px;
        height: 12px;
    }

    .ah-nav-label {
        padding-top: 4px;
    }

    .ah-nav-title {
        font-size: .8rem;
        font-weight: 600;
        color: var(--dim);
        transition: color var(--t);
    }

    .ah-nav-item.active .ah-nav-title {
        color: var(--text);
    }

    .ah-nav-item.done .ah-nav-title {
        color: var(--muted);
    }

    .ah-nav-sub {
        font-size: .7rem;
        color: var(--dim);
        margin-top: 1px;
    }

    .ah-nav-item.active .ah-nav-sub {
        color: var(--gold);
    }

    /* Progress */
    .ah-progress-wrap {
        margin-bottom: 20px;
    }

    .ah-progress-label {
        display: flex;
        justify-content: space-between;
        font-size: .72rem;
        color: var(--dim);
        margin-bottom: 6px;
    }

    .ah-progress-label strong {
        color: var(--text);
    }

    .ah-progress-bar {
        height: 4px;
        background: var(--border);
        border-radius: 2px;
        overflow: hidden;
    }

    .ah-progress-fill {
        height: 100%;
        background: var(--gold);
        border-radius: 2px;
        transition: width .5s cubic-bezier(.4, 0, .2, 1);
    }

    /* ── Steps ── */
    .ah-form-area {
        min-width: 0;
    }

    .ah-step {
        display: none;
        animation: ahIn .35s cubic-bezier(.4, 0, .2, 1) both;
    }

    .ah-step.active {
        display: block;
    }

    @keyframes ahIn {
        from {
            opacity: 0;
            transform: translateX(22px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes ahBack {
        from {
            opacity: 0;
            transform: translateX(-22px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .ah-step.going-back {
        animation: ahBack .35s cubic-bezier(.4, 0, .2, 1) both;
    }

    /* ── Panels ── */
    .ah-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        margin-bottom: 16px;
        overflow: hidden;
    }

    .ah-panel-head {
        padding: 18px 22px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ah-panel-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .ah-panel-icon svg {
        width: 15px;
        height: 15px;
        color: var(--gold);
    }

    .ah-panel-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.05rem;
        font-weight: 600;
        letter-spacing: -.01em;
        color: var(--text);
        margin: 0;
    }

    .ah-panel-body {
        padding: 20px 22px 24px;
    }

    /* ── Step header ── */
    .ah-step-header {
        margin-bottom: 20px;
    }

    .ah-step-num {
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 4px;
    }

    .ah-step-header h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.4rem;
        font-weight: 600;
        letter-spacing: -.01em;
        color: var(--text);
        margin: 0;
    }

    .ah-step-header p {
        font-size: .82rem;
        color: var(--muted);
        margin-top: 3px;
    }

    /* ── Fields ── */
    .ah-field {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 14px;
    }

    .ah-field:last-child {
        margin-bottom: 0;
    }

    .ah-field label {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--muted);
    }

    .ah-field label .req {
        color: #dc2626;
        margin-left: 2px;
    }

    .ah-field input,
    .ah-field textarea,
    .ah-field select {
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

    .ah-field input::placeholder,
    .ah-field textarea::placeholder {
        color: var(--dim);
    }

    .ah-field input:focus,
    .ah-field textarea:focus,
    .ah-field select:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(200, 135, 58, .1);
        background: var(--surface);
    }

    .ah-field textarea {
        resize: vertical;
        min-height: 100px;
    }

    .ah-field .hint {
        font-size: .71rem;
        color: var(--dim);
    }

    /* File upload */
    .ah-file-zone {
        border: 2px dashed var(--border2);
        border-radius: var(--r);
        padding: 24px 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color var(--t), background var(--t);
        background: var(--bg);
        position: relative;
    }

    .ah-file-zone:hover {
        border-color: var(--gold);
        background: var(--gold-bg);
    }

    .ah-file-zone input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .ah-file-zone svg {
        width: 26px;
        height: 26px;
        color: var(--dim);
        margin-bottom: 8px;
    }

    .ah-file-zone .fz-title {
        font-size: .82rem;
        color: var(--muted);
        font-weight: 500;
    }

    .ah-file-zone .fz-sub {
        font-size: .72rem;
        color: var(--dim);
        margin-top: 3px;
    }

    .fz-picked {
        display: none;
        font-size: .82rem;
        color: var(--green);
        font-weight: 500;
        margin-top: 6px;
    }

    /* Image previews */
    .img-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
        gap: 8px;
        margin-top: 12px;
    }

    .img-preview-cell {
        aspect-ratio: 1;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid var(--border);
        background: var(--border);
    }

    .img-preview-cell img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .ah-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .ah-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 14px;
    }

    @media (max-width: 640px) {

        .ah-row,
        .ah-row-3 {
            grid-template-columns: 1fr;
        }
    }

    /* UPI badge style input */
    .ah-upi-wrap {
        position: relative;
    }

    .ah-upi-wrap input {
        padding-left: 40px;
        font-family: 'DM Mono', monospace;
        letter-spacing: .06em;
        font-size: .82rem;
    }

    .ah-upi-badge {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: .6rem;
        font-weight: 700;
        color: var(--gold);
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        padding: 1px 5px;
        border-radius: 4px;
        letter-spacing: .04em;
        pointer-events: none;
    }

    /* Notice */
    .ah-notice {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 13px 16px;
        border-radius: var(--r);
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        font-size: .8rem;
        color: var(--muted);
        margin-bottom: 16px;
        line-height: 1.6;
    }

    .ah-notice svg {
        width: 15px;
        height: 15px;
        color: var(--gold);
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* Zoning cards */
    .zoning-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(145px, 1fr));
        gap: 8px;
    }

    .zoning-check {
        position: relative;
    }

    .zoning-check input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .zoning-check label {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 12px 14px;
        border-radius: 9px;
        border: 1.5px solid var(--border);
        background: var(--bg);
        cursor: pointer;
        font-size: .8rem;
        font-weight: 500;
        color: var(--muted);
        transition: all var(--t);
    }

    .zoning-check label .z-code {
        font-family: 'DM Mono', monospace;
        font-size: .72rem;
        font-weight: 700;
        color: var(--gold);
        margin-bottom: 3px;
        letter-spacing: .04em;
    }

    .zoning-check label .z-desc {
        font-size: .72rem;
        color: var(--dim);
        margin-top: 2px;
    }

    .zoning-check input:checked+label {
        border-color: var(--gold-bd);
        background: var(--gold-bg);
        color: var(--text);
    }

    .zoning-check input:checked+label .z-desc {
        color: var(--muted);
    }

    .zoning-check label:hover {
        border-color: var(--gold-bd);
        background: var(--gold-bg);
    }

    /* Nav buttons */
    .ah-nav-btns {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 24px;
    }

    .ah-btn-back {
        padding: 11px 22px;
        border-radius: 9px;
        border: 1.5px solid var(--border2);
        background: var(--surface);
        font-size: .84rem;
        font-weight: 500;
        color: var(--muted);
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: all var(--t);
        display: none;
    }

    .ah-btn-back:hover {
        border-color: var(--gold);
        color: var(--gold);
    }

    .ah-btn-next {
        flex: 1;
        padding: 12px 22px;
        border-radius: 9px;
        background: var(--gold);
        border: none;
        color: #fff;
        font-size: .86rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background var(--t), transform var(--t);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }

    .ah-btn-next:hover {
        background: #a06828;
        transform: translateY(-1px);
    }

    .ah-btn-next svg {
        width: 15px;
        height: 15px;
    }
</style>

<div class="ah-page">
    <div class="container">

        {{-- Page header --}}
        <div class="ah-page-header">
            <div class="ah-eyebrow">Property Management</div>
            <h1>Add a new <em>land listing</em></h1>
            <p>Fill in the details below — your listing will be reviewed before going live.</p>
        </div>

        {{-- Errors --}}
        @if($errors->any())
        <div class="ah-errors">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="ah-layout">

            {{-- ══ SIDEBAR ══ --}}
            <aside class="ah-sidebar">
                <div class="ah-progress-wrap">
                    <div class="ah-progress-label">
                        <span>Progress</span>
                        <strong id="ah-prog-label">Step 1 of 4</strong>
                    </div>
                    <div class="ah-progress-bar">
                        <div class="ah-progress-fill" id="ah-prog-fill" style="width:25%"></div>
                    </div>
                </div>

                <nav class="ah-step-nav" id="ah-step-nav">
                    <div class="ah-nav-item active" data-step="0">
                        <div class="ah-nav-circle">1</div>
                        <div class="ah-nav-label">
                            <div class="ah-nav-title">Basic Details</div>
                            <div class="ah-nav-sub">Title &amp; description</div>
                        </div>
                    </div>
                    <div class="ah-nav-item" data-step="1">
                        <div class="ah-nav-circle">2</div>
                        <div class="ah-nav-label">
                            <div class="ah-nav-title">Land Specifications</div>
                            <div class="ah-nav-sub">Zoning, size &amp; UPI</div>
                        </div>
                    </div>
                    <div class="ah-nav-item" data-step="2">
                        <div class="ah-nav-circle">3</div>
                        <div class="ah-nav-label">
                            <div class="ah-nav-title">Pricing &amp; Photos</div>
                            <div class="ah-nav-sub">Price, service &amp; images</div>
                        </div>
                    </div>
                    <div class="ah-nav-item" data-step="3">
                        <div class="ah-nav-circle">4</div>
                        <div class="ah-nav-label">
                            <div class="ah-nav-title">Contact Info</div>
                            <div class="ah-nav-sub">Owner details</div>
                        </div>
                    </div>
                </nav>
            </aside>

            {{-- ══ FORM ══ --}}
            <div class="ah-form-area">
                <form method="POST" action="{{ route('user.properties.land.store') }}"
                    enctype="multipart/form-data" id="ah-form">
                    @csrf

                    {{-- ══ STEP 1: BASIC DETAILS ══ --}}
                    <div class="ah-step active" id="ah-step-0">
                        <div class="ah-step-header">
                            <div class="ah-step-num">Step 1 of 4</div>
                            <h2>Basic Details</h2>
                            <p>Give your land listing a clear title and description.</p>
                        </div>

                        <div class="ah-panel">
                            <div class="ah-panel-head">
                                <div class="ah-panel-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                                        <path d="M14 2v6h6" />
                                    </svg>
                                </div>
                                <p class="ah-panel-title">Land Information</p>
                            </div>
                            <div class="ah-panel-body">
                                <div class="ah-field">
                                    <label>Listing Title <span class="req">*</span></label>
                                    <input type="text" name="title" id="f_title"
                                        value="{{ old('title') }}"
                                        placeholder="e.g. Prime Residential Plot in Gasabo" required>
                                </div>
                                <div class="ah-field">
                                    <label>Description</label>
                                    <textarea name="description"
                                        placeholder="Describe the land — access roads, utilities available, nearby landmarks…">{{ old('description') }}</textarea>
                                    <span class="hint">A detailed description helps buyers make faster decisions.</span>
                                </div>
                                @include('includes.form')
                            </div>
                        </div>
                    </div>

                    {{-- ══ STEP 2: SPECIFICATIONS ══ --}}
                    <div class="ah-step" id="ah-step-1">
                        <div class="ah-step-header">
                            <div class="ah-step-num">Step 2 of 4</div>
                            <h2>Land Specifications</h2>
                            <p>Zoning classification, size, UPI and legal documents.</p>
                        </div>

                        {{-- Zoning --}}
                        <div class="ah-panel">
                            <div class="ah-panel-head">
                                <div class="ah-panel-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A4.49 4.49 0 008 20C19 20 22 3 22 3c-1 2-8 2-9 0-2-2-3-4-3-4z" />
                                    </svg>
                                </div>
                                <p class="ah-panel-title">Zoning Classification</p>
                            </div>
                            <div class="ah-panel-body">
                                <div class="zoning-grid">
                                    @php
                                    $zones = [
                                    'R1' => ['code'=>'R1','desc'=>'Low density residential'],
                                    'R2' => ['code'=>'R2','desc'=>'Medium density residential'],
                                    'R3' => ['code'=>'R3','desc'=>'High density residential'],
                                    'R4' => ['code'=>'R3','desc'=>'High density residential'],
                                    'Commercial' => ['code'=>'COM','desc'=>'Commercial use'],
                                    'Industrial' => ['code'=>'IND','desc'=>'Industrial use'],
                                    'Agricultural'=> ['code'=>'AGR','desc'=>'Agricultural use'],
                                    ];
                                    @endphp
                                    @foreach($zones as $val => $zone)
                                    <div class="zoning-check">
                                        <input type="radio" name="zoning" id="zone_{{ $val }}"
                                            value="{{ $val }}"
                                            {{ old('zoning', 'R1') === $val ? 'checked' : '' }}>
                                        <label for="zone_{{ $val }}">
                                            <span class="z-code">{{ $zone['code'] }}</span>
                                            {{ $val }}
                                            <span class="z-desc">{{ $zone['desc'] }}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="ah-panel">
                            <div class="ah-panel-head">
                                <div class="ah-panel-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z" />
                                    </svg>
                                </div>
                                <p class="ah-panel-title">Size, Status &amp; Land Use</p>
                            </div>
                            <div class="ah-panel-body">
                                <div class="ah-row-3">
                                    <div class="ah-field">
                                        <label>Size (sqm) <span class="req">*</span></label>
                                        <input type="number" name="size_sqm" id="f_size"
                                            value="{{ old('size_sqm') }}"
                                            placeholder="e.g. 600">
                                    </div>
                                    <div class="ah-field">
                                        <label>Land Use <span class="req">*</span></label>
                                        <input type="text" name="land_use" id="f_land_use"
                                            value="{{ old('land_use') }}"
                                            placeholder="e.g. Residential" required>
                                    </div>
                                    <div class="ah-field">
                                        <label>Condition <span class="req">*</span></label>
                                        <select name="condition" required>
                                            <option value="for_rent" {{ old('condition')=='for_rent'?'selected':'' }}>For Rent</option>
                                            <option value="for_sale" {{ old('condition')=='for_sale'?'selected':'' }}>For Sale</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ah-panel">
                            <div class="ah-panel-head">
                                <div class="ah-panel-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                                    </svg>
                                </div>
                                <p class="ah-panel-title">Legal &amp; Documents</p>
                            </div>
                            <div class="ah-panel-body">
                                <div class="ah-row">
                                    <div class="ah-field">
                                        <label>Land UPI <span class="req">*</span></label>
                                        <div class="ah-upi-wrap">
                                            <span class="ah-upi-badge">UPI</span>
                                            <input type="text" name="upi" id="f_upi"
                                                value="{{ old('upi') }}"
                                                placeholder="1/02/01/01/2345" required>
                                        </div>
                                        <span class="hint">Unique Parcel Identifier from Rwanda Land Authority</span>
                                    </div>
                                    <div class="ah-field">
                                        <label>Title Document <span class="req">*</span></label>
                                        <div class="ah-file-zone" style="padding:16px">
                                            <input type="file" name="title_doc" accept=".pdf,.doc,.docx,.jpg,.png"
                                                onchange="handleDocUpload(this)">
                                            <div id="doc-placeholder">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                                                    <path d="M14 2v6h6M12 11v6M9 14l3-3 3 3" />
                                                </svg>
                                                <p class="fz-title" style="font-size:.75rem">Upload title document</p>
                                                <p class="fz-sub">PDF, DOC or image</p>
                                            </div>
                                            <div class="fz-picked" id="doc-picked">
                                                <svg viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;color:var(--green);display:inline-block;margin-right:4px">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span id="doc-name"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ah-notice" style="margin-top:8px">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-4h2v4zm0-6H11V8h2v2z" />
                                    </svg>
                                    <span>The UPI and title document will be used to verify land ownership. Ensure details match your official Rwanda Land Authority records.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ══ STEP 3: PRICING & PHOTOS ══ --}}
                    <div class="ah-step" id="ah-step-2">
                        <div class="ah-step-header">
                            <div class="ah-step-num">Step 3 of 4</div>
                            <h2>Pricing &amp; Photos</h2>
                            <p>Set the price, link a service, and upload land photos.</p>
                        </div>

                        <div class="ah-panel">
                            <div class="ah-panel-head">
                                <div class="ah-panel-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.86 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z" />
                                    </svg>
                                </div>
                                <p class="ah-panel-title">Price &amp; Service</p>
                            </div>
                            <div class="ah-panel-body">
                                <div class="ah-row">
                                    <div class="ah-field">
                                        <label>Price (RWF) <span class="req">*</span></label>
                                        <input type="number" name="price" id="f_price"
                                            value="{{ old('price') }}"
                                            placeholder="e.g. 18000000">
                                    </div>
                                    <div class="ah-field">
                                        <label class="form-label fw-semibold">Listing Package <span class="text-danger">*</span></label>
                                        <select name="listing_package_id" class="form-select" onchange="recalcFee()" required>
                                            <option value="">Select a package</option>
                                            @foreach($packages as $pkg)
                                            <option value="{{ $pkg->id }}"
                                                data-price="{{ $pkg->price_per_day }}"
                                                data-agent-pct="{{ $pkg->agent_commission_pct }}"
                                                data-terra-pct="{{ $pkg->terra_share_pct }}"
                                                {{ old('listing_package_id') == $pkg->id ? 'selected' : '' }}>
                                                {{ ucfirst($pkg->package_tier) }}
                                                — RWF {{ number_format($pkg->price_per_day) }}/day
                                                (you earn {{ $pkg->agent_commission_pct }}%)
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('listing_package_id')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="ah-field">
                                        <label class="form-label fw-semibold">Listing Duration (days) <span class="text-danger">*</span></label>
                                        <input type="number" name="listing_days" class="form-control"
                                            value="{{ old('listing_days', 30) }}" min="1" oninput="recalcFee()" required>
                                        <div class="form-text">31-59 days: 10% off &nbsp;·&nbsp; 61-89 days: 15% off &nbsp;·&nbsp; 90+ days: 20% off</div>
                                        @error('listing_days')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ah-panel">
                            <div class="ah-panel-head">
                                <div class="ah-panel-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                                    </svg>
                                </div>
                                <p class="ah-panel-title">Land Photos</p>
                            </div>
                            <div class="ah-panel-body">
                                <div class="ah-file-zone" id="img-zone">
                                    <input type="file" name="images[]" id="img-input"
                                        accept="image/*" multiple
                                        onchange="previewImages(this)">
                                    <div id="img-placeholder">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12" />
                                        </svg>
                                        <p class="fz-title">Click or drag &amp; drop land photos</p>
                                        <p class="fz-sub">JPG, PNG or WEBP — up to 10 images, max 5MB each</p>
                                    </div>
                                    <div class="fz-picked" id="fz-count"></div>
                                </div>
                                <div class="img-preview-grid" id="img-preview-grid"></div>
                            </div>
                        </div>
                    </div>

                    {{-- ══ STEP 4: CONTACT INFO ══ --}}
                    <div class="ah-step" id="ah-step-3">
                        <div class="ah-step-header">
                            <div class="ah-step-num">Step 4 of 4</div>
                            <h2>Contact Information</h2>
                            <p>Provide owner details for this listing.</p>
                        </div>

                        <div class="ah-panel">
                            <div class="ah-panel-head">
                                <div class="ah-panel-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                </div>
                                <p class="ah-panel-title">Owner / Agent Details</p>
                            </div>
                            <div class="ah-panel-body">
                                <div class="ah-row">
                                    <div class="ah-field">
                                        <label>Full Name <span class="req">*</span></label>
                                        <input type="text" name="name" id="f_name"
                                            value="{{ old('name') }}"
                                            placeholder="e.g. Amina Uwimana" required>
                                    </div>
                                    <div class="ah-field">
                                        <label>Email <span class="req">*</span></label>
                                        <input type="email" name="email" id="f_email"
                                            value="{{ old('email') }}"
                                            placeholder="you@email.com" required>
                                    </div>
                                </div>

                                <div class="ah-notice" style="margin-top:4px">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Your listing will be reviewed before it goes live. You'll be notified once approved.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Navigation --}}
                    <div class="ah-nav-btns">
                        <button type="button" class="ah-btn-back" id="ah-btn-back" onclick="ahNav(-1)">
                            ← Back
                        </button>
                        <button type="button" class="ah-btn-next" id="ah-btn-next" onclick="ahNav(1)">
                            Continue
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 13H4V11H12V4L20 12L12 20V13Z" />
                            </svg>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        let cur = 0;
        const TOTAL = 4;

        const steps = document.querySelectorAll('.ah-step');
        const navItems = document.querySelectorAll('.ah-nav-item');
        const progFill = document.getElementById('ah-prog-fill');
        const progLabel = document.getElementById('ah-prog-label');
        const btnBack = document.getElementById('ah-btn-back');
        const btnNext = document.getElementById('ah-btn-next');

        const required = {
            0: ['f_title'],
            1: ['f_size', 'f_land_use', 'f_upi'],
            2: ['f_price'],
            3: ['f_name', 'f_email'],
        };

        showStep(0, false);

        function showStep(n, back) {
            steps.forEach(s => s.classList.remove('active', 'going-back'));
            navItems.forEach((ni, i) => {
                ni.classList.remove('active', 'done');
                if (i < n) ni.classList.add('done');
                if (i === n) ni.classList.add('active');
                const circle = ni.querySelector('.ah-nav-circle');
                if (i < n) {
                    circle.innerHTML = `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg>`;
                } else {
                    circle.textContent = i + 1;
                }
            });

            const target = steps[n];
            if (back) target.classList.add('going-back');
            target.classList.add('active');

            const pct = ((n + 1) / TOTAL * 100).toFixed(0);
            progFill.style.width = pct + '%';
            progLabel.textContent = 'Step ' + (n + 1) + ' of ' + TOTAL;
            btnBack.style.display = n === 0 ? 'none' : 'inline-block';

            if (n === TOTAL - 1) {
                btnNext.innerHTML = `<svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14l-4-4 1.41-1.41L11 13.17l6.59-6.59L19 8l-8 8z"/></svg> Submit Listing`;
                btnNext.onclick = () => {
                    if (validate(cur)) document.getElementById('ah-form').submit();
                };
            } else {
                btnNext.innerHTML = `Continue <svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px"><path d="M12 13H4V11H12V4L20 12L12 20V13Z"/></svg>`;
                btnNext.onclick = () => ahNav(1);
            }
            cur = n;
        }

        window.ahNav = function(dir) {
            if (dir === 1 && !validate(cur)) return;
            const next = cur + dir;
            if (next < 0 || next >= TOTAL) return;
            showStep(next, dir < 0);
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        };

        function validate(n) {
            const req = required[n] || [];
            let ok = true;
            req.forEach(id => {
                const el = document.getElementById(id);
                if (!el || !el.value.trim()) {
                    if (el) {
                        el.focus();
                        el.style.borderColor = '#dc2626';
                        el.style.boxShadow = '0 0 0 3px rgba(220,38,38,.12)';
                        setTimeout(() => {
                            el.style.borderColor = '';
                            el.style.boxShadow = '';
                        }, 2000);
                    }
                    ok = false;
                }
            });
            return ok;
        }

        navItems.forEach((ni, i) => {
            ni.addEventListener('click', () => {
                if (i < cur) showStep(i, true);
            });
        });

        /* Document upload */
        window.handleDocUpload = function(input) {
            if (!input.files || !input.files[0]) return;
            document.getElementById('doc-placeholder').style.display = 'none';
            document.getElementById('doc-name').textContent = input.files[0].name;
            document.getElementById('doc-picked').style.display = 'block';
        };

        /* Image previews */
        window.previewImages = function(input) {
            const grid = document.getElementById('img-preview-grid');
            const countEl = document.getElementById('fz-count');
            const placeholder = document.getElementById('img-placeholder');
            grid.innerHTML = '';
            if (!input.files || !input.files.length) return;
            countEl.textContent = input.files.length + ' photo' + (input.files.length > 1 ? 's' : '') + ' selected ✓';
            countEl.style.display = 'block';
            placeholder.style.display = 'none';
            Array.from(input.files).slice(0, 12).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const cell = document.createElement('div');
                    cell.className = 'img-preview-cell';
                    cell.innerHTML = `<img src="${e.target.result}" alt="">`;
                    grid.appendChild(cell);
                };
                reader.readAsDataURL(file);
            });
        };
    })();
</script>
<!--===== DASHBOARD AREA ENDS =======-->


@endsection