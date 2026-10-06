@extends('layouts.property-management')

@section('title', $tenant->full_name . ' - Tenant')

@section('content')

<style>
    :root {
        --pm-navy: #19265d;
        --pm-orange: #D05208;
        --pm-bg: #f6f7fb;
        --pm-border: #e5e7ec;
        --pm-text: #202636;
        --pm-muted: #737b8b;
    }

    .tenant-profile-page {
        background: var(--pm-bg);
        min-height: calc(100vh - 80px);
        padding: 28px 0 50px;
    }

    /* Header */
    .breadcrumb-text {
        font-size: .78rem;
        color: #858c99;
    }

    .breadcrumb-text a {
        color: #858c99;
        text-decoration: none;
    }

    .breadcrumb-text a:hover {
        color: var(--pm-navy);
    }

    .page-title {
        color: var(--pm-navy);
        font-size: 1.65rem;
        font-weight: 750;
        letter-spacing: -.4px;
    }

    .page-subtitle {
        color: var(--pm-muted);
        font-size: .88rem;
    }

    .btn-edit {
        background: var(--pm-orange);
        border: 1px solid var(--pm-orange);
        color: #fff;
        border-radius: 8px;
        font-size: .83rem;
        font-weight: 650;
        padding: 9px 15px;
    }

    .btn-edit:hover {
        background: #b94705;
        border-color: #b94705;
        color: #fff;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #626a78;
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 8px;
        padding: 8px 12px;
        font-size: .8rem;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-back:hover {
        color: var(--pm-navy);
        border-color: #ccd1dc;
    }

    /* Alerts */
    .pm-alert {
        border: 0;
        border-radius: 10px;
        font-size: .84rem;
    }

    /* Profile hero */
    .profile-hero {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 15px;
        box-shadow: 0 4px 18px rgba(25, 38, 93, .035);
        padding: 22px;
        margin-bottom: 20px;
    }

    .profile-avatar {
        width: 72px;
        height: 72px;
        border-radius: 16px;
        background: #eef1fa;
        color: var(--pm-navy);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .profile-name {
        color: var(--pm-text);
        font-size: 1.35rem;
        font-weight: 750;
        margin-bottom: 4px;
    }

    .profile-contact {
        color: #7d8491;
        font-size: .81rem;
    }

    .profile-contact i {
        color: #9aa1ad;
    }

    .profile-divider {
        height: 38px;
        width: 1px;
        background: var(--pm-border);
    }

    /* Cards */
    .pm-card {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(25, 38, 93, .035);
        overflow: hidden;
    }

    .card-header-modern {
        padding: 17px 20px;
        border-bottom: 1px solid var(--pm-border);
        background: #fff;
    }

    .card-title-modern {
        color: var(--pm-text);
        font-size: .95rem;
        font-weight: 750;
        margin: 0;
    }

    .card-description {
        color: #8a919d;
        font-size: .73rem;
        margin-top: 3px;
    }

    .card-body-modern {
        padding: 20px;
    }

    /* Information rows */
    .info-item {
        min-height: 55px;
    }

    .info-label {
        color: #8a919d;
        font-size: .71rem;
        font-weight: 650;
        text-transform: uppercase;
        letter-spacing: .035em;
        margin-bottom: 4px;
    }

    .info-value {
        color: var(--pm-text);
        font-size: .84rem;
        font-weight: 600;
        word-break: break-word;
    }

    .info-value.muted {
        color: #969ca7;
        font-weight: 500;
    }

    .info-value a {
        color: var(--pm-navy);
        text-decoration: none;
    }

    .info-value a:hover {
        text-decoration: underline;
    }

    /* Section icons */
    .section-icon {
        width: 35px;
        height: 35px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eef1fa;
        color: var(--pm-navy);
        flex-shrink: 0;
    }

    .section-icon.orange {
        background: #fff0e9;
        color: var(--pm-orange);
    }

    .section-icon.green {
        background: #eaf8f1;
        color: #168653;
    }

    /* Status */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 30px;
        padding: 6px 11px;
        font-size: .72rem;
        font-weight: 700;
    }

    .status-pill::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-verified {
        background: #eaf8f1;
        color: #168653;
    }

    .status-pending {
        background: #fff5df;
        color: #a96800;
    }

    .status-rejected {
        background: #fdeeee;
        color: #bd3636;
    }

    .status-active {
        background: #eaf7f0;
        color: #168653;
    }

    .status-inactive {
        background: #f0f1f4;
        color: #737985;
    }

    .status-blacklisted {
        background: #fdeeee;
        color: #bd3636;
    }

    .account-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 30px;
        font-size: .71rem;
        font-weight: 700;
    }

    .account-linked {
        background: #edf3ff;
        color: #315fa8;
    }

    .account-none {
        background: #f2f3f5;
        color: #777d88;
    }

    /* Status action */
    .status-action {
        width: 100%;
        min-height: 40px;
        border: 1px solid #dfe2e8;
        background: #fff;
        color: var(--pm-navy);
        border-radius: 8px;
        font-size: .79rem;
        font-weight: 650;
        transition: .15s ease;
    }

    .status-action:hover {
        background: #f5f6fa;
        border-color: #cbd0da;
    }

    /* Mini stats */
    .mini-stat {
        background: #f8f9fb;
        border: 1px solid #eceef2;
        border-radius: 10px;
        padding: 14px;
        height: 100%;
    }

    .mini-stat-label {
        color: #858c98;
        font-size: .7rem;
        font-weight: 650;
        margin-bottom: 5px;
    }

    .mini-stat-value {
        color: var(--pm-text);
        font-size: 1.15rem;
        font-weight: 750;
    }

    /* Address */
    .address-box {
        background: #f8f9fb;
        border: 1px solid #eceef2;
        border-radius: 10px;
        padding: 15px;
        color: #515968;
        font-size: .83rem;
        line-height: 1.65;
    }

    /* Empty */
    .empty-content {
        padding: 24px 10px;
        text-align: center;
        color: #8a919d;
        font-size: .8rem;
    }

    .empty-content i {
        font-size: 1.7rem;
        color: #c0c5ce;
        display: block;
        margin-bottom: 8px;
    }

    /* Notes */
    .notes-box {
        background: #fffaf5;
        border: 1px solid #f4dfcc;
        border-radius: 10px;
        padding: 15px;
        color: #62605c;
        font-size: .82rem;
        line-height: 1.65;
        white-space: pre-line;
    }

    /* Modal */
    .modal-content {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 18px 50px rgba(20, 28, 50, .18);
    }

    .modal-header {
        padding: 18px 20px;
        border-bottom: 1px solid var(--pm-border);
    }

    .modal-title {
        color: var(--pm-text);
        font-size: .98rem;
        font-weight: 750;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 14px 20px;
        border-top: 1px solid var(--pm-border);
    }

    .modal-status-option {
        position: relative;
    }

    .modal-status-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .modal-status-option label {
        display: block;
        border: 1px solid #dfe2e8;
        border-radius: 9px;
        padding: 13px 14px;
        cursor: pointer;
        transition: .15s ease;
    }

    .modal-status-option label:hover {
        background: #fafbfc;
    }

    .modal-status-option input:checked + label {
        border-color: var(--pm-navy);
        background: #f6f7fc;
        box-shadow: 0 0 0 2px rgba(25, 38, 93, .06);
    }

    .modal-status-title {
        color: var(--pm-text);
        font-size: .82rem;
        font-weight: 700;
    }

    .modal-status-description {
        color: #8a919d;
        font-size: .71rem;
        margin-top: 2px;
    }

    .btn-modal-cancel {
        border: 1px solid #dfe2e8;
        background: #fff;
        color: #5e6573;
        border-radius: 8px;
        font-size: .8rem;
        font-weight: 600;
    }

    .btn-modal-save {
        border: 1px solid var(--pm-navy);
        background: var(--pm-navy);
        color: #fff;
        border-radius: 8px;
        font-size: .8rem;
        font-weight: 650;
    }

    .btn-modal-save:hover {
        background: #101a47;
        border-color: #101a47;
        color: #fff;
    }

    @media (max-width: 767.98px) {
        .tenant-profile-page {
            padding-top: 20px;
        }

        .profile-hero {
            padding: 17px;
        }

        .profile-divider {
            display: none;
        }

        .profile-contact-group {
            margin-top: 10px;
        }

        .page-title {
            font-size: 1.4rem;
        }
    }
</style>

<div class="tenant-profile-page">

    <div class="container-fluid px-3 px-lg-4">

        {{-- ==========================================================
             PAGE HEADER
        =========================================================== --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <div>

                <div class="breadcrumb-text mb-2">
                    <a href="{{ route('property-management.dashboard') }}">
                        Property Management
                    </a>

                    <span class="mx-1">/</span>

                    <a href="{{ route('property-management.tenants.index') }}">
                        Tenants
                    </a>

                    <span class="mx-1">/</span>

                    <span>{{ $tenant->full_name }}</span>
                </div>

                <h1 class="page-title mb-1">
                    Tenant Profile
                </h1>

                <p class="page-subtitle mb-0">
                    View tenant information, verification status, account details and tenancy activity.
                </p>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('property-management.tenants.index') }}"
                   class="btn-back">
                    <i class="bi bi-arrow-left"></i>
                    Tenants
                </a>

                <a href="{{ route('property-management.tenants.edit', $tenant) }}"
                   class="btn btn-edit">
                    <i class="bi bi-pencil me-1"></i>
                    Edit Tenant
                </a>

            </div>

        </div>


        {{-- ==========================================================
             ALERTS
        =========================================================== --}}
        @if(session('success'))

            <div class="alert alert-success pm-alert alert-dismissible fade show mb-4"
                 role="alert">

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger pm-alert alert-dismissible fade show mb-4"
                 role="alert">

                <i class="bi bi-exclamation-circle-fill me-2"></i>

                {{ session('error') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- ==========================================================
             PROFILE SUMMARY
        =========================================================== --}}
        <div class="profile-hero">

            <div class="d-flex flex-wrap align-items-center gap-3">

                @php
                    $initials = collect([
                        $tenant->first_name,
                        $tenant->last_name
                    ])
                    ->filter()
                    ->map(fn($name) => strtoupper(substr($name, 0, 1)))
                    ->join('');

                    $initials = $initials ?: 'TN';
                @endphp

                <div class="profile-avatar">
                    {{ $initials }}
                </div>

                <div class="flex-grow-1">

                    <div class="profile-name">
                        {{ $tenant->full_name }}
                    </div>

                    <div class="d-flex flex-wrap gap-3 profile-contact-group">

                        @if($tenant->phone)

                            <span class="profile-contact">
                                <i class="bi bi-telephone me-1"></i>
                                {{ $tenant->phone }}
                            </span>

                        @endif

                        @if($tenant->email)

                            <span class="profile-contact">
                                <i class="bi bi-envelope me-1"></i>
                                {{ $tenant->email }}
                            </span>

                        @endif

                        @if($tenant->national_id)

                            <span class="profile-contact">
                                <i class="bi bi-card-text me-1"></i>
                                {{ $tenant->national_id }}
                            </span>

                        @endif

                    </div>

                </div>

                <div class="profile-divider"></div>

                <div class="d-flex flex-wrap gap-2">

                    {{-- KYC badge --}}
                    @if($tenant->kyc_status === 'verified')

                        <span class="status-pill status-verified">
                            KYC Verified
                        </span>

                    @elseif($tenant->kyc_status === 'rejected')

                        <span class="status-pill status-rejected">
                            KYC Rejected
                        </span>

                    @else

                        <span class="status-pill status-pending">
                            KYC Pending
                        </span>

                    @endif


                    {{-- Tenant status badge --}}
                    @if($tenant->status === 'active')

                        <span class="status-pill status-active">
                            Active
                        </span>

                    @elseif($tenant->status === 'blacklisted')

                        <span class="status-pill status-blacklisted">
                            Blacklisted
                        </span>

                    @else

                        <span class="status-pill status-inactive">
                            Inactive
                        </span>

                    @endif

                </div>

            </div>

        </div>


        <div class="row g-4">

            {{-- ======================================================
                 MAIN CONTENT
            ======================================================= --}}
            <div class="col-xl-8">


                {{-- PERSONAL INFORMATION --}}
                <div class="pm-card mb-4">

                    <div class="card-header-modern">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon">
                                <i class="bi bi-person"></i>
                            </div>

                            <div>

                                <h2 class="card-title-modern">
                                    Personal Information
                                </h2>

                                <div class="card-description">
                                    Identity and contact information
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-body-modern">

                        <div class="row g-4">

                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Full Name</div>
                                    <div class="info-value">
                                        {{ $tenant->full_name }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Phone Number</div>

                                    <div class="info-value">
                                        @if($tenant->phone)
                                            <a href="tel:{{ $tenant->phone }}">
                                                {{ $tenant->phone }}
                                            </a>
                                        @else
                                            <span class="muted">Not provided</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">Email Address</div>

                                    <div class="info-value">
                                        @if($tenant->email)
                                            <a href="mailto:{{ $tenant->email }}">
                                                {{ $tenant->email }}
                                            </a>
                                        @else
                                            <span class="info-value muted">
                                                Not provided
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">National ID</div>

                                    <div class="info-value">
                                        {{ $tenant->national_id ?: 'Not provided' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-label">Date of Birth</div>

                                    <div class="info-value">
                                        {{ $tenant->date_of_birth?->format('d M Y') ?: 'Not provided' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-label">Gender</div>

                                    <div class="info-value">
                                        {{ $tenant->gender ? ucfirst($tenant->gender) : 'Not provided' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-label">Tenant Since</div>

                                    <div class="info-value">
                                        {{ $tenant->created_at?->format('d M Y') ?: '—' }}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- ADDRESS --}}
                <div class="pm-card mb-4">

                    <div class="card-header-modern">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon orange">
                                <i class="bi bi-geo-alt"></i>
                            </div>

                            <div>

                                <h2 class="card-title-modern">
                                    Residential Address
                                </h2>

                                <div class="card-description">
                                    Tenant's registered residential location
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-body-modern">

                        <div class="row g-4 mb-3">

                            <div class="col-md-3">
                                <div class="info-item">
                                    <div class="info-label">District</div>
                                    <div class="info-value">
                                        {{ $tenant->district ?: '—' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="info-item">
                                    <div class="info-label">Sector</div>
                                    <div class="info-value">
                                        {{ $tenant->sector ?: '—' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="info-item">
                                    <div class="info-label">Cell</div>
                                    <div class="info-value">
                                        {{ $tenant->cell ?: '—' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="info-item">
                                    <div class="info-label">Village</div>
                                    <div class="info-value">
                                        {{ $tenant->village ?: '—' }}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="info-label">
                            Full Address
                        </div>

                        <div class="address-box">

                            @if($tenant->address)

                                <i class="bi bi-geo-alt me-1"></i>
                                {{ $tenant->address }}

                            @else

                                No additional address information provided.

                            @endif

                        </div>

                    </div>

                </div>


                {{-- EMERGENCY CONTACT --}}
                <div class="pm-card mb-4">

                    <div class="card-header-modern">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon orange">
                                <i class="bi bi-shield-plus"></i>
                            </div>

                            <div>

                                <h2 class="card-title-modern">
                                    Emergency Contact
                                </h2>

                                <div class="card-description">
                                    Person to contact in case of an emergency
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-body-modern">

                        @if($tenant->emergency_contact_name)

                            <div class="row g-4">

                                <div class="col-md-4">

                                    <div class="info-label">
                                        Contact Name
                                    </div>

                                    <div class="info-value">
                                        {{ $tenant->emergency_contact_name }}
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="info-label">
                                        Phone Number
                                    </div>

                                    <div class="info-value">

                                        @if($tenant->emergency_contact_phone)

                                            <a href="tel:{{ $tenant->emergency_contact_phone }}">
                                                {{ $tenant->emergency_contact_phone }}
                                            </a>

                                        @else

                                            Not provided

                                        @endif

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="info-label">
                                        Relationship
                                    </div>

                                    <div class="info-value">
                                        {{ $tenant->emergency_contact_relationship ?: 'Not provided' }}
                                    </div>

                                </div>

                            </div>

                        @else

                            <div class="empty-content">

                                <i class="bi bi-person-exclamation"></i>

                                No emergency contact has been provided for this tenant.

                            </div>

                        @endif

                    </div>

                </div>


                {{-- NOTES --}}
                <div class="pm-card mb-4">

                    <div class="card-header-modern">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon">
                                <i class="bi bi-journal-text"></i>
                            </div>

                            <div>

                                <h2 class="card-title-modern">
                                    Internal Notes
                                </h2>

                                <div class="card-description">
                                    Property management notes about this tenant
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-body-modern">

                        @if($tenant->notes)

                            <div class="notes-box">
                                {{ $tenant->notes }}
                            </div>

                        @else

                            <div class="empty-content">
                                <i class="bi bi-journal"></i>
                                No internal notes have been added.
                            </div>

                        @endif

                    </div>

                </div>


                {{-- LEASE HISTORY --}}
                <div class="pm-card">

                    <div class="card-header-modern">

                        <div class="d-flex justify-content-between align-items-center">

                            <div class="d-flex align-items-center gap-3">

                                <div class="section-icon green">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>

                                <div>

                                    <h2 class="card-title-modern">
                                        Lease History
                                    </h2>

                                    <div class="card-description">
                                        Tenant lease records
                                    </div>

                                </div>

                            </div>

                            <span class="record-count">
                                {{ $tenant->leases->count() }} record(s)
                            </span>

                        </div>

                    </div>

                    <div class="card-body-modern">

                        @if($tenant->leases->count())

                            <div class="row g-3">

                                @foreach($tenant->leases as $lease)

                                    <div class="col-12">

                                        <div class="mini-stat">

                                            <div class="d-flex justify-content-between align-items-center">

                                                <div>

                                                    <div class="mini-stat-label">
                                                        Lease #{{ $lease->id }}
                                                    </div>

                                                    <div class="mini-stat-value">
                                                        Lease Record
                                                    </div>

                                                </div>

                                                <i class="bi bi-chevron-right text-muted"></i>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="empty-content">

                                <i class="bi bi-file-earmark"></i>

                                No lease records have been associated with this tenant yet.

                            </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- ======================================================
                 SIDEBAR
            ======================================================= --}}
            <div class="col-xl-4">


                {{-- KYC --}}
                <div class="pm-card mb-4">

                    <div class="card-header-modern">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon green">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>

                                <h2 class="card-title-modern">
                                    KYC Verification
                                </h2>

                                <div class="card-description">
                                    Identity verification status
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-body-modern">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="text-muted small">
                                Current status
                            </span>

                            @if($tenant->kyc_status === 'verified')

                                <span class="status-pill status-verified">
                                    Verified
                                </span>

                            @elseif($tenant->kyc_status === 'rejected')

                                <span class="status-pill status-rejected">
                                    Rejected
                                </span>

                            @else

                                <span class="status-pill status-pending">
                                    Pending
                                </span>

                            @endif

                        </div>

                        <button type="button"
                                class="status-action"
                                data-bs-toggle="modal"
                                data-bs-target="#kycStatusModal">

                            <i class="bi bi-arrow-repeat me-1"></i>
                            Change KYC Status

                        </button>

                    </div>

                </div>


                {{-- TENANT STATUS --}}
                <div class="pm-card mb-4">

                    <div class="card-header-modern">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon orange">
                                <i class="bi bi-person-check"></i>
                            </div>

                            <div>

                                <h2 class="card-title-modern">
                                    Tenant Status
                                </h2>

                                <div class="card-description">
                                    Current tenant account status
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-body-modern">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="text-muted small">
                                Current status
                            </span>

                            @if($tenant->status === 'active')

                                <span class="status-pill status-active">
                                    Active
                                </span>

                            @elseif($tenant->status === 'blacklisted')

                                <span class="status-pill status-blacklisted">
                                    Blacklisted
                                </span>

                            @else

                                <span class="status-pill status-inactive">
                                    Inactive
                                </span>

                            @endif

                        </div>

                        <button type="button"
                                class="status-action"
                                data-bs-toggle="modal"
                                data-bs-target="#tenantStatusModal">

                            <i class="bi bi-arrow-repeat me-1"></i>
                            Change Tenant Status

                        </button>

                    </div>

                </div>


                {{-- ACCOUNT --}}
                <div class="pm-card mb-4">

                    <div class="card-header-modern">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon">
                                <i class="bi bi-person-badge"></i>
                            </div>

                            <div>

                                <h2 class="card-title-modern">
                                    Account Information
                                </h2>

                                <div class="card-description">
                                    Tenant system account
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-body-modern">

                        <div class="info-item mb-3">

                            <div class="info-label">
                                Account Status
                            </div>

                            @if($tenant->user_id)

                                <span class="account-pill account-linked">
                                    <i class="bi bi-link-45deg"></i>
                                    Linked to User Account
                                </span>

                            @else

                                <span class="account-pill account-none">
                                    <i class="bi bi-person-x"></i>
                                    No User Account
                                </span>

                            @endif

                        </div>

                        <div class="info-item">

                            <div class="info-label">
                                User ID
                            </div>

                            <div class="info-value">
                                {{ $tenant->user_id ?: 'Not linked' }}
                            </div>

                        </div>

                    </div>

                </div>


                {{-- ACTIVITY SUMMARY --}}
                <div class="pm-card mb-4">

                    <div class="card-header-modern">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon">
                                <i class="bi bi-bar-chart"></i>
                            </div>

                            <div>

                                <h2 class="card-title-modern">
                                    Activity Summary
                                </h2>

                                <div class="card-description">
                                    Tenant records and activity
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-body-modern">

                        <div class="row g-2">

                            <div class="col-6">

                                <div class="mini-stat">

                                    <div class="mini-stat-label">
                                        Leases
                                    </div>

                                    <div class="mini-stat-value">
                                        {{ $tenant->leases->count() }}
                                    </div>

                                </div>

                            </div>

                            <div class="col-6">

                                <div class="mini-stat">

                                    <div class="mini-stat-label">
                                        Applications
                                    </div>

                                    <div class="mini-stat-value">
                                        {{ $tenant->applications->count() }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- RECORD INFORMATION --}}
                <div class="pm-card">

                    <div class="card-header-modern">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon">
                                <i class="bi bi-clock-history"></i>
                            </div>

                            <div>

                                <h2 class="card-title-modern">
                                    Record Information
                                </h2>

                                <div class="card-description">
                                    Tenant record timestamps
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-body-modern">

                        <div class="info-item mb-3">

                            <div class="info-label">
                                Created
                            </div>

                            <div class="info-value">
                                {{ $tenant->created_at?->format('d M Y, H:i') ?: '—' }}
                            </div>

                        </div>

                        <div class="info-item">

                            <div class="info-label">
                                Last Updated
                            </div>

                            <div class="info-value">
                                {{ $tenant->updated_at?->format('d M Y, H:i') ?: '—' }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ================================================================
     KYC STATUS MODAL
================================================================ --}}
<div class="modal fade"
     id="kycStatusModal"
     tabindex="-1"
     aria-labelledby="kycStatusModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form method="POST"
                  action="{{ route('property-management.tenants.update-kyc-status', $tenant) }}">

                @csrf
                @method('PATCH')

                <div class="modal-header">

                    <div>

                        <h5 class="modal-title"
                            id="kycStatusModalLabel">
                            Change KYC Status
                        </h5>

                        <div class="text-muted small mt-1">
                            Update the identity verification status for
                            {{ $tenant->full_name }}.
                        </div>

                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row g-2">

                        <div class="col-12">

                            <div class="modal-status-option">

                                <input type="radio"
                                       name="kyc_status"
                                       id="modal_kyc_pending"
                                       value="pending"
                                       @checked($tenant->kyc_status === 'pending')>

                                <label for="modal_kyc_pending">

                                    <div class="modal-status-title">
                                        Pending
                                    </div>

                                    <div class="modal-status-description">
                                        KYC documents have not yet been fully verified.
                                    </div>

                                </label>

                            </div>

                        </div>

                        <div class="col-12">

                            <div class="modal-status-option">

                                <input type="radio"
                                       name="kyc_status"
                                       id="modal_kyc_verified"
                                       value="verified"
                                       @checked($tenant->kyc_status === 'verified')>

                                <label for="modal_kyc_verified">

                                    <div class="modal-status-title">
                                        Verified
                                    </div>

                                    <div class="modal-status-description">
                                        The tenant's KYC information has been verified.
                                    </div>

                                </label>

                            </div>

                        </div>

                        <div class="col-12">

                            <div class="modal-status-option">

                                <input type="radio"
                                       name="kyc_status"
                                       id="modal_kyc_rejected"
                                       value="rejected"
                                       @checked($tenant->kyc_status === 'rejected')>

                                <label for="modal_kyc_rejected">

                                    <div class="modal-status-title">
                                        Rejected
                                    </div>

                                    <div class="modal-status-description">
                                        The submitted KYC information was rejected.
                                    </div>

                                </label>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-modal-cancel"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-modal-save">
                        Update KYC Status
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- ================================================================
     TENANT STATUS MODAL
================================================================ --}}
<div class="modal fade"
     id="tenantStatusModal"
     tabindex="-1"
     aria-labelledby="tenantStatusModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form method="POST"
                  action="{{ route('property-management.tenants.update-status', $tenant) }}">

                @csrf
                @method('PATCH')

                <div class="modal-header">

                    <div>

                        <h5 class="modal-title"
                            id="tenantStatusModalLabel">
                            Change Tenant Status
                        </h5>

                        <div class="text-muted small mt-1">
                            Update the current management status for
                            {{ $tenant->full_name }}.
                        </div>

                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row g-2">

                        <div class="col-12">

                            <div class="modal-status-option">

                                <input type="radio"
                                       name="status"
                                       id="modal_status_active"
                                       value="active"
                                       @checked($tenant->status === 'active')>

                                <label for="modal_status_active">

                                    <div class="modal-status-title">
                                        Active
                                    </div>

                                    <div class="modal-status-description">
                                        Tenant is currently active and eligible for tenancy services.
                                    </div>

                                </label>

                            </div>

                        </div>

                        <div class="col-12">

                            <div class="modal-status-option">

                                <input type="radio"
                                       name="status"
                                       id="modal_status_inactive"
                                       value="inactive"
                                       @checked($tenant->status === 'inactive')>

                                <label for="modal_status_inactive">

                                    <div class="modal-status-title">
                                        Inactive
                                    </div>

                                    <div class="modal-status-description">
                                        Tenant record is retained but is not currently active.
                                    </div>

                                </label>

                            </div>

                        </div>

                        <div class="col-12">

                            <div class="modal-status-option">

                                <input type="radio"
                                       name="status"
                                       id="modal_status_blacklisted"
                                       value="blacklisted"
                                       @checked($tenant->status === 'blacklisted')>

                                <label for="modal_status_blacklisted">

                                    <div class="modal-status-title">
                                        Blacklisted
                                    </div>

                                    <div class="modal-status-description">
                                        Tenant is restricted from normal property management activities.
                                    </div>

                                </label>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-modal-cancel"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-modal-save">
                        Update Tenant Status
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection