@extends('layouts.app')
@section('title', 'Add New House Property')
@section('content')


<form method="POST" action="{{ route('admin.properties.houses.store') }}" enctype="multipart/form-data">
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

        <div class="col-xl-8 col-xxl-9">
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
                            <label for="propertyType" class="form-label">Property Type</label>
                            <select class="form-select" id="propertyType" name="type" required>
                                <option value="">Select type</option>
                                <option value="house">House</option>
                                <option value="apartment">Apartment</option>
                                <option value="villa">Villa</option>
                                <option value="townhouse">Townhouse</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="propertyPrice" class="form-label">Price ($)</label>
                            <input type="number" class="form-control" id="propertyPrice"
                                placeholder="Enter price" name="price" required>
                        </div>
                        <div class="col-md-4">
                            <label for="propertyArea" class="form-label">Area (sq ft)</label>
                            <input type="number" class="form-control" id="propertyArea"
                                placeholder="Enter area" name="area_sqft" required>
                        </div>
                        <div class="col-md-4">
                            <label for="propertyStatus" class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="available">Available</option>
                                <option value="reserved">Reserved</option>
                                <option value="sold">Sold</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="propertyBeds" class="form-label">Bedrooms</label>
                            <input name="bedrooms" type="number" class="form-control" id="propertyBeds"
                                placeholder="Enter number of bedrooms" required>
                        </div>
                        <div class="col-md-6">
                            <label for="propertyBaths" class="form-label">Bathrooms</label>
                            <input name="bathrooms" type="number" class="form-control" id="propertyBaths"
                                placeholder="Enter number of bathrooms" required>
                        </div>
                        <div class="col-md-6">
                            <label for="propertyGarage" class="form-label">Garage</label>
                            <input name="garages" type="number" class="form-control" id="propertyGarage"
                                placeholder="Enter number of garages" required>
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
                                <label for="propertyCity" class="form-label">City</label>
                                <input name="city" type="text" class="form-control" id="propertyCity"
                                    placeholder="Enter city" required>
                            </div>
                            <div class="col-md-4">
                                <label for="propertyState" class="form-label">State</label>
                                <input name="state" type="text" class="form-control" id="propertyState"
                                    placeholder="Enter state" required>
                            </div>
                            <div class="col-md-4">
                                <label for="propertyZip" class="form-label">Zip Code</label>
                                <input name="zip_code" type="text" class="form-control" id="propertyZip"
                                    placeholder="Enter zip code" required>
                            </div>
                            <div class="col-md-6">
                                <label for="propertyCountry" class="form-label">Country</label>
                                <input name="country" class="form-control" value="Rwanda">
                            </div>
                            <div class="col-md-6">
                                <label for="propertyAddress" class="form-label">Address</label>
                                <input name="address" type="text" class="form-control" id="propertyAddress"
                                    placeholder="Enter full address" required>
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
        <div class="col-xl-4 col-xxl-3">
            <div class="card position-sticky top-24">
                <div class="card-body">
                    <h6 class="card-title mb-5">Upload Image</h6>
                    <input type="file" name="images[]" multiple>
                    <label>
                        <div class="text-muted">
                            <i data-lucide="image-up"></i>
                            <div class="mt-3">Property Image</div>
                        </div>
                    </label>
                    <h6 class="card-title my-5">Facilities</h6>
                    <div class="row g-3">
                        @foreach($facilities as $facility)
                        <div class="col-md-4 col-xl-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="facilities[]" id="facility{{ $facility->id }}"
                                    value="{{ $facility->id }}">
                                <label class="form-check-label" for="facility{{ $facility->id }}">{{ $facility->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


@endsection