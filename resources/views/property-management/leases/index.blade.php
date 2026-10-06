@extends('layouts.property-management')

@section('title', 'Leases & Contracts - Property Management')

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
        --pm-warning: #a96d00;
        --pm-danger: #c43d3d;
        --pm-info: #27779f;
    }

    .leases-page {
        background: var(--pm-bg);
        min-height: calc(100vh - 80px);
        padding: 28px 0 50px;
    }

    /* =====================================================
       PAGE HEADER
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

    .btn-create-lease {
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

    .btn-create-lease:hover {
        background: #b94705;
        border-color: #b94705;
        color: #fff;
        transform: translateY(-1px);
    }

    /* =====================================================
       ALERTS
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
       STAT CARDS
    ====================================================== */

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
        font-size: .72rem;
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

    .stat-description {
        color: #9a9faa;
        font-size: .68rem;
        margin-top: 5px;
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

    /* =====================================================
       FILTERS
    ====================================================== */

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

    /* =====================================================
       TABLE CARD
    ====================================================== */

    .leases-card {
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

    .leases-table {
        margin-bottom: 0;
        min-width: 1250px;
    }

    .leases-table thead th {
        background: #fafbfc;
        border-bottom: 1px solid var(--pm-border);
        color: #737b89;
        font-size: .67rem;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: .35px;
        white-space: nowrap;
        padding: 13px 14px;
    }

    .leases-table tbody td {
        border-bottom: 1px solid #eef0f3;
        padding: 14px;
        color: #4c5462;
        font-size: .77rem;
        vertical-align: middle;
    }

    .leases-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .leases-table tbody tr {
        transition: background .15s ease;
    }

    .leases-table tbody tr:hover {
        background: #fbfcfe;
    }

    /* =====================================================
       LEASE
    ====================================================== */

    .lease-cell {
        min-width: 150px;
    }

    .lease-number {
        color: var(--pm-navy);
        font-size: .8rem;
        font-weight: 750;
        margin-bottom: 3px;
    }

    .lease-frequency {
        color: #9299a5;
        font-size: .68rem;
        text-transform: capitalize;
    }

    /* =====================================================
       TENANT
    ====================================================== */

    .tenant-cell {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 185px;
    }

    .tenant-avatar {
        width: 37px;
        height: 37px;
        border-radius: 10px;
        background: #eef1fa;
        color: var(--pm-navy);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .7rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .tenant-name {
        color: var(--pm-text);
        font-size: .79rem;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .tenant-phone {
        color: #9299a5;
        font-size: .67rem;
    }

    /* =====================================================
       UNIT / PROPERTY
    ====================================================== */

    .unit-number {
        color: var(--pm-navy);
        font-size: .79rem;
        font-weight: 750;
    }

    .property-name {
        color: #7d8491;
        font-size: .67rem;
        margin-top: 3px;
        max-width: 180px;
        line-height: 1.35;
    }

    /* =====================================================
       PERIOD
    ====================================================== */

    .period-date {
        color: #4e5664;
        font-size: .74rem;
        font-weight: 650;
        white-space: nowrap;
    }

    .period-arrow {
        color: #a0a5ae;
        margin: 0 3px;
    }

    .period-remaining {
        color: #9299a5;
        font-size: .65rem;
        margin-top: 3px;
    }

    .period-remaining.active {
        color: var(--pm-success);
        font-weight: 650;
    }

    .period-remaining.expired {
        color: var(--pm-danger);
    }

    /* =====================================================
       FINANCIAL
    ====================================================== */

    .money-value {
        color: var(--pm-text);
        font-size: .78rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .money-label {
        color: #969da8;
        font-size: .64rem;
        margin-top: 2px;
    }

    /* =====================================================
       SIGNING
    ====================================================== */

    .signed-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .68rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .signed-status.signed {
        color: var(--pm-success);
    }

    .signed-status.unsigned {
        color: var(--pm-warning);
    }

    .signed-date {
        color: #969da8;
        font-size: .63rem;
        margin-top: 3px;
    }

    /* =====================================================
       STATUS
    ====================================================== */

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

    .status-draft {
        background: #f0f1f3;
        color: #707783;
    }

    .status-pending {
        background: #fff7e6;
        color: #a96d00;
    }

    .status-active {
        background: #eaf8f1;
        color: #168653;
    }

    .status-expired {
        background: #edf7fc;
        color: #27779f;
    }

    .status-terminated {
        background: #fff0f0;
        color: #bf3d3d;
    }

    .status-cancelled {
        background: #f0f1f3;
        color: #555c68;
    }

    /* =====================================================
       ACTIONS
    ====================================================== */

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

    /* =====================================================
       EMPTY STATE
    ====================================================== */

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

    /* =====================================================
       RESPONSIVE
    ====================================================== */

    @media (max-width: 767.98px) {

        .leases-page {
            padding-top: 20px;
        }

        .page-title {
            font-size: 1.4rem;
        }

        .btn-create-lease {
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


<div class="leases-page">

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

                    <span>Leases & Contracts</span>

                </div>

                <h1 class="page-title">
                    Leases & Contracts
                </h1>

                <p class="page-subtitle">
                    Manage tenancy agreements, rental terms, signatures and contract status.
                </p>

            </div>


            <a href="{{ route('property-management.leases.create') }}"
               class="btn-create-lease">

                <i class="bi bi-file-earmark-plus"></i>

                Create Lease

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
             STATISTICS
        ====================================================== --}}

        @php

            $totalLeases = $leases->total();

            $activeLeases = $leases
                ->where('status', 'active')
                ->count();

            $pendingSignature = $leases
                ->where('status', 'pending_signature')
                ->count();

            $expiredLeases = $leases
                ->where('status', 'expired')
                ->count();

        @endphp


        <div class="row g-3 mb-4">


            {{-- Total --}}

            <div class="col-xl-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-top">

                        <div>

                            <div class="stat-label">
                                Total Leases
                            </div>

                            <div class="stat-value">
                                {{ number_format($totalLeases) }}
                            </div>

                            <div class="stat-description">
                                All lease records
                            </div>

                        </div>

                        <div class="stat-icon navy">
                            <i class="bi bi-files"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Active --}}

            <div class="col-xl-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-top">

                        <div>

                            <div class="stat-label">
                                Active Leases
                            </div>

                            <div class="stat-value">
                                {{ number_format($activeLeases) }}
                            </div>

                            <div class="stat-description">
                                Currently active contracts
                            </div>

                        </div>

                        <div class="stat-icon green">
                            <i class="bi bi-check2-circle"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Pending Signature --}}

            <div class="col-xl-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-top">

                        <div>

                            <div class="stat-label">
                                Pending Signature
                            </div>

                            <div class="stat-value">
                                {{ number_format($pendingSignature) }}
                            </div>

                            <div class="stat-description">
                                Awaiting completion
                            </div>

                        </div>

                        <div class="stat-icon yellow">
                            <i class="bi bi-pen"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Expired --}}

            <div class="col-xl-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-top">

                        <div>

                            <div class="stat-label">
                                Expired
                            </div>

                            <div class="stat-value">
                                {{ number_format($expiredLeases) }}
                            </div>

                            <div class="stat-description">
                                Contracts past end date
                            </div>

                        </div>

                        <div class="stat-icon orange">
                            <i class="bi bi-calendar-x"></i>
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
                Find leases by lease number, tenant, phone number or unit.
            </div>


            <form method="GET"
                  action="{{ route('property-management.leases.index') }}">

                <div class="row g-3 align-items-end">


                    <div class="col-xl-5 col-lg-5">

                        <label class="field-label">
                            Search Leases
                        </label>

                        <div class="search-wrapper">

                            <i class="bi bi-search"></i>

                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="form-control"
                                   placeholder="Lease number, tenant, phone or unit">

                        </div>

                    </div>


                    <div class="col-xl-3 col-lg-3 col-md-5">

                        <label class="field-label">
                            Contract Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="">
                                All statuses
                            </option>

                            @foreach([
                                'draft' => 'Draft',
                                'pending_signature' => 'Pending Signature',
                                'active' => 'Active',
                                'expired' => 'Expired',
                                'terminated' => 'Terminated',
                                'cancelled' => 'Cancelled',
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


                            <a href="{{ route('property-management.leases.index') }}"
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
             LEASE TABLE
        ====================================================== --}}

        <div class="leases-card">

            <div class="table-header">

                <div class="d-flex justify-content-between align-items-center gap-3">

                    <div>

                        <div class="table-title">
                            Lease Records
                        </div>

                        <p class="table-subtitle">
                            Tenancy contracts, rental terms and contract status.
                        </p>

                    </div>


                    <span class="record-count">

                        {{ $leases->total() }}

                        {{ Str::plural('lease', $leases->total()) }}

                    </span>

                </div>

            </div>


            <div class="table-responsive">

                <table class="table leases-table align-middle">

                    <thead>

                        <tr>

                            <th class="ps-4">
                                Lease
                            </th>

                            <th>
                                Tenant
                            </th>

                            <th>
                                Property / Unit
                            </th>

                            <th>
                                Lease Period
                            </th>

                            <th>
                                Financial Terms
                            </th>

                            <th>
                                Signature
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end pe-4">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($leases as $lease)

                            @php

                                $tenant = $lease->tenant;
                                $unit = $lease->unit;

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
                                    'draft' => 'status-draft',
                                    'pending_signature' => 'status-pending',
                                    'active' => 'status-active',
                                    'expired' => 'status-expired',
                                    'terminated' => 'status-terminated',
                                    'cancelled' => 'status-cancelled',
                                ];

                                $statusClass = $statusClasses[$lease->status]
                                    ?? 'status-draft';


                                /*
                                 * Calculate remaining days only where
                                 * an end date exists.
                                 */

                                $remainingDays = null;

                                if ($lease->end_date) {
                                    $remainingDays = now()
                                        ->startOfDay()
                                        ->diffInDays(
                                            $lease->end_date,
                                            false
                                        );
                                }

                            @endphp


                            <tr>


                                {{-- Lease --}}

                                <td class="ps-4">

                                    <div class="lease-cell">

                                        <div class="lease-number">

                                            {{ $lease->lease_number }}

                                        </div>

                                        <div class="lease-frequency">

                                            {{ ucwords(str_replace('_', ' ', $lease->payment_frequency ?? 'Not specified')) }}

                                        </div>

                                    </div>

                                </td>


                                {{-- Tenant --}}

                                <td>

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


                                {{-- Property / Unit --}}

                                <td>

                                    @if($unit)

                                        <div class="unit-number">

                                            Unit {{ $unit->unit_number }}

                                        </div>

                                        <div class="property-name">

                                            {{ $property?->title ?? 'Property unavailable' }}

                                        </div>

                                    @else

                                        <span class="text-muted">
                                            Unit unavailable
                                        </span>

                                    @endif

                                </td>


                                {{-- Lease Period --}}

                                <td>

                                    @if($lease->start_date || $lease->end_date)

                                        <div class="period-date">

                                            {{ $lease->start_date?->format('d M Y') ?? '—' }}

                                            <span class="period-arrow">
                                                →
                                            </span>

                                            {{ $lease->end_date?->format('d M Y') ?? '—' }}

                                        </div>


                                        @if($remainingDays !== null)

                                            @if($remainingDays > 0 && $lease->status === 'active')

                                                <div class="period-remaining active">

                                                    {{ $remainingDays }}
                                                    {{ Str::plural('day', $remainingDays) }}
                                                    remaining

                                                </div>

                                            @elseif($remainingDays === 0 && $lease->status === 'active')

                                                <div class="period-remaining expired">

                                                    Ends today

                                                </div>

                                            @elseif($remainingDays < 0)

                                                <div class="period-remaining expired">

                                                    Ended
                                                    {{ abs($remainingDays) }}
                                                    {{ Str::plural('day', abs($remainingDays)) }}
                                                    ago

                                                </div>

                                            @endif

                                        @endif

                                    @else

                                        <span class="text-muted">
                                            No period defined
                                        </span>

                                    @endif

                                </td>


                                {{-- Financial Terms --}}

                                <td>

                                    <div class="money-value">

                                        RWF
                                        {{ number_format((float) ($lease->monthly_rent ?? 0)) }}

                                    </div>

                                    <div class="money-label">

                                        Monthly rent

                                    </div>


                                    <div class="money-label mt-1">

                                        Deposit:
                                        RWF
                                        {{ number_format((float) ($lease->deposit_amount ?? 0)) }}

                                    </div>

                                </td>


                                {{-- Signature --}}

                                <td>

                                    @if($lease->signed_at)

                                        <div class="signed-status signed">

                                            <i class="bi bi-check-circle-fill"></i>

                                            Signed

                                        </div>

                                        <div class="signed-date">

                                            {{ $lease->signed_at->format('d M Y') }}

                                        </div>


                                        @if($lease->signer)

                                            <div class="signed-date">

                                                By {{ $lease->signer->name }}

                                            </div>

                                        @endif

                                    @else

                                        <div class="signed-status unsigned">

                                            <i class="bi bi-clock"></i>

                                            Not signed

                                        </div>

                                    @endif

                                </td>


                                {{-- Status --}}

                                <td>

                                    <span class="status-pill {{ $statusClass }}">

                                        <span class="status-dot"></span>

                                        {{ ucwords(str_replace('_', ' ', $lease->status)) }}

                                    </span>

                                </td>


                                {{-- Actions --}}

                                <td class="text-end pe-4">

                                    <div class="action-buttons">


                                        <a href="{{ route('property-management.leases.show', $lease) }}"
                                           class="action-btn"
                                           data-bs-toggle="tooltip"
                                           title="View lease">

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        @if(in_array($lease->status, ['draft', 'pending_signature']))

                                            <a href="{{ route('property-management.leases.edit', $lease) }}"
                                               class="action-btn edit"
                                               data-bs-toggle="tooltip"
                                               title="Edit lease">

                                                <i class="bi bi-pencil"></i>

                                            </a>

                                        @endif


                                    </div>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="8">

                                    <div class="empty-state">

                                        <div class="empty-icon">

                                            <i class="bi bi-file-earmark-text"></i>

                                        </div>

                                        <div class="empty-title">

                                            No leases found

                                        </div>

                                        <p class="empty-description">

                                            There are no lease records matching your
                                            current search or filter criteria.

                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =================================================
                 PAGINATION
            ================================================== --}}

            @if($leases->hasPages())

                <div class="pagination-wrapper">

                    {{ $leases->withQueryString()->links() }}

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