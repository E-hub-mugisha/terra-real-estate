@extends('layouts.app')
@section('title', 'House Properties')
@section('content')

<div class="gap-2 page-heading mb-3 flex-column flex-md-row">
    <h6 class="flex-grow-1 mb-0">Grid View</h6>
    <ul class="breadcrumb flex-shrink-0 mb-0">
        <li class="breadcrumb-item"><a href="#!">Property</a></li>
        <li class="breadcrumb-item active">Grid View</li>
    </ul>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex flex-grow-1">
                    <h6 class="card-title mb-0">Property Grid</h6>
                </div>
                <div class="d-flex flex-wrap gap-2 ms-auto flex-shrink-0">
                    <button type="button" class="btn btn-light d-flex align-items-center gap-1"
                        data-bs-toggle="offcanvas" data-bs-target="#drawerEnd"
                        aria-controls="drawerEnd"><i data-lucide="list-filter-plus"
                            class="size-4"></i>Filter</button>
                    <a href="{{ route('admin.properties.houses.create')}}"
                        class="btn btn-primary d-flex align-items-center gap-1"><i data-lucide="plus"
                            class="size-4"></i>Add Property</a>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
            @foreach( $houses as $house)
            <div class="col">
                <div class="card">
                    <div class="card-body p-4 property-card">
                        <div class="position-relative propery-wrapper overflow-hidden">
                            <img src="{{ asset('dashboard/assets/images/property-1.jpg') }}" alt="Property 1"
                                class="card-img-top rounded object-fit-cover img-1">
                            <img src="{{ asset('dashboard/assets/images/property-2.jpg') }}" alt="Property 2"
                                class="card-img-top rounded object-fit-cover img-2">
                            <span
                                class="px-3 py-1 fs-11 text-white bg-success bg-opacity-75 backdrop-blur-md position-absolute top-0 rounded-1 rounded-start-0 start-0 mt-3">
                                {{ $house->status}}
                            </span>
                            <div
                                class="position-absolute bottom-0 d-flex flex-column gap-2 m-2 social-btn">
                                <a href="{{ route('admin.properties.houses.show', $house->id) }}"
                                    class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i
                                        data-lucide="bookmark" class="size-4"></i></a>
                                <a href="{{ route('admin.properties.houses.show', $house->id) }}"
                                    class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i
                                        data-lucide="heart" class="size-4"></i></a>
                            </div>
                        </div>
                        <div class="my-4 pb-4 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 text-primary">${{ number_format($house->price, 0) }}</h6>
                                <p class="mb-0 text-muted small d-flex align-items-center gap-1"><i
                                        data-lucide="star" class="size-3 text-warning"></i>4.8</p>
                            </div>
                            <a href="{{ route('admin.properties.houses.show', $house->id) }}"
                                class="mb-1 fs-16 text-body fw-semibold d-block">{{ $house->title }}</a>
                            <p class="text-muted mb-0 d-flex align-items-center gap-1 fs-sm"><i
                                    data-lucide="map-pin" class="size-3"></i>{{ $house->address}}, {{ $house->city}}, {{ $house->state}} {{ $house->zip_code}}</p>
                        </div>
                        <div class="d-flex justify-content-between text-muted fs-sm pb-1">
                            <span><i data-lucide="bed-single" class="me-1 size-3"></i>{{ $house->bedrooms }} Beds</span>
                            <span><i data-lucide="soap-dispenser-droplet" class="me-1 size-3"></i>{{ $house->bathrooms }}
                                Baths</span>
                            <span><i data-lucide="squares-subtract" class="me-1 size-3"></i>{{ $house->area_sqft }}
                                sqft</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Offcanvas end Modal -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="drawerEnd"
            aria-labelledby="drawerEndLabel">
            <div class="offcanvas-header">
                <h6 class="mb-0">Filter Properties</h6>
                <button type="button" data-bs-dismiss="offcanvas" class="btn-close"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <h6 class="mb-3">Property Status</h6>
                <div class="row g-3 mb-5">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="statusSale">
                            <label class="form-check-label" for="statusSale">For Sale</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="statusRent">
                            <label class="form-check-label" for="statusRent">For Rent</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="statusSold">
                            <label class="form-check-label" for="statusSold">Sold</label>
                        </div>
                    </div>
                </div>
                <h6 class="mb-3">Property Type</h6>
                <div class="row g-3 mb-5">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="typeHouse">
                            <label class="form-check-label" for="typeHouse">House</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="typeApartment">
                            <label class="form-check-label" for="typeApartment">Apartment</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="typeVilla">
                            <label class="form-check-label" for="typeVilla">Villa</label>
                        </div>
                    </div>
                </div>
                <h6 class="mb-3">Price Range</h6>
                <div class="h-10 d-flex justify-content-center align-items-center mb-3">
                    <div id="slider" class="w-100"></div>
                </div>
                <div class="mb-5 d-flex align-items-center gap-2">
                    <input type="number" class="form-control" placeholder="Min $" min="0">
                    <span>-</span>
                    <input type="number" class="form-control" placeholder="Max $" min="0">
                </div>
                <h6 class="mb-3">Bedrooms</h6>
                <div class="row g-3 mb-5">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bed1">
                            <label class="form-check-label" for="bed1">1+ Beds</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bed2">
                            <label class="form-check-label" for="bed2">2+ Beds</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bed3">
                            <label class="form-check-label" for="bed3">3+ Beds</label>
                        </div>
                    </div>
                </div>
                <h6 class="mb-3">Year Built</h6>
                <div class="mb-5 d-flex align-items-center gap-2">
                    <input type="number" class="form-control" placeholder="From" min="1900" max="2025">
                    <span>-</span>
                    <input type="number" class="form-control" placeholder="To" min="1900" max="2025">
                </div>
                <h6 class="mb-3">Additional Features</h6>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featureBalcony">
                            <label class="form-check-label" for="featureBalcony">Balcony</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featureFireplace">
                            <label class="form-check-label" for="featureFireplace">Fireplace</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featureGym">
                            <label class="form-check-label" for="featureGym">Gym</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featureSecurity">
                            <label class="form-check-label" for="featureSecurity">Security</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featureSwimmingPool">
                            <label class="form-check-label" for="featureSwimmingPool">Swimming
                                Pool</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-footer">
                <button class="btn btn-primary d-flex ms-auto" type="button">Apply Filters</button>
            </div>
        </div>
    </div>
</div>

@endsection