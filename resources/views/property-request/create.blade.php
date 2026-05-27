<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Request a Property — Terra Real Estate</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --terra-green: #1a3c2e;
            --terra-mid: #2d5a40;
            --terra-light: #4a8c62;
            --terra-gold: #c9a84c;
            --terra-gold-lt: #e8d08a;
            --terra-cream: #f7f3ec;
            --terra-white: #fdfcf9;
            --terra-gray: #8a8a7e;
            --terra-border: #ddd8ce;
            --terra-error: #c0392b;
            --step-total: 6;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--terra-cream);
            color: var(--terra-green);
            min-height: 100vh;
        }

        /* ── Top bar ── */
        .topbar {
            background: var(--terra-green);
            padding: 0 2rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-logo {
            display: flex;
            align-items: center;
            gap: .6rem;
            text-decoration: none;
        }

        .topbar-logo img {
            height: 32px;
            filter: brightness(0) invert(1);
        }

        .topbar-back {
            color: rgba(255, 255, 255, .7);
            text-decoration: none;
            font-size: .8rem;
            letter-spacing: .05em;
            display: flex;
            align-items: center;
            gap: .4rem;
            transition: color .2s;
        }

        .topbar-back:hover {
            color: var(--terra-gold-lt);
        }

        .topbar-back svg {
            width: 14px;
            height: 14px;
        }

        /* ── Hero header ── */
        .page-hero {
            background: linear-gradient(135deg, var(--terra-green) 0%, var(--terra-mid) 60%, var(--terra-light) 100%);
            padding: 3rem 2rem 2.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .page-hero-tag {
            display: inline-block;
            font-size: .7rem;
            font-weight: 500;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--terra-gold-lt);
            border: 1px solid rgba(201, 168, 76, .4);
            padding: .3rem .9rem;
            border-radius: 2rem;
            margin-bottom: 1rem;
        }

        .page-hero h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 300;
            color: #fff;
            line-height: 1.2;
            margin-bottom: .6rem;
        }

        .page-hero h1 em {
            font-style: italic;
            color: var(--terra-gold-lt);
        }

        .page-hero p {
            color: rgba(255, 255, 255, .75);
            font-size: .9rem;
            max-width: 480px;
            margin: 0 auto;
        }

        /* ── Progress bar ── */
        .progress-wrapper {
            background: var(--terra-green);
            padding: 0 2rem 1.5rem;
        }

        .progress-steps {
            max-width: 700px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 0;
        }

        .progress-step {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .progress-step+.progress-step::before {
            content: '';
            position: absolute;
            left: -50%;
            top: 14px;
            width: 100%;
            height: 2px;
            background: rgba(255, 255, 255, .15);
            z-index: 0;
            transition: background .4s;
        }

        .progress-step.done+.progress-step::before,
        .progress-step.active+.progress-step::before {
            background: var(--terra-gold);
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .12);
            border: 2px solid rgba(255, 255, 255, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .7rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .5);
            position: relative;
            z-index: 1;
            transition: all .3s;
        }

        .progress-step.done .step-circle {
            background: var(--terra-gold);
            border-color: var(--terra-gold);
            color: var(--terra-green);
        }

        .progress-step.active .step-circle {
            background: #fff;
            border-color: #fff;
            color: var(--terra-green);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, .2);
        }

        .step-label {
            font-size: .6rem;
            color: rgba(255, 255, 255, .4);
            margin-top: .4rem;
            letter-spacing: .04em;
            text-align: center;
            display: none;
        }

        @media(min-width:500px) {
            .step-label {
                display: block;
            }
        }

        .progress-step.active .step-label {
            color: rgba(255, 255, 255, .9);
        }

        .progress-step.done .step-label {
            color: rgba(255, 255, 255, .6);
        }

        /* ── Form card ── */
        .form-container {
            max-width: 720px;
            margin: 2rem auto;
            padding: 0 1rem 4rem;
        }

        .form-card {
            background: var(--terra-white);
            border-radius: 16px;
            box-shadow: 0 4px 40px rgba(26, 60, 46, .08);
            overflow: hidden;
        }

        .step-panel {
            display: none;
            padding: 2.5rem 2.5rem;
            animation: fadeUp .35s ease;
        }

        .step-panel.active {
            display: block;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-panel-header {
            margin-bottom: 2rem;
            padding-bottom: 1.2rem;
            border-bottom: 1px solid var(--terra-border);
        }

        .step-badge {
            font-size: .68rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--terra-light);
            margin-bottom: .4rem;
        }

        .step-panel-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 400;
            color: var(--terra-green);
        }

        .step-panel-header p {
            color: var(--terra-gray);
            font-size: .85rem;
            margin-top: .3rem;
        }

        /* ── Form fields ── */
        .form-grid {
            display: grid;
            gap: 1.25rem;
        }

        .form-grid.cols-2 {
            grid-template-columns: 1fr 1fr;
        }

        .form-grid.cols-3 {
            grid-template-columns: 1fr 1fr 1fr;
        }

        @media(max-width:540px) {

            .form-grid.cols-2,
            .form-grid.cols-3 {
                grid-template-columns: 1fr;
            }

            .step-panel {
                padding: 1.5rem;
            }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: .4rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            font-size: .78rem;
            font-weight: 500;
            color: var(--terra-green);
            letter-spacing: .02em;
        }

        label .req {
            color: var(--terra-gold);
            margin-left: 2px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: .7rem 1rem;
            border: 1.5px solid var(--terra-border);
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            color: var(--terra-green);
            background: var(--terra-white);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
            appearance: none;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--terra-light);
            box-shadow: 0 0 0 3px rgba(74, 140, 98, .12);
        }

        select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%231a3c2e' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        .field-hint {
            font-size: .73rem;
            color: var(--terra-gray);
            margin-top: .1rem;
        }

        .field-error {
            font-size: .73rem;
            color: var(--terra-error);
            margin-top: .1rem;
            display: none;
        }

        .field-error.visible {
            display: block;
        }

        input.error,
        select.error,
        textarea.error {
            border-color: var(--terra-error);
        }

        /* ── Radio / Choice cards ── */
        .choice-grid {
            display: grid;
            gap: .75rem;
        }

        .choice-grid.cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .choice-grid.cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        @media(max-width:480px) {
            .choice-grid.cols-3 {
                grid-template-columns: 1fr 1fr;
            }
        }

        .choice-card {
            position: relative;
        }

        .choice-card input[type="radio"],
        .choice-card input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .choice-card label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: .35rem;
            padding: 1rem .75rem;
            border: 1.5px solid var(--terra-border);
            border-radius: 10px;
            cursor: pointer;
            text-align: center;
            font-size: .78rem;
            font-weight: 500;
            color: var(--terra-gray);
            background: var(--terra-white);
            transition: all .2s;
            letter-spacing: 0;
            min-height: 72px;
        }

        .choice-card label .icon {
            font-size: 1.4rem;
            line-height: 1;
        }

        .choice-card input:checked+label {
            border-color: var(--terra-light);
            background: rgba(74, 140, 98, .06);
            color: var(--terra-green);
            box-shadow: 0 0 0 3px rgba(74, 140, 98, .1);
        }

        .choice-card label:hover {
            border-color: var(--terra-light);
            color: var(--terra-green);
        }

        /* ── Amenity checkboxes ── */
        .amenity-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: .5rem;
        }

        /* ── Budget range ── */
        .budget-row {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .budget-row .sep {
            color: var(--terra-gray);
            font-size: .85rem;
            white-space: nowrap;
        }

        /* ── Navigation ── */
        .form-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 2.5rem;
            border-top: 1px solid var(--terra-border);
            background: var(--terra-cream);
        }

        @media(max-width:540px) {
            .form-nav {
                padding: 1.2rem 1.5rem;
            }
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .75rem 1.75rem;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: .88rem;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all .2s;
            text-decoration: none;
            letter-spacing: .02em;
        }

        .btn-primary {
            background: var(--terra-green);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--terra-mid);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(26, 60, 46, .3);
        }

        .btn-secondary {
            background: transparent;
            color: var(--terra-gray);
            border: 1.5px solid var(--terra-border);
        }

        .btn-secondary:hover {
            border-color: var(--terra-green);
            color: var(--terra-green);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--terra-gold) 0%, #b8922a 100%);
            color: var(--terra-green);
            font-weight: 600;
            padding: .85rem 2rem;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(201, 168, 76, .4);
        }

        .btn svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .step-counter {
            font-size: .78rem;
            color: var(--terra-gray);
        }

        .step-counter strong {
            color: var(--terra-green);
        }

        /* ── Checkbox styled ── */
        .checkbox-field {
            display: flex;
            align-items: flex-start;
            gap: .75rem;
            padding: .75rem 1rem;
            border: 1.5px solid var(--terra-border);
            border-radius: 8px;
            cursor: pointer;
            transition: border-color .2s;
        }

        .checkbox-field:hover {
            border-color: var(--terra-light);
        }

        .checkbox-field input[type="checkbox"] {
            width: 18px;
            height: 18px;
            min-width: 18px;
            accent-color: var(--terra-light);
            margin-top: 1px;
        }

        .checkbox-field .cbx-text {
            font-size: .83rem;
            color: var(--terra-green);
        }

        .checkbox-field .cbx-text small {
            display: block;
            color: var(--terra-gray);
            font-size: .75rem;
            margin-top: .1rem;
        }

        /* ── Review summary ── */
        .review-section {
            margin-bottom: 1.5rem;
        }

        .review-section-title {
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--terra-light);
            margin-bottom: .6rem;
            padding-bottom: .4rem;
            border-bottom: 1px solid var(--terra-border);
        }

        .review-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: .35rem 0;
            font-size: .84rem;
        }

        .review-row .rv-key {
            color: var(--terra-gray);
            min-width: 150px;
        }

        .review-row .rv-val {
            color: var(--terra-green);
            font-weight: 500;
            text-align: right;
        }

        /* ── Alert ── */
        .alert-error {
            background: #fdf2f2;
            border: 1px solid #f5c6c6;
            border-radius: 8px;
            padding: 1rem 1.2rem;
            margin-bottom: 1.5rem;
            font-size: .84rem;
            color: var(--terra-error);
            display: none;
        }

        .alert-error.visible {
            display: block;
        }

        .alert-error ul {
            margin-top: .5rem;
            padding-left: 1.2rem;
        }

        /* Laravel validation errors */
        .server-error {
            color: var(--terra-error);
            font-size: .78rem;
            margin-top: .3rem;
        }

        /* ── Misc ── */
        .divider {
            height: 1px;
            background: var(--terra-border);
            margin: 1.2rem 0;
        }

        .section-subtitle {
            font-size: .78rem;
            color: var(--terra-gray);
            margin-bottom: .75rem;
        }
    </style>
</head>

<body>

    {{-- ── Top bar ── --}}
    <header class="topbar">
        <a href="{{ url('/') }}" class="topbar-logo">
            <img src="https://www.terra.rw/front/assets/img/logo/logo.png" alt="Terra Real Estate" onerror="this.style.display='none';this.nextSibling.style.display='block'">
            <span style="color:#fff;font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:400;display:none;">Terra</span>
        </a>
        <a href="{{ url('/') }}" class="topbar-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15,18 9,12 15,6" />
            </svg>
            Back to Terra
        </a>
    </header>

    {{-- ── Hero ── --}}
    <div class="page-hero">
        <div class="page-hero-tag">Property Request</div>
        <h1>Find Your <em>Dream Property</em></h1>
        <p>Tell us what you're looking for and our team will match you with the perfect property across Rwanda.</p>
    </div>

    {{-- ── Progress ── --}}
    <div class="progress-wrapper">
        <div class="progress-steps">
            @php
            $steps = [
            1 => 'Personal',
            2 => 'Purpose',
            3 => 'Location',
            4 => 'Budget',
            5 => 'Features',
            6 => 'Review',
            ];
            @endphp
            @foreach($steps as $num => $label)
            <div class="progress-step {{ $num === 1 ? 'active' : '' }}" id="prog-{{ $num }}">
                <div class="step-circle">
                    <span class="step-num">{{ $num }}</span>
                    <svg class="check-icon" style="display:none;width:14px;height:14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20,6 9,17 4,12" />
                    </svg>
                </div>
                <span class="step-label">{{ $label }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Form ── --}}
    <div class="form-container">

        @if($errors->any())
        <div style="background:#fdf2f2;border:1px solid #f5c6c6;border-radius:8px;padding:1rem 1.2rem;margin-bottom:1rem;color:#c0392b;font-size:.85rem;">
            <strong>Please fix the following errors:</strong>
            <ul style="margin-top:.5rem;padding-left:1.2rem;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="propertyForm" action="{{ route('property-request.store') }}" method="POST" novalidate>
            @csrf
            <div class="form-card">

                {{-- ══════════════════════════════════════════════════════
                     STEP 1 — Personal Information
                ══════════════════════════════════════════════════════ --}}
                <div class="step-panel active" id="step-1">
                    <div class="step-panel-header">
                        <div class="step-badge">Step 1 of 6</div>
                        <h2>Personal Information</h2>
                        <p>Let us know who you are so we can reach you with the best options.</p>
                    </div>
                    <div class="alert-error" id="err-1"></div>
                    <div class="form-grid cols-2">
                        <div class="form-group full-width">
                            <label for="full_name">Full Name <span class="req">*</span></label>
                            <input type="text" id="full_name" name="full_name" placeholder="e.g. Jean-Paul Habimana" value="{{ old('full_name') }}" required>
                            @error('full_name')<span class="server-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address <span class="req">*</span></label>
                            <input type="email" id="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required>
                            @error('email')<span class="server-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number <span class="req">*</span></label>
                            <input type="tel" id="phone" name="phone" placeholder="+250 7XX XXX XXX" value="{{ old('phone') }}" required>
                            @error('phone')<span class="server-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="nationality">Nationality</label>
                            <input type="text" id="nationality" name="nationality" placeholder="e.g. Rwandan" value="{{ old('nationality') }}">
                        </div>
                        <div class="form-group full-width">
                            <label>Preferred Contact Method <span class="req">*</span></label>
                            <div class="choice-grid cols-3" style="margin-top:.25rem;">
                                @foreach(['email' => ['📧','Email'], 'phone' => ['📞','Phone Call'], 'whatsapp' => ['💬','WhatsApp']] as $val => $data)
                                <div class="choice-card">
                                    <input type="radio" name="preferred_contact" id="contact_{{ $val }}" value="{{ $val }}" {{ old('preferred_contact', 'email') === $val ? 'checked' : '' }}>
                                    <label for="contact_{{ $val }}">
                                        <span class="icon">{{ $data[0] }}</span>
                                        {{ $data[1] }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════════════
                     STEP 2 — Property Type & Purpose
                ══════════════════════════════════════════════════════ --}}
                <div class="step-panel" id="step-2">
                    <div class="step-panel-header">
                        <div class="step-badge">Step 2 of 6</div>
                        <h2>Property Type & Purpose</h2>
                        <p>What are you looking to do, and what kind of property interests you?</p>
                    </div>
                    <div class="alert-error" id="err-2"></div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>I want to… <span class="req">*</span></label>
                            <div class="choice-grid cols-3" style="margin-top:.25rem;">
                                @foreach(['buy' => ['🏠','Buy'], 'rent' => ['🔑','Rent'], 'invest' => ['📈','Invest']] as $val => $data)
                                <div class="choice-card">
                                    <input type="radio" name="request_type" id="rtype_{{ $val }}" value="{{ $val }}" {{ old('request_type') === $val ? 'checked' : '' }} required>
                                    <label for="rtype_{{ $val }}">
                                        <span class="icon">{{ $data[0] }}</span>
                                        {{ $data[1] }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Property Type <span class="req">*</span></label>
                            <div class="choice-grid cols-3" style="margin-top:.25rem;">
                                @foreach([
                                'house' => ['🏡','House'],
                                'apartment' => ['🏢','Apartment'],
                                'land' => ['🌍','Land / Plot'],
                                'commercial' => ['🏪','Commercial'],
                                'architectural_design'=> ['📐','Design Plan'],
                                ] as $val => $data)
                                <div class="choice-card">
                                    <input type="radio" name="property_type" id="ptype_{{ $val }}" value="{{ $val }}" {{ old('property_type') === $val ? 'checked' : '' }} required>
                                    <label for="ptype_{{ $val }}">
                                        <span class="icon">{{ $data[0] }}</span>
                                        {{ $data[1] }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Property Status</label>
                            <div class="choice-grid cols-3" style="margin-top:.25rem;">
                                @foreach(['new' => ['✨','New Build'], 'existing' => ['🏚️','Existing'], 'any' => ['🔄','Either']] as $val => $data)
                                <div class="choice-card">
                                    <input type="radio" name="property_status" id="pstatus_{{ $val }}" value="{{ $val }}" {{ old('property_status', 'any') === $val ? 'checked' : '' }}>
                                    <label for="pstatus_{{ $val }}">
                                        <span class="icon">{{ $data[0] }}</span>
                                        {{ $data[1] }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════════════
                     STEP 3 — Location Preferences
                ══════════════════════════════════════════════════════ --}}
                <div class="step-panel" id="step-3">
                    <div class="step-panel-header">
                        <div class="step-badge">Step 3 of 6</div>
                        <h2>Location Preferences</h2>
                        <p>Where in Rwanda would you like your property to be?</p>
                    </div>
                    <div class="alert-error" id="err-3"></div>
                    <div class="form-grid cols-2">
                        <div class="form-group">
                            <label for="preferred_province">Province</label>
                            <select id="preferred_province" name="preferred_province">
                                <option value="">Any province</option>
                                @foreach(['Kigali City', 'Northern Province', 'Southern Province', 'Eastern Province', 'Western Province'] as $prov)
                                <option value="{{ $prov }}" {{ old('preferred_province') === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="preferred_district">District</label>
                            <input type="text" id="preferred_district" name="preferred_district" placeholder="e.g. Gasabo, Nyarugenge…" value="{{ old('preferred_district') }}">
                        </div>
                        <div class="form-group">
                            <label for="preferred_sector">Sector / Neighbourhood</label>
                            <input type="text" id="preferred_sector" name="preferred_sector" placeholder="e.g. Kimihurura, Remera…" value="{{ old('preferred_sector') }}">
                        </div>
                        <div class="form-group full-width">
                            <label for="location_notes">Additional Location Notes</label>
                            <textarea id="location_notes" name="location_notes" placeholder="Describe any specific location requirements, nearby amenities, proximity to schools, etc.">{{ old('location_notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════════════
                     STEP 4 — Budget & Timeline
                ══════════════════════════════════════════════════════ --}}
                <div class="step-panel" id="step-4">
                    <div class="step-panel-header">
                        <div class="step-badge">Step 4 of 6</div>
                        <h2>Budget & Timeline</h2>
                        <p>Help us understand your financial range and when you need to move.</p>
                    </div>
                    <div class="alert-error" id="err-4"></div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="currency">Currency</label>
                            <select id="currency" name="currency">
                                <option value="USD" {{ old('currency', 'USD') === 'USD' ? 'selected' : '' }}>USD — US Dollar</option>
                                <option value="RWF" {{ old('currency') === 'RWF' ? 'selected' : '' }}>RWF — Rwandan Franc</option>
                                <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR — Euro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Budget Range</label>
                            <div class="budget-row">
                                <input type="number" id="budget_min" name="budget_min" placeholder="Min" min="0" value="{{ old('budget_min') }}" style="flex:1;">
                                <span class="sep">to</span>
                                <input type="number" id="budget_max" name="budget_max" placeholder="Max" min="0" value="{{ old('budget_max') }}" style="flex:1;">
                            </div>
                            <span class="field-hint">Leave blank if not sure</span>
                        </div>
                        <div class="form-group">
                            <label for="timeline">When do you need it? <span class="req">*</span></label>
                            <select id="timeline" name="timeline" required>
                                <option value="immediate" {{ old('timeline') === 'immediate'    ? 'selected' : '' }}>Immediately</option>
                                <option value="1_3_months" {{ old('timeline') === '1_3_months'   ? 'selected' : '' }}>1 – 3 Months</option>
                                <option value="3_6_months" {{ old('timeline') === '3_6_months'   ? 'selected' : '' }}>3 – 6 Months</option>
                                <option value="6_12_months" {{ old('timeline') === '6_12_months'  ? 'selected' : '' }}>6 – 12 Months</option>
                                <option value="flexible" selected {{ old('timeline', 'flexible') === 'flexible' ? 'selected' : '' }}>Flexible</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Financing</label>
                            <label class="checkbox-field" style="cursor:pointer;display:flex;">
                                <input type="hidden" name="financing_needed" value="0">
                                <input type="checkbox" name="financing_needed" id="financing_needed" value="1" {{ old('financing_needed') ? 'checked' : '' }}>
                                <div class="cbx-text">
                                    I need financing / mortgage assistance
                                    <small>Our consultants can connect you with mortgage providers in Rwanda</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════════════
                     STEP 5 — Property Features
                ══════════════════════════════════════════════════════ --}}
                <div class="step-panel" id="step-5">
                    <div class="step-panel-header">
                        <div class="step-badge">Step 5 of 6</div>
                        <h2>Property Features</h2>
                        <p>Specify what your ideal property looks like inside and out.</p>
                    </div>
                    <div class="alert-error" id="err-5"></div>
                    <div class="form-grid cols-2">
                        <div class="form-group">
                            <label for="bedrooms_min">Minimum Bedrooms</label>
                            <select id="bedrooms_min" name="bedrooms_min">
                                <option value="">Any</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('bedrooms_min') == $i ? 'selected' : '' }}>{{ $i }}{{ $i === 10 ? '+' : '' }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bathrooms_min">Minimum Bathrooms</label>
                            <select id="bathrooms_min" name="bathrooms_min">
                                <option value="">Any</option>
                                @for($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}" {{ old('bathrooms_min') == $i ? 'selected' : '' }}>{{ $i }}{{ $i === 8 ? '+' : '' }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Land Size (m²)</label>
                            <div class="budget-row">
                                <input type="number" name="land_size_min" placeholder="Min m²" min="0" value="{{ old('land_size_min') }}" style="flex:1;">
                                <span class="sep">–</span>
                                <input type="number" name="land_size_max" placeholder="Max m²" min="0" value="{{ old('land_size_max') }}" style="flex:1;">
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label>Desired Amenities</label>
                            <div class="amenity-grid" style="margin-top:.4rem;">
                                @foreach([
                                'parking' => '🚗 Parking',
                                'garden' => '🌿 Garden',
                                'pool' => '🏊 Pool',
                                'security' => '🔒 Security',
                                'generator' => '⚡ Generator',
                                'gym' => '🏋️ Gym',
                                'elevator' => '🛗 Elevator',
                                'borehole' => '💧 Borehole',
                                ] as $val => $label)
                                <div class="choice-card">
                                    <input type="checkbox" name="amenities[]" id="amenity_{{ $val }}" value="{{ $val }}"
                                        {{ in_array($val, old('amenities', [])) ? 'checked' : '' }}>
                                    <label for="amenity_{{ $val }}" style="min-height:52px;font-size:.76rem;">{{ $label }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label for="must_have">Must-Have Features</label>
                            <input type="text" id="must_have_input" placeholder="Type a feature and press Enter (e.g. Corner plot, Gate house)">
                            <div id="must_have_tags" style="display:flex;flex-wrap:wrap;gap:.4rem;margin-top:.5rem;"></div>
                            <div id="must_have_hidden"></div>
                            <span class="field-hint">Press Enter or comma to add a feature</span>
                        </div>
                        <div class="form-group full-width">
                            <label for="nice_have_input">Nice-to-Have Features</label>
                            <input type="text" id="nice_have_input" placeholder="Type a feature and press Enter (e.g. Mountain view, Solar panels)">
                            <div id="nice_have_tags" style="display:flex;flex-wrap:wrap;gap:.4rem;margin-top:.5rem;"></div>
                            <div id="nice_have_hidden"></div>
                            <span class="field-hint">Press Enter or comma to add a feature</span>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════════════
                     STEP 6 — Review & Submit
                ══════════════════════════════════════════════════════ --}}
                <div class="step-panel" id="step-6">
                    <div class="step-panel-header">
                        <div class="step-badge">Step 6 of 6</div>
                        <h2>Review & Submit</h2>
                        <p>Almost there — review your request and add any final notes.</p>
                    </div>

                    {{-- Summary ── --}}
                    <div id="review-summary" style="margin-bottom:2rem;"></div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="urgency">Request Urgency <span class="req">*</span></label>
                            <select id="urgency" name="urgency" required>
                                <option value="low" {{ old('urgency') === 'low'    ? 'selected' : '' }}>🟢 Low — No rush</option>
                                <option value="medium" {{ old('urgency', 'medium') === 'medium' ? 'selected' : '' }}>🟡 Medium — Within a few months</option>
                                <option value="high" {{ old('urgency') === 'high'   ? 'selected' : '' }}>🔴 High — As soon as possible</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="how_did_you_hear">How did you hear about Terra?</label>
                            <select id="how_did_you_hear" name="how_did_you_hear">
                                <option value="">Select…</option>
                                @foreach(['Google Search', 'Social Media', 'Friend / Family', 'Agent Referral', 'Advertisement', 'Radio / TV', 'Other'] as $src)
                                <option value="{{ $src }}" {{ old('how_did_you_hear') === $src ? 'selected' : '' }}>{{ $src }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group full-width">
                            <label for="additional_notes">Additional Notes</label>
                            <textarea id="additional_notes" name="additional_notes" placeholder="Any other details that would help us find your perfect property…">{{ old('additional_notes') }}</textarea>
                        </div>
                        <div class="form-group full-width">
                            <label class="checkbox-field" style="cursor:pointer;display:flex;">
                                <input type="hidden" name="newsletter_opt_in" value="0">
                                <input type="checkbox" name="newsletter_opt_in" id="newsletter_opt_in" value="1" {{ old('newsletter_opt_in') ? 'checked' : '' }}>
                                <div class="cbx-text">
                                    Keep me updated with new listings and market news
                                    <small>You can unsubscribe at any time</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- ── Navigation ── --}}
                <div class="form-nav">
                    <button type="button" class="btn btn-secondary" id="btnPrev" style="visibility:hidden;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="15,18 9,12 15,6" />
                        </svg>
                        Previous
                    </button>
                    <span class="step-counter">Step <strong id="currentStepLabel">1</strong> of <strong>6</strong></span>
                    <button type="button" class="btn btn-primary" id="btnNext">
                        Next
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9,18 15,12 9,6" />
                        </svg>
                    </button>
                    <button type="submit" class="btn btn-submit" id="btnSubmit" style="display:none;">
                        Submit Request
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9,18 15,12 9,6" />
                        </svg>
                    </button>
                </div>

            </div>
        </form>
    </div>

    <script>
        (function() {
            const TOTAL = 6;
            let current = 1;

            const panels = id => document.getElementById('step-' + id);
            const progs = id => document.getElementById('prog-' + id);
            const btnPrev = document.getElementById('btnPrev');
            const btnNext = document.getElementById('btnNext');
            const btnSubmit = document.getElementById('btnSubmit');
            const label = document.getElementById('currentStepLabel');

            /* ── Tag input helper ── */
            function initTagInput(inputId, tagContainerId, hiddenContainerId, fieldName) {
                const input = document.getElementById(inputId);
                const tags = document.getElementById(tagContainerId);
                const hidden = document.getElementById(hiddenContainerId);
                const items = [];

                function addTag(val) {
                    val = val.trim().replace(/,$/, '');
                    if (!val || items.includes(val)) return;
                    items.push(val);
                    renderTags();
                }

                function renderTags() {
                    tags.innerHTML = '';
                    hidden.innerHTML = '';
                    items.forEach((item, i) => {
                        const chip = document.createElement('span');
                        chip.style.cssText = 'display:inline-flex;align-items:center;gap:.3rem;background:#e8f0ec;color:#1a3c2e;padding:.2rem .6rem;border-radius:4px;font-size:.75rem;font-weight:500;';
                        chip.innerHTML = item + ' <button type="button" style="background:none;border:none;cursor:pointer;color:#4a8c62;font-size:.9rem;padding:0;line-height:1;" data-i="' + i + '">×</button>';
                        chip.querySelector('button').onclick = () => {
                            items.splice(i, 1);
                            renderTags();
                        };
                        tags.appendChild(chip);

                        const inp = document.createElement('input');
                        inp.type = 'hidden';
                        inp.name = fieldName + '[]';
                        inp.value = item;
                        hidden.appendChild(inp);
                    });
                }
                input.addEventListener('keydown', e => {
                    if (e.key === 'Enter' || e.key === ',') {
                        e.preventDefault();
                        addTag(input.value);
                        input.value = '';
                    }
                });
                input.addEventListener('blur', () => {
                    if (input.value.trim()) {
                        addTag(input.value);
                        input.value = '';
                    }
                });
            }

            initTagInput('must_have_input', 'must_have_tags', 'must_have_hidden', 'must_have_features');
            initTagInput('nice_have_input', 'nice_have_tags', 'nice_have_hidden', 'nice_to_have_features');

            /* ── Validation ── */
            function validateStep(n) {
                const errBox = document.getElementById('err-' + n);
                const errors = [];

                function req(id, label) {
                    const el = document.getElementById(id);
                    if (!el) return;
                    const val = el.value.trim();
                    if (!val) {
                        el.classList.add('error');
                        errors.push(label + ' is required.');
                    } else el.classList.remove('error');
                }

                function reqRadio(name, label) {
                    const checked = document.querySelector('input[name="' + name + '"]:checked');
                    if (!checked) errors.push(label + ' is required.');
                }

                if (n === 1) {
                    req('full_name', 'Full Name');
                    req('email', 'Email Address');
                    req('phone', 'Phone Number');
                    // email format
                    const em = document.getElementById('email');
                    if (em && em.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em.value)) {
                        em.classList.add('error');
                        errors.push('Please enter a valid email address.');
                    }
                }
                if (n === 2) {
                    reqRadio('request_type', 'Request type');
                    reqRadio('property_type', 'Property type');
                }

                if (errBox) {
                    if (errors.length) {
                        errBox.innerHTML = '<strong>Please fix:</strong><ul>' + errors.map(e => '<li>' + e + '</li>').join('') + '</ul>';
                        errBox.classList.add('visible');
                    } else {
                        errBox.classList.remove('visible');
                    }
                }
                return errors.length === 0;
            }

            /* ── Review summary ── */
            function buildReview() {
                const val = name => {
                    const el = document.querySelector('[name="' + name + '"]');
                    return el ? el.value : '';
                };
                const radio = name => {
                    const el = document.querySelector('[name="' + name + '"]:checked');
                    return el ? el.value : '—';
                };
                const fmt = v => v || '—';

                function amenitiesSelected() {
                    return Array.from(document.querySelectorAll('[name="amenities[]"]:checked')).map(e => e.value).join(', ') || '—';
                }

                const sections = [{
                        title: 'Personal',
                        rows: [
                            ['Name', fmt(val('full_name'))],
                            ['Email', fmt(val('email'))],
                            ['Phone', fmt(val('phone'))],
                            ['Contact', radio('preferred_contact')],
                        ]
                    },
                    {
                        title: 'Purpose',
                        rows: [
                            ['Type', radio('request_type')],
                            ['Property', radio('property_type')],
                            ['Status', radio('property_status')],
                        ]
                    },
                    {
                        title: 'Location',
                        rows: [
                            ['Province', fmt(val('preferred_province'))],
                            ['District', fmt(val('preferred_district'))],
                            ['Sector', fmt(val('preferred_sector'))],
                        ]
                    },
                    {
                        title: 'Budget',
                        rows: [
                            ['Currency', fmt(val('currency'))],
                            ['Budget', (val('budget_min') || val('budget_max')) ? (val('budget_min') || '0') + ' – ' + (val('budget_max') || '∞') : '—'],
                            ['Timeline', fmt(val('timeline'))],
                        ]
                    },
                    {
                        title: 'Features',
                        rows: [
                            ['Bedrooms', fmt(val('bedrooms_min'))],
                            ['Amenities', amenitiesSelected()],
                        ]
                    },
                ];

                document.getElementById('review-summary').innerHTML = sections.map(s => `
            <div class="review-section">
                <div class="review-section-title">${s.title}</div>
                ${s.rows.map(([k,v]) => `<div class="review-row"><span class="rv-key">${k}</span><span class="rv-val">${v}</span></div>`).join('')}
            </div>
        `).join('');
            }

            /* ── Navigation ── */
            function goTo(n) {
                panels(current).classList.remove('active');
                progs(current).classList.remove('active');
                progs(current).classList.add('done');
                // show checkmark
                progs(current).querySelector('.step-num').style.display = 'none';
                progs(current).querySelector('.check-icon').style.display = '';

                current = n;
                panels(current).classList.add('active');

                // progress
                for (let i = 1; i <= TOTAL; i++) {
                    const p = progs(i);
                    if (i < current) {
                        p.classList.remove('active');
                        p.classList.add('done');
                        p.querySelector('.step-num').style.display = 'none';
                        p.querySelector('.check-icon').style.display = '';
                    } else if (i === current) {
                        p.classList.add('active');
                        p.classList.remove('done');
                        p.querySelector('.step-num').style.display = '';
                        p.querySelector('.check-icon').style.display = 'none';
                    } else {
                        p.classList.remove('active', 'done');
                        p.querySelector('.step-num').style.display = '';
                        p.querySelector('.check-icon').style.display = 'none';
                    }
                }

                label.textContent = current;
                btnPrev.style.visibility = current === 1 ? 'hidden' : 'visible';
                btnNext.style.display = current === TOTAL ? 'none' : '';
                btnSubmit.style.display = current === TOTAL ? '' : 'none';

                if (current === TOTAL) buildReview();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            btnNext.addEventListener('click', () => {
                if (validateStep(current) && current < TOTAL) goTo(current + 1);
            });
            btnPrev.addEventListener('click', () => {
                if (current > 1) goTo(current - 1);
            });

            // If server returned errors, jump to step 1
            @if($errors->any())
            goTo(1);
            @endif
        })();
    </script>
</body>

</html>