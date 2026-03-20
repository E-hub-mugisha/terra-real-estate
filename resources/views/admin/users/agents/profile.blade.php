@extends('layouts.app')
@section('title', $agent->full_name . ' — Agent Profile')
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

    .as-page { padding: 1.75rem 0 3rem; max-width: 1160px; margin: 0 auto; }

    /* ── Breadcrumb ── */
    .as-breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: .78rem; color: var(--muted); margin-bottom: 1.5rem; }
    .as-breadcrumb a { color: var(--muted); text-decoration: none; transition: color .15s; }
    .as-breadcrumb a:hover { color: var(--accent); }

    /* ── Alerts ── */
    .as-alert { border-radius: 8px; padding: .85rem 1.1rem; font-size: .84rem; display: flex; gap: .6rem; align-items: center; margin-bottom: 1.25rem; }
    .as-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .as-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .as-alert-warning { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }

    /* ── Layout ── */
    .as-layout { display: grid; grid-template-columns: 300px 1fr; gap: 1.25rem; align-items: start; }
    .as-left  { display: flex; flex-direction: column; gap: 1.25rem; position: sticky; top: 80px; }
    .as-right { display: flex; flex-direction: column; gap: 1.25rem; }

    /* ── Buttons ── */
    .as-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .6rem 1.2rem; border-radius: 8px; font-size: .84rem; font-weight: 600;
        border: none; cursor: pointer; transition: all .2s; text-decoration: none; font-family: inherit;
    }
    .as-btn-primary       { background: var(--accent); color: #fff; }
    .as-btn-primary:hover { background: var(--accent-lt); color: #fff; }
    .as-btn-ghost         { background: none; border: 1.5px solid var(--border); color: var(--text-dim); }
    .as-btn-ghost:hover   { border-color: var(--accent); color: var(--accent); }
    .as-btn-danger        { background: none; border: 1.5px solid #fecaca; color: var(--danger); }
    .as-btn-danger:hover  { background: #fef2f2; }
    .as-btn-blue          { background: none; border: 1.5px solid #bfdbfe; color: var(--blue); }
    .as-btn-blue:hover    { background: #eff6ff; }
    .as-btn-sm { padding: .38rem .85rem; font-size: .78rem; }

    /* ── Profile card ── */
    .as-profile-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .as-profile-banner {
        height: 90px; position: relative;
        background: linear-gradient(135deg, #c9a96e40, #e4c99025, #c9a96e18);
        border-bottom: 1px solid var(--border);
    }
    .as-profile-banner::after {
        content: ''; position: absolute; inset: 0;
        background: repeating-linear-gradient(45deg,transparent,transparent 20px,rgba(201,169,110,.04) 20px,rgba(201,169,110,.04) 40px);
    }
    .as-profile-body { padding: 0 1.5rem 1.5rem; }
    .as-profile-avatar-wrap { margin-top: -32px; margin-bottom: 1rem; position: relative; z-index: 1; }
    .as-profile-avatar {
        width: 64px; height: 64px; border-radius: 50%; object-fit: cover;
        border: 3px solid #fff; box-shadow: 0 2px 12px rgba(0,0,0,.12);
        display: block;
    }
    .as-profile-avatar-initials {
        width: 64px; height: 64px; border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent-lt));
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 1.2rem; color: #fff;
        border: 3px solid #fff; box-shadow: 0 2px 12px rgba(0,0,0,.12);
    }
    .as-profile-name { font-size: 1.05rem; font-weight: 700; color: var(--text); margin: 0 0 .2rem; }
    .as-profile-role { font-size: .8rem; color: var(--text-dim); margin: 0 0 .75rem; }

    /* ── Rating stars ── */
    .as-rating { display: flex; align-items: center; gap: .3rem; margin-bottom: .85rem; }
    .as-star { color: #fbbf24; font-size: 1rem; }
    .as-star.empty { color: var(--border); }
    .as-rating-val { font-size: .82rem; font-weight: 600; color: var(--text-dim); margin-left: .2rem; }

    /* ── Contact links ── */
    .as-contact-list { display: flex; flex-direction: column; gap: .5rem; }
    .as-contact-item {
        display: flex; align-items: center; gap: .6rem;
        font-size: .82rem; color: var(--text-dim); text-decoration: none; transition: color .15s;
    }
    .as-contact-item:hover { color: var(--accent); }
    .as-contact-icon {
        width: 28px; height: 28px; border-radius: 7px; background: var(--surface);
        border: 1px solid var(--border); display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; color: var(--muted);
    }

    /* ── Social links ── */
    .as-socials { display: flex; gap: .5rem; margin-top: .75rem; padding-top: .75rem; border-top: 1px solid var(--border); }
    .as-social-btn {
        width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        transition: all .15s; text-decoration: none; color: var(--muted);
    }
    .as-social-btn:hover { border-color: var(--accent); color: var(--accent); background: #c9a96e08; }

    /* ── Card ── */
    .as-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .as-card-header {
        display: flex; align-items: center; gap: .75rem;
        padding: .9rem 1.4rem; border-bottom: 1px solid var(--border); background: var(--surface);
    }
    .as-card-header-icon {
        width: 30px; height: 30px; border-radius: 7px; background: #c9a96e18;
        display: flex; align-items: center; justify-content: center; color: var(--accent); flex-shrink: 0;
    }
    .as-card-header h6 { margin: 0; font-size: .86rem; font-weight: 600; color: var(--text); }
    .as-card-action { margin-left: auto; }
    .as-card-body { padding: 1.4rem; }

    /* ── Stat cards ── */
    .as-stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1px; background: var(--border); }
    .as-stat-cell { background: #fff; padding: 1.25rem 1rem; text-align: center; }
    .as-stat-cell:hover { background: var(--surface); }
    .as-stat-val   { font-size: 1.6rem; font-weight: 700; color: var(--text); line-height: 1; }
    .as-stat-val.accent { color: var(--accent); }
    .as-stat-val.blue   { color: var(--blue); }
    .as-stat-val.green  { color: var(--green); }
    .as-stat-label { font-size: .7rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); margin-top: .4rem; }

    /* ── Info grid ── */
    .as-info-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 1px;
        background: var(--border); border: 1px solid var(--border); border-radius: 8px; overflow: hidden;
    }
    .as-info-cell { background: #fff; padding: .85rem 1rem; transition: background .15s; }
    .as-info-cell:hover { background: var(--surface); }
    .as-info-key { font-size: .68rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); margin-bottom: .3rem; }
    .as-info-val { font-size: .88rem; color: var(--text); font-weight: 500; }
    .as-info-val.muted  { color: var(--muted); font-weight: 400; font-style: italic; }
    .as-info-val.accent { color: var(--accent); }

    /* ── Bio ── */
    .as-bio { font-size: .9rem; color: var(--text-dim); line-height: 1.8; }
    .as-no-bio { font-size: .84rem; color: var(--muted); font-style: italic; }

    /* ── Quick actions ── */
    .as-action-btn {
        display: flex; align-items: center; gap: .6rem; padding: .65rem .9rem;
        border-radius: 8px; border: 1.5px solid var(--border); background: none;
        font-family: inherit; font-size: .82rem; font-weight: 500; cursor: pointer;
        transition: all .15s; color: var(--text-dim); text-align: left; width: 100%;
        text-decoration: none;
    }
    .as-action-btn:hover        { border-color: var(--accent); color: var(--text); background: #c9a96e06; }
    .as-action-btn.blue:hover   { border-color: #bfdbfe; color: var(--blue); background: #eff6ff; }
    .as-action-btn.danger:hover { border-color: #fecaca; color: var(--danger); background: #fef2f2; }
    .as-actions-list { display: flex; flex-direction: column; gap: .5rem; }

    /* ── Languages ── */
    .as-lang-chips { display: flex; flex-wrap: wrap; gap: .4rem; }
    .as-lang-chip {
        padding: .24rem .7rem; border-radius: 100px; font-size: .74rem; font-weight: 600;
        background: #c9a96e0d; border: 1px solid #c9a96e30; color: var(--accent);
    }

    /* ── Social row ── */
    .as-social-list { display: flex; flex-direction: column; gap: .6rem; }
    .as-social-link {
        display: flex; align-items: center; gap: .75rem; font-size: .83rem;
        color: var(--text-dim); text-decoration: none; transition: color .15s;
        padding: .5rem .75rem; border-radius: 8px; border: 1px solid var(--border);
    }
    .as-social-link:hover { border-color: var(--accent); color: var(--accent); background: #c9a96e06; }
    .as-social-link .as-soc-ico { width: 22px; display: flex; justify-content: center; flex-shrink: 0; }

    /* ── Modal ── */
    .as-modal .modal-content { border: 1px solid var(--border); border-radius: var(--radius); box-shadow: 0 8px 32px rgba(0,0,0,.12); overflow: hidden; }
    .as-modal .modal-header  { background: var(--surface); border-bottom: 1px solid var(--border); padding: 1rem 1.4rem; display: flex; align-items: center; gap: .75rem; }
    .as-modal-icon { width: 30px; height: 30px; border-radius: 7px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .as-modal-icon.danger { background: #fef2f2; color: var(--danger); }
    .as-modal-icon.blue   { background: #eff6ff; color: var(--blue); }
    .as-modal .modal-title  { font-size: .92rem; font-weight: 700; color: var(--text); margin: 0; }
    .as-modal .modal-body   { padding: 1.4rem; }
    .as-modal .modal-footer { padding: .85rem 1.4rem; border-top: 1px solid var(--border); gap: .5rem; }
    .as-delete-box { font-size: .87rem; color: var(--text-dim); line-height: 1.6; padding: .85rem 1rem; border-radius: 8px; border: 1px solid #fecaca; background: #fef2f2; }
    .as-delete-box strong { color: var(--text); }

    /* ── Timeline ── */
    .as-timeline { display: flex; flex-direction: column; }
    .as-tl-item  { display: flex; gap: 1rem; padding-bottom: 1.25rem; }
    .as-tl-item:last-child { padding-bottom: 0; }
    .as-tl-left  { display: flex; flex-direction: column; align-items: center; flex-shrink: 0; }
    .as-tl-dot {
        width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center;
        justify-content: center; border: 2px solid var(--border); background: #fff; color: var(--muted); flex-shrink: 0;
    }
    .as-tl-dot.accent { border-color: var(--accent); background: #c9a96e12; color: var(--accent); }
    .as-tl-dot.blue   { border-color: #bfdbfe; background: #eff6ff; color: var(--blue); }
    .as-tl-dot.green  { border-color: #bbf7d0; background: #f0fdf4; color: var(--green); }
    .as-tl-line { width: 1px; flex: 1; background: var(--border); margin-top: 4px; min-height: 16px; }
    .as-tl-item:last-child .as-tl-line { display: none; }
    .as-tl-content { flex: 1; padding-top: .2rem; }
    .as-tl-title { font-size: .86rem; font-weight: 600; color: var(--text); }
    .as-tl-meta  { font-size: .76rem; color: var(--muted); margin-top: .2rem; }

    @media (max-width: 960px) {
        .as-layout { grid-template-columns: 1fr; }
        .as-left { position: static; }
        .as-stat-grid { grid-template-columns: repeat(3,1fr); }
        .as-info-grid  { grid-template-columns: 1fr; }
    }
    @media (max-width: 500px) {
        .as-stat-grid { grid-template-columns: 1fr 1fr; }
    }
</style>

<div class="as-page">

    {{-- ── Breadcrumb ── --}}
    <nav class="as-breadcrumb">
        <a href="{{ route('admin.agents.index') }}">Agents</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">{{ $agent->full_name }}</span>
    </nav>

    {{-- ── Alerts ── --}}
    @if(session('success'))
        <div class="as-alert as-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="as-alert as-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="as-alert as-alert-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/></svg>
            {{ session('warning') }}
        </div>
    @endif

    <div class="as-layout">

        {{-- ══ LEFT COLUMN ══ --}}
        <div class="as-left">

            {{-- ── Profile card ── --}}
            <div class="as-profile-card">
                <div class="as-profile-banner"></div>
                <div class="as-profile-body">
                    <div class="as-profile-avatar-wrap">
                        @if($agent->profile_image)
                            <img src="{{ asset('storage/' . $agent->profile_image) }}"
                                 alt="{{ $agent->full_name }}" class="as-profile-avatar">
                        @else
                            <div class="as-profile-avatar-initials">
                                {{ strtoupper(substr($agent->full_name, 0, 2)) }}
                            </div>
                        @endif
                    </div>

                    <h5 class="as-profile-name">{{ $agent->full_name }}</h5>
                    <p class="as-profile-role">Real Estate Agent · Terra</p>

                    {{-- Star rating --}}
                    <div class="as-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="as-star {{ $i <= round($agent->rating) ? '' : 'empty' }}">★</span>
                        @endfor
                        <span class="as-rating-val">{{ number_format($agent->rating, 1) }} / 5</span>
                    </div>

                    {{-- Contact info --}}
                    <div class="as-contact-list">
                        @if($agent->email)
                            <a href="mailto:{{ $agent->email }}" class="as-contact-item">
                                <div class="as-contact-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                </div>
                                {{ $agent->email }}
                            </a>
                        @endif
                        @if($agent->phone)
                            <a href="tel:{{ $agent->phone }}" class="as-contact-item">
                                <div class="as-contact-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </div>
                                {{ $agent->phone }}
                            </a>
                        @endif
                        @if($agent->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $agent->whatsapp) }}"
                               target="_blank" class="as-contact-item">
                                <div class="as-contact-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                </div>
                                WhatsApp
                            </a>
                        @endif
                        @if($agent->office_location)
                            <div class="as-contact-item">
                                <div class="as-contact-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                </div>
                                {{ $agent->office_location }}
                            </div>
                        @endif
                    </div>

                    {{-- Social links --}}
                    @if($agent->linkedin || $agent->facebook || $agent->instagram || $agent->twitter)
                        <div class="as-socials">
                            @if($agent->linkedin)
                                <a href="{{ $agent->linkedin }}" target="_blank" class="as-social-btn" title="LinkedIn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#0a66c2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
                                </a>
                            @endif
                            @if($agent->facebook)
                                <a href="{{ $agent->facebook }}" target="_blank" class="as-social-btn" title="Facebook">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#1877f2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                                </a>
                            @endif
                            @if($agent->instagram)
                                <a href="{{ $agent->instagram }}" target="_blank" class="as-social-btn" title="Instagram">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e1306c" stroke-width="2"><rect width="20" height="20" x="2" y="2" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                                </a>
                            @endif
                            @if($agent->twitter)
                                <a href="{{ $agent->twitter }}" target="_blank" class="as-social-btn" title="Twitter / X">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="#000"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            @endif
                        </div>
                    @endif

                    {{-- Action buttons --}}
                    <div style="display:flex;gap:.5rem;margin-top:1.1rem;padding-top:1rem;border-top:1px solid var(--border);">
                        <a href="{{ route('admin.agents.edit', $agent->id) }}"
                           class="as-btn as-btn-primary as-btn-sm" style="flex:1;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </a>
                        <button class="as-btn as-btn-danger as-btn-sm"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                style="flex:1;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                            Remove
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── Quick actions ── --}}
            <div class="as-card">
                <div class="as-card-header">
                    <div class="as-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                    <h6>Quick Actions</h6>
                </div>
                <div class="as-card-body">
                    <div class="as-actions-list">
                        <a href="mailto:{{ $agent->email }}" class="as-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            Send Email
                        </a>
                        @if($agent->phone)
                            <a href="tel:{{ $agent->phone }}" class="as-action-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                Call Agent
                            </a>
                        @endif
                        @if($agent->user)
                            <button class="as-action-btn blue"
                                    data-bs-toggle="modal" data-bs-target="#resetPasswordModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Reset Password
                            </button>
                        @endif
                        <a href="{{ route('admin.agents.edit', $agent->id) }}" class="as-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>

        </div>{{-- /.as-left --}}

        {{-- ══ RIGHT COLUMN ══ --}}
        <div class="as-right">

            {{-- ── Performance stats ── --}}
            <div class="as-card">
                <div class="as-stat-grid">
                    <div class="as-stat-cell">
                        <div class="as-stat-val accent">{{ $agent->sales_count ?? 0 }}</div>
                        <div class="as-stat-label">Sales</div>
                    </div>
                    <div class="as-stat-cell">
                        <div class="as-stat-val blue">{{ $agent->clients_count ?? 0 }}</div>
                        <div class="as-stat-label">Clients</div>
                    </div>
                    <div class="as-stat-cell">
                        <div class="as-stat-val green">{{ $agent->properties_count ?? 0 }}</div>
                        <div class="as-stat-label">Listings</div>
                    </div>
                </div>
            </div>

            {{-- ── Agent details ── --}}
            <div class="as-card">
                <div class="as-card-header">
                    <div class="as-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>
                    <h6>Agent Details</h6>
                    <a href="{{ route('admin.agents.edit', $agent->id) }}"
                       class="as-card-action as-btn as-btn-ghost as-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </a>
                </div>
                <div class="as-card-body" style="padding:0">
                    <div class="as-info-grid">
                        <div class="as-info-cell">
                            <div class="as-info-key">Full Name</div>
                            <div class="as-info-val">{{ $agent->full_name }}</div>
                        </div>
                        <div class="as-info-cell">
                            <div class="as-info-key">Email</div>
                            <div class="as-info-val" style="font-size:.83rem">
                                <a href="mailto:{{ $agent->email }}" style="color:var(--accent);text-decoration:none">{{ $agent->email }}</a>
                            </div>
                        </div>
                        <div class="as-info-cell">
                            <div class="as-info-key">Phone</div>
                            <div class="as-info-val">
                                @if($agent->phone)
                                    <a href="tel:{{ $agent->phone }}" style="color:var(--text);text-decoration:none">{{ $agent->phone }}</a>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </div>
                        </div>
                        <div class="as-info-cell">
                            <div class="as-info-key">WhatsApp</div>
                            <div class="as-info-val">{{ $agent->whatsapp ?? '—' }}</div>
                        </div>
                        <div class="as-info-cell">
                            <div class="as-info-key">Experience</div>
                            <div class="as-info-val accent">{{ $agent->years_experience }} yr{{ $agent->years_experience != 1 ? 's' : '' }}</div>
                        </div>
                        <div class="as-info-cell">
                            <div class="as-info-key">Rating</div>
                            <div class="as-info-val">
                                <span style="color:#f59e0b;font-size:.9rem;">★</span>
                                {{ number_format($agent->rating, 1) }} / 5
                            </div>
                        </div>
                        <div class="as-info-cell">
                            <div class="as-info-key">Office</div>
                            <div class="as-info-val">{{ $agent->office_location ?? '—' }}</div>
                        </div>
                        <div class="as-info-cell">
                            <div class="as-info-key">Account</div>
                            <div class="as-info-val">
                                @if($agent->user)
                                    <span style="color:var(--green);font-size:.82rem;font-weight:500;">✓ Linked</span>
                                @else
                                    <span style="color:var(--muted);font-size:.82rem;">No account</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Languages ── --}}
            @if($agent->languages)
                <div class="as-card">
                    <div class="as-card-header">
                        <div class="as-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 8 6 6"/><path d="m4 14 6-6 2-3"/><path d="M2 5h12"/><path d="M7 2h1"/><path d="m22 22-5-10-5 10"/><path d="M14 18h6"/></svg>
                        </div>
                        <h6>Languages</h6>
                    </div>
                    <div class="as-card-body">
                        <div class="as-lang-chips">
                            @foreach(array_map('trim', explode(',', $agent->languages)) as $lang)
                                @if($lang)
                                    <span class="as-lang-chip">{{ $lang }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- ── Bio ── --}}
            <div class="as-card">
                <div class="as-card-header">
                    <div class="as-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" x2="3" y1="10" y2="10"/><line x1="21" x2="3" y1="6" y2="6"/><line x1="21" x2="3" y1="14" y2="14"/><line x1="13" x2="3" y1="18" y2="18"/></svg>
                    </div>
                    <h6>Bio</h6>
                </div>
                <div class="as-card-body">
                    @if($agent->bio)
                        <p class="as-bio">{{ $agent->bio }}</p>
                    @else
                        <p class="as-no-bio">No bio provided yet.</p>
                    @endif
                </div>
            </div>

            {{-- ── Social media ── --}}
            @if($agent->linkedin || $agent->facebook || $agent->instagram || $agent->twitter)
                <div class="as-card">
                    <div class="as-card-header">
                        <div class="as-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg>
                        </div>
                        <h6>Social Media</h6>
                    </div>
                    <div class="as-card-body">
                        <div class="as-social-list">
                            @if($agent->linkedin)
                                <a href="{{ $agent->linkedin }}" target="_blank" class="as-social-link">
                                    <div class="as-soc-ico"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#0a66c2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg></div>
                                    LinkedIn
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left:auto;opacity:.4"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                                </a>
                            @endif
                            @if($agent->facebook)
                                <a href="{{ $agent->facebook }}" target="_blank" class="as-social-link">
                                    <div class="as-soc-ico"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#1877f2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></div>
                                    Facebook
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left:auto;opacity:.4"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                                </a>
                            @endif
                            @if($agent->instagram)
                                <a href="{{ $agent->instagram }}" target="_blank" class="as-social-link">
                                    <div class="as-soc-ico"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e1306c" stroke-width="2"><rect width="20" height="20" x="2" y="2" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg></div>
                                    Instagram
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left:auto;opacity:.4"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                                </a>
                            @endif
                            @if($agent->twitter)
                                <a href="{{ $agent->twitter }}" target="_blank" class="as-social-link">
                                    <div class="as-soc-ico"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#000"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></div>
                                    Twitter / X
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left:auto;opacity:.4"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- ── Timeline ── --}}
            <div class="as-card">
                <div class="as-card-header">
                    <div class="as-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h6>Activity</h6>
                </div>
                <div class="as-card-body">
                    <div class="as-timeline">
                        <div class="as-tl-item">
                            <div class="as-tl-left">
                                <div class="as-tl-dot accent">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                                </div>
                                <div class="as-tl-line"></div>
                            </div>
                            <div class="as-tl-content">
                                <div class="as-tl-title">Agent profile created</div>
                                <div class="as-tl-meta">{{ $agent->created_at->format('F j, Y') }} — {{ $agent->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @if($agent->user)
                            <div class="as-tl-item">
                                <div class="as-tl-left">
                                    <div class="as-tl-dot blue">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                                    </div>
                                    <div class="as-tl-line"></div>
                                </div>
                                <div class="as-tl-content">
                                    <div class="as-tl-title">Login account created</div>
                                    <div class="as-tl-meta">{{ $agent->user->created_at->format('F j, Y') }} — {{ $agent->user->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endif
                        <div class="as-tl-item">
                            <div class="as-tl-left">
                                <div class="as-tl-dot">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </div>
                            </div>
                            <div class="as-tl-content">
                                <div class="as-tl-title">Last profile update</div>
                                <div class="as-tl-meta">{{ $agent->updated_at->format('F j, Y') }} — {{ $agent->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Danger zone ── --}}
            <div class="as-card" style="border-color:#fecaca;">
                <div class="as-card-header" style="background:#fef2f2;border-color:#fecaca;">
                    <div class="as-card-header-icon" style="background:#fee2e2;color:var(--danger);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                    </div>
                    <h6 style="color:var(--danger)">Danger Zone</h6>
                </div>
                <div class="as-card-body">
                    <p style="font-size:.82rem;color:var(--muted);margin-bottom:1rem;line-height:1.55;">
                        Permanently deletes this agent profile and their linked login account. All listing associations will be affected.
                    </p>
                    <button class="as-btn as-btn-danger" style="width:100%;justify-content:center;"
                            data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                        Delete Agent
                    </button>
                </div>
            </div>

        </div>{{-- /.as-right --}}
    </div>{{-- /.as-layout --}}
</div>

{{-- ══ RESET PASSWORD MODAL ══ --}}
<div class="modal fade as-modal" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.agents.reset-password', $agent->id) }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <div class="as-modal-icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div style="display:flex;align-items:flex-start;gap:.65rem;padding:.85rem 1rem;border-radius:8px;background:#eff6ff;border:1px solid #bfdbfe;font-size:.83rem;color:#1d4ed8;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                    <span>A new secure password will be generated using <strong>Hash::make()</strong> and emailed to <strong>{{ $agent->email }}</strong>. The current password will stop working immediately.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="as-btn as-btn-ghost as-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="as-btn as-btn-sm" style="background:var(--blue);color:#fff;border:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    Reset &amp; Send Credentials
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ DELETE MODAL ══ --}}
<div class="modal fade as-modal" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.agents.destroy', $agent->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="as-modal-icon danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                </div>
                <h5 class="modal-title" style="color:var(--danger)">Delete Agent</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="as-delete-box">
                    You are about to permanently delete <strong>{{ $agent->full_name }}</strong> and their login account.
                    All property listings associated with this agent may be affected.
                    <br><br>
                    <span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="as-btn as-btn-ghost as-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="as-btn as-btn-danger as-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    Delete Agent
                </button>
            </div>
        </form>
    </div>
</div>

@endsection