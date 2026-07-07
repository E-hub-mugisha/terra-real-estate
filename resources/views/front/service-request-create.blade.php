<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Request a Service — Terra</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/dist/tabler-icons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --navy: #19265d;
        --navy-dark: #111a45;
        --navy-tint: #eef0f8;
        --gold: #D05208;
        --gold-light: #fdf1e8;
        --ink: #16203f;
        --muted: #6b7280;
        --line: #e7e9f2;
        --danger: #dc3545;
    }

    * { box-sizing: border-box; }

    body {
        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
        background: linear-gradient(180deg, var(--navy-dark) 0%, var(--navy) 260px, #f7f7fb 260px);
        min-height: 100vh;
        margin: 0;
    }

    .rq-shell { max-width: 760px; margin: 0 auto; padding: 3rem 1.25rem 4rem; }

    /* ── Header ── */
    .rq-brand {
        display: flex; align-items: center; gap: .6rem;
        color: rgba(255,255,255,.85); font-weight: 700; font-size: .85rem;
        letter-spacing: .08em; text-transform: uppercase; margin-bottom: 1.5rem;
    }
    .rq-brand i { color: var(--gold); font-size: 1.1rem; }

    .rq-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 700; font-size: 2.4rem; color: #fff; margin-bottom: .5rem;
    }
    .rq-hero p { color: rgba(255,255,255,.75); font-size: 1rem; max-width: 480px; margin-bottom: 2.25rem; }

    /* ── Progress ── */
    .rq-progress { display: flex; align-items: center; margin-bottom: 2.25rem; }
    .rq-progress-step {
        display: flex; flex-direction: column; align-items: center; gap: .5rem;
        flex: 1; position: relative;
    }
    .rq-progress-dot {
        width: 34px; height: 34px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: #fff; border: 2px solid var(--line); color: var(--muted);
        font-weight: 700; font-size: .85rem; transition: all .25s ease; z-index: 2;
    }
    .rq-progress-step.active .rq-progress-dot {
        border-color: var(--gold); background: var(--gold); color: #fff;
        box-shadow: 0 0 0 5px rgba(208,82,8,.15);
    }
    .rq-progress-step.done .rq-progress-dot {
        border-color: var(--navy); background: var(--navy); color: #fff;
    }
    .rq-progress-label { font-size: .72rem; font-weight: 600; color: rgba(255,255,255,.6); text-align: center; }
    .rq-progress-step.active .rq-progress-label,
    .rq-progress-step.done .rq-progress-label { color: #fff; }
    .rq-progress-line {
        position: absolute; top: 17px; left: -50%; width: 100%; height: 2px;
        background: var(--line); z-index: 1;
    }
    .rq-progress-step:first-child .rq-progress-line { display: none; }
    .rq-progress-step.done .rq-progress-line,
    .rq-progress-step.active .rq-progress-line { background: var(--gold); }

    /* ── Card ── */
    .rq-card {
        background: #fff; border-radius: 20px; border: 1px solid var(--line);
        box-shadow: 0 20px 45px -25px rgba(17,26,69,.35);
        overflow: hidden;
    }
    .rq-card-body { padding: 2.25rem 2.25rem 2rem; min-height: 380px; }

    .rq-step-title {
        font-family: 'Cormorant Garamond', serif; font-weight: 700; font-size: 1.5rem;
        color: var(--navy); margin-bottom: .3rem;
    }
    .rq-step-subtitle { color: var(--muted); font-size: .88rem; margin-bottom: 1.75rem; }

    /* ── Service cards ── */
    .rq-service-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: .9rem; }
    @media (max-width: 560px) { .rq-service-grid { grid-template-columns: 1fr; } }

    .rq-service-card {
        border: 1.5px solid var(--line); border-radius: 14px; padding: 1.1rem 1.2rem;
        cursor: pointer; transition: all .15s ease; position: relative; display: block;
    }
    .rq-service-card:hover { border-color: var(--gold); background: var(--gold-light); }
    .rq-service-card.selected { border-color: var(--gold); background: var(--gold-light); }
    .rq-service-card input { position: absolute; opacity: 0; pointer-events: none; }
    .rq-service-card-title { font-weight: 700; font-size: .92rem; color: var(--ink); margin-bottom: .2rem; }
    .rq-service-card-price { font-size: .78rem; color: var(--muted); }
    .rq-service-check {
        position: absolute; top: .9rem; right: .9rem; width: 20px; height: 20px;
        border-radius: 50%; border: 1.5px solid var(--line); background: #fff;
        display: flex; align-items: center; justify-content: center; font-size: .65rem; color: #fff;
    }
    .rq-service-card.selected .rq-service-check { background: var(--gold); border-color: var(--gold); }

    /* ── Inputs ── */
    .rq-label { display: block; font-size: .8rem; font-weight: 600; color: var(--muted); margin-bottom: .4rem; }
    .rq-input-wrap { position: relative; margin-bottom: 1.1rem; }
    .rq-input-icon {
        position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
        color: #9aa0b4; font-size: 1rem; pointer-events: none; z-index: 2;
    }
    .rq-control {
        width: 100%; border: 1.5px solid var(--line); border-radius: 12px;
        padding: .72rem 1rem .72rem 2.9rem; font-size: .92rem; background: #fbfbfd;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
        font-family: 'DM Sans', sans-serif; color: var(--ink);
    }
    .rq-control:focus {
        border-color: var(--gold); box-shadow: 0 0 0 4px rgba(208,82,8,.1);
        background: #fff; outline: none;
    }
    textarea.rq-control { padding-left: 1rem; resize: vertical; min-height: 100px; }
    .rq-error { color: var(--danger); font-size: .76rem; margin-top: -.7rem; margin-bottom: .9rem; }

    /* ── Review ── */
    .rq-review-row {
        display: flex; justify-content: space-between; gap: 1rem;
        padding: .85rem 0; border-bottom: 1px dashed var(--line); font-size: .88rem;
    }
    .rq-review-row:last-child { border-bottom: none; }
    .rq-review-label { color: var(--muted); font-weight: 600; }
    .rq-review-value { color: var(--ink); font-weight: 600; text-align: right; }

    /* ── Footer nav ── */
    .rq-card-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.25rem 2.25rem; border-top: 1px solid var(--line); background: var(--navy-tint);
    }
    .rq-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        border: none; border-radius: 12px; font-weight: 700; font-size: .9rem;
        padding: .75rem 1.4rem; transition: all .15s ease; cursor: pointer;
    }
    .rq-btn-primary {
        background: var(--gold); color: #fff;
        box-shadow: 0 10px 22px -10px rgba(208,82,8,.55);
    }
    .rq-btn-primary:hover { background: #b84706; color: #fff; transform: translateY(-1px); }
    .rq-btn-ghost { background: transparent; color: var(--muted); }
    .rq-btn-ghost:hover { color: var(--navy); }
    .rq-btn:disabled { opacity: .45; cursor: not-allowed; transform: none !important; }

    .rq-alert-success {
        background: #eafaf1; border: 1px solid #b9e9cd; color: #146c43;
        border-radius: 14px; padding: 1rem 1.2rem; margin-bottom: 1.5rem;
        display: flex; align-items: center; gap: .6rem; font-size: .9rem;
    }

    .rq-step { display: none; }
    .rq-step.active { display: block; animation: rqFade .25s ease; }
    @keyframes rqFade { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
</style>
</head>
<body>

<div class="rq-shell">

    <div class="rq-brand"><i class="ti ti-building-skyscraper"></i> Terra Real Estate</div>

    <div class="rq-hero">
        <h1>Request a Consultation</h1>
        <p>Tell us what you need and one of our Terra consultants will reach out to confirm the details.</p>
    </div>

    @if (session('success'))
    <div class="rq-alert-success">
        <i class="ti ti-circle-check fs-5"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Progress bar ── --}}
    <div class="rq-progress" id="rqProgress">
        <div class="rq-progress-step active" data-step-indicator="1">
            <div class="rq-progress-line"></div>
            <div class="rq-progress-dot">1</div>
            <div class="rq-progress-label">Service</div>
        </div>
        <div class="rq-progress-step" data-step-indicator="2">
            <div class="rq-progress-line"></div>
            <div class="rq-progress-dot">2</div>
            <div class="rq-progress-label">Your Details</div>
        </div>
        <div class="rq-progress-step" data-step-indicator="3">
            <div class="rq-progress-line"></div>
            <div class="rq-progress-dot">3</div>
            <div class="rq-progress-label">Schedule</div>
        </div>
        <div class="rq-progress-step" data-step-indicator="4">
            <div class="rq-progress-line"></div>
            <div class="rq-progress-dot">4</div>
            <div class="rq-progress-label">Review</div>
        </div>
    </div>

    <form method="POST" action="{{ route('service-requests.store') }}" id="rqForm" novalidate>
        @csrf

        <div class="rq-card">
            <div class="rq-card-body">

                {{-- ── Step 1: Service ── --}}
                <div class="rq-step active" data-step="1">
                    <div class="rq-step-title">Which service do you need?</div>
                    <div class="rq-step-subtitle">Choose the service that best matches what you're looking for.</div>

                    <div class="rq-service-grid">
                        @foreach ($services as $service)
                            <label class="rq-service-card" data-service-card>
                                <input type="radio" name="service_id" value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'checked' : '' }} required>
                                <div class="rq-service-check"><i class="ti ti-check"></i></div>
                                <div class="rq-service-card-title">{{ $service->title }}</div>
                                @if(isset($service->price))
                                <div class="rq-service-card-price">From {{ number_format($service->price) }} RWF</div>
                                @endif
                            </label>
                        @endforeach
                    </div>
                    @error('service_id') <div class="rq-error">{{ $message }}</div> @enderror
                </div>

                {{-- ── Step 2: Your details ── --}}
                <div class="rq-step" data-step="2">
                    <div class="rq-step-title">Your details</div>
                    <div class="rq-step-subtitle">So our consultant knows who to contact and where.</div>

                    <label class="rq-label">Full Name</label>
                    <div class="rq-input-wrap">
                        <i class="ti ti-user rq-input-icon"></i>
                        <input type="text" name="full_name" class="rq-control" value="{{ old('full_name') }}" required>
                    </div>
                    @error('full_name') <div class="rq-error">{{ $message }}</div> @enderror

                    <label class="rq-label">Phone Number</label>
                    <div class="rq-input-wrap">
                        <i class="ti ti-phone rq-input-icon"></i>
                        <input type="text" name="phone" class="rq-control" placeholder="0788123456" value="{{ old('phone') }}" required>
                    </div>
                    @error('phone') <div class="rq-error">{{ $message }}</div> @enderror

                    <label class="rq-label">Email <span class="fw-normal text-muted">(optional)</span></label>
                    <div class="rq-input-wrap">
                        <i class="ti ti-mail rq-input-icon"></i>
                        <input type="email" name="email" class="rq-control" value="{{ old('email') }}">
                    </div>
                    @error('email') <div class="rq-error">{{ $message }}</div> @enderror

                    <label class="rq-label">Location</label>
                    <div class="rq-input-wrap">
                        <i class="ti ti-map-pin rq-input-icon"></i>
                        <input type="text" name="location" class="rq-control" placeholder="e.g. Kicukiro, Kigali" value="{{ old('location') }}" required>
                    </div>
                    @error('location') <div class="rq-error">{{ $message }}</div> @enderror
                </div>

                {{-- ── Step 3: Schedule ── --}}
                <div class="rq-step" data-step="3">
                    <div class="rq-step-title">When works best?</div>
                    <div class="rq-step-subtitle">Give us your preferred date and time, plus any details we should know.</div>

                    <div class="row g-3 mb-1">
                        <div class="col-sm-6">
                            <label class="rq-label">Preferred Date</label>
                            <div class="rq-input-wrap">
                                <i class="ti ti-calendar rq-input-icon"></i>
                                <input type="date" name="preferred_date" class="rq-control" value="{{ old('preferred_date') }}" required>
                            </div>
                            @error('preferred_date') <div class="rq-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="rq-label">Preferred Time</label>
                            <div class="rq-input-wrap">
                                <i class="ti ti-clock rq-input-icon"></i>
                                <input type="time" name="preferred_time" class="rq-control" value="{{ old('preferred_time') }}" required>
                            </div>
                            @error('preferred_time') <div class="rq-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <label class="rq-label">Message <span class="fw-normal text-muted">(optional)</span></label>
                    <textarea name="message" class="rq-control" rows="4" placeholder="Tell us more about what you need...">{{ old('message') }}</textarea>
                    @error('message') <div class="rq-error">{{ $message }}</div> @enderror
                </div>

                {{-- ── Step 4: Review ── --}}
                <div class="rq-step" data-step="4">
                    <div class="rq-step-title">Review your request</div>
                    <div class="rq-step-subtitle">Make sure everything looks right before you submit.</div>

                    <div class="rq-review-row">
                        <span class="rq-review-label">Service</span>
                        <span class="rq-review-value" id="reviewService">—</span>
                    </div>
                    <div class="rq-review-row">
                        <span class="rq-review-label">Name</span>
                        <span class="rq-review-value" id="reviewName">—</span>
                    </div>
                    <div class="rq-review-row">
                        <span class="rq-review-label">Phone</span>
                        <span class="rq-review-value" id="reviewPhone">—</span>
                    </div>
                    <div class="rq-review-row">
                        <span class="rq-review-label">Location</span>
                        <span class="rq-review-value" id="reviewLocation">—</span>
                    </div>
                    <div class="rq-review-row">
                        <span class="rq-review-label">Date &amp; Time</span>
                        <span class="rq-review-value" id="reviewDateTime">—</span>
                    </div>
                </div>

            </div>

            <div class="rq-card-footer">
                <button type="button" class="rq-btn rq-btn-ghost" id="rqBackBtn" disabled>
                    <i class="ti ti-arrow-left"></i> Back
                </button>
                <button type="button" class="rq-btn rq-btn-primary" id="rqNextBtn">
                    Continue <i class="ti ti-arrow-right"></i>
                </button>
                <button type="submit" class="rq-btn rq-btn-primary d-none" id="rqSubmitBtn">
                    <i class="ti ti-send"></i> Submit Request
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const totalSteps = 4;
    let currentStep = 1;

    const steps = document.querySelectorAll('.rq-step');
    const indicators = document.querySelectorAll('.rq-progress-step');
    const backBtn = document.getElementById('rqBackBtn');
    const nextBtn = document.getElementById('rqNextBtn');
    const submitBtn = document.getElementById('rqSubmitBtn');

    const stepFieldMap = { 1: 'service_id', 2: 'client-details', 3: 'schedule' };

    function detectErrorStep() {
        for (let step = 1; step <= totalSteps; step++) {
            const stepEl = document.querySelector(`.rq-step[data-step="${step}"]`);
            if (stepEl && stepEl.querySelector('.rq-error')) return step;
        }
        return 1;
    }

    function showStep(step) {
        steps.forEach(s => s.classList.toggle('active', parseInt(s.dataset.step) === step));
        indicators.forEach(ind => {
            const n = parseInt(ind.dataset.stepIndicator);
            ind.classList.toggle('active', n === step);
            ind.classList.toggle('done', n < step);
        });

        backBtn.disabled = step === 1;
        nextBtn.classList.toggle('d-none', step === totalSteps);
        submitBtn.classList.toggle('d-none', step !== totalSteps);

        if (step === totalSteps) populateReview();
        currentStep = step;
    }

    function validateStep(step) {
        const stepEl = document.querySelector(`.rq-step[data-step="${step}"]`);
        const required = stepEl.querySelectorAll('[required]');

        if (step === 1) {
            const selected = stepEl.querySelector('input[name="service_id"]:checked');
            if (!selected) { alert('Please select a service to continue.'); return false; }
            return true;
        }

        for (const field of required) {
            if (!field.value.trim()) {
                field.focus();
                alert('Please fill in all required fields before continuing.');
                return false;
            }
        }
        return true;
    }

    function populateReview() {
        const selectedCard = document.querySelector('input[name="service_id"]:checked')?.closest('.rq-service-card');
        document.getElementById('reviewService').textContent = selectedCard?.querySelector('.rq-service-card-title')?.textContent.trim() || '—';
        document.getElementById('reviewName').textContent = document.querySelector('[name="full_name"]').value || '—';
        document.getElementById('reviewPhone').textContent = document.querySelector('[name="phone"]').value || '—';
        document.getElementById('reviewLocation').textContent = document.querySelector('[name="location"]').value || '—';

        const date = document.querySelector('[name="preferred_date"]').value;
        const time = document.querySelector('[name="preferred_time"]').value;
        document.getElementById('reviewDateTime').textContent = (date && time) ? `${date} at ${time}` : '—';
    }

    nextBtn.addEventListener('click', () => {
        if (!validateStep(currentStep)) return;
        if (currentStep < totalSteps) showStep(currentStep + 1);
    });

    backBtn.addEventListener('click', () => {
        if (currentStep > 1) showStep(currentStep - 1);
    });

    document.querySelectorAll('[data-service-card]').forEach(card => {
        card.addEventListener('click', () => {
            document.querySelectorAll('[data-service-card]').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            card.querySelector('input[type="radio"]').checked = true;
        });
        if (card.querySelector('input[type="radio"]').checked) card.classList.add('selected');
    });

    document.addEventListener('DOMContentLoaded', () => {
        showStep(detectErrorStep());
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
