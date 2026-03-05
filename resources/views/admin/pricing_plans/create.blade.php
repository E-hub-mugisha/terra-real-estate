@extends('layouts.app')

@section('content')

<div class="container">

    <h4>Create Pricing Plan</h4>

    <form method="POST" action="{{ route('admin.pricing-plans.store') }}">

        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Price Per Day</label>
            <input type="number" step="0.01" name="price_per_day" class="form-control">
        </div>

        <div class="mb-3">
            <label>Max Images</label>
            <input type="number" name="max_images" class="form-control">
        </div>

        <div class="form-check">
            <input type="checkbox" name="featured" class="form-check-input">
            <label class="form-check-label">Featured Listing</label>
        </div>

        <div class="form-check">
            <input type="checkbox" name="priority_listing" class="form-check-input">
            <label class="form-check-label">Priority Listing</label>
        </div>

        <div class="form-check">
            <input type="checkbox" name="show_on_homepage" class="form-check-input">
            <label class="form-check-label">Show on Homepage</label>
        </div>

        <div class="form-check">
            <input type="checkbox" name="active" class="form-check-input" checked>
            <label class="form-check-label">Active</label>
        </div>

        <br>

        <button class="btn btn-success">
            Save Plan
        </button>

    </form>

</div>

@endsection