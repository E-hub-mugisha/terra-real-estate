@extends('layouts.app')
@section('title', 'Add New Professional')
@section('content')

<style>
    :root{--accent:#c9a96e;--accent-lt:#e4c990;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--blue:#3b82f6;--purple:#7c3aed;}
    .pc-page{padding:1.75rem 0 3rem;max-width:1060px;margin:0 auto;}
    .pc-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);margin-bottom:1.5rem;}
    .pc-breadcrumb a{color:var(--muted);text-decoration:none;transition:color .15s;}
    .pc-breadcrumb a:hover{color:var(--accent);}
    .pc-heading{display:flex;align-items:center;gap:1rem;margin-bottom:2rem;}
    .pc-heading-icon{width:48px;height:48px;border-radius:10px;flex-shrink:0;background:linear-gradient(135deg,#7c3aed22,#7c3aed44);border:1px solid #7c3aed55;display:flex;align-items:center;justify-content:center;color:var(--purple);}
    .pc-heading h4{font-size:1.2rem;font-weight:700;color:var(--text);margin:0;}
    .pc-heading p{font-size:.82rem;color:var(--text-dim);margin:.15rem 0 0;}
    .pc-layout{display:grid;grid-template-columns:1fr 280px;gap:1.25rem;align-items:start;}
    .pc-main{display:flex;flex-direction:column;gap:1.25rem;}
    .pc-side{display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:80px;}
    .pc-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .pc-card-header{display:flex;align-items:center;gap:.75rem;padding:1rem 1.5rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .pc-card-header-icon{width:32px;height:32px;border-radius:8px;background:#c9a96e18;display:flex;align-items:center;justify-content:center;color:var(--accent);flex-shrink:0;}
    .pc-card-header h6{margin:0;font-size:.88rem;font-weight:600;color:var(--text);}
    .pc-card-body{padding:1.5rem;}
    .pc-label{display:block;font-size:.77rem;font-weight:600;letter-spacing:.03em;color:var(--text-dim);text-transform:uppercase;margin-bottom:.45rem;}
    .pc-label .req{color:var(--danger);margin-left:.2rem;}
    .pc-input,.pc-select,.pc-textarea{width:100%;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.875rem;color:var(--text);background:#fff;outline:none;font-family:inherit;transition:border-color .2s,box-shadow .2s;}
    .pc-input:focus,.pc-select:focus,.pc-textarea:focus{border-color:var(--accent);box-shadow:0 0 0 3px #c9a96e18;}
    .pc-input.is-invalid{border-color:var(--danger);}
    .pc-textarea{resize:vertical;line-height:1.65;}
    .pc-hint{font-size:.73rem;color:var(--muted);margin-top:.35rem;}
    .pc-error{font-size:.73rem;color:var(--danger);margin-top:.35rem;display:flex;align-items:center;gap:.3rem;}
    .pc-input-icon{position:relative;}
    .pc-input-icon svg{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none;}
    .pc-input-icon .pc-input{padding-left:2.5rem;}
    .pc-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
    .pc-gap{display:flex;flex-direction:column;gap:1rem;}
    .pc-stars{display:flex;gap:.3rem;flex-direction:row-reverse;justify-content:flex-end;}
    .pc-stars input{display:none;}
    .pc-stars label{cursor:pointer;font-size:1.4rem;color:var(--border);transition:color .15s;user-select:none;}
    .pc-stars input:checked~label,.pc-stars label:hover,.pc-stars label:hover~label{color:#f59e0b;}
    .pc-img-upload{display:flex;flex-direction:column;align-items:center;gap:.75rem;padding:1.5rem;border:2px dashed var(--border);border-radius:10px;background:var(--surface);cursor:pointer;transition:border-color .2s,background .2s;position:relative;text-align:center;}
    .pc-img-upload:hover{border-color:var(--accent);background:#c9a96e06;}
    .pc-img-upload input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
    .pc-img-preview{width:72px;height:72px;border-radius:50%;object-fit:cover;border:2px solid var(--accent);display:none;}
    .pc-img-placeholder{width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--purple),#a855f7);display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;color:#fff;}
    .pc-social-row{display:flex;align-items:center;gap:.65rem;padding:.6rem .9rem;border:1.5px solid var(--border);border-radius:8px;background:#fff;transition:border-color .2s,box-shadow .2s;}
    .pc-social-row:focus-within{border-color:var(--accent);box-shadow:0 0 0 3px #c9a96e18;}
    .pc-social-icon{flex-shrink:0;width:18px;display:flex;align-items:center;justify-content:center;}
    .pc-social-row input{flex:1;border:none;outline:none;font-family:inherit;font-size:.875rem;color:var(--text);background:transparent;}
    .pc-switch{position:relative;width:38px;height:22px;flex-shrink:0;}
    .pc-switch input{opacity:0;width:0;height:0;}
    .pc-switch-track{position:absolute;inset:0;background:var(--border);border-radius:100px;cursor:pointer;transition:background .2s;}
    .pc-switch-track::before{content:'';position:absolute;width:16px;height:16px;border-radius:50%;background:#fff;top:3px;left:3px;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.2);}
    .pc-switch input:checked+.pc-switch-track{background:var(--accent);}
    .pc-switch input:checked+.pc-switch-track::before{transform:translateX(16px);}
    .pc-toggle-row{display:flex;align-items:center;justify-content:space-between;padding:.75rem 0;border-bottom:1px solid var(--border);}
    .pc-toggle-row:last-child{border-bottom:none;padding-bottom:0;}
    .pc-toggle-label{font-size:.84rem;color:var(--text);font-weight:500;}
    .pc-toggle-desc{font-size:.73rem;color:var(--muted);margin-top:.1rem;}
    .pc-preview-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .pc-preview-banner{height:56px;background:linear-gradient(135deg,#7c3aed20,#a855f715);border-bottom:1px solid var(--border);}
    .pc-preview-body{padding:0 1.25rem 1.25rem;}
    .pc-preview-avatar-wrap{margin-top:-24px;margin-bottom:.65rem;}
    .pc-preview-avatar{width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--purple),#a855f7);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.95rem;color:#fff;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.1);}
    .pc-preview-name{font-size:.92rem;font-weight:700;color:var(--text);margin:0 0 .15rem;}
    .pc-preview-email{font-size:.74rem;color:var(--muted);word-break:break-all;margin-bottom:.35rem;}
    .pc-preview-role{font-size:.73rem;color:var(--text-dim);}
    .pc-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:flex-start;margin-bottom:1.25rem;}
    .pc-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .pc-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .pc-alert ul{margin:.35rem 0 0 1rem;padding:0;}
    .pc-alert li{margin-bottom:.2rem;}
    .pc-submit-bar{display:flex;align-items:center;justify-content:flex-end;gap:.6rem;padding:1.1rem 1.5rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);}
    .pc-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.65rem 1.4rem;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .pc-btn-primary{background:var(--accent);color:#fff;}
    .pc-btn-primary:hover{background:var(--accent-lt);color:#fff;transform:translateY(-1px);}
    .pc-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}
    .pc-btn-ghost:hover{border-color:var(--accent);color:var(--accent);}
    .pc-file-upload{border:2px dashed var(--border);border-radius:10px;padding:1.25rem;background:var(--surface);cursor:pointer;transition:border-color .2s,background .2s;position:relative;text-align:center;}
    .pc-file-upload:hover{border-color:var(--accent);background:#c9a96e06;}
    .pc-file-upload input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
    .pc-file-selected{display:none;align-items:center;gap:.75rem;padding:.85rem 1rem;border:1px solid #bbf7d0;border-radius:8px;background:#f0fdf4;margin-top:.75rem;}
    .pc-file-selected.visible{display:flex;}
    @media(max-width:900px){.pc-layout{grid-template-columns:1fr;}.pc-side{position:static;}.pc-row-2{grid-template-columns:1fr;}}
</style>

<div class="pc-page">
    <nav class="pc-breadcrumb">
        <a href="{{ route('admin.professionals.index') }}">Professionals</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">Add New</span>
    </nav>

    <div class="pc-heading">
        <div class="pc-heading-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 20V8l-10-6L2 8v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2z"/><path d="M6 20v-8l6-4 6 4v8"/><path d="M19 8v6m-3-3h6" style="display:none"/></svg>
        </div>
        <div>
            <h4>Add New Professional</h4>
            <p>A login account will be auto-created and credentials emailed.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="pc-alert pc-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div><strong>Please fix the following errors:</strong><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
    @endif
    @if(session('success'))
        <div class="pc-alert pc-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.professionals.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="pc-layout">
            <div class="pc-main">

                {{-- Account & Identity --}}
                <div class="pc-card">
                    <div class="pc-card-header">
                        <div class="pc-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
                        <h6>Account &amp; Identity</h6>
                    </div>
                    <div class="pc-card-body">
                        <div style="display:flex;align-items:flex-start;gap:.65rem;padding:.85rem 1rem;border-radius:8px;background:#eff6ff;border:1px solid #bfdbfe;font-size:.82rem;color:#1d4ed8;margin-bottom:1.25rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                            <span>A <strong>login account</strong> will be created automatically. Credentials will be emailed to the address below.</span>
                        </div>
                        <div class="pc-row-2">
                            <div>
                                <label class="pc-label">Full Name <span class="req">*</span></label>
                                <input type="text" name="full_name" id="fullNameInput" class="pc-input @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" oninput="syncPreview()" placeholder="e.g. Dr. Alice Uwimana" required>
                                @error('full_name')<p class="pc-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="pc-label">Email <span class="req">*</span></label>
                                <input type="email" name="email" id="emailInput" class="pc-input @error('email') is-invalid @enderror" value="{{ old('email') }}" oninput="syncPreview()" placeholder="alice@firm.com" required>
                                <p class="pc-hint">Login credentials sent here.</p>
                                @error('email')<p class="pc-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div style="margin-top:1rem;">
                            <label class="pc-label">Phone <span class="req">*</span></label>
                            <div class="pc-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <input type="text" name="phone" class="pc-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+250 7XX XXX XXX" required>
                            </div>
                            @error('phone')<p class="pc-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Professional Details --}}
                <div class="pc-card">
                    <div class="pc-card-header">
                        <div class="pc-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                        <h6>Professional Details</h6>
                    </div>
                    <div class="pc-card-body">
                        <div class="pc-gap">
                            <div class="pc-row-2">
                                <div>
                                    <label class="pc-label">Profession</label>
                                    <input type="text" name="profession" class="pc-input @error('profession') is-invalid @enderror" value="{{ old('profession') }}" placeholder="e.g. Architect, Lawyer, Valuer">
                                    @error('profession')<p class="pc-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="pc-label">License / Registration No.</label>
                                    <input type="text" name="license_number" class="pc-input @error('license_number') is-invalid @enderror" value="{{ old('license_number') }}" placeholder="e.g. RWA-ARCH-001">
                                    @error('license_number')<p class="pc-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="pc-row-2">
                                <div>
                                    <label class="pc-label">Years of Experience</label>
                                    <input type="number" name="years_experience" class="pc-input @error('years_experience') is-invalid @enderror" value="{{ old('years_experience',0) }}" min="0" max="50">
                                    @error('years_experience')<p class="pc-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="pc-label">Office Location</label>
                                    <div class="pc-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                        <input type="text" name="office_location" class="pc-input @error('office_location') is-invalid @enderror" value="{{ old('office_location') }}" placeholder="e.g. Kigali, KN 5 Rd">
                                    </div>
                                    @error('office_location')<p class="pc-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="pc-row-2">
                                <div>
                                    <label class="pc-label">Languages</label>
                                    <input type="text" name="languages" class="pc-input @error('languages') is-invalid @enderror" value="{{ old('languages') }}" placeholder="English, French, Kinyarwanda">
                                    <p class="pc-hint">Comma-separated.</p>
                                    @error('languages')<p class="pc-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="pc-label">WhatsApp</label>
                                    <div class="pc-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                        <input type="text" name="whatsapp" class="pc-input @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp') }}" placeholder="+250 7XX XXX XXX">
                                    </div>
                                    @error('whatsapp')<p class="pc-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div>
                                <label class="pc-label">Services Offered</label>
                                <input type="text" name="services" class="pc-input @error('services') is-invalid @enderror" value="{{ old('services') }}" placeholder="e.g. Property Valuation, Legal Conveyancing, Site Plans">
                                <p class="pc-hint">Brief comma-separated list.</p>
                                @error('services')<p class="pc-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="pc-label">Rating</label>
                                <div style="display:flex;align-items:center;gap:1rem;">
                                    <div class="pc-stars">
                                        @for($i=5;$i>=1;$i--)
                                            <input type="radio" name="_star" id="star{{$i}}" value="{{$i}}" {{ old('rating',5)==$i?'checked':'' }} onchange="document.getElementById('ratingInput').value=this.value;document.getElementById('ratingLabel').textContent=this.value+' / 5'">
                                            <label for="star{{$i}}">★</label>
                                        @endfor
                                    </div>
                                    <span id="ratingLabel" style="font-size:.82rem;color:var(--text-dim)">5 / 5</span>
                                </div>
                                <input type="number" name="rating" id="ratingInput" class="pc-input @error('rating') is-invalid @enderror" value="{{ old('rating',5) }}" min="0" max="5" step="0.1" style="max-width:120px;margin-top:.4rem" oninput="document.getElementById('ratingLabel').textContent=this.value+' / 5'">
                                @error('rating')<p class="pc-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="pc-label">Bio</label>
                                <textarea name="bio" rows="4" class="pc-textarea @error('bio') is-invalid @enderror" placeholder="Professional background, expertise, notable projects…">{{ old('bio') }}</textarea>
                                @error('bio')<p class="pc-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Portfolio & Links --}}
                <div class="pc-card">
                    <div class="pc-card-header">
                        <div class="pc-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg></div>
                        <h6>Portfolio &amp; Links</h6>
                    </div>
                    <div class="pc-card-body">
                        <div class="pc-gap">
                            <div>
                                <label class="pc-label">LinkedIn</label>
                                <div class="pc-social-row">
                                    <div class="pc-social-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#0a66c2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg></div>
                                    <input type="url" name="linkedin" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/…">
                                </div>
                                @error('linkedin')<p class="pc-error">{{ $message }}</p>@enderror
                            </div>
                            <div class="pc-row-2">
                                <div>
                                    <label class="pc-label">Website / Portfolio URL</label>
                                    <div class="pc-social-row">
                                        <div class="pc-social-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></div>
                                        <input type="url" name="portfolio_url" value="{{ old('portfolio_url') }}" placeholder="https://yourportfolio.com">
                                    </div>
                                    @error('portfolio_url')<p class="pc-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="pc-label">Website</label>
                                    <div class="pc-social-row">
                                        <div class="pc-social-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></div>
                                        <input type="url" name="website" value="{{ old('website') }}" placeholder="https://website.com">
                                    </div>
                                    @error('website')<p class="pc-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div>
                                <label class="pc-label">Credentials Document</label>
                                <div class="pc-file-upload" id="credDropzone">
                                    <input type="file" name="credentials_doc" id="credInput" accept=".pdf,.jpg,.jpeg,.png">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--accent);margin-bottom:.4rem"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    <p style="font-size:.84rem;font-weight:600;color:var(--text);margin:0 0 .2rem">Drop credentials document</p>
                                    <p style="font-size:.75rem;color:var(--muted);margin:0">PDF, JPG, PNG — max 5MB</p>
                                </div>
                                <div class="pc-file-selected" id="credSelected">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--green);flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
                                    <span id="credFileName" style="font-size:.83rem;color:var(--text)">—</span>
                                </div>
                                @error('credentials_doc')<p class="pc-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pc-submit-bar">
                    <a href="{{ route('admin.professionals.index') }}" class="pc-btn pc-btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                        Cancel
                    </a>
                    <button type="submit" class="pc-btn pc-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        Create &amp; Send Credentials
                    </button>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="pc-side">
                <div class="pc-card">
                    <div class="pc-card-header">
                        <div class="pc-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg></div>
                        <h6>Profile Photo</h6>
                    </div>
                    <div class="pc-card-body">
                        <div class="pc-img-upload" id="imgUploadZone">
                            <input type="file" name="profile_image" id="profileImageInput" accept="image/jpg,image/jpeg,image/png,image/webp">
                            <img id="imgPreview" class="pc-img-preview" src="" alt="Preview">
                            <div class="pc-img-placeholder" id="imgPlaceholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            </div>
                            <p style="font-size:.83rem;font-weight:600;color:var(--text);margin:0 0 .2rem">Upload photo</p>
                            <p style="font-size:.74rem;color:var(--muted);margin:0">JPG, PNG, WEBP — max 2MB</p>
                        </div>
                        @error('profile_image')<p class="pc-error" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="pc-preview-card">
                    <div class="pc-preview-banner"></div>
                    <div class="pc-preview-body">
                        <div class="pc-preview-avatar-wrap">
                            <div class="pc-preview-avatar" id="previewAvatar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            </div>
                        </div>
                        <p class="pc-preview-name" id="previewName" style="color:var(--muted);font-style:italic;font-weight:400;">Enter name…</p>
                        <p class="pc-preview-email" id="previewEmail">—</p>
                        <p class="pc-preview-role">Professional · Terra</p>
                    </div>
                </div>

                <div class="pc-card">
                    <div class="pc-card-header">
                        <div class="pc-card-header-icon" style="background:#eff6ff;color:var(--blue);"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
                        <h6>Password &amp; Access</h6>
                    </div>
                    <div class="pc-card-body">
                        <div class="pc-toggle-row" style="padding-top:0;">
                            <div><div class="pc-toggle-label">Auto-generate password</div><div class="pc-toggle-desc">Secure via Hash::make()</div></div>
                            <label class="pc-switch"><input type="checkbox" name="auto_password" id="autoPass" value="1" checked onchange="togglePass()"><span class="pc-switch-track"></span></label>
                        </div>
                        <div id="customPassWrap" style="display:none;margin-top:.85rem;">
                            <label class="pc-label">Custom Password</label>
                            <input type="password" name="custom_password" class="pc-input" placeholder="Min. 8 characters" minlength="8" autocomplete="new-password">
                        </div>
                        <div class="pc-toggle-row">
                            <div><div class="pc-toggle-label">Send credentials by email</div><div class="pc-toggle-desc">Email login + password</div></div>
                            <label class="pc-switch"><input type="checkbox" name="send_credentials" value="1" checked><span class="pc-switch-track"></span></label>
                        </div>
                        <div class="pc-toggle-row">
                            <div><div class="pc-toggle-label">Mark as verified</div><div class="pc-toggle-desc">Skip email verification</div></div>
                            <label class="pc-switch"><input type="checkbox" name="is_verified" value="1" checked><span class="pc-switch-track"></span></label>
                        </div>
                        <div style="margin-top:.85rem;padding:.75rem;border-radius:8px;background:#f0fdf4;border:1px solid #bbf7d0;font-size:.78rem;color:#166534;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;margin-right:.3rem"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                            Password hashed with <strong>Hash::make()</strong>
                        </div>
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
    const initials=name.split(/\s+/).map(w=>w[0]?.toUpperCase()??'').slice(0,2).join('');
    const avatar=document.getElementById('previewAvatar');
    const pName=document.getElementById('previewName');
    if(initials){avatar.textContent=initials;avatar.style.fontSize='1rem';pName.textContent=name;pName.style.cssText='font-size:.92rem;font-weight:700;color:var(--text);margin:0 0 .15rem;';}
    else{avatar.innerHTML='<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>';pName.textContent='Enter name…';pName.style.cssText='color:var(--muted);font-style:italic;font-weight:400;';}
    document.getElementById('previewEmail').textContent=email||'—';
}
function togglePass(){
    const auto=document.getElementById('autoPass').checked;
    document.getElementById('customPassWrap').style.display=auto?'none':'block';
}
document.getElementById('profileImageInput').addEventListener('change',function(){
    const file=this.files[0];if(!file)return;
    const reader=new FileReader();
    reader.onload=e=>{
        const preview=document.getElementById('imgPreview');
        preview.src=e.target.result;preview.style.display='block';
        document.getElementById('imgPlaceholder').style.display='none';
    };
    reader.readAsDataURL(file);
});
document.getElementById('credInput').addEventListener('change',function(){
    const file=this.files[0];
    document.getElementById('credFileName').textContent=file?file.name:'—';
    document.getElementById('credSelected').classList.toggle('visible',!!file);
});
document.querySelectorAll('.pc-stars input').forEach(r=>{
    r.addEventListener('change',()=>{
        document.getElementById('ratingInput').value=r.value;
        document.getElementById('ratingLabel').textContent=r.value+' / 5';
    });
});
</script>
@endsection