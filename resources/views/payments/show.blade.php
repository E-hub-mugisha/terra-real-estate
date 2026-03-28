{{-- resources/views/payments/show.blade.php --}}
@extends('layouts.base')

@section('title', 'Complete Payment — Terra')
@section('content')

<style>
    :root {
        --gold: #C8873A;
        --gold-light: rgba(200,135,58,.12);
        --dark: #0d0d0d;
    }

    .pay-wrap {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        background: radial-gradient(ellipse at top left, rgba(200,135,58,.06) 0%, transparent 60%);
    }

    .pay-card {
        width: 100%;
        max-width: 520px;
        background: #fff;
        border: 1px solid rgba(200,135,58,.2);
        border-radius: 4px;
        box-shadow: 0 24px 64px rgba(0,0,0,.08);
        overflow: hidden;
    }

    .pay-header {
        background: var(--dark);
        padding: 2rem 2rem 1.5rem;
        border-bottom: 2px solid var(--gold);
    }
    .pay-header .eyebrow {
        font-family: 'DM Sans', sans-serif;
        font-size: .7rem;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: .5rem;
    }
    .pay-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.7rem;
        font-weight: 600;
        color: #fff;
        margin: 0;
        line-height: 1.2;
    }

    .pay-summary {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #f0ebe3;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: 'DM Sans', sans-serif;
        font-size: .85rem;
        color: #777;
        margin-bottom: .5rem;
    }
    .summary-row span:last-child { color: #111; font-weight: 500; }
    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--dark);
        border-top: 1px solid #e8e0d4;
        padding-top: .75rem;
        margin-top: .75rem;
    }
    .summary-total .amount { color: var(--gold); }

    .pay-form { padding: 1.5rem 2rem 2rem; }

    .method-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .6rem;
        margin-bottom: 1.5rem;
    }
    .method-btn {
        position: relative;
        border: 1.5px solid #ddd;
        border-radius: 4px;
        padding: .75rem .5rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        background: #fafafa;
    }
    .method-btn input[type=radio] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    .method-btn:has(input:checked) {
        border-color: var(--gold);
        background: var(--gold-light);
    }
    .method-icon { font-size: 1.4rem; display: block; margin-bottom: .25rem; }
    .method-label {
        font-family: 'DM Sans', sans-serif;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .04em;
        color: #444;
    }

    .phone-field { display: none; margin-bottom: 1.25rem; }
    .phone-field.visible { display: block; }
    .phone-field label {
        display: block;
        font-family: 'DM Sans', sans-serif;
        font-size: .75rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #888;
        margin-bottom: .4rem;
    }
    .phone-field input {
        width: 100%;
        border: 1.5px solid #ddd;
        border-radius: 4px;
        padding: .65rem .9rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        outline: none;
        transition: border-color .2s;
    }
    .phone-field input:focus { border-color: var(--gold); }

    .btn-pay {
        width: 100%;
        background: var(--gold);
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: .9rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .85rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        cursor: pointer;
        transition: opacity .2s;
    }
    .btn-pay:hover { opacity: .88; }

    .pay-note {
        text-align: center;
        font-family: 'DM Sans', sans-serif;
        font-size: .72rem;
        color: #aaa;
        margin-top: 1rem;
        line-height: 1.5;
    }
    .ref-badge {
        display: inline-block;
        background: #f5f0e8;
        color: var(--gold);
        font-family: monospace;
        font-size: .75rem;
        padding: .2rem .5rem;
        border-radius: 3px;
    }
</style>


<div class="pay-wrap">
    <div class="pay-card">

        {{-- Header --}}
        <div class="pay-header">
            <p class="eyebrow">Terra Real Estate Rwanda</p>
            <h1>Complete Your Payment</h1>
        </div>

        {{-- Summary --}}
        <div class="pay-summary">
            <div class="summary-row">
                <span>Reference</span>
                <span><span class="ref-badge">{{ $payment->reference }}</span></span>
            </div>
            <div class="summary-row">
                <span>Listing type</span>
                <span>{{ $payment->payableLabel() }}</span>
            </div>
            @if($payment->payable)
            <div class="summary-row">
                <span>Property</span>
                <span>{{ $payment->payable->title }}</span>
            </div>
            @endif
            <div class="summary-row">
                <span>Purpose</span>
                <span>{{ ucwords(str_replace('_', ' ', $payment->payment_purpose)) }}</span>
            </div>
            <div class="summary-total">
                <span>Total Due</span>
                <span class="amount">{{ number_format($payment->amount, 0) }} {{ $payment->currency }}</span>
            </div>
        </div>

        {{-- Form --}}
        <form class="pay-form" method="POST" action="{{ route('payment.initiate', $payment->reference) }}">
            @csrf

            @if($errors->any())
                <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
            @endif

            <p style="font-family:'DM Sans',sans-serif;font-size:.8rem;color:#666;margin-bottom:1rem;">
                Select your preferred payment method:
            </p>

            <div class="method-grid">
                <label class="method-btn">
                    <input type="radio" name="payment_method" value="momo" checked>
                    <span class="method-icon">📱</span>
                    <span class="method-label">MoMo</span>
                </label>
                <label class="method-btn">
                    <input type="radio" name="payment_method" value="card">
                    <span class="method-icon">💳</span>
                    <span class="method-label">Card</span>
                </label>
                <label class="method-btn">
                    <input type="radio" name="payment_method" value="bank_transfer">
                    <span class="method-icon">🏦</span>
                    <span class="method-label">Bank</span>
                </label>
            </div>

            {{-- Phone field for MoMo --}}
            <div class="phone-field visible" id="phoneField">
                <label>MoMo Phone Number</label>
                <input type="text"
                       name="phone_number"
                       placeholder="+250 7XX XXX XXX"
                       value="{{ old('phone_number', auth()->user()->phone ?? '') }}">
            </div>

            <button type="submit" class="btn-pay">Pay {{ number_format($payment->amount, 0) }} {{ $payment->currency }}</button>

            <p class="pay-note">
                Your listing will be published immediately after payment is confirmed.<br>
                Need help? Contact us at <strong>support@terra.rw</strong>
            </p>
        </form>

    </div>
</div>

<script>
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', () => {
            const phoneField = document.getElementById('phoneField');
            phoneField.classList.toggle('visible', radio.value === 'momo');
        });
    });
</script>
@endsection
