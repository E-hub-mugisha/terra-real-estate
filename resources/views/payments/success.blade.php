{{-- resources/views/payments/success.blade.php --}}
@extends('layouts.base')
@section('title', 'Payment Successful — Terra')

@section('content')

<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:3rem 1rem;">
    <div style="max-width:480px;width:100%;text-align:center;">

        <div style="width:72px;height:72px;background:#C8873A;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;font-size:2rem;">
            ✓
        </div>

        <p style="font-family:'DM Sans',sans-serif;font-size:.7rem;letter-spacing:.18em;text-transform:uppercase;color:#C8873A;margin-bottom:.5rem;">
            Payment Confirmed
        </p>
        <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.2rem;font-weight:600;color:#0d0d0d;margin-bottom:1rem;">
            Your listing is now live
        </h1>
        <p style="font-family:'DM Sans',sans-serif;font-size:.9rem;color:#666;line-height:1.7;margin-bottom:2rem;">
            Payment of <strong>{{ number_format($payment->amount, 0) }} {{ $payment->currency }}</strong>
            received for <strong>{{ $payment->payableLabel() }}</strong>.<br>
            Reference: <code style="background:#f5f0e8;color:#C8873A;padding:.1rem .4rem;border-radius:3px;">{{ $payment->reference }}</code>
        </p>

        @if($payment->payable && $viewRoute)
        <a href="{{ $viewRoute }}"
            style="display:inline-block;background:#C8873A;color:#fff;padding:.75rem 2rem;border-radius:4px;font-family:'DM Sans',sans-serif;font-size:.8rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;">
            View Listing →
        </a>
        @endif

        <p style="margin-top:1.5rem;">
            <a href="{{ route('front.home') }}"
                style="font-family:'DM Sans',sans-serif;font-size:.8rem;color:#999;text-decoration:none;">
                ← Go to Home
            </a>
        </p>

    </div>
</div>
@endsection