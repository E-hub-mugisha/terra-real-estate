@extends('layouts.property-management')

@section('title', 'Register Tenant - Property Management')

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

    .tenant-create-page {
        background: var(--pm-bg);
        min-height: calc(100vh - 80px);
        padding: 28px 0 50px;
    }

    /* Header */
    .page-header {
        margin-bottom: 25px;
    }

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
        font-size: .9rem;
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
        font-size: .82rem;
        font-weight: 600;
        text-decoration: none;
        transition: .2s ease;
    }

    .back-btn:hover {
        color: var(--pm-navy);
        border-color: #ccd1dc;
        background: #fff;
    }

    /* Alerts */
    .validation-alert {
        border: 1px solid #f2caca;
        background: #fff7f7;
        color: #8e3030;
        border-radius: 10px;
        padding: 15px 17px;
        font-size: .85rem;
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

    /* Form fields */
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

    /* Status cards */
    .status-option {
        position: relative;
    }

    .status-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .status-option label {
        display: block;
        border: 1px solid #dfe2e8;
        border-radius: 9px;
        padding: 12px 14px;
        cursor: pointer;
        transition: .18s ease;
        background: #fff;
    }

    .status-option label:hover {
        border-color: #cbd0da;
        background: #fafbfc;
    }

    .status-option input:checked + label {
        border-color: var(--pm-navy);
        background: #f6f7fc;
        box-shadow: 0 0 0 2px rgba(25, 38, 93, .06);
    }

    .status-option-title {
        color: var(--pm-text);
        font-size: .82rem;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .status-option-description {
        color: #8b929e;
        font-size: .71rem;
    }

    /* Form footer */
    .form-actions {
        background: #fff;
        border: 1px solid var(--pm-border);
        border-radius: 14px;
        padding: 16px 20px;
        box-shadow: 0 4px 18px rgba(25, 38, 93, .035);
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

    .btn-register {
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

    .btn-register:hover {
        background: #b94705;
        border-color: #b94705;
        color: #fff;
        transform: translateY(-1px);
    }

    .required-note {
        color: #8a919d;
        font-size: .74rem;
    }

    /* Small info box */
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

    @media (max-width: 767.98px) {
        .tenant-create-page {
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

        .btn-cancel,
        .btn-register {
            flex: 1;
        }
    }

    @media (max-width: 575.98px) {
        .form-actions .d-flex {
            width: 100%;
        }

        .btn-cancel,
        .btn-register {
            width: 100%;
        }
    }
</style>

<div class="tenant-create-page">

    <div class="container-fluid px-3 px-lg-4">

        {{-- PAGE HEADER --}}
        <div class="page-header">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

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
                        <span>Register</span>
                    </div>

                    <h1 class="page-title">
                        Register Tenant
                    </h1>

                    <p class="page-subtitle">
                        Create and maintain a complete tenant profile for property management.
                    </p>
                </div>

                <a href="{{ route('property-management.tenants.index') }}"
                   class="back-btn">
                    <i class="bi bi-arrow-left"></i>
                    Back to Tenants
                </a>

            </div>

        </div>

        {{-- VALIDATION ERRORS --}}
        @if($errors->any())
            <div class="validation-alert mb-4">

                <div class="d-flex align-items-start gap-2">

                    <i class="bi bi-exclamation-triangle-fill mt-1"></i>

                    <div class="flex-grow-1">

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
              action="{{ route('property-management.tenants.store') }}">

            @csrf

            {{-- =========================
                 PERSONAL INFORMATION
            ========================== --}}
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
                            Basic identification and contact information for the tenant.
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
                                       value="{{ old('first_name') }}"
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
                                       value="{{ old('last_name') }}"
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
                                       value="{{ old('phone') }}"
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
                                       value="{{ old('email') }}"
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
                                       value="{{ old('national_id') }}"
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
                                   value="{{ old('date_of_birth') }}"
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
                                    @selected(old('gender') === 'male')}>
                                    Male
                                </option>

                                <option value="female"
                                    @selected(old('gender') === 'female')}>
                                    Female
                                </option>

                                <option value="other"
                                    @selected(old('gender') === 'other')}>
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


            {{-- =========================
                 ADDRESS
            ========================== --}}
            <div class="form-card">

                <div class="section-header">

                    <div class="section-number">
                        02
                    </div>

                    <div>
                        <h2 class="section-title">
                            Residential Address
                        </h2>

                        <p class="section-description">
                            Record the tenant's current residential location.
                        </p>
                    </div>

                </div>

                <div class="section-body">

                    <div class="row g-3">

                        <div class="col-lg-3 col-md-6">

                            <label class="field-label">
                                District
                            </label>

                            <input type="text"
                                   name="district"
                                   value="{{ old('district') }}"
                                   class="form-control @error('district') is-invalid @enderror"
                                   placeholder="District">

                            @error('district')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-lg-3 col-md-6">

                            <label class="field-label">
                                Sector
                            </label>

                            <input type="text"
                                   name="sector"
                                   value="{{ old('sector') }}"
                                   class="form-control @error('sector') is-invalid @enderror"
                                   placeholder="Sector">

                            @error('sector')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-lg-3 col-md-6">

                            <label class="field-label">
                                Cell
                            </label>

                            <input type="text"
                                   name="cell"
                                   value="{{ old('cell') }}"
                                   class="form-control @error('cell') is-invalid @enderror"
                                   placeholder="Cell">

                            @error('cell')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-lg-3 col-md-6">

                            <label class="field-label">
                                Village
                            </label>

                            <input type="text"
                                   name="village"
                                   value="{{ old('village') }}"
                                   class="form-control @error('village') is-invalid @enderror"
                                   placeholder="Village">

                            @error('village')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-12">

                            <label class="field-label">
                                Full Address
                            </label>

                            <textarea name="address"
                                      rows="3"
                                      class="form-control @error('address') is-invalid @enderror"
                                      placeholder="Enter street, house number, landmark or other address details">{{ old('address') }}</textarea>

                            @error('address')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================
                 EMERGENCY CONTACT
            ========================== --}}
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
                            Contact information for someone who can be reached in an emergency.
                        </p>
                    </div>

                </div>

                <div class="section-body">

                    <div class="info-box mb-4">
                        <i class="bi bi-info-circle"></i>

                        <span>
                            Providing an emergency contact helps property management
                            respond quickly when the tenant cannot be reached.
                        </span>
                    </div>

                    <div class="row g-3">

                        <div class="col-md-4">

                            <label class="field-label">
                                Contact Name
                            </label>

                            <div class="input-icon-wrapper">

                                <i class="bi bi-person"></i>

                                <input type="text"
                                       name="emergency_contact_name"
                                       value="{{ old('emergency_contact_name') }}"
                                       class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                       placeholder="Full name">

                            </div>

                            @error('emergency_contact_name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-md-4">

                            <label class="field-label">
                                Contact Phone
                            </label>

                            <div class="input-icon-wrapper">

                                <i class="bi bi-telephone"></i>

                                <input type="text"
                                       name="emergency_contact_phone"
                                       value="{{ old('emergency_contact_phone') }}"
                                       class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                                       placeholder="Phone number">

                            </div>

                            @error('emergency_contact_phone')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-md-4">

                            <label class="field-label">
                                Relationship
                            </label>

                            <select name="emergency_contact_relationship"
                                    class="form-select @error('emergency_contact_relationship') is-invalid @enderror">

                                <option value="">
                                    Select relationship
                                </option>

                                <option value="Parent"
                                    @selected(old('emergency_contact_relationship') === 'Parent')}>
                                    Parent
                                </option>

                                <option value="Spouse"
                                    @selected(old('emergency_contact_relationship') === 'Spouse')}>
                                    Spouse
                                </option>

                                <option value="Sibling"
                                    @selected(old('emergency_contact_relationship') === 'Sibling')}>
                                    Sibling
                                </option>

                                <option value="Child"
                                    @selected(old('emergency_contact_relationship') === 'Child')}>
                                    Child
                                </option>

                                <option value="Friend"
                                    @selected(old('emergency_contact_relationship') === 'Friend')}>
                                    Friend
                                </option>

                                <option value="Other"
                                    @selected(old('emergency_contact_relationship') === 'Other')}>
                                    Other
                                </option>

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


            {{-- =========================
                 MANAGEMENT STATUS
            ========================== --}}
            <div class="form-card">

                <div class="section-header">

                    <div class="section-number">
                        04
                    </div>

                    <div>
                        <h2 class="section-title">
                            Tenant Management
                        </h2>

                        <p class="section-description">
                            Configure KYC verification and tenant account status.
                        </p>
                    </div>

                </div>

                <div class="section-body">

                    <div class="row g-4">

                        {{-- KYC --}}
                        <div class="col-lg-6">

                            <label class="field-label">
                                KYC Status
                            </label>

                            <div class="row g-2">

                                <div class="col-4">
                                    <div class="status-option">

                                        <input type="radio"
                                               name="kyc_status"
                                               id="kyc_pending"
                                               value="pending"
                                               @checked(old('kyc_status', 'pending') === 'pending')>

                                        <label for="kyc_pending">

                                            <div class="status-option-title">
                                                Pending
                                            </div>

                                            <div class="status-option-description">
                                                Not verified
                                            </div>

                                        </label>

                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="status-option">

                                        <input type="radio"
                                               name="kyc_status"
                                               id="kyc_verified"
                                               value="verified"
                                               @checked(old('kyc_status') === 'verified')>

                                        <label for="kyc_verified">

                                            <div class="status-option-title">
                                                Verified
                                            </div>

                                            <div class="status-option-description">
                                                Documents verified
                                            </div>

                                        </label>

                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="status-option">

                                        <input type="radio"
                                               name="kyc_status"
                                               id="kyc_rejected"
                                               value="rejected"
                                               @checked(old('kyc_status') === 'rejected')>

                                        <label for="kyc_rejected">

                                            <div class="status-option-title">
                                                Rejected
                                            </div>

                                            <div class="status-option-description">
                                                Verification failed
                                            </div>

                                        </label>

                                    </div>
                                </div>

                            </div>

                            @error('kyc_status')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Tenant Status --}}
                        <div class="col-lg-6">

                            <label class="field-label">
                                Tenant Status
                            </label>

                            <div class="row g-2">

                                <div class="col-4">
                                    <div class="status-option">

                                        <input type="radio"
                                               name="status"
                                               id="status_active"
                                               value="active"
                                               @checked(old('status', 'active') === 'active')>

                                        <label for="status_active">

                                            <div class="status-option-title">
                                                Active
                                            </div>

                                            <div class="status-option-description">
                                                Current tenant
                                            </div>

                                        </label>

                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="status-option">

                                        <input type="radio"
                                               name="status"
                                               id="status_inactive"
                                               value="inactive"
                                               @checked(old('status') === 'inactive')>

                                        <label for="status_inactive">

                                            <div class="status-option-title">
                                                Inactive
                                            </div>

                                            <div class="status-option-description">
                                                Not currently active
                                            </div>

                                        </label>

                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="status-option">

                                        <input type="radio"
                                               name="status"
                                               id="status_blacklisted"
                                               value="blacklisted"
                                               @checked(old('status') === 'blacklisted')>

                                        <label for="status_blacklisted">

                                            <div class="status-option-title">
                                                Blacklisted
                                            </div>

                                            <div class="status-option-description">
                                                Restricted tenant
                                            </div>

                                        </label>

                                    </div>
                                </div>

                            </div>

                            @error('status')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Notes --}}
                        <div class="col-12">

                            <label class="field-label">
                                Internal Notes
                            </label>

                            <textarea name="notes"
                                      rows="4"
                                      class="form-control @error('notes') is-invalid @enderror"
                                      placeholder="Add any relevant internal notes about this tenant...">{{ old('notes') }}</textarea>

                            @error('notes')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="field-help">
                                These notes are for property management use and are not displayed publicly.
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- FORM ACTIONS --}}
            <div class="form-actions">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <div class="required-note">
                        <span class="required">*</span>
                        Required fields
                    </div>

                    <div class="d-flex gap-2">

                        <a href="{{ route('property-management.tenants.index') }}"
                           class="btn btn-cancel">
                            Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-register">

                            <i class="bi bi-person-plus me-1"></i>
                            Register Tenant

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection