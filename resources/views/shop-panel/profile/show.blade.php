@extends('layouts.shop')
@section('page-title', 'Shop Profile')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --terra-navy: #19265d;
        --terra-navy-deep: #121b45;
        --terra-navy-light: #2a3a82;
        --terra-orange: #D05208;
        --terra-orange-light: #ea6f1f;
        --terra-bg-soft: #f5f6fb;
        --terra-ink: #1c2340;
        --terra-muted: #6b7290;
        --terra-line: #eaebf4;
    }

    [data-h-scope="shop-profile-view"] {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--terra-ink);
    }
    [data-h-scope="shop-profile-view"] h1,
    [data-h-scope="shop-profile-view"] h2,
    [data-h-scope="shop-profile-view"] h5,
    [data-h-scope="shop-profile-view"] .h-heading {
        font-family: 'Sora', sans-serif;
    }

    /* ---------- Alert ---------- */
    [data-h-scope="shop-profile-view"] .alert-terra-success {
        background: rgba(30,158,99,.1);
        border: 1px solid rgba(30,158,99,.25);
        color: #157a4c;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: .6rem;
        font-weight: 500;
        font-size: .9rem;
    }

    /* ---------- Header card (cover + logo) ---------- */
    [data-h-scope="shop-profile-view"] .profile-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 14px rgba(25, 38, 93, 0.07);
        overflow: hidden;
    }
    [data-h-scope="shop-profile-view"] .cover-banner {
        height: 190px;
        background: linear-gradient(135deg, var(--terra-navy-deep) 0%, var(--terra-navy) 55%, var(--terra-navy-light) 100%);
        position: relative;
        overflow: hidden;
    }
    [data-h-scope="shop-profile-view"] .cover-banner img {
        width: 100%; height: 100%; object-fit: cover;
    }
    [data-h-scope="shop-profile-view"] .cover-banner::after {
        content: "";
        position: absolute;
        right: -50px; top: -60px;
        width: 200px; height: 200px;
        background: rgba(208,82,8,.2);
        border-radius: 50%;
        pointer-events: none;
    }
    [data-h-scope="shop-profile-view"] .cover-banner.has-image::after { display: none; }

    [data-h-scope="shop-profile-view"] .profile-header-row {
        padding: 0 2rem 1.5rem;
        display: flex;
        align-items: flex-end;
        gap: 1.25rem;
        margin-top: -44px;
        position: relative;
        flex-wrap: wrap;
    }
    [data-h-scope="shop-profile-view"] .profile-logo {
        width: 96px; height: 96px;
        border-radius: 16px;
        border: 4px solid #fff;
        object-fit: cover;
        background: #fff;
        box-shadow: 0 4px 14px rgba(25,38,93,.15);
        flex-shrink: 0;
    }
    [data-h-scope="shop-profile-view"] .profile-logo-placeholder {
        width: 96px; height: 96px;
        border-radius: 16px;
        border: 4px solid #fff;
        background: var(--terra-bg-soft);
        color: var(--terra-muted);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem;
        box-shadow: 0 4px 14px rgba(25,38,93,.15);
        flex-shrink: 0;
    }
    [data-h-scope="shop-profile-view"] .profile-name-block {
        padding-bottom: .35rem;
        flex: 1;
        min-width: 200px;
    }
    [data-h-scope="shop-profile-view"] .profile-name {
        font-size: 1.35rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: .6rem;
        flex-wrap: wrap;
    }
    [data-h-scope="shop-profile-view"] .profile-meta {
        color: var(--terra-muted);
        font-size: .85rem;
        margin-top: .2rem;
        display: flex;
        align-items: center;
        gap: .4rem;
        flex-wrap: wrap;
    }
    [data-h-scope="shop-profile-view"] .profile-actions {
        padding-bottom: .35rem;
        margin-left: auto;
    }

    [data-h-scope="shop-profile-view"] .badge-soft-success { background: rgba(30,158,99,.12); color: #157a4c; font-weight: 600; }
    [data-h-scope="shop-profile-view"] .badge-soft-warning { background: rgba(208,82,8,.12); color: #a5430a; font-weight: 600; }
    [data-h-scope="shop-profile-view"] .badge-soft-danger  { background: rgba(214,69,69,.12); color: #b93434; font-weight: 600; }
    [data-h-scope="shop-profile-view"] .badge-soft-muted   { background: #eceef5; color: var(--terra-muted); font-weight: 600; }

    [data-h-scope="shop-profile-view"] .btn-terra {
        background: var(--terra-navy);
        border-color: var(--terra-navy);
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        padding: .55rem 1.25rem;
        font-size: .86rem;
    }
    [data-h-scope="shop-profile-view"] .btn-terra:hover {
        background: var(--terra-navy-light);
        border-color: var(--terra-navy-light);
        color: #fff;
    }
    [data-h-scope="shop-profile-view"] .btn-terra-outline {
        background: #fff;
        border: 1px solid var(--terra-line);
        color: var(--terra-navy);
        font-weight: 600;
        border-radius: 10px;
        padding: .55rem 1.1rem;
        font-size: .86rem;
    }
    [data-h-scope="shop-profile-view"] .btn-terra-outline:hover {
        border-color: var(--terra-navy);
        background: var(--terra-bg-soft);
    }

    /* ---------- Detail sections ---------- */
    [data-h-scope="shop-profile-view"] .form-section {
        padding: 1.75rem 2rem;
        border-top: 1px solid var(--terra-line);
    }
    [data-h-scope="shop-profile-view"] .section-eyebrow {
        display: flex;
        align-items: center;
        gap: .6rem;
        margin-bottom: 1.25rem;
    }
    [data-h-scope="shop-profile-view"] .section-icon {
        width: 34px; height: 34px; border-radius: 9px;
        background: rgba(25,38,93,.08);
        color: var(--terra-navy);
        display: flex; align-items: center; justify-content: center;
        font-size: .95rem;
        flex-shrink: 0;
    }
    [data-h-scope="shop-profile-view"] .section-title {
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        margin: 0;
    }
    [data-h-scope="shop-profile-view"] .section-desc {
        color: var(--terra-muted);
        font-size: .8rem;
        margin: 0;
    }

    [data-h-scope="shop-profile-view"] .detail-label {
        text-transform: uppercase;
        letter-spacing: .06em;
        font-size: .68rem;
        font-weight: 700;
        color: var(--terra-muted);
        margin-bottom: .3rem;
    }
    [data-h-scope="shop-profile-view"] .detail-value {
        font-size: .92rem;
        font-weight: 600;
        color: var(--terra-ink);
    }
    [data-h-scope="shop-profile-view"] .detail-value.is-muted {
        font-weight: 400;
        color: var(--terra-muted);
        font-style: italic;
    }
    [data-h-scope="shop-profile-view"] .detail-value a {
        color: var(--terra-navy);
        text-decoration: none;
        font-weight: 600;
    }
    [data-h-scope="shop-profile-view"] .detail-value a:hover { color: var(--terra-orange); }
    [data-h-scope="shop-profile-view"] .detail-desc {
        font-size: .9rem;
        color: var(--terra-ink);
        line-height: 1.65;
    }

    /* ---------- Side stat cards ---------- */
    [data-h-scope="shop-profile-view"] .mini-stat-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(25, 38, 93, 0.06);
        padding: 1.1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: .85rem;
    }
    [data-h-scope="shop-profile-view"] .mini-stat-icon {
        width: 42px; height: 42px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.05rem;
        flex-shrink: 0;
    }
    [data-h-scope="shop-profile-view"] .mini-stat-icon.bg-navy { background: rgba(25,38,93,.08); color: var(--terra-navy); }
    [data-h-scope="shop-profile-view"] .mini-stat-icon.bg-orange { background: rgba(208,82,8,.12); color: var(--terra-orange); }
    [data-h-scope="shop-profile-view"] .mini-stat-label { color: var(--terra-muted); font-size: .78rem; font-weight: 500; }
    [data-h-scope="shop-profile-view"] .mini-stat-value { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 1.15rem; color: var(--terra-ink); }

    [data-h-scope="shop-profile-view"] .tip-card {
        border: none;
        border-radius: 14px;
        background: var(--terra-bg-soft);
        padding: 1.1rem 1.25rem;
    }
    [data-h-scope="shop-profile-view"] .tip-card .tip-title {
        font-weight: 700;
        font-size: .85rem;
        display: flex;
        align-items: center;
        gap: .5rem;
        color: var(--terra-ink);
        margin-bottom: .35rem;
    }
    [data-h-scope="shop-profile-view"] .tip-card .tip-title i { color: var(--terra-orange); }
    [data-h-scope="shop-profile-view"] .tip-card p {
        font-size: .8rem;
        color: var(--terra-muted);
        margin: 0;
        line-height: 1.55;
    }

    @media (max-width: 767px) {
        [data-h-scope="shop-profile-view"] .form-section { padding: 1.25rem 1.25rem; }
        [data-h-scope="shop-profile-view"] .profile-header-row { padding: 0 1.25rem 1.25rem; }
        [data-h-scope="shop-profile-view"] .profile-actions { margin-left: 0; width: 100%; }
        [data-h-scope="shop-profile-view"] .profile-actions .btn { width: 100%; }
    }
</style>
@endpush

@section('content')
<div data-h-scope="shop-profile-view">

    @if (session('status') === 'shop-updated')
        <div class="alert alert-terra-success py-3 px-4 mb-4">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span>Shop profile updated successfully.</span>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card profile-card mb-3">

                {{-- Cover + logo header --}}
                <div class="cover-banner {{ $shop->cover_image ? 'has-image' : '' }}">
                    @if ($shop->cover_image)
                        <img src="{{ asset('storage/' . $shop->cover_image) }}" alt="{{ $shop->name }} cover">
                    @endif
                </div>

                <div class="profile-header-row">
                    @if ($shop->logo)
                        <img src="{{ asset('storage/' . $shop->logo) }}" class="profile-logo" alt="{{ $shop->name }} logo">
                    @else
                        <div class="profile-logo-placeholder"><i class="bi bi-shop"></i></div>
                    @endif

                    <div class="profile-name-block">
                        <div class="profile-name">
                            {{ $shop->name }}
                            @php
                                $shopBadge = ['pending' => 'badge-soft-warning', 'approved' => 'badge-soft-success', 'rejected' => 'badge-soft-danger', 'suspended' => 'badge-soft-muted'][$shop->status] ?? 'badge-soft-muted';
                            @endphp
                            <span class="badge {{ $shopBadge }}">{{ ucfirst($shop->status) }}</span>
                        </div>
                        <div class="profile-meta">
                            <i class="bi bi-geo-alt"></i>
                            {{ collect([$shop->district, $shop->province])->filter()->implode(', ') ?: 'Location not set' }}
                        </div>
                    </div>

                    <div class="profile-actions">
                        <a href="{{ route('shop-panel.profile.edit') }}" class="btn btn-terra">
                            <i class="bi bi-pencil"></i> Edit Profile
                        </a>
                    </div>
                </div>

                {{-- About --}}
                <div class="form-section">
                    <div class="section-eyebrow">
                        <div class="section-icon"><i class="bi bi-shop-window"></i></div>
                        <div>
                            <p class="section-title">About This Shop</p>
                            <p class="section-desc">Shown to buyers on your public shop page.</p>
                        </div>
                    </div>

                    @if ($shop->description)
                        <p class="detail-desc mb-0">{{ $shop->description }}</p>
                    @else
                        <p class="detail-value is-muted mb-0">No description added yet.</p>
                    @endif
                </div>

                {{-- Contact --}}
                <div class="form-section">
                    <div class="section-eyebrow">
                        <div class="section-icon"><i class="bi bi-headset"></i></div>
                        <div>
                            <p class="section-title">Contact Information</p>
                            <p class="section-desc">How buyers can reach you directly.</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value {{ $shop->phone ? '' : 'is-muted' }}">
                                @if ($shop->phone)
                                    <a href="tel:{{ $shop->phone }}"><i class="bi bi-telephone me-1"></i>{{ $shop->phone }}</a>
                                @else
                                    Not provided
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">WhatsApp</div>
                            <div class="detail-value {{ $shop->whatsapp_number ? '' : 'is-muted' }}">
                                @if ($shop->whatsapp_number)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $shop->whatsapp_number) }}" target="_blank"><i class="bi bi-whatsapp me-1"></i>{{ $shop->whatsapp_number }}</a>
                                @else
                                    Not provided
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Email</div>
                            <div class="detail-value {{ $shop->email ? '' : 'is-muted' }}">
                                @if ($shop->email)
                                    <a href="mailto:{{ $shop->email }}"><i class="bi bi-envelope me-1"></i>{{ $shop->email }}</a>
                                @else
                                    Not provided
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Location --}}
                <div class="form-section">
                    <div class="section-eyebrow">
                        <div class="section-icon"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <p class="section-title">Location</p>
                            <p class="section-desc">Helps buyers find you and estimate delivery.</p>
                        </div>
                    </div>

                    <div class="row g-4 mb-3">
                        <div class="col-md-4">
                            <div class="detail-label">Province</div>
                            <div class="detail-value {{ $shop->province ? '' : 'is-muted' }}">{{ $shop->province ?: 'Not set' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">District</div>
                            <div class="detail-value {{ $shop->district ? '' : 'is-muted' }}">{{ $shop->district ?: 'Not set' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Sector</div>
                            <div class="detail-value {{ $shop->sector ? '' : 'is-muted' }}">{{ $shop->sector ?: 'Not set' }}</div>
                        </div>
                    </div>

                    <div class="detail-label">Address</div>
                    <div class="detail-value {{ $shop->address ? '' : 'is-muted' }}">
                        <i class="bi bi-pin-map me-1"></i>{{ $shop->address ?: 'Not set' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Side column --}}
        <div class="col-lg-4">
            <div class="mini-stat-card mb-3">
                <div class="mini-stat-icon bg-navy"><i class="bi bi-eye"></i></div>
                <div>
                    <div class="mini-stat-label">Shop Views</div>
                    <div class="mini-stat-value">{{ number_format($shop->views_count ?? 0) }}</div>
                </div>
            </div>

            <div class="mini-stat-card mb-3">
                <div class="mini-stat-icon bg-orange"><i class="bi bi-calendar-check"></i></div>
                <div>
                    <div class="mini-stat-label">Member Since</div>
                    <div class="mini-stat-value" style="font-size:.95rem;">{{ $shop->created_at?->format('M Y') ?? '—' }}</div>
                </div>
            </div>

            <div class="tip-card">
                <div class="tip-title"><i class="bi bi-lightbulb"></i> Complete your profile</div>
                <p>Shops with a logo, cover photo, and full contact details get more buyer trust and higher visibility in search.</p>
            </div>
        </div>
    </div>

</div>
@endsection
