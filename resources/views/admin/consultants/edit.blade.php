{{-- ================================================================
     SAVE AS: resources/views/admin/consultants/edit.blade.php
     ================================================================ --}}
@extends('layouts.app')
@section('title', 'Edit Consultant — ' . $consultant->name)
@section('content')

<style>
    :root{--accent:#c9a96e;--accent-lt:#e4c990;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--teal:#0d9488;--blue:#3b82f6;--green:#22c55e;}
    .ce-page{padding:1.75rem 0 3rem;max-width:1060px;margin:0 auto;}
    .ce-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);margin-bottom:1.5rem;}
    .ce-breadcrumb a{color:var(--muted);text-decoration:none;}.ce-breadcrumb a:hover{color:var(--teal);}
    .ce-heading{display:flex;align-items:center;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;}
    .ce-heading-avatar{width:48px;height:48px;border-radius:50%;flex-shrink:0;background:linear-gradient(135deg,var(--teal),#14b8a6);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1rem;color:#fff;border:2px solid rgba(13,148,136,.3);overflow:hidden;}
    .ce-heading-avatar img{width:100%;height:100%;object-fit:cover;}
    .ce-heading h4{font-size:1.2rem;font-weight:700;color:var(--text);margin:0;}
    .ce-heading p{font-size:.82rem;color:var(--text-dim);margin:.15rem 0 0;}
    .ce-heading-meta{margin-left:auto;display:flex;align-items:center;gap:.6rem;}
    .ce-layout{display:grid;grid-template-columns:1fr 280px;gap:1.25rem;align-items:start;}
    .ce-main{display:flex;flex-direction:column;gap:1.25rem;}
    .ce-side{display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:80px;}
    .ce-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .ce-card-header{display:flex;align-items:center;gap:.75rem;padding:1rem 1.5rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .ce-card-header-icon{width:32px;height:32px;border-radius:8px;background:#0d948818;display:flex;align-items:center;justify-content:center;color:var(--teal);flex-shrink:0;}
    .ce-card-header h6{margin:0;font-size:.88rem;font-weight:600;color:var(--text);}
    .ce-card-body{padding:1.5rem;}
    .ce-label{display:block;font-size:.77rem;font-weight:600;letter-spacing:.03em;color:var(--text-dim);text-transform:uppercase;margin-bottom:.45rem;}
    .ce-label .req{color:var(--danger);margin-left:.2rem;}
    .ce-input,.ce-select,.ce-textarea{width:100%;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.875rem;color:var(--text);background:#fff;outline:none;font-family:inherit;transition:border-color .2s,box-shadow .2s;}
    .ce-input:focus,.ce-select:focus,.ce-textarea:focus{border-color:var(--teal);box-shadow:0 0 0 3px rgba(13,148,136,.12);}
    .ce-input.is-invalid{border-color:var(--danger);}
    .ce-textarea{resize:vertical;line-height:1.65;}
    .ce-hint{font-size:.73rem;color:var(--muted);margin-top:.35rem;}
    .ce-error{font-size:.73rem;color:var(--danger);margin-top:.35rem;display:flex;align-items:center;gap:.3rem;}
    .ce-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
    .ce-gap{display:flex;flex-direction:column;gap:1rem;}
    .ce-cat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:.5rem;}
    .ce-cat-check{display:none;}
    .ce-cat-label{display:flex;align-items:center;gap:.5rem;padding:.55rem .85rem;border:1.5px solid var(--border);border-radius:8px;font-size:.8rem;color:var(--text-dim);cursor:pointer;transition:all .15s;user-select:none;font-weight:400;}
    .ce-cat-check:checked+.ce-cat-label{border-color:var(--teal);background:#f0fdfa;color:var(--teal);font-weight:500;}
    .ce-cat-dot{width:8px;height:8px;border-radius:50%;border:2px solid currentColor;flex-shrink:0;}
    .ce-cat-check:checked+.ce-cat-label .ce-cat-dot{background:var(--teal);border-color:var(--teal);}
    .ce-current-photo{display:flex;align-items:center;gap:.85rem;padding:.85rem 1rem;border:1px solid var(--border);border-radius:8px;background:var(--surface);margin-bottom:.85rem;}
    .ce-current-photo img{width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid var(--border);flex-shrink:0;}
    .ce-current-initials{width:48px;height:48px;border-radius:50%;flex-shrink:0;background:linear-gradient(135deg,var(--teal),#14b8a6);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.9rem;color:#fff;}
    .ce-img-upload{border:2px dashed var(--border);border-radius:10px;padding:1.25rem;background:var(--surface);cursor:pointer;transition:border-color .2s,background .2s;position:relative;text-align:center;}
    .ce-img-upload:hover{border-color:var(--teal);background:#f0fdfa05;}
    .ce-img-upload input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
    .ce-new-preview{display:none;border-radius:8px;overflow:hidden;margin-top:.75rem;position:relative;}
    .ce-new-preview img{width:100%;max-height:140px;object-fit:cover;display:block;}
    .ce-new-preview-remove{position:absolute;top:5px;right:5px;width:22px;height:22px;border-radius:50%;background:rgba(0,0,0,.6);border:none;color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:10px;}
    .ce-preview-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .ce-preview-banner{height:56px;background:linear-gradient(135deg,#0d948825,#14b8a615);border-bottom:1px solid var(--border);}
    .ce-preview-body{padding:0 1.25rem 1.25rem;}
    .ce-preview-avatar-wrap{margin-top:-24px;margin-bottom:.65rem;}
    .ce-preview-avatar{width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--teal),#14b8a6);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.95rem;color:#fff;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.1);overflow:hidden;}
    .ce-preview-avatar img{width:100%;height:100%;object-fit:cover;}
    .ce-preview-name{font-size:.92rem;font-weight:700;color:var(--text);margin:0 0 .15rem;}
    .ce-preview-email{font-size:.74rem;color:var(--muted);word-break:break-all;margin-bottom:.35rem;}
    .ce-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:flex-start;margin-bottom:1.25rem;}
    .ce-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .ce-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .ce-alert ul{margin:.35rem 0 0 1rem;padding:0;}
    .ce-alert li{margin-bottom:.2rem;}
    .ce-submit-bar{display:flex;align-items:center;justify-content:space-between;gap:.75rem;padding:1.1rem 1.5rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);}
    .ce-submit-bar-left{font-size:.78rem;color:var(--muted);display:flex;align-items:center;gap:.4rem;}
    .ce-submit-bar-right{display:flex;gap:.6rem;}
    .ce-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.65rem 1.4rem;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .ce-btn-primary{background:var(--teal);color:#fff;}.ce-btn-primary:hover{background:#0f766e;color:#fff;transform:translateY(-1px);}
    .ce-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.ce-btn-ghost:hover{border-color:var(--teal);color:var(--teal);}
    .ce-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}.ce-btn-danger:hover{background:#fef2f2;}
    .ce-btn-blue{background:none;border:1.5px solid #bfdbfe;color:var(--blue);}.ce-btn-blue:hover{background:#eff6ff;}
    .ce-btn-sm{padding:.42rem .9rem;font-size:.78rem;}
    @media(max-width:900px){.ce-layout{grid-template-columns:1fr;}.ce-side{position:static;}.ce-row-2{grid-template-columns:1fr;}}
</style>

<div class="ce-page">
    <nav class="ce-breadcrumb">
        <a href="{{ route('admin.consultants.index') }}">Consultants</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <a href="{{ route('admin.consultants.show',$consultant->id) }}">{{ $consultant->name }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">Edit</span>
    </nav>

    <div class="ce-heading">
        <div class="ce-heading-avatar">
            @if($consultant->photo)<img src="{{ asset('storage/'.$consultant->photo) }}" alt="{{ $consultant->name }}">
            @else{{ strtoupper(substr($consultant->name,0,2)) }}@endif
        </div>
        <div>
            <h4>Edit Consultant</h4>
            <p>{{ $consultant->name }} — last updated {{ $consultant->updated_at->diffForHumans() }}</p>
        </div>
        <div class="ce-heading-meta">
            <a href="{{ route('admin.consultants.show',$consultant->id) }}" class="ce-btn ce-btn-ghost ce-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                View
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="ce-alert ce-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div><strong>Please fix the following errors:</strong><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
    @endif
    @if(session('success'))
        <div class="ce-alert ce-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.consultants.update',$consultant->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="ce-layout">
            <div class="ce-main">

                {{-- Account --}}
                <div class="ce-card">
                    <div class="ce-card-header">
                        <div class="ce-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
                        <h6>Account Details</h6>
                    </div>
                    <div class="ce-card-body">
                        <div class="ce-row-2">
                            <div>
                                <label class="ce-label">Full Name <span class="req">*</span></label>
                                <input type="text" name="name" id="nameInput" class="ce-input @error('name') is-invalid @enderror" value="{{ old('name',$consultant->name) }}" oninput="syncPreview()" required>
                                @error('name')<p class="ce-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="ce-label">Email <span class="req">*</span></label>
                                <input type="email" name="email" id="emailInput" class="ce-input @error('email') is-invalid @enderror" value="{{ old('email',$consultant->email) }}" oninput="syncPreview()" required>
                                <p class="ce-hint">Also updates login email.</p>
                                @error('email')<p class="ce-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Profile --}}
                <div class="ce-card">
                    <div class="ce-card-header">
                        <div class="ce-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                        <h6>Profile Details</h6>
                    </div>
                    <div class="ce-card-body">
                        <div class="ce-gap">
                            <div class="ce-row-2">
                                <div>
                                    <label class="ce-label">Title / Role <span class="req">*</span></label>
                                    <input type="text" name="title" class="ce-input @error('title') is-invalid @enderror" value="{{ old('title',$consultant->title) }}" required>
                                    @error('title')<p class="ce-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="ce-label">Phone <span class="req">*</span></label>
                                    <input type="text" name="phone" class="ce-input @error('phone') is-invalid @enderror" value="{{ old('phone',$consultant->phone) }}" required>
                                    @error('phone')<p class="ce-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div>
                                <label class="ce-label">Company / Firm</label>
                                <input type="text" name="company" class="ce-input @error('company') is-invalid @enderror" value="{{ old('company',$consultant->company) }}" placeholder="e.g. Terra Advisory Ltd">
                                @error('company')<p class="ce-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="ce-label">Bio</label>
                                <textarea name="bio" rows="4" class="ce-textarea @error('bio') is-invalid @enderror">{{ old('bio',$consultant->bio) }}</textarea>
                                @error('bio')<p class="ce-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Service Categories --}}
                <div class="ce-card">
                    <div class="ce-card-header">
                        <div class="ce-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg></div>
                        <h6>Service Categories</h6>
                    </div>
                    <div class="ce-card-body">
                        @php $currentCats = old('service_categories',$consultant->serviceCategories->pluck('id')->toArray()); @endphp
                        <div class="ce-cat-grid">
                            @foreach($serviceCategories as $cat)
                                <input type="checkbox" name="service_categories[]" id="cat{{ $cat->id }}" value="{{ $cat->id }}" class="ce-cat-check" {{ in_array($cat->id,$currentCats)?'checked':'' }}>
                                <label for="cat{{ $cat->id }}" class="ce-cat-label"><span class="ce-cat-dot"></span>{{ $cat->name }}</label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="ce-submit-bar">
                    <div class="ce-submit-bar-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Last saved {{ $consultant->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                    <div class="ce-submit-bar-right">
                        <a href="{{ route('admin.consultants.show',$consultant->id) }}" class="ce-btn ce-btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                            Cancel
                        </a>
                        <button type="submit" class="ce-btn ce-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="ce-side">
                {{-- Photo --}}
                <div class="ce-card">
                    <div class="ce-card-header">
                        <div class="ce-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg></div>
                        <h6>Profile Photo</h6>
                    </div>
                    <div class="ce-card-body">
                        @if($consultant->photo)
                            <div class="ce-current-photo">
                                <img src="{{ asset('storage/'.$consultant->photo) }}" alt="{{ $consultant->name }}">
                                <div><strong style="display:block;font-size:.83rem;color:var(--text)">Current photo</strong><span style="font-size:.73rem;color:var(--muted)">Upload below to replace</span></div>
                            </div>
                        @else
                            <div class="ce-current-photo">
                                <div class="ce-current-initials">{{ strtoupper(substr($consultant->name,0,2)) }}</div>
                                <div><strong style="display:block;font-size:.83rem;color:var(--text)">No photo set</strong><span style="font-size:.73rem;color:var(--muted)">Upload one below</span></div>
                            </div>
                        @endif
                        <div class="ce-img-upload">
                            <input type="file" name="photo" id="photoInput" accept="image/*">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--teal);margin-bottom:.4rem"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            <p style="font-size:.83rem;font-weight:600;color:var(--text);margin:0 0 .2rem">{{ $consultant->photo ? 'Replace photo' : 'Upload photo' }}</p>
                            <p style="font-size:.74rem;color:var(--muted);margin:0">JPG, PNG, WEBP — max 2MB</p>
                        </div>
                        <div class="ce-new-preview" id="newPreviewBox">
                            <img id="newPreviewImg" src="" alt="New preview">
                            <button type="button" class="ce-new-preview-remove" onclick="clearPhoto()">✕</button>
                        </div>
                        @error('photo')<p class="ce-error" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Live preview --}}
                <div class="ce-preview-card">
                    <div class="ce-preview-banner"></div>
                    <div class="ce-preview-body">
                        <div class="ce-preview-avatar-wrap">
                            <div class="ce-preview-avatar" id="previewAvatar">
                                @if($consultant->photo)<img id="previewAvatarImg" src="{{ asset('storage/'.$consultant->photo) }}" alt="{{ $consultant->name }}">
                                @else<span id="previewAvatarInitials">{{ strtoupper(substr($consultant->name,0,2)) }}</span>@endif
                            </div>
                        </div>
                        <p class="ce-preview-name" id="previewName">{{ $consultant->name }}</p>
                        <p class="ce-preview-email" id="previewEmail">{{ $consultant->email }}</p>
                        <p class="ce-preview-role">{{ $consultant->title ?? 'Consultant' }} · Terra</p>
                    </div>
                </div>

                {{-- Password reset --}}
                <div class="ce-card">
                    <div class="ce-card-header">
                        <div class="ce-card-header-icon" style="background:#eff6ff;color:var(--blue);"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
                        <h6>Password</h6>
                    </div>
                    <div class="ce-card-body">
                        <p style="font-size:.81rem;color:var(--muted);margin-bottom:.85rem;line-height:1.55;">Generate a new secure password and email it to <strong>{{ $consultant->email }}</strong>.</p>
                        @if($consultant->user)
                            <form method="POST" action="{{ route('admin.consultants.reset-password',$consultant->id) }}">
                                @csrf
                                <button type="submit" class="ce-btn ce-btn-blue" style="width:100%;justify-content:center;" onclick="return confirm('Reset password and send to {{ $consultant->email }}?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                    Reset &amp; Email
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- Danger zone --}}
                <div class="ce-card" style="border-color:#fecaca;">
                    <div class="ce-card-header" style="background:#fef2f2;border-color:#fecaca;">
                        <div class="ce-card-header-icon" style="background:#fee2e2;color:var(--danger);"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/></svg></div>
                        <h6 style="color:var(--danger)">Danger Zone</h6>
                    </div>
                    <div class="ce-card-body">
                        <p style="font-size:.8rem;color:var(--muted);margin-bottom:.85rem;line-height:1.55;">Deletes this consultant and their login account.</p>
                        <form method="POST" action="{{ route('admin.consultants.destroy',$consultant->id) }}" onsubmit="return confirm('Delete {{ $consultant->name }}? Cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="ce-btn ce-btn-danger" style="width:100%;justify-content:center;font-size:.82rem;padding:.55rem 1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                Delete Consultant
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
    const name=document.getElementById('nameInput').value.trim();
    const email=document.getElementById('emailInput').value.trim();
    const initials=name.split(/\s+/).map(w=>w[0]?.toUpperCase()??'').slice(0,2).join('')||'??';
    document.getElementById('previewName').textContent=name||'—';
    document.getElementById('previewEmail').textContent=email||'—';
    const initEl=document.getElementById('previewAvatarInitials');
    if(initEl)initEl.textContent=initials;
}
document.getElementById('photoInput').addEventListener('change',function(){
    const file=this.files[0];if(!file)return;
    const reader=new FileReader();
    reader.onload=e=>{
        document.getElementById('newPreviewImg').src=e.target.result;
        document.getElementById('newPreviewBox').style.display='block';
        document.getElementById('previewAvatar').innerHTML='<img src="'+e.target.result+'" style="width:100%;height:100%;object-fit:cover;">';
    };reader.readAsDataURL(file);
});
function clearPhoto(){
    document.getElementById('photoInput').value='';
    document.getElementById('newPreviewBox').style.display='none';
    @if($consultant->photo)
    document.getElementById('previewAvatar').innerHTML='<img src="{{ asset('storage/'.$consultant->photo) }}" style="width:100%;height:100%;object-fit:cover;">';
    @else
    document.getElementById('previewAvatar').innerHTML='<span id="previewAvatarInitials">{{ strtoupper(substr($consultant->name,0,2)) }}</span>';
    @endif
}
</script>
@endsection
