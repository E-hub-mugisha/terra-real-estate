{{-- resources/views/payments/pending.blade.php --}}
@extends('layouts.base')

@section('title', 'Confirm Payment — Terra')

@section('content')
<style>
    :root { --gold: #D05208; --dark: #19265D; }

    .pending-wrap {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        background: radial-gradient(ellipse at top left, rgba(208, 82, 8,.06) 0%, transparent 60%);
    }

    .pending-card {
        width: 100%;
        max-width: 480px;
        background: #FFFFFF;
        border: 1px solid rgba(208, 82, 8,.2);
        border-radius: 4px;
        box-shadow: 0 24px 64px rgba(25, 38, 93,.08);
        overflow: hidden;
    }

    .pending-header {
        background: var(--dark);
        padding: 1.75rem 2rem;
        border-bottom: 2px solid var(--gold);
    }
    .eyebrow {
        font-family: 'DM Sans', sans-serif;
        font-size: .7rem;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: .4rem;
    }
    .pending-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.7rem;
        font-weight: 600;
        color: #FFFFFF;
        margin: 0;
    }

    .pending-body { padding: 2rem; }

    .info-box {
        background: #FDF6F3;
        border-left: 3px solid var(--gold);
        border-radius: 0 4px 4px 0;
        padding: .9rem 1rem;
        margin-bottom: 1.75rem;
    }
    .info-box p {
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        color: #19265D;
        line-height: 1.6;
        margin: 0;
    }
    .info-box strong { color: var(--dark); }

    .field-label {
        display: block;
        font-family: 'DM Sans', sans-serif;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #636B91;
        margin-bottom: .4rem;
    }
    .field-input {
        width: 100%;
        border: 1.5px solid #EAEBF0;
        border-radius: 4px;
        padding: .7rem .9rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        outline: none;
        transition: border-color .2s;
        margin-bottom: 1.25rem;
    }
    .field-input:focus { border-color: var(--gold); }

    .btn-confirm {
        width: 100%;
        background: var(--gold);
        color: #FFFFFF;
        border: none;
        border-radius: 4px;
        padding: .85rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        cursor: pointer;
        transition: opacity .2s;
    }
    .btn-confirm:hover { opacity: .85; }

    .ref-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: 'DM Sans', sans-serif;
        font-size: .8rem;
        color: #636B91;
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid #FAEEE6;
    }
    .ref-badge {
        background: #FDF6F3;
        color: var(--gold);
        font-family: monospace;
        font-size: .78rem;
        padding: .2rem .5rem;
        border-radius: 3px;
    }
</style>

<div class="pending-wrap">
    <div class="pending-card">

        <div class="pending-header">
            <p class="eyebrow">Terra Real Estate Rwanda</p>
            <h1>Confirm Your Payment</h1>
        </div>

        <div class="pending-body">

            @if(session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
            @endif

            <div class="info-box">
                <p>
                    Send <strong>{{ number_format($payment->amount, 0) }} {{ $payment->currency }}</strong>
                    via <strong>{{ strtoupper($payment->payment_method) }}</strong>
                    @if($payment->phone_number)
                        to <strong>{{ $payment->phone_number }}</strong>
                    @endif
                    , then paste your transaction ID below to confirm.
                </p>
            </div>

            <form method="POST" action="{{ route('payment.confirm', $payment->reference) }}">
                @csrf

                <label class="field-label" for="transaction_id">Transaction ID</label>
                <input
                    class="field-input"
                    type="text"
                    id="transaction_id"
                    name="transaction_id"
                    placeholder="e.g. 1234567890"
                    value="{{ old('transaction_id') }}"
                    required
                    autofocus
                >

                <label class="field-label" for="note">Note <span style="font-weight:400;text-transform:none;letter-spacing:0">(optional)</span></label>
                <input
                    class="field-input"
                    type="text"
                    id="note"
                    name="note"
                    placeholder="Any extra reference or note"
                    value="{{ old('note') }}"
                >

                <button type="submit" class="btn-confirm">Confirm Payment</button>
            </form>

            <div class="ref-row">
                <span>Terra reference</span>
                <span class="ref-badge">{{ $payment->reference }}</span>
            </div>

            <p style="text-align:center;margin-top:1.25rem;">
                <a href="{{ route('payment.show', $payment->reference) }}"
                   style="font-family:'DM Sans',sans-serif;font-size:.78rem;color:#A3A8BE;text-decoration:none;">
                    ← Change payment method
                </a>
            </p>

        </div>
    </div>
</div>
@endsection