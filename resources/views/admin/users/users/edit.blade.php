@extends('layouts.app')
@section('title', 'Edit Agent — ' . $agent->full_name)
@section('content')

<style>
    :root {
        --accent:   #c9a96e;
        --accent-lt:#e4c990;
        --danger:   #dc3545;
        --border:   #e2e8f0;
        --surface:  #f8fafc;
        --muted:    #94a3b8;
        --text:     #1e293b;
        --text-dim: #64748b;
        --radius:   10px;
        --blue:     #3b82f6;
        --green:    #22c55e;
    }

    .ae-page { padding: 1.75rem 0 3rem; max-width: 1060px; margin: 0 auto; }

    /* ── Breadcrumb ── */
    .ae-breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: .78rem; color: var(--muted); margin-bottom: 1.5rem; }
    .ae-breadcrumb a { color: var(--muted); text-decoration: none; transition: color .15s; }
    .ae-breadcrumb a:hover { color: var(--accent); }

    /* ── Heading ── */
    .ae-heading { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; }
    .ae-heading-avatar {
        width: 48px; height: 48px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, var(--accent), var(--accent-lt));
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 1rem; color: #fff;
        border: 2px solid rgba(201,169,110,.3); overflow: hidden;
    }
    .ae-heading-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .ae-heading h4 { font-size: 1.2rem; font-weight: 700; color: var(--text); margin: 0; }
    .ae-heading p  { font-size: .82rem; color: var(--text-dim); margin: .15rem 0 0; }
    .ae-heading-meta { margin-left: auto; display: flex; align-items: center; gap: .6rem; }

    /* ── Layout ── */
    .ae-layout { display: grid; grid-template-columns: 1fr 280px; gap: 1.25rem; align-items: start; }
    .ae-main { display: flex; flex-direction: column; gap: 1.25rem; }
    .ae-side { display: flex; flex-direction: column; gap: 1.25rem; position: sticky; top: 80px; }

    /* ── Card ── */
    .ae-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .ae-card-header {
        display: flex; align-items: center; gap: .75rem;
        padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); background: var(--surface);
    }
    .ae-card-header-icon {
        width: 32px; height: 32px; border-radius: 8px; background: #c9a96e18;
        display: flex; align-items: center; justify-content: center; color: var(--accent); flex-shrink: 0;
    }
    .ae-card-header h6 { margin: 0; font-size: .88rem; font-weight: 600; color: var(--text); }
    .ae-card-body { padding: 1.5rem; }

    /* ── Form controls ── */
    .ae-label {
        display: block; font-size: .77rem; font-weight: 600; letter-spacing: .03em;
        color: var(--text-dim); text-transform: uppercase; margin-bottom: .45rem;
    }
    .ae-label .req { color: var(--danger); margin-left: .2rem; }
    .ae-input, .ae-select, .ae-textarea {
        width: 100%; padding: .65rem .9rem; border: 1.5px solid var(--border); border-radius: 8px;
        font-size: .875rem; color: var(--text); background: #fff; outline: none; font-family: inherit;
        transition: border-color .2s, box-shadow .2s;
    }
    .ae-input:focus, .ae-select:focus, .ae-textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px #c9a96e18; }
    .ae-input.is-invalid { border-color: var(--danger); }
    .ae-textarea { resize: vertical; line-height: 1.65; }
    .ae-hint  { font-size: .73rem; color: var(--muted); margin-top: .35rem; }
    .ae-error { font-size: .73rem; color: var(--danger); margin-top: .35rem; display: flex; align-items: center; gap: .3rem; }

    /* ── Input with icon ── */
    .ae-input-icon { position: relative; }
    .ae-input-icon svg { position: absolute; left: .9rem; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
    .ae-input-icon .ae-input { padding-left: 2.5rem; }

    /* ── Grid helpers ── */
    .ae-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .ae-gap   { display: flex; flex-direction: column; gap: 1rem; }

    /* ── Star rating ── */
    .ae-stars { display: flex; gap: .3rem; flex-direction: row-reverse; justify-content: flex-end; }
    .ae-stars input { display: none; }
    .ae-stars label { cursor: pointer; font-size: 1.4rem; color: var(--border); transition: color .15s; user-select: none; }
    .ae-stars input:checked ~ label,
    .ae-stars label:hover,
    .ae-stars label:hover ~ label { color: #f59e0b; }

    /* ── Profile image ── */
    .ae-current-photo {
        display: flex; align-items: center; gap: .85rem; padding: .85rem 1rem;
        border: 1px solid var(--border); border-radius: 8px; background: var(--surface); margin-bottom: .85rem;
    }
    .ae-current-photo img {
        width: 48px; height: 48px; border-radius: 50%; object-fit: cover;
        border: 2px solid var(--border); flex-shrink: 0;
    }
    .ae-current-photo-initials {
        width: 48px; height: 48px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, var(--accent), var(--accent-lt));
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .9rem; color: #fff;
    }
    .ae-current-photo-info strong { display: block; font-size: .83rem; color: var(--text); margin-bottom: .1rem; }
    .ae-current-photo-info span   { font-size: .73rem; color: var(--muted); }

    .ae-img-upload {
        border: 2px dashed var(--border); border-radius: 10px; padding: 1.25rem;
        background: var(--surface); cursor: pointer; transition: border-color .2s, background .2s;
        position: relative; text-align: center;
    }
    .ae-img-upload:hover { border-color: var(--accent); background: #c9a96e06; }
    .ae-img-upload input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .ae-img-upload-icon { width: 36px; height: 36px; border-radius: 8px; background: #c9a96e18; display: flex; align-items: center; justify-content: center; margin: 0 auto .5rem; color: var(--accent); }
    .ae-new-preview {
        display: none; border-radius: 8px; overflow: hidden; margin-top: .75rem; position: relative;
    }
    .ae-new-preview img { width: 100%; max-height: 140px; object-fit: cover; display: block; }
    .ae-new-preview-remove {
        position: absolute; top: 5px; right: 5px; width: 22px; height: 22px; border-radius: 50%;
        background: rgba(0,0,0,.6); border: none; color: #fff; display: flex; align-items: center;
        justify-content: center; cursor: pointer; font-size: 10px;
    }

    /* ── Social input ── */
    .ae-social-row {
        display: flex; align-items: center; gap: .65rem; padding: .6rem .9rem;
        border: 1.5px solid var(--border); border-radius: 8px; background: #fff;
        transition: border-color .2s, box-shadow .2s;
    }
    .ae-social-row:focus-within { border-color: var(--accent); box-shadow: 0 0 0 3px #c9a96e18; }
    .ae-social-icon { flex-shrink: 0; width: 18px; display: flex; align-items: center; justify-content: center; }
    .ae-social-row input { flex: 1; border: none; outline: none; font-family: inherit; font-size: .875rem; color: var(--text); background: transparent; }

    /* ── Toggle switch ── */
    .ae-toggle-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: .75rem 0; border-bottom: 1px solid var(--border);
    }
    .ae-toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
    .ae-toggle-label { font-size: .84rem; color: var(--text); font-weight: 500; }
    .ae-toggle-desc  { font-size: .73rem; color: var(--muted); margin-top: .1rem; }
    .ae-switch { position: relative; width: 38px; height: 22px; flex-shrink: 0; }
    .ae-switch input { opacity: 0; width: 0; height: 0; }
    .ae-switch-track {
        position: absolute; inset: 0; background: var(--border); border-radius: 100px;
        cursor: pointer; transition: background .2s;
    }
    .ae-switch-track::before {
        content: ''; position: absolute; width: 16px; height: 16px; border-radius: 50%;
        background: #fff; top: 3px; left: 3px; transition: transform .2s;
        box-shadow: 0 1px 3px rgba(0,0,0,.2);
    }
    .ae-switch input:checked + .ae-switch-track { background: var(--accent); }
    .ae-switch input:checked + .ae-switch-track::before { transform: translateX(16px); }

    /* ── Live preview card ── */
    .ae-preview-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .ae-preview-banner { height: 56px; background: linear-gradient(135deg,#c9a96e28,#e4c99015); border-bottom: 1px solid var(--border); }
    .ae-preview-body { padding: 0 1.25rem 1.25rem; }
    .ae-preview-avatar-wrap { margin-top: -24px; margin-bottom: .65rem; }
    .ae-preview-avatar {
        width: 48px; height: 48px; border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent-lt));
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .95rem; color: #fff;
        border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,.1);
        overflow: hidden;
    }
    .ae-preview-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .ae-preview-name  { font-size: .92rem; font-weight: 700; color: var(--text); margin: 0 0 .15rem; }
    .ae-preview-email { font-size: .74rem; color: var(--muted); word-break: break-all; margin-bottom: .35rem; }
    .ae-preview-role  { font-size: .73rem; color: var(--text-dim); }

    /* ── Alerts ── */
    .ae-alert { border-radius: 8px; padding: .85rem 1.1rem; font-size: .84rem; display: flex; gap: .6rem; align-items: flex-start; margin-bottom: 1.25rem; }
    .ae-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .ae-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .ae-alert ul { margin: .35rem 0 0 1rem; padding: 0; }
    .ae-alert li { margin-bottom: .2rem; }

    /* ── Submit bar ── */
    .ae-submit-bar {
        display: flex; align-items: center; justify-content: space-between; gap: .75rem;
        padding: 1.1rem 1.5rem; background: #fff;
        border: 1px solid var(--border); border-radius: var(--radius);
    }
    .ae-submit-bar-left { font-size: .78rem; color: var(--muted); display: flex; align-items: center; gap: .4rem; }
    .ae-submit-bar-right { display: flex; gap: .6rem; }

    /* ── Buttons ── */
    .ae-btn {
        display: inline-flex; align-items: center; gap: .45rem; padding: .65rem 1.4rem;
        border-radius: 8px; font-size: .85rem; font-weight: 600; border: none;
        cursor: pointer; transition: all .2s; text-decoration: none; font-family: inherit;
    }
    .ae-btn-primary       { background: var(--accent); color: #fff; }
    .ae-btn-primary:hover { background: var(--accent-lt); color: #fff; transform: translateY(-1px); }
    .ae-btn-ghost         { background: none; border: 1.5px solid var(--border); color: var(--text-dim); }
    .ae-btn-ghost:hover   { border-color: var(--accent); color: var(--accent); }
    .ae-btn-danger        { background: none; border: 1.5px solid #fecaca; color: var(--danger); }
    .ae-btn-danger:hover  { background: #fef2f2; }
    .ae-btn-sm { padding: .42rem .9rem; font-size: .78rem; }
    .ae-btn-blue { background: none; border: 1.5px solid #bfdbfe; color: var(--blue); }
    .ae-btn-blue:hover { background: #eff6ff; }

    @media (max-width: 900px) {
        .ae-layout { grid-template-columns: 1fr; }
        .ae-side { position: static; }
        .ae-row-2 { grid-template-columns: 1fr; }
    }
</style>

<div class="ae-page">

    {{-- ── Breadcrumb ── --}}
    <nav class="ae-breadcrumb">
        <a href="{{ route('admin.agents.index') }}">Agents</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <a href="{{ route('admin.agents.show', $agent->id) }}">{{ $agent->full_name }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">Edit</span>
    </nav>

    {{-- ── Heading ── --}}
    <div class="ae-heading">
        <div class="ae-heading-avatar" id="headingAvatar">
            @if($agent->profile_image)
                <img src="{{asset('image/agents/')}}/{{ $agent->profile_image }}" alt="{{ $agent->full_name }}">
            @else
                {{ strtoupper(substr($agent->full_name, 0, 2)) }}
            @endif
        </div>
        <div>
            <h4>Edit Agent</h4>
            <p>{{ $agent->full_name }} &mdash; last updated {{ $agent->updated_at->diffForHumans() }}</p>
        </div>
        <div class="ae-heading-meta">
            <a href="{{ route('admin.agents.show', $agent->id) }}" class="ae-btn ae-btn-ghost ae-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                View Profile
            </a>
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if($errors->any())
        <div class="ae-alert ae-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="ae-alert ae-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.agents.update', $agent->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="ae-layout">

            {{-- ══ MAIN ══ --}}
            <div class="ae-main">

                {{-- ── Account Details ── --}}
                <div class="ae-card">
                    <div class="ae-card-header">
                        <div class="ae-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        </div>
                        <h6>Account Details</h6>
                    </div>
                    <div class="ae-card-body">
                        <div class="ae-row-2">
                            <div>
                                <label class="ae-label">Full Name <span class="req">*</span></label>
                                <input type="text" name="full_name" id="fullNameInput"
                                       class="ae-input @error('full_name') is-invalid @enderror"
                                       value="{{ old('full_name', $agent->full_name) }}"
                                       oninput="syncPreview()" required>
                                @error('full_name')<p class="ae-error">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                                    {{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="ae-label">Email Address <span class="req">*</span></label>
                                <input type="email" name="email" id="emailInput"
                                       class="ae-input @error('email') is-invalid @enderror"
                                       value="{{ old('email', $agent->email) }}"
                                       oninput="syncPreview()" required>
                                <p class="ae-hint">Changing this also updates the login email.</p>
                                @error('email')<p class="ae-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div style="margin-top:1rem;">
                            <label class="ae-label">Phone <span class="req">*</span></label>
                            <div class="ae-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <input type="text" name="phone"
                                       class="ae-input @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $agent->phone) }}"
                                       placeholder="+250 7XX XXX XXX" required>
                            </div>
                            @error('phone')<p class="ae-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- ── Professional Details ── --}}
                <div class="ae-card">
                    <div class="ae-card-header">
                        <div class="ae-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        </div>
                        <h6>Professional Details</h6>
                    </div>
                    <div class="ae-card-body">
                        <div class="ae-gap">

                            <div class="ae-row-2">
                                <div>
                                    <label class="ae-label">Years of Experience <span class="req">*</span></label>
                                    <input type="number" name="years_experience"
                                           class="ae-input @error('years_experience') is-invalid @enderror"
                                           value="{{ old('years_experience', $agent->years_experience) }}"
                                           min="0" max="50" required>
                                    @error('years_experience')<p class="ae-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="ae-label">Office Location</label>
                                    <div class="ae-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                        <input type="text" name="office_location"
                                               class="ae-input @error('office_location') is-invalid @enderror"
                                               value="{{ old('office_location', $agent->office_location) }}"
                                               placeholder="e.g. Kigali CBD">
                                    </div>
                                    @error('office_location')<p class="ae-error">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="ae-row-2">
                                <div>
                                    <label class="ae-label">Languages Spoken</label>
                                    <input type="text" name="languages"
                                           class="ae-input @error('languages') is-invalid @enderror"
                                           value="{{ old('languages', $agent->languages) }}"
                                           placeholder="e.g. English, French">
                                    @error('languages')<p class="ae-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="ae-label">WhatsApp</label>
                                    <div class="ae-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                        <input type="text" name="whatsapp"
                                               class="ae-input @error('whatsapp') is-invalid @enderror"
                                               value="{{ old('whatsapp', $agent->whatsapp) }}"
                                               placeholder="+250 7XX XXX XXX">
                                    </div>
                                    @error('whatsapp')<p class="ae-error">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            

                            {{-- Bio ── --}}
                            <div>
                                <label class="ae-label">Bio</label>
                                <textarea name="bio" rows="4"
                                          class="ae-textarea @error('bio') is-invalid @enderror"
                                          placeholder="A brief professional biography…">{{ old('bio', $agent->bio) }}</textarea>
                                @error('bio')<p class="ae-error">{{ $message }}</p>@enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── Social Media ── --}}
                <div class="ae-card">
                    <div class="ae-card-header">
                        <div class="ae-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg>
                        </div>
                        <h6>Social Media Links</h6>
                    </div>
                    <div class="ae-card-body">
                        <div class="ae-gap">

                            <div>
                                <label class="ae-label">LinkedIn</label>
                                <div class="ae-social-row">
                                    <div class="ae-social-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#0a66c2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
                                    </div>
                                    <input type="url" name="linkedin" value="{{ old('linkedin', $agent->linkedin) }}" placeholder="https://linkedin.com/in/…">
                                </div>
                                @error('linkedin')<p class="ae-error">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="ae-label">Facebook</label>
                                <div class="ae-social-row">
                                    <div class="ae-social-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#1877f2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                                    </div>
                                    <input type="url" name="facebook" value="{{ old('facebook', $agent->facebook) }}" placeholder="https://facebook.com/…">
                                </div>
                                @error('facebook')<p class="ae-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="ae-row-2">
                                <div>
                                    <label class="ae-label">Instagram</label>
                                    <div class="ae-social-row">
                                        <div class="ae-social-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="url(#ig2)" stroke-width="2"><defs><linearGradient id="ig2" x1="0%" y1="100%" x2="100%" y2="0%"><stop offset="0%" style="stop-color:#f09433"/><stop offset="50%" style="stop-color:#dc2743"/><stop offset="100%" style="stop-color:#bc1888"/></linearGradient></defs><rect width="20" height="20" x="2" y="2" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                                        </div>
                                        <input type="url" name="instagram" value="{{ old('instagram', $agent->instagram) }}" placeholder="https://instagram.com/…">
                                    </div>
                                    @error('instagram')<p class="ae-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="ae-label">Twitter / X</label>
                                    <div class="ae-social-row">
                                        <div class="ae-social-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#000"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                        </div>
                                        <input type="url" name="twitter" value="{{ old('twitter', $agent->twitter) }}" placeholder="https://x.com/…">
                                    </div>
                                    @error('twitter')<p class="ae-error">{{ $message }}</p>@enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── Submit bar ── --}}
                <div class="ae-submit-bar">
                    <div class="ae-submit-bar-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Last saved {{ $agent->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                    <div class="ae-submit-bar-right">
                        <a href="{{ route('admin.agents.show', $agent->id) }}" class="ae-btn ae-btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                            Cancel
                        </a>
                        <button type="submit" class="ae-btn ae-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>

            </div>{{-- /.ae-main --}}

            {{-- ══ SIDEBAR ══ --}}
            <div class="ae-side">

                {{-- ── Profile photo ── --}}
                <div class="ae-card">
                    <div class="ae-card-header">
                        <div class="ae-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                        </div>
                        <h6>Profile Photo</h6>
                    </div>
                    <div class="ae-card-body">

                        {{-- Current photo --}}
                        @if($agent->profile_image)
                            <div class="ae-current-photo">
                                <img src="{{asset('image/agents/')}}/{{ $agent->profile_image }}" alt="{{ $agent->full_name }}">
                                <div class="ae-current-photo-info">
                                    <strong>Current photo</strong>
                                    <span>Upload below to replace</span>
                                </div>
                            </div>
                        @else
                            <div class="ae-current-photo">
                                <div class="ae-current-photo-initials">{{ strtoupper(substr($agent->full_name, 0, 2)) }}</div>
                                <div class="ae-current-photo-info">
                                    <strong>No photo set</strong>
                                    <span>Upload one below</span>
                                </div>
                            </div>
                        @endif

                        <div class="ae-img-upload">
                            <input type="file" name="profile_image" id="profileImageInput"
                                   accept="image/jpg,image/jpeg,image/png,image/webp">
                            <div class="ae-img-upload-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            </div>
                            <p style="font-size:.83rem;font-weight:600;color:var(--text);margin:0 0 .2rem">
                                {{ $agent->profile_image ? 'Replace photo' : 'Upload photo' }}
                            </p>
                            <p style="font-size:.74rem;color:var(--muted);margin:0">JPG, PNG, WEBP — max 2MB</p>
                        </div>

                        <div class="ae-new-preview" id="newPreviewBox">
                            <img id="newPreviewImg" src="" alt="New preview">
                            <button type="button" class="ae-new-preview-remove" onclick="clearNewPhoto()">✕</button>
                        </div>

                        @error('profile_image')<p class="ae-error" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Live preview ── --}}
                <div class="ae-preview-card">
                    <div class="ae-preview-banner"></div>
                    <div class="ae-preview-body">
                        <div class="ae-preview-avatar-wrap">
                            <div class="ae-preview-avatar" id="previewAvatar">
                                @if($agent->profile_image)
                                    <img id="previewAvatarImg"
                                         src="{{ asset('storage/' . $agent->profile_image) }}"
                                         alt="{{ $agent->full_name }}">
                                @else
                                    <span id="previewAvatarInitials">{{ strtoupper(substr($agent->full_name, 0, 2)) }}</span>
                                @endif
                            </div>
                        </div>
                        <p class="ae-preview-name" id="previewName">{{ $agent->full_name }}</p>
                        <p class="ae-preview-email" id="previewEmail">{{ $agent->email }}</p>
                        <p class="ae-preview-role">Agent · Terra</p>
                    </div>
                </div>

                {{-- ── Reset password ── --}}
                <div class="ae-card">
                    <div class="ae-card-header">
                        <div class="ae-card-header-icon" style="background:#eff6ff;color:var(--blue);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <h6>Password</h6>
                    </div>
                    <div class="ae-card-body">
                        <p style="font-size:.81rem;color:var(--muted);margin-bottom:.85rem;line-height:1.55;">
                            Generate a new secure password and email it to <strong>{{ $agent->email }}</strong>.
                        </p>
                        @if($agent->user)
                            <form method="POST" action="{{ route('admin.agents.reset-password', $agent->id) }}">
                                @csrf
                                <button type="submit" class="ae-btn ae-btn-blue"
                                        style="width:100%;justify-content:center;"
                                        onclick="return confirm('Reset password and send to {{ $agent->email }}?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                    Reset &amp; Email Password
                                </button>
                            </form>
                        @else
                            <p style="font-size:.79rem;color:var(--muted);font-style:italic;">No linked user account.</p>
                        @endif
                    </div>
                </div>

                {{-- ── Danger zone ── --}}
                <div class="ae-card" style="border-color:#fecaca;">
                    <div class="ae-card-header" style="background:#fef2f2;border-color:#fecaca;">
                        <div class="ae-card-header-icon" style="background:#fee2e2;color:var(--danger);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                        </div>
                        <h6 style="color:var(--danger)">Danger Zone</h6>
                    </div>
                    <div class="ae-card-body">
                        <p style="font-size:.8rem;color:var(--muted);margin-bottom:.85rem;line-height:1.55;">
                            Permanently deletes this agent and their linked login account.
                        </p>
                        <form method="POST" action="{{ route('admin.agents.destroy', $agent->id) }}"
                              onsubmit="return confirm('Delete {{ $agent->full_name }}? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="ae-btn ae-btn-danger"
                                    style="width:100%;justify-content:center;font-size:.82rem;padding:.55rem 1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                Delete Agent
                            </button>
                        </form>
                    </div>
                </div>

            </div>{{-- /.ae-side --}}

        </div>{{-- /.ae-layout --}}
    </form>
</div>

<script>
/* ── Live preview sync ── */
function syncPreview() {
    const name  = document.getElementById('fullNameInput').value.trim();
    const email = document.getElementById('emailInput').value.trim();
    const initials = name.split(/\s+/).map(w => w[0]?.toUpperCase() ?? '').slice(0,2).join('') || '??';

    document.getElementById('previewName').textContent  = name  || '—';
    document.getElementById('previewEmail').textContent = email || '—';

    // Update avatar initials if no image loaded
    const initEl = document.getElementById('previewAvatarInitials');
    if (initEl) initEl.textContent = initials;
}

/* ── New profile photo preview ── */
document.getElementById('profileImageInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const box = document.getElementById('newPreviewBox');
        const img = document.getElementById('newPreviewImg');
        const avatarEl = document.getElementById('previewAvatar');

        img.src = e.target.result;
        box.style.display = 'block';

        // Update preview avatar
        avatarEl.innerHTML = `<img src="${e.target.result}" alt="preview" style="width:100%;height:100%;object-fit:cover;">`;
    };
    reader.readAsDataURL(file);
});

function clearNewPhoto() {
    document.getElementById('profileImageInput').value = '';
    document.getElementById('newPreviewBox').style.display = 'none';
    document.getElementById('newPreviewImg').src = '';

    // Restore original avatar
    const avatar = document.getElementById('previewAvatar');
    @if($agent->profile_image)
        avatar.innerHTML = '<img src="{{ asset('storage/' . $agent->profile_image) }}" alt="{{ $agent->full_name }}" style="width:100%;height:100%;object-fit:cover;">';
    @else
        avatar.innerHTML = '<span id="previewAvatarInitials">{{ strtoupper(substr($agent->full_name, 0, 2)) }}</span>';
    @endif
}
</script>

@endsection