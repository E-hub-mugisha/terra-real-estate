@extends('layouts.app')
@section('title', 'House Details')
@section('content')

<div class="gap-2 page-heading mb-3 flex-column flex-md-row">
    <h6 class="flex-grow-1 mb-0">Property Details</h6>
    <ul class="breadcrumb flex-shrink-0 mb-0">
        <li class="breadcrumb-item"><a href="#!">Property</a></li>
        <li class="breadcrumb-item active">{{ $house->title }}</li>
    </ul>
</div>
<div class="row">
    <div class="col-xl-8 col-xxl-9">
        <div class="card">
            <div class="card-body">
                <div class="row g-2 g-md-3 mb-5">
                    <div class="col-md-6">
                        <div class="position-relative h-100">
                            <img src="{{ asset('dashboard/assets/images/property-14.jpg') }}" alt="Property"
                                class="img-fluid w-100 object-fit-cover rounded h-100">
                            <a href="#!"
                                class="backdrop-blur-md avatar size-9 bg-body-secondary bg-opacity-50 d-none d-md-inline-flex rounded-circle position-absolute top-0 end-0 m-2 text-body"><i
                                    data-lucide="heart" class="size-4"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-2 g-md-3">
                            <div class="col-md-12">
                                <div class="position-relative h-100">
                                    <img src="{{ asset('dashboard/assets/images/property-22.jpg') }}" alt="Property"
                                        class="img-fluid w-100 object-fit-cover rounded h-100">
                                    <a href="#!"
                                        class="backdrop-blur-md avatar size-9 bg-body-secondary bg-opacity-50 d-none d-md-inline-flex rounded-circle position-absolute top-0 end-0 m-2 text-body"><i
                                            data-lucide="heart" class="size-4"></i></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative h-100">
                                    <img src="{{ asset('dashboard/assets/images/property-32.jpg') }}" alt="Property"
                                        class="img-fluid w-100 object-fit-cover rounded h-100">
                                    <a href="#!"
                                        class="backdrop-blur-md avatar size-9 bg-body-secondary bg-opacity-50 d-none d-md-inline-flex rounded-circle position-absolute top-0 end-0 m-2 text-body"><i
                                            data-lucide="heart" class="size-4"></i></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative h-100">
                                    <img src="{{ asset('dashboard/assets/images/property-42.jpg') }}" alt="Property"
                                        class="img-fluid w-100 object-fit-cover rounded h-100">
                                    <a href="#!"
                                        class="backdrop-blur-md avatar size-9 bg-body-secondary bg-opacity-50 d-none d-md-inline-flex rounded-circle position-absolute top-0 end-0 m-2 text-body"><i
                                            data-lucide="heart" class="size-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex h-100 flex-wrap justify-content-between gap-5 gap-xxl-16 mb-5">
                    <div class="flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="mb-4 fs-xl">{{ $house->title }} <span
                                    class="fs-sm fw-normal text-muted ms-1">{{ $house->city }} /
                                    {{ $house->state}}</span></h5>
                            <p class="text-muted mb-5"><i data-lucide="map-pin-house"
                                    class="size-4 me-1"></i>{{ $house->address}}, {{ $house->city}}, {{ $house->state}} {{ $house->zip_code}}, {{ $house->country }}</p>
                        </div>
                        <div class="row g-0 border rounded-2">
                            <div
                                class="col border-bottom border-bottom-md-0 border-end p-4 text-center">
                                <p class="text-muted mb-2">Bedrooms</p>
                                <h6 class="mb-0 d-flex justify-content-center align-items-center gap-2">
                                    <i data-lucide="bed-single" class="text-muted size-4"></i> {{ $house->bedrooms }}
                                </h6>
                            </div>
                            <div
                                class="col border-bottom border-bottom-md-0 border-end p-4 text-center">
                                <p class="text-muted mb-2">Bathrooms</p>
                                <h6
                                    class="mb-0 d-flex justify-content-center align-items-center text-nowrap gap-2">
                                    <i data-lucide="soap-dispenser-droplet" class="text-muted size-4"></i> {{ $house->bathrooms }}
                                </h6>
                            </div>
                            <div
                                class="col border-bottom border-bottom-md-0 border-end p-4 text-center">
                                <p class="text-muted mb-2">Area</p>
                                <h6
                                    class="mb-0 d-flex justify-content-center align-items-center text-nowrap gap-2">
                                    <i data-lucide="ruler" class="text-muted size-4"></i> {{ $house->area_sqft }} ft²
                                </h6>
                            </div>
                            <div
                                class="col border-bottom border-bottom-md-0 border-end p-4 text-center">
                                <p class="text-muted mb-2">Type</p>
                                <h6
                                    class="mb-0 d-flex justify-content-center align-items-center text-nowrap gap-2">
                                    <i data-lucide="sofa" class="text-muted size-4"></i> {{ $house->type }}
                                </h6>
                            </div>
                            <div class="col p-4 text-center">
                                <p class="text-muted mb-2">Ownership</p>
                                <h6
                                    class="mb-0 d-flex justify-content-center align-items-center text-nowrap gap-2">
                                    <i data-lucide="id-card" class="text-muted size-4"></i> {{ $house->user->name }}
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="text-end ms-auto">
                        <span class="text-muted ms-3 fs-13 mb-1 d-block"><i
                                class="ri-star-fill text-warning me-1"></i>4.5</span>
                        <h5 class="mb-5 fw-semibold">${{ number_format($house->price, 0) }} <span class="fs-sm text-muted fw-normal">/
                                month</span></h5>
                        <iframe
                            width="200"
                            height="110"
                            style="border-radius: 8px; border:0;"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q={{ urlencode($house->address . ', ' . $house->city . ', ' . $house->country) }}&output=embed">
                        </iframe>

                    </div>
                </div>
                <div class="mb-5">
                    <h6 class="card-title mb-3">Property Description :</h6>
                    <p class="text-muted mb-3">
                        {{ $house->description }}
                    </p>
                </div>
                <h6 class="card-title mb-3">Key Features :</h6>
                <div class="p-5 rounded border">
                    <h6 class="border-bottom pb-4 mb-0">Amenities :</h6>
                    <div class="pt-5">
                        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 row-cols-xxl-6 gy-4">
                            <div class="col">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="size-9 text-muted avatar shadow rounded-circle border">
                                        <i data-lucide="bed" class="size-4"></i>
                                    </div>
                                    <span>{{ $house->bedrooms }} Beds</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="size-9 text-muted avatar shadow rounded-circle border">
                                        <i data-lucide="soap-dispenser-droplet" class="size-4"></i>
                                    </div>
                                    <span>{{ $house->bathrooms }} Baths</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="size-9 text-muted avatar shadow rounded-circle border">
                                        <i data-lucide="squares-subtract" class="size-4"></i>
                                    </div>
                                    <span>{{ $house->area_sqft }} sqft</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="size-9 text-muted avatar shadow rounded-circle border">
                                        <i data-lucide="home" class="size-4"></i>
                                    </div>
                                    <span>2 Floors</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="size-9 text-muted avatar shadow rounded-circle border">
                                        <i data-lucide="calendar" class="size-4"></i>
                                    </div>
                                    <span>2018</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="size-9 text-muted avatar shadow rounded-circle border">
                                        <i data-lucide="map-pin" class="size-4"></i>
                                    </div>
                                    <span>{{ $house->city }}</span>
                                </div>
                            </div>
                            @foreach($house->facilities as $facility)
                            <div class="col">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="size-9 text-muted avatar shadow rounded-circle border">
                                        <i data-lucide="thermometer" class="size-4"></i>
                                    </div>
                                    <span>{{ $facility->name }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-xxl-3">
        <div class="position-sticky top-24 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-5">
                        <div class="position-relative size-12 flex-shrink-0 rounded-circle bg-white">
                            <img src="assets/images/user-61.png" alt=""
                                class="img-fluid rounded-circle">
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $house->user->name }}</h6>
                            <p class="text-muted mb-0 fs-sm">{{ $house->user->address }}</p>
                        </div>
                    </div>
                    <div class="mb-5 d-flex flex-wrap gap-2 justify-content-between">
                        <p class="text-muted mb-0">Office Phone :</p>
                        <h6 class="mb-0">{{ $house->user->phone ?? 'N/A' }}</h6>
                    </div>
                    <div class="mb-5 d-flex flex-wrap gap-2 justify-content-between">
                        <p class="text-muted mb-0">Email :</p>
                        <h6 class="mb-0">{{ $house->user->email }}</h6>
                    </div>
                    <div class="mb-5 d-flex flex-wrap gap-2 justify-content-between">
                        <p class="text-muted mb-0">Website :</p>
                        <h6 class="mb-0">{{ $house->user->website ?? 'N/A' }}</h6>
                    </div>
                    <div class="mb-5 d-flex flex-wrap gap-2 justify-content-between">
                        <p class="text-muted mb-0">Role :</p>
                        <h6 class="mb-0">{{ $house->user->role }}</h6>
                    </div>
                    <div class="d-flex flex-wrap gap-2 justify-content-between">
                        <p class="text-muted mb-0">Working Hours :</p>
                        <h6 class="mb-0">Mon - Fri, 9am - 6pm</h6>
                    </div>
                    <button type="button" class="btn btn-secondary w-100 mt-5">View Details <i
                            data-lucide="arrow-right" class="size-4 ms-1"></i></button>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Schedule a Visit</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Schedule a visit with our agent to explore the property
                        and get all the details you need. We'll help you find a convenient time.</p>
                    <form>
                        <div class="row g-4">
                            <div class="col-md-6 col-xl-12">
                                <label for="visitorName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="visitorName"
                                    placeholder="Enter your name" required>
                            </div>
                            <div class="col-md-6 col-xl-12">
                                <label for="visitorEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="visitorEmail"
                                    placeholder="Enter your email" required>
                            </div>
                            <div class="col-md-6 col-xl-12">
                                <label for="visitorPhone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="visitorPhone"
                                    placeholder="Enter your phone number" required>
                            </div>
                            <div class="col-md-6 col-xl-12">
                                <label for="visitDate" class="form-label">Preferred Date</label>
                                <input type="text" class="form-control" id="visitDate"
                                    placeholder="Select preferred date" required>
                            </div>
                            <div class="col-12 justify-content-end d-flex">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection