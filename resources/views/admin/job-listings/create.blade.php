@extends('layouts.app')
@section('title', 'Post a Job')

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
        --radius-card: 14px;
        --shadow-card: 0 2px 12px rgba(0, 0, 0, .07);
        --transition: .22s cubic-bezier(.4, 0, .2, 1);
    }

    body {
        background: var(--clr-bg);
        font-family: 'DM Sans', sans-serif;
    }

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

    .page-header p {
        color: var(--clr-muted);
        font-size: .88rem;
    }

    /* ── Steps indicator ── */
    .steps {
        display: flex;
        gap: 0;
        margin-bottom: 32px;
    }

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

    .step::after {
        content: '→';
        position: absolute;
        right: 8px;
        color: var(--clr-border);
    }

    .step:last-child::after {
        display: none;
    }

    .step.active {
        color: var(--clr-accent);
    }

    .step.done {
        color: var(--clr-job);
    }

    .step-num {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: var(--clr-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .72rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .step.active .step-num {
        background: var(--clr-accent);
        color: #fff;
    }

    .step.done .step-num {
        background: var(--clr-job);
        color: #fff;
    }

    /* ── Card ── */
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
    }

    .form-card-header h2 {
        font-size: .92rem;
        font-weight: 700;
        color: var(--clr-text);
        margin: 0;
    }

    .form-card-body {
        padding: 24px;
    }

    .form-label {
        font-size: .82rem;
        font-weight: 600;
        color: var(--clr-text);
        margin-bottom: 6px;
    }

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
        box-shadow: 0 0 0 3px rgba(208, 82, 8, .08);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    /* ── Package selector ── */
    .package-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
    }

    .package-option {
        display: none;
    }

    .package-label {
        display: block;
        border: 2px solid var(--clr-border);
        border-radius: 10px;
        padding: 16px;
        cursor: pointer;
        transition: all var(--transition);
        background: var(--clr-bg);
    }

    .package-label:hover {
        border-color: var(--clr-accent);
    }

    .package-option:checked+.package-label {
        border-color: var(--clr-accent);
        background: #FEF3E2;
    }

    .pkg-tier {
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--clr-muted);
        margin-bottom: 4px;
    }

    .pkg-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--clr-text);
        margin-bottom: 8px;
    }

    .pkg-price span {
        font-size: .72rem;
        font-weight: 500;
        color: var(--clr-muted);
    }

    .pkg-features {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pkg-features li {
        font-size: .75rem;
        color: var(--clr-muted);
        padding: 3px 0;
        display: flex;
        align-items: flex-start;
        gap: 5px;
    }

    .pkg-features li::before {
        content: '✓';
        color: var(--clr-job);
        font-weight: 700;
        flex-shrink: 0;
    }

    /* ── Days input ── */
    .days-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .days-wrap input[type=number] {
        width: 100px;
        text-align: center;
    }

    .days-quick {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .days-pill {
        padding: 5px 12px;
        border-radius: 20px;
        border: 1.5px solid var(--clr-border);
        background: transparent;
        font-size: .78rem;
        font-weight: 600;
        color: var(--clr-muted);
        cursor: pointer;
        transition: all var(--transition);
    }

    .days-pill:hover,
    .days-pill.active {
        border-color: var(--clr-accent);
        background: #FEF3E2;
        color: var(--clr-accent);
    }

    /* ── Price preview ── */
    .price-preview {
        background: var(--clr-text);
        border-radius: 12px;
        padding: 20px;
        color: #fff;
    }

    .price-preview h3 {
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: rgba(255, 255, 255, .4);
        margin-bottom: 16px;
    }

    .preview-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255, 255, 255, .08);
        font-size: .82rem;
    }

    .preview-row:last-child {
        border-bottom: none;
    }

    .preview-row .label {
        color: rgba(255, 255, 255, .5);
    }

    .preview-row .value {
        font-weight: 700;
        color: #fff;
    }

    .preview-row.total .value {
        color: #FFD166;
        font-size: 1rem;
    }

    .preview-placeholder {
        text-align: center;
        padding: 20px;
        color: rgba(255, 255, 255, .3);
        font-size: .82rem;
    }

    /* ── Submit ── */
    .submit-btn {
        padding: 12px 32px;
        background: var(--clr-accent);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: .92rem;
        font-weight: 700;
        cursor: pointer;
        transition: background var(--transition), transform var(--transition);
    }

    .submit-btn:hover {
        background: #A06828;
        transform: translateY(-1px);
    }

    .form-text {
        font-size: .75rem;
        color: var(--clr-muted);
        margin-top: 4px;
    }
</style>

@section('content')

<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h1>Post a Job</h1>
                <p>Reach thousands of qualified candidates across Rwanda</p>
            </div>
            <a href="{{ route('admin.job-listings.index') }}" style="font-size:.82rem;color:var(--clr-muted);text-decoration:none">
                ← Browse Jobs
            </a>
        </div>
    </div>
</div>

<div class="container py-5">

    {{-- Steps --}}
    <div class="steps mb-4">
        <div class="step active"><span class="step-num">1</span> Job Details</div>
        <div class="step"><span class="step-num">2</span> Choose Package</div>
        <div class="step"><span class="step-num">3</span> Payment</div>
        <div class="step"><span class="step-num">4</span> Live</div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.job-listings.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            {{-- LEFT COLUMN ── --}}
            <div class="col-lg-8">

                {{-- Company Info ── --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <h2>🏢 Company Information</h2>
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control"
                                    value="{{ old('company_name') }}" placeholder="e.g. Kigali Tech Ltd" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Company Email <span class="text-danger">*</span></label>
                                <input type="email" name="company_email" class="form-control"
                                    value="{{ old('company_email') }}" placeholder="hr@company.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="company_phone" class="form-control"
                                    value="{{ old('company_phone') }}" placeholder="+250 7xx xxx xxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Website</label>
                                <input type="url" name="company_website" class="form-control"
                                    value="{{ old('company_website') }}" placeholder="https://yourcompany.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Company Logo</label>
                                <input type="file" name="company_logo" class="form-control" accept="image/*">
                                <div class="form-text">JPG, PNG or WebP. Max 2MB.</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Job Details ── --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <h2>💼 Job Details</h2>
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Job Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title') }}" placeholder="e.g. Senior Software Engineer" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Job Type <span class="text-danger">*</span></label>
                                <select name="job_type" class="form-select" required>
                                    <option value="">— Select —</option>
                                    <option value="full-time" {{ old('job_type') === 'full-time'  ? 'selected' : '' }}>Full Time</option>
                                    <option value="part-time" {{ old('job_type') === 'part-time'  ? 'selected' : '' }}>Part Time</option>
                                    <option value="contract" {{ old('job_type') === 'contract'   ? 'selected' : '' }}>Contract</option>
                                    <option value="internship" {{ old('job_type') === 'internship' ? 'selected' : '' }}>Internship</option>
                                    <option value="remote" {{ old('job_type') === 'remote'     ? 'selected' : '' }}>Remote</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <input type="text" name="category" class="form-control"
                                    value="{{ old('category') }}" placeholder="e.g. Technology, Finance, Health">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location" class="form-control"
                                    value="{{ old('location') }}" placeholder="e.g. Kigali, Rwanda" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Job Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control" rows="6"
                                    placeholder="Describe the role, responsibilities, and what the candidate will do…" required>{{ old('description') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Requirements</label>
                                <textarea name="requirements" id="requirements" class="form-control" rows="5"
                                    placeholder="List qualifications, education, experience, skills…">{{ old('requirements') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Benefits</label>
                                <textarea name="benefits" id="benefits" class="form-control" rows="4"
                                    placeholder="Health insurance, performance bonus, remote work…">{{ old('benefits') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Salary & Application ── --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <h2>💰 Salary & Application</h2>
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label">Min Salary (RWF)</label>
                                <input type="number" name="salary_min" class="form-control"
                                    value="{{ old('salary_min') }}" placeholder="200000">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Max Salary (RWF)</label>
                                <input type="number" name="salary_max" class="form-control"
                                    value="{{ old('salary_max') }}" placeholder="500000">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="form-check mb-2">
                                    <input type="hidden" name="show_salary" value="0">
                                    <input class="form-check-input" type="checkbox" name="show_salary" value="1"
                                        id="show_salary" {{ old('show_salary', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_salary" style="font-size:.8rem">Show</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Application Email <span class="text-danger">*</span></label>
                                <input type="email" name="application_email" class="form-control"
                                    value="{{ old('application_email') }}" placeholder="apply@company.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Application URL</label>
                                <input type="url" name="application_url" class="form-control"
                                    value="{{ old('application_url') }}" placeholder="https://apply.company.com/job">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Application Deadline</label>
                                <input type="date" name="application_deadline" class="form-control"
                                    value="{{ old('application_deadline') }}"
                                    min="{{ now()->addDay()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Package Selection ── --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <h2>📦 Choose a Package</h2>
                    </div>
                    <div class="form-card-body">
                        @if($packages->isEmpty())
                        <p class="text-muted" style="font-size:.85rem">No active job packages available. Please contact us.</p>
                        @else
                        <div class="package-grid mb-4">
                            @foreach($packages as $pkg)
                            <div>
                                <input type="radio" name="listing_package_id" id="pkg_{{ $pkg->id }}"
                                    value="{{ $pkg->id }}" class="package-option"
                                    {{ old('listing_package_id') == $pkg->id ? 'checked' : '' }}
                                    data-price="{{ $pkg->price_per_day }}"
                                    data-tier="{{ $pkg->tier_label }}">
                                <label for="pkg_{{ $pkg->id }}" class="package-label">
                                    <div class="pkg-tier">{{ $pkg->tier_label }}</div>
                                    <div class="pkg-price">
                                        {{ number_format($pkg->price_per_day) }} <span>RWF/day</span>
                                    </div>
                                    @php
                                    $features = is_array($pkg->features) ? $pkg->features : json_decode($pkg->features, true);
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

                        {{-- Days selection ── --}}
                        <div class="mb-3">
                            <label class="form-label">Number of Days <span class="text-danger">*</span></label>
                            <div class="days-wrap mb-2">
                                <input type="number" name="days_purchased" id="days_purchased"
                                    class="form-control" value="{{ old('days_purchased', 7) }}"
                                    min="1" max="365" required>
                                <div class="days-quick">
                                    <button type="button" class="days-pill" data-days="7">7 days</button>
                                    <button type="button" class="days-pill" data-days="14">14 days</button>
                                    <button type="button" class="days-pill" data-days="30">30 days</button>
                                    <button type="button" class="days-pill" data-days="60">60 days</button>
                                    <button type="button" class="days-pill" data-days="90">90 days</button>
                                </div>
                            </div>
                            <div class="form-text">Your listing will go live immediately after payment and expire after the chosen number of days.</div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Submit ── --}}
                <div class="d-flex gap-3 align-items-center">
                    <button type="submit" class="submit-btn">
                        Continue to Payment →
                    </button>
                    <a href="{{ route('front.jobs.index') }}" style="font-size:.82rem;color:var(--clr-muted);text-decoration:none">
                        Cancel
                    </a>
                </div>

            </div>

            {{-- RIGHT — Price Preview ── --}}
            <div class="col-lg-4">
                <div style="position:sticky;top:80px">
                    <div class="price-preview">
                        <h3>Price Preview</h3>
                        <div id="preview-content">
                            <div class="preview-placeholder">
                                Select a package and enter number of days to see pricing.
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:16px;padding:14px;border:1px solid var(--clr-border);border-radius:10px;background:var(--clr-surface)">
                        <p style="font-size:.78rem;color:var(--clr-muted);margin:0;line-height:1.6">
                            🔒 Your listing will only go live after payment is confirmed. We accept MTN MoMo and bank transfer.
                        </p>
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

    (function() {
        const pkgInputs = document.querySelectorAll('.package-option');
        const daysInput = document.getElementById('days_purchased');
        const daysPills = document.querySelectorAll('.days-pill');
        const previewEl = document.getElementById('preview-content');

        function fmt(n) {
            return Number(n).toLocaleString();
        }

        function updatePreview() {
            const pkg = document.querySelector('.package-option:checked');
            const days = parseInt(daysInput.value) || 0;

            if (!pkg || days < 1) {
                previewEl.innerHTML = '<div class="preview-placeholder">Select a package and days above.</div>';
                return;
            }

            const pricePerDay = parseInt(pkg.dataset.price);
            const total = pricePerDay * days;
            const tier = pkg.dataset.tier;

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
        const currentDays = daysInput.value;
        daysPills.forEach(p => {
            if (p.dataset.days === currentDays) p.classList.add('active');
        });

        updatePreview();
    })();
</script>

@endsection