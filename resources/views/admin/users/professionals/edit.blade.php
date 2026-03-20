{{-- ============================================================
     SAVE AS: resources/views/admin/professionals/edit.blade.php
     ============================================================ --}}
@extends('layouts.app')
@section('title', 'Edit Professional — ' . $professional->full_name)
@section('content')

<style>
    :root{--accent:#c9a96e;--accent-lt:#e4c990;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--blue:#3b82f6;--purple:#7c3aed;--green:#22c55e;}
    .pe-page{padding:1.75rem 0 3rem;max-width:1060px;margin:0 auto;}
    .pe-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);margin-bottom:1.5rem;}
    .pe-breadcrumb a{color:var(--muted);text-decoration:none;transition:color .15s;}
    .pe-breadcrumb a:hover{color:var(--accent);}
    .pe-heading{display:flex;align-items:center;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;}
    .pe-heading-avatar{width:48px;height:48px;border-radius:50%;flex-shrink:0;background:linear-gradient(135deg,var(--purple),#a855f7);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1rem;color:#fff;border:2px solid rgba(124,58,237,.3);overflow:hidden;}
    .pe-heading-avatar img{width:100%;height:100%;object-fit:cover;}
    .pe-heading h4{font-size:1.2rem;font-weight:700;color:var(--text);margin:0;}
    .pe-heading p{font-size:.82rem;color:var(--text-dim);margin:.15rem 0 0;}
    .pe-heading-meta{margin-left:auto;display:flex;align-items:center;gap:.6rem;}
    .pe-verified-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.24rem .7rem;border-radius:100px;font-size:.7rem;font-weight:600;border:1px solid;}
    .pe-verified-badge.yes{color:#166534;border-color:#bbf7d0;background:#f0fdf4;}
    .pe-verified-badge.no{color:#991b1b;border-color:#fecaca;background:#fef2f2;}
    .pe-layout{display:grid;grid-template-columns:1fr 280px;gap:1.25rem;align-items:start;}
    .pe-main{display:flex;flex-direction:column;gap:1.25rem;}
    .pe-side{display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:80px;}
    .pe-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .pe-card-header{display:flex;align-items:center;gap:.75rem;padding:1rem 1.5rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .pe-card-header-icon{width:32px;height:32px;border-radius:8px;background:#c9a96e18;display:flex;align-items:center;justify-content:center;color:var(--accent);flex-shrink:0;}
    .pe-card-header h6{margin:0;font-size:.88rem;font-weight:600;color:var(--text);}
    .pe-card-body{padding:1.5rem;}
    .pe-label{display:block;font-size:.77rem;font-weight:600;letter-spacing:.03em;color:var(--text-dim);text-transform:uppercase;margin-bottom:.45rem;}
    .pe-label .req{color:var(--danger);margin-left:.2rem;}
    .pe-input,.pe-select,.pe-textarea{width:100%;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.875rem;color:var(--text);background:#fff;outline:none;font-family:inherit;transition:border-color .2s,box-shadow .2s;}
    .pe-input:focus,.pe-select:focus,.pe-textarea:focus{border-color:var(--accent);box-shadow:0 0 0 3px #c9a96e18;}
    .pe-input.is-invalid{border-color:var(--danger);}
    .pe-textarea{resize:vertical;line-height:1.65;}
    .pe-hint{font-size:.73rem;color:var(--muted);margin-top:.35rem;}
    .pe-error{font-size:.73rem;color:var(--danger);margin-top:.35rem;display:flex;align-items:center;gap:.3rem;}
    .pe-input-icon{position:relative;}
    .pe-input-icon svg{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none;}
    .pe-input-icon .pe-input{padding-left:2.5rem;}
    .pe-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
    .pe-gap{display:flex;flex-direction:column;gap:1rem;}
    .pe-stars{display:flex;gap:.3rem;flex-direction:row-reverse;justify-content:flex-end;}
    .pe-stars input{display:none;}
    .pe-stars label{cursor:pointer;font-size:1.4rem;color:var(--border);transition:color .15s;user-select:none;}
    .pe-stars input:checked~label,.pe-stars label:hover,.pe-stars label:hover~label{color:#f59e0b;}
    .pe-current-file{display:flex;align-items:center;gap:.85rem;padding:.85rem 1rem;border:1px solid var(--border);border-radius:8px;background:var(--surface);margin-bottom:.85rem;}
    .pe-current-file img{width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid var(--border);flex-shrink:0;}
    .pe-current-initials{width:48px;height:48px;border-radius:50%;flex-shrink:0;background:linear-gradient(135deg,var(--purple),#a855f7);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.9rem;color:#fff;}
    .pe-current-file-info strong{display:block;font-size:.83rem;color:var(--text);margin-bottom:.1rem;}
    .pe-current-file-info span{font-size:.73rem;color:var(--muted);}
    .pe-doc-row{display:flex;align-items:center;gap:.85rem;padding:.85rem 1rem;border:1px solid var(--border);border-radius:8px;background:var(--surface);margin-bottom:.85rem;}
    .pe-doc-icon{width:38px;height:38px;border-radius:8px;background:#fef2f2;display:flex;align-items:center;justify-content:center;color:var(--danger);flex-shrink:0;}
    .pe-doc-info strong{display:block;font-size:.83rem;color:var(--text);margin-bottom:.1rem;}
    .pe-doc-info span{font-size:.73rem;color:var(--muted);}
    .pe-img-upload{border:2px dashed var(--border);border-radius:10px;padding:1.25rem;background:var(--surface);cursor:pointer;transition:border-color .2s,background .2s;position:relative;text-align:center;}
    .pe-img-upload:hover{border-color:var(--accent);background:#c9a96e06;}
    .pe-img-upload input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
    .pe-new-preview{display:none;border-radius:8px;overflow:hidden;margin-top:.75rem;position:relative;}
    .pe-new-preview img{width:100%;max-height:140px;object-fit:cover;display:block;}
    .pe-new-preview-remove{position:absolute;top:5px;right:5px;width:22px;height:22px;border-radius:50%;background:rgba(0,0,0,.6);border:none;color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:10px;}
    .pe-social-row{display:flex;align-items:center;gap:.65rem;padding:.6rem .9rem;border:1.5px solid var(--border);border-radius:8px;background:#fff;transition:border-color .2s,box-shadow .2s;}
    .pe-social-row:focus-within{border-color:var(--accent);box-shadow:0 0 0 3px #c9a96e18;}
    .pe-social-icon{flex-shrink:0;width:18px;display:flex;align-items:center;justify-content:center;}
    .pe-social-row input{flex:1;border:none;outline:none;font-family:inherit;font-size:.875rem;color:var(--text);background:transparent;}
    .pe-switch{position:relative;width:38px;height:22px;flex-shrink:0;}
    .pe-switch input{opacity:0;width:0;height:0;}
    .pe-switch-track{position:absolute;inset:0;background:var(--border);border-radius:100px;cursor:pointer;transition:background .2s;}
    .pe-switch-track::before{content:'';position:absolute;width:16px;height:16px;border-radius:50%;background:#fff;top:3px;left:3px;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.2);}
    .pe-switch input:checked+.pe-switch-track{background:var(--accent);}
    .pe-switch input:checked+.pe-switch-track::before{transform:translateX(16px);}
    .pe-preview-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .pe-preview-banner{height:56px;background:linear-gradient(135deg,#7c3aed20,#a855f715);border-bottom:1px solid var(--border);}
    .pe-preview-body{padding:0 1.25rem 1.25rem;}
    .pe-preview-avatar-wrap{margin-top:-24px;margin-bottom:.65rem;}
    .pe-preview-avatar{width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--purple),#a855f7);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.95rem;color:#fff;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.1);overflow:hidden;}
    .pe-preview-avatar img{width:100%;height:100%;object-fit:cover;}
    .pe-preview-name{font-size:.92rem;font-weight:700;color:var(--text);margin:0 0 .15rem;}
    .pe-preview-email{font-size:.74rem;color:var(--muted);word-break:break-all;margin-bottom:.35rem;}
    .pe-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:flex-start;margin-bottom:1.25rem;}
    .pe-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .pe-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .pe-alert ul{margin:.35rem 0 0 1rem;padding:0;}
    .pe-alert li{margin-bottom:.2rem;}
    .pe-submit-bar{display:flex;align-items:center;justify-content:space-between;gap:.75rem;padding:1.1rem 1.5rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);}
    .pe-submit-bar-left{font-size:.78rem;color:var(--muted);display:flex;align-items:center;gap:.4rem;}
    .pe-submit-bar-right{display:flex;gap:.6rem;}
    .pe-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.65rem 1.4rem;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .pe-btn-primary{background:var(--accent);color:#fff;}
    .pe-btn-primary:hover{background:var(--accent-lt);color:#fff;transform:translateY(-1px);}
    .pe-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}
    .pe-btn-ghost:hover{border-color:var(--accent);color:var(--accent);}
    .pe-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}
    .pe-btn-danger:hover{background:#fef2f2;}
    .pe-btn-blue{background:none;border:1.5px solid #bfdbfe;color:var(--blue);}
    .pe-btn-blue:hover{background:#eff6ff;}
    .pe-btn-sm{padding:.42rem .9rem;font-size:.78rem;}
    @media(max-width:900px){.pe-layout{grid-template-columns:1fr;}.pe-side{position:static;}.pe-row-2{grid-template-columns:1fr;}}
</style>

<div class="pe-page">
    <nav class="pe-breadcrumb">
        <a href="{{ route('admin.professionals.index') }}">Professionals</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <a href="{{ route('admin.professionals.show',$professional->id) }}">{{ $professional->full_name }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">Edit</span>
    </nav>

    <div class="pe-heading">
        <div class="pe-heading-avatar">
            @if($professional->profile_image)
                <img src="{{ asset('storage/'.$professional->profile_image) }}" alt="{{ $professional->full_name }}">
            @else
                {{ strtoupper(substr($professional->full_name,0,2)) }}
            @endif
        </div>
        <div>
            <h4>Edit Professional</h4>
            <p>{{ $professional->full_name }} — last updated {{ $professional->updated_at->diffForHumans() }}</p>
        </div>
        <div class="pe-heading-meta">
            <span class="pe-verified-badge {{ $professional->is_verified ? 'yes' : 'no' }}">
                {{ $professional->is_verified ? '✓ Verified' : 'Unverified' }}
            </span>
            <a href="{{ route('admin.professionals.show',$professional->id) }}" class="pe-btn pe-btn-ghost pe-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                View
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="pe-alert pe-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div><strong>Please fix the following errors:</strong><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
    @endif
    @if(session('success'))
        <div class="pe-alert pe-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.professionals.update',$professional->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="pe-layout">
            <div class="pe-main">

                {{-- Account Details --}}
                <div class="pe-card">
                    <div class="pe-card-header">
                        <div class="pe-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
                        <h6>Account Details</h6>
                    </div>
                    <div class="pe-card-body">
                        <div class="pe-row-2">
                            <div>
                                <label class="pe-label">Full Name <span class="req">*</span></label>
                                <input type="text" name="full_name" id="fullNameInput" class="pe-input @error('full_name') is-invalid @enderror" value="{{ old('full_name',$professional->full_name) }}" oninput="syncPreview()" required>
                                @error('full_name')<p class="pe-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="pe-label">Email <span class="req">*</span></label>
                                <input type="email" name="email" id="emailInput" class="pe-input @error('email') is-invalid @enderror" value="{{ old('email',$professional->email) }}" oninput="syncPreview()" required>
                                <p class="pe-hint">Also updates login email.</p>
                                @error('email')<p class="pe-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div style="margin-top:1rem;">
                            <label class="pe-label">Phone <span class="req">*</span></label>
                            <div class="pe-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <input type="text" name="phone" class="pe-input @error('phone') is-invalid @enderror" value="{{ old('phone',$professional->phone) }}" required>
                            </div>
                            @error('phone')<p class="pe-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Professional Details --}}
                <div class="pe-card">
                    <div class="pe-card-header">
                        <div class="pe-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                        <h6>Professional Details</h6>
                    </div>
                    <div class="pe-card-body">
                        <div class="pe-gap">
                            <div class="pe-row-2">
                                <div>
                                    <label class="pe-label">Profession</label>
                                    <input type="text" name="profession" class="pe-input @error('profession') is-invalid @enderror" value="{{ old('profession',$professional->profession) }}" placeholder="e.g. Architect">
                                    @error('profession')<p class="pe-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="pe-label">License Number</label>
                                    <input type="text" name="license_number" class="pe-input @error('license_number') is-invalid @enderror" value="{{ old('license_number',$professional->license_number) }}">
                                    @error('license_number')<p class="pe-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="pe-row-2">
                                <div>
                                    <label class="pe-label">Years Experience</label>
                                    <input type="number" name="years_experience" class="pe-input @error('years_experience') is-invalid @enderror" value="{{ old('years_experience',$professional->years_experience) }}" min="0" max="50">
                                    @error('years_experience')<p class="pe-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="pe-label">Office Location</label>
                                    <div class="pe-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                        <input type="text" name="office_location" class="pe-input @error('office_location') is-invalid @enderror" value="{{ old('office_location',$professional->office_location) }}">
                                    </div>
                                    @error('office_location')<p class="pe-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="pe-row-2">
                                <div>
                                    <label class="pe-label">Languages</label>
                                    <input type="text" name="languages" class="pe-input @error('languages') is-invalid @enderror" value="{{ old('languages',$professional->languages) }}" placeholder="English, French">
                                    @error('languages')<p class="pe-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="pe-label">WhatsApp</label>
                                    <input type="text" name="whatsapp" class="pe-input @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp',$professional->whatsapp) }}">
                                    @error('whatsapp')<p class="pe-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div>
                                <label class="pe-label">Services Offered</label>
                                <input type="text" name="services" class="pe-input @error('services') is-invalid @enderror" value="{{ old('services',$professional->services) }}" placeholder="Property Valuation, Legal Conveyancing…">
                                @error('services')<p class="pe-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="pe-label">Rating</label>
                                <div style="display:flex;align-items:center;gap:1rem;">
                                    <div class="pe-stars">
                                        @for($i=5;$i>=1;$i--)
                                            <input type="radio" name="_star" id="pstar{{$i}}" value="{{$i}}" {{ (int)old('rating',$professional->rating)===$i?'checked':'' }} onchange="document.getElementById('ratingInput').value=this.value;document.getElementById('ratingLabel').textContent=this.value+' / 5'">
                                            <label for="pstar{{$i}}">★</label>
                                        @endfor
                                    </div>
                                    <span id="ratingLabel" style="font-size:.82rem;color:var(--text-dim)">{{ number_format(old('rating',$professional->rating),1) }} / 5</span>
                                </div>
                                <input type="number" name="rating" id="ratingInput" class="pe-input @error('rating') is-invalid @enderror" value="{{ old('rating',$professional->rating) }}" min="0" max="5" step="0.1" style="max-width:120px;margin-top:.5rem" oninput="document.getElementById('ratingLabel').textContent=this.value+' / 5'">
                                @error('rating')<p class="pe-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="pe-label">Bio</label>
                                <textarea name="bio" rows="4" class="pe-textarea @error('bio') is-invalid @enderror">{{ old('bio',$professional->bio) }}</textarea>
                                @error('bio')<p class="pe-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Portfolio & Links --}}
                <div class="pe-card">
                    <div class="pe-card-header">
                        <div class="pe-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg></div>
                        <h6>Portfolio &amp; Links</h6>
                    </div>
                    <div class="pe-card-body">
                        <div class="pe-gap">
                            <div>
                                <label class="pe-label">LinkedIn</label>
                                <div class="pe-social-row">
                                    <div class="pe-social-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#0a66c2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg></div>
                                    <input type="url" name="linkedin" value="{{ old('linkedin',$professional->linkedin) }}" placeholder="https://linkedin.com/in/…">
                                </div>
                                @error('linkedin')<p class="pe-error">{{ $message }}</p>@enderror
                            </div>
                            <div class="pe-row-2">
                                <div>
                                    <label class="pe-label">Portfolio URL</label>
                                    <div class="pe-social-row">
                                        <div class="pe-social-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></div>
                                        <input type="url" name="portfolio_url" value="{{ old('portfolio_url',$professional->portfolio_url) }}" placeholder="https://yourportfolio.com">
                                    </div>
                                    @error('portfolio_url')<p class="pe-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="pe-label">Website</label>
                                    <div class="pe-social-row">
                                        <div class="pe-social-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></div>
                                        <input type="url" name="website" value="{{ old('website',$professional->website) }}" placeholder="https://website.com">
                                    </div>
                                    @error('website')<p class="pe-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pe-submit-bar">
                    <div class="pe-submit-bar-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Last saved {{ $professional->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                    <div class="pe-submit-bar-right">
                        <a href="{{ route('admin.professionals.show',$professional->id) }}" class="pe-btn pe-btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                            Cancel
                        </a>
                        <button type="submit" class="pe-btn pe-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="pe-side">
                {{-- Photo --}}
                <div class="pe-card">
                    <div class="pe-card-header">
                        <div class="pe-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg></div>
                        <h6>Profile Photo</h6>
                    </div>
                    <div class="pe-card-body">
                        @if($professional->profile_image)
                            <div class="pe-current-file">
                                <img src="{{ asset('storage/'.$professional->profile_image) }}" alt="{{ $professional->full_name }}">
                                <div class="pe-current-file-info"><strong>Current photo</strong><span>Upload below to replace</span></div>
                            </div>
                        @else
                            <div class="pe-current-file">
                                <div class="pe-current-initials">{{ strtoupper(substr($professional->full_name,0,2)) }}</div>
                                <div class="pe-current-file-info"><strong>No photo set</strong><span>Upload one below</span></div>
                            </div>
                        @endif
                        <div class="pe-img-upload">
                            <input type="file" name="profile_image" id="profileImageInput" accept="image/jpg,image/jpeg,image/png,image/webp">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--accent);margin-bottom:.4rem"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            <p style="font-size:.83rem;font-weight:600;color:var(--text);margin:0 0 .2rem">{{ $professional->profile_image ? 'Replace photo' : 'Upload photo' }}</p>
                            <p style="font-size:.74rem;color:var(--muted);margin:0">JPG, PNG, WEBP — max 2MB</p>
                        </div>
                        <div class="pe-new-preview" id="newPreviewBox">
                            <img id="newPreviewImg" src="" alt="New preview">
                            <button type="button" class="pe-new-preview-remove" onclick="clearNewPhoto()">✕</button>
                        </div>
                        @error('profile_image')<p class="pe-error" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Credentials doc --}}
                <div class="pe-card">
                    <div class="pe-card-header">
                        <div class="pe-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                        <h6>Credentials Doc</h6>
                    </div>
                    <div class="pe-card-body">
                        @if($professional->credentials_doc)
                            <div class="pe-doc-row">
                                <div class="pe-doc-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                                <div class="pe-doc-info"><strong>{{ basename($professional->credentials_doc) }}</strong><span>Current document</span></div>
                                <a href="{{ asset('storage/'.$professional->credentials_doc) }}" target="_blank" style="font-size:.75rem;color:var(--blue);text-decoration:none;margin-left:auto">View</a>
                            </div>
                        @endif
                        <div class="pe-img-upload">
                            <input type="file" name="credentials_doc" id="credInput" accept=".pdf,.jpg,.jpeg,.png">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--accent);margin-bottom:.4rem"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <p style="font-size:.83rem;font-weight:600;color:var(--text);margin:0 0 .2rem">{{ $professional->credentials_doc ? 'Replace document' : 'Upload document' }}</p>
                            <p style="font-size:.74rem;color:var(--muted);margin:0">PDF, JPG, PNG — max 5MB</p>
                        </div>
                        @error('credentials_doc')<p class="pe-error" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Preview --}}
                <div class="pe-preview-card">
                    <div class="pe-preview-banner"></div>
                    <div class="pe-preview-body">
                        <div class="pe-preview-avatar-wrap">
                            <div class="pe-preview-avatar" id="previewAvatar">
                                @if($professional->profile_image)
                                    <img id="previewAvatarImg" src="{{ asset('storage/'.$professional->profile_image) }}" alt="{{ $professional->full_name }}">
                                @else
                                    <span id="previewAvatarInitials">{{ strtoupper(substr($professional->full_name,0,2)) }}</span>
                                @endif
                            </div>
                        </div>
                        <p class="pe-preview-name" id="previewName">{{ $professional->full_name }}</p>
                        <p class="pe-preview-email" id="previewEmail">{{ $professional->email }}</p>
                        <p style="font-size:.73rem;color:var(--text-dim)">{{ $professional->profession ?? 'Professional' }} · Terra</p>
                    </div>
                </div>

                {{-- Verification --}}
                <div class="pe-card">
                    <div class="pe-card-header">
                        <div class="pe-card-header-icon" style="background:#f0fdf4;color:var(--green);"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg></div>
                        <h6>Verification</h6>
                    </div>
                    <div class="pe-card-body">
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <div><div style="font-size:.84rem;font-weight:500;color:var(--text)">Mark as verified</div><div style="font-size:.73rem;color:var(--muted);margin-top:.1rem">Shows verified badge publicly</div></div>
                            <label class="pe-switch"><input type="checkbox" name="is_verified" value="1" {{ $professional->is_verified ? 'checked' : '' }}><span class="pe-switch-track"></span></label>
                        </div>
                    </div>
                </div>

                {{-- Password reset --}}
                <div class="pe-card">
                    <div class="pe-card-header">
                        <div class="pe-card-header-icon" style="background:#eff6ff;color:var(--blue);"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
                        <h6>Password</h6>
                    </div>
                    <div class="pe-card-body">
                        <p style="font-size:.81rem;color:var(--muted);margin-bottom:.85rem;line-height:1.55;">Generate a new secure password and email it.</p>
                        @if($professional->user)
                            <form method="POST" action="{{ route('admin.professionals.reset-password',$professional->id) }}">
                                @csrf
                                <button type="submit" class="pe-btn pe-btn-blue" style="width:100%;justify-content:center;" onclick="return confirm('Reset password and send to {{ $professional->email }}?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                    Reset &amp; Email
                                </button>
                            </form>
                        @else
                            <p style="font-size:.79rem;color:var(--muted);font-style:italic;">No linked user account.</p>
                        @endif
                    </div>
                </div>

                {{-- Danger zone --}}
                <div class="pe-card" style="border-color:#fecaca;">
                    <div class="pe-card-header" style="background:#fef2f2;border-color:#fecaca;">
                        <div class="pe-card-header-icon" style="background:#fee2e2;color:var(--danger);"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg></div>
                        <h6 style="color:var(--danger)">Danger Zone</h6>
                    </div>
                    <div class="pe-card-body">
                        <p style="font-size:.8rem;color:var(--muted);margin-bottom:.85rem;line-height:1.55;">Deletes this professional and their login account.</p>
                        <form method="POST" action="{{ route('admin.professionals.destroy',$professional->id) }}" onsubmit="return confirm('Delete {{ $professional->full_name }}? Cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="pe-btn pe-btn-danger" style="width:100%;justify-content:center;font-size:.82rem;padding:.55rem 1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                Delete Professional
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function syncPreview(){
    const name=document.getElementById('fullNameInput').value.trim();
    const email=document.getElementById('emailInput').value.trim();
    const initials=name.split(/\s+/).map(w=>w[0]?.toUpperCase()??'').slice(0,2).join('')||'??';
    document.getElementById('previewName').textContent=name||'—';
    document.getElementById('previewEmail').textContent=email||'—';
    const initEl=document.getElementById('previewAvatarInitials');
    if(initEl)initEl.textContent=initials;
}
document.getElementById('profileImageInput').addEventListener('change',function(){
    const file=this.files[0];if(!file)return;
    const reader=new FileReader();
    reader.onload=e=>{
        document.getElementById('newPreviewImg').src=e.target.result;
        document.getElementById('newPreviewBox').style.display='block';
        document.getElementById('previewAvatar').innerHTML='<img src="'+e.target.result+'" style="width:100%;height:100%;object-fit:cover;">';
    };reader.readAsDataURL(file);
});
function clearNewPhoto(){
    document.getElementById('profileImageInput').value='';
    document.getElementById('newPreviewBox').style.display='none';
    @if($professional->profile_image)
    document.getElementById('previewAvatar').innerHTML='<img src="{{ asset('storage/'.$professional->profile_image) }}" style="width:100%;height:100%;object-fit:cover;">';
    @else
    document.getElementById('previewAvatar').innerHTML='<span id="previewAvatarInitials">{{ strtoupper(substr($professional->full_name,0,2)) }}</span>';
    @endif
}
</script>
@endsection