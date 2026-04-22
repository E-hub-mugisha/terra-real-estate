@extends('layouts.app')

@section('title', 'Complete Payment — Terra')

@section('content')

<style>
.checkout-hero { background: #051321; padding: 40px 0 30px; }
.ad-steps { display: flex; align-items: center; justify-content: center; gap: 0; margin-bottom: 0; }
.ad-step { display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 500; color: rgba(255,255,255,.4); }
.ad-step span { width: 28px; height: 28px; border-radius: 50%; background: rgba(255,255,255,.15); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; }
.ad-step.active { color: #fff; }
.ad-step.active span { background: #00a667; color: #fff; }
.ad-step.done { color: rgba(255,255,255,.7); }
.ad-step.done span { background: #00a667; color: #fff; }
.ad-step-line { width: 40px; height: 2px; background: rgba(255,255,255,.15); }
.ad-step-line.done { background: #00a667; }

.section-pad { padding: 60px 0; }
.container--narrow { max-width: 640px; }

.order-summary {
    background: #051321; border-radius: 14px; padding: 24px; margin-bottom: 24px; color: #fff;
}
.order-summary__title { font-size: 16px; font-weight: 700; margin-bottom: 16px; color: rgba(255,255,255,.7); text-transform: uppercase; letter-spacing: .06em; font-size: 12px; }
.order-summary__row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; font-size: 15px; color: rgba(255,255,255,.75); }
.order-summary__row strong { color: #fff; }
.order-summary__divider { height: 1px; background: rgba(255,255,255,.1); margin: 8px 0; }
.order-summary__row--total { font-size: 16px; }
.order-summary__amount { font-size: 24px; color: #00a667; }

.momo-instructions {
    background: #f0fdf8; border: 1.5px solid #a7f3d0; border-radius: 14px;
    padding: 24px; margin-bottom: 24px;
}
.momo-instructions__title {
    display: flex; align-items: center; gap: 10px;
    font-size: 17px; font-weight: 700; color: #051321; margin-bottom: 16px;
}
.momo-icon {
    width: 32px; height: 32px; background: #ffcc00; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 900; color: #051321; font-size: 14px; flex-shrink: 0;
}
.momo-steps { padding-left: 20px; margin: 0; }
.momo-steps li { font-size: 14px; color: #374151; padding: 6px 0; line-height: 1.6; }
.momo-steps code {
    background: #d1fae5; color: #065f46; padding: 2px 8px;
    border-radius: 4px; font-family: monospace; font-size: 13px;
}

.form-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 28px; }
.form-card__title { font-size: 17px; font-weight: 700; color: #051321; margin-bottom: 6px; }
.form-card__hint { font-size: 13px; color: #9ca3af; margin-bottom: 20px; }
.form-group { margin-bottom: 18px; }
.form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
.form-control { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box; }
.form-control:focus { outline: none; border-color: #00a667; box-shadow: 0 0 0 3px rgba(0,166,103,.1); }
.form-hint { font-size: 12px; color: #9ca3af; margin-top: 4px; display: block; }
.req { color: #ef4444; }
.optional { font-weight: 400; color: #9ca3af; font-size: 13px; }
.is-invalid { border-color: #ef4444; }
.invalid-feedback { font-size: 12px; color: #ef4444; margin-top: 4px; display: block; }

.checkout-actions { margin-top: 24px; }
.checkout-note { font-size: 13px; color: #6b7280; margin-bottom: 16px; line-height: 1.6; }
.btn-block { width: 100%; display: block; text-align: center; }
.btn-lg { padding: 14px; font-size: 16px; border-radius: 10px; border: none; cursor: pointer; font-weight: 700; }
.btn-primary { background: #00a667; color: #fff; }
.btn-primary:hover { background: #008f57; }

.alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
.alert-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
</style>

<section class="checkout-hero">
    <div class="container">
        <div class="ad-steps">
            <div class="ad-step done"><span>1</span> Choose Package</div>
            <div class="ad-step-line done"></div>
            <div class="ad-step done"><span>2</span> Ad Details</div>
            <div class="ad-step-line done"></div>
            <div class="ad-step active"><span>3</span> Payment</div>
        </div>
    </div>
</section>

<section class="checkout section-pad">
    <div class="container container--narrow">

        {{-- Order summary --}}
        <div class="order-summary">
            <h3 class="order-summary__title">Order Summary</h3>
            <div class="order-summary__row">
                <span>Ad Title</span>
                <strong>{{ $advertisement->title }}</strong>
            </div>
            <div class="order-summary__row">
                <span>Package</span>
                <strong>{{ $advertisement->package->name }}</strong>
            </div>
            <div class="order-summary__row">
                <span>Duration</span>
                <strong>{{ $advertisement->package->duration_days }} days</strong>
            </div>
            <div class="order-summary__row">
                <span>Media</span>
                <strong>
                    {{ count($advertisement->images ?? []) }} image(s)
                    @if($advertisement->video_path) + video @endif
                </strong>
            </div>
            <div class="order-summary__divider"></div>
            <div class="order-summary__row order-summary__row--total">
                <span>Total</span>
                <strong class="order-summary__amount">{{ number_format($advertisement->package->price) }} RWF</strong>
            </div>
        </div>

        {{-- MoMo instructions --}}
        <div class="momo-instructions">
            <h3 class="momo-instructions__title">
                <span class="momo-icon">M</span>
                Pay via Mobile Money
            </h3>

            <ol class="momo-steps">
                <li>
                    <strong>MTN MoMo</strong> — Dial <code>*182*1*1*250796511725#</code> or open the MoMo Pay app
                </li>
                <li>
                    <strong>Airtel Money</strong> — Dial <code>*183*1*250796511725#</code>
                </li>
                <li>
                    Enter amount: <strong>{{ number_format($advertisement->package->price) }} RWF</strong>
                </li>
                <li>
                    Use reference: <strong>TERRA-AD-{{ $advertisement->id }}</strong>
                </li>
                <li>
                    Complete the payment, then fill in the form below
                </li>
            </ol>
        </div>

        {{-- Payment submission form --}}
        <div class="form-card">
            <h3 class="form-card__title">Confirm Your Payment</h3>
            <p class="form-card__hint">Enter the MoMo number you paid from and your transaction ID so our team can verify quickly.</p>

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('advertisements.pay', $advertisement) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>MoMo Phone Number <span class="req">*</span></label>
                    <input type="text" name="momo_phone"
                           class="form-control @error('momo_phone') is-invalid @enderror"
                           value="{{ old('momo_phone') }}"
                           placeholder="07XXXXXXXX"
                           maxlength="10">
                    @error('momo_phone')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <span class="form-hint">The number used to make the MoMo payment</span>
                </div>

                <div class="form-group">
                    <label>Transaction ID <span class="optional">(recommended)</span></label>
                    <input type="text" name="momo_transaction_id"
                           class="form-control @error('momo_transaction_id') is-invalid @enderror"
                           value="{{ old('momo_transaction_id') }}"
                           placeholder="e.g. 1234567890">
                    @error('momo_transaction_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <span class="form-hint">From your MoMo confirmation SMS — helps us activate faster</span>
                </div>

                <div class="checkout-actions">
                    <p class="checkout-note">
                        Our team will verify your payment and activate your ad — usually within 2–4 hours.
                    </p>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Submit Payment Confirmation
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>

@endsection
