@extends('layouts.property-management')

@section('title', 'Tenant Application #' . $application->id)

@section('content')

<style>
    :root {
        --pm-navy: #19265d;
        --pm-orange: #D05208;
        --pm-bg: #f6f7fb;
        --pm-border: #e5e7ec;
        --pm-text: #202636;
        --pm-muted: #747c8c;
        --pm-success: #168653;
        --pm-danger: #c43d3d;
        --pm-warning: #a96d00;
        --pm-info: #27779f;
    }

    .application-page {
        background: var(--pm-bg);
        min-height: calc(100vh - 80px);
        padding: 28px 0 50px;
    }

    /* =====================================================
       Header
    ====================================================== */

    .breadcrumb-text {
        font-size: .77rem;
        color: #8a919e;
        margin-bottom: 8px;
    }

    .breadcrumb-text a {
        color: #8a919e;
        text-decoration: none;
    }

    .breadcrumb-text a:hover {
        color: var(--pm-navy);
    }

    .page-title {
        color: var(--pm-navy);
        font-size: 1.6rem;
        font-weight: 750;
        letter-spacing: -.4px;
        margin-bottom: 5px;
    }

    .page-subtitle {
        color: var(--pm-muted);
        font-size: .82rem;
        margin-bottom: 0;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 40px;
        padding: 8px 13px;
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 8px;
        color: #626a78;
        font-size: .79rem;
        font-weight: 600;
        text-decoration: none;
    }

    .back-btn:hover {
        color: var(--pm-navy);
        border-color: #ccd1dc;
        background: #fafbfc;
    }

    .edit-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 40px;
        padding: 8px 14px;
        background: #fff;
        border: 1px solid #dfe2e8;
        border-radius: 8px;
        color: var(--pm-navy);
        font-size: .79rem;
        font-weight: 650;
        text-decoration: none;
    }

    .edit-btn:hover {
        background: #f6f8fc;
        border-color: #cbd1dc;
        color: var(--pm-navy);
    }

    /* =====================================================
       Alerts
    ====================================================== */

    .pm-alert {
        border-radius: 10px;
        border: 1px solid;
        font-size: .81rem;
        padding: 12px 15px;
    }

    .pm-alert-success {
        color: #176c47;
        background: #f0faf5;
        border-color: #c9ead9;
    }

    .pm-alert-danger {
        color: #963636;
        background: #fff5f5;
        border-color: #f0cccc;
    }

    /* =====================================================
       Application Hero
    ====================================================== */

    .application-hero {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(25, 38, 93, .035);
        padding: 19px 21px;
        margin-bottom: 20px;
    }

    .application-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: #fff0e9;
        color: var(--pm-orange);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .application-id {
        color: #8a919e;
        font-size: .69rem;
        font-weight: 650;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 3px;
    }

    .application-number {
        color: var(--pm-text);
        font-size: 1rem;
        font-weight: 750;
        margin-bottom: 3px;
    }

    .application-meta {
        color: #9299a5;
        font-size: .73rem;
    }

    /* =====================================================
       Status
    ====================================================== */

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: .68rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-pending {
        background: #fff7e6;
        color: #a96d00;
    }

    .status-review {
        background: #edf7fc;
        color: #27779f;
    }

    .status-approved {
        background: #eaf8f1;
        color: #168653;
    }

    .status-rejected {
        background: #fff0f0;
        color: #bf3d3d;
    }

    .status-withdrawn {
        background: #f0f1f3;
        color: #707783;
    }

    /* =====================================================
       Cards
    ====================================================== */

    .content-card {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(25, 38, 93, .035);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card-section-header {
        padding: 17px 20px;
        border-bottom: 1px solid var(--pm-border);
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .section-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: #eef1fa;
        color: var(--pm-navy);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .88rem;
        flex-shrink: 0;
    }

    .section-icon.orange {
        background: #fff0e9;
        color: var(--pm-orange);
    }

    .section-icon.green {
        background: #eaf8f1;
        color: var(--pm-success);
    }

    .section-title {
        color: var(--pm-text);
        font-size: .88rem;
        font-weight: 750;
        margin: 0;
    }

    .section-description {
        color: #9097a3;
        font-size: .7rem;
        margin: 2px 0 0;
    }

    .card-section-body {
        padding: 20px;
    }

    /* =====================================================
       Tenant Profile
    ====================================================== */

    .tenant-profile {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .tenant-avatar {
        width: 52px;
        height: 52px;
        border-radius: 13px;
        background: #eef1fa;
        color: var(--pm-navy);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .tenant-name {
        color: var(--pm-text);
        font-size: .98rem;
        font-weight: 750;
        margin-bottom: 4px;
    }

    .tenant-contact {
        color: #858d9b;
        font-size: .74rem;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        color: #555d6b;
        font-size: .76rem;
    }

    .contact-item i {
        color: #8a919e;
        margin-top: 2px;
    }

    /* =====================================================
       Detail Grid
    ====================================================== */

    .detail-item {
        min-height: 60px;
    }

    .detail-label {
        color: #8b929f;
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .25px;
        margin-bottom: 5px;
    }

    .detail-value {
        color: #454d5b;
        font-size: .8rem;
        font-weight: 600;
        line-height: 1.45;
    }

    .detail-value strong {
        color: var(--pm-text);
    }

    /* =====================================================
       Property
    ====================================================== */

    .property-highlight {
        background: #f8f9fc;
        border: 1px solid #e7e9ef;
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 18px;
    }

    .property-label {
        color: #8c939f;
        font-size: .66rem;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: .3px;
        margin-bottom: 4px;
    }

    .property-title {
        color: var(--pm-navy);
        font-size: .9rem;
        font-weight: 750;
    }

    .unit-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        background: #fff0e9;
        color: var(--pm-orange);
        border-radius: 7px;
        font-size: .7rem;
        font-weight: 750;
    }

    /* =====================================================
       Financial Comparison
    ====================================================== */

    .financial-box {
        border: 1px solid var(--pm-border);
        border-radius: 10px;
        overflow: hidden;
    }

    .financial-header {
        background: #fafbfc;
        border-bottom: 1px solid var(--pm-border);
        padding: 10px 13px;
        color: #6f7785;
        font-size: .71rem;
        font-weight: 700;
    }

    .financial-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 11px 13px;
        border-bottom: 1px solid #eef0f3;
    }

    .financial-row:last-child {
        border-bottom: 0;
    }

    .financial-label {
        color: #777f8d;
        font-size: .74rem;
    }

    .financial-value {
        color: var(--pm-text);
        font-size: .76rem;
        font-weight: 700;
        text-align: right;
    }

    .financial-offer {
        color: var(--pm-orange);
    }

    /* =====================================================
       Notes
    ====================================================== */

    .notes-box {
        background: #fafbfc;
        border: 1px solid #e7e9ee;
        border-radius: 9px;
        padding: 14px;
        color: #626a78;
        font-size: .78rem;
        line-height: 1.65;
        white-space: pre-line;
    }

    .rejection-box {
        background: #fff5f5;
        border: 1px solid #f0cccc;
        border-radius: 9px;
        padding: 14px;
    }

    .rejection-title {
        color: #a33737;
        font-size: .75rem;
        font-weight: 750;
        margin-bottom: 5px;
    }

    .rejection-text {
        color: #744848;
        font-size: .77rem;
        line-height: 1.55;
    }

    /* =====================================================
       Sidebar Review
    ====================================================== */

    .review-card {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(25, 38, 93, .035);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .review-header {
        padding: 17px 19px;
        border-bottom: 1px solid var(--pm-border);
    }

    .review-title {
        color: var(--pm-text);
        font-size: .9rem;
        font-weight: 750;
        margin: 0;
    }

    .review-body {
        padding: 18px;
    }

    .review-status-box {
        background: #f8f9fc;
        border: 1px solid #e7e9ef;
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 17px;
    }

    .review-status-label {
        color: #8b929f;
        font-size: .66rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .3px;
        margin-bottom: 8px;
    }

    .review-action {
        width: 100%;
        min-height: 42px;
        border-radius: 8px;
        font-size: .8rem;
        font-weight: 650;
    }

    .btn-approve {
        background: var(--pm-success);
        border-color: var(--pm-success);
        color: #fff;
    }

    .btn-approve:hover {
        background: #117348;
        border-color: #117348;
        color: #fff;
    }

    .btn-reject {
        background: #fff;
        border: 1px solid #e4bcbc;
        color: var(--pm-danger);
    }

    .btn-reject:hover {
        background: #fff5f5;
        border-color: #d99a9a;
        color: var(--pm-danger);
    }

    .btn-lease {
        background: var(--pm-orange);
        border-color: var(--pm-orange);
        color: #fff;
    }

    .btn-lease:hover {
        background: #b94705;
        border-color: #b94705;
        color: #fff;
    }

    .review-info {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        padding-top: 14px;
        margin-top: 14px;
        border-top: 1px solid #eef0f3;
    }

    .review-info i {
        color: #8d95a3;
        font-size: .85rem;
        margin-top: 2px;
    }

    .review-info-label {
        color: #9299a5;
        font-size: .66rem;
        margin-bottom: 2px;
    }

    .review-info-value {
        color: #505866;
        font-size: .74rem;
        font-weight: 650;
    }

    /* =====================================================
       Timeline
    ====================================================== */

    .timeline {
        position: relative;
        padding-left: 23px;
    }

    .timeline::before {
        content: "";
        position: absolute;
        left: 5px;
        top: 4px;
        bottom: 4px;
        width: 1px;
        background: #e2e5ea;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 17px;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: -22px;
        top: 3px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--pm-navy);
        border: 2px solid #fff;
        box-shadow: 0 0 0 1px #dce0e7;
    }

    .timeline-title {
        color: #555d6b;
        font-size: .74rem;
        font-weight: 700;
    }

    .timeline-date {
        color: #969da8;
        font-size: .66rem;
        margin-top: 2px;
    }

    /* =====================================================
       Lease Card
    ====================================================== */

    .lease-success {
        background: #f0faf5;
        border: 1px solid #c9ead9;
        border-radius: 10px;
        padding: 14px;
    }

    .lease-success-title {
        color: #176c47;
        font-size: .78rem;
        font-weight: 750;
        margin-bottom: 4px;
    }

    .lease-success-text {
        color: #4f7765;
        font-size: .71rem;
        margin-bottom: 12px;
    }

    /* =====================================================
       Modal
    ====================================================== */

    .modal-content {
        border: 0;
        border-radius: 13px;
        overflow: hidden;
        box-shadow: 0 18px 50px rgba(25, 38, 93, .18);
    }

    .modal-header {
        border-bottom: 1px solid var(--pm-border);
        padding: 17px 19px;
    }

    .modal-title {
        color: var(--pm-text);
        font-size: .92rem;
        font-weight: 750;
    }

    .modal-body {
        padding: 19px;
    }

    .modal-footer {
        border-top: 1px solid var(--pm-border);
        padding: 13px 19px;
    }

    .modal-label {
        color: #555d6b;
        font-size: .75rem;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .modal textarea {
        border: 1px solid #dfe2e8;
        border-radius: 8px;
        font-size: .8rem;
        resize: vertical;
        box-shadow: none !important;
    }

    .modal textarea:focus {
        border-color: var(--pm-danger);
        box-shadow: 0 0 0 3px rgba(196, 61, 61, .06) !important;
    }

    /* =====================================================
       Responsive
    ====================================================== */

    @media (max-width: 767.98px) {

        .application-page {
            padding-top: 20px;
        }

        .page-title {
            font-size: 1.4rem;
        }

        .application-hero {
            padding: 16px;
        }

        .application-hero .header-actions {
            width: 100%;
        }

        .application-hero .header-actions > * {
            flex: 1;
            justify-content: center;
        }

        .card-section-header,
        .card-section-body {
            padding: 16px;
        }

        .review-body {
            padding: 16px;
        }

    }

    @media (max-width: 575.98px) {

        .application-hero .header-actions {
            flex-direction: column;
        }

        .application-hero .header-actions > * {
            width: 100%;
        }

    }
</style>


<div class="application-page">

    <div class="container-fluid px-3 px-lg-4">


        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <div>

                <div class="breadcrumb-text">

                    <a href="{{ route('property-management.dashboard') }}">
                        Property Management
                    </a>

                    <span class="mx-1">/</span>

                    <a href="{{ route('property-management.applications.index') }}">
                        Applications
                    </a>

                    <span class="mx-1">/</span>

                    <span>
                        Application #{{ $application->id }}
                    </span>

                </div>

                <h1 class="page-title">
                    Tenant Application
                </h1>

                <p class="page-subtitle">
                    Review application details, financial terms and tenant information.
                </p>

            </div>


            <div class="d-flex gap-2">

                <a href="{{ route('property-management.applications.index') }}"
                   class="back-btn">

                    <i class="bi bi-arrow-left"></i>

                    Applications

                </a>

                @if(in_array($application->status, ['pending', 'under_review']))

                    <a href="{{ route('property-management.applications.edit', $application) }}"
                       class="edit-btn">

                        <i class="bi bi-pencil"></i>

                        Edit

                    </a>

                @endif

            </div>

        </div>


        {{-- =====================================================
             FLASH MESSAGES
        ====================================================== --}}

        @if(session('success'))

            <div class="pm-alert pm-alert-success alert-dismissible fade show mb-4"
                 role="alert">

                <div class="d-flex align-items-center gap-2">

                    <i class="bi bi-check-circle-fill"></i>

                    <span>{{ session('success') }}</span>

                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        @if(session('error'))

            <div class="pm-alert pm-alert-danger alert-dismissible fade show mb-4"
                 role="alert">

                <div class="d-flex align-items-center gap-2">

                    <i class="bi bi-exclamation-circle-fill"></i>

                    <span>{{ session('error') }}</span>

                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- =====================================================
             APPLICATION HERO
        ====================================================== --}}

        @php

            $tenant = $application->tenant;
            $unit = $application->unit;

            $property = $unit?->floor?->building?->property;

            $tenantInitials = collect([
                $tenant?->first_name,
                $tenant?->last_name
            ])
            ->filter()
            ->map(fn($name) => strtoupper(substr($name, 0, 1)))
            ->join('');

            $tenantInitials = $tenantInitials ?: 'TN';

            $statusClasses = [
                'pending' => 'status-pending',
                'under_review' => 'status-review',
                'approved' => 'status-approved',
                'rejected' => 'status-rejected',
                'withdrawn' => 'status-withdrawn',
            ];

            $statusClass = $statusClasses[$application->status]
                ?? 'status-withdrawn';

        @endphp


        <div class="application-hero">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div class="d-flex align-items-center gap-3">

                    <div class="application-icon">

                        <i class="bi bi-file-earmark-text"></i>

                    </div>

                    <div>

                        <div class="application-id">
                            Application
                        </div>

                        <div class="application-number">
                            #{{ $application->id }}
                        </div>

                        <div class="application-meta">

                            @if($application->application_date)

                                Submitted
                                {{ $application->application_date->format('d M Y') }}

                            @else

                                Application date not recorded

                            @endif

                        </div>

                    </div>

                </div>


                <span class="status-pill {{ $statusClass }}">

                    <span class="status-dot"></span>

                    {{ ucwords(str_replace('_', ' ', $application->status)) }}

                </span>

            </div>

        </div>


        <div class="row g-4">


            {{-- =================================================
                 MAIN CONTENT
            ================================================== --}}

            <div class="col-xl-8">


                {{-- =================================================
                     TENANT
                ================================================== --}}

                <div class="content-card">

                    <div class="card-section-header">

                        <div class="section-icon">

                            <i class="bi bi-person"></i>

                        </div>

                        <div>

                            <h2 class="section-title">
                                Applicant Information
                            </h2>

                            <p class="section-description">
                                Tenant information associated with this application.
                            </p>

                        </div>

                    </div>


                    <div class="card-section-body">

                        <div class="row g-4 align-items-center">

                            <div class="col-md-6">

                                <div class="tenant-profile">

                                    <div class="tenant-avatar">
                                        {{ $tenantInitials }}
                                    </div>

                                    <div>

                                        <div class="tenant-name">

                                            {{ $tenant?->full_name ?? 'Unknown Tenant' }}

                                        </div>

                                        <div class="tenant-contact">

                                            Tenant ID:
                                            {{ $tenant?->id ?? '—' }}

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-3">

                                <div class="contact-item">

                                    <i class="bi bi-telephone"></i>

                                    <div>

                                        <div class="detail-label">
                                            Phone
                                        </div>

                                        {{ $tenant?->phone ?? 'Not provided' }}

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-3">

                                <div class="contact-item">

                                    <i class="bi bi-envelope"></i>

                                    <div>

                                        <div class="detail-label">
                                            Email
                                        </div>

                                        {{ $tenant?->email ?? 'Not provided' }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     REQUESTED UNIT
                ================================================== --}}

                <div class="content-card">

                    <div class="card-section-header">

                        <div class="section-icon orange">

                            <i class="bi bi-building"></i>

                        </div>

                        <div>

                            <h2 class="section-title">
                                Requested Property & Unit
                            </h2>

                            <p class="section-description">
                                Property and unit selected by the applicant.
                            </p>

                        </div>

                    </div>


                    <div class="card-section-body">

                        @if($property)

                            <div class="property-highlight">

                                <div class="property-label">
                                    Property
                                </div>

                                <div class="property-title">
                                    {{ $property->title }}
                                </div>

                            </div>

                        @endif


                        <div class="row g-4">

                            <div class="col-md-4">

                                <div class="detail-item">

                                    <div class="detail-label">
                                        Building
                                    </div>

                                    <div class="detail-value">

                                        {{ $unit?->floor?->building?->name ?? 'Not available' }}

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="detail-item">

                                    <div class="detail-label">
                                        Floor
                                    </div>

                                    <div class="detail-value">

                                        {{ $unit?->floor?->name ?? 'Not available' }}

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="detail-item">

                                    <div class="detail-label">
                                        Unit
                                    </div>

                                    <div class="detail-value">

                                        @if($unit)

                                            <span class="unit-badge">

                                                Unit {{ $unit->unit_number }}

                                            </span>

                                        @else

                                            Not available

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     FINANCIAL INFORMATION
                ================================================== --}}

                <div class="content-card">

                    <div class="card-section-header">

                        <div class="section-icon green">

                            <i class="bi bi-cash-stack"></i>

                        </div>

                        <div>

                            <h2 class="section-title">
                                Financial Terms
                            </h2>

                            <p class="section-description">
                                Compare the unit's current terms with the tenant's offer.
                            </p>

                        </div>

                    </div>


                    <div class="card-section-body">

                        <div class="financial-box">

                            <div class="financial-header">

                                Financial comparison

                            </div>


                            <div class="financial-row">

                                <span class="financial-label">
                                    Current Unit Rent
                                </span>

                                <span class="financial-value">

                                    RWF
                                    {{ number_format((float) ($unit?->rent ?? 0)) }}

                                </span>

                            </div>


                            <div class="financial-row">

                                <span class="financial-label">
                                    Offered Rent
                                </span>

                                <span class="financial-value financial-offer">

                                    RWF
                                    {{ number_format((float) ($application->offered_rent ?? 0)) }}

                                </span>

                            </div>


                            <div class="financial-row">

                                <span class="financial-label">
                                    Current Unit Deposit
                                </span>

                                <span class="financial-value">

                                    RWF
                                    {{ number_format((float) ($unit?->deposit ?? 0)) }}

                                </span>

                            </div>


                            <div class="financial-row">

                                <span class="financial-label">
                                    Offered Deposit
                                </span>

                                <span class="financial-value financial-offer">

                                    RWF
                                    {{ number_format((float) ($application->offered_deposit ?? 0)) }}

                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     APPLICATION DETAILS
                ================================================== --}}

                <div class="content-card">

                    <div class="card-section-header">

                        <div class="section-icon">

                            <i class="bi bi-file-text"></i>

                        </div>

                        <div>

                            <h2 class="section-title">
                                Application Details
                            </h2>

                            <p class="section-description">
                                Dates and additional information submitted with the application.
                            </p>

                        </div>

                    </div>


                    <div class="card-section-body">

                        <div class="row g-4 mb-4">

                            <div class="col-md-4">

                                <div class="detail-item">

                                    <div class="detail-label">
                                        Application Date
                                    </div>

                                    <div class="detail-value">

                                        {{ $application->application_date?->format('d M Y') ?? 'Not specified' }}

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="detail-item">

                                    <div class="detail-label">
                                        Preferred Move-in
                                    </div>

                                    <div class="detail-value">

                                        {{ $application->preferred_move_in_date?->format('d M Y') ?? 'Not specified' }}

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="detail-item">

                                    <div class="detail-label">
                                        Submitted
                                    </div>

                                    <div class="detail-value">

                                        @if($application->application_date)

                                            {{ $application->application_date->diffForHumans() }}

                                        @else

                                            —

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div>

                            <div class="detail-label mb-2">
                                Applicant Notes
                            </div>

                            <div class="notes-box">

                                {{ $application->notes ?: 'No additional notes were provided with this application.' }}

                            </div>

                        </div>


                        @if($application->rejection_reason)

                            <div class="mt-4">

                                <div class="rejection-box">

                                    <div class="rejection-title">

                                        <i class="bi bi-exclamation-circle me-1"></i>

                                        Rejection Reason

                                    </div>

                                    <div class="rejection-text">

                                        {{ $application->rejection_reason }}

                                    </div>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                     REVIEW HISTORY
                ================================================== --}}

                @if($application->reviewer || $application->reviewed_at)

                    <div class="content-card">

                        <div class="card-section-header">

                            <div class="section-icon">

                                <i class="bi bi-clock-history"></i>

                            </div>

                            <div>

                                <h2 class="section-title">
                                    Review History
                                </h2>

                                <p class="section-description">
                                    Information about the application review.
                                </p>

                            </div>

                        </div>


                        <div class="card-section-body">

                            <div class="timeline">

                                <div class="timeline-item">

                                    <span class="timeline-dot"></span>

                                    <div class="timeline-title">

                                        Application reviewed

                                    </div>

                                    <div class="timeline-date">

                                        @if($application->reviewed_at)

                                            {{ $application->reviewed_at->format('d M Y, H:i') }}

                                        @else

                                            Review date not recorded

                                        @endif

                                        @if($application->reviewer)

                                            · {{ $application->reviewer->name }}

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endif


            </div>


            {{-- =================================================
                 SIDEBAR
            ================================================== --}}

            <div class="col-xl-4">


                {{-- =================================================
                     REVIEW CARD
                ================================================== --}}

                <div class="review-card">

                    <div class="review-header">

                        <h2 class="review-title">
                            Application Review
                        </h2>

                    </div>


                    <div class="review-body">

                        <div class="review-status-box">

                            <div class="review-status-label">
                                Current Status
                            </div>

                            <span class="status-pill {{ $statusClass }}">

                                <span class="status-dot"></span>

                                {{ ucwords(str_replace('_', ' ', $application->status)) }}

                            </span>

                        </div>


                        {{-- =========================================
                             PENDING / UNDER REVIEW
                        ========================================== --}}

                        @if(in_array($application->status, ['pending', 'under_review']))

                            <form method="POST"
                                  action="{{ route('property-management.applications.approve', $application) }}"
                                  class="mb-2">

                                @csrf

                                <button type="submit"
                                        class="btn review-action btn-approve"
                                        onclick="return confirm('Approve this tenant application?');">

                                    <i class="bi bi-check-circle me-1"></i>

                                    Approve Application

                                </button>

                            </form>


                            <button type="button"
                                    class="btn review-action btn-reject"
                                    data-bs-toggle="modal"
                                    data-bs-target="#rejectApplicationModal">

                                <i class="bi bi-x-circle me-1"></i>

                                Reject Application

                            </button>


                            @if($application->reviewer)

                                <div class="review-info">

                                    <i class="bi bi-person-check"></i>

                                    <div>

                                        <div class="review-info-label">
                                            Last Reviewed By
                                        </div>

                                        <div class="review-info-value">
                                            {{ $application->reviewer->name }}
                                        </div>

                                    </div>

                                </div>

                            @endif


                        {{-- =========================================
                             APPROVED
                        ========================================== --}}

                        @elseif($application->status === 'approved')

                            <div class="lease-success mb-3">

                                <div class="lease-success-title">

                                    <i class="bi bi-check-circle-fill me-1"></i>

                                    Application Approved

                                </div>

                                <div class="lease-success-text">

                                    This application has been approved and can proceed
                                    to lease creation.

                                </div>


                                @if(!$application->lease)

                                    <a href="{{ route(
                                        'property-management.leases.create',
                                        ['application' => $application->id]
                                    ) }}"
                                       class="btn review-action btn-lease">

                                        <i class="bi bi-file-earmark-plus me-1"></i>

                                        Create Lease

                                    </a>

                                @else

                                    <a href="{{ route(
                                        'property-management.leases.show',
                                        $application->lease
                                    ) }}"
                                       class="btn review-action btn-lease">

                                        <i class="bi bi-file-earmark-text me-1"></i>

                                        View Lease

                                    </a>

                                @endif

                            </div>


                            @if($application->reviewer)

                                <div class="review-info">

                                    <i class="bi bi-person-check"></i>

                                    <div>

                                        <div class="review-info-label">
                                            Approved / Reviewed By
                                        </div>

                                        <div class="review-info-value">
                                            {{ $application->reviewer->name }}
                                        </div>

                                    </div>

                                </div>

                            @endif


                            @if($application->reviewed_at)

                                <div class="review-info">

                                    <i class="bi bi-calendar-check"></i>

                                    <div>

                                        <div class="review-info-label">
                                            Review Date
                                        </div>

                                        <div class="review-info-value">

                                            {{ $application->reviewed_at->format('d M Y, H:i') }}

                                        </div>

                                    </div>

                                </div>

                            @endif


                        {{-- =========================================
                             REJECTED
                        ========================================== --}}

                        @elseif($application->status === 'rejected')

                            <div class="rejection-box">

                                <div class="rejection-title">

                                    <i class="bi bi-x-circle-fill me-1"></i>

                                    Application Rejected

                                </div>

                                <div class="rejection-text">

                                    @if($application->rejection_reason)

                                        {{ $application->rejection_reason }}

                                    @else

                                        No rejection reason was recorded.

                                    @endif

                                </div>

                            </div>


                            @if($application->reviewer)

                                <div class="review-info">

                                    <i class="bi bi-person-x"></i>

                                    <div>

                                        <div class="review-info-label">
                                            Rejected By
                                        </div>

                                        <div class="review-info-value">
                                            {{ $application->reviewer->name }}
                                        </div>

                                    </div>

                                </div>

                            @endif


                        {{-- =========================================
                             WITHDRAWN
                        ========================================== --}}

                        @elseif($application->status === 'withdrawn')

                            <div class="review-status-box mb-0">

                                <div class="review-status-label">
                                    Application State
                                </div>

                                <div class="detail-value">

                                    This application has been withdrawn
                                    and is no longer active.

                                </div>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                     APPLICATION SUMMARY
                ================================================== --}}

                <div class="review-card">

                    <div class="review-header">

                        <h2 class="review-title">
                            Application Summary
                        </h2>

                    </div>


                    <div class="review-body">

                        <div class="detail-item mb-3">

                            <div class="detail-label">
                                Application Date
                            </div>

                            <div class="detail-value">

                                {{ $application->application_date?->format('d M Y') ?? 'Not specified' }}

                            </div>

                        </div>


                        <div class="detail-item mb-3">

                            <div class="detail-label">
                                Preferred Move-in
                            </div>

                            <div class="detail-value">

                                {{ $application->preferred_move_in_date?->format('d M Y') ?? 'Not specified' }}

                            </div>

                        </div>


                        <div class="detail-item mb-3">

                            <div class="detail-label">
                                Offered Rent
                            </div>

                            <div class="detail-value">

                                RWF
                                {{ number_format((float) ($application->offered_rent ?? 0)) }}

                            </div>

                        </div>


                        <div class="detail-item">

                            <div class="detail-label">
                                Offered Deposit
                            </div>

                            <div class="detail-value">

                                RWF
                                {{ number_format((float) ($application->offered_deposit ?? 0)) }}

                            </div>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     REJECT APPLICATION MODAL
============================================================== --}}

@if(in_array($application->status, ['pending', 'under_review']))

    <div class="modal fade"
         id="rejectApplicationModal"
         tabindex="-1"
         aria-labelledby="rejectApplicationModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <form method="POST"
                      action="{{ route('property-management.applications.reject', $application) }}">

                    @csrf

                    <div class="modal-header">

                        <div>

                            <h5 class="modal-title"
                                id="rejectApplicationModalLabel">

                                Reject Application

                            </h5>

                            <div class="text-muted small mt-1">

                                Application #{{ $application->id }}

                            </div>

                        </div>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                        </button>

                    </div>


                    <div class="modal-body">

                        <div class="alert alert-danger py-2 px-3 small">

                            <i class="bi bi-exclamation-triangle me-1"></i>

                            This action will mark the tenant application as
                            <strong>rejected</strong>.

                        </div>


                        <label class="modal-label">

                            Rejection Reason
                            <span class="text-danger">*</span>

                        </label>

                        <textarea name="rejection_reason"
                                  class="form-control"
                                  rows="5"
                                  required
                                  placeholder="Explain why this application is being rejected..."></textarea>

                        <div class="text-muted mt-2"
                             style="font-size:.69rem;">

                            Provide a clear reason so the decision can be
                            properly documented.

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-light"
                                style="font-size:.78rem;"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit"
                                class="btn btn-danger"
                                style="font-size:.78rem;">

                            <i class="bi bi-x-circle me-1"></i>

                            Reject Application

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endif

@endsection