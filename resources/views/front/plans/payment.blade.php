@extends('layouts.base')
@section('title', 'Plan Payment')
@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card shadow-lg border-0 checkout-card">

                <div class="card-body p-4">

                    <h4 class="fw-bold mb-4 text-center">
                        Plan Payment
                    </h4>

                    <!-- Plan Summary -->
                    <div class="plan-summary p-3 mb-4">

                        <h5 class="fw-bold mb-3">
                            {{ $order->plan->name }}
                        </h5>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Price per day</span>
                            <strong>${{ number_format($order->price_per_day) }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Days</span>
                            <strong>{{ $order->days }}</strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between total-row">
                            <span>Total Payment</span>
                            <strong class="text-success fs-4">
                                ${{ number_format($order->total_price) }}
                            </strong>
                        </div>

                    </div>


                    <!-- Payment Options -->

                    <div class="payment-options">

                        <button
                            class="btn btn-success w-100 mb-3 pay-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#momoModal">

                            Pay with Mobile Money

                        </button>

                        <a href="{{ route('dashboard') }}"
                            class="btn btn-outline-secondary w-100">

                            Pay Later

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<!-- Mobile Money Modal -->

<div class="modal fade" id="momoModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <form method="POST"
            action="{{ route('plans.pay.momo') }}"
            class="modal-content border-0 shadow">

            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="modal-header bg-success text-white">

                <h5 class="modal-title">
                    Mobile Money Payment
                </h5>

                <button class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>

            </div>


            <div class="modal-body">

                <p class="text-muted mb-3">

                    Enter your MTN Mobile Money number.
                    A payment request will be sent to your phone.

                </p>


                <div class="mb-3">

                    <label class="form-label">
                        Phone Number
                    </label>

                    <input type="text"
                        name="phone"
                        class="form-control form-control-lg"
                        placeholder="078XXXXXXX"
                        required>

                </div>


                <div class="payment-help p-3">

                    <small class="text-muted">

                        Dial: <strong>*182*8*1#</strong><br>
                        Merchant Code: <strong>511725</strong>

                    </small>

                </div>

            </div>


            <div class="modal-footer">

                <button class="btn btn-success w-100">

                    Confirm Payment

                </button>

            </div>

        </form>

    </div>

</div>



<style>
    .checkout-card {
        border-radius: 16px;
    }

    .plan-summary {
        background: #f8f9fa;
        border-radius: 12px;
    }

    .total-row {
        font-size: 18px;
        font-weight: 600;
    }

    .pay-btn {
        font-size: 16px;
        padding: 12px;
    }

    .payment-help {
        background: #f1f3f5;
        border-radius: 10px;
    }
</style>

@endsection