@extends('layouts.base')

@section('content')

<div class="container py-5">

    <h3 class="mb-4">Choose Listing Plan</h3>
 <!-- errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('plans.store') }}" method="POST">

        @csrf

        <input type="hidden" name="property_id" value="{{ $id }}">
        <input type="hidden" name="property_type" value="{{ $type }}">

        <div class="row">

            @foreach($plans as $plan)

            <div class="col-md-4">

                <div class="card shadow-sm mb-4">

                    <div class="card-body text-center">

                        <h4>{{ $plan->name }}</h4>

                        <h2>${{ $plan->price_per_day }}</h2>

                        <p>Per Day</p>

                        <p>{{ $plan->description }}</p>

                        <label>

                            <input type="radio" name="plan_id"
                                value="{{ $plan->id }}" required>

                            Select Plan

                        </label>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

        <div class="mb-3">

            <label>How many days?</label>

            <input type="number" name="days"
                class="form-control"
                min="1"
                required>

        </div>

        <button class="btn btn-primary">

            Continue

        </button>

    </form>

</div>

@endsection