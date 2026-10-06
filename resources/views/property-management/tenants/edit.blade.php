@extends('layouts.property-management')

@section('title', 'Edit Tenant - Property Management')

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

    .tenant-edit-page {
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
        margin-bottom: 5px;
    }

    .page-subtitle {
        color: var(--pm-muted);
        font-size: .88rem;
        margin-bottom: 0;
    }

    .back-btn {
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

    .back-btn:hover {
        color: var(--pm-navy);
        border-color: #ccd1dc;
    }

    /* Profile summary */
    .profile-summary {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(25, 38, 93, .035);
        padding: 18px 20px;
        margin-bottom: 20px;
    }

    .profile-avatar {
        width: 52px;
        height: 52px;
        border-radius: 13px;
        background: #eef1fa;
        color: var(--pm-navy);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .profile-name {
        color: var(--pm-text);
        font-size: .98rem;
        font-weight: 750;
        margin-bottom: 3px;
    }

    .profile-meta {
        color: #858c98;
        font-size: .75rem;
    }

    /* Alerts */
    .validation-alert {
        border: 1px solid #f2caca;
        background: #fff7f7;
        color: #8e3030;
        border-radius: 10px;
        padding: 15px 17px;
        font-size: .84rem;
    }

    .validation-alert strong {
        color: #7e2525;
    }

    .validation-alert ul {
        padding-left: 19px;
    }

    /* Form cards */
    .form-card {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(25, 38, 93, .035);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 18px 21px;
        border-bottom: 1px solid var(--pm-border);
        background: #fff;
    }

    .section-number {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #eef1fa;
        color: var(--pm-navy);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .82rem;
        font-weight: 750;
        flex-shrink: 0;
    }

    .section-number.orange {
        background: #fff0e9;
        color: var(--pm-orange);
    }

    .section-number.green {
        background: #eaf8f1;
        color: #168653;
    }

    .section-title {
        color: var(--pm-text);
        font-size: .98rem;
        font-weight: 750;
        margin: 0;
    }

    .section-description {
        color: #8a919e;
        font-size: .76rem;
        margin: 2px 0 0;
    }

    .section-body {
        padding: 22px;
    }

    /* Fields */
    .field-label {
        display: block;
        color: #505867;
        font-size: .77rem;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .required {
        color: var(--pm-orange);
    }

    .field-help {
        color: #9399a5;
        font-size: .72rem;
        margin-top: 5px;
    }

    .form-control,
    .form-select {
        min-height: 44px;
        border: 1px solid #dfe2e8;
        border-radius: 8px;
        color: var(--pm-text);
        font-size: .86rem;
        padding: 9px 12px;
        box-shadow: none !important;
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    textarea.form-control {
        min-height: auto;
        resize: vertical;
    }

    .form-control::placeholder {
        color: #a8adb7;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--pm-navy);
        box-shadow: 0 0 0 3px rgba(25, 38, 93, .07) !important;
    }

    .input-icon-wrapper {
        position: relative;
    }

    .input-icon-wrapper > i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #969daa;
        font-size: .9rem;
        z-index: 2;
    }

    .input-icon-wrapper .form-control {
        padding-left: 37px;
    }

    .invalid-feedback {
        font-size: .74rem;
    }

    /* Read-only management panel */
    .management-info {
        background: #f7f8fb;
        border: 1px solid #e7e9ee;
        border-radius: 10px;
        padding: 15px;
    }

    .management-info-title {
        color: var(--pm-text);
        font-size: .8rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .management-info-text {
        color: #818896;
        font-size: .74rem;
        line-height: 1.55;
        margin-bottom: 0;
    }

    .status-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--pm-navy);
        text-decoration: none;
        font-size: .75rem;
        font-weight: 650;
        margin-top: 9px;
    }

    .status-link:hover {
        text-decoration: underline;
    }

    /* Info box */
    .info-box {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: #f6f8fc;
        border: 1px solid #e6e9f0;
        border-radius: 9px;
        padding: 12px 14px;
        color: #687080;
        font-size: .76rem;
        line-height: 1.5;
    }

    .info-box i {
        color: var(--pm-navy);
        margin-top: 1px;
    }

    /* Bottom actions */
    .form-actions {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 14px;
        padding: 16px 20px;
        box-shadow: 0 4px 18px rgba(25, 38, 93, .035);
    }

    .required-note {
        color: #8a919d;
        font-size: .74rem;
    }

    .btn-cancel {
        min-height: 42px;
        border-radius: 8px;
        padding: 9px 18px;
        font-size: .84rem;
        font-weight: 600;
        color: #5d6573;
        background: #fff;
        border: 1px solid #dfe2e8;
    }

    .btn-cancel:hover {
        background: #f7f8fa;
        color: var(--pm-navy);
        border-color: #cdd2dc;
    }

    .btn-save {
        min-height: 42px;
        border-radius: 8px;
        padding: 9px 20px;
        font-size: .84rem;
        font-weight: 650;
        color: #fff;
        background: var(--pm-orange);
        border: 1px solid var(--pm-orange);
        transition: .2s ease;
    }

    .btn-save:hover {
        background: #b94705;
        border-color: #b94705;
        color: #fff;
        transform: translateY(-1px);
    }

    @media (max-width: 767.98px) {
        .tenant-edit-page {
            padding-top: 20px;
        }

        .page-title {
            font-size: 1.4rem;
        }

        .section-header,
        .section-body {
            padding: 16px;
        }

        .form-actions {
            padding: 14px;
        }
    }

    @media (max-width: 575.98px) {
        .form-actions .action-buttons {
            width: 100%;
        }

        .btn-cancel,
        .btn-save {
            width: 100%;
        }
    }
</style>

<div class="tenant-edit-page">

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

                    <a href="{{ route('property-management.tenants.show', $tenant) }}">
                        {{ $tenant->full_name }}
                    </a>

                    <span class="mx-1">/</span>

                    <span>Edit</span>

                </div>

                <h1 class="page-title">
                    Edit Tenant
                </h1>

                <p class="page-subtitle">
                    Update the tenant's personal, address and emergency contact information.
                </p>

            </div>

            <a href="{{ route('property-management.tenants.show', $tenant) }}"
               class="back-btn">

                <i class="bi bi-arrow-left"></i>
                Back to Tenant

            </a>

        </div>


        {{-- ==========================================================
             PROFILE SUMMARY
        =========================================================== --}}
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

        <div class="profile-summary">

            <div class="d-flex align-items-center gap-3">

                <div class="profile-avatar">
                    {{ $initials }}
                </div>

                <div>

                    <div class="profile-name">
                        {{ $tenant->full_name }}
                    </div>

                    <div class="profile-meta">

                        @if($tenant->phone)
                            {{ $tenant->phone }}
                        @endif

                        @if($tenant->phone && $tenant->email)
                            <span class="mx-1">•</span>
                        @endif

                        @if($tenant->email)
                            {{ $tenant->email }}
                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- ==========================================================
             VALIDATION ERRORS
        =========================================================== --}}
        @if($errors->any())

            <div class="validation-alert mb-4">

                <div class="d-flex align-items-start gap-2">

                    <i class="bi bi-exclamation-triangle-fill mt-1"></i>

                    <div>

                        <strong>
                            Please review the following fields:
                        </strong>

                        <ul class="mb-0 mt-2">

                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        <form method="POST"
              action="{{ route('property-management.tenants.update', $tenant) }}">

            @csrf
            @method('PUT')


            {{-- ======================================================
                 PERSONAL INFORMATION
            ======================================================= --}}
            <div class="form-card">

                <div class="section-header">

                    <div class="section-number">
                        01
                    </div>

                    <div>

                        <h2 class="section-title">
                            Personal Information
                        </h2>

                        <p class="section-description">
                            Update the tenant's identity and primary contact information.
                        </p>

                    </div>

                </div>

                <div class="section-body">

                    <div class="row g-3">

                        {{-- First Name --}}
                        <div class="col-md-6">

                            <label class="field-label">
                                First Name <span class="required">*</span>
                            </label>

                            <div class="input-icon-wrapper">

                                <i class="bi bi-person"></i>

                                <input type="text"
                                       name="first_name"
                                       value="{{ old('first_name', $tenant->first_name) }}"
                                       class="form-control @error('first_name') is-invalid @enderror"
                                       placeholder="Enter first name"
                                       required>

                            </div>

                            @error('first_name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Last Name --}}
                        <div class="col-md-6">

                            <label class="field-label">
                                Last Name <span class="required">*</span>
                            </label>

                            <div class="input-icon-wrapper">

                                <i class="bi bi-person"></i>

                                <input type="text"
                                       name="last_name"
                                       value="{{ old('last_name', $tenant->last_name) }}"
                                       class="form-control @error('last_name') is-invalid @enderror"
                                       placeholder="Enter last name"
                                       required>

                            </div>

                            @error('last_name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Phone --}}
                        <div class="col-md-4">

                            <label class="field-label">
                                Phone Number <span class="required">*</span>
                            </label>

                            <div class="input-icon-wrapper">

                                <i class="bi bi-telephone"></i>

                                <input type="text"
                                       name="phone"
                                       value="{{ old('phone', $tenant->phone) }}"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="e.g. 0788 000 000"
                                       required>

                            </div>

                            @error('phone')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Email --}}
                        <div class="col-md-4">

                            <label class="field-label">
                                Email Address
                            </label>

                            <div class="input-icon-wrapper">

                                <i class="bi bi-envelope"></i>

                                <input type="email"
                                       name="email"
                                       value="{{ old('email', $tenant->email) }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="tenant@example.com">

                            </div>

                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- National ID --}}
                        <div class="col-md-4">

                            <label class="field-label">
                                National ID
                            </label>

                            <div class="input-icon-wrapper">

                                <i class="bi bi-card-text"></i>

                                <input type="text"
                                       name="national_id"
                                       value="{{ old('national_id', $tenant->national_id) }}"
                                       class="form-control @error('national_id') is-invalid @enderror"
                                       placeholder="National identification number">

                            </div>

                            @error('national_id')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Date of Birth --}}
                        <div class="col-md-4">

                            <label class="field-label">
                                Date of Birth
                            </label>

                            <input type="date"
                                   name="date_of_birth"
                                   value="{{ old('date_of_birth', optional($tenant->date_of_birth)->format('Y-m-d')) }}"
                                   class="form-control @error('date_of_birth') is-invalid @enderror">

                            @error('date_of_birth')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Gender --}}
                        <div class="col-md-4">

                            <label class="field-label">
                                Gender
                            </label>

                            <select name="gender"
                                    class="form-select @error('gender') is-invalid @enderror">

                                <option value="">
                                    Select gender
                                </option>

                                <option value="male"
                                    @selected(old('gender', $tenant->gender) === 'male')}>
                                    Male
                                </option>

                                <option value="female"
                                    @selected(old('gender', $tenant->gender) === 'female')}>
                                    Female
                                </option>

                                <option value="other"
                                    @selected(old('gender', $tenant->gender) === 'other')}>
                                    Other
                                </option>

                            </select>

                            @error('gender')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- ======================================================
                 RESIDENTIAL ADDRESS
            ======================================================= --}}
            <div class="form-card">

                <div class="section-header">

                    <div class="section-number orange">
                        02
                    </div>

                    <div>

                        <h2 class="section-title">
                            Residential Address
                        </h2>

                        <p class="section-description">
                            Update the tenant's current residential location.
                        </p>

                    </div>

                </div>

                <div class="section-body">

                    <div class="row g-3">

                        @foreach([
                            'district' => 'District',
                            'sector' => 'Sector',
                            'cell' => 'Cell',
                            'village' => 'Village'
                        ] as $field => $label)

                            <div class="col-lg-3 col-md-6">

                                <label class="field-label">
                                    {{ $label }}
                                </label>

                                <input type="text"
                                       name="{{ $field }}"
                                       value="{{ old($field, $tenant->$field) }}"
                                       class="form-control @error($field) is-invalid @enderror"
                                       placeholder="{{ $label }}">

                                @error($field)
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        @endforeach


                        <div class="col-12">

                            <label class="field-label">
                                Full Address
                            </label>

                            <textarea name="address"
                                      rows="3"
                                      class="form-control @error('address') is-invalid @enderror"
                                      placeholder="Street, house number, landmark or other address details">{{ old('address', $tenant->address) }}</textarea>

                            @error('address')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- ======================================================
                 EMERGENCY CONTACT
            ======================================================= --}}
            <div class="form-card">

                <div class="section-header">

                    <div class="section-number orange">
                        03
                    </div>

                    <div>

                        <h2 class="section-title">
                            Emergency Contact
                        </h2>

                        <p class="section-description">
                            Update the person who should be contacted in an emergency.
                        </p>

                    </div>

                </div>

                <div class="section-body">

                    <div class="info-box mb-4">

                        <i class="bi bi-info-circle"></i>

                        <span>
                            Keep this information accurate so property management
                            can contact the right person when necessary.
                        </span>

                    </div>

                    <div class="row g-3">

                        {{-- Name --}}
                        <div class="col-md-4">

                            <label class="field-label">
                                Contact Name
                            </label>

                            <div class="input-icon-wrapper">

                                <i class="bi bi-person"></i>

                                <input type="text"
                                       name="emergency_contact_name"
                                       value="{{ old('emergency_contact_name', $tenant->emergency_contact_name) }}"
                                       class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                       placeholder="Full name">

                            </div>

                            @error('emergency_contact_name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Phone --}}
                        <div class="col-md-4">

                            <label class="field-label">
                                Contact Phone
                            </label>

                            <div class="input-icon-wrapper">

                                <i class="bi bi-telephone"></i>

                                <input type="text"
                                       name="emergency_contact_phone"
                                       value="{{ old('emergency_contact_phone', $tenant->emergency_contact_phone) }}"
                                       class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                                       placeholder="Phone number">

                            </div>

                            @error('emergency_contact_phone')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Relationship --}}
                        <div class="col-md-4">

                            <label class="field-label">
                                Relationship
                            </label>

                            <select name="emergency_contact_relationship"
                                    class="form-select @error('emergency_contact_relationship') is-invalid @enderror">

                                <option value="">
                                    Select relationship
                                </option>

                                @foreach([
                                    'Parent',
                                    'Spouse',
                                    'Sibling',
                                    'Child',
                                    'Friend',
                                    'Other'
                                ] as $relationship)

                                    <option value="{{ $relationship }}"
                                        @selected(old('emergency_contact_relationship', $tenant->emergency_contact_relationship) === $relationship)>
                                        {{ $relationship }}
                                    </option>

                                @endforeach

                            </select>

                            @error('emergency_contact_relationship')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- ======================================================
                 INTERNAL NOTES
            ======================================================= --}}
            <div class="form-card">

                <div class="section-header">

                    <div class="section-number green">
                        04
                    </div>

                    <div>

                        <h2 class="section-title">
                            Internal Notes
                        </h2>

                        <p class="section-description">
                            Add or update private property management notes.
                        </p>

                    </div>

                </div>

                <div class="section-body">

                    <label class="field-label">
                        Notes
                    </label>

                    <textarea name="notes"
                              rows="5"
                              class="form-control @error('notes') is-invalid @enderror"
                              placeholder="Add relevant internal notes about this tenant...">{{ old('notes', $tenant->notes) }}</textarea>

                    @error('notes')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="field-help">
                        Internal notes are intended for property management staff.
                    </div>

                </div>

            </div>


            {{-- ======================================================
                 MANAGEMENT STATUS
            ======================================================= --}}
            <div class="form-card">

                <div class="section-header">

                    <div class="section-number">
                        05
                    </div>

                    <div>

                        <h2 class="section-title">
                            Tenant Management
                        </h2>

                        <p class="section-description">
                            KYC and tenant status are managed from the tenant profile.
                        </p>

                    </div>

                </div>

                <div class="section-body">

                    <div class="management-info">

                        <div class="management-info-title">
                            Status management moved to the tenant profile
                        </div>

                        <p class="management-info-text">
                            KYC verification and tenant account status are intentionally
                            managed separately to provide better control and prevent
                            accidental status changes while editing profile information.
                        </p>

                        <a href="{{ route('property-management.tenants.show', $tenant) }}"
                           class="status-link">

                            View Tenant Profile
                            <i class="bi bi-arrow-right"></i>

                        </a>

                    </div>

                </div>

            </div>


            {{-- ======================================================
                 FORM ACTIONS
            ======================================================= --}}
            <div class="form-actions">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <div class="required-note">

                        <span class="required">*</span>
                        Required fields

                    </div>

                    <div class="d-flex gap-2 action-buttons">

                        <a href="{{ route('property-management.tenants.show', $tenant) }}"
                           class="btn btn-cancel">

                            Cancel

                        </a>

                        <button type="submit"
                                class="btn btn-save">

                            <i class="bi bi-check2 me-1"></i>
                            Save Changes

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection