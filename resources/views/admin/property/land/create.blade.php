@extends('layouts.app')
@section('title', 'Add New land Property')
@section('content')


<form method="POST" action="{{ route('admin.properties.lands.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
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

        <!-- success message -->
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="col-xl-10 col-xxl-11">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Property Details</h6>
                </div>
                <div class="card-body">

                    <div class="row g-5">
                        <div class="col-12">
                            <label for="propertyTitle" class="form-label">Property Title</label>
                            <input type="text" class="form-control" id="propertyTitle"
                                placeholder="Enter property title" name="title" required>
                        </div>
                        <div class="col-md-4">
                            <label for="propertyType" class="form-label">Land UPI</label>
                            <input type="text" class="form-control" id="propertyType" name="upi" required>
                        </div>
                        <div class="col-md-4">
                            <label for="zoning" class="form-label">Property Type</label>
                            <select name="zoning" class="form-control">
                                <option value="R1">R1 – Low density residential</option>
                                <option value="R2">R2 – Medium density residential</option>
                                <option value="R3">R3 – High density residential</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Industrial">Industrial</option>
                                <option value="Agricultural">Agricultural</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Service</label>
                            <select class="form-select" name="service_id" required>
                                <option value="">Select service</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}">
                                    {{ $service->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="propertyPrice" class="form-label">Price ($)</label>
                            <input type="number" class="form-control" id="propertyPrice"
                                placeholder="Enter price" name="price" required>
                        </div>
                        <div class="col-md-4">
                            <label for="propertyArea" class="form-label">Area (sq ft)</label>
                            <input type="number" class="form-control" id="propertyArea"
                                placeholder="Enter area" name="size_sqm" required>
                        </div>
                        <div class="col-md-4">
                            <label for="propertyStatus" class="form-label">land status</label>
                            <select name="status" class="form-control">
                                <option value="available">Available</option>
                                <option value="reserved">Reserved</option>
                                <option value="sold">Sold</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="propertyArea" class="form-label">Land Use</label>
                            <input type="text" class="form-control" id="land_use"
                                placeholder="Enter land_use" name="land_use" required>
                        </div>
                        
                        <div class="col-12">
                            <label for="propertyDescription" class="form-label">Property
                                Description</label>
                            <textarea class="form-control" name="description" id="propertyDescription" rows="4"
                                placeholder="Enter property description" required></textarea>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Location Details</h6>
                </div>
                <div class="card-body">
                    @include('includes.form')
                </div>
            </div>
        </div>
    </div>
</form>


@endsection