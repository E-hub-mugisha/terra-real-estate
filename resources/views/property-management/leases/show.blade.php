@extends('layouts.property-management')

@section('title', $lease->lease_number . ' - Lease')

@section('content')

@php
/*
|--------------------------------------------------------------------------
| Related Models
|--------------------------------------------------------------------------
*/
$tenant = $lease->tenant;
$unit = $lease->unit;
$floor = $unit?->floor;
$building = $floor?->building;
$property = $building?->property;

/*
|--------------------------------------------------------------------------
| Status
|--------------------------------------------------------------------------
*/
$status = $lease->status;

$statusLabel = ucwords(
str_replace('_', ' ', $status)
);

$statusClass = match ($status) {
'active' => 'status-active',
'pending_signature' => 'status-pending',
'draft' => 'status-draft',
'expired' => 'status-expired',
'terminated' => 'status-terminated',
'cancelled' => 'status-cancelled',
default => 'status-default',
};

/*
|--------------------------------------------------------------------------
| Tenant Initials
|--------------------------------------------------------------------------
*/
$tenantName = $tenant?->full_name
?? trim(($tenant?->first_name ?? '') . ' ' . ($tenant?->last_name ?? ''));

$tenantInitials = collect(
preg_split('/\s+/', trim($tenantName))
)
->filter()
->take(2)
->map(fn ($name) => strtoupper(substr($name, 0, 1)))
->implode('');

$tenantInitials = $tenantInitials ?: 'TN';

/*
|--------------------------------------------------------------------------
| Lease Period
|--------------------------------------------------------------------------
*/
$remainingDays = null;
$periodLabel = 'Not specified';

if ($lease->start_date && $lease->end_date) {
$remainingDays = now()
->startOfDay()
->diffInDays($lease->end_date, false);

$periodLabel = $lease->start_date->format('d M Y')
. ' — '
. $lease->end_date->format('d M Y');
}

/*
|--------------------------------------------------------------------------
| Payment Frequency
|--------------------------------------------------------------------------
*/
$paymentFrequency = $lease->payment_frequency
? ucwords(str_replace('_', ' ', $lease->payment_frequency))
: 'Not specified';

/*
|--------------------------------------------------------------------------
| Application
|--------------------------------------------------------------------------
*/
$application = $lease->application;

/*
|--------------------------------------------------------------------------
| Signature
|--------------------------------------------------------------------------
*/
$signerName = $lease->signer?->name;

@endphp

<style>
    :root {
        --pm-navy: #19265d;
        --pm-orange: #D05208;
        --pm-bg: #f6f7fb;
        --pm-border: #e8eaf0;
        --pm-muted: #6b7280;
        --pm-dark: #1f2937;
        --pm-success: #198754;
        --pm-warning: #d98b00;
        --pm-danger: #c0392b;
    }

    .lease-page {
        background: var(--pm-bg);
        min-height: calc(100vh - 100px);
    }

    .lease-breadcrumb {
        font-size: .82rem;
        color: var(--pm-muted);
    }

    .lease-breadcrumb a {
        color: var(--pm-navy);
        text-decoration: none;
        font-weight: 600;
    }

    .lease-breadcrumb a:hover {
        color: var(--pm-orange);
    }

    .lease-title {
        color: var(--pm-navy);
        font-weight: 800;
        letter-spacing: -.025em;
    }

    .lease-subtitle {
        color: var(--pm-muted);
    }

    .btn-terra {
        background: var(--pm-orange);
        border-color: var(--pm-orange);
        color: #fff;
        font-weight: 600;
    }

    .btn-terra:hover,
    .btn-terra:focus {
        background: #b94706;
        border-color: #b94706;
        color: #fff;
    }

    .btn-navy {
        background: var(--pm-navy);
        border-color: var(--pm-navy);
        color: #fff;
        font-weight: 600;
    }

    .btn-navy:hover,
    .btn-navy:focus {
        background: #111b47;
        border-color: #111b47;
        color: #fff;
    }

    .lease-card {
        border: 1px solid var(--pm-border);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 5px 20px rgba(25, 38, 93, .045);
        overflow: hidden;
    }

    .lease-card-header {
        padding: 18px 22px;
        border-bottom: 1px solid var(--pm-border);
        background: #fff;
    }

    .lease-card-body {
        padding: 22px;
    }

    .lease-card-title {
        color: var(--pm-navy);
        font-size: .98rem;
        font-weight: 750;
        margin: 0;
    }

    .lease-card-description {
        color: var(--pm-muted);
        font-size: .82rem;
        margin-top: 3px;
    }

    /* Hero */

    .lease-hero {
        position: relative;
        border-radius: 18px;
        background: linear-gradient(135deg,
                var(--pm-navy) 0%,
                #263675 100%);
        color: #fff;
        padding: 28px;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(25, 38, 93, .14);
    }

    .lease-hero::after {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        right: -90px;
        top: -100px;
        background: rgba(255, 255, 255, .06);
    }

    .lease-hero::before {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        right: 100px;
        bottom: -100px;
        background: rgba(208, 82, 8, .12);
    }

    .lease-hero-content {
        position: relative;
        z-index: 2;
    }

    .lease-number {
        font-size: 1.55rem;
        font-weight: 800;
        letter-spacing: -.025em;
    }

    .lease-hero-label {
        color: rgba(255, 255, 255, .68);
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .07em;
        font-weight: 700;
    }

    .hero-meta {
        color: rgba(255, 255, 255, .72);
        font-size: .88rem;
    }

    /* Status */

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: .76rem;
        font-weight: 750;
        white-space: nowrap;
    }

    .status-pill::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-active {
        background: rgba(25, 135, 84, .12);
        color: #147a4b;
    }

    .status-pending {
        background: rgba(217, 139, 0, .13);
        color: #9b6200;
    }

    .status-draft {
        background: rgba(107, 114, 128, .12);
        color: #59616d;
    }

    .status-expired {
        background: rgba(108, 117, 125, .14);
        color: #555d64;
    }

    .status-terminated,
    .status-cancelled {
        background: rgba(192, 57, 43, .11);
        color: #b02a1b;
    }

    .status-default {
        background: rgba(25, 38, 93, .09);
        color: var(--pm-navy);
    }

    /* Stats */

    .summary-card {
        border: 1px solid var(--pm-border);
        background: #fff;
        border-radius: 14px;
        padding: 18px;
        height: 100%;
    }

    .summary-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(25, 38, 93, .07);
        color: var(--pm-navy);
        margin-bottom: 12px;
    }

    .summary-label {
        color: var(--pm-muted);
        font-size: .76rem;
        font-weight: 650;
        margin-bottom: 4px;
    }

    .summary-value {
        color: var(--pm-dark);
        font-weight: 800;
        font-size: 1rem;
    }

    /* Information rows */

    .info-item {
        height: 100%;
        padding: 14px 15px;
        border: 1px solid #edf0f4;
        background: #fbfcfe;
        border-radius: 11px;
    }

    .info-label {
        color: var(--pm-muted);
        font-size: .74rem;
        font-weight: 650;
        margin-bottom: 5px;
    }

    .info-value {
        color: var(--pm-dark);
        font-size: .9rem;
        font-weight: 650;
        word-break: break-word;
    }

    .info-value strong {
        color: var(--pm-navy);
    }

    /* Tenant */

    .tenant-profile {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .tenant-avatar {
        width: 54px;
        height: 54px;
        flex: 0 0 54px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(208, 82, 8, .1);
        color: var(--pm-orange);
        font-weight: 800;
        font-size: 1rem;
    }

    .tenant-name {
        color: var(--pm-navy);
        font-weight: 800;
        margin-bottom: 3px;
    }

    .tenant-contact {
        color: var(--pm-muted);
        font-size: .83rem;
    }

    /* Period */

    .period-track {
        position: relative;
        height: 5px;
        background: #e9ecf1;
        border-radius: 20px;
        margin: 28px 0 18px;
    }

    .period-track-fill {
        height: 100%;
        border-radius: inherit;
        background: var(--pm-orange);
        width: 100%;
    }

    .period-dates {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .period-date-label {
        color: var(--pm-muted);
        font-size: .73rem;
        margin-bottom: 3px;
    }

    .period-date-value {
        color: var(--pm-navy);
        font-size: .85rem;
        font-weight: 750;
    }

    .period-status {
        border-radius: 10px;
        padding: 10px 13px;
        background: #f8f9fb;
        color: var(--pm-muted);
        font-size: .8rem;
        margin-top: 18px;
    }

    /* Text blocks */

    .contract-text {
        white-space: pre-line;
        color: #4b5563;
        line-height: 1.75;
        font-size: .88rem;
    }

    .empty-text {
        color: #9ca3af;
        font-size: .85rem;
        font-style: italic;
    }

    /* Action card */

    .action-button {
        width: 100%;
        border-radius: 10px;
        padding: 11px 14px;
        font-weight: 650;
    }

    .action-divider {
        border-top: 1px solid var(--pm-border);
        margin: 18px 0;
    }

    /* Sidebar */

    .sidebar-sticky {
        position: sticky;
        top: 20px;
    }

    .detail-link {
        color: var(--pm-navy);
        text-decoration: none;
        font-weight: 650;
    }

    .detail-link:hover {
        color: var(--pm-orange);
    }

    .application-box {
        background: #f8f9fc;
        border-radius: 11px;
        padding: 13px 14px;
    }

    /* Modal */

    .modal-content {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
    }

    .modal-header {
        border-bottom: 1px solid var(--pm-border);
    }

    .modal-title {
        color: var(--pm-navy);
        font-weight: 750;
    }

    /* Responsive */

    @media (max-width: 767.98px) {
        .lease-hero {
            padding: 22px;
        }

        .lease-number {
            font-size: 1.25rem;
        }

        .lease-card-body,
        .lease-card-header {
            padding: 17px;
        }

        .sidebar-sticky {
            position: static;
        }

        .period-dates {
            flex-direction: column;
            gap: 12px;
        }
    }
</style>

<div class="lease-page">

    <div class="container-fluid py-4">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <div>

                <div class="lease-breadcrumb mb-2">

                    <a href="{{ route('property-management.dashboard') }}">
                        Property Management
                    </a>

                    <span class="mx-2">/</span>

                    <a href="{{ route('property-management.leases.index') }}">
                        Leases & Contracts
                    </a>

                    <span class="mx-2">/</span>

                    <span>{{ $lease->lease_number }}</span>

                </div>

                <h1 class="h3 lease-title mb-1">
                    {{ $lease->lease_number }}
                </h1>

                <p class="lease-subtitle mb-0">
                    Lease and contract details
                </p>

            </div>

            <div class="d-flex flex-wrap gap-2">

                <a href="{{ route('property-management.leases.index') }}"
                    class="btn btn-light border">
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Leases
                </a>

                @if(in_array($lease->status, ['draft', 'pending_signature']))

                <a href="{{ route('property-management.leases.edit', $lease) }}"
                    class="btn btn-navy">
                    <i class="bi bi-pencil-square me-1"></i>
                    Edit Lease
                </a>

                @endif

            </div>

        </div>


        {{-- =========================================================
            FLASH MESSAGES
        ========================================================== --}}

        @if(session('success'))

        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
        </div>

        @endif

        @if(session('error'))

        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>

        @endif


        {{-- =========================================================
            HERO
        ========================================================== --}}

        <div class="lease-hero mb-4">

            <div class="lease-hero-content">

                <div class="row align-items-center g-4">

                    <div class="col-lg-7">

                        <div class="lease-hero-label mb-2">
                            Lease Agreement
                        </div>

                        <div class="lease-number mb-2">
                            {{ $lease->lease_number }}
                        </div>

                        <div class="hero-meta">
                            <i class="bi bi-building me-1"></i>

                            {{ $property?->title ?? 'Property not assigned' }}

                            @if($unit)
                            <span class="mx-2">•</span>
                            Unit {{ $unit->unit_number }}
                            @endif
                        </div>

                    </div>

                    <div class="col-lg-5 text-lg-end">

                        <div class="mb-2">
                            <span class="status-pill {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <div class="hero-meta">

                            @if($lease->start_date && $lease->end_date)

                            {{ $lease->start_date->format('d M Y') }}
                            —
                            {{ $lease->end_date->format('d M Y') }}

                            @else

                            Lease period not specified

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            SUMMARY
        ========================================================== --}}

        <div class="row g-3 mb-4">

            <div class="col-6 col-xl-3">

                <div class="summary-card">

                    <div class="summary-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                    <div class="summary-label">
                        Monthly Rent
                    </div>

                    <div class="summary-value">
                        RWF {{ number_format($lease->monthly_rent ?? 0) }}
                    </div>

                </div>

            </div>


            <div class="col-6 col-xl-3">

                <div class="summary-card">

                    <div class="summary-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div class="summary-label">
                        Deposit
                    </div>

                    <div class="summary-value">
                        RWF {{ number_format($lease->deposit_amount ?? 0) }}
                    </div>

                </div>

            </div>


            <div class="col-6 col-xl-3">

                <div class="summary-card">

                    <div class="summary-icon">
                        <i class="bi bi-calendar3"></i>
                    </div>

                    <div class="summary-label">
                        Payment Frequency
                    </div>

                    <div class="summary-value">
                        {{ $paymentFrequency }}
                    </div>

                </div>

            </div>


            <div class="col-6 col-xl-3">

                <div class="summary-card">

                    <div class="summary-icon">
                        <i class="bi bi-hourglass-split"></i>
                    </div>

                    <div class="summary-label">

                        @if($remainingDays !== null && $remainingDays >= 0)
                        Remaining
                        @elseif($remainingDays !== null)
                        Days Since End
                        @else
                        Lease Period
                        @endif

                    </div>

                    <div class="summary-value">

                        @if($remainingDays !== null)

                        {{ abs($remainingDays) }}
                        {{ \Illuminate\Support\Str::plural('day', abs($remainingDays)) }}

                        @else

                        Not specified

                        @endif

                    </div>

                </div>

            </div>

        </div>


        <div class="row g-4">

            {{-- =====================================================
                MAIN CONTENT
            ====================================================== --}}

            <div class="col-xl-8">

                {{-- =================================================
                    TENANT
                ================================================== --}}

                <div class="lease-card mb-4">

                    <div class="lease-card-header">

                        <h2 class="lease-card-title">
                            <i class="bi bi-person me-2"></i>
                            Tenant
                        </h2>

                        <div class="lease-card-description">
                            Tenant assigned to this lease agreement
                        </div>

                    </div>

                    <div class="lease-card-body">

                        @if($tenant)

                        <div class="tenant-profile">

                            <div class="tenant-avatar">
                                {{ $tenantInitials }}
                            </div>

                            <div class="flex-grow-1">

                                <div class="tenant-name">
                                    {{ $tenantName ?: 'Unnamed Tenant' }}
                                </div>

                                <div class="tenant-contact">

                                    @if($tenant->phone)
                                    <i class="bi bi-telephone me-1"></i>
                                    {{ $tenant->phone }}
                                    @endif

                                    @if($tenant->email)
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-envelope me-1"></i>
                                    {{ $tenant->email }}
                                    @endif

                                </div>

                            </div>

                        </div>

                        <hr class="my-4">

                        <div class="row g-3">

                            <div class="col-md-4">

                                <div class="info-item">

                                    <div class="info-label">
                                        National ID
                                    </div>

                                    <div class="info-value">
                                        {{ $tenant->national_id ?: 'Not provided' }}
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="info-item">

                                    <div class="info-label">
                                        KYC Status
                                    </div>

                                    <div class="info-value">

                                        {{ ucwords(str_replace('_', ' ', $tenant->kyc_status ?? 'Not set')) }}

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="info-item">

                                    <div class="info-label">
                                        Tenant Status
                                    </div>

                                    <div class="info-value">

                                        {{ ucwords(str_replace('_', ' ', $tenant->status ?? 'Not set')) }}

                                    </div>

                                </div>

                            </div>

                        </div>

                        @else

                        <div class="empty-text">
                            No tenant is currently associated with this lease.
                        </div>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    PROPERTY & UNIT
                ================================================== --}}

                <div class="lease-card mb-4">

                    <div class="lease-card-header">

                        <h2 class="lease-card-title">
                            <i class="bi bi-building me-2"></i>
                            Property & Unit
                        </h2>

                        <div class="lease-card-description">
                            Location assigned to the tenancy
                        </div>

                    </div>

                    <div class="lease-card-body">

                        <div class="row g-3">

                            <div class="col-md-6">

                                <div class="info-item">

                                    <div class="info-label">
                                        Property
                                    </div>

                                    <div class="info-value">

                                        {{ $property?->title ?? 'Not assigned' }}

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="info-item">

                                    <div class="info-label">
                                        Building
                                    </div>

                                    <div class="info-value">

                                        {{ $building?->name ?? 'Not assigned' }}

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="info-item">

                                    <div class="info-label">
                                        Floor
                                    </div>

                                    <div class="info-value">

                                        {{ $floor?->name ?? 'Not assigned' }}

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="info-item">

                                    <div class="info-label">
                                        Unit
                                    </div>

                                    <div class="info-value">

                                        <strong>
                                            {{ $unit?->unit_number ?? 'Not assigned' }}
                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    LEASE PERIOD
                ================================================== --}}

                <div class="lease-card mb-4">

                    <div class="lease-card-header">

                        <h2 class="lease-card-title">
                            <i class="bi bi-calendar-range me-2"></i>
                            Lease Period
                        </h2>

                        <div class="lease-card-description">
                            Contract start and end dates
                        </div>

                    </div>

                    <div class="lease-card-body">

                        @if($lease->start_date && $lease->end_date)

                        <div class="period-track">

                            <div class="period-track-fill"></div>

                        </div>

                        <div class="period-dates">

                            <div>

                                <div class="period-date-label">
                                    Start Date
                                </div>

                                <div class="period-date-value">
                                    {{ $lease->start_date->format('d M Y') }}
                                </div>

                            </div>

                            <div class="text-md-end">

                                <div class="period-date-label">
                                    End Date
                                </div>

                                <div class="period-date-value">
                                    {{ $lease->end_date->format('d M Y') }}
                                </div>

                            </div>

                        </div>


                        <div class="period-status">

                            @if($remainingDays > 0)

                            <i class="bi bi-clock me-1"></i>

                            This lease has
                            <strong>
                                {{ $remainingDays }}
                                {{ \Illuminate\Support\Str::plural('day', $remainingDays) }}
                            </strong>
                            remaining.

                            @elseif($remainingDays === 0)

                            <i class="bi bi-exclamation-circle me-1"></i>

                            This lease ends today.

                            @else

                            <i class="bi bi-calendar-x me-1"></i>

                            This lease ended
                            <strong>
                                {{ abs($remainingDays) }}
                                {{ \Illuminate\Support\Str::plural('day', abs($remainingDays)) }}
                            </strong>
                            ago.

                            @endif

                        </div>

                        @else

                        <div class="empty-text">
                            Lease start and end dates have not been completely specified.
                        </div>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    FINANCIAL TERMS
                ================================================== --}}

                <div class="lease-card mb-4">

                    <div class="lease-card-header">

                        <h2 class="lease-card-title">
                            <i class="bi bi-wallet2 me-2"></i>
                            Financial Terms
                        </h2>

                        <div class="lease-card-description">
                            Rental and payment obligations
                        </div>

                    </div>

                    <div class="lease-card-body">

                        <div class="row g-3">

                            <div class="col-md-4">

                                <div class="info-item">

                                    <div class="info-label">
                                        Monthly Rent
                                    </div>

                                    <div class="info-value">
                                        RWF {{ number_format($lease->monthly_rent ?? 0) }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="info-item">

                                    <div class="info-label">
                                        Deposit Amount
                                    </div>

                                    <div class="info-value">
                                        RWF {{ number_format($lease->deposit_amount ?? 0) }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="info-item">

                                    <div class="info-label">
                                        Payment Frequency
                                    </div>

                                    <div class="info-value">
                                        {{ $paymentFrequency }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Invoices</h5>
                    </div>

                    <div class="card-body">
                        @if ($lease->invoices->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Type</th>
                                        <th>Issue date</th>
                                        <th>Due date</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lease->invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $invoice->invoice_type)) }}</td>
                                        <td>{{ $invoice->issue_date?->format('d M Y') }}</td>
                                        <td>{{ $invoice->due_date?->format('d M Y') }}</td>
                                        <td>{{ number_format((float) $invoice->amount, 2) }} RWF</td>
                                        <td>{{ number_format((float) $invoice->balance, 2) }} RWF</td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted mb-0">
                            No invoices have been generated for this lease yet.
                        </p>
                        @endif
                    </div>
                </div>
                {{-- =================================================
                    CONTRACT TERMS
                ================================================== --}}

                <div class="lease-card mb-4">

                    <div class="lease-card-header">

                        <h2 class="lease-card-title">
                            <i class="bi bi-file-text me-2"></i>
                            Contract Terms
                        </h2>

                        <div class="lease-card-description">
                            Agreement terms and additional conditions
                        </div>

                    </div>

                    <div class="lease-card-body">

                        <div class="mb-4">

                            <div class="info-label mb-2">
                                Terms & Conditions
                            </div>

                            @if($lease->terms)

                            <div class="contract-text">
                                {{ $lease->terms }}
                            </div>

                            @else

                            <div class="empty-text">
                                No terms and conditions have been entered.
                            </div>

                            @endif

                        </div>


                        <div>

                            <div class="info-label mb-2">
                                Special Conditions
                            </div>

                            @if($lease->special_conditions)

                            <div class="contract-text">
                                {{ $lease->special_conditions }}
                            </div>

                            @else

                            <div class="empty-text">
                                No special conditions have been entered.
                            </div>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    APPLICATION
                ================================================== --}}

                @if($application)

                <div class="lease-card mb-4">

                    <div class="lease-card-header">

                        <h2 class="lease-card-title">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            Tenant Application
                        </h2>

                        <div class="lease-card-description">
                            Application associated with this lease
                        </div>

                    </div>

                    <div class="lease-card-body">

                        <div class="row g-3">

                            <div class="col-md-4">

                                <div class="info-item">

                                    <div class="info-label">
                                        Application
                                    </div>

                                    <div class="info-value">
                                        #{{ $application->id }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="info-item">

                                    <div class="info-label">
                                        Application Date
                                    </div>

                                    <div class="info-value">

                                        {{ $application->application_date?->format('d M Y') ?? 'Not specified' }}

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="info-item">

                                    <div class="info-label">
                                        Move-in Date
                                    </div>

                                    <div class="info-value">

                                        {{ $application->preferred_move_in_date?->format('d M Y') ?? 'Not specified' }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                @endif


                {{-- =================================================
                    NOTES
                ================================================== --}}

                @if($lease->notes)

                <div class="lease-card mb-4">

                    <div class="lease-card-header">

                        <h2 class="lease-card-title">
                            <i class="bi bi-sticky me-2"></i>
                            Internal Notes
                        </h2>

                    </div>

                    <div class="lease-card-body">

                        <div class="contract-text">
                            {{ $lease->notes }}
                        </div>

                    </div>

                </div>

                @endif


                {{-- =================================================
                    TERMINATION
                ================================================== --}}

                @if($lease->terminated_at || $lease->termination_reason)

                <div class="lease-card mb-4">

                    <div class="lease-card-header">

                        <h2 class="lease-card-title text-danger">
                            <i class="bi bi-x-circle me-2"></i>
                            Termination Information
                        </h2>

                    </div>

                    <div class="lease-card-body">

                        <div class="row g-3">

                            @if($lease->terminated_at)

                            <div class="col-md-4">

                                <div class="info-item">

                                    <div class="info-label">
                                        Terminated At
                                    </div>

                                    <div class="info-value">

                                        {{ $lease->terminated_at->format('d M Y H:i') }}

                                    </div>

                                </div>

                            </div>

                            @endif


                            @if($lease->termination_reason)

                            <div class="col-md-8">

                                <div class="info-item">

                                    <div class="info-label">
                                        Termination Reason
                                    </div>

                                    <div class="info-value">

                                        {{ $lease->termination_reason }}

                                    </div>

                                </div>

                            </div>

                            @endif

                        </div>

                    </div>

                </div>

                @endif

            </div>


            {{-- =====================================================
                SIDEBAR
            ====================================================== --}}

            <div class="col-xl-4">

                <div class="sidebar-sticky">

                    {{-- =============================================
                        CONTRACT STATUS
                    ============================================== --}}

                    <div class="lease-card mb-4">

                        <div class="lease-card-header">

                            <h2 class="lease-card-title">
                                <i class="bi bi-shield-check me-2"></i>
                                Contract Status
                            </h2>

                        </div>

                        <div class="lease-card-body">

                            <span class="status-pill {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>


                            @if($lease->signed_at)

                            <div class="mt-4">

                                <div class="info-label">
                                    Signed At
                                </div>

                                <div class="info-value">

                                    {{ $lease->signed_at->format('d M Y H:i') }}

                                </div>

                            </div>

                            @endif


                            @if($signerName)

                            <div class="mt-3">

                                <div class="info-label">
                                    Signed / Activated By
                                </div>

                                <div class="info-value">
                                    {{ $signerName }}
                                </div>

                            </div>

                            @endif

                        </div>

                    </div>


                    {{-- =============================================
                        ACTIONS
                    ============================================== --}}

                    <div class="lease-card mb-4">

                        <div class="lease-card-header">

                            <h2 class="lease-card-title">
                                <i class="bi bi-lightning me-2"></i>
                                Lease Actions
                            </h2>

                        </div>

                        <div class="lease-card-body">

                            @if($lease->status === 'draft')

                            <form method="POST"
                                action="{{ route('property-management.leases.send-for-signature', $lease) }}">

                                @csrf

                                <button type="submit"
                                    class="btn btn-navy action-button">

                                    <i class="bi bi-send me-2"></i>
                                    Send for Signature

                                </button>

                            </form>

                            @endif


                            @if($lease->status === 'pending_signature')

                            <form method="POST"
                                action="{{ route('property-management.leases.activate', $lease) }}">

                                @csrf

                                <button type="submit"
                                    class="btn btn-success action-button"
                                    onclick="return confirm('Activate this lease? The unit will become occupied.');">

                                    <i class="bi bi-check-circle me-2"></i>
                                    Sign & Activate Lease

                                </button>

                            </form>

                            @endif


                            @if($lease->status === 'active')

                            <button type="button"
                                class="btn btn-outline-danger action-button"
                                data-bs-toggle="modal"
                                data-bs-target="#terminateLeaseModal">

                                <i class="bi bi-x-circle me-2"></i>
                                Terminate Lease

                            </button>

                            @endif


                            @if(in_array($lease->status, ['expired', 'terminated', 'cancelled']))

                            <div class="application-box">

                                <div class="small fw-semibold text-muted mb-1">
                                    No active actions
                                </div>

                                <div class="small text-muted">
                                    This lease is no longer active and does not require an operational action.
                                </div>

                            </div>

                            @endif

                        </div>

                    </div>


                    {{-- =============================================
                        SIGNATURE
                    ============================================== --}}

                    <div class="lease-card mb-4">

                        <div class="lease-card-header">

                            <h2 class="lease-card-title">
                                <i class="bi bi-pen me-2"></i>
                                Signature
                            </h2>

                        </div>

                        <div class="lease-card-body">

                            @if($lease->signed_at)

                            <div class="info-item mb-3">

                                <div class="info-label">
                                    Signed Date
                                </div>

                                <div class="info-value">

                                    {{ $lease->signed_at->format('d M Y H:i') }}

                                </div>

                            </div>

                            @else

                            <div class="info-item mb-3">

                                <div class="info-label">
                                    Signature Status
                                </div>

                                <div class="info-value">
                                    Not signed
                                </div>

                            </div>

                            @endif


                            @if($signerName)

                            <div class="info-item">

                                <div class="info-label">
                                    Signer
                                </div>

                                <div class="info-value">
                                    {{ $signerName }}
                                </div>

                            </div>

                            @endif

                        </div>

                    </div>


                    {{-- =============================================
                        TENANT QUICK INFO
                    ============================================== --}}

                    @if($tenant)

                    <div class="lease-card">

                        <div class="lease-card-header">

                            <h2 class="lease-card-title">
                                <i class="bi bi-person-vcard me-2"></i>
                                Tenant Summary
                            </h2>

                        </div>

                        <div class="lease-card-body">

                            <div class="info-item mb-3">

                                <div class="info-label">
                                    Tenant
                                </div>

                                <div class="info-value">
                                    {{ $tenantName ?: 'Unnamed Tenant' }}
                                </div>

                            </div>


                            <div class="info-item mb-3">

                                <div class="info-label">
                                    Phone
                                </div>

                                <div class="info-value">
                                    {{ $tenant->phone ?: 'Not provided' }}
                                </div>

                            </div>


                            <div class="info-item">

                                <div class="info-label">
                                    Email
                                </div>

                                <div class="info-value">
                                    {{ $tenant->email ?: 'Not provided' }}
                                </div>

                            </div>

                        </div>

                    </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ================================================================
    TERMINATE LEASE MODAL
================================================================= --}}

@if($lease->status === 'active')

<div class="modal fade"
    id="terminateLeaseModal"
    tabindex="-1"
    aria-labelledby="terminateLeaseModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>

                    <h5 class="modal-title"
                        id="terminateLeaseModalLabel">

                        Terminate Lease

                    </h5>

                    <small class="text-muted">
                        {{ $lease->lease_number }}
                    </small>

                </div>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <form method="POST"
                action="{{ route('property-management.leases.terminate', $lease) }}">

                @csrf

                <div class="modal-body">

                    <div class="alert alert-warning border-0">

                        <i class="bi bi-exclamation-triangle me-2"></i>

                        Terminating this lease will end the tenant's active agreement.
                        Please provide a reason before continuing.

                    </div>

                    <label for="termination_reason"
                        class="form-label fw-semibold">

                        Termination Reason
                        <span class="text-danger">*</span>

                    </label>

                    <textarea name="termination_reason"
                        id="termination_reason"
                        rows="5"
                        class="form-control @error('termination_reason') is-invalid @enderror"
                        placeholder="Enter the reason for terminating this lease..."
                        required>{{ old('termination_reason') }}</textarea>

                    @error('termination_reason')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit"
                        class="btn btn-danger">

                        <i class="bi bi-x-circle me-1"></i>
                        Terminate Lease

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endif


{{-- ================================================================
    TOOLTIP INITIALIZATION
================================================================= --}}

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(element) {
            new bootstrap.Tooltip(element);
        });

    });
</script>

@endpush

@endsection