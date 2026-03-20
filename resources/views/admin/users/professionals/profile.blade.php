@extends('layouts.app')
@section('title', $professional->full_name . ' — Professional Profile')
@section('content')

<style>
    :root{--accent:#c9a96e;--accent-lt:#e4c990;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--blue:#3b82f6;--purple:#7c3aed;--green:#22c55e;}
    .ps-page{padding:1.75rem 0 3rem;max-width:1160px;margin:0 auto;}
    .ps-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);margin-bottom:1.5rem;}
    .ps-breadcrumb a{color:var(--muted);text-decoration:none;transition:color .15s;}
    .ps-breadcrumb a:hover{color:var(--accent);}
    .ps-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:center;margin-bottom:1.25rem;}
    .ps-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .ps-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .ps-alert-warning{background:#fffbeb;border:1px solid #fde68a;color:#92400e;}
    .ps-layout{display:grid;grid-template-columns:300px 1fr;gap:1.25rem;align-items:start;}
    .ps-left{display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:80px;}
    .ps-right{display:flex;flex-direction:column;gap:1.25rem;}
    .ps-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.6rem 1.2rem;border-radius:8px;font-size:.84rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .ps-btn-primary{background:var(--accent);color:#fff;}.ps-btn-primary:hover{background:var(--accent-lt);color:#fff;}
    .ps-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.ps-btn-ghost:hover{border-color:var(--accent);color:var(--accent);}
    .ps-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}.ps-btn-danger:hover{background:#fef2f2;}
    .ps-btn-blue{background:none;border:1.5px solid #bfdbfe;color:var(--blue);}.ps-btn-blue:hover{background:#eff6ff;}
    .ps-btn-sm{padding:.38rem .85rem;font-size:.78rem;}
    .ps-profile-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .ps-profile-banner{height:90px;position:relative;background:linear-gradient(135deg,#7c3aed30,#a855f720,#7c3aed12);border-bottom:1px solid var(--border);}
    .ps-profile-banner::after{content:'';position:absolute;inset:0;background:repeating-linear-gradient(45deg,transparent,transparent 20px,rgba(124,58,237,.04) 20px,rgba(124,58,237,.04) 40px);}
    .ps-profile-body{padding:0 1.5rem 1.5rem;}
    .ps-profile-avatar-wrap{margin-top:-32px;margin-bottom:1rem;position:relative;z-index:1;}
    .ps-profile-avatar{width:64px;height:64px;border-radius:50%;object-fit:cover;border:3px solid #fff;box-shadow:0 2px 12px rgba(0,0,0,.12);display:block;}
    .ps-profile-avatar-initials{width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--purple),#a855f7);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.2rem;color:#fff;border:3px solid #fff;box-shadow:0 2px 12px rgba(0,0,0,.12);}
    .ps-verified{display:inline-flex;align-items:center;gap:.3rem;padding:.22rem .65rem;border-radius:100px;font-size:.7rem;font-weight:600;background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;margin-bottom:.85rem;}
    .ps-profile-name{font-size:1.05rem;font-weight:700;color:var(--text);margin:0 0 .2rem;}
    .ps-profile-role{font-size:.8rem;color:var(--text-dim);margin:0 0 .75rem;}
    .ps-rating{display:flex;align-items:center;gap:.3rem;margin-bottom:.85rem;}
    .ps-star{color:#fbbf24;font-size:1rem;}
    .ps-star.empty{color:var(--border);}
    .ps-rating-val{font-size:.82rem;font-weight:600;color:var(--text-dim);margin-left:.2rem;}
    .ps-contact-list{display:flex;flex-direction:column;gap:.5rem;}
    .ps-contact-item{display:flex;align-items:center;gap:.6rem;font-size:.82rem;color:var(--text-dim);text-decoration:none;transition:color .15s;}
    .ps-contact-item:hover{color:var(--accent);}
    .ps-contact-icon{width:28px;height:28px;border-radius:7px;background:var(--surface);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--muted);}
    .ps-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .ps-card-header{display:flex;align-items:center;gap:.75rem;padding:.9rem 1.4rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .ps-card-header-icon{width:30px;height:30px;border-radius:7px;background:#c9a96e18;display:flex;align-items:center;justify-content:center;color:var(--accent);flex-shrink:0;}
    .ps-card-header h6{margin:0;font-size:.86rem;font-weight:600;color:var(--text);}
    .ps-card-action{margin-left:auto;}
    .ps-card-body{padding:1.4rem;}
    .ps-info-grid{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--border);border:1px solid var(--border);border-radius:8px;overflow:hidden;}
    .ps-info-cell{background:#fff;padding:.85rem 1rem;transition:background .15s;}
    .ps-info-cell:hover{background:var(--surface);}
    .ps-info-key{font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-bottom:.3rem;}
    .ps-info-val{font-size:.88rem;color:var(--text);font-weight:500;}
    .ps-info-val.accent{color:var(--accent);}
    .ps-info-val.muted{color:var(--muted);font-weight:400;font-style:italic;}
    .ps-bio{font-size:.9rem;color:var(--text-dim);line-height:1.8;}
    .ps-no-content{font-size:.84rem;color:var(--muted);font-style:italic;}
    .ps-lang-chips{display:flex;flex-wrap:wrap;gap:.4rem;}
    .ps-lang-chip{padding:.24rem .7rem;border-radius:100px;font-size:.74rem;font-weight:600;background:#f5f3ff;border:1px solid #ddd6fe;color:var(--purple);}
    .ps-service-chips{display:flex;flex-wrap:wrap;gap:.4rem;}
    .ps-service-chip{padding:.24rem .7rem;border-radius:100px;font-size:.74rem;font-weight:500;background:#c9a96e0d;border:1px solid #c9a96e30;color:var(--accent);}
    .ps-action-btn{display:flex;align-items:center;gap:.6rem;padding:.65rem .9rem;border-radius:8px;border:1.5px solid var(--border);background:none;font-family:inherit;font-size:.82rem;font-weight:500;cursor:pointer;transition:all .15s;color:var(--text-dim);text-align:left;width:100%;text-decoration:none;}
    .ps-action-btn:hover{border-color:var(--accent);color:var(--text);background:#c9a96e06;}
    .ps-action-btn.blue:hover{border-color:#bfdbfe;color:var(--blue);background:#eff6ff;}
    .ps-action-btn.danger:hover{border-color:#fecaca;color:var(--danger);background:#fef2f2;}
    .ps-actions-list{display:flex;flex-direction:column;gap:.5rem;}
    .ps-tl{display:flex;flex-direction:column;}
    .ps-tl-item{display:flex;gap:1rem;padding-bottom:1.25rem;}
    .ps-tl-item:last-child{padding-bottom:0;}
    .ps-tl-left{display:flex;flex-direction:column;align-items:center;flex-shrink:0;}
    .ps-tl-dot{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid var(--border);background:#fff;color:var(--muted);flex-shrink:0;}
    .ps-tl-dot.accent{border-color:var(--accent);background:#c9a96e12;color:var(--accent);}
    .ps-tl-dot.blue{border-color:#bfdbfe;background:#eff6ff;color:var(--blue);}
    .ps-tl-dot.purple{border-color:#ddd6fe;background:#f5f3ff;color:var(--purple);}
    .ps-tl-line{width:1px;flex:1;background:var(--border);margin-top:4px;min-height:16px;}
    .ps-tl-item:last-child .ps-tl-line{display:none;}
    .ps-tl-content{flex:1;padding-top:.2rem;}
    .ps-tl-title{font-size:.86rem;font-weight:600;color:var(--text);}
    .ps-tl-meta{font-size:.76rem;color:var(--muted);margin-top:.2rem;}
    .ps-social-link{display:flex;align-items:center;gap:.75rem;font-size:.83rem;color:var(--text-dim);text-decoration:none;transition:color .15s;padding:.5rem .75rem;border-radius:8px;border:1px solid var(--border);margin-bottom:.5rem;}
    .ps-social-link:last-child{margin-bottom:0;}
    .ps-social-link:hover{border-color:var(--accent);color:var(--accent);background:#c9a96e06;}
    .ps-doc-row{display:flex;align-items:center;gap:.85rem;padding:.85rem 1rem;border:1px solid var(--border);border-radius:8px;background:var(--surface);}
    .ps-doc-icon{width:38px;height:38px;border-radius:8px;background:#fef2f2;display:flex;align-items:center;justify-content:center;color:var(--danger);flex-shrink:0;}
    .ps-modal .modal-content{border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 8px 32px rgba(0,0,0,.12);overflow:hidden;}
    .ps-modal .modal-header{background:var(--surface);border-bottom:1px solid var(--border);padding:1rem 1.4rem;display:flex;align-items:center;gap:.75rem;}
    .ps-modal-icon{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .ps-modal-icon.danger{background:#fef2f2;color:var(--danger);}
    .ps-modal-icon.blue{background:#eff6ff;color:var(--blue);}
    .ps-modal .modal-title{font-size:.92rem;font-weight:700;color:var(--text);margin:0;}
    .ps-modal .modal-body{padding:1.4rem;}
    .ps-modal .modal-footer{padding:.85rem 1.4rem;border-top:1px solid var(--border);gap:.5rem;}
    .ps-delete-box{font-size:.87rem;color:var(--text-dim);line-height:1.6;padding:.85rem 1rem;border-radius:8px;border:1px solid #fecaca;background:#fef2f2;}
    .ps-delete-box strong{color:var(--text);}
    @media(max-width:960px){.ps-layout{grid-template-columns:1fr;}.ps-left{position:static;}.ps-info-grid{grid-template-columns:1fr;}}
</style>

<div class="ps-page">
    <nav class="ps-breadcrumb">
        <a href="{{ route('admin.professionals.index') }}">Professionals</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">{{ $professional->full_name }}</span>
    </nav>

    @foreach(['success','error','warning'] as $type)
        @if(session($type))
            <div class="ps-alert ps-alert-{{ $type === 'error' ? 'danger' : ($type === 'warning' ? 'warning' : 'success') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">@if($type==='success')<path d="M20 6 9 17l-5-5"/>@else<circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>@endif</svg>
                {{ session($type) }}
            </div>
        @endif
    @endforeach

    <div class="ps-layout">
        {{-- Left --}}
        <div class="ps-left">
            <div class="ps-profile-card">
                <div class="ps-profile-banner"></div>
                <div class="ps-profile-body">
                    <div class="ps-profile-avatar-wrap">
                        @if($professional->profile_image)
                            <img src="{{ asset('storage/'.$professional->profile_image) }}" alt="{{ $professional->full_name }}" class="ps-profile-avatar">
                        @else
                            <div class="ps-profile-avatar-initials">{{ strtoupper(substr($professional->full_name,0,2)) }}</div>
                        @endif
                    </div>
                    @if($professional->is_verified)
                        <div class="ps-verified"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>Verified Professional</div>
                    @endif
                    <h5 class="ps-profile-name">{{ $professional->full_name }}</h5>
                    <p class="ps-profile-role">{{ $professional->profession ?? 'Professional' }} · Terra</p>
                    <div class="ps-rating">
                        @for($i=1;$i<=5;$i++)
                            <span class="ps-star {{ $i<=round($professional->rating)?'':'empty' }}">★</span>
                        @endfor
                        <span class="ps-rating-val">{{ number_format($professional->rating,1) }} / 5</span>
                    </div>
                    <div class="ps-contact-list">
                        @if($professional->email)
                            <a href="mailto:{{ $professional->email }}" class="ps-contact-item">
                                <div class="ps-contact-icon"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></div>
                                {{ $professional->email }}
                            </a>
                        @endif
                        @if($professional->phone)
                            <a href="tel:{{ $professional->phone }}" class="ps-contact-item">
                                <div class="ps-contact-icon"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
                                {{ $professional->phone }}
                            </a>
                        @endif
                        @if($professional->office_location)
                            <div class="ps-contact-item">
                                <div class="ps-contact-icon"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg></div>
                                {{ $professional->office_location }}
                            </div>
                        @endif
                    </div>
                    <div style="display:flex;gap:.5rem;margin-top:1.1rem;padding-top:1rem;border-top:1px solid var(--border);">
                        <a href="{{ route('admin.professionals.edit',$professional->id) }}" class="ps-btn ps-btn-primary ps-btn-sm" style="flex:1;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </a>
                        <button class="ps-btn ps-btn-danger ps-btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" style="flex:1;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                            Remove
                        </button>
                    </div>
                </div>
            </div>

            <div class="ps-card">
                <div class="ps-card-header">
                    <div class="ps-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg></div>
                    <h6>Quick Actions</h6>
                </div>
                <div class="ps-card-body">
                    <div class="ps-actions-list">
                        <a href="mailto:{{ $professional->email }}" class="ps-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            Send Email
                        </a>
                        @if($professional->phone)
                            <a href="tel:{{ $professional->phone }}" class="ps-action-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                Call
                            </a>
                        @endif
                        @if($professional->user)
                            <button class="ps-action-btn blue" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Reset Password
                            </button>
                        @endif
                        <form method="POST" action="{{ route('admin.professionals.toggle-verified',$professional->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="ps-action-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                                {{ $professional->is_verified ? 'Remove Verification' : 'Mark as Verified' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.professionals.edit',$professional->id) }}" class="ps-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right --}}
        <div class="ps-right">

            {{-- Details grid --}}
            <div class="ps-card">
                <div class="ps-card-header">
                    <div class="ps-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                    <h6>Professional Details</h6>
                    <a href="{{ route('admin.professionals.edit',$professional->id) }}" class="ps-card-action ps-btn ps-btn-ghost ps-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </a>
                </div>
                <div class="ps-card-body" style="padding:0">
                    <div class="ps-info-grid">
                        <div class="ps-info-cell"><div class="ps-info-key">Full Name</div><div class="ps-info-val">{{ $professional->full_name }}</div></div>
                        <div class="ps-info-cell"><div class="ps-info-key">Email</div><div class="ps-info-val" style="font-size:.83rem"><a href="mailto:{{ $professional->email }}" style="color:var(--accent);text-decoration:none">{{ $professional->email }}</a></div></div>
                        <div class="ps-info-cell"><div class="ps-info-key">Phone</div><div class="ps-info-val"><a href="tel:{{ $professional->phone }}" style="color:var(--text);text-decoration:none">{{ $professional->phone }}</a></div></div>
                        <div class="ps-info-cell"><div class="ps-info-key">WhatsApp</div><div class="ps-info-val">{{ $professional->whatsapp ?? '—' }}</div></div>
                        <div class="ps-info-cell"><div class="ps-info-key">Profession</div><div class="ps-info-val accent">{{ $professional->profession ?? '—' }}</div></div>
                        <div class="ps-info-cell"><div class="ps-info-key">License No.</div><div class="ps-info-val" style="font-family:monospace;font-size:.83rem">{{ $professional->license_number ?? '—' }}</div></div>
                        <div class="ps-info-cell"><div class="ps-info-key">Experience</div><div class="ps-info-val accent">{{ $professional->years_experience }} yr{{ $professional->years_experience != 1 ? 's':'' }}</div></div>
                        <div class="ps-info-cell"><div class="ps-info-key">Rating</div><div class="ps-info-val"><span style="color:#f59e0b">★</span> {{ number_format($professional->rating,1) }} / 5</div></div>
                        <div class="ps-info-cell"><div class="ps-info-key">Office</div><div class="ps-info-val">{{ $professional->office_location ?? '—' }}</div></div>
                        <div class="ps-info-cell"><div class="ps-info-key">Verified</div><div class="ps-info-val"><span style="color:{{ $professional->is_verified ? 'var(--green)':'var(--muted)' }};font-size:.82rem">{{ $professional->is_verified ? '✓ Verified':'Unverified' }}</span></div></div>
                    </div>
                </div>
            </div>

            {{-- Services --}}
            @if($professional->services)
                <div class="ps-card">
                    <div class="ps-card-header">
                        <div class="ps-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg></div>
                        <h6>Services Offered</h6>
                    </div>
                    <div class="ps-card-body">
                        <div class="ps-service-chips">
                            @foreach(array_map('trim',explode(',',$professional->services)) as $svc)
                                @if($svc)<span class="ps-service-chip">{{ $svc }}</span>@endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Languages --}}
            @if($professional->languages)
                <div class="ps-card">
                    <div class="ps-card-header">
                        <div class="ps-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 8 6 6"/><path d="m4 14 6-6 2-3"/><path d="M2 5h12"/><path d="M7 2h1"/><path d="m22 22-5-10-5 10"/><path d="M14 18h6"/></svg></div>
                        <h6>Languages</h6>
                    </div>
                    <div class="ps-card-body">
                        <div class="ps-lang-chips">
                            @foreach(array_map('trim',explode(',',$professional->languages)) as $lang)
                                @if($lang)<span class="ps-lang-chip">{{ $lang }}</span>@endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Bio --}}
            <div class="ps-card">
                <div class="ps-card-header">
                    <div class="ps-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" x2="3" y1="10" y2="10"/><line x1="21" x2="3" y1="6" y2="6"/><line x1="21" x2="3" y1="14" y2="14"/><line x1="13" x2="3" y1="18" y2="18"/></svg></div>
                    <h6>Bio</h6>
                </div>
                <div class="ps-card-body">
                    @if($professional->bio)<p class="ps-bio">{{ $professional->bio }}</p>
                    @else<p class="ps-no-content">No bio provided.</p>@endif
                </div>
            </div>

            {{-- Credentials doc --}}
            @if($professional->credentials_doc)
                <div class="ps-card">
                    <div class="ps-card-header">
                        <div class="ps-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                        <h6>Credentials Document</h6>
                    </div>
                    <div class="ps-card-body">
                        <div class="ps-doc-row">
                            <div class="ps-doc-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                            <div style="flex:1;min-width:0"><strong style="display:block;font-size:.83rem;color:var(--text)">{{ basename($professional->credentials_doc) }}</strong><span style="font-size:.73rem;color:var(--muted)">Uploaded credentials document</span></div>
                            <a href="{{ asset('storage/'.$professional->credentials_doc) }}" target="_blank" class="ps-btn ps-btn-ghost ps-btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Portfolio & Links --}}
            @if($professional->linkedin || $professional->portfolio_url || $professional->website)
                <div class="ps-card">
                    <div class="ps-card-header">
                        <div class="ps-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg></div>
                        <h6>Links</h6>
                    </div>
                    <div class="ps-card-body">
                        @if($professional->linkedin)
                            <a href="{{ $professional->linkedin }}" target="_blank" class="ps-social-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#0a66c2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
                                LinkedIn
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left:auto;opacity:.4"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                            </a>
                        @endif
                        @if($professional->portfolio_url)
                            <a href="{{ $professional->portfolio_url }}" target="_blank" class="ps-social-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                Portfolio
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left:auto;opacity:.4"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                            </a>
                        @endif
                        @if($professional->website)
                            <a href="{{ $professional->website }}" target="_blank" class="ps-social-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                Website
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left:auto;opacity:.4"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Timeline --}}
            <div class="ps-card">
                <div class="ps-card-header">
                    <div class="ps-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                    <h6>Activity</h6>
                </div>
                <div class="ps-card-body">
                    <div class="ps-tl">
                        <div class="ps-tl-item">
                            <div class="ps-tl-left"><div class="ps-tl-dot accent"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg></div><div class="ps-tl-line"></div></div>
                            <div class="ps-tl-content"><div class="ps-tl-title">Profile created</div><div class="ps-tl-meta">{{ $professional->created_at->format('F j, Y') }} — {{ $professional->created_at->diffForHumans() }}</div></div>
                        </div>
                        @if($professional->user)
                            <div class="ps-tl-item">
                                <div class="ps-tl-left"><div class="ps-tl-dot blue"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div><div class="ps-tl-line"></div></div>
                                <div class="ps-tl-content"><div class="ps-tl-title">Login account created</div><div class="ps-tl-meta">{{ $professional->user->created_at->format('F j, Y') }}</div></div>
                            </div>
                        @endif
                        @if($professional->is_verified)
                            <div class="ps-tl-item">
                                <div class="ps-tl-left"><div class="ps-tl-dot purple"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg></div><div class="ps-tl-line"></div></div>
                                <div class="ps-tl-content"><div class="ps-tl-title">Verified professional</div><div class="ps-tl-meta">Marked as verified on the platform</div></div>
                            </div>
                        @endif
                        <div class="ps-tl-item">
                            <div class="ps-tl-left"><div class="ps-tl-dot"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></div></div>
                            <div class="ps-tl-content"><div class="ps-tl-title">Last updated</div><div class="ps-tl-meta">{{ $professional->updated_at->format('F j, Y') }} — {{ $professional->updated_at->diffForHumans() }}</div></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Danger zone --}}
            <div class="ps-card" style="border-color:#fecaca;">
                <div class="ps-card-header" style="background:#fef2f2;border-color:#fecaca;">
                    <div class="ps-card-header-icon" style="background:#fee2e2;color:var(--danger);"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg></div>
                    <h6 style="color:var(--danger)">Danger Zone</h6>
                </div>
                <div class="ps-card-body">
                    <p style="font-size:.82rem;color:var(--muted);margin-bottom:1rem;line-height:1.55;">Permanently deletes this professional and their login account.</p>
                    <button class="ps-btn ps-btn-danger" style="width:100%;justify-content:center;" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                        Delete Professional
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Reset Password Modal --}}
<div class="modal fade ps-modal" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.professionals.reset-password',$professional->id) }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <div class="ps-modal-icon blue"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div style="display:flex;align-items:flex-start;gap:.65rem;padding:.85rem 1rem;border-radius:8px;background:#eff6ff;border:1px solid #bfdbfe;font-size:.83rem;color:#1d4ed8;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                    <span>A new password via <strong>Hash::make()</strong> will be generated and emailed to <strong>{{ $professional->email }}</strong>.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ps-btn ps-btn-ghost ps-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="ps-btn ps-btn-sm" style="background:var(--blue);color:#fff;border:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    Reset &amp; Send
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade ps-modal" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.professionals.destroy',$professional->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="ps-modal-icon danger"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg></div>
                <h5 class="modal-title" style="color:var(--danger)">Delete Professional</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="ps-delete-box">Permanently delete <strong>{{ $professional->full_name }}</strong> and their login account? All associated records will be affected.<br><br><span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ps-btn ps-btn-ghost ps-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="ps-btn ps-btn-danger ps-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

@endsection