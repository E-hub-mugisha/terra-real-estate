@extends('layouts.app')
@section('title', $consultant->name . ' — Consultant Profile')
@section('content')

<style>
    :root{--accent:#c9a96e;--accent-lt:#e4c990;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--blue:#3b82f6;--teal:#0d9488;--green:#22c55e;}
    .cs-page{padding:1.75rem 0 3rem;max-width:1160px;margin:0 auto;}
    .cs-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);margin-bottom:1.5rem;}
    .cs-breadcrumb a{color:var(--muted);text-decoration:none;}.cs-breadcrumb a:hover{color:var(--teal);}
    .cs-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:center;margin-bottom:1.25rem;}
    .cs-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .cs-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .cs-layout{display:grid;grid-template-columns:300px 1fr;gap:1.25rem;align-items:start;}
    .cs-left{display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:80px;}
    .cs-right{display:flex;flex-direction:column;gap:1.25rem;}
    .cs-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.6rem 1.2rem;border-radius:8px;font-size:.84rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .cs-btn-primary{background:var(--teal);color:#fff;}.cs-btn-primary:hover{background:#0f766e;color:#fff;}
    .cs-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.cs-btn-ghost:hover{border-color:var(--teal);color:var(--teal);}
    .cs-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}.cs-btn-danger:hover{background:#fef2f2;}
    .cs-btn-blue{background:none;border:1.5px solid #bfdbfe;color:var(--blue);}.cs-btn-blue:hover{background:#eff6ff;}
    .cs-btn-sm{padding:.38rem .85rem;font-size:.78rem;}
    /* Profile card */
    .cs-profile-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .cs-profile-banner{height:90px;background:linear-gradient(135deg,#0d948830,#14b8a620,#0d948818);border-bottom:1px solid var(--border);position:relative;}
    .cs-profile-banner::after{content:'';position:absolute;inset:0;background:repeating-linear-gradient(45deg,transparent,transparent 20px,rgba(13,148,136,.04) 20px,rgba(13,148,136,.04) 40px);}
    .cs-profile-body{padding:0 1.5rem 1.5rem;}
    .cs-profile-avatar-wrap{margin-top:-32px;margin-bottom:1rem;position:relative;z-index:1;}
    .cs-profile-avatar{width:64px;height:64px;border-radius:50%;object-fit:cover;border:3px solid #fff;box-shadow:0 2px 12px rgba(0,0,0,.12);display:block;}
    .cs-profile-avatar-initials{width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--teal),#14b8a6);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.2rem;color:#fff;border:3px solid #fff;box-shadow:0 2px 12px rgba(0,0,0,.12);}
    .cs-profile-name{font-size:1.05rem;font-weight:700;color:var(--text);margin:0 0 .2rem;}
    .cs-title-badge{display:inline-flex;align-items:center;padding:.22rem .65rem;border-radius:100px;font-size:.72rem;font-weight:600;background:#f0fdfa;border:1px solid #99f6e4;color:var(--teal);margin-bottom:.75rem;}
    .cs-contact-list{display:flex;flex-direction:column;gap:.5rem;}
    .cs-contact-item{display:flex;align-items:center;gap:.6rem;font-size:.82rem;color:var(--text-dim);text-decoration:none;transition:color .15s;}
    .cs-contact-item:hover{color:var(--teal);}
    .cs-contact-icon{width:28px;height:28px;border-radius:7px;background:var(--surface);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--muted);}
    /* Cards */
    .cs-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .cs-card-header{display:flex;align-items:center;gap:.75rem;padding:.9rem 1.4rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .cs-card-header-icon{width:30px;height:30px;border-radius:7px;background:#0d948818;display:flex;align-items:center;justify-content:center;color:var(--teal);flex-shrink:0;}
    .cs-card-header h6{margin:0;font-size:.86rem;font-weight:600;color:var(--text);}
    .cs-card-action{margin-left:auto;}
    .cs-card-body{padding:1.4rem;}
    /* Info grid */
    .cs-info-grid{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--border);border:1px solid var(--border);border-radius:8px;overflow:hidden;}
    .cs-info-cell{background:#fff;padding:.85rem 1rem;transition:background .15s;}
    .cs-info-cell:hover{background:var(--surface);}
    .cs-info-key{font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-bottom:.3rem;}
    .cs-info-val{font-size:.88rem;color:var(--text);font-weight:500;}
    .cs-info-val.teal{color:var(--teal);}
    .cs-info-val.muted{color:var(--muted);font-weight:400;font-style:italic;}
    /* Categories */
    .cs-cat-chips{display:flex;flex-wrap:wrap;gap:.4rem;}
    .cs-cat-chip{padding:.24rem .7rem;border-radius:100px;font-size:.74rem;font-weight:500;background:#c9a96e0d;border:1px solid #c9a96e30;color:var(--accent);}
    /* Bio */
    .cs-bio{font-size:.9rem;color:var(--text-dim);line-height:1.8;}
    .cs-no-content{font-size:.84rem;color:var(--muted);font-style:italic;}
    /* Actions */
    .cs-action-btn{display:flex;align-items:center;gap:.6rem;padding:.65rem .9rem;border-radius:8px;border:1.5px solid var(--border);background:none;font-family:inherit;font-size:.82rem;font-weight:500;cursor:pointer;transition:all .15s;color:var(--text-dim);text-align:left;width:100%;text-decoration:none;}
    .cs-action-btn:hover{border-color:var(--teal);color:var(--text);background:#f0fdfa;}
    .cs-action-btn.blue:hover{border-color:#bfdbfe;color:var(--blue);background:#eff6ff;}
    .cs-action-btn.danger:hover{border-color:#fecaca;color:var(--danger);background:#fef2f2;}
    .cs-actions-list{display:flex;flex-direction:column;gap:.5rem;}
    /* Timeline */
    .cs-tl{display:flex;flex-direction:column;}
    .cs-tl-item{display:flex;gap:1rem;padding-bottom:1.25rem;}
    .cs-tl-item:last-child{padding-bottom:0;}
    .cs-tl-left{display:flex;flex-direction:column;align-items:center;flex-shrink:0;}
    .cs-tl-dot{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid var(--border);background:#fff;color:var(--muted);flex-shrink:0;}
    .cs-tl-dot.teal{border-color:#99f6e4;background:#f0fdfa;color:var(--teal);}
    .cs-tl-dot.blue{border-color:#bfdbfe;background:#eff6ff;color:var(--blue);}
    .cs-tl-line{width:1px;flex:1;background:var(--border);margin-top:4px;min-height:16px;}
    .cs-tl-item:last-child .cs-tl-line{display:none;}
    .cs-tl-content{flex:1;padding-top:.2rem;}
    .cs-tl-title{font-size:.86rem;font-weight:600;color:var(--text);}
    .cs-tl-meta{font-size:.76rem;color:var(--muted);margin-top:.2rem;}
    /* Modals */
    .cs-modal .modal-content{border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 8px 32px rgba(0,0,0,.12);overflow:hidden;}
    .cs-modal .modal-header{background:var(--surface);border-bottom:1px solid var(--border);padding:1rem 1.4rem;display:flex;align-items:center;gap:.75rem;}
    .cs-modal-icon{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .cs-modal-icon.danger{background:#fef2f2;color:var(--danger);}
    .cs-modal-icon.blue{background:#eff6ff;color:var(--blue);}
    .cs-modal .modal-title{font-size:.92rem;font-weight:700;color:var(--text);margin:0;}
    .cs-modal .modal-body{padding:1.4rem;}
    .cs-modal .modal-footer{padding:.85rem 1.4rem;border-top:1px solid var(--border);gap:.5rem;}
    .cs-delete-box{font-size:.87rem;color:var(--text-dim);line-height:1.6;padding:.85rem 1rem;border-radius:8px;border:1px solid #fecaca;background:#fef2f2;}
    .cs-delete-box strong{color:var(--text);}
    @media(max-width:960px){.cs-layout{grid-template-columns:1fr;}.cs-left{position:static;}.cs-info-grid{grid-template-columns:1fr;}}
</style>

<div class="cs-page">
    <nav class="cs-breadcrumb">
        <a href="{{ route('admin.consultants.index') }}">Consultants</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">{{ $consultant->name }}</span>
    </nav>

    @if(session('success'))
        <div class="cs-alert cs-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="cs-alert cs-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="cs-layout">

        {{-- ── LEFT ── --}}
        <div class="cs-left">

            <div class="cs-profile-card">
                <div class="cs-profile-banner"></div>
                <div class="cs-profile-body">
                    <div class="cs-profile-avatar-wrap">
                        @if($consultant->photo)
                            <img src="{{asset('image/consultant/')}}/{{ $consultant->photo }}"
                                 alt="{{ $consultant->name }}" class="cs-profile-avatar">
                        @else
                            <div class="cs-profile-avatar-initials">
                                {{ strtoupper(substr($consultant->name,0,2)) }}
                            </div>
                        @endif
                    </div>
                    <h5 class="cs-profile-name">{{ $consultant->name }}</h5>
                    @if($consultant->title)
                        <div class="cs-title-badge">{{ $consultant->title }}</div>
                    @endif

                    <div class="cs-contact-list" style="margin-bottom:.85rem;">
                        <a href="mailto:{{ $consultant->email }}" class="cs-contact-item">
                            <div class="cs-contact-icon"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></div>
                            {{ $consultant->email }}
                        </a>
                        @if($consultant->phone)
                            <a href="tel:{{ $consultant->phone }}" class="cs-contact-item">
                                <div class="cs-contact-icon"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
                                {{ $consultant->phone }}
                            </a>
                        @endif
                        @if($consultant->company)
                            <div class="cs-contact-item">
                                <div class="cs-contact-icon"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M12 6h.01M12 10h.01M8 10h.01M16 10h.01M8 14h.01M16 14h.01M12 14h.01"/></svg></div>
                                {{ $consultant->company }}
                            </div>
                        @endif
                    </div>

                    <div style="display:flex;gap:.5rem;padding-top:1rem;border-top:1px solid var(--border);">
                        <a href="{{ route('admin.consultants.edit',$consultant->id) }}"
                           class="cs-btn cs-btn-primary cs-btn-sm" style="flex:1;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </a>
                        <button class="cs-btn cs-btn-danger cs-btn-sm"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                style="flex:1;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                            Remove
                        </button>
                    </div>
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="cs-card">
                <div class="cs-card-header">
                    <div class="cs-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg></div>
                    <h6>Quick Actions</h6>
                </div>
                <div class="cs-card-body">
                    <div class="cs-actions-list">
                        <a href="mailto:{{ $consultant->email }}" class="cs-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            Send Email
                        </a>
                        @if($consultant->phone)
                            <a href="tel:{{ $consultant->phone }}" class="cs-action-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                Call
                            </a>
                        @endif
                        @if($consultant->user)
                            <button class="cs-action-btn blue" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Reset Password
                            </button>
                        @endif
                        <a href="{{ route('admin.consultants.edit',$consultant->id) }}" class="cs-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>

        </div>{{-- /.cs-left --}}

        {{-- ── RIGHT ── --}}
        <div class="cs-right">

            {{-- Details grid --}}
            <div class="cs-card">
                <div class="cs-card-header">
                    <div class="cs-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                    <h6>Consultant Details</h6>
                    <a href="{{ route('admin.consultants.edit',$consultant->id) }}" class="cs-card-action cs-btn cs-btn-ghost cs-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </a>
                </div>
                <div class="cs-card-body" style="padding:0">
                    <div class="cs-info-grid">
                        <div class="cs-info-cell"><div class="cs-info-key">Full Name</div><div class="cs-info-val">{{ $consultant->name }}</div></div>
                        <div class="cs-info-cell"><div class="cs-info-key">Email</div><div class="cs-info-val" style="font-size:.83rem"><a href="mailto:{{ $consultant->email }}" style="color:var(--teal);text-decoration:none">{{ $consultant->email }}</a></div></div>
                        <div class="cs-info-cell"><div class="cs-info-key">Phone</div><div class="cs-info-val"><a href="tel:{{ $consultant->phone }}" style="color:var(--text);text-decoration:none">{{ $consultant->phone ?? '—' }}</a></div></div>
                        <div class="cs-info-cell"><div class="cs-info-key">Title</div><div class="cs-info-val teal">{{ $consultant->title ?? '—' }}</div></div>
                        <div class="cs-info-cell"><div class="cs-info-key">Company</div><div class="cs-info-val">{{ $consultant->company ?? '—' }}</div></div>
                        <div class="cs-info-cell"><div class="cs-info-key">Account</div><div class="cs-info-val">
                            @if($consultant->user)
                                <span style="color:var(--green);font-size:.82rem;font-weight:500;">✓ Linked ({{ $consultant->user->email }})</span>
                            @else
                                <span style="color:var(--muted);font-size:.82rem;">No account</span>
                            @endif
                        </div></div>
                        <div class="cs-info-cell"><div class="cs-info-key">Created</div><div class="cs-info-val" style="font-size:.83rem">{{ $consultant->created_at->format('M j, Y') }}</div></div>
                        <div class="cs-info-cell"><div class="cs-info-key">Last Updated</div><div class="cs-info-val" style="font-size:.83rem">{{ $consultant->updated_at->diffForHumans() }}</div></div>
                    </div>
                </div>
            </div>

            {{-- Service categories --}}
            <div class="cs-card">
                <div class="cs-card-header">
                    <div class="cs-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg></div>
                    <h6>Service Categories</h6>
                </div>
                <div class="cs-card-body">
                    @if($consultant->serviceCategories->count())
                        <div class="cs-cat-chips">
                            @foreach($consultant->serviceCategories as $cat)
                                <span class="cs-cat-chip">{{ $cat->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="cs-no-content">No service categories assigned.</p>
                    @endif
                </div>
            </div>

            {{-- Bio --}}
            <div class="cs-card">
                <div class="cs-card-header">
                    <div class="cs-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" x2="3" y1="10" y2="10"/><line x1="21" x2="3" y1="6" y2="6"/><line x1="21" x2="3" y1="14" y2="14"/><line x1="13" x2="3" y1="18" y2="18"/></svg></div>
                    <h6>Bio</h6>
                </div>
                <div class="cs-card-body">
                    @if($consultant->bio)
                        <p class="cs-bio">{{ $consultant->bio }}</p>
                    @else
                        <p class="cs-no-content">No bio provided.</p>
                    @endif
                </div>
            </div>

            {{-- Activity timeline --}}
            <div class="cs-card">
                <div class="cs-card-header">
                    <div class="cs-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                    <h6>Activity</h6>
                </div>
                <div class="cs-card-body">
                    <div class="cs-tl">
                        <div class="cs-tl-item">
                            <div class="cs-tl-left">
                                <div class="cs-tl-dot teal"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg></div>
                                <div class="cs-tl-line"></div>
                            </div>
                            <div class="cs-tl-content">
                                <div class="cs-tl-title">Consultant profile created</div>
                                <div class="cs-tl-meta">{{ $consultant->created_at->format('F j, Y') }} — {{ $consultant->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @if($consultant->user)
                            <div class="cs-tl-item">
                                <div class="cs-tl-left">
                                    <div class="cs-tl-dot blue"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
                                    <div class="cs-tl-line"></div>
                                </div>
                                <div class="cs-tl-content">
                                    <div class="cs-tl-title">Login account created</div>
                                    <div class="cs-tl-meta">{{ $consultant->user->created_at->format('F j, Y') }} — {{ $consultant->user->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endif
                        @if($consultant->serviceCategories->count())
                            <div class="cs-tl-item">
                                <div class="cs-tl-left">
                                    <div class="cs-tl-dot"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/></svg></div>
                                    <div class="cs-tl-line"></div>
                                </div>
                                <div class="cs-tl-content">
                                    <div class="cs-tl-title">{{ $consultant->serviceCategories->count() }} service {{ Str::plural('category', $consultant->serviceCategories->count()) }} assigned</div>
                                    <div class="cs-tl-meta">{{ $consultant->serviceCategories->pluck('name')->join(', ') }}</div>
                                </div>
                            </div>
                        @endif
                        <div class="cs-tl-item">
                            <div class="cs-tl-left">
                                <div class="cs-tl-dot"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></div>
                            </div>
                            <div class="cs-tl-content">
                                <div class="cs-tl-title">Last profile update</div>
                                <div class="cs-tl-meta">{{ $consultant->updated_at->format('F j, Y') }} — {{ $consultant->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Danger zone --}}
            <div class="cs-card" style="border-color:#fecaca;">
                <div class="cs-card-header" style="background:#fef2f2;border-color:#fecaca;">
                    <div class="cs-card-header-icon" style="background:#fee2e2;color:var(--danger);"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg></div>
                    <h6 style="color:var(--danger)">Danger Zone</h6>
                </div>
                <div class="cs-card-body">
                    <p style="font-size:.82rem;color:var(--muted);margin-bottom:1rem;line-height:1.55;">
                        Permanently deletes this consultant profile, their service category associations, and login account.
                    </p>
                    <button class="cs-btn cs-btn-danger" style="width:100%;justify-content:center;"
                            data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                        Delete Consultant
                    </button>
                </div>
            </div>

        </div>{{-- /.cs-right --}}
    </div>
</div>

{{-- Reset Password Modal --}}
<div class="modal fade cs-modal" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.consultants.reset-password',$consultant->id) }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <div class="cs-modal-icon blue"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div style="display:flex;align-items:flex-start;gap:.65rem;padding:.85rem 1rem;border-radius:8px;background:#eff6ff;border:1px solid #bfdbfe;font-size:.83rem;color:#1d4ed8;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                    <span>A new secure password will be generated via <strong>Hash::make()</strong> and emailed to <strong>{{ $consultant->email }}</strong>. The current password will stop working immediately.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="cs-btn cs-btn-ghost cs-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="cs-btn cs-btn-sm" style="background:var(--blue);color:#fff;border:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    Reset &amp; Send
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade cs-modal" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.consultants.destroy',$consultant->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="cs-modal-icon danger"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg></div>
                <h5 class="modal-title" style="color:var(--danger)">Delete Consultant</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="cs-delete-box">
                    Permanently delete <strong>{{ $consultant->name }}</strong> and their linked login account? All service category associations will be removed.
                    <br><br>
                    <span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="cs-btn cs-btn-ghost cs-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="cs-btn cs-btn-danger cs-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

@endsection