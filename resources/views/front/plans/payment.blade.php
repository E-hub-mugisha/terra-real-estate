@extends('layouts.base')

@section('content')

<div class="container py-5">

    <h3>Plan Payment</h3>

    <div class="card p-4">

        <h4>{{ $order->plan->name }}</h4>

        <p>Price per day: ${{ $order->price_per_day }}</p>

        <p>Days: {{ $order->days }}</p>

        <hr>

        <h3>Total: ${{ $order->total_price }}</h3>

        <div class="mt-4">

            <button class="btn btn-success"
                data-bs-toggle="modal"
                data-bs-target="#momoModal">
                Pay Now (MoMo)
            </button>

            <a href="{{ route('dashboard') }}"
                class="btn btn-secondary">
                Pay Later
            </a>

        </div>

    </div>

</div>

<div class="modal fade" id="momoModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('plans.pay.momo') }}" class="modal-content">

            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="modal-header">
                <h5 class="modal-title">Mobile Money Payment</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <p class="text-muted">
                    Enter your MTN Mobile Money number.
                    A payment request will be sent.
                </p>

                <input type="text"
                    name="phone"
                    class="form-control"
                    placeholder="078XXXXXXX"
                    required>

                <small class="text-muted">
                    Payment Code: <strong>*182*8*1#</strong>
                    Merchant Code: <strong>511725</strong>
                </small>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success">
                    Confirm Payment
                </button>
            </div>

        </form>
    </div>
</div>
@endsection