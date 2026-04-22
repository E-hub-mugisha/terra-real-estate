@extends('layouts.app')
@section('title', 'Edit Job Listing')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;400;500;600&display=swap');

    :root {
        --clr-bg: #F7F5F2;
        --clr-surface: #FFFFFF;
        --clr-border: #E8E3DC;
        --clr-text: #19265d;
        --clr-muted: #7A736B;
        --clr-accent: #D05208;
        --clr-job: #1a5276;
        --clr-job-light: #EBF5FB;
        --clr-success: #1a7a4a;
        --clr-warning: #b45309;
        --radius-card: 14px;
        --shadow-card: 0 2px 12px rgba(0,0,0,.07);
        --transition: .22s cubic-bezier(.4,0,.2,1);
    }

    body { background: var(--clr-bg); font-family: 'DM Sans', sans-serif; }

    /* ── Page header ── */
    .page-header {
        background: var(--clr-surface);
        border-bottom: 1px solid var(--clr-border);
        padding: 30px 0 28px;
    }

    .page-header h1 {
        font-family: 'DM Serif Display', serif;
        font-size: clamp(1.5rem, 3vw, 2rem);
        color: var(--clr-text);
        font-weight: 400;
        margin-bottom: 6px;
    }

    .page-header p { color: var(--clr-muted); font-size: .88rem; }

    /* ── Status badge ── */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .status-badge.pending   { background: #FEF3E2; color: var(--clr-warning); border: 1px solid #F6D09A; }
    .status-badge.active    { background: #D1FAE5; color: var(--clr-success); border: 1px solid #6EE7B7; }
    .status-badge.expired   { background: #F3F4F6; color: var(--clr-muted);   border: 1px solid var(--clr-border); }
    .status-badge.rejected  { background: #FEE2E2; color: #b91c1c;            border: 1px solid #FCA5A5; }

    /* ── Alert banner ── */
    .edit-notice {
        background: var(--clr-job-light);
        border: 1px solid #9ecae9;
        border-radius: 10px;
        padding: 14px 18px;
        font-size: .82rem;
        color: var(--clr-job);
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .edit-notice .notice-icon { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }

    /* ── Steps indicator ── */
    .steps { display: flex; gap: 0; margin-bottom: 32px; }

    .step {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .8rem;
        font-weight: 600;
        color: var(--clr-muted);
        padding-right: 24px;
        position: relative;
    }

    .step::after { content: '→'; position: absolute; right: 8px; color: var(--clr-border); }
    .step:last-child::after { display: none; }
    .step.active { color: var(--clr-accent); }
    .step.done   { color: var(--clr-job); }

    .step-num {
        width: 24px; height: 24px;
        border-radius: 50%;
        background: var(--clr-border);
        display: flex; align-items: center; justify-content: center;
        font-size: .72rem; font-weight: 700;
        flex-shrink: 0;
    }

    .step.active .step-num { background: var(--clr-accent); color: #fff; }
    .step.done   .step-num { background: var(--clr-job);    color: #fff; }

    /* ── Cards ── */
    .form-card {
        background: var(--clr-surface);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-card);
        box-shadow: var(--shadow-card);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .form-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--clr-border);
        background: var(--clr-bg);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .form-card-header h2 { font-size: .92rem; font-weight: 700; color: var(--clr-text); margin: 0; }
    .form-card-body { padding: 24px; }

    /* ── Form controls ── */
    .form-label { font-size: .82rem; font-weight: 600; color: var(--clr-text); margin-bottom: 6px; }

    .form-control,
    .form-select {
        border: 1.5px solid var(--clr-border);
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: .88rem;
        color: var(--clr-text);
        background: var(--clr-bg);
        transition: border-color var(--transition), background var(--transition);
        padding: 9px 12px;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--clr-accent);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(208,82,8,.08);
    }

    .form-control:disabled,
    .form-select:disabled {
        opacity: .55;
        cursor: not-allowed;
        background: #EDEBE8;
    }

    textarea.form-control { resize: vertical; min-height: 120px; }
    .form-text { font-size: .75rem; color: var(--clr-muted); margin-top: 4px; }

    /* ── Logo preview ── */
    .logo-preview-wrap {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 10px;
    }

    .logo-preview-img {
        width: 64px; height: 64px;
        border-radius: 10px;
        object-fit: cover;
        border: 1.5px solid var(--clr-border);
        background: var(--clr-bg);
    }

    .logo-preview-info { font-size: .78rem; color: var(--clr-muted); }
    .logo-preview-info strong { display: block; color: var(--clr-text); font-size: .82rem; margin-bottom: 3px; }

    /* ── Package selector ── */
    .package-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px; }
    .package-option { display: none; }

    .package-label {
        display: block;
        border: 2px solid var(--clr-border);
        border-radius: 10px;
        padding: 16px;
        cursor: pointer;
        transition: all var(--transition);
        background: var(--clr-bg);
    }

    .package-label:hover                    { border-color: var(--clr-accent); }
    .package-option:checked + .package-label { border-color: var(--clr-accent); background: #FEF3E2; }

    .package-label.locked { cursor: not-allowed; opacity: .65; }
    .package-label.locked:hover { border-color: var(--clr-border); }

    .pkg-tier {
        font-size: .7rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .08em;
        color: var(--clr-muted); margin-bottom: 4px;
    }

    .pkg-price { font-size: 1.1rem; font-weight: 700; color: var(--clr-text); margin-bottom: 8px; }
    .pkg-price span { font-size: .72rem; font-weight: 500; color: var(--clr-muted); }

    .pkg-features { list-style: none; padding: 0; margin: 0; }
    .pkg-features li {
        font-size: .75rem; color: var(--clr-muted);
        padding: 3px 0; display: flex; align-items: flex-start; gap: 5px;
    }
    .pkg-features li::before { content: '✓'; color: var(--clr-job); font-weight: 700; flex-shrink: 0; }

    /* ── Days input ── */
    .days-wrap { display: flex; align-items: center; gap: 12px; }
    .days-wrap input[type=number] { width: 100px; text-align: center; }
    .days-quick { display: flex; gap: 6px; flex-wrap: wrap; }

    .days-pill {
        padding: 5px 12px;
        border-radius: 20px;
        border: 1.5px solid var(--clr-border);
        background: transparent;
        font-size: .78rem; font-weight: 600;
        color: var(--clr-muted);
        cursor: pointer;
        transition: all var(--transition);
    }

    .days-pill:hover,
    .days-pill.active { border-color: var(--clr-accent); background: #FEF3E2; color: var(--clr-accent); }
    .days-pill:disabled { opacity: .5; cursor: not-allowed; }

    /* ── Price preview ── */
    .price-preview { background: var(--clr-text); border-radius: 12px; padding: 20px; color: #fff; }
    .price-preview h3 {
        font-size: .75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .1em;
        color: rgba(255,255,255,.4); margin-bottom: 16px;
    }

    .preview-row {
        display: flex; justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255,255,255,.08);
        font-size: .82rem;
    }

    .preview-row:last-child { border-bottom: none; }
    .preview-row .label  { color: rgba(255,255,255,.5); }
    .preview-row .value  { font-weight: 700; color: #fff; }
    .preview-row.total .value { color: #FFD166; font-size: 1rem; }

    .preview-placeholder { text-align: center; padding: 20px; color: rgba(255,255,255,.3); font-size: .82rem; }

    /* ── Locked-package notice ── */
    .package-locked-notice {
        background: #FEF3E2;
        border: 1px solid #F6D09A;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: .78rem;
        color: var(--clr-warning);
        margin-top: 12px;
        display: flex;
        gap: 8px;
        align-items: flex-start;
    }

    /* ── Submit area ── */
    .submit-btn {
        padding: 12px 32px;
        background: var(--clr-accent);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: .92rem; font-weight: 700;
        cursor: pointer;
        transition: background var(--transition), transform var(--transition);
    }

    .submit-btn:hover { background: #A06828; transform: translateY(-1px); }

    /* ── Danger zone ── */
    .danger-zone {
        border: 1.5px solid #FCA5A5;
        border-radius: var(--radius-card);
        padding: 20px 24px;
        background: #FFF5F5;
        margin-top: 8px;
    }

    .danger-zone h4 { font-size: .88rem; font-weight: 700; color: #b91c1c; margin-bottom: 6px; }
    .danger-zone p  { font-size: .78rem; color: #b91c1c; margin-bottom: 14px; opacity: .8; }

    .btn-danger-outline {
        padding: 9px 20px;
        border: 1.5px solid #b91c1c;
        background: transparent;
        color: #b91c1c;
        border-radius: 8px;
        font-size: .82rem; font-weight: 700;
        cursor: pointer;
        transition: all var(--transition);
        font-family: 'DM Sans', sans-serif;
    }

    .btn-danger-outline:hover { background: #b91c1c; color: #fff; }
</style>

@section('content')

<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <div class="d-flex align-items-center gap-3 mb-1">
                    <h1 class="mb-0">Edit Job Listing</h1>
                    @php
                        $badgeClass = match($job->status) {
                            'active'          => 'active',
                            'pending_payment' => 'pending',
                            'expired'         => 'expired',
                            'rejected'        => 'rejected',
                            default           => 'pending',
                        };
                        $badgeLabel = match($job->status) {
                            'active'          => '● Active',
                            'pending_payment' => '◌ Pending Payment',
                            'expired'         => '○ Expired',
                            'rejected'        => '✕ Rejected',
                            default           => ucfirst($job->status),
                        };
                    @endphp
                    <span class="status-badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                </div>
                <p class="mb-0">{{ $job->title }} &mdash; posted {{ $job->created_at->diffForHumans() }}</p>
            </div>
            <a href="{{ route('admin.job-listings.index') }}"
               style="font-size:.82rem;color:var(--clr-muted);text-decoration:none">
                ← All Listings
            </a>
        </div>
    </div>
</div>

<div class="container py-5">

    {{-- Steps indicator (visual only on edit) --}}
    <div class="steps mb-4">
        <div class="step done"><span class="step-num">✓</span> Job Details</div>
        <div class="step {{ in_array($job->status, ['active','expired','rejected']) ? 'done' : 'active' }}">
            <span class="step-num">{{ in_array($job->status, ['active','expired','rejected']) ? '✓' : '2' }}</span>
            Choose Package
        </div>
        <div class="step {{ in_array($job->status, ['active','expired','rejected']) ? 'done' : '' }}">
            <span class="step-num">{{ in_array($job->status, ['active','expired','rejected']) ? '✓' : '3' }}</span>
            Payment
        </div>
        <div class="step {{ $job->status === 'active' ? 'done' : '' }}">
            <span class="step-num">{{ $job->status === 'active' ? '✓' : '4' }}</span>
            Live
        </div>
    </div>

    {{-- Edit notice --}}
    @if($job->status === 'active')
    <div class="edit-notice">
        <span class="notice-icon">ℹ️</span>
        <div>
            <strong style="font-weight:700">This listing is currently live.</strong>
            Changes to job details will be applied immediately. Package and billing cannot be changed for active listings.
        </div>
    </div>
    @elseif($job->payment_status === 'paid')
    <div class="edit-notice">
        <span class="notice-icon">💳</span>
        <div>
            <strong style="font-weight:700">Payment has already been made.</strong>
            You may update job details freely. Package and days cannot be changed after payment.
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif

    <form method="POST"
          action="{{ route('admin.job-listings.update', $job) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @php $packageLocked = $job->payment_status === 'paid' || $job->status === 'active'; @endphp

        <div class="row g-4">

            {{-- ── LEFT COLUMN ── --}}
            <div class="col-lg-8">

                {{-- Company Info --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <h2>🏢 Company Information</h2>
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control"
                                       value="{{ old('company_name', $job->company_name) }}"
                                       placeholder="e.g. Kigali Tech Ltd" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Company Email <span class="text-danger">*</span></label>
                                <input type="email" name="company_email" class="form-control"
                                       value="{{ old('company_email', $job->company_email) }}"
                                       placeholder="hr@company.com" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="company_phone" class="form-control"
                                       value="{{ old('company_phone', $job->company_phone) }}"
                                       placeholder="+250 7xx xxx xxx">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Website</label>
                                <input type="url" name="company_website" class="form-control"
                                       value="{{ old('company_website', $job->company_website) }}"
                                       placeholder="https://yourcompany.com">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Company Logo</label>

                                {{-- Existing logo preview --}}
                                @if($job->company_logo)
                                <div class="logo-preview-wrap">
                                    <img src="{{asset('image/jobs/company_logos/')}}/{{ $job->company_logo }}"
                                         alt="Current logo"
                                         class="logo-preview-img">
                                    <div class="logo-preview-info">
                                        <strong>Current logo</strong>
                                        Upload a new file below to replace it.
                                    </div>
                                </div>
                                @endif

                                <input type="file" name="company_logo" class="form-control" accept="image/*">
                                <div class="form-text">JPG, PNG or WebP. Max 2 MB. Leave blank to keep existing logo.</div>

                                {{-- Remove existing logo checkbox --}}
                                @if($job->company_logo)
                                <div class="form-check mt-2">
                                    <input type="hidden" name="remove_logo" value="0">
                                    <input class="form-check-input" type="checkbox"
                                           name="remove_logo" value="1" id="remove_logo">
                                    <label class="form-check-label" for="remove_logo"
                                           style="font-size:.78rem;color:#b91c1c">
                                        Remove current logo
                                    </label>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Job Details --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <h2>💼 Job Details</h2>
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">

                            <div class="col-12">
                                <label class="form-label">Job Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                       value="{{ old('title', $job->title) }}"
                                       placeholder="e.g. Senior Software Engineer" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Job Type <span class="text-danger">*</span></label>
                                <select name="job_type" class="form-select" required>
                                    <option value="">— Select —</option>
                                    @foreach(['full-time','part-time','contract','internship','remote'] as $type)
                                    <option value="{{ $type }}"
                                        {{ old('job_type', $job->job_type) === $type ? 'selected' : '' }}>
                                        {{ Str::title(str_replace('-', ' ', $type)) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <input type="text" name="category" class="form-control"
                                       value="{{ old('category', $job->category) }}"
                                       placeholder="e.g. Technology, Finance, Health">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location" class="form-control"
                                       value="{{ old('location', $job->location) }}"
                                       placeholder="e.g. Kigali, Rwanda" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Job Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control" rows="6"
                                          placeholder="Describe the role, responsibilities…" required>{{ old('description', $job->description) }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Requirements</label>
                                <textarea name="requirements" id="requirements" class="form-control" rows="5"
                                          placeholder="List qualifications, education, skills…">{{ old('requirements', $job->requirements) }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Benefits</label>
                                <textarea name="benefits" id="benefits" class="form-control" rows="4"
                                          placeholder="Health insurance, bonus, remote work…">{{ old('benefits', $job->benefits) }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Salary & Application --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <h2>💰 Salary & Application</h2>
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">

                            <div class="col-md-5">
                                <label class="form-label">Min Salary (RWF)</label>
                                <input type="number" name="salary_min" class="form-control"
                                       value="{{ old('salary_min', $job->salary_min) }}"
                                       placeholder="200000">
                            </div>

                            <div class="col-md-5">
                                <label class="form-label">Max Salary (RWF)</label>
                                <input type="number" name="salary_max" class="form-control"
                                       value="{{ old('salary_max', $job->salary_max) }}"
                                       placeholder="500000">
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <div class="form-check mb-2">
                                    <input type="hidden" name="show_salary" value="0">
                                    <input class="form-check-input" type="checkbox"
                                           name="show_salary" value="1" id="show_salary"
                                           {{ old('show_salary', $job->show_salary) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_salary"
                                           style="font-size:.8rem">Show</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Application Email <span class="text-danger">*</span></label>
                                <input type="email" name="application_email" class="form-control"
                                       value="{{ old('application_email', $job->application_email) }}"
                                       placeholder="apply@company.com" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Application URL</label>
                                <input type="url" name="application_url" class="form-control"
                                       value="{{ old('application_url', $job->application_url) }}"
                                       placeholder="https://apply.company.com/job">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Application Deadline</label>
                                <input type="date" name="application_deadline" class="form-control"
                                       value="{{ old('application_deadline', optional($job->application_deadline)->format('Y-m-d')) }}"
                                       min="{{ now()->addDay()->format('Y-m-d') }}">
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Package Selection --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <h2>📦 Package & Duration</h2>
                        @if($packageLocked)
                        <span style="font-size:.72rem;color:var(--clr-muted);font-weight:600">🔒 Locked after payment</span>
                        @endif
                    </div>
                    <div class="form-card-body">

                        @if($packages->isEmpty())
                            <p class="text-muted" style="font-size:.85rem">No active job packages available.</p>
                        @else
                            <div class="package-grid mb-4">
                                @foreach($packages as $pkg)
                                <div>
                                    <input type="radio"
                                           name="listing_package_id"
                                           id="pkg_{{ $pkg->id }}"
                                           value="{{ $pkg->id }}"
                                           class="package-option"
                                           {{ old('listing_package_id', $job->listing_package_id) == $pkg->id ? 'checked' : '' }}
                                           data-price="{{ $pkg->price_per_day }}"
                                           data-tier="{{ $pkg->tier_label }}"
                                           {{ $packageLocked ? 'disabled' : '' }}>
                                    <label for="pkg_{{ $pkg->id }}"
                                           class="package-label {{ $packageLocked ? 'locked' : '' }}">
                                        <div class="pkg-tier">{{ $pkg->tier_label }}</div>
                                        <div class="pkg-price">
                                            {{ number_format($pkg->price_per_day) }} <span>RWF/day</span>
                                        </div>
                                        @php
                                            $features = is_array($pkg->features)
                                                ? $pkg->features
                                                : json_decode($pkg->features, true);
                                        @endphp
                                        @if($features)
                                        <ul class="pkg-features">
                                            @foreach(array_slice($features, 0, 4) as $feature)
                                            <li>{{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            {{-- Hidden inputs to keep values when locked --}}
                            @if($packageLocked)
                            <input type="hidden" name="listing_package_id" value="{{ $job->listing_package_id }}">
                            <input type="hidden" name="days_purchased"     value="{{ $job->days_purchased }}">
                            @endif

                            {{-- Days selection --}}
                            <div class="mb-3">
                                <label class="form-label">Number of Days <span class="text-danger">*</span></label>
                                <div class="days-wrap mb-2">
                                    <input type="number"
                                           name="{{ $packageLocked ? '_days_display' : 'days_purchased' }}"
                                           id="days_purchased"
                                           class="form-control"
                                           value="{{ old('days_purchased', $job->days_purchased) }}"
                                           min="1" max="365"
                                           {{ $packageLocked ? 'disabled' : 'required' }}>
                                    <div class="days-quick">
                                        @foreach([7, 14, 30, 60, 90] as $d)
                                        <button type="button" class="days-pill"
                                                data-days="{{ $d }}"
                                                {{ $packageLocked ? 'disabled' : '' }}>
                                            {{ $d }} days
                                        </button>
                                        @endforeach
                                    </div>
                                </div>

                                @if($packageLocked)
                                <div class="package-locked-notice">
                                    ⚠️ Package and duration are locked because payment has been processed. To change these, please contact support.
                                </div>
                                @else
                                <div class="form-text">Listing will go live after payment and expire after the chosen duration.</div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="d-flex gap-3 align-items-center flex-wrap">
                    <button type="submit" class="submit-btn">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.job-listings.show', $job) }}"
                       style="font-size:.82rem;color:var(--clr-muted);text-decoration:none">
                        Cancel
                    </a>
                    @if($job->status === 'pending_payment' && $job->payment_status !== 'paid')
                    <a href="{{ route('admin.job-listings.payment', $job) }}"
                       class="submit-btn ms-auto"
                       style="background:var(--clr-job);text-decoration:none;display:inline-flex;align-items:center;gap:6px">
                        Go to Payment →
                    </a>
                    @endif
                </div>

                {{-- Danger zone --}}
                @can('delete', $job)
                <div class="danger-zone mt-5">
                    <h4>⚠️ Danger Zone</h4>
                    <p>Permanently delete this job listing. This action cannot be undone.</p>
                    <form method="POST"
                          action="{{ route('admin.job-listings.destroy', $job) }}"
                          onsubmit="return confirm('Delete this listing permanently? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-outline">
                            Delete Listing
                        </button>
                    </form>
                </div>
                @endcan

            </div>

            {{-- ── RIGHT — Price Preview ── --}}
            <div class="col-lg-4">
                <div style="position:sticky;top:80px">

                    {{-- Billing summary (when package is locked / paid) --}}
                    @if($packageLocked)
                    <div class="price-preview" style="margin-bottom:16px">
                        <h3>Billing Summary</h3>
                        <div class="preview-row">
                            <span class="label">Package</span>
                            <span class="value">{{ optional($job->listingPackage)->tier_label ?? '—' }}</span>
                        </div>
                        <div class="preview-row">
                            <span class="label">Price / Day</span>
                            <span class="value">{{ number_format(optional($job->listingPackage)->price_per_day ?? 0) }} RWF</span>
                        </div>
                        <div class="preview-row">
                            <span class="label">Duration</span>
                            <span class="value">{{ $job->days_purchased }} day{{ $job->days_purchased === 1 ? '' : 's' }}</span>
                        </div>
                        <div class="preview-row total">
                            <span class="label">Total</span>
                            <span class="value">{{ number_format($job->total_amount) }} RWF</span>
                        </div>
                        <div class="preview-row">
                            <span class="label">Payment Status</span>
                            <span class="value" style="color:{{ $job->payment_status === 'paid' ? '#6EE7B7' : '#FFD166' }}">
                                {{ Str::title($job->payment_status) }}
                            </span>
                        </div>
                        @if($job->expires_at)
                        <div class="preview-row">
                            <span class="label">Expires</span>
                            <span class="value" style="font-size:.78rem">{{ $job->expires_at->format('d M Y') }}</span>
                        </div>
                        @endif
                    </div>
                    @else
                    {{-- Interactive price preview for pending listings --}}
                    <div class="price-preview" style="margin-bottom:16px">
                        <h3>Price Preview</h3>
                        <div id="preview-content">
                            <div class="preview-placeholder">
                                Select a package and days above to see pricing.
                            </div>
                        </div>
                    </div>
                    @endif

                    <div style="padding:14px;border:1px solid var(--clr-border);border-radius:10px;background:var(--clr-surface)">
                        <p style="font-size:.78rem;color:var(--clr-muted);margin:0;line-height:1.6">
                            🔒 Your listing only goes live after payment is confirmed. We accept MTN MoMo and bank transfer.
                        </p>
                    </div>

                    {{-- Listing meta info --}}
                    <div style="margin-top:16px;padding:14px;border:1px solid var(--clr-border);border-radius:10px;background:var(--clr-surface)">
                        <p style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--clr-muted);margin-bottom:10px">Listing Info</p>
                        <div style="display:flex;flex-direction:column;gap:7px">
                            <div style="display:flex;justify-content:space-between;font-size:.78rem">
                                <span style="color:var(--clr-muted)">ID</span>
                                <span style="font-weight:700;color:var(--clr-text)">#{{ $job->id }}</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:.78rem">
                                <span style="color:var(--clr-muted)">Created</span>
                                <span style="font-weight:600;color:var(--clr-text)">{{ $job->created_at->format('d M Y') }}</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:.78rem">
                                <span style="color:var(--clr-muted)">Last edited</span>
                                <span style="font-weight:600;color:var(--clr-text)">{{ $job->updated_at->diffForHumans() }}</span>
                            </div>
                            @if($job->user)
                            <div style="display:flex;justify-content:space-between;font-size:.78rem">
                                <span style="color:var(--clr-muted)">Posted by</span>
                                <span style="font-weight:600;color:var(--clr-text)">{{ $job->user->name }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </form>
</div>

<script>

    $(document).ready(function () {
        $('#description, #requirements, #benefits').summernote({
            height: 250,
            placeholder: 'Write job description here...',
            toolbar: [
                ['style',  ['bold', 'italic', 'underline', 'clear']],
                ['para',   ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view',   ['fullscreen', 'codeview']],
            ]
        });
    });

(function () {
    const packageLocked = {{ $packageLocked ? 'true' : 'false' }};

    if (packageLocked) return; // Nothing interactive to do

    const pkgInputs  = document.querySelectorAll('.package-option');
    const daysInput  = document.getElementById('days_purchased');
    const daysPills  = document.querySelectorAll('.days-pill');
    const previewEl  = document.getElementById('preview-content');

    function fmt(n) { return Number(n).toLocaleString(); }

    function updatePreview() {
        const pkg  = document.querySelector('.package-option:checked');
        const days = parseInt(daysInput.value) || 0;

        if (!pkg || days < 1) {
            previewEl.innerHTML = '<div class="preview-placeholder">Select a package and days above.</div>';
            return;
        }

        const pricePerDay = parseInt(pkg.dataset.price);
        const total       = pricePerDay * days;
        const tier        = pkg.dataset.tier;

        previewEl.innerHTML = `
            <div class="preview-row">
                <span class="label">Package</span>
                <span class="value">${tier}</span>
            </div>
            <div class="preview-row">
                <span class="label">Price / Day</span>
                <span class="value">${fmt(pricePerDay)} RWF</span>
            </div>
            <div class="preview-row">
                <span class="label">Duration</span>
                <span class="value">${days} day${days === 1 ? '' : 's'}</span>
            </div>
            <div class="preview-row total">
                <span class="label">Total</span>
                <span class="value">${fmt(total)} RWF</span>
            </div>
        `;
    }

    pkgInputs.forEach(i => i.addEventListener('change', updatePreview));
    daysInput.addEventListener('input', updatePreview);

    daysPills.forEach(pill => {
        pill.addEventListener('click', () => {
            daysPills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            daysInput.value = pill.dataset.days;
            updatePreview();
        });
    });

    // Highlight matching pill on load
    daysPills.forEach(p => {
        if (p.dataset.days === daysInput.value) p.classList.add('active');
    });

    updatePreview();
})();
</script>

@endsection