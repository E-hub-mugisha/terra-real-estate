@extends('layouts.app')
@section('title', 'Complete Payment — ' . $job->title)

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
        --radius-card: 14px;
        --shadow-card: 0 2px 12px rgba(0,0,0,.07);
        --transition: .22s cubic-bezier(.4,0,.2,1);
    }

    body { background: var(--clr-bg); font-family: 'DM Sans', sans-serif; }

    .page-header {
        background: var(--clr-surface);
        border-bottom: 1px solid var(--clr-border);
        padding: 100px 0 28px;
    }

    .page-header h1 {
        font-family: 'DM Serif Display', serif;
        font-size: 1.8rem;
        color: var(--clr-text);
        font-weight: 400;
        margin-bottom: 4px;
    }

    .page-header p { color: var(--clr-muted); font-size: .88rem; }

    /* ── Steps ── */
    .steps { display: flex; gap: 0; margin-bottom: 32px; }
    .step {
        display: flex; align-items: center; gap: 8px;
        font-size: .8rem; font-weight: 600; color: var(--clr-muted);
        padding-right: 24px; position: relative;
    }
    .step::after { content: '→'; position: absolute; right: 8px; color: var(--clr-border); }
    .step:last-child::after { display: none; }
    .step.done .step-num   { background: var(--clr-job); color: #fff; }
    .step.active .step-num { background: var(--clr-accent); color: #fff; }
    .step.active { color: var(--clr-accent); }
    .step.done   { color: var(--clr-job); }
    .step-num {
        width: 24px; height: 24px; border-radius: 50%;
        background: var(--clr-border);
        display: flex; align-items: center; justify-content: center;
        font-size: .72rem; font-weight: 700; flex-shrink: 0;
    }

    /* ── Cards ── */
    .pay-card {
        background: var(--clr-surface);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-card);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .pay-card-header {
        padding: 16px 22px;
        border-bottom: 1px solid var(--clr-border);
        background: var(--clr-bg);
        font-size: .85rem;
        font-weight: 700;
        color: var(--clr-text);
    }

    .pay-card-body { padding: 22px; }

    /* ── Order Summary ── */
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid var(--clr-border);
        font-size: .85rem;
    }

    .summary-row:last-child { border-bottom: none; }
    .summary-row .label { color: var(--clr-muted); }
    .summary-row .value { font-weight: 600; color: var(--clr-text); }
    .summary-row.total .label { font-weight: 700; color: var(--clr-text); font-size: .9rem; }
    .summary-row.total .value { font-size: 1.2rem; font-weight: 700; color: var(--clr-accent); }

    /* ── Payment methods ── */
    .method-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 10px; margin-bottom: 20px; }

    .method-radio { display: none; }

    .method-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 16px 12px;
        border: 2px solid var(--clr-border);
        border-radius: 10px;
        cursor: pointer;
        transition: all var(--transition);
        background: var(--clr-bg);
        text-align: center;
    }

    .method-label:hover { border-color: var(--clr-accent); }
    .method-radio:checked + .method-label { border-color: var(--clr-accent); background: #FEF3E2; }

    .method-icon { font-size: 1.6rem; }
    .method-name { font-size: .78rem; font-weight: 700; color: var(--clr-text); }
    .method-desc { font-size: .7rem; color: var(--clr-muted); }

    /* ── Reference input ── */
    .form-label { font-size: .82rem; font-weight: 600; color: var(--clr-text); margin-bottom: 6px; }

    .form-control {
        border: 1.5px solid var(--clr-border);
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: .88rem;
        color: var(--clr-text);
        background: var(--clr-bg);
        transition: border-color var(--transition);
        padding: 9px 12px;
    }

    .form-control:focus { outline: none; border-color: var(--clr-accent); background: #fff; box-shadow: 0 0 0 3px rgba(208,82,8,.08); }

    /* ── Payment instructions ── */
    .pay-instruction {
        background: var(--clr-job);
        color: #fff;
        border-radius: 10px;
        padding: 18px 20px;
        margin-bottom: 16px;
        display: none;
    }

    .pay-instruction.visible { display: block; }
    .pay-instruction h4 { font-size: .85rem; font-weight: 700; margin-bottom: 10px; }
    .pay-instruction p  { font-size: .82rem; color: rgba(255,255,255,.8); margin: 0; line-height: 1.6; }
    .pay-instruction code {
        background: rgba(255,255,255,.15);
        padding: 2px 7px;
        border-radius: 4px;
        font-family: monospace;
        font-size: .85rem;
    }

    /* ── Submit ── */
    .submit-btn {
        width: 100%;
        padding: 14px;
        background: var(--clr-accent);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: .95rem;
        font-weight: 700;
        cursor: pointer;
        transition: background var(--transition), transform var(--transition);
    }

    .submit-btn:hover { background: #A06828; transform: translateY(-1px); }

    /* ── Job preview card ── */
    .job-preview {
        background: var(--clr-text);
        border-radius: 12px;
        padding: 20px;
        color: #fff;
    }

    .job-preview .label { font-size: .68rem; text-transform: uppercase; letter-spacing: .08em; color: rgba(255,255,255,.4); margin-bottom: 4px; }
    .job-preview .val   { font-size: .88rem; font-weight: 600; color: #fff; margin-bottom: 14px; }
    .job-preview .val:last-child { margin-bottom: 0; }

    .expires-info {
        background: rgba(255,255,255,.06);
        border-radius: 8px;
        padding: 12px 14px;
        margin-top: 14px;
        font-size: .78rem;
        color: rgba(255,255,255,.6);
    }

    .expires-info strong { color: #FFD166; }
</style>

@section('content')

<div class="page-header">
    <div class="container">
        <h1>Complete Payment</h1>
        <p>Your listing is ready — one step to go live</p>
    </div>
</div>

<div class="container py-5">

    {{-- Steps ── --}}
    <div class="steps mb-4">
        <div class="step done"><span class="step-num">✓</span> Job Details</div>
        <div class="step done"><span class="step-num">✓</span> Choose Package</div>
        <div class="step active"><span class="step-num">3</span> Payment</div>
        <div class="step"><span class="step-num">4</span> Live</div>
    </div>

    @if(session('error'))
    <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="row g-4">

        {{-- LEFT — Payment form ── --}}
        <div class="col-lg-7">

            {{-- Order Summary ── --}}
            <div class="pay-card">
                <div class="pay-card-header">📋 Order Summary</div>
                <div class="pay-card-body">
                    <div class="summary-row">
                        <span class="label">Job Title</span>
                        <span class="value">{{ $job->title }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Company</span>
                        <span class="value">{{ $job->company_name }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Package</span>
                        <span class="value">{{ $job->package->tier_label }} ({{ number_format($job->package->price_per_day) }} RWF/day)</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Duration</span>
                        <span class="value">{{ $job->days_purchased }} days</span>
                    </div>
                    <div class="summary-row total">
                        <span class="label">Total Amount</span>
                        <span class="value">{{ number_format($job->total_amount) }} RWF</span>
                    </div>
                </div>
            </div>

            {{-- Payment Method ── --}}
            <div class="pay-card">
                <div class="pay-card-header">💳 Payment Method</div>
                <div class="pay-card-body">
                    <form method="POST" action="{{ route('admin.job-listings.payment.confirm', $job) }}">
                        @csrf

                        <div class="method-grid">
                            <div>
                                <input type="radio" name="payment_method" id="momo"
                                    value="momo" class="method-radio" {{ old('payment_method') === 'momo' ? 'checked' : '' }}>
                                <label for="momo" class="method-label">
                                    <span class="method-icon">📱</span>
                                    <span class="method-name">MTN MoMo</span>
                                    <span class="method-desc">Mobile Money</span>
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="payment_method" id="bank"
                                    value="bank_transfer" class="method-radio" {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}>
                                <label for="bank" class="method-label">
                                    <span class="method-icon">🏦</span>
                                    <span class="method-name">Bank Transfer</span>
                                    <span class="method-desc">Direct transfer</span>
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="payment_method" id="card"
                                    value="card" class="method-radio" {{ old('payment_method') === 'card' ? 'checked' : '' }}>
                                <label for="card" class="method-label">
                                    <span class="method-icon">💳</span>
                                    <span class="method-name">Card</span>
                                    <span class="method-desc">Visa / Mastercard</span>
                                </label>
                            </div>
                        </div>

                        {{-- Dynamic instructions ── --}}
                        <div class="pay-instruction" id="instr-momo">
                            <h4>MTN MoMo Instructions</h4>
                            <p>
                                Send <code>{{ number_format($job->total_amount) }} RWF</code> to:<br>
                                MoMo Number: <code>+250 7XX XXX XXX</code><br>
                                Name: <strong>Terra Platform Ltd</strong><br>
                                After payment, enter the transaction ID below.
                            </p>
                        </div>

                        <div class="pay-instruction" id="instr-bank">
                            <h4>Bank Transfer Instructions</h4>
                            <p>
                                Transfer <code>{{ number_format($job->total_amount) }} RWF</code> to:<br>
                                Bank: <strong>Bank of Kigali</strong><br>
                                Account: <code>000-XXXX-XXXX</code><br>
                                Name: <strong>Terra Platform Ltd</strong><br>
                                Reference: <code>JOB-{{ $job->id }}</code><br>
                                Enter the reference/transaction number below.
                            </p>
                        </div>

                        <div class="pay-instruction" id="instr-card">
                            <h4>Card Payment</h4>
                            <p>
                                Enter your card details on the next screen. You will be redirected to our secure payment gateway. Enter your transaction ID below after completing payment.
                            </p>
                        </div>

                        {{-- Reference ── --}}
                        <div class="mb-4">
                            <label class="form-label">Transaction / Reference Number <span class="text-danger">*</span></label>
                            <input type="text" name="payment_reference" class="form-control"
                                value="{{ old('payment_reference') }}"
                                placeholder="e.g. 1234567890 or BK-REF-2025" required>
                            <div style="font-size:.75rem;color:var(--clr-muted);margin-top:4px">
                                Enter the transaction ID or reference you received after payment.
                            </div>
                        </div>

                        <button type="submit" class="submit-btn">
                            ✓ Confirm Payment & Activate Listing
                        </button>

                        <p style="font-size:.75rem;color:var(--clr-muted);text-align:center;margin-top:12px">
                            Our team will verify your payment and activate your listing within 1 hour.
                        </p>
                    </form>
                </div>
            </div>

        </div>

        {{-- RIGHT — Listing Preview ── --}}
        <div class="col-lg-5">
            <div style="position:sticky;top:80px">
                <div class="job-preview">
                    <div class="label">Listing Preview</div>
                    <div class="val" style="font-size:1rem;font-family:'DM Serif Display',serif;font-weight:400">{{ $job->title }}</div>
                    <div class="label">Company</div>
                    <div class="val">{{ $job->company_name }}</div>
                    <div class="label">Location</div>
                    <div class="val">{{ $job->location }}</div>
                    <div class="label">Job Type</div>
                    <div class="val">{{ $job->job_type_label }}</div>
                    <div class="label">Salary</div>
                    <div class="val">{{ $job->salary_range }}</div>

                    <div class="expires-info">
                        After payment, your listing goes <strong>live immediately</strong> and will be active for <strong>{{ $job->days_purchased }} days</strong>, expiring on <strong>{{ now()->addDays($job->days_purchased)->format('d M Y') }}</strong>.
                    </div>
                </div>

                <div style="margin-top:14px;padding:14px;border:1px solid var(--clr-border);border-radius:10px;background:var(--clr-surface)">
                    <p style="font-size:.75rem;color:var(--clr-muted);margin:0;line-height:1.6">
                        🔒 Payments are verified manually by our team. If you have issues, contact us at <strong>support@terra.rw</strong> with your reference number <strong>JOB-{{ $job->id }}</strong>.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
(function () {
    const methods = document.querySelectorAll('.method-radio');
    const instrs  = { momo: document.getElementById('instr-momo'), bank_transfer: document.getElementById('instr-bank'), card: document.getElementById('instr-card') };

    function updateInstructions() {
        const checked = document.querySelector('.method-radio:checked');
        Object.values(instrs).forEach(el => el?.classList.remove('visible'));
        if (checked && instrs[checked.value]) instrs[checked.value].classList.add('visible');
    }

    methods.forEach(m => m.addEventListener('change', updateInstructions));
    updateInstructions();
})();
</script>

@endsection