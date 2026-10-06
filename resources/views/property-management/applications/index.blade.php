@extends('layouts.property-management')

@section('title', 'Tenant Applications - Property Management')

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
        --pm-warning: #b77900;
        --pm-danger: #c43d3d;
        --pm-info: #2877a8;
    }

    .applications-page {
        background: var(--pm-bg);
        min-height: calc(100vh - 80px);
        padding: 28px 0 50px;
    }

    /* --------------------------------------------------
       Header
    -------------------------------------------------- */

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
        font-size: 1.65rem;
        font-weight: 750;
        letter-spacing: -.45px;
        margin-bottom: 5px;
    }

    .page-subtitle {
        color: var(--pm-muted);
        font-size: .86rem;
        margin-bottom: 0;
    }

    .btn-new-application {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 42px;
        padding: 9px 16px;
        border-radius: 8px;
        border: 1px solid var(--pm-orange);
        background: var(--pm-orange);
        color: #fff;
        font-size: .82rem;
        font-weight: 650;
        text-decoration: none;
        transition: .2s ease;
    }

    .btn-new-application:hover {
        background: #b94705;
        border-color: #b94705;
        color: #fff;
        transform: translateY(-1px);
    }

    /* --------------------------------------------------
       Alerts
    -------------------------------------------------- */

    .pm-alert {
        border-radius: 10px;
        border: 1px solid;
        font-size: .82rem;
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

    /* --------------------------------------------------
       KPI Cards
    -------------------------------------------------- */

    .stat-card {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 13px;
        padding: 17px 18px;
        box-shadow: 0 4px 18px rgba(25, 38, 93, .035);
        height: 100%;
    }

    .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }

    .stat-label {
        color: #858c99;
        font-size: .73rem;
        font-weight: 650;
        text-transform: uppercase;
        letter-spacing: .35px;
        margin-bottom: 6px;
    }

    .stat-value {
        color: var(--pm-text);
        font-size: 1.45rem;
        font-weight: 750;
        line-height: 1.1;
    }

    .stat-icon {
        width: 39px;
        height: 39px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .95rem;
        flex-shrink: 0;
    }

    .stat-icon.navy {
        background: #eef1fa;
        color: var(--pm-navy);
    }

    .stat-icon.orange {
        background: #fff0e9;
        color: var(--pm-orange);
    }

    .stat-icon.green {
        background: #eaf8f1;
        color: var(--pm-success);
    }

    .stat-icon.yellow {
        background: #fff8e8;
        color: var(--pm-warning);
    }

    /* --------------------------------------------------
       Filter Card
    -------------------------------------------------- */

    .filter-card {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 13px;
        box-shadow: 0 4px 18px rgba(25, 38, 93, .035);
        padding: 18px;
    }

    .filter-heading {
        color: var(--pm-text);
        font-size: .86rem;
        font-weight: 750;
        margin-bottom: 3px;
    }

    .filter-description {
        color: #8a919e;
        font-size: .73rem;
        margin-bottom: 17px;
    }

    .field-label {
        display: block;
        color: #555d6b;
        font-size: .74rem;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .search-wrapper {
        position: relative;
    }

    .search-wrapper i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #9299a5;
        font-size: .88rem;
        z-index: 2;
    }

    .search-wrapper .form-control {
        padding-left: 36px;
    }

    .filter-card .form-control,
    .filter-card .form-select {
        min-height: 42px;
        border: 1px solid #dfe2e8;
        border-radius: 8px;
        font-size: .81rem;
        color: var(--pm-text);
        box-shadow: none !important;
    }

    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: var(--pm-navy);
        box-shadow: 0 0 0 3px rgba(25, 38, 93, .06) !important;
    }

    .filter-actions {
        display: flex;
        gap: 8px;
    }

    .btn-filter {
        min-height: 42px;
        border-radius: 8px;
        padding: 8px 17px;
        background: var(--pm-navy);
        border: 1px solid var(--pm-navy);
        color: #fff;
        font-size: .8rem;
        font-weight: 650;
    }

    .btn-filter:hover {
        background: #111c4b;
        border-color: #111c4b;
        color: #fff;
    }

    .btn-reset {
        min-height: 42px;
        border-radius: 8px;
        padding: 8px 15px;
        background: #fff;
        border: 1px solid #dfe2e8;
        color: #626a78;
        font-size: .8rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-reset:hover {
        background: #f7f8fa;
        color: var(--pm-navy);
    }

    /* --------------------------------------------------
       Table
    -------------------------------------------------- */

    .applications-card {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 13px;
        box-shadow: 0 4px 18px rgba(25, 38, 93, .035);
        overflow: hidden;
    }

    .table-header {
        padding: 17px 20px;
        border-bottom: 1px solid var(--pm-border);
    }

    .table-title {
        color: var(--pm-text);
        font-size: .9rem;
        font-weight: 750;
        margin-bottom: 2px;
    }

    .table-subtitle {
        color: #8a919e;
        font-size: .72rem;
        margin: 0;
    }

    .record-count {
        color: #747c8c;
        background: #f5f6f9;
        border: 1px solid #e7e9ee;
        border-radius: 7px;
        padding: 5px 9px;
        font-size: .7rem;
        font-weight: 650;
    }

    .applications-table {
        margin-bottom: 0;
        min-width: 1050px;
    }

    .applications-table thead th {
        background: #fafbfc;
        border-bottom: 1px solid var(--pm-border);
        color: #737b89;
        font-size: .68rem;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: .35px;
        white-space: nowrap;
        padding: 13px 14px;
    }

    .applications-table tbody td {
        border-bottom: 1px solid #eef0f3;
        padding: 14px;
        color: #4c5462;
        font-size: .78rem;
        vertical-align: middle;
    }

    .applications-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .applications-table tbody tr {
        transition: background .15s ease;
    }

    .applications-table tbody tr:hover {
        background: #fbfcfe;
    }

    .tenant-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 190px;
    }

    .tenant-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #eef1fa;
        color: var(--pm-navy);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .72rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .tenant-name {
        color: var(--pm-text);
        font-size: .8rem;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .tenant-phone {
        color: #9299a5;
        font-size: .7rem;
    }

    .unit-number {
        color: var(--pm-navy);
        font-weight: 750;
        font-size: .8rem;
    }

    .property-name {
        color: #4f5765;
        font-weight: 600;
        max-width: 190px;
        line-height: 1.35;
    }

    .date-main {
        color: #4f5765;
        font-weight: 600;
        white-space: nowrap;
    }

    .date-secondary {
        color: #9a9faa;
        font-size: .67rem;
        margin-top: 2px;
        white-space: nowrap;
    }

    .money-value {
        color: var(--pm-text);
        font-size: .78rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .money-label {
        color: #969da8;
        font-size: .65rem;
        margin-top: 2px;
    }

    /* --------------------------------------------------
       Status
    -------------------------------------------------- */

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: .67rem;
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

    .status-default {
        background: #f0f1f3;
        color: #707783;
    }

    /* --------------------------------------------------
       Review information
    -------------------------------------------------- */

    .reviewer-name {
        color: #535b68;
        font-size: .74rem;
        font-weight: 650;
        white-space: nowrap;
    }

    .reviewed-date {
        color: #969da8;
        font-size: .66rem;
        margin-top: 2px;
        white-space: nowrap;
    }

    .not-reviewed {
        color: #a1a6af;
        font-size: .7rem;
        font-style: italic;
    }

    /* --------------------------------------------------
       Actions
    -------------------------------------------------- */

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 5px;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e0e3e8;
        background: #fff;
        color: #68707e;
        text-decoration: none;
        font-size: .82rem;
        transition: .15s ease;
    }

    .action-btn:hover {
        color: var(--pm-navy);
        border-color: #cbd1dc;
        background: #f8f9fb;
    }

    .action-btn.edit:hover {
        color: var(--pm-orange);
        border-color: #f1c8b5;
        background: #fff8f4;
    }

    /* --------------------------------------------------
       Empty state
    -------------------------------------------------- */

    .empty-state {
        padding: 65px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 15px;
        border-radius: 14px;
        background: #f1f3f8;
        color: #81899a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }

    .empty-title {
        color: var(--pm-text);
        font-size: .92rem;
        font-weight: 750;
        margin-bottom: 5px;
    }

    .empty-description {
        color: #9299a5;
        font-size: .75rem;
        max-width: 390px;
        margin: 0 auto;
    }

    .pagination-wrapper {
        padding: 15px 20px;
        border-top: 1px solid var(--pm-border);
    }

    .pagination-wrapper .pagination {
        margin-bottom: 0;
    }

    /* --------------------------------------------------
       Responsive
    -------------------------------------------------- */

    @media (max-width: 767.98px) {

        .applications-page {
            padding-top: 20px;
        }

        .page-title {
            font-size: 1.4rem;
        }

        .btn-new-application {
            width: 100%;
            justify-content: center;
        }

        .filter-actions {
            width: 100%;
        }

        .btn-filter,
        .btn-reset {
            flex: 1;
        }

        .table-header {
            padding: 15px;
        }

        .pagination-wrapper {
            padding: 14px;
        }
    }

    @media (max-width: 575.98px) {

        .stat-value {
            font-size: 1.25rem;
        }

        .filter-card {
            padding: 15px;
        }

        .record-count {
            display: none;
        }
    }
</style>

<div class="applications-page">

    <div class="container-fluid px-3 px-lg-4">

        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">

            <div>

                <div class="breadcrumb-text">
                    <a href="{{ route('property-management.dashboard') }}">
                        Property Management
                    </a>

                    <span class="mx-1">/</span>

                    <span>Tenant Applications</span>
                </div>

                <h1 class="page-title">
                    Tenant Applications
                </h1>

                <p class="page-subtitle">
                    Review, evaluate and manage applications submitted for available units.
                </p>

            </div>

            <a href="{{ route('property-management.applications.create') }}"
               class="btn-new-application">

                <i class="bi bi-file-earmark-plus"></i>

                New Application

            </a>

        </div>


        {{-- =====================================================
             ALERTS
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
             KPI STATISTICS
        ====================================================== --}}

        @php

            /*
             * These use the currently loaded collection.
             *
             * For accurate global statistics across all paginated
             * records, pass separate counts from the controller.
             */

            $totalApplications = $applications->total();

            $pendingApplications = $applications
                ->where('status', 'pending')
                ->count();

            $underReviewApplications = $applications
                ->where('status', 'under_review')
                ->count();

            $approvedApplications = $applications
                ->where('status', 'approved')
                ->count();

        @endphp

        <div class="row g-3 mb-4">

            <div class="col-xl-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-top">

                        <div>

                            <div class="stat-label">
                                Total Applications
                            </div>

                            <div class="stat-value">
                                {{ number_format($totalApplications) }}
                            </div>

                        </div>

                        <div class="stat-icon navy">
                            <i class="bi bi-files"></i>
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-xl-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-top">

                        <div>

                            <div class="stat-label">
                                Pending
                            </div>

                            <div class="stat-value">
                                {{ number_format($pendingApplications) }}
                            </div>

                        </div>

                        <div class="stat-icon yellow">
                            <i class="bi bi-hourglass-split"></i>
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-xl-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-top">

                        <div>

                            <div class="stat-label">
                                Under Review
                            </div>

                            <div class="stat-value">
                                {{ number_format($underReviewApplications) }}
                            </div>

                        </div>

                        <div class="stat-icon orange">
                            <i class="bi bi-search"></i>
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-xl-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-top">

                        <div>

                            <div class="stat-label">
                                Approved
                            </div>

                            <div class="stat-value">
                                {{ number_format($approvedApplications) }}
                            </div>

                        </div>

                        <div class="stat-icon green">
                            <i class="bi bi-check2-circle"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             FILTERS
        ====================================================== --}}

        <div class="filter-card mb-4">

            <div class="filter-heading">
                Search & Filters
            </div>

            <div class="filter-description">
                Find applications by tenant, phone number, unit or application status.
            </div>

            <form method="GET"
                  action="{{ route('property-management.applications.index') }}">

                <div class="row g-3 align-items-end">

                    <div class="col-xl-5 col-lg-5">

                        <label class="field-label">
                            Search Applications
                        </label>

                        <div class="search-wrapper">

                            <i class="bi bi-search"></i>

                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="form-control"
                                   placeholder="Tenant name, phone or unit number">

                        </div>

                    </div>


                    <div class="col-xl-3 col-lg-3 col-md-5">

                        <label class="field-label">
                            Application Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="">
                                All statuses
                            </option>

                            @foreach([
                                'pending' => 'Pending',
                                'under_review' => 'Under Review',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                                'withdrawn' => 'Withdrawn',
                            ] as $value => $label)

                                <option value="{{ $value }}"
                                    @selected(request('status') === $value)>
                                    {{ $label }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-xl-4 col-lg-4 col-md-7">

                        <div class="filter-actions">

                            <button type="submit"
                                    class="btn btn-filter">

                                <i class="bi bi-search me-1"></i>
                                Apply Filters

                            </button>

                            <a href="{{ route('property-management.applications.index') }}"
                               class="btn-reset">

                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                Reset

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>


        {{-- =====================================================
             APPLICATION TABLE
        ====================================================== --}}

        <div class="applications-card">

            <div class="table-header">

                <div class="d-flex justify-content-between align-items-center gap-3">

                    <div>

                        <div class="table-title">
                            Application Records
                        </div>

                        <p class="table-subtitle">
                            Tenant applications and their current review status.
                        </p>

                    </div>

                    <span class="record-count">

                        {{ $applications->total() }}

                        {{ Str::plural('application', $applications->total()) }}

                    </span>

                </div>

            </div>


            <div class="table-responsive">

                <table class="table applications-table align-middle">

                    <thead>

                        <tr>

                            <th class="ps-4">
                                Tenant
                            </th>

                            <th>
                                Unit
                            </th>

                            <th>
                                Property
                            </th>

                            <th>
                                Applied
                            </th>

                            <th>
                                Move-in
                            </th>

                            <th>
                                Financial Offer
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Reviewed By
                            </th>

                            <th class="text-end pe-4">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($applications as $application)

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
                                    ?? 'status-default';

                            @endphp

                            <tr>

                                {{-- Tenant --}}

                                <td class="ps-4">

                                    <div class="tenant-cell">

                                        <div class="tenant-avatar">
                                            {{ $tenantInitials }}
                                        </div>

                                        <div>

                                            <div class="tenant-name">

                                                {{ $tenant?->full_name ?? 'Unknown Tenant' }}

                                            </div>

                                            <div class="tenant-phone">

                                                {{ $tenant?->phone ?? 'No phone number' }}

                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- Unit --}}

                                <td>

                                    @if($unit)

                                        <div class="unit-number">
                                            {{ $unit->unit_number }}
                                        </div>

                                    @else

                                        <span class="text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- Property --}}

                                <td>

                                    <div class="property-name">

                                        {{ $property?->title ?? 'Property unavailable' }}

                                    </div>

                                </td>


                                {{-- Application Date --}}

                                <td>

                                    @if($application->application_date)

                                        <div class="date-main">

                                            {{ $application->application_date->format('d M Y') }}

                                        </div>

                                        <div class="date-secondary">

                                            {{ $application->application_date->diffForHumans() }}

                                        </div>

                                    @else

                                        <span class="text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- Preferred Move-in --}}

                                <td>

                                    @if($application->preferred_move_in_date)

                                        <div class="date-main">

                                            {{ $application->preferred_move_in_date->format('d M Y') }}

                                        </div>

                                        <div class="date-secondary">
                                            Preferred move-in
                                        </div>

                                    @else

                                        <span class="text-muted">
                                            Not specified
                                        </span>

                                    @endif

                                </td>


                                {{-- Financial Offer --}}

                                <td>

                                    <div class="money-value">

                                        RWF
                                        {{ number_format((float) $application->offered_rent, 0) }}

                                    </div>

                                    <div class="money-label">

                                        Rent

                                        @if($application->offered_deposit !== null)

                                            · Deposit:
                                            RWF
                                            {{ number_format((float) $application->offered_deposit, 0) }}

                                        @endif

                                    </div>

                                </td>


                                {{-- Status --}}

                                <td>

                                    <span class="status-pill {{ $statusClass }}">

                                        <span class="status-dot"></span>

                                        {{ ucwords(str_replace('_', ' ', $application->status)) }}

                                    </span>

                                </td>


                                {{-- Reviewer --}}

                                <td>

                                    @if($application->reviewer)

                                        <div class="reviewer-name">

                                            {{ $application->reviewer->name }}

                                        </div>

                                        @if($application->reviewed_at)

                                            <div class="reviewed-date">

                                                {{ $application->reviewed_at->format('d M Y') }}

                                            </div>

                                        @endif

                                    @else

                                        <span class="not-reviewed">
                                            Not reviewed
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}

                                <td class="text-end pe-4">

                                    <div class="action-buttons">

                                        <a href="{{ route('property-management.applications.show', $application) }}"
                                           class="action-btn"
                                           data-bs-toggle="tooltip"
                                           title="View application">

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        @if(in_array($application->status, ['pending', 'under_review']))

                                            <a href="{{ route('property-management.applications.edit', $application) }}"
                                               class="action-btn edit"
                                               data-bs-toggle="tooltip"
                                               title="Edit application">

                                                <i class="bi bi-pencil"></i>

                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9">

                                    <div class="empty-state">

                                        <div class="empty-icon">

                                            <i class="bi bi-file-earmark-text"></i>

                                        </div>

                                        <div class="empty-title">
                                            No tenant applications found
                                        </div>

                                        <p class="empty-description">

                                            There are no applications matching your
                                            current search or filter criteria.

                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}

            @if($applications->hasPages())

                <div class="pagination-wrapper">

                    {{ $applications->withQueryString()->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const tooltipTriggerList =
            document.querySelectorAll('[data-bs-toggle="tooltip"]');

        [...tooltipTriggerList].map(function (tooltipTriggerEl) {

            return new bootstrap.Tooltip(tooltipTriggerEl);

        });

    });
</script>

@endsection