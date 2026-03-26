@extends('layouts.app')
@section('title', 'Add New Agent')
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
        --blue: #3b82f6;
        --green: #22c55e;
    }

    .ac-page {
        padding: 1.75rem 0 3rem;
        max-width: 1060px;
        margin: 0 auto;
    }

    /* ── Breadcrumb ── */
    .ac-breadcrumb {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .78rem;
        color: var(--muted);
        margin-bottom: 1.5rem;
    }

    .ac-breadcrumb a {
        color: var(--muted);
        text-decoration: none;
        transition: color .15s;
    }

    .ac-breadcrumb a:hover {
        color: var(--accent);
    }

    /* ── Heading ── */
    .ac-heading {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .ac-heading-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        flex-shrink: 0;
        background: linear-gradient(135deg, #c9a96e22, #c9a96e44);
        border: 1px solid #c9a96e55;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
    }

    .ac-heading h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .ac-heading p {
        font-size: .82rem;
        color: var(--text-dim);
        margin: .15rem 0 0;
    }

    /* ── Layout ── */
    .ac-layout {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 1.25rem;
        align-items: start;
    }

    .ac-main {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .ac-side {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        position: sticky;
        top: 80px;
    }

    /* ── Card ── */
    .ac-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .ac-card-header {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        background: var(--surface);
    }

    .ac-card-header-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #c9a96e18;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        flex-shrink: 0;
    }

    .ac-card-header h6 {
        margin: 0;
        font-size: .88rem;
        font-weight: 600;
        color: var(--text);
    }

    .ac-card-body {
        padding: 1.5rem;
    }

    /* ── Form controls ── */
    .ac-label {
        display: block;
        font-size: .77rem;
        font-weight: 600;
        letter-spacing: .03em;
        color: var(--text-dim);
        text-transform: uppercase;
        margin-bottom: .45rem;
    }

    .ac-label .req {
        color: var(--danger);
        margin-left: .2rem;
    }

    .ac-input,
    .ac-select,
    .ac-textarea {
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

    .ac-input:focus,
    .ac-select:focus,
    .ac-textarea:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px #c9a96e18;
    }

    .ac-input.is-invalid {
        border-color: var(--danger);
    }

    .ac-textarea {
        resize: vertical;
        line-height: 1.65;
    }

    .ac-hint {
        font-size: .73rem;
        color: var(--muted);
        margin-top: .35rem;
    }

    .ac-error {
        font-size: .73rem;
        color: var(--danger);
        margin-top: .35rem;
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    /* ── Input with icon prefix ── */
    .ac-input-icon {
        position: relative;
    }

    .ac-input-icon svg {
        position: absolute;
        left: .9rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        pointer-events: none;
    }

    .ac-input-icon .ac-input {
        padding-left: 2.5rem;
    }

    /* ── Grid helpers ── */
    .ac-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .ac-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 1rem;
    }

    .ac-gap {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* ── Star rating picker ── */
    .ac-stars {
        display: flex;
        gap: .3rem;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }

    .ac-stars input {
        display: none;
    }

    .ac-stars label {
        cursor: pointer;
        font-size: 1.4rem;
        color: var(--border);
        transition: color .15s;
        user-select: none;
    }

    .ac-stars input:checked~label,
    .ac-stars label:hover,
    .ac-stars label:hover~label {
        color: var(--amber, #f59e0b);
    }

    /* ── Profile image upload ── */
    .ac-img-upload {
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

    .ac-img-upload:hover {
        border-color: var(--accent);
        background: #c9a96e06;
    }

    .ac-img-upload input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .ac-img-preview {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--accent);
        display: none;
    }

    .ac-img-placeholder {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent-lt));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }

    .ac-img-placeholder.has-name {
        font-size: 1.2rem;
    }

    .ac-img-label {
        font-size: .83rem;
        font-weight: 600;
        color: var(--text);
    }

    .ac-img-sub {
        font-size: .74rem;
        color: var(--muted);
    }

    /* ── Social input ── */
    .ac-social-row {
        display: flex;
        align-items: center;
        gap: .65rem;
        padding: .6rem .9rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
    }

    .ac-social-row:focus-within {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px #c9a96e18;
    }

    .ac-social-icon {
        flex-shrink: 0;
        width: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ac-social-row input {
        flex: 1;
        border: none;
        outline: none;
        font-family: inherit;
        font-size: .875rem;
        color: var(--text);
        background: transparent;
    }

    /* ── Toggle switch ── */
    .ac-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .75rem 0;
        border-bottom: 1px solid var(--border);
    }

    .ac-toggle-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .ac-toggle-label {
        font-size: .84rem;
        color: var(--text);
        font-weight: 500;
    }

    .ac-toggle-desc {
        font-size: .73rem;
        color: var(--muted);
        margin-top: .1rem;
    }

    .ac-switch {
        position: relative;
        width: 38px;
        height: 22px;
        flex-shrink: 0;
    }

    .ac-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .ac-switch-track {
        position: absolute;
        inset: 0;
        background: var(--border);
        border-radius: 100px;
        cursor: pointer;
        transition: background .2s;
    }

    .ac-switch-track::before {
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

    .ac-switch input:checked+.ac-switch-track {
        background: var(--accent);
    }

    .ac-switch input:checked+.ac-switch-track::before {
        transform: translateX(16px);
    }

    /* ── Live profile card (sidebar) ── */
    .ac-preview-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .ac-preview-banner {
        height: 56px;
        background: linear-gradient(135deg, #c9a96e28, #e4c99015);
        border-bottom: 1px solid var(--border);
    }

    .ac-preview-body {
        padding: 0 1.25rem 1.25rem;
    }

    .ac-preview-avatar-wrap {
        margin-top: -24px;
        margin-bottom: .65rem;
    }

    .ac-preview-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent-lt));
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .95rem;
        color: #fff;
        border: 3px solid #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
    }

    .ac-preview-name {
        font-size: .92rem;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 .15rem;
    }

    .ac-preview-email {
        font-size: .74rem;
        color: var(--muted);
        word-break: break-all;
        margin-bottom: .5rem;
    }

    .ac-preview-role {
        font-size: .73rem;
        color: var(--text-dim);
    }

    /* ── Alerts ── */
    .ac-alert {
        border-radius: 8px;
        padding: .85rem 1.1rem;
        font-size: .84rem;
        display: flex;
        gap: .6rem;
        align-items: flex-start;
        margin-bottom: 1.25rem;
    }

    .ac-alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    .ac-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .ac-alert ul {
        margin: .35rem 0 0 1rem;
        padding: 0;
    }

    .ac-alert li {
        margin-bottom: .2rem;
    }

    /* ── Submit bar ── */
    .ac-submit-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: .6rem;
        padding: 1.1rem 1.5rem;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
    }

    .ac-btn {
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

    .ac-btn-primary {
        background: var(--accent);
        color: #fff;
    }

    .ac-btn-primary:hover {
        background: var(--accent-lt);
        color: #fff;
        transform: translateY(-1px);
    }

    .ac-btn-ghost {
        background: none;
        border: 1.5px solid var(--border);
        color: var(--text-dim);
    }

    .ac-btn-ghost:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    @media (max-width: 900px) {
        .ac-layout {
            grid-template-columns: 1fr;
        }

        .ac-side {
            position: static;
        }

        .ac-row-2,
        .ac-row-3 {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="ac-page">

    {{-- ── Breadcrumb ── --}}
    <nav class="ac-breadcrumb">
        <a href="{{ route('admin.agents.index') }}">Agents</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m9 18 6-6-6-6" />
        </svg>
        <span style="color:var(--text-dim)">Add New Agent</span>
    </nav>

    {{-- ── Heading ── --}}
    <div class="ac-heading">
        <div class="ac-heading-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="8" r="4" />
                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                <path d="M19 8v6m-3-3h6" />
            </svg>
        </div>
        <div>
            <h4>Add New Agent</h4>
            <p>Fill in the details below. A login account will be created and credentials emailed automatically.</p>
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if($errors->any())
    <div class="ac-alert ac-alert-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4m0 4h.01" />
        </svg>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class="ac-alert ac-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <path d="M20 6 9 17l-5-5" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <form method="POST"
        action="{{ route('admin.agents.store') }}"
        enctype="multipart/form-data">
        @csrf

        <div class="ac-layout">

            {{-- ══ MAIN ══ --}}
            <div class="ac-main">

                {{-- ── Account & Credentials ── --}}
                <div class="ac-card">
                    <div class="ac-card-header">
                        <div class="ac-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                            </svg>
                        </div>
                        <h6>Account &amp; Credentials</h6>
                    </div>
                    <div class="ac-card-body">

                        {{-- Info banner --}}
                        <div style="display:flex;align-items:flex-start;gap:.65rem;padding:.85rem 1rem;border-radius:8px;background:#eff6ff;border:1px solid #bfdbfe;font-size:.82rem;color:#1d4ed8;margin-bottom:1.25rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 8v4m0 4h.01" />
                            </svg>
                            <span>A <strong>login account</strong> will be automatically created for this agent. A secure hashed password will be generated and the credentials emailed to the address below.</span>
                        </div>

                        <div class="ac-row-2">
                            <div>
                                <label class="ac-label">Full Name <span class="req">*</span></label>
                                <input type="text" name="full_name" id="fullNameInput"
                                    class="ac-input @error('full_name') is-invalid @enderror"
                                    value="{{ old('full_name') }}"
                                    placeholder="e.g. Jean Paul Mutabazi"
                                    oninput="syncPreview()" required>
                                @error('full_name')<p class="ac-error">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <path d="M12 8v4m0 4h.01" />
                                    </svg>
                                    {{ $message }}
                                </p>@enderror
                            </div>
                            <div>
                                <label class="ac-label">Email Address <span class="req">*</span></label>
                                <input type="email" name="email" id="emailInput"
                                    class="ac-input @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="agent@company.com"
                                    oninput="syncPreview()" required>
                                <p class="ac-hint">Login credentials will be sent to this address.</p>
                                @error('email')<p class="ac-error">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div style="margin-top:1rem;">
                            <label class="ac-label">Phone <span class="req">*</span></label>
                            <div class="ac-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                                <input type="text" name="phone"
                                    class="ac-input @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}"
                                    placeholder="+250 7XX XXX XXX" required>
                            </div>
                            @error('phone')<p class="ac-error">{{ $message }}</p>@enderror
                        </div>

                    </div>
                </div>

                {{-- ── Professional Details ── --}}
                <div class="ac-card">
                    <div class="ac-card-header">
                        <div class="ac-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="20" height="14" x="2" y="7" rx="2" />
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                            </svg>
                        </div>
                        <h6>Professional Details</h6>
                    </div>
                    <div class="ac-card-body">
                        <div class="ac-gap">

                            <div class="ac-row-2">
                                <div>
                                    <label class="ac-label">Office Location</label>
                                    <div class="ac-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z" />
                                            <circle cx="12" cy="10" r="3" />
                                        </svg>
                                        <input type="text" name="office_location"
                                            class="ac-input @error('office_location') is-invalid @enderror"
                                            value="{{ old('office_location') }}"
                                            placeholder="e.g. Kigali CBD, KN 5 Rd">
                                    </div>
                                    @error('office_location')<p class="ac-error">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="ac-row-2">
                                <div>
                                    <label class="ac-label">Languages Spoken</label>
                                    <input type="text" name="languages"
                                        class="ac-input @error('languages') is-invalid @enderror"
                                        value="{{ old('languages') }}"
                                        placeholder="e.g. English, French, Kinyarwanda">
                                    <p class="ac-hint">Comma-separated list of languages.</p>
                                    @error('languages')<p class="ac-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="ac-label">WhatsApp Number</label>
                                    <div class="ac-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                                        </svg>
                                        <input type="text" name="whatsapp"
                                            class="ac-input @error('whatsapp') is-invalid @enderror"
                                            value="{{ old('whatsapp') }}"
                                            placeholder="+250 7XX XXX XXX">
                                    </div>
                                    @error('whatsapp')<p class="ac-error">{{ $message }}</p>@enderror
                                </div>
                            </div>


                            <div>
                                <label class="ac-label">Bio</label>
                                <textarea name="bio" rows="4"
                                    class="ac-textarea @error('bio') is-invalid @enderror"
                                    placeholder="A brief professional biography of the agent — experience, specialties, achievements…">{{ old('bio') }}</textarea>
                                @error('bio')<p class="ac-error">{{ $message }}</p>@enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── Social Media ── --}}
                <div class="ac-card">
                    <div class="ac-card-header">
                        <div class="ac-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="18" cy="5" r="3" />
                                <circle cx="6" cy="12" r="3" />
                                <circle cx="18" cy="19" r="3" />
                                <line x1="8.59" x2="15.42" y1="13.51" y2="17.49" />
                                <line x1="15.41" x2="8.59" y1="6.51" y2="10.49" />
                            </svg>
                        </div>
                        <h6>Social Media Links</h6>
                    </div>
                    <div class="ac-card-body">
                        <div class="ac-gap">

                            {{-- LinkedIn --}}
                            <div>
                                <label class="ac-label">LinkedIn</label>
                                <div class="ac-social-row">
                                    <div class="ac-social-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#0a66c2">
                                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                                            <rect width="4" height="12" x="2" y="9" />
                                            <circle cx="4" cy="4" r="2" />
                                        </svg>
                                    </div>
                                    <input type="url" name="linkedin"
                                        value="{{ old('linkedin') }}"
                                        placeholder="https://linkedin.com/in/agent-name">
                                </div>
                                @error('linkedin')<p class="ac-error">{{ $message }}</p>@enderror
                            </div>

                            {{-- Facebook --}}
                            <div>
                                <label class="ac-label">Facebook</label>
                                <div class="ac-social-row">
                                    <div class="ac-social-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#1877f2">
                                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                                        </svg>
                                    </div>
                                    <input type="url" name="facebook"
                                        value="{{ old('facebook') }}"
                                        placeholder="https://facebook.com/agent-name">
                                </div>
                                @error('facebook')<p class="ac-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="ac-row-2">
                                {{-- Instagram --}}
                                <div>
                                    <label class="ac-label">Instagram</label>
                                    <div class="ac-social-row">
                                        <div class="ac-social-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="url(#ig)" stroke-width="2">
                                                <defs>
                                                    <linearGradient id="ig" x1="0%" y1="100%" x2="100%" y2="0%">
                                                        <stop offset="0%" style="stop-color:#f09433" />
                                                        <stop offset="25%" style="stop-color:#e6683c" />
                                                        <stop offset="50%" style="stop-color:#dc2743" />
                                                        <stop offset="75%" style="stop-color:#cc2366" />
                                                        <stop offset="100%" style="stop-color:#bc1888" />
                                                    </linearGradient>
                                                </defs>
                                                <rect width="20" height="20" x="2" y="2" rx="5" />
                                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                                            </svg>
                                        </div>
                                        <input type="url" name="instagram"
                                            value="{{ old('instagram') }}"
                                            placeholder="https://instagram.com/agent">
                                    </div>
                                    @error('instagram')<p class="ac-error">{{ $message }}</p>@enderror
                                </div>

                                {{-- Twitter --}}
                                <div>
                                    <label class="ac-label">Twitter / X</label>
                                    <div class="ac-social-row">
                                        <div class="ac-social-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#000">
                                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                            </svg>
                                        </div>
                                        <input type="url" name="twitter"
                                            value="{{ old('twitter') }}"
                                            placeholder="https://x.com/agent">
                                    </div>
                                    @error('twitter')<p class="ac-error">{{ $message }}</p>@enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── Submit bar ── --}}
                <div class="ac-submit-bar">
                    <a href="{{ route('admin.agents.index') }}" class="ac-btn ac-btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="ac-btn ac-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect width="20" height="16" x="2" y="4" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                        Create Agent &amp; Send Credentials
                    </button>
                </div>

            </div>{{-- /.ac-main --}}

            {{-- ══ SIDEBAR ══ --}}
            <div class="ac-side">

                {{-- ── Profile image ── --}}
                <div class="ac-card">
                    <div class="ac-card-header">
                        <div class="ac-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="18" height="18" x="3" y="3" rx="2" />
                                <circle cx="9" cy="9" r="2" />
                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                            </svg>
                        </div>
                        <h6>Profile Photo</h6>
                    </div>
                    <div class="ac-card-body">
                        <div class="ac-img-upload" id="imgUploadZone">
                            <input type="file" name="profile_image" id="profileImageInput"
                                accept="image/jpg,image/jpeg,image/png,image/webp">
                            <img id="imgPreview" class="ac-img-preview" src="" alt="Preview">
                            <div class="ac-img-placeholder" id="imgPlaceholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="8" r="4" />
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                                </svg>
                            </div>
                            <p class="ac-img-label">Upload photo</p>
                            <p class="ac-img-sub">JPG, PNG, WEBP — max 2MB</p>
                        </div>
                        @error('profile_image')<p class="ac-error" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Live preview ── --}}
                <div class="ac-preview-card">
                    <div class="ac-preview-banner"></div>
                    <div class="ac-preview-body">
                        <div class="ac-preview-avatar-wrap">
                            <div class="ac-preview-avatar" id="previewAvatar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="8" r="4" />
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                                </svg>
                            </div>
                        </div>
                        <p class="ac-preview-name" id="previewName" style="color:var(--muted);font-style:italic;font-weight:400;">Enter name…</p>
                        <p class="ac-preview-email" id="previewEmail">—</p>
                        <p class="ac-preview-role">Agent · Terra</p>
                    </div>
                </div>

                {{-- ── Password options ── --}}
                <div class="ac-card">
                    <div class="ac-card-header">
                        <div class="ac-card-header-icon" style="background:#eff6ff;color:var(--blue);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="18" height="11" x="3" y="11" rx="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </div>
                        <h6>Password &amp; Access</h6>
                    </div>
                    <div class="ac-card-body">
                        <div class="ac-toggle-row" style="padding-top:0;">
                            <div>
                                <div class="ac-toggle-label">Auto-generate password</div>
                                <div class="ac-toggle-desc">Secure random password via Hash::make()</div>
                            </div>
                            <label class="ac-switch">
                                <input type="checkbox" name="auto_password" id="autoPasswordToggle"
                                    value="1" checked onchange="togglePasswordField()">
                                <span class="ac-switch-track"></span>
                            </label>
                        </div>

                        <div id="customPasswordWrap" style="display:none;margin-top:.85rem;">
                            <label class="ac-label">Custom Password</label>
                            <input type="password" name="custom_password" id="customPasswordInput"
                                class="ac-input" placeholder="Min. 8 characters"
                                minlength="8" autocomplete="new-password">
                            <p class="ac-hint">Will be hashed with Hash::make() before storing.</p>
                        </div>

                        <div class="ac-toggle-row">
                            <div>
                                <div class="ac-toggle-label">Send credentials by email</div>
                                <div class="ac-toggle-desc">Email login + password to agent</div>
                            </div>
                            <label class="ac-switch">
                                <input type="checkbox" name="send_credentials" value="1" checked>
                                <span class="ac-switch-track"></span>
                            </label>
                        </div>

                        <div class="ac-toggle-row">
                            <div>
                                <div class="ac-toggle-label">Mark account as verified</div>
                                <div class="ac-toggle-desc">Skip email verification step</div>
                            </div>
                            <label class="ac-switch">
                                <input type="checkbox" name="is_verified" value="1" checked>
                                <span class="ac-switch-track"></span>
                            </label>
                        </div>

                        <div style="margin-top:.85rem;padding:.75rem;border-radius:8px;background:#f0fdf4;border:1px solid #bbf7d0;font-size:.78rem;color:#166534;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;margin-right:.3rem">
                                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                            Password will be hashed using <strong>Hash::make()</strong> before saving.
                        </div>
                    </div>
                </div>

            </div>{{-- /.ac-side --}}

        </div>{{-- /.ac-layout --}}
    </form>
</div>

<script>
    /* ── Live preview sync ── */
    function syncPreview() {
        const name = document.getElementById('fullNameInput').value.trim();
        const email = document.getElementById('emailInput').value.trim();

        const initials = name.split(/\s+/).map(w => w[0]?.toUpperCase() ?? '').slice(0, 2).join('');
        const avatar = document.getElementById('previewAvatar');
        const pName = document.getElementById('previewName');
        const pEmail = document.getElementById('previewEmail');

        if (initials) {
            avatar.textContent = initials;
            avatar.style.fontSize = '1rem';
            pName.textContent = name;
            pName.style.cssText = 'font-size:.92rem;font-weight:700;color:var(--text);margin:0 0 .15rem;';
        } else {
            avatar.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>';
            pName.textContent = 'Enter name…';
            pName.style.cssText = 'color:var(--muted);font-style:italic;font-weight:400;';
        }
        pEmail.textContent = email || '—';
    }

    /* ── Password toggle ── */
    function togglePasswordField() {
        const auto = document.getElementById('autoPasswordToggle').checked;
        const wrap = document.getElementById('customPasswordWrap');
        const input = document.getElementById('customPasswordInput');
        wrap.style.display = auto ? 'none' : 'block';
        input.required = !auto;
    }

    /* ── Profile image preview ── */
    document.getElementById('profileImageInput').addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('imgPreview');
            const placeholder = document.getElementById('imgPlaceholder');
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
            document.querySelector('#imgUploadZone .ac-img-label').textContent = file.name;
            document.querySelector('#imgUploadZone .ac-img-sub').textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
        };
        reader.readAsDataURL(file);
    });

    /* ── Star rating sync ── */
    document.querySelectorAll('.ac-stars input').forEach(radio => {
        radio.addEventListener('change', () => {
            document.getElementById('ratingInput').value = radio.value;
            document.getElementById('ratingLabel').textContent = radio.value + ' / 5';
        });
    });
</script>

@endsection