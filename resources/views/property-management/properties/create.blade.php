@extends('layouts.property-management')

@section('title', 'Add Property')

@section('content')

<style>
    :root {
        --pm-navy: #19265d;
        --pm-navy-dark: #111a43;
        --pm-orange: #d05208;
        --pm-orange-light: #fff4ed;
        --pm-bg: #f6f7fb;
        --pm-border: #e5e7eb;
        --pm-text: #172033;
        --pm-muted: #6b7280;
        --pm-success: #15803d;
    }

    .property-create {
        background: var(--pm-bg);
        min-height: calc(100vh - 80px);
        padding: 0 0 2rem;
    }

    /* =========================================================
       HEADER
    ========================================================= */

    .page-header {
        background: #fff;
        border-bottom: 1px solid var(--pm-border);
        margin: -1.5rem -1.5rem 1.5rem;
        padding: 1.35rem 1.5rem;
    }

    .back-link {
        color: var(--pm-muted);
        text-decoration: none;
        font-size: .82rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: .65rem;
    }

    .back-link:hover {
        color: var(--pm-orange);
    }

    .page-title {
        color: var(--pm-text);
        font-size: 1.55rem;
        font-weight: 750;
        margin: 0;
        letter-spacing: -.025em;
    }

    .page-subtitle {
        color: var(--pm-muted);
        font-size: .9rem;
        margin: .3rem 0 0;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: .65rem;
    }

    .btn-outline-modern {
        background: #fff;
        border: 1px solid var(--pm-border);
        color: #374151;
        font-weight: 600;
        border-radius: 8px;
        padding: .6rem 1rem;
    }

    .btn-outline-modern:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
        color: var(--pm-navy);
    }

    /* =========================================================
       SECTIONS
    ========================================================= */

    .form-section {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 12px;
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: .85rem;
        padding: 1rem 1.2rem;
        border-bottom: 1px solid var(--pm-border);
        background: #fff;
    }

    .section-number {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--pm-navy);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .65rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .section-title {
        margin: 0;
        font-size: .95rem;
        font-weight: 750;
        color: var(--pm-text);
    }

    .section-description {
        margin: 2px 0 0;
        color: var(--pm-muted);
        font-size: .76rem;
    }

    .section-body {
        padding: 1.25rem;
    }

    /* =========================================================
       FORM
    ========================================================= */

    .form-label {
        color: #374151;
        font-size: .8rem;
        font-weight: 700;
        margin-bottom: .42rem;
    }

    .required {
        color: var(--pm-orange);
    }

    .optional {
        color: #9ca3af;
        font-weight: 500;
        font-size: .72rem;
        margin-left: 3px;
    }

    .form-control,
    .form-select {
        border: 1px solid #dfe3e8;
        border-radius: 8px;
        min-height: 43px;
        padding: .58rem .75rem;
        font-size: .85rem;
        color: #1f2937;
        background-color: #fff;
        box-shadow: none;
        transition: all .15s ease;
    }

    textarea.form-control {
        min-height: 125px;
        resize: vertical;
    }

    .form-control::placeholder {
        color: #a3aab5;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--pm-orange);
        box-shadow: 0 0 0 3px rgba(208, 82, 8, .08);
    }

    .field-help {
        color: #8a919c;
        font-size: .72rem;
        margin-top: .35rem;
    }

    /* =========================================================
       OWNER
    ========================================================= */

    .owner-summary {
        display: flex;
        align-items: center;
        gap: .85rem;
        padding: .9rem;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .owner-avatar {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: var(--pm-navy);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        font-weight: 750;
        flex-shrink: 0;
    }

    .owner-label {
        color: #9ca3af;
        font-size: .62rem;
        font-weight: 750;
        letter-spacing: .07em;
        margin-bottom: 2px;
    }

    .owner-name {
        color: var(--pm-text);
        font-size: .86rem;
        font-weight: 750;
    }

    .owner-email {
        color: var(--pm-muted);
        font-size: .72rem;
        margin-top: 1px;
    }

    .owner-badge {
        margin-left: auto;
        white-space: nowrap;
        padding: .35rem .55rem;
        border-radius: 6px;
        background: #ecfdf3;
        color: #15803d;
        font-size: .65rem;
        font-weight: 700;
    }

    /* =========================================================
       SIDEBAR
    ========================================================= */

    .sticky-panel {
        position: sticky;
        top: 1rem;
    }

    .side-card {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 12px;
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .side-card-header {
        padding: .95rem 1rem;
        border-bottom: 1px solid var(--pm-border);
    }

    .side-card-title {
        font-size: .88rem;
        font-weight: 750;
        color: var(--pm-text);
        margin: 0;
    }

    .side-card-body {
        padding: 1rem;
    }

    .status-hint {
        display: flex;
        align-items: flex-start;
        gap: 7px;
        background: #f8fafc;
        border: 1px solid #edf0f3;
        padding: .65rem .7rem;
        border-radius: 8px;
        color: #6b7280;
        font-size: .72rem;
        margin-top: .7rem;
        line-height: 1.4;
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--pm-success);
        flex-shrink: 0;
        margin-top: 4px;
    }

    .switch-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        padding: .8rem 0;
        border-bottom: 1px solid #f0f1f3;
    }

    .switch-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .switch-title {
        font-size: .8rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 2px;
    }

    .switch-description {
        color: #8a919c;
        font-size: .7rem;
        line-height: 1.4;
    }

    .form-check-input {
        width: 2.2em;
        height: 1.15em;
        margin-top: .1rem;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--pm-orange);
        border-color: var(--pm-orange);
    }

    /* =========================================================
       WORKFLOW BOX
    ========================================================= */

    .publication-box {
        background: linear-gradient(
            135deg,
            var(--pm-navy-dark),
            var(--pm-navy)
        );
        color: #fff;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .publication-label {
        text-transform: uppercase;
        letter-spacing: .08em;
        font-size: .62rem;
        font-weight: 700;
        opacity: .65;
        margin-bottom: .3rem;
    }

    .publication-title {
        font-size: .92rem;
        font-weight: 750;
        margin-bottom: .25rem;
    }

    .publication-text {
        font-size: .72rem;
        opacity: .72;
        line-height: 1.45;
        margin-bottom: 0;
    }

    /* =========================================================
       BUTTONS
    ========================================================= */

    .btn-primary-modern {
        background: var(--pm-orange);
        border: 1px solid var(--pm-orange);
        color: #fff;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 700;
        padding: .7rem 1rem;
        transition: all .15s ease;
    }

    .btn-primary-modern:hover {
        background: #b94505;
        border-color: #b94505;
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-secondary-modern {
        background: #fff;
        border: 1px solid var(--pm-border);
        color: #4b5563;
        border-radius: 8px;
        font-size: .82rem;
        font-weight: 650;
        padding: .68rem 1rem;
    }

    .btn-secondary-modern:hover {
        background: #f8fafc;
        color: var(--pm-navy);
    }

    .required-note {
        font-size: .72rem;
        color: #8a919c;
        margin-bottom: 0;
    }

    .required-note span {
        color: var(--pm-orange);
        font-weight: 700;
    }

    .mini-divider {
        height: 1px;
        background: #edf0f3;
        margin: 1rem 0;
    }

    /* =========================================================
       ERROR
    ========================================================= */

    .alert-modern {
        border: 1px solid #fecaca;
        background: #fff7f7;
        color: #991b1b;
        border-radius: 10px;
        padding: 1rem 1.1rem;
        margin-bottom: 1rem;
    }

    .alert-modern ul {
        margin-bottom: 0;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .sticky-panel {
            position: static;
        }

    }

    @media (max-width: 575.98px) {

        .page-header {
            margin-left: -1rem;
            margin-right: -1rem;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .header-actions {
            width: 100%;
            margin-top: 1rem;
        }

        .header-actions .btn {
            flex: 1;
        }

        .section-body {
            padding: 1rem;
        }

        .owner-summary {
            align-items: flex-start;
        }

        .owner-badge {
            display: none;
        }

    }
</style>


<div class="property-create">

    {{-- ============================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ============================================================= --}}

    <div class="page-header">

        <div class="d-flex flex-wrap justify-content-between align-items-start">

            <div>

                <a href="{{ route('property-management.properties.index') }}"
                   class="back-link">

                    <span>←</span>

                    Properties

                </a>

                <h1 class="page-title">
                    Add New Property
                </h1>

                <p class="page-subtitle">
                    Create and configure a property record for your portfolio.
                </p>

            </div>

            <div class="header-actions">

                <a href="{{ route('property-management.properties.index') }}"
                   class="btn btn-outline-modern">

                    Cancel

                </a>

            </div>

        </div>

    </div>


    <div class="container-fluid px-0">

        {{-- ============================================================= --}}
        {{-- VALIDATION ERRORS --}}
        {{-- ============================================================= --}}

        @if ($errors->any())

            <div class="alert-modern">

                <div class="fw-bold mb-2">
                    Please review the following issues:
                </div>

                <ul class="ps-3">

                    @foreach ($errors->all() as $error)

                        <li class="small mb-1">
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            action="{{ route('property-management.properties.store') }}"
            method="POST"
        >

            @csrf


            <div class="row g-3">


                {{-- ===================================================== --}}
                {{-- MAIN CONTENT --}}
                {{-- ===================================================== --}}

                <div class="col-xl-8">


                    {{-- ================================================= --}}
                    {{-- PROPERTY DETAILS --}}
                    {{-- ================================================= --}}

                    <div class="form-section">

                        <div class="section-header">

                            <span class="section-number">
                                01
                            </span>

                            <div>

                                <h2 class="section-title">
                                    Property details
                                </h2>

                                <p class="section-description">
                                    Basic information about the property.
                                </p>

                            </div>

                        </div>


                        <div class="section-body">

                            <div class="row g-3">


                                {{-- ================================================= --}}
                                {{-- CURRENT AUTHENTICATED OWNER --}}
                                {{-- ================================================= --}}

                                <div class="col-12">

                                    <label class="form-label">
                                        Property owner
                                    </label>

                                    <div class="owner-summary">

                                        <div class="owner-avatar">

                                            {{ strtoupper(
                                                substr(
                                                    trim(auth()->user()->name ?? 'U'),
                                                    0,
                                                    1
                                                )
                                            ) }}

                                        </div>


                                        <div class="flex-grow-1">

                                            <div class="owner-label">
                                                CURRENT ACCOUNT
                                            </div>

                                            <div class="owner-name">
                                                {{ auth()->user()->name }}
                                            </div>

                                            @if(auth()->user()->email)

                                                <div class="owner-email">
                                                    {{ auth()->user()->email }}
                                                </div>

                                            @endif

                                        </div>


                                        <div class="owner-badge">
                                            Property owner
                                        </div>

                                    </div>


                                    {{-- Important:
                                         The controller also forces this
                                         value from auth()->id().
                                    --}}

                                    <input
                                        type="hidden"
                                        name="user_id"
                                        value="{{ auth()->id() }}"
                                    >

                                </div>


                                {{-- ================================================= --}}
                                {{-- TITLE --}}
                                {{-- ================================================= --}}

                                <div class="col-12">

                                    <label class="form-label">
                                        Property title
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="title"
                                        value="{{ old('title') }}"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="e.g. Modern 4-Bedroom House in Kicukiro"
                                        required
                                    >

                                    @error('title')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- ================================================= --}}
                                {{-- DESCRIPTION --}}
                                {{-- ================================================= --}}

                                <div class="col-12">

                                    <label class="form-label">
                                        Property description
                                        <span class="required">*</span>
                                    </label>

                                    <textarea
                                        name="description"
                                        rows="5"
                                        class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Provide a clear description of the property, features, condition and other relevant details..."
                                        required
                                    >{{ old('description') }}</textarea>

                                    @error('description')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- ================================================= --}}
                                {{-- TYPE --}}
                                {{-- ================================================= --}}

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Property type
                                        <span class="required">*</span>
                                    </label>

                                    <select
                                        name="type"
                                        class="form-select @error('type') is-invalid @enderror"
                                        required
                                    >

                                        <option value="">
                                            Select type
                                        </option>

                                        <option
                                            value="house"
                                            {{ old('type') === 'house' ? 'selected' : '' }}
                                        >
                                            House
                                        </option>

                                        <option
                                            value="land"
                                            {{ old('type') === 'land' ? 'selected' : '' }}
                                        >
                                            Land
                                        </option>

                                    </select>

                                    @error('type')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- ================================================= --}}
                                {{-- CATEGORY --}}
                                {{-- ================================================= --}}

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Property category
                                        <span class="required">*</span>
                                    </label>

                                    <select
                                        name="property_category"
                                        class="form-select @error('property_category') is-invalid @enderror"
                                        required
                                    >

                                        <option value="">
                                            Select category
                                        </option>

                                        <option
                                            value="residential"
                                            {{ old('property_category') === 'residential' ? 'selected' : '' }}
                                        >
                                            Residential
                                        </option>

                                        <option
                                            value="commercial"
                                            {{ old('property_category') === 'commercial' ? 'selected' : '' }}
                                        >
                                            Commercial
                                        </option>

                                        <option
                                            value="land"
                                            {{ old('property_category') === 'land' ? 'selected' : '' }}
                                        >
                                            Land
                                        </option>

                                        <option
                                            value="industrial"
                                            {{ old('property_category') === 'industrial' ? 'selected' : '' }}
                                        >
                                            Industrial
                                        </option>

                                    </select>

                                    @error('property_category')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- ================================================= --}}
                                {{-- LISTING TYPE --}}
                                {{-- ================================================= --}}

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Listing type
                                        <span class="required">*</span>
                                    </label>

                                    <select
                                        name="listing_type"
                                        class="form-select @error('listing_type') is-invalid @enderror"
                                        required
                                    >

                                        <option value="">
                                            Select listing type
                                        </option>

                                        <option
                                            value="sale"
                                            {{ old('listing_type') === 'sale' ? 'selected' : '' }}
                                        >
                                            For sale
                                        </option>

                                        <option
                                            value="rent"
                                            {{ old('listing_type') === 'rent' ? 'selected' : '' }}
                                        >
                                            For rent
                                        </option>

                                        <option
                                            value="lease"
                                            {{ old('listing_type') === 'lease' ? 'selected' : '' }}
                                        >
                                            Lease
                                        </option>

                                    </select>

                                    @error('listing_type')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- ================================================= --}}
                                {{-- PRICE --}}
                                {{-- ================================================= --}}

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Price (RWF)
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="number"
                                        name="price"
                                        value="{{ old('price') }}"
                                        min="0"
                                        step="0.01"
                                        class="form-control @error('price') is-invalid @enderror"
                                        placeholder="e.g. 85000000"
                                        required
                                    >

                                    @error('price')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- LOCATION --}}
                    {{-- ================================================= --}}

                    <div class="form-section">

                        <div class="section-header">

                            <span class="section-number">
                                02
                            </span>

                            <div>

                                <h2 class="section-title">
                                    Property location
                                </h2>

                                <p class="section-description">
                                    Specify where the property is located.
                                </p>

                            </div>

                        </div>


                        <div class="section-body">

                            <div class="row g-3">


                                {{-- District --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        District
                                        <span class="required">*</span>
                                    </label>

                                    <select
                                        name="district"
                                        class="form-select @error('district') is-invalid @enderror"
                                        required
                                    >

                                        <option value="">
                                            Select district
                                        </option>

                                        @foreach([
                                            'Gasabo',
                                            'Kicukiro',
                                            'Nyarugenge',
                                            'Musanze',
                                            'Huye',
                                            'Rubavu',
                                            'Muhanga',
                                            'Other'
                                        ] as $district)

                                            <option
                                                value="{{ $district }}"
                                                {{ old('district') === $district ? 'selected' : '' }}
                                            >
                                                {{ $district }}
                                            </option>

                                        @endforeach

                                    </select>

                                    @error('district')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Sector --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Sector
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="sector"
                                        value="{{ old('sector') }}"
                                        class="form-control @error('sector') is-invalid @enderror"
                                        placeholder="e.g. Remera"
                                        required
                                    >

                                    @error('sector')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Cell --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Cell
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="cell"
                                        value="{{ old('cell') }}"
                                        class="form-control @error('cell') is-invalid @enderror"
                                        placeholder="e.g. Rukiri"
                                        required
                                    >

                                    @error('cell')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Village --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Village
                                        <span class="optional">
                                            Optional
                                        </span>
                                    </label>

                                    <input
                                        type="text"
                                        name="village"
                                        value="{{ old('village') }}"
                                        class="form-control @error('village') is-invalid @enderror"
                                        placeholder="e.g. Nyarutarama"
                                    >

                                    @error('village')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Address --}}
                                <div class="col-12">

                                    <label class="form-label">
                                        Street / address
                                        <span class="optional">
                                            Optional
                                        </span>
                                    </label>

                                    <input
                                        type="text"
                                        name="address"
                                        value="{{ old('address') }}"
                                        class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Street, neighborhood or additional address details"
                                    >

                                    @error('address')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- MAP COORDINATES --}}
                    {{-- ================================================= --}}

                    <div class="form-section">

                        <div class="section-header">

                            <span class="section-number">
                                03
                            </span>

                            <div>

                                <h2 class="section-title">
                                    Map coordinates
                                </h2>

                                <p class="section-description">
                                    Add precise geographic coordinates when available.
                                </p>

                            </div>

                        </div>


                        <div class="section-body">

                            <div class="row g-3">


                                {{-- Latitude --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Latitude
                                        <span class="optional">
                                            Optional
                                        </span>
                                    </label>

                                    <input
                                        type="number"
                                        name="latitude"
                                        value="{{ old('latitude') }}"
                                        step="0.0000001"
                                        class="form-control @error('latitude') is-invalid @enderror"
                                        placeholder="-1.9441"
                                    >

                                    <div class="field-help">
                                        Example: -1.9441
                                    </div>

                                    @error('latitude')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- Longitude --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Longitude
                                        <span class="optional">
                                            Optional
                                        </span>
                                    </label>

                                    <input
                                        type="number"
                                        name="longitude"
                                        value="{{ old('longitude') }}"
                                        step="0.0000001"
                                        class="form-control @error('longitude') is-invalid @enderror"
                                        placeholder="30.0619"
                                    >

                                    <div class="field-help">
                                        Example: 30.0619
                                    </div>

                                    @error('longitude')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                            </div>

                        </div>

                    </div>


                </div>


                {{-- ===================================================== --}}
                {{-- RIGHT SIDEBAR --}}
                {{-- ===================================================== --}}

                <div class="col-xl-4">

                    <div class="sticky-panel">


                        {{-- ================================================= --}}
                        {{-- WORKFLOW --}}
                        {{-- ================================================= --}}

                        <div class="publication-box">

                            <div class="publication-label">
                                Property workflow
                            </div>

                            <div class="publication-title">
                                Configure before publishing
                            </div>

                            <p class="publication-text">
                                Review the property's status, management
                                settings and publication permissions before
                                saving.
                            </p>

                        </div>


                        {{-- ================================================= --}}
                        {{-- LISTING STATUS --}}
                        {{-- ================================================= --}}

                        <div class="side-card">

                            <div class="side-card-header">

                                <h3 class="side-card-title">
                                    Listing status
                                </h3>

                            </div>


                            <div class="side-card-body">


                                <label class="form-label">
                                    Availability
                                    <span class="required">*</span>
                                </label>

                                <select
                                    name="status"
                                    class="form-select @error('status') is-invalid @enderror"
                                    required
                                >

                                    <option value="">
                                        Select status
                                    </option>

                                    <option
                                        value="available"
                                        {{ old('status', 'available') === 'available' ? 'selected' : '' }}
                                    >
                                        Available
                                    </option>

                                    <option
                                        value="reserved"
                                        {{ old('status') === 'reserved' ? 'selected' : '' }}
                                    >
                                        Reserved
                                    </option>

                                    <option
                                        value="sold"
                                        {{ old('status') === 'sold' ? 'selected' : '' }}
                                    >
                                        Sold
                                    </option>

                                </select>

                                @error('status')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror


                                <div class="status-hint">

                                    <span class="status-dot"></span>

                                    <span>
                                        Availability controls how this property
                                        appears in the portfolio.
                                    </span>

                                </div>


                                <div class="mini-divider"></div>


                                <label class="form-label">
                                    Management status
                                    <span class="required">*</span>
                                </label>

                                <select
                                    name="management_status"
                                    class="form-select @error('management_status') is-invalid @enderror"
                                    required
                                >

                                    <option
                                        value="not_managed"
                                        {{ old('management_status', 'not_managed') === 'not_managed' ? 'selected' : '' }}
                                    >
                                        Not managed
                                    </option>

                                    <option
                                        value="active"
                                        {{ old('management_status') === 'active' ? 'selected' : '' }}
                                    >
                                        Active
                                    </option>

                                    <option
                                        value="inactive"
                                        {{ old('management_status') === 'inactive' ? 'selected' : '' }}
                                    >
                                        Inactive
                                    </option>

                                </select>

                                @error('management_status')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- MANAGEMENT --}}
                        {{-- ================================================= --}}

                        <div class="side-card">

                            <div class="side-card-header">

                                <h3 class="side-card-title">
                                    Terra management
                                </h3>

                            </div>


                            <div class="side-card-body">


                                <div class="switch-row">

                                    <div>

                                        <div class="switch-title">
                                            Approve property
                                        </div>

                                        <div class="switch-description">
                                            Allow the property to be published
                                            after creation.
                                        </div>

                                    </div>


                                    <div class="form-check form-switch m-0">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="is_approved"
                                            value="1"
                                            id="is_approved"
                                            {{ old('is_approved') ? 'checked' : '' }}
                                        >

                                    </div>

                                </div>


                                <div class="switch-row">

                                    <div>

                                        <div class="switch-title">
                                            Managed property
                                        </div>

                                        <div class="switch-description">
                                            Mark this property as actively
                                            managed by Terra.
                                        </div>

                                    </div>


                                    <div class="form-check form-switch m-0">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="is_managed"
                                            value="1"
                                            id="is_managed"
                                            {{ old('is_managed') ? 'checked' : '' }}
                                        >

                                    </div>

                                </div>


                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- LAND INFORMATION --}}
                        {{-- ================================================= --}}

                        <div class="side-card">

                            <div class="side-card-header">

                                <h3 class="side-card-title">
                                    Land information
                                </h3>

                            </div>


                            <div class="side-card-body">


                                <div class="mb-3">

                                    <label class="form-label">
                                        UPI reference
                                        <span class="optional">
                                            Optional
                                        </span>
                                    </label>

                                    <input
                                        type="text"
                                        name="upi_reference"
                                        value="{{ old('upi_reference') }}"
                                        class="form-control @error('upi_reference') is-invalid @enderror"
                                        placeholder="e.g. 1/01/05/06"
                                    >

                                    @error('upi_reference')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                <div>

                                    <label class="form-label">
                                        Zoning
                                        <span class="optional">
                                            Optional
                                        </span>
                                    </label>

                                    <select
                                        name="zoning"
                                        class="form-select @error('zoning') is-invalid @enderror"
                                    >

                                        <option value="">
                                            Select zoning
                                        </option>

                                        <option
                                            value="R1"
                                            {{ old('zoning') === 'R1' ? 'selected' : '' }}
                                        >
                                            R1
                                        </option>

                                        <option
                                            value="R2"
                                            {{ old('zoning') === 'R2' ? 'selected' : '' }}
                                        >
                                            R2
                                        </option>

                                        <option
                                            value="R3"
                                            {{ old('zoning') === 'R3' ? 'selected' : '' }}
                                        >
                                            R3
                                        </option>

                                        <option
                                            value="Commercial"
                                            {{ old('zoning') === 'Commercial' ? 'selected' : '' }}
                                        >
                                            Commercial
                                        </option>

                                        <option
                                            value="Industrial"
                                            {{ old('zoning') === 'Industrial' ? 'selected' : '' }}
                                        >
                                            Industrial
                                        </option>

                                    </select>

                                    @error('zoning')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- EXPIRATION --}}
                        {{-- ================================================= --}}

                        <div class="side-card">

                            <div class="side-card-header">

                                <h3 class="side-card-title">
                                    Listing expiration
                                </h3>

                            </div>


                            <div class="side-card-body">

                                <label class="form-label">
                                    Expires at
                                    <span class="optional">
                                        Optional
                                    </span>
                                </label>

                                <input
                                    type="datetime-local"
                                    name="expires_at"
                                    value="{{ old('expires_at') }}"
                                    class="form-control @error('expires_at') is-invalid @enderror"
                                >

                                @error('expires_at')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                                <div class="field-help">
                                    Leave empty for a listing with no expiration date.
                                </div>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- SAVE --}}
                        {{-- ================================================= --}}

                        <div class="side-card">

                            <div class="side-card-body">

                                <p class="required-note mb-3">
                                    <span>*</span>
                                    Required fields must be completed.
                                </p>


                                <button
                                    type="submit"
                                    class="btn btn-primary-modern w-100"
                                >
                                    Add property
                                </button>


                                <a
                                    href="{{ route('property-management.properties.index') }}"
                                    class="btn btn-secondary-modern w-100 mt-2 text-center"
                                >
                                    Cancel
                                </a>

                            </div>

                        </div>


                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection