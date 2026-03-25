{{-- ================================================================
     SAVE AS: resources/views/admin/consultants/edit.blade.php
     ================================================================ --}}
@extends('layouts.app')
@section('title', 'Edit Consultant — ' . $consultant->name)
@section('content')

<style>
    :root {
        --accent: #c9a96e;
        --accent-lt: #e4c990;
        --danger: #dc3545;
        --border: #e2e8f0;
        --surface: #f8fafc;
        --muted: #94a3b8;
        --text: #1e293b;
        --text-dim: #64748b;
        --radius: 10px;
        --teal: #0d9488;
        --blue: #3b82f6;
    }

    .cc-page {
        padding: 1.75rem 0 3rem;
        max-width: 1060px;
        margin: 0 auto;
    }

    .cc-breadcrumb {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .78rem;
        color: var(--muted);
        margin-bottom: 1.5rem;
    }

    .cc-breadcrumb a {
        color: var(--muted);
        text-decoration: none;
        transition: color .15s;
    }

    .cc-breadcrumb a:hover {
        color: var(--teal);
    }

    .cc-heading {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .cc-heading-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        flex-shrink: 0;
        background: linear-gradient(135deg, #0d948820, #14b8a630);
        border: 1px solid #0d948840;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--teal);
    }

    .cc-heading h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .cc-heading p {
        font-size: .82rem;
        color: var(--text-dim);
        margin: .15rem 0 0;
    }

    .cc-layout {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 1.25rem;
        align-items: start;
    }

    .cc-main {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .cc-side {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        position: sticky;
        top: 80px;
    }

    .cc-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .cc-card-header {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        background: var(--surface);
    }

    .cc-card-header-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #0d948818;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--teal);
        flex-shrink: 0;
    }

    .cc-card-header h6 {
        margin: 0;
        font-size: .88rem;
        font-weight: 600;
        color: var(--text);
    }

    .cc-card-body {
        padding: 1.5rem;
    }

    .cc-label {
        display: block;
        font-size: .77rem;
        font-weight: 600;
        letter-spacing: .03em;
        color: var(--text-dim);
        text-transform: uppercase;
        margin-bottom: .45rem;
    }

    .cc-label .req {
        color: var(--danger);
        margin-left: .2rem;
    }

    .cc-input,
    .cc-select,
    .cc-textarea {
        width: 100%;
        padding: .65rem .9rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .875rem;
        color: var(--text);
        background: #fff;
        outline: none;
        font-family: inherit;
        transition: border-color .2s, box-shadow .2s;
    }

    .cc-input:focus,
    .cc-select:focus,
    .cc-textarea:focus {
        border-color: var(--teal);
        box-shadow: 0 0 0 3px rgba(13, 148, 136, .12);
    }

    .cc-input.is-invalid {
        border-color: var(--danger);
    }

    .cc-textarea {
        resize: vertical;
        line-height: 1.65;
    }

    .cc-hint {
        font-size: .73rem;
        color: var(--muted);
        margin-top: .35rem;
    }

    .cc-error {
        font-size: .73rem;
        color: var(--danger);
        margin-top: .35rem;
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    .cc-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .cc-gap {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .cc-pw-wrap {
        position: relative;
    }

    .cc-pw-toggle {
        position: absolute;
        right: .9rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--muted);
        padding: 0;
    }

    .cc-pw-toggle:hover {
        color: var(--teal);
    }

    .cc-cat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: .5rem;
    }

    .cc-cat-check {
        display: none;
    }

    .cc-cat-label {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .55rem .85rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .8rem;
        color: var(--text-dim);
        cursor: pointer;
        transition: all .15s;
        user-select: none;
        font-weight: 400;
    }

    .cc-cat-check:checked+.cc-cat-label {
        border-color: var(--teal);
        background: #f0fdfa;
        color: var(--teal);
        font-weight: 500;
    }

    .cc-cat-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        border: 2px solid currentColor;
        flex-shrink: 0;
    }

    .cc-cat-check:checked+.cc-cat-label .cc-cat-dot {
        background: var(--teal);
        border-color: var(--teal);
    }

    .cc-img-upload {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .75rem;
        padding: 1.5rem;
        border: 2px dashed var(--border);
        border-radius: 10px;
        background: var(--surface);
        cursor: pointer;
        transition: border-color .2s, background .2s;
        position: relative;
        text-align: center;
    }

    .cc-img-upload:hover {
        border-color: var(--teal);
        background: #f0fdfa05;
    }

    .cc-img-upload input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .cc-img-preview {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--teal);
    }

    .cc-img-placeholder {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--teal), #14b8a6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
    }

    .cc-preview-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .cc-preview-banner {
        height: 56px;
        background: linear-gradient(135deg, #0d948825, #14b8a615);
        border-bottom: 1px solid var(--border);
    }

    .cc-preview-body {
        padding: 0 1.25rem 1.25rem;
    }

    .cc-preview-avatar-wrap {
        margin-top: -24px;
        margin-bottom: .65rem;
    }

    .cc-preview-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--teal), #14b8a6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .95rem;
        color: #fff;
        border: 3px solid #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
    }

    .cc-preview-name {
        font-size: .92rem;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 .15rem;
    }

    .cc-preview-email {
        font-size: .74rem;
        color: var(--muted);
        word-break: break-all;
        margin-bottom: .35rem;
    }

    .cc-preview-role {
        font-size: .73rem;
        color: var(--text-dim);
    }

    .cc-switch {
        position: relative;
        width: 38px;
        height: 22px;
        flex-shrink: 0;
    }

    .cc-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .cc-switch-track {
        position: absolute;
        inset: 0;
        background: var(--border);
        border-radius: 100px;
        cursor: pointer;
        transition: background .2s;
    }

    .cc-switch-track::before {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #fff;
        top: 3px;
        left: 3px;
        transition: transform .2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
    }

    .cc-switch input:checked+.cc-switch-track {
        background: var(--teal);
    }

    .cc-switch input:checked+.cc-switch-track::before {
        transform: translateX(16px);
    }

    .cc-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .75rem 0;
        border-bottom: 1px solid var(--border);
    }

    .cc-toggle-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .cc-toggle-label {
        font-size: .84rem;
        color: var(--text);
        font-weight: 500;
    }

    .cc-toggle-desc {
        font-size: .73rem;
        color: var(--muted);
        margin-top: .1rem;
    }

    .cc-alert {
        border-radius: 8px;
        padding: .85rem 1.1rem;
        font-size: .84rem;
        display: flex;
        gap: .6rem;
        align-items: flex-start;
        margin-bottom: 1.25rem;
    }

    .cc-alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    .cc-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .cc-alert ul {
        margin: .35rem 0 0 1rem;
        padding: 0;
    }

    .cc-alert li {
        margin-bottom: .2rem;
    }

    .cc-submit-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: .6rem;
        padding: 1.1rem 1.5rem;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
    }

    .cc-btn {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .65rem 1.4rem;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
        font-family: inherit;
    }

    .cc-btn-primary {
        background: var(--teal);
        color: #fff;
    }

    .cc-btn-primary:hover {
        background: #0f766e;
        color: #fff;
        transform: translateY(-1px);
    }

    .cc-btn-ghost {
        background: none;
        border: 1.5px solid var(--border);
        color: var(--text-dim);
    }

    .cc-btn-ghost:hover {
        border-color: var(--teal);
        color: var(--teal);
    }

    .cc-current-photo {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .65rem;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        margin-bottom: .75rem;
        font-size: .78rem;
        color: var(--text-dim);
    }

    .cc-current-photo img {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--teal);
    }

    @media(max-width:900px) {
        .cc-layout {
            grid-template-columns: 1fr;
        }

        .cc-side {
            position: static;
        }

        .cc-row-2 {
            grid-template-columns: 1fr;
        }
    }
</style>

{{-- ── Pre-compute selected IDs for JS ── --}}
@php
$selectedCatIds = old('service_categories',
$consultant->serviceCategories->pluck('id')->toArray()
);
$selectedSvcIds = old('services',
$consultant->services->pluck('id')->toArray()
);
@endphp

<div class="cc-page">

    <nav class="cc-breadcrumb">
        <a href="{{ route('admin.consultants.index') }}">Consultants</a>
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m9 18 6-6-6-6" />
        </svg>
        <a href="{{ route('admin.consultants.show', $consultant) }}">{{ $consultant->name }}</a>
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m9 18 6-6-6-6" />
        </svg>
        <span style="color:var(--text-dim)">Edit</span>
    </nav>

    <div class="cc-heading">
        <div class="cc-heading-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
            </svg>
        </div>
        <div>
            <h4>Edit Consultant</h4>
            <p>Updating profile for <strong>{{ $consultant->name }}</strong></p>
        </div>
    </div>

    @if($errors->any())
    <div class="cc-alert cc-alert-danger">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4m0 4h.01" />
        </svg>
        <div><strong>Please fix the following errors:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    </div>
    @endif
    @if(session('success'))
    <div class="cc-alert cc-alert-success">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <path d="M20 6 9 17l-5-5" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <form method="POST"
        action="{{ route('admin.consultants.update', $consultant) }}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="cc-layout">
            <div class="cc-main">

                {{-- ── Account Details ── --}}
                <div class="cc-card">
                    <div class="cc-card-header">
                        <div class="cc-card-header-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                            </svg>
                        </div>
                        <h6>Account Details</h6>
                    </div>
                    <div class="cc-card-body">
                        <div class="cc-gap">
                            <div class="cc-row-2">
                                <div>
                                    <label class="cc-label">Full Name <span class="req">*</span></label>
                                    <input type="text" name="name" id="nameInput"
                                        class="cc-input @error('name') is-invalid @enderror"
                                        value="{{ old('name', $consultant->name) }}"
                                        oninput="syncPreview()"
                                        placeholder="e.g. Dr. James Habimana" required>
                                    @error('name')<p class="cc-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="cc-label">Email <span class="req">*</span></label>
                                    <input type="email" name="email" id="emailInput"
                                        class="cc-input @error('email') is-invalid @enderror"
                                        value="{{ old('email', $consultant->email) }}"
                                        oninput="syncPreview()"
                                        placeholder="james@firm.com" required>
                                    @error('email')<p class="cc-error">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            {{-- Password: optional on edit --}}
                            <div class="cc-row-2">
                                <div>
                                    <label class="cc-label">New Password
                                        <span style="font-weight:400;font-size:.72rem;text-transform:none;letter-spacing:0;color:var(--muted)">(leave blank to keep current)</span>
                                    </label>
                                    <div class="cc-pw-wrap">
                                        <input type="password" name="password" id="pwInput"
                                            class="cc-input @error('password') is-invalid @enderror"
                                            placeholder="Min. 8 characters" minlength="8">
                                        <button type="button" class="cc-pw-toggle" onclick="togglePw('pwInput')">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </button>
                                    </div>
                                    @error('password')<p class="cc-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="cc-label">Confirm New Password</label>
                                    <div class="cc-pw-wrap">
                                        <input type="password" name="password_confirmation"
                                            id="pwConfirmInput" class="cc-input"
                                            placeholder="Repeat new password">
                                        <button type="button" class="cc-pw-toggle" onclick="togglePw('pwConfirmInput')">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Profile Details ── --}}
                <div class="cc-card">
                    <div class="cc-card-header">
                        <div class="cc-card-header-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="20" height="14" x="2" y="7" rx="2" />
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                            </svg>
                        </div>
                        <h6>Profile Details</h6>
                    </div>
                    <div class="cc-card-body">
                        <div class="cc-gap">
                            <div class="cc-row-2">
                                <div>
                                    <label class="cc-label">Title / Role <span class="req">*</span></label>
                                    <input type="text" name="title"
                                        class="cc-input @error('title') is-invalid @enderror"
                                        value="{{ old('title', $consultant->title) }}"
                                        placeholder="e.g. Senior Property Consultant" required>
                                    @error('title')<p class="cc-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="cc-label">Phone <span class="req">*</span></label>
                                    <input type="text" name="phone"
                                        class="cc-input @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $consultant->phone) }}"
                                        placeholder="+250 7XX XXX XXX" required>
                                    @error('phone')<p class="cc-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div>
                                <label class="cc-label">Company / Firm</label>
                                <input type="text" name="company"
                                    class="cc-input @error('company') is-invalid @enderror"
                                    value="{{ old('company', $consultant->company) }}"
                                    placeholder="e.g. Terra Advisory Ltd">
                                @error('company')<p class="cc-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="cc-label">Bio</label>
                                <textarea name="bio" rows="4"
                                    class="cc-textarea @error('bio') is-invalid @enderror"
                                    placeholder="Professional background, specialties, approach…">{{ old('bio', $consultant->bio) }}</textarea>
                                @error('bio')<p class="cc-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Service Categories & Services ── --}}
                <div class="cc-card">
                    <div class="cc-card-header">
                        <div class="cc-card-header-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z" />
                                <path d="M7 7h.01" />
                            </svg>
                        </div>
                        <h6>Service Categories &amp; Services</h6>
                    </div>
                    <div class="cc-card-body">
                        @if($serviceCategories->count())

                        {{-- Step 1: categories --}}
                        <p class="cc-label" style="margin-bottom:.65rem">Step 1 — Select categories</p>
                        <div class="cc-cat-grid" id="catGrid">
                            @foreach($serviceCategories as $cat)
                            <input type="checkbox"
                                class="cc-cat-check cat-trigger"
                                name="service_categories[]"
                                id="cat{{ $cat->id }}"
                                value="{{ $cat->id }}"
                                data-cat-id="{{ $cat->id }}"
                                {{ in_array($cat->id, $selectedCatIds) ? 'checked' : '' }}>
                            <label for="cat{{ $cat->id }}" class="cc-cat-label">
                                <span class="cc-cat-dot"></span>
                                {{ $cat->name }}
                                <span class="cc-cat-count" id="count-{{ $cat->id }}"
                                    style="margin-left:auto;font-size:.68rem;background:var(--teal);
                                                     color:#fff;border-radius:20px;padding:1px 7px;display:none">
                                    0
                                </span>
                            </label>
                            @endforeach
                        </div>

                        {{-- Step 2: services panel --}}
                        <div id="servicesPanel" style="margin-top:1.25rem;display:none">
                            <p class="cc-label" style="margin-bottom:.65rem">
                                Step 2 — Pick services from selected categories
                            </p>

                            {{-- Search --}}
                            <div style="position:relative;margin-bottom:.85rem">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    style="position:absolute;left:.8rem;top:50%;transform:translateY(-50%);color:#94a3b8">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="m21 21-4.35-4.35" />
                                </svg>
                                <input type="text" id="serviceSearch" class="cc-input"
                                    placeholder="Filter services…"
                                    style="padding-left:2.2rem;font-size:.82rem">
                            </div>

                            <div id="serviceGroups">
                                @foreach($serviceCategories as $cat)
                                @if($cat->services->count())
                                <div class="service-group"
                                    id="group-{{ $cat->id }}"
                                    style="display:none;margin-bottom:1.1rem">

                                    <div style="display:flex;align-items:center;gap:.5rem;
                                                        margin-bottom:.55rem;padding-bottom:.45rem;
                                                        border-bottom:1px solid var(--border)">
                                        <span style="font-size:.7rem;font-weight:700;text-transform:uppercase;
                                                             letter-spacing:.06em;color:var(--teal)">
                                            {{ $cat->name }}
                                        </span>
                                        <button type="button"
                                            class="select-all-btn"
                                            data-group="{{ $cat->id }}"
                                            style="margin-left:auto;font-size:.72rem;font-weight:600;
                                                               color:var(--teal);background:none;border:none;cursor:pointer;padding:0">
                                            Select all
                                        </button>
                                    </div>

                                    <div class="cc-cat-grid">
                                        @foreach($cat->services as $svc)
                                        <input type="checkbox"
                                            class="cc-cat-check service-check"
                                            id="svc{{ $svc->id }}"
                                            name="services[]"
                                            value="{{ $svc->id }}"
                                            data-group="{{ $cat->id }}"
                                            data-name="{{ strtolower($svc->title) }}"
                                            {{ in_array($svc->id, $selectedSvcIds) ? 'checked' : '' }}>
                                        <label for="svc{{ $svc->id }}" class="cc-cat-label">
                                            <span class="cc-cat-dot"></span>{{ $svc->title }}
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>

                            {{-- Summary bar --}}
                            <div id="selectedSummary"
                                style="margin-top:.85rem;padding:.65rem .9rem;border-radius:8px;
                                            background:#f0fdfa;border:1px solid #99f6e4;
                                            font-size:.78rem;color:var(--teal);display:none">
                                <strong id="selectedCount">0</strong> service(s) selected
                                <button type="button" id="clearServices"
                                    style="margin-left:.75rem;font-size:.72rem;color:#ef4444;
                                                   background:none;border:none;cursor:pointer;font-weight:600">
                                    Clear all
                                </button>
                            </div>
                        </div>

                        <p class="cc-hint" style="margin-top:.75rem">
                            Select categories first, then choose individual services.
                        </p>

                        @else
                        <p class="cc-hint">No categories found.
                            <a href="{{ route('service-categories.index') }}" style="color:var(--teal)">
                                Add categories first.
                            </a>
                        </p>
                        @endif
                    </div>
                </div>

                {{-- ── Submit bar ── --}}
                <div class="cc-submit-bar">
                    <a href="{{ route('admin.consultants.index') }}" class="cc-btn cc-btn-ghost">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="cc-btn cc-btn-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Save Changes
                    </button>
                </div>

            </div>

            {{-- ── Sidebar ── --}}
            <div class="cc-side">

                {{-- Photo --}}
                <div class="cc-card">
                    <div class="cc-card-header">
                        <div class="cc-card-header-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="18" height="18" x="3" y="3" rx="2" />
                                <circle cx="9" cy="9" r="2" />
                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                            </svg>
                        </div>
                        <h6>Profile Photo</h6>
                    </div>
                    <div class="cc-card-body">
                        {{-- Current photo --}}
                        @if($consultant->photo)
                        <div class="cc-current-photo">
                            <img src="{{ asset($consultant->photo) }}" alt="{{ $consultant->name }}">
                            <div>
                                <div style="font-weight:600;color:var(--text)">Current photo</div>
                                <div>Upload below to replace it</div>
                            </div>
                        </div>
                        @endif

                        <div class="cc-img-upload">
                            <input type="file" name="photo" id="photoInput" accept="image/*">
                            <img id="imgPreview" class="cc-img-preview" src="" alt="Preview" style="display:none">
                            <div class="cc-img-placeholder" id="imgPlaceholder">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="8" r="4" />
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                                </svg>
                            </div>
                            <p style="font-size:.83rem;font-weight:600;color:var(--text);margin:0 0 .2rem">
                                {{ $consultant->photo ? 'Replace photo' : 'Upload photo' }}
                            </p>
                            <p style="font-size:.74rem;color:var(--muted);margin:0">JPG, PNG, WEBP — max 2MB</p>
                        </div>
                        @error('photo')<p class="cc-error" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Live preview --}}
                <div class="cc-preview-card">
                    <div class="cc-preview-banner"></div>
                    <div class="cc-preview-body">
                        <div class="cc-preview-avatar-wrap">
                            @if($consultant->photo)
                            <img id="previewAvatar"
                                src="{{ asset($consultant->photo) }}"
                                alt="{{ $consultant->name }}"
                                style="width:48px;height:48px;border-radius:50%;object-fit:cover;
                                        border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.1)">
                            @else
                            <div class="cc-preview-avatar" id="previewAvatar">
                                {{ strtoupper(substr($consultant->name, 0, 2)) }}
                            </div>
                            @endif
                        </div>
                        <p class="cc-preview-name" id="previewName">{{ $consultant->name }}</p>
                        <p class="cc-preview-email" id="previewEmail">{{ $consultant->email }}</p>
                        <p class="cc-preview-role">Consultant · Terra</p>
                    </div>
                </div>

                {{-- Info card --}}
                <div class="cc-card">
                    <div class="cc-card-header">
                        <div class="cc-card-header-icon" style="background:#eff6ff;color:var(--blue)">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 8v4m0 4h.01" />
                            </svg>
                        </div>
                        <h6>Account Info</h6>
                    </div>
                    <div class="cc-card-body" style="display:flex;flex-direction:column;gap:.65rem">
                        <div style="font-size:.78rem;color:var(--text-dim)">
                            <span style="font-weight:600;color:var(--text)">Registered:</span>
                            {{ $consultant->created_at->format('d M Y') }}
                        </div>
                        <div style="font-size:.78rem;color:var(--text-dim)">
                            <span style="font-weight:600;color:var(--text)">Last updated:</span>
                            {{ $consultant->updated_at->diffForHumans() }}
                        </div>
                        <div style="margin-top:.25rem;padding:.75rem;border-radius:8px;
                                    background:#fefce8;border:1px solid #fde68a;
                                    font-size:.78rem;color:#92400e;">
                            Leave password fields blank to keep the current password unchanged.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    // ── Live preview sync ────────────────────────────────────────────
    function syncPreview() {
        const name = document.getElementById('nameInput').value.trim();
        const email = document.getElementById('emailInput').value.trim();
        const initials = name.split(/\s+/).map(w => w[0]?.toUpperCase() ?? '').slice(0, 2).join('');
        const avatar = document.getElementById('previewAvatar');
        const pName = document.getElementById('previewName');

        // Only update avatar if it's a div (not an img with an existing photo)
        if (avatar.tagName === 'DIV') {
            if (initials) {
                avatar.textContent = initials;
                avatar.style.fontSize = '1rem';
            } else {
                avatar.textContent = '?';
            }
        }

        pName.textContent = name || '—';
        document.getElementById('previewEmail').textContent = email || '—';
    }

    // ── Password toggle ──────────────────────────────────────────────
    function togglePw(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // ── Photo preview ────────────────────────────────────────────────
    document.getElementById('photoInput').addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const prev = document.getElementById('imgPreview');
            const phld = document.getElementById('imgPlaceholder');
            const pavtr = document.getElementById('previewAvatar');

            prev.src = e.target.result;
            prev.style.display = 'block';
            phld.style.display = 'none';

            // Update sidebar preview with new photo
            if (pavtr.tagName === 'DIV') {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width:48px;height:48px;border-radius:50%;object-fit:cover;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.1)';
                img.id = 'previewAvatar';
                pavtr.replaceWith(img);
            } else {
                pavtr.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    });

    // ── Categories → Services ────────────────────────────────────────
    document.querySelectorAll('.cat-trigger').forEach(cb => {
        cb.addEventListener('change', handleCategoryChange);
    });

    function handleCategoryChange() {
        const catId = this.dataset.catId;
        const group = document.getElementById('group-' + catId);
        const panel = document.getElementById('servicesPanel');

        if (this.checked) {
            if (group) group.style.display = 'block';
        } else {
            if (group) {
                group.style.display = 'none';
                // Uncheck all services in this group
                group.querySelectorAll('.service-check').forEach(s => s.checked = false);
            }
        }

        const anyChecked = document.querySelectorAll('.cat-trigger:checked').length > 0;
        panel.style.display = anyChecked ? 'block' : 'none';

        updateCounts();
        updateSummary();
    }

    // Select all per group
    document.querySelectorAll('.select-all-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const groupId = this.dataset.group;
            const services = document.querySelectorAll(`.service-check[data-group="${groupId}"]`);
            const allChecked = [...services].every(s => s.checked);
            services.forEach(s => s.checked = !allChecked);
            this.textContent = allChecked ? 'Select all' : 'Deselect all';
            updateCounts();
            updateSummary();
        });
    });

    // Service check → update counts
    document.querySelectorAll('.service-check').forEach(cb => {
        cb.addEventListener('change', () => {
            updateCounts();
            updateSummary();
        });
    });

    function updateCounts() {
        document.querySelectorAll('.cat-trigger').forEach(cb => {
            const catId = cb.dataset.catId;
            const count = document.querySelectorAll(`.service-check[data-group="${catId}"]:checked`).length;
            const badge = document.getElementById('count-' + catId);
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'inline' : 'none';
            }
        });
    }

    function updateSummary() {
        const total = document.querySelectorAll('.service-check:checked').length;
        const summary = document.getElementById('selectedSummary');
        document.getElementById('selectedCount').textContent = total;
        summary.style.display = total > 0 ? 'block' : 'none';
    }

    // Search filter
    document.getElementById('serviceSearch')?.addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.service-check').forEach(cb => {
            const label = cb.nextElementSibling;
            const match = cb.dataset.name.includes(q);
            cb.style.display = label.style.display = match ? '' : 'none';
        });
    });

    // Clear all
    document.getElementById('clearServices')?.addEventListener('click', () => {
        document.querySelectorAll('.service-check').forEach(s => s.checked = false);
        updateCounts();
        updateSummary();
    });

    // ── Restore state on load (existing selections) ──────────────────
    document.querySelectorAll('.cat-trigger:checked').forEach(cb => {
        const group = document.getElementById('group-' + cb.dataset.catId);
        if (group) group.style.display = 'block';
    });
    const anyCheckedOnLoad = document.querySelectorAll('.cat-trigger:checked').length > 0;
    if (anyCheckedOnLoad) document.getElementById('servicesPanel').style.display = 'block';

    // Update "Select all" button text for groups that are fully selected
    document.querySelectorAll('.select-all-btn').forEach(btn => {
        const groupId = btn.dataset.group;
        const services = document.querySelectorAll(`.service-check[data-group="${groupId}"]`);
        if (services.length && [...services].every(s => s.checked)) {
            btn.textContent = 'Deselect all';
        }
    });

    updateCounts();
    updateSummary();
</script>
@endsection