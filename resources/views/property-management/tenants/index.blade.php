@extends('layouts.property-management')

@section('title', 'Tenants - Property Management')

@section('content')

<style>
    :root {
        --pm-navy: #19265d;
        --pm-orange: #D05208;
        --pm-bg: #f6f7fb;
        --pm-border: #e8eaf0;
        --pm-muted: #6b7280;
        --pm-text: #202636;
    }

    .tenant-page {
        background: var(--pm-bg);
        min-height: calc(100vh - 80px);
        padding: 28px 0 45px;
    }

    .page-title {
        color: var(--pm-navy);
        font-size: 1.65rem;
        font-weight: 750;
        letter-spacing: -0.4px;
    }

    .page-subtitle {
        color: #7a8190;
        font-size: .9rem;
    }

    .btn-add-tenant {
        background: var(--pm-orange);
        border: 1px solid var(--pm-orange);
        color: #fff;
        font-weight: 600;
        border-radius: 9px;
        padding: 10px 17px;
        transition: .2s ease;
    }

    .btn-add-tenant:hover {
        background: #b94705;
        border-color: #b94705;
        color: #fff;
        transform: translateY(-1px);
    }

    /* KPI cards */

    .stat-card {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 14px;
        padding: 18px;
        height: 100%;
        transition: .2s ease;
    }

    .stat-card:hover {
        border-color: #d9dce5;
        transform: translateY(-1px);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .stat-icon.total {
        background: #eef1ff;
        color: var(--pm-navy);
    }

    .stat-icon.verified {
        background: #eaf8f1;
        color: #168653;
    }

    .stat-icon.pending {
        background: #fff6e8;
        color: #b66a00;
    }

    .stat-icon.active {
        background: #edf7ff;
        color: #1769aa;
    }

    .stat-label {
        color: #7a8190;
        font-size: .78rem;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .stat-value {
        color: var(--pm-text);
        font-size: 1.35rem;
        font-weight: 750;
        line-height: 1;
    }

    /* Main cards */

    .pm-card {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(25, 38, 93, .035);
    }

    .filter-card {
        padding: 20px;
    }

    .filter-title {
        color: var(--pm-text);
        font-size: .95rem;
        font-weight: 700;
    }

    .filter-label {
        color: #5f6675;
        font-size: .76rem;
        font-weight: 650;
        margin-bottom: 7px;
    }

    .form-control,
    .form-select {
        min-height: 43px;
        border-color: #dfe2e8;
        border-radius: 8px;
        font-size: .88rem;
        color: var(--pm-text);
        box-shadow: none !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--pm-navy);
    }

    .search-wrapper {
        position: relative;
    }

    .search-wrapper .search-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #9298a5;
        z-index: 2;
    }

    .search-wrapper input {
        padding-left: 38px;
    }

    .btn-filter {
        min-height: 43px;
        background: var(--pm-navy);
        border-color: var(--pm-navy);
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-filter:hover {
        background: #101a47;
        border-color: #101a47;
    }

    .btn-reset {
        min-height: 43px;
        border-radius: 8px;
        font-weight: 600;
    }

    /* Table */

    .table-card {
        overflow: hidden;
    }

    .table-header {
        padding: 19px 22px;
        border-bottom: 1px solid var(--pm-border);
    }

    .table-title {
        color: var(--pm-text);
        font-size: 1rem;
        font-weight: 750;
        margin: 0;
    }

    .record-count {
        color: #7b8290;
        font-size: .78rem;
        background: #f4f5f8;
        border: 1px solid #e8e9ed;
        border-radius: 20px;
        padding: 5px 10px;
    }

    .tenant-table {
        margin: 0;
    }

    .tenant-table thead th {
        background: #fafbfc;
        color: #747b89;
        border-bottom: 1px solid var(--pm-border);
        border-top: 0;
        font-size: .72rem;
        font-weight: 750;
        letter-spacing: .04em;
        text-transform: uppercase;
        padding: 13px 18px;
        white-space: nowrap;
    }

    .tenant-table tbody td {
        padding: 16px 18px;
        border-color: #f0f1f4;
        vertical-align: middle;
        font-size: .86rem;
        color: #3f4654;
    }

    .tenant-table tbody tr {
        transition: background .15s ease;
    }

    .tenant-table tbody tr:hover {
        background: #fafbfe;
    }

    .tenant-table th:first-child,
    .tenant-table td:first-child {
        padding-left: 22px;
    }

    .tenant-table th:last-child,
    .tenant-table td:last-child {
        padding-right: 22px;
    }

    .tenant-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 220px;
    }

    .tenant-avatar {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        background: #eef1fa;
        color: var(--pm-navy);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        font-weight: 750;
        flex-shrink: 0;
    }

    .tenant-name {
        color: var(--pm-text);
        font-weight: 700;
        margin-bottom: 3px;
    }

    .tenant-email {
        color: #8a909c;
        font-size: .76rem;
    }

    .tenant-phone {
        color: #4d5563;
        font-weight: 500;
        white-space: nowrap;
    }

    /* Status */

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 30px;
        padding: 5px 9px;
        font-size: .71rem;
        font-weight: 700;
        white-space: nowrap;
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
        gap: 5px;
        border-radius: 30px;
        padding: 5px 9px;
        font-size: .71rem;
        font-weight: 700;
    }

    .account-linked {
        background: #edf3ff;
        color: #315fa8;
    }

    .account-none {
        background: #f5f5f6;
        color: #777d88;
        border: 1px solid #e5e6e9;
    }

    /* Actions */

    .action-group {
        display: flex;
        justify-content: flex-end;
        gap: 5px;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e1e3e8;
        background: #fff;
        color: #5e6573;
        transition: .15s ease;
    }

    .action-btn:hover {
        background: #f5f6f9;
        color: var(--pm-navy);
        border-color: #cfd3dc;
    }

    .action-btn.delete:hover {
        background: #fff1f1;
        color: #c03939;
        border-color: #f0cccc;
    }

    /* Empty */

    .empty-state {
        padding: 65px 20px;
    }

    .empty-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        background: #f1f3f8;
        color: #8a91a0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.65rem;
    }

    .empty-title {
        color: var(--pm-text);
        font-weight: 700;
        margin-top: 16px;
    }

    .empty-text {
        color: #8a909b;
        font-size: .86rem;
    }

    /* Pagination */

    .pagination-wrapper {
        padding: 17px 22px;
        border-top: 1px solid var(--pm-border);
    }

    /* Alerts */

    .pm-alert {
        border: 0;
        border-radius: 10px;
        font-size: .86rem;
    }

    @media (max-width: 991.98px) {
        .tenant-page {
            padding-top: 20px;
        }

        .action-group {
            justify-content: flex-start;
        }
    }

    @media (max-width: 575.98px) {
        .page-title {
            font-size: 1.4rem;
        }

        .btn-add-tenant {
            width: 100%;
            margin-top: 15px;
        }

        .table-header {
            padding: 16px;
        }

        .tenant-table th:first-child,
        .tenant-table td:first-child {
            padding-left: 16px;
        }

        .tenant-table th:last-child,
        .tenant-table td:last-child {
            padding-right: 16px;
        }
    }
</style>


<div class="tenant-page">

    <div class="container-fluid px-3 px-lg-4">

        {{-- ========================================================= --}}
        {{-- PAGE HEADER --}}
        {{-- ========================================================= --}}

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

            <div>
                <div class="d-flex align-items-center gap-2 mb-1">

                    <span class="text-muted small">
                        Property Management
                    </span>

                    <span class="text-muted small">
                        /
                    </span>

                    <span class="text-muted small">
                        Tenants
                    </span>

                </div>

                <h1 class="page-title mb-1">
                    Tenants
                </h1>

                <p class="page-subtitle mb-0">
                    Manage tenant profiles, KYC verification and account records.
                </p>
            </div>

            <a href="{{ route('property-management.tenants.create') }}"
               class="btn btn-add-tenant">

                <i class="bi bi-plus-lg me-1"></i>

                Add Tenant

            </a>

        </div>


        {{-- ========================================================= --}}
        {{-- ALERTS --}}
        {{-- ========================================================= --}}

        @if(session('success'))

            <div class="alert alert-success pm-alert alert-dismissible fade show mb-4"
                 role="alert">

                <div class="d-flex align-items-center">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    <span>{{ session('success') }}</span>

                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger pm-alert alert-dismissible fade show mb-4"
                 role="alert">

                <div class="d-flex align-items-center">

                    <i class="bi bi-exclamation-circle-fill me-2"></i>

                    <span>{{ session('error') }}</span>

                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- SUMMARY --}}
        {{-- ========================================================= --}}

        <div class="row g-3 mb-4">

            {{-- Total --}}
            <div class="col-xl-3 col-sm-6">

                <div class="stat-card">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon total">
                            <i class="bi bi-people"></i>
                        </div>

                        <div>
                            <div class="stat-label">
                                Total Tenants
                            </div>

                            <div class="stat-value">
                                {{ $tenants->total() }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Verified --}}
            <div class="col-xl-3 col-sm-6">

                <div class="stat-card">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon verified">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <div>
                            <div class="stat-label">
                                Verified KYC
                            </div>

                            <div class="stat-value">
                                {{ $tenants->where('kyc_status', 'verified')->count() }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Pending --}}
            <div class="col-xl-3 col-sm-6">

                <div class="stat-card">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon pending">
                            <i class="bi bi-hourglass-split"></i>
                        </div>

                        <div>
                            <div class="stat-label">
                                Pending KYC
                            </div>

                            <div class="stat-value">
                                {{ $tenants->where('kyc_status', 'pending')->count() }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Active --}}
            <div class="col-xl-3 col-sm-6">

                <div class="stat-card">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon active">
                            <i class="bi bi-person-check"></i>
                        </div>

                        <div>
                            <div class="stat-label">
                                Active Tenants
                            </div>

                            <div class="stat-value">
                                {{ $tenants->where('status', 'active')->count() }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- FILTERS --}}
        {{-- ========================================================= --}}

        <div class="pm-card filter-card mb-4">

            <div class="d-flex align-items-center justify-content-between mb-3">

                <div>

                    <div class="filter-title">
                        Tenant Directory
                    </div>

                    <div class="text-muted small mt-1">
                        Search and filter tenant records.
                    </div>

                </div>

                @if(request()->hasAny(['search', 'kyc_status', 'status']))

                    <a href="{{ route('property-management.tenants.index') }}"
                       class="btn btn-sm btn-outline-secondary btn-reset">

                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                        Reset

                    </a>

                @endif

            </div>


            <form method="GET"
                  action="{{ route('property-management.tenants.index') }}">

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-xl-6 col-lg-5">

                        <label class="filter-label">
                            Search tenants
                        </label>

                        <div class="search-wrapper">

                            <i class="bi bi-search search-icon"></i>

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                value="{{ request('search') }}"
                                placeholder="Name, phone, email or national ID"
                            >

                        </div>

                    </div>


                    {{-- KYC --}}
                    <div class="col-xl-2 col-lg-3">

                        <label class="filter-label">
                            KYC Status
                        </label>

                        <select name="kyc_status"
                                class="form-select">

                            <option value="">
                                All statuses
                            </option>

                            <option value="pending"
                                @selected(request('kyc_status') === 'pending')>
                                Pending
                            </option>

                            <option value="verified"
                                @selected(request('kyc_status') === 'verified')>
                                Verified
                            </option>

                            <option value="rejected"
                                @selected(request('kyc_status') === 'rejected')>
                                Rejected
                            </option>

                        </select>

                    </div>


                    {{-- Status --}}
                    <div class="col-xl-2 col-lg-2">

                        <label class="filter-label">
                            Account Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="">
                                All
                            </option>

                            <option value="active"
                                @selected(request('status') === 'active')>
                                Active
                            </option>

                            <option value="inactive"
                                @selected(request('status') === 'inactive')>
                                Inactive
                            </option>

                            <option value="blacklisted"
                                @selected(request('status') === 'blacklisted')>
                                Blacklisted
                            </option>

                        </select>

                    </div>


                    {{-- Search --}}
                    <div class="col-xl-2 col-lg-2 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-filter text-white w-100">

                            <i class="bi bi-search me-1"></i>

                            Apply Filters

                        </button>

                    </div>

                </div>

            </form>

        </div>


        {{-- ========================================================= --}}
        {{-- TENANT TABLE --}}
        {{-- ========================================================= --}}

        <div class="pm-card table-card">

            {{-- Table header --}}
            <div class="table-header">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

                    <div>

                        <h5 class="table-title">
                            Tenant Records
                        </h5>

                        <div class="text-muted small mt-1">
                            Tenant profiles registered in the property management system.
                        </div>

                    </div>

                    <span class="record-count">

                        <i class="bi bi-people me-1"></i>

                        {{ $tenants->total() }} records

                    </span>

                </div>

            </div>


            {{-- Table --}}
            <div class="table-responsive">

                <table class="table tenant-table align-middle">

                    <thead>

                        <tr>

                            <th>
                                Tenant
                            </th>

                            <th>
                                Phone
                            </th>

                            <th>
                                KYC
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Account
                            </th>

                            <th class="text-end">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($tenants as $tenant)

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


                            <tr>

                                {{-- Tenant --}}
                                <td>

                                    <div class="tenant-profile">

                                        <div class="tenant-avatar">
                                            {{ $initials }}
                                        </div>

                                        <div>

                                            <div class="tenant-name">
                                                {{ $tenant->full_name }}
                                            </div>

                                            @if($tenant->email)

                                                <div class="tenant-email">
                                                    {{ $tenant->email }}
                                                </div>

                                            @else

                                                <div class="tenant-email">
                                                    No email provided
                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Phone --}}
                                <td>

                                    @if($tenant->phone)

                                        <span class="tenant-phone">
                                            <i class="bi bi-telephone me-1 text-muted"></i>
                                            {{ $tenant->phone }}
                                        </span>

                                    @else

                                        <span class="text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- KYC --}}
                                <td>

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

                                </td>


                                {{-- Status --}}
                                <td>

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

                                </td>


                                {{-- Account --}}
                                <td>

                                    @if($tenant->user_id)

                                        <span class="account-pill account-linked">

                                            <i class="bi bi-link-45deg"></i>

                                            Linked

                                        </span>

                                    @else

                                        <span class="account-pill account-none">

                                            <i class="bi bi-person-x"></i>

                                            No Account

                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="action-group">

                                        {{-- View --}}
                                        <a href="{{ route('property-management.tenants.show', $tenant) }}"
                                           class="action-btn"
                                           title="View tenant"
                                           data-bs-toggle="tooltip">

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route('property-management.tenants.edit', $tenant) }}"
                                           class="action-btn"
                                           title="Edit tenant"
                                           data-bs-toggle="tooltip">

                                            <i class="bi bi-pencil"></i>

                                        </a>


                                        {{-- Delete --}}
                                        <form method="POST"
                                              action="{{ route('property-management.tenants.destroy', $tenant) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this tenant?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="action-btn delete"
                                                    title="Delete tenant"
                                                    data-bs-toggle="tooltip">

                                                <i class="bi bi-trash3"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6">

                                    <div class="empty-state text-center">

                                        <div class="empty-icon">
                                            <i class="bi bi-people"></i>
                                        </div>

                                        <div class="empty-title">
                                            No tenants found
                                        </div>

                                        <div class="empty-text mb-3">
                                            There are no tenant records matching your current filters.
                                        </div>

                                        @if(request()->hasAny(['search', 'kyc_status', 'status']))

                                            <a href="{{ route('property-management.tenants.index') }}"
                                               class="btn btn-sm btn-outline-secondary">

                                                Clear filters

                                            </a>

                                        @else

                                            <a href="{{ route('property-management.tenants.create') }}"
                                               class="btn btn-sm text-white"
                                               style="background:#D05208;">

                                                <i class="bi bi-plus-lg me-1"></i>

                                                Add First Tenant

                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($tenants->hasPages())

                <div class="pagination-wrapper">

                    {{ $tenants->withQueryString()->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const tooltipTriggerList = document.querySelectorAll(
            '[data-bs-toggle="tooltip"]'
        );

        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

    });
</script>

@endsection