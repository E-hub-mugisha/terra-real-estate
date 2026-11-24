@extends('layouts.app')
@section('title', 'My Profile')

@section('content')

<style>
    @@keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }

    .profile-card {
        animation: fadeIn .25s ease;
        background: #FFFFFF;
        border-radius: 12px;
        border: 1px solid #EAEBF0;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .sec-title {
        font-family: 'Cormorant Garamond', serif;
        color: #19265D;
        font-size: 1rem;
        font-weight: 700;
        padding-bottom: .4rem;
        border-bottom: 1.5px solid #F6F6F9;
        margin-bottom: 1.25rem;
    }

    .avatar-circle {
        width: 72px; height: 72px;
        border-radius: 50%;
        background: #F6F6F9;
        color: #19265D;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem; font-weight: 700;
        flex-shrink: 0;
        border: 2px solid #DADCE5;
    }

    .stat-box {
        background: #FFFFFF;
        border-radius: 8px;
        padding: .85rem 1rem;
        text-align: center;
    }
    .stat-box .num  { font-size: 1.4rem; font-weight: 700; color: #19265D; line-height: 1.2; }
    .stat-box .lbl  { font-size: .72rem; color: #636B91; margin-top: .15rem; }

    .pill {
        display: inline-flex; align-items: center;
        padding: .2rem .65rem; border-radius: 999px;
        font-size: .72rem; font-weight: 600;
    }
    .pill-active   { background: #EAEBF0; color: #19265D; }
    .pill-inactive { background: #F6F6F9; color: #636B91; }
    .pill-admin    { background: #F6F6F9; color: #19265D; }
    .pill-user     { background: #EAEBF0; color: #19265D; }

    .info-row {
        display: grid; grid-template-columns: 140px 1fr;
        gap: .2rem .75rem; font-size: .875rem; align-items: start;
    }
    .info-row dt { color: #636B91; font-weight: 500; padding: .35rem 0; }
    .info-row dd { color: #19265D; padding: .35rem 0; margin: 0; word-break: break-all; }

    .nav-tabs .nav-link          { color: #636B91; border: none; border-bottom: 2px solid transparent; padding: .5rem 1rem; font-size: .875rem; font-weight: 500; }
    .nav-tabs .nav-link:hover    { color: #19265D; border-bottom-color: #EAEBF0; background: transparent; }
    .nav-tabs .nav-link.active   { color: #19265D; border-bottom: 2px solid #D05208; background: transparent; font-weight: 700; }
    .nav-tabs { border-bottom: 1px solid #EAEBF0; margin-bottom: 1.25rem; }

    .recent-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: .6rem 0; border-bottom: 1px solid #F6F6F9; font-size: .85rem;
    }
    .recent-item:last-child { border-bottom: none; }
    .recent-item .ri-title   { color: #19265D; font-weight: 500; }
    .recent-item .ri-meta    { color: #A3A8BE; font-size: .75rem; margin-top: 1px; }
    .recent-item .ri-badge   { font-size: .7rem; padding: .15rem .5rem; border-radius: 999px; }

    .danger-zone {
        border: 1px solid #FDF6F3;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        background: #FFFFFF;
    }
</style>

<div class="container py-4" style="max-width:900px">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ── Header ─────────────────────────────────────────────────────── --}}
    <div class="profile-card">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="avatar-circle">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(Str::contains(Auth::user()->name, ' ') ? explode(' ', Auth::user()->name)[1] : '', 0, 1)) }}
            </div>
            <div class="flex-grow-1">
                <h2 style="font-family:'Cormorant Garamond',serif;color:#19265D;font-size:1.5rem;margin-bottom:.15rem">
                    {{ Auth::user()->name }}
                </h2>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="text-muted small">{{ Auth::user()->email }}</span>
                    <span class="pill {{ Auth::user()->is_admin ? 'pill-admin' : 'pill-user' }}">
                        {{ Auth::user()->is_admin ? 'Admin' : 'Member' }}
                    </span>
                    <span class="pill {{ Auth::user()->email_verified_at ? 'pill-active' : 'pill-inactive' }}">
                        {{ Auth::user()->email_verified_at ? 'Verified' : 'Unverified' }}
                    </span>
                </div>
                <p class="text-muted small mb-0 mt-1">
                    Member since {{ Auth::user()->created_at->format('F Y') }}
                </p>
            </div>
        </div>

        {{-- Stats row --}}
        <div class="row g-2 mt-3">
            <div class="col-6 col-md-4">
                <div class="stat-box">
                    <div class="num">{{ $stats['houses'] }}</div>
                    <div class="lbl">Houses listed</div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="stat-box">
                    <div class="num">{{ $stats['lands'] }}</div>
                    <div class="lbl">Lands listed</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="stat-box">
                    <div class="num">{{ $stats['designs'] }}</div>
                    <div class="lbl">Designs</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Tabs: Info / Security / Danger ─────────────────────────────── --}}
    <ul class="nav nav-tabs" id="profileTabs">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-info">Account info</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-security">Security</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-activity">Recent activity</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-danger">Danger zone</a></li>
    </ul>

    <div class="tab-content">

        {{-- ── TAB: Account info ───────────────────────────────────────── --}}
        <div class="tab-pane fade show active" id="tab-info">
            <div class="profile-card">
                <div class="sec-title">Personal information</div>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem">Full name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem">Email address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem">Phone number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', Auth::user()->phone) }}" placeholder="+250 7XX XXX XXX">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem">WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror"
                                value="{{ old('whatsapp', Auth::user()->whatsapp) }}" placeholder="+250 7XX XXX XXX">
                            @error('whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem">Province</label>
                            <input type="text" name="province" class="form-control" value="{{ old('province', Auth::user()->province) }}" placeholder="e.g. Kigali City">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem">District</label>
                            <input type="text" name="district" class="form-control" value="{{ old('district', Auth::user()->district) }}" placeholder="e.g. Gasabo">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold" style="font-size:.875rem">About you <span class="text-muted fw-normal">(shown to people you message)</span></label>
                            <textarea name="bio" rows="3" maxlength="1000" class="form-control @error('bio') is-invalid @enderror">{{ old('bio', Auth::user()->bio) }}</textarea>
                            @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        @if (Auth::user()->isPartner())
                            @php $pp = Auth::user()->partnerProfile; @endphp
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:.875rem">Company <span class="text-muted fw-normal">(optional)</span></label>
                                <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $pp?->company_name) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:.875rem">Areas you cover</label>
                                <input type="text" name="areas" class="form-control" value="{{ old('areas', $pp?->areas) }}" placeholder="e.g. Gasabo, Kicukiro">
                            </div>
                            <div class="col-12"><span class="badge text-bg-light">Partner status: {{ ucfirst($pp?->status ?? 'pending') }}</span></div>
                        @endif
                    <div class="mt-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-sm px-4 fw-semibold"
                            style="background:#19265D;color:#FFFFFF;border-radius:8px">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>

            {{-- Read-only account details --}}
            <div class="profile-card">
                <div class="sec-title">Account details</div>
                <dl class="info-row">
                    <dt>User ID</dt>
                    <dd><code>#{{ Auth::user()->id }}</code></dd>

                    <dt>Role</dt>
                    <dd>
                        <span class="pill {{ Auth::user()->is_admin ? 'pill-admin' : 'pill-user' }}">
                            {{ Auth::user()->is_admin ? 'Administrator' : 'Member' }}
                        </span>
                    </dd>

                    <dt>Email verified</dt>
                    <dd>
                        @if(Auth::user()->email_verified_at)
                            <span class="pill pill-active">Verified</span>
                            <span class="text-muted small ms-1">{{ Auth::user()->email_verified_at->format('d M Y') }}</span>
                        @else
                            <span class="pill pill-inactive">Not verified</span>
                            <form method="POST" action="{{ route('verification.send') }}" class="d-inline ms-2">
                                @csrf
                                <button class="btn btn-link btn-sm p-0 text-decoration-underline" style="font-size:.8rem;color:#D05208">
                                    Resend verification email
                                </button>
                            </form>
                        @endif
                    </dd>

                    <dt>Joined</dt>
                    <dd>{{ Auth::user()->created_at->format('d M Y, H:i') }}</dd>

                    <dt>Last updated</dt>
                    <dd>{{ Auth::user()->updated_at->format('d M Y, H:i') }}</dd>

                    @if(Auth::user()->last_seen_at)
                    <dt>Last active</dt>
                    <dd>{{ Auth::user()->last_seen_at->format('d M Y, H:i') }}</dd>
                    @endif
                </dl>
            </div>
        </div>

        {{-- ── TAB: Security ───────────────────────────────────────────── --}}
        <div class="tab-pane fade" id="tab-security">
            <div class="profile-card">
                <div class="sec-title">Change password</div>
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold" style="font-size:.875rem">Current password</label>
                            <input type="password" name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                placeholder="Enter your current password" autocomplete="current-password">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem">New password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimum 8 characters" autocomplete="new-password">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.875rem">Confirm new password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Repeat new password" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-sm px-4 fw-semibold"
                            style="background:#D05208;color:#FFFFFF;border-radius:8px">
                            Update password
                        </button>
                    </div>
                </form>
            </div>

            {{-- Session / login info --}}
            <div class="profile-card">
                <div class="sec-title">Login information</div>
                <dl class="info-row">
                    @if(Auth::user()->last_seen_at)
                    <dt>Last active</dt>
                    <dd>{{ Auth::user()->last_seen_at->format('d M Y, H:i') }}</dd>
                    @endif
                    @if(Auth::user()->last_login_ip)
                    <dt>Last IP</dt>
                    <dd><code>{{ Auth::user()->last_login_ip }}</code></dd>
                    @endif
                    <dt>Session</dt>
                    <dd>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 text-decoration-underline"
                                style="font-size:.875rem;color:#D05208">
                                Sign out of this device
                            </button>
                        </form>
                    </dd>
                </dl>
            </div>
        </div>

        {{-- ── TAB: Recent activity ────────────────────────────────────── --}}
        <div class="tab-pane fade" id="tab-activity">

            @if(isset($recentHouses) && $recentHouses->count())
            <div class="profile-card">
                <div class="sec-title">Recent house listings</div>
                @foreach($recentHouses as $house)
                <div class="recent-item">
                    <div>
                        <div class="ri-title">{{ $house->title }}</div>
                        <div class="ri-meta">{{ $house->created_at->diffForHumans() }} · {{ $house->location ?? 'No location' }}</div>
                    </div>
                    <a href="{{ route('front.buy.home.details', $house) }}" class="btn btn-outline-secondary btn-sm" style="font-size:.75rem">View</a>
                </div>
                @endforeach
            </div>
            @endif

            @if(!isset($recentHouses) || $recentHouses->isEmpty())
            <div class="profile-card text-center py-4 text-muted">
                No recent activity yet.
            </div>
            @endif
        </div>

        {{-- ── TAB: Danger zone ───────────────────────────────────────── --}}
        <div class="tab-pane fade" id="tab-danger">
            <div class="danger-zone">
                <h6 style="color:#D05208;font-weight:700;margin-bottom:.25rem">Delete account</h6>
                <p class="text-muted small mb-3">
                    Permanently delete your account and all associated listings and data.
                    This action <strong>cannot be undone</strong>.
                </p>
                <button type="button" class="btn btn-sm btn-outline-danger fw-semibold"
                    data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    Delete my account
                </button>
            </div>
        </div>

    </div>
</div>

{{-- ── Delete account confirmation modal ─────────────────────────────────── --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;border:1px solid #F5D9C9">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" style="color:#D05208;font-weight:700">Delete account?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <p class="text-muted small">
                    This will permanently remove your account, all your listings and any uploaded files.
                    Enter your password to confirm.
                </p>
                <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                    @csrf
                    @method('DELETE')
                    <input type="password" name="password" class="form-control"
                        placeholder="Your current password" autocomplete="current-password" required>
                    <div class="mt-3 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger fw-semibold">Yes, delete my account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
