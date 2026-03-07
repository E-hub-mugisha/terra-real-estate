@extends('layouts.app')
@section('title', 'Create Agents Pricing Plan')
@section('content')

<div class="container">
    <div class="card shadow-sm rounded-3 p-4">
        <h4>Create Agents Pricing Plan</h4>

        <form method="POST" action="{{ route('admin.pricing-plans.store') }}">

            @csrf
            <div class="row">
                <!-- type selection dropdown -->
                <div class="col-md-6 mb-3">
                    <label>Agent Plan</label>
                    <select name="type" class="form-control">
                        <option value="agents_plan">Agents Plan</option>
                    </select>
                </div>
                <!-- selection type -->
                <div class="col-md-6 mb-3">
                    <label>Listing Type</label>
                    <select name="selection_type" class="form-control">
                        <option value="agents_commissions">Agents commissions</option>
                    </select>
                </div>

                <!-- type selection dropdown -->
                <div class="col-md-4 mb-3">
                    <label>Plan Type</label>
                    <select name="type" class="form-control">
                        <option value="basic">Basic</option>
                        <option value="medium">Medium</option>
                        <option value="standard">Standard</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Listing Type</label>
                    <select name="selection_type" class="form-control">
                        <option value="land_listings">Land Listings</option>
                        <option value="house_listings">House Listings</option>
                        <option value="architectural_listings">Architectural Listings</option>
                        <option value="tenders">Tenders</option>
                        <option value="advertisements">Advertisements</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Price Per Listing</label>
                    <input type="number" step="1.00" max="100" name="price_per_day" class="form-control" placeholder="Enter percentage">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                

                <div class="form-check">
                    <input type="checkbox" name="active" class="form-check-input" checked>
                    <label class="form-check-label">Active</label>
                </div>

                <br>

                <button class="btn btn-success w-50 mt-3">
                    Save Plan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection