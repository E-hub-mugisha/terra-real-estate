@extends('layouts.base')
@section('title', 'Payment – Request a Consultant')

@section('content')
<style>
    .fee-summary {
        background: #f9fafb;
        border-radius: 10px;
        padding: 1rem 1.25rem;
        border: 1px solid #e5e7eb;
    }

    .fee-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        padding: 4px 0;
        color: #374151;
    }

    .fee-row.total {
        font-weight: 600;
        font-size: 16px;
        border-top: 1px solid #e5e7eb;
        padding-top: 10px;
        margin-top: 6px;
        color: #1a1a1a;
    }

    .pay-methods {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .pay-method {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        cursor: pointer;
        transition: all .15s;
        background: #fff;
    }

    .pay-method:hover {
        border-color: #D05208;
        background: #f9fefe;
    }

    .pay-method.selected {
        border-color: #D05208;
        background: #f0fdf6;
    }

    .pay-icon {
        font-size: 22px;
        flex-shrink: 0;
    }

    .pay-name {
        font-size: 14px;
        font-weight: 500;
        color: #1a1a1a;
    }

    .pay-sub {
        font-size: 12px;
        color: #6b7280;
    }

    .pay-check {
        margin-left: auto;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #D05208;
        color: #fff;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .pay-method.selected .pay-check {
        display: flex;
    }

    .info-box {
        background: #f0fdf6;
        border: 1px solid #bbf0d9;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 13px;
        color: #0F6E56;
    }
</style>

<div class="terra-wizard-container">
    @include('consultant.partials.wizard-layout', ['currentStep' => 6])

    <form method="POST" action="{{ route('consultant.step6.post') }}" id="payForm">
        @csrf
        <input type="hidden" name="payment_method" id="paymentMethod" value="{{ old('payment_method') }}">

        <div class="wizard-card">
            <h2>Payment</h2>
            <p class="wizard-subtitle">A small booking fee confirms your appointment slot and is non-refundable.</p>

            {{-- Fee summary --}}
            <div class="fee-summary mb-4">
                <div class="fee-row">
                    <span>Consultation booking fee</span>
                    <span>{{ number_format($fee) }} RWF</span>
                </div>
                <div class="fee-row total">
                    <span>Total</span>
                    <span>{{ number_format($fee) }} RWF</span>
                </div>
            </div>

            <p style="font-size:13px;color:#6b7280;margin-bottom:1rem;">Choose payment method</p>

            <div class="pay-methods mb-4">
                {{-- MTN MoMo --}}
                <div class="pay-method {{ old('payment_method') === 'momo' ? 'selected' : '' }}"
                    data-method="momo" onclick="selectPayment('momo', this)">
                    <span class="pay-icon">📱</span>
                    <div>
                        <div class="pay-name">MTN MoMo Pay</div>
                        <div class="pay-sub">Receive a push prompt on your phone</div>
                    </div>
                    <span class="pay-check">✓</span>
                </div>

                {{-- Airtel Money --}}
                <div class="pay-method {{ old('payment_method') === 'airtel' ? 'selected' : '' }}"
                    data-method="airtel" onclick="selectPayment('airtel', this)">
                    <span class="pay-icon">📲</span>
                    <div>
                        <div class="pay-name">Airtel Money</div>
                        <div class="pay-sub">Pay via Airtel mobile money</div>
                    </div>
                    <span class="pay-check">✓</span>
                </div>

                {{-- Card --}}
                <div class="pay-method {{ old('payment_method') === 'card' ? 'selected' : '' }}"
                    data-method="card" onclick="selectPayment('card', this)">
                    <span class="pay-icon">💳</span>
                    <div>
                        <div class="pay-name">Visa / Mastercard</div>
                        <div class="pay-sub">Secure card payment</div>
                    </div>
                    <span class="pay-check">✓</span>
                </div>
            </div>

            {{-- replace the two separate payment_reference inputs with this --}}

            {{-- Single hidden field that receives the value before submit --}}
            <input type="hidden" name="payment_reference" id="paymentReference" value="{{ old('payment_reference') }}">

            {{-- MoMo / Airtel fields --}}
            <div id="momoFields" style="{{ in_array(old('payment_method'), ['momo','airtel']) ? '' : 'display:none' }}">
                <div class="mb-3">
                    <label class="form-label" id="momoLabel">MTN phone number</label>
                    {{-- no name attribute --}}
                    <input type="tel" id="momoPhone"
                        class="form-control @error('payment_reference') is-invalid @enderror"
                        placeholder="+250 7XX XXX XXX"
                        value="{{ in_array(old('payment_method'), ['momo','airtel']) ? old('payment_reference') : '' }}">
                    @error('payment_reference')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="info-box">
                    📲 You will receive a payment prompt on your phone. Enter your PIN to confirm the
                    <strong>{{ number_format($fee) }} RWF</strong> payment.
                </div>
            </div>

            {{-- Card fields --}}
            <div id="cardFields" style="{{ old('payment_method') === 'card' ? '' : 'display:none' }}">
                <div class="mb-3">
                    <label class="form-label">Card number</label>
                    {{-- no name attribute --}}
                    <input type="text" id="cardNumber"
                        class="form-control @error('payment_reference') is-invalid @enderror"
                        placeholder="1234 5678 9012 3456" maxlength="19"
                        value="{{ old('payment_method') === 'card' ? old('payment_reference') : '' }}">
                    @error('payment_reference')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">Expiry</label>
                        <input type="text" class="form-control" placeholder="MM/YY" maxlength="5">
                    </div>
                    <div class="col-6">
                        <label class="form-label">CVV</label>
                        <input type="text" class="form-control" placeholder="123" maxlength="4">
                    </div>
                </div>
                <div class="info-box mt-3">🔒 Your card details are encrypted and secure.</div>
            </div>

        </div>

        <div class="wizard-actions">
            <a href="{{ route('consultant.step5') }}" class="btn-back-link">← Back</a>
            <button type="submit" id="btnPay" class="btn-terra" {{ old('payment_method') ? '' : 'disabled' }}>
                Pay {{ number_format($fee) }} RWF →
            </button>
        </div>
    </form>
</div>

<script>
    function selectPayment(method, el) {
        document.querySelectorAll('.pay-method').forEach(m => m.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('paymentMethod').value = method;
        document.getElementById('btnPay').disabled = false;

        const momoFields = document.getElementById('momoFields');
        const cardFields = document.getElementById('cardFields');
        const momoLabel = document.getElementById('momoLabel');

        momoFields.style.display = (method === 'momo' || method === 'airtel') ? 'block' : 'none';
        cardFields.style.display = method === 'card' ? 'block' : 'none';

        if (method === 'airtel') momoLabel.textContent = 'Airtel phone number';
        if (method === 'momo') momoLabel.textContent = 'MTN phone number';

        // Clear reference when switching methods so stale value doesn't carry over
        document.getElementById('paymentReference').value = '';
        document.getElementById('momoPhone').value = '';
        document.getElementById('cardNumber').value = '';
    }

    document.getElementById('payForm').addEventListener('submit', function(e) {
        const method = document.getElementById('paymentMethod').value;
        let ref = '';

        if (method === 'momo' || method === 'airtel') {
            ref = document.getElementById('momoPhone').value.trim();
            if (!ref) {
                e.preventDefault();
                document.getElementById('momoPhone').focus();
                document.getElementById('momoPhone').classList.add('is-invalid');
                return;
            }
        } else if (method === 'card') {
            ref = document.getElementById('cardNumber').value.replace(/\s+/g, '').trim();
            if (!ref) {
                e.preventDefault();
                document.getElementById('cardNumber').focus();
                document.getElementById('cardNumber').classList.add('is-invalid');
                return;
            }
        }

        document.getElementById('paymentReference').value = ref;
    });

    document.addEventListener('DOMContentLoaded', function() {
        const old = document.getElementById('paymentMethod').value;
        if (old) {
            const el = document.querySelector(`[data-method="${old}"]`);
            if (el) el.classList.add('selected');
            // Restore visibility without clearing the old reference value
            document.getElementById('momoFields').style.display =
                (old === 'momo' || old === 'airtel') ? 'block' : 'none';
            document.getElementById('cardFields').style.display =
                old === 'card' ? 'block' : 'none';
            document.getElementById('btnPay').disabled = false;
        }
    });
</script>

@endsection