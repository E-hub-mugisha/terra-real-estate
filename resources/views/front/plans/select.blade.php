@extends('layouts.base')
@section('title', 'Select Plan')
@section('content')

<div class="container py-5">

    <h2 class="text-center fw-bold mb-5">Choose Your Listing Plan</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row g-4">

        @foreach($plans as $plan)

        <div class="col-lg-4 col-md-6">

            <div class="card plan-card shadow-lg border-0 text-center p-4 h-100">

                <h4 class="fw-bold mb-3">{{ $plan->name }}</h4>

                <h2 class="text-primary fw-bold">
                    {{ number_format($plan->price_per_day) }} RWF
                </h2>

                <p class="text-muted mb-4">per day</p>

                <ul class="list-unstyled text-start mb-4">
                    <li>✔ Featured Listing</li>
                    <li>✔ Higher Visibility</li>
                    <li>✔ Priority Search Ranking</li>
                    <li>✔ More Buyer Views</li>
                </ul>

                <button
                    class="btn btn-primary w-100 choose-plan"
                    data-id="{{ $plan->id }}"
                    data-name="{{ $plan->name }}"
                    data-price="{{ $plan->price_per_day }}">
                    Choose Plan
                </button>

            </div>

        </div>

        @endforeach

    </div>

</div>


<!-- PLAN REVIEW MODAL -->

<div class="modal fade" id="planModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">Review Your Plan</h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>

            </div>


            <form method="POST" action="{{ route('plans.store') }}">

                @csrf

                <div class="modal-body">

                    <input type="hidden" name="plan_id" id="plan_id">
                    <input type="hidden" name="property_id" value="{{ $id }}">
                    <input type="hidden" name="property_type" value="{{ $type }}">
                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">Selected Plan</label>

                            <input type="text"
                                id="plan_name"
                                class="form-control"
                                readonly>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">Price Per Day</label>

                            <input type="text"
                                id="plan_price"
                                class="form-control"
                                readonly>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">Number of Days</label>

                            <input type="number"
                                name="days"
                                id="days"
                                class="form-control"
                                min="1"
                                placeholder="Enter number of days"
                                required>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">Total Amount</label>

                            <input type="text"
                                id="total_amount"
                                class="form-control fw-bold text-success"
                                readonly>

                        </div>

                    </div>

                    <hr>

                    <div class="alert alert-light border mt-3">

                        <h6 class="fw-bold">Review Before Continue</h6>

                        <p class="mb-1">
                            Plan: <strong id="review_plan"></strong>
                        </p>

                        <p class="mb-1">
                            Days: <strong id="review_days"></strong>
                        </p>

                        <p class="mb-0">
                            Total: <strong class="text-success" id="review_total"></strong>
                        </p>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">

                        Choose Another Plan

                    </button>

                    <button type="submit"
                        class="btn btn-success">

                        Confirm & Continue

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<style>
    .plan-card {
        border-radius: 16px;
        transition: all .3s ease;
    }

    .plan-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .modal-content {
        border-radius: 14px;
    }
</style>


<script>
    let selectedPrice = 0


    document.querySelectorAll(".choose-plan").forEach(button => {

        button.addEventListener("click", function() {

            let id = this.dataset.id
            let name = this.dataset.name
            let price = this.dataset.price

            selectedPrice = parseFloat(price)

            document.getElementById("plan_id").value = id
            document.getElementById("plan_name").value = name
            document.getElementById("plan_price").value = price + " RWF"

            document.getElementById("review_plan").innerText = name

            document.getElementById("days").value = ""
            document.getElementById("total_amount").value = ""
            document.getElementById("review_days").innerText = ""
            document.getElementById("review_total").innerText = ""

            let modal = new bootstrap.Modal(document.getElementById("planModal"))

            modal.show()

        })

    })


    document.getElementById("days").addEventListener("input", function() {

        let days = parseInt(this.value)

        if (days > 0) {

            let total = selectedPrice * days

            document.getElementById("total_amount").value =
                total.toLocaleString() + " RWF"

            document.getElementById("review_days").innerText = days

            document.getElementById("review_total").innerText =
                total.toLocaleString() + " RWF"

        }

    })
</script>


@endsection