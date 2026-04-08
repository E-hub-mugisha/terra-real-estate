@extends('layouts.app')
@section('title', 'Submit Payment')

@section('content')
<div class="container py-4" style="max-width:620px">
    <div class="card border-0 shadow-sm" style="border-radius:14px;overflow:hidden">
        <div class="p-4" style="background:#19265d;color:#fff">
            <h4 class="mb-1" style="font-family:'Cormorant Garamond',serif;font-size:1.6rem">Payment Required</h4>
            <p class="mb-0 opacity-75 small">Submit your MoMo payment details to activate your ad</p>
        </div>
        <div class="card-body p-4">

            {{-- Cost Summary --}}
            <div class="rounded-3 p-3 mb-4" style="background:#fff8f5;border:1px solid #f0ddd3">
                <div class="fw-semibold mb-2" style="color:#19265d">Order Summary</div>
                <div class="d-flex justify-content-between small mb-1">
                    <span class="text-muted">Package</span>
                    <span>{{ $advertisement->listingPackage?->tier_label ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between small mb-1">
                    <span class="text-muted">Duration</span>
                    <span>{{ $advertisement->listing_days }} days</span>
                </div>
                <div class="d-flex justify-content-between small mb-1">
                    <span class="text-muted">Price/day</span>
                    <span>{{ number_format($advertisement->listingPackage?->price_per_day) }} RWF</span>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total</span>
                    <span style="color:#D05208;font-size:1.2rem">{{ $advertisement->formatted_total }}</span>
                </div>
            </div>

            {{-- MoMo Instructions --}}
            <div class="alert alert-info small mb-4">
                <strong>How to pay via MoMo:</strong><br>
                Dial <strong>*182*8*1*0788XXXXXX*{{ $advertisement->total_cost }}#</strong> or send to our MoMo number, then enter your transaction ID below.
            </div>

            @if($errors->any())
                <div class="alert alert-danger small">
                    @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('advertisements.submit-payment', $advertisement) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">MoMo Phone Number Used</label>
                    <input type="text" name="momo_phone" class="form-control" value="{{ old('momo_phone') }}"
                        placeholder="+250 7XX XXX XXX" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">MoMo Transaction ID</label>
                    <input type="text" name="momo_transaction_id" class="form-control" value="{{ old('momo_transaction_id') }}"
                        placeholder="e.g. TXN123456789" required>
                </div>
                <button type="submit" class="btn w-100 py-2 fw-bold" style="background:#D05208;color:#fff;border-radius:8px">
                    Submit Payment for Review
                </button>
            </form>
        </div>
    </div>
</div>
@endsection