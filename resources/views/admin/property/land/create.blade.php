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
                        <div class="col-md-6">
                            <label for="propertyType" class="form-label">Land UPI</label>
                            <input type="text" class="form-control" id="propertyType" name="upi" required>
                        </div>
                        <div class="col-md-6">
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
                    <form>
                        <div class="row g-5">
                            <div class="col-md-4">
                                <label for="province" class="form-label">Province</label>
                                <input name="province" type="text" class="form-control" id="province"
                                    placeholder="Province (e.g. Kigali City)" required>
                            </div>
                            <div class="col-md-4">
                                <label for="district" class="form-label">District</label>
                                <input name="district" type="text" class="form-control" id="district"
                                    placeholder="District (e.g. Gasabo)" required>
                            </div>
                            <div class="col-md-4">
                                <label for="sector" class="form-label">Sector</label>
                                <input name="sector" type="text" class="form-control" id="sector"
                                    placeholder="Sector (e.g. Nyamirambo)" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cell" class="form-label">Cell</label>
                                <input name="cell" type="text" class="form-control" id="cell"
                                    placeholder="Cell (e.g. Kacyiru)" required>
                            </div>
                            <div class="col-md-6">
                                <label for="village" class="form-label">Village</label>
                                <input name="village" type="text" class="form-control" id="village"
                                    placeholder="Village (e.g. Nyamirambo)" required>
                            </div>
                            <div class="col-md-6">
                                <label for="title_doc" class="form-label">land Document</label>
                                <input type="file" name="title_doc" class="form-control">
                            </div>
                            <div class="col-12 d-flex flex-wrap justify-content-end gap-2">
                                <button type="button" class="btn btn-active-danger">Cancel</button>
                                <button type="submit" class="btn btn-primary">Add Property</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</form>


@endsection