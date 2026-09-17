@extends('layouts.app')

@section('title', 'Property Requests')

@section('content')

<style>
    :root {
        --terra-navy: #19265d;
        --terra-navy-dark: #111a45;
        --terra-orange: #D05208;
        --terra-orange-light: rgba(208, 82, 8, .07);
        --terra-border: #e5e7eb;
        --terra-muted: #6b7280;
    }

    /* =========================
       PAGE HEADER
    ========================== */

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .page-header h1 {
        font-family: 'Cormorant Garamond', serif;
        color: var(--terra-navy-dark);
        font-size: 2rem;
        margin: 0;
        line-height: 1.2;
    }

    .subtitle {
        font-family: 'DM Sans', sans-serif;
        color: var(--terra-muted);
        margin: .35rem 0 0;
    }

    /* =========================
       BUTTONS
    ========================== */

    .btn {
        font-family: 'DM Sans', sans-serif;
        border-radius: 6px;
        font-weight: 600;
    }

    .btn-gold {
        background: var(--terra-orange);
        color: #fff;
        border: 1px solid var(--terra-orange);
    }

    .btn-gold:hover,
    .btn-gold:focus {
        background: #b84606;
        border-color: #b84606;
        color: #fff;
    }

    .btn-navy {
        background: var(--terra-navy);
        color: #fff;
        border: 1px solid var(--terra-navy);
    }

    .btn-navy:hover,
    .btn-navy:focus {
        background: var(--terra-navy-dark);
        border-color: var(--terra-navy-dark);
        color: #fff;
    }

    .btn-outline {
        background: #fff;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .btn-outline:hover,
    .btn-outline:focus {
        background: #f9fafb;
        border-color: #9ca3af;
        color: #111827;
    }

    /* =========================
       STATUS TABS
    ========================== */

    .status-tabs {
        display: flex;
        gap: .5rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid var(--terra-border);
        overflow-x: auto;
        scrollbar-width: thin;
    }

    .tab {
        font-family: 'DM Sans', sans-serif;
        padding: .6rem 1rem;
        text-decoration: none;
        color: var(--terra-muted);
        border-bottom: 2px solid transparent;
        white-space: nowrap;
        transition: all .15s ease;
    }

    .tab:hover {
        color: var(--terra-navy-dark);
    }

    .tab.active {
        color: var(--terra-navy-dark);
        border-color: var(--terra-orange);
        font-weight: 600;
    }

    .tab .count {
        color: #9ca3af;
        font-size: .85em;
        margin-left: .15rem;
    }

    /* =========================
       FILTER BAR
    ========================== */

    .filters-bar {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .filters-bar input,
    .filters-bar select {
        font-family: 'DM Sans', sans-serif;
        padding: .55rem .75rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        background: #fff;
        color: #374151;
        min-height: 40px;
    }

    .filters-bar input {
        min-width: 260px;
    }

    .filters-bar input:focus,
    .filters-bar select:focus {
        outline: none;
        border-color: var(--terra-orange);
        box-shadow: 0 0 0 .2rem rgba(208, 82, 8, .1);
    }

    /* =========================
       TABLE
    ========================== */

    .table-wrap {
        background: #fff;
        border-radius: 8px;
        overflow-x: auto;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'DM Sans', sans-serif;
        min-width: 950px;
    }

    .admin-table th {
        text-align: left;
        padding: .75rem 1rem;
        background: #f9fafb;
        color: #6b7280;
        font-size: .8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .02em;
        white-space: nowrap;
    }

    .admin-table td {
        padding: .75rem 1rem;
        border-top: 1px solid #f3f4f6;
        vertical-align: middle;
        color: #374151;
    }

    .admin-table tbody tr:hover {
        background: #fafafa;
    }

    .ref {
        font-family: monospace;
        color: var(--terra-navy);
        font-weight: 600;
        white-space: nowrap;
    }

    .client-name {
        font-weight: 600;
        color: var(--terra-navy-dark);
    }

    .client-sub {
        font-size: .8rem;
        color: #9ca3af;
        margin-top: .15rem;
    }

    /* =========================
       BADGES
    ========================== */

    .badge {
        display: inline-flex;
        align-items: center;
        padding: .25rem .6rem;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-red {
        background: #fee2e2;
        color: #b91c1c;
    }

    .badge-yellow {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-green {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-status-new {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge-status-in_review {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-status-matched {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-status-closed {
        background: #f3f4f6;
        color: #6b7280;
    }

    .badge-status-unmatched {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* =========================
       LINKS / EMPTY STATE
    ========================== */

    .btn-link {
        color: var(--terra-orange);
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-link:hover {
        color: #b84606;
        text-decoration: underline;
    }

    .empty {
        text-align: center;
        padding: 2.5rem 2rem !important;
        color: #9ca3af;
    }

    .pagination-wrap {
        margin-top: 1rem;
    }

    /* =========================
       BOOTSTRAP EXPORT MODAL
    ========================== */

    #exportPropertyRequestsModal .modal-content {
        border-radius: 12px;
        overflow: hidden;
        font-family: 'DM Sans', sans-serif;
    }

    /*
     * Main scrolling fix.
     * Bootstrap controls the modal height and scrolling.
     */
    #exportPropertyRequestsModal .modal-dialog-scrollable {
        height: calc(100% - 2rem);
    }

    #exportPropertyRequestsModal .modal-dialog-scrollable .modal-content {
        max-height: 100%;
    }

    #exportPropertyRequestsModal .modal-dialog-scrollable .modal-body {
        overflow-y: auto;
    }

    /* Modal header */

    #exportPropertyRequestsModal .modal-header {
        padding: 1.15rem 1.4rem;
        border-bottom: 1px solid #edf0f3;
        background: #fff;
    }

    .export-modal-icon {
        width: 42px;
        height: 42px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--terra-orange-light);
        color: var(--terra-orange);
        font-size: 1.05rem;
        flex-shrink: 0;
    }

    .export-modal-title {
        color: var(--terra-navy-dark);
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
    }

    .export-modal-subtitle {
        color: var(--terra-muted);
        font-size: .8rem;
        margin: .2rem 0 0;
    }

    #exportPropertyRequestsModal .btn-close {
        opacity: .55;
    }

    #exportPropertyRequestsModal .btn-close:hover {
        opacity: .9;
    }

    /* Modal body */

    #exportPropertyRequestsModal .modal-body {
        padding: 1.4rem;
    }

    .export-section-title {
        display: flex;
        align-items: center;
        gap: .5rem;
        color: var(--terra-navy-dark);
        font-size: .9rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .export-section-title i {
        color: var(--terra-orange);
        font-size: .85rem;
    }

    .export-description {
        color: var(--terra-muted);
        font-size: .84rem;
        margin-bottom: 1.25rem;
    }

    #exportPropertyRequestsModal .form-label {
        color: #374151;
        font-size: .78rem;
        font-weight: 700;
        margin-bottom: .4rem;
    }

    #exportPropertyRequestsModal .form-control,
    #exportPropertyRequestsModal .form-select {
        min-height: 42px;
        border-color: #d1d5db;
        border-radius: 7px;
        font-size: .84rem;
    }

    #exportPropertyRequestsModal .form-control:focus,
    #exportPropertyRequestsModal .form-select:focus {
        border-color: var(--terra-orange);
        box-shadow: 0 0 0 .2rem rgba(208, 82, 8, .1);
    }

    /* Custom dates */

    #pr-custom-dates {
        transition: opacity .15s ease;
    }

    /* Format cards */

    .pr-format-option {
        position: relative;
        display: block;
        height: 100%;
        cursor: pointer;
    }

    .pr-format-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .pr-format-card {
        border: 1.5px solid #e5e7eb;
        border-radius: 9px;
        padding: 1rem;
        background: #fff;
        transition:
            border-color .15s ease,
            background-color .15s ease,
            box-shadow .15s ease;
        height: 100%;
    }

    .pr-format-option:hover .pr-format-card {
        border-color: #cbd5e1;
        background: #fafafa;
    }

    .pr-format-option.active .pr-format-card {
        border-color: var(--terra-orange);
        background: var(--terra-orange-light);
        box-shadow: 0 0 0 1px rgba(208, 82, 8, .05);
    }

    .pr-format-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        color: var(--terra-navy);
        margin-bottom: .65rem;
    }

    .pr-format-option.active .pr-format-icon {
        background: #fff;
        color: var(--terra-orange);
    }

    .pr-format-label {
        color: var(--terra-navy-dark);
        font-size: .86rem;
        font-weight: 700;
    }

    .pr-format-description {
        color: #9ca3af;
        font-size: .74rem;
        margin-top: .2rem;
    }

    /* Modal footer */

    #exportPropertyRequestsModal .modal-footer {
        padding: 1rem 1.4rem;
        border-top: 1px solid #edf0f3;
        background: #fff;
        gap: .5rem;
    }

    /* =========================
       RESPONSIVE
    ========================== */

    @media (max-width: 768px) {
        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .page-header .header-actions {
            width: 100%;
            display: flex;
        }

        .page-header .header-actions .btn {
            flex: 1;
        }

        .filters-bar {
            align-items: stretch;
            flex-direction: column;
        }

        .filters-bar input,
        .filters-bar select,
        .filters-bar .btn {
            width: 100%;
            min-width: 0;
        }

        #exportPropertyRequestsModal .modal-dialog {
            margin: .5rem;
        }

        #exportPropertyRequestsModal .modal-body {
            padding: 1rem;
        }

        #exportPropertyRequestsModal .modal-header {
            padding: 1rem;
        }

        #exportPropertyRequestsModal .modal-footer {
            padding: .85rem 1rem;
            flex-wrap: wrap;
        }

        #exportPropertyRequestsModal .modal-footer .btn {
            flex: 1;
        }
    }

    @media (max-width: 576px) {
        .page-header h1 {
            font-size: 1.7rem;
        }

        .page-header .header-actions {
            flex-direction: column;
        }

        #exportPropertyRequestsModal .modal-dialog-scrollable {
            height: calc(100% - 1rem);
        }

        #exportPropertyRequestsModal .modal-dialog {
            margin: .5rem;
        }

        #exportPropertyRequestsModal .modal-footer {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        #exportPropertyRequestsModal .modal-footer .download-btn {
            grid-column: 1 / -1;
        }
    }
</style>


{{-- =========================================================
     PAGE HEADER
========================================================= --}}

<div class="page-header">

    <div>
        <h1>Property Requests</h1>
        <p class="subtitle">
            Buyer &amp; renter intake submissions
        </p>
    </div>

    <div class="header-actions d-flex gap-2">

        {{-- Export --}}
        <button
            type="button"
            class="btn btn-navy px-3 py-2"
            data-bs-toggle="modal"
            data-bs-target="#exportPropertyRequestsModal"
        >
            <i class="fa-solid fa-file-export me-1"></i>
            Export
        </button>

        {{-- New Request --}}
        <a
            href="{{ route('admin.property-requests.create') }}"
            class="btn btn-gold px-3 py-2"
        >
            <i class="fa-solid fa-plus me-1"></i>
            New Request
        </a>

    </div>

</div>


{{-- =========================================================
     STATUS TABS
========================================================= --}}

<div class="status-tabs">

    <a
        href="{{ route('admin.property-requests.index') }}"
        class="tab {{ !request('status') ? 'active' : '' }}"
    >
        All
        <span class="count">
            {{ $counts['all'] }}
        </span>
    </a>

    @foreach (\App\Models\PropertyRequest::STATUSES as $key => $label)

        <a
            href="{{ route('admin.property-requests.index', ['status' => $key]) }}"
            class="tab {{ request('status') === $key ? 'active' : '' }}"
        >
            {{ $label }}

            <span class="count">
                {{ $counts[$key] ?? 0 }}
            </span>
        </a>

    @endforeach

</div>


{{-- =========================================================
     FILTERS
========================================================= --}}

<form method="GET" class="filters-bar">

    @if (request('status'))
        <input
            type="hidden"
            name="status"
            value="{{ request('status') }}"
        >
    @endif

    <input
        type="text"
        name="q"
        value="{{ request('q') }}"
        placeholder="Search name, phone, email, ref #"
    >

    <select name="request_type">

        <option value="">
            All Types
        </option>

        @foreach (\App\Models\PropertyRequest::REQUEST_TYPES as $key => $label)

            <option
                value="{{ $key }}"
                @selected(request('request_type') === $key)
            >
                {{ $label }}
            </option>

        @endforeach

    </select>

    <select name="property_type">

        <option value="">
            All Properties
        </option>

        @foreach (\App\Models\PropertyRequest::PROPERTY_TYPES as $key => $label)

            <option
                value="{{ $key }}"
                @selected(request('property_type') === $key)
            >
                {{ $label }}
            </option>

        @endforeach

    </select>

    <select name="is_public">

        <option value="">
            All Visibility
        </option>

        <option
            value="1"
            @selected(request('is_public') === '1')
        >
            Public
        </option>

        <option
            value="0"
            @selected(request('is_public') === '0')
        >
            Private
        </option>

    </select>

    <button
        type="submit"
        class="btn btn-navy px-3"
    >
        <i class="fa-solid fa-filter me-1"></i>
        Filter
    </button>

</form>


{{-- =========================================================
     PROPERTY REQUESTS TABLE
========================================================= --}}

<div class="table-wrap">

    <table class="admin-table">

        <thead>
            <tr>
                <th>Reference</th>
                <th>Client</th>
                <th>Type</th>
                <th>Budget</th>
                <th>Urgency</th>
                <th>Status</th>
                <th>Submitted</th>
                <th></th>
            </tr>
        </thead>

        <tbody>

            @forelse ($requests as $r)

                <tr>

                    {{-- Reference --}}
                    <td class="ref">
                        {{ $r->reference_number }}
                    </td>

                    {{-- Client --}}
                    <td>
                        <div class="client-name">
                            {{ $r->full_name }}
                        </div>

                        <div class="client-sub">
                            {{ $r->phone }}
                        </div>
                    </td>

                    {{-- Request / Property Type --}}
                    <td>

                        {{
                            \App\Models\PropertyRequest::REQUEST_TYPES[$r->request_type]
                            ?? $r->request_type
                        }}

                        <div class="client-sub">
                            {{ $r->property_type_label }}
                        </div>

                    </td>

                    {{-- Budget --}}
                    <td>
                        {{ $r->formatted_budget }}
                    </td>

                    {{-- Urgency --}}
                    <td>

                        <span class="badge badge-{{ $r->urgency_badge_color }}">
                            {{ ucfirst($r->urgency) }}
                        </span>

                    </td>

                    {{-- Status --}}
                    <td>

                        <span class="badge badge-status-{{ $r->status }}">

                            {{
                                \App\Models\PropertyRequest::STATUSES[$r->status]
                                ?? $r->status
                            }}

                        </span>

                    </td>


                    {{-- Submitted --}}
                    <td>
                        {{ $r->created_at->format('M d, Y') }}
                    </td>

                    {{-- Action --}}
                    <td>

                        <a
                            href="{{ route('admin.property-requests.show', $r->id) }}"
                            class="btn-link"
                        >
                            View
                            <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="9" class="empty">

                        <i class="fa-regular fa-folder-open d-block mb-2 fs-4"></i>

                        No property requests found.

                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>


{{-- =========================================================
     PAGINATION
========================================================= --}}

<div class="pagination-wrap">
    {{ $requests->links() }}
</div>


{{-- =========================================================
     STANDARD BOOTSTRAP EXPORT MODAL
========================================================= --}}

<div
    class="modal fade"
    id="exportPropertyRequestsModal"
    tabindex="-1"
    aria-labelledby="exportPropertyRequestsModalLabel"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-dialog-centered modal-lg"
    >

        <div class="modal-content border-0 shadow-lg">

            {{-- Modal Header --}}
            <div class="modal-header">

                <div class="d-flex align-items-center gap-3">

                    <div class="export-modal-icon">
                        <i class="fa-solid fa-file-export"></i>
                    </div>

                    <div>

                        <h5
                            class="export-modal-title"
                            id="exportPropertyRequestsModalLabel"
                        >
                            Export Property Requests
                        </h5>

                        <p class="export-modal-subtitle">
                            Choose filters and download your request data.
                        </p>

                    </div>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- Export Form --}}
            <form
                id="pr-export-form"
                method="GET"
                action="{{ route('admin.property-requests.export') }}"
            >

                {{-- Modal Body --}}
                <div class="modal-body">

                    <p class="export-description">
                        Choose which property requests should be included
                        in the export, then select your preferred format.
                    </p>


                    {{-- =========================
                         REQUEST FILTERS
                    ========================== --}}

                    <div class="export-section-title">

                        <i class="fa-solid fa-sliders"></i>

                        <span>
                            Request Filters
                        </span>

                    </div>


                    <div class="row g-3">

                        {{-- Status --}}
                        <div class="col-md-6">

                            <label
                                for="pr-status"
                                class="form-label"
                            >
                                Status
                            </label>

                            <select
                                name="status"
                                id="pr-status"
                                class="form-select"
                            >

                                <option value="">
                                    All Statuses
                                </option>

                                @foreach (\App\Models\PropertyRequest::STATUSES as $key => $label)

                                    <option value="{{ $key }}">
                                        {{ $label }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Search --}}
                        <div class="col-md-6">

                            <label
                                for="pr-search"
                                class="form-label"
                            >
                                Search
                            </label>

                            <input
                                type="text"
                                name="q"
                                id="pr-search"
                                class="form-control"
                                placeholder="Name, phone, email, ref #"
                            >

                        </div>


                        {{-- Request Type --}}
                        <div class="col-md-6">

                            <label
                                for="pr-request-type"
                                class="form-label"
                            >
                                Request Type
                            </label>

                            <select
                                name="request_type"
                                id="pr-request-type"
                                class="form-select"
                            >

                                <option value="">
                                    All Types
                                </option>

                                @foreach (\App\Models\PropertyRequest::REQUEST_TYPES as $key => $label)

                                    <option value="{{ $key }}">
                                        {{ $label }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Property Type --}}
                        <div class="col-md-6">

                            <label
                                for="pr-property-type"
                                class="form-label"
                            >
                                Property Type
                            </label>

                            <select
                                name="property_type"
                                id="pr-property-type"
                                class="form-select"
                            >

                                <option value="">
                                    All Properties
                                </option>

                                @foreach (\App\Models\PropertyRequest::PROPERTY_TYPES as $key => $label)

                                    <option value="{{ $key }}">
                                        {{ $label }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Visibility --}}
                        <div class="col-md-6">

                            <label
                                for="pr-visibility"
                                class="form-label"
                            >
                                Visibility
                            </label>

                            <select
                                name="is_public"
                                id="pr-visibility"
                                class="form-select"
                            >

                                <option value="">
                                    All Visibility
                                </option>

                                <option value="1">
                                    Public
                                </option>

                                <option value="0">
                                    Private
                                </option>

                            </select>

                        </div>


                        {{-- Date Range --}}
                        <div class="col-md-6">

                            <label
                                for="pr-date-range"
                                class="form-label"
                            >
                                Date Range
                            </label>

                            <select
                                name="date_range"
                                id="pr-date-range"
                                class="form-select"
                                onchange="toggleCustomDates()"
                            >

                                <option value="">
                                    All Time
                                </option>

                                <option value="today">
                                    Today
                                </option>

                                <option value="7_days">
                                    Last 7 Days
                                </option>

                                <option value="30_days">
                                    Last 30 Days
                                </option>

                                <option value="this_month">
                                    This Month
                                </option>

                                <option value="custom">
                                    Custom Range
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- =========================
                         CUSTOM DATE RANGE
                    ========================== --}}

                    <div
                        class="row g-3 mt-1"
                        id="pr-custom-dates"
                        style="display: none;"
                    >

                        <div class="col-md-6">

                            <label
                                for="pr-date-from"
                                class="form-label"
                            >
                                From
                            </label>

                            <input
                                type="date"
                                name="date_from"
                                id="pr-date-from"
                                class="form-control"
                            >

                        </div>

                        <div class="col-md-6">

                            <label
                                for="pr-date-to"
                                class="form-label"
                            >
                                To
                            </label>

                            <input
                                type="date"
                                name="date_to"
                                id="pr-date-to"
                                class="form-control"
                            >

                        </div>

                    </div>


                    {{-- =========================
                         EXPORT FORMAT
                    ========================== --}}

                    <div class="export-section-title mt-4">

                        <i class="fa-solid fa-file-arrow-down"></i>

                        <span>
                            Export Format
                        </span>

                    </div>


                    <div class="row g-3">

                        {{-- Excel --}}
                        <div class="col-md-6">

                            <label
                                class="pr-format-option active"
                                id="opt-excel"
                            >

                                <input
                                    type="radio"
                                    name="format"
                                    value="excel"
                                    checked
                                    onclick="selectFormat('excel')"
                                >

                                <div class="pr-format-card">

                                    <div class="pr-format-icon">
                                        <i class="fa-solid fa-file-excel"></i>
                                    </div>

                                    <div class="pr-format-label">
                                        Excel (.xlsx)
                                    </div>

                                    <div class="pr-format-description">
                                        Spreadsheet format for data analysis.
                                    </div>

                                </div>

                            </label>

                        </div>


                        {{-- PDF --}}
                        <div class="col-md-6">

                            <label
                                class="pr-format-option"
                                id="opt-pdf"
                            >

                                <input
                                    type="radio"
                                    name="format"
                                    value="pdf"
                                    onclick="selectFormat('pdf')"
                                >

                                <div class="pr-format-card">

                                    <div class="pr-format-icon">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </div>

                                    <div class="pr-format-label">
                                        PDF
                                    </div>

                                    <div class="pr-format-description">
                                        Printable document format.
                                    </div>

                                </div>

                            </label>

                        </div>

                    </div>

                </div>


                {{-- Modal Footer --}}
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline px-3"
                        onclick="resetExportForm()"
                    >
                        <i class="fa-solid fa-rotate-left me-1"></i>
                        Reset
                    </button>

                    <button
                        type="button"
                        class="btn btn-outline px-3"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-gold px-4 download-btn"
                    >
                        <i class="fa-solid fa-download me-1"></i>
                        Download
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

<script>
    /**
     * Select export format.
     */
    function selectFormat(format) {

        const excelOption = document.getElementById('opt-excel');
        const pdfOption = document.getElementById('opt-pdf');

        if (!excelOption || !pdfOption) {
            return;
        }

        excelOption.classList.toggle(
            'active',
            format === 'excel'
        );

        pdfOption.classList.toggle(
            'active',
            format === 'pdf'
        );
    }


    /**
     * Show/hide custom date fields.
     */
    function toggleCustomDates() {

        const dateRange = document.getElementById('pr-date-range');
        const customDates = document.getElementById('pr-custom-dates');

        if (!dateRange || !customDates) {
            return;
        }

        const isCustom = dateRange.value === 'custom';

        customDates.style.display = isCustom ? '' : 'none';

        const fromInput = document.getElementById('pr-date-from');
        const toInput = document.getElementById('pr-date-to');

        if (!isCustom) {

            if (fromInput) {
                fromInput.value = '';
            }

            if (toInput) {
                toInput.value = '';
            }

        }
    }


    /**
     * Reset export form.
     */
    function resetExportForm() {

        const form = document.getElementById('pr-export-form');

        if (!form) {
            return;
        }

        form.reset();

        selectFormat('excel');

        toggleCustomDates();
    }


    /**
     * Make sure format cards remain visually synchronized
     * when a radio input is changed with keyboard/accessibility controls.
     */
    document.addEventListener('DOMContentLoaded', function () {

        const formatInputs = document.querySelectorAll(
            '#pr-export-form input[name="format"]'
        );

        formatInputs.forEach(function (input) {

            input.addEventListener('change', function () {

                selectFormat(this.value);

            });

        });

    });
</script>

@endsection