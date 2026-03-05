@extends('layouts.app')
@section('title', 'land Details')
@section('content')

<div class="gap-2 page-heading mb-3 flex-column flex-md-row">
    <h6 class="flex-grow-1 mb-0">Property Details</h6>
    <ul class="breadcrumb flex-shrink-0 mb-0">
        <li class="breadcrumb-item"><a href="#!">Property</a></li>
        <li class="breadcrumb-item active">{{ $land->title }}</li>
    </ul>
</div>
<div class="row">
    <div class="col-xl-8 col-xxl-9">
        <div class="card">
            <div class="card-body">
                <div class="row g-2 g-md-3 mb-5">
                    {{-- Main Image --}}
                    <div class="col-md-6">
                        <div class="position-relative h-100">
                            <img src="{{ asset('storage/' . $land->images->first()->image_path ?? 'dashboard/assets/images/property-14.jpg') }}"
                                class="img-fluid w-100 object-fit-cover rounded h-100">

                            <a href="#!"
                                class="backdrop-blur-md avatar size-9 bg-body-secondary bg-opacity-50 d-none d-md-inline-flex rounded-circle position-absolute top-0 end-0 m-2 text-body">
                                <i data-lucide="heart" class="size-4"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Other Images --}}
                    <div class="col-md-6">
                        <div class="row g-2 g-md-3">

                            @foreach($land->images->skip(1)->take(3) as $image)
                            <div class="col-md-6">
                                <div class="position-relative h-100">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                        class="img-fluid w-100 object-fit-cover rounded h-100">

                                    <a href="#!"
                                        class="backdrop-blur-md avatar size-9 bg-body-secondary bg-opacity-50 d-none d-md-inline-flex rounded-circle position-absolute top-0 end-0 m-2 text-body">
                                        <i data-lucide="heart" class="size-4"></i>
                                    </a>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="d-flex h-100 flex-wrap justify-content-between gap-5 gap-xxl-16 mb-5">
                    <div class="flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="mb-4 fs-xl">{{ $land->title }} <span
                                    class="fs-sm fw-normal text-muted ms-1">{{ $land->city }} /
                                    {{ $land->state}}</span></h5>
                            <p class="text-muted mb-5"><i data-lucide="map-pin-land"
                                    class="size-4 me-1"></i>{{ $land->address}}, {{ $land->city}}, {{ $land->state}} {{ $land->zip_code}}, {{ $land->country }}</p>
                        </div>
                        <div class="row g-0 border rounded-2">
                            <div
                                class="col border-bottom border-bottom-md-0 border-end p-4 text-center">
                                <p class="text-muted mb-2">Bedrooms</p>
                                <h6 class="mb-0 d-flex justify-content-center align-items-center gap-2">
                                    <i data-lucide="bed-single" class="text-muted size-4"></i> {{ $land->bedrooms }}
                                </h6>
                            </div>
                            <div
                                class="col border-bottom border-bottom-md-0 border-end p-4 text-center">
                                <p class="text-muted mb-2">Bathrooms</p>
                                <h6
                                    class="mb-0 d-flex justify-content-center align-items-center text-nowrap gap-2">
                                    <i data-lucide="soap-dispenser-droplet" class="text-muted size-4"></i> {{ $land->bathrooms }}
                                </h6>
                            </div>
                            <div
                                class="col border-bottom border-bottom-md-0 border-end p-4 text-center">
                                <p class="text-muted mb-2">Area</p>
                                <h6
                                    class="mb-0 d-flex justify-content-center align-items-center text-nowrap gap-2">
                                    <i data-lucide="ruler" class="text-muted size-4"></i> {{ $land->area_sqft }} ft²
                                </h6>
                            </div>
                            <div
                                class="col border-bottom border-bottom-md-0 border-end p-4 text-center">
                                <p class="text-muted mb-2">Type</p>
                                <h6
                                    class="mb-0 d-flex justify-content-center align-items-center text-nowrap gap-2">
                                    <i data-lucide="sofa" class="text-muted size-4"></i> {{ $land->type }}
                                </h6>
                            </div>
                            <div class="col p-4 text-center">
                                <p class="text-muted mb-2">Ownership</p>
                                <h6
                                    class="mb-0 d-flex justify-content-center align-items-center text-nowrap gap-2">
                                    <i data-lucide="id-card" class="text-muted size-4"></i> {{ $land->user->name }}
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="text-end ms-auto">
                        <span class="text-muted ms-3 fs-13 mb-1 d-block"><i
                                class="ri-star-fill text-warning me-1"></i>4.5</span>
                        <h5 class="mb-5 fw-semibold">${{ number_format($land->price, 0) }} <span class="fs-sm text-muted fw-normal">/
                                month</span></h5>
                        <iframe
                            width="200"
                            height="110"
                            style="border-radius: 8px; border:0;"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q={{ urlencode($land->address . ', ' . $land->city . ', ' . $land->country) }}&output=embed">
                        </iframe>

                    </div>
                </div>
                <div class="mb-5">
                    <h6 class="card-title mb-3">Property Description :</h6>
                    <p class="text-muted mb-3">
                        {{ $land->description }}
                    </p>
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
                            <h6 class="mb-1">{{ $land->user->name }}</h6>
                            <p class="text-muted mb-0 fs-sm">{{ $land->user->address }}</p>
                        </div>
                    </div>
                    <div class="mb-5 d-flex flex-wrap gap-2 justify-content-between">
                        <p class="text-muted mb-0">Office Phone :</p>
                        <h6 class="mb-0">{{ $land->user->phone ?? 'N/A' }}</h6>
                    </div>
                    <div class="mb-5 d-flex flex-wrap gap-2 justify-content-between">
                        <p class="text-muted mb-0">Email :</p>
                        <h6 class="mb-0">{{ $land->user->email }}</h6>
                    </div>
                    <div class="mb-5 d-flex flex-wrap gap-2 justify-content-between">
                        <p class="text-muted mb-0">Website :</p>
                        <h6 class="mb-0">{{ $land->user->website ?? 'N/A' }}</h6>
                    </div>
                    <div class="mb-5 d-flex flex-wrap gap-2 justify-content-between">
                        <p class="text-muted mb-0">Role :</p>
                        <h6 class="mb-0">{{ $land->user->role }}</h6>
                    </div>
                    <div class="d-flex flex-wrap gap-2 justify-content-between">
                        <p class="text-muted mb-0">Working Hours :</p>
                        <h6 class="mb-0">Mon - Fri, 9am - 6pm</h6>
                    </div>
                    <button type="button" class="btn btn-secondary w-100 mt-5">View Profile <i
                            data-lucide="arrow-right" class="size-4 ms-1"></i></button>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Property Plan Details</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Here is the information about the property's plan:</p>

                    @php
                    // Get the latest plan order for this property
                    $latestOrder = $land->planOrders()->latest()->first();
                    @endphp

                    @if($latestOrder)
                    <ul class="list-unstyled mb-4">
                        <li><strong>Plan Name:</strong> {{ $latestOrder->plan?->name ?? 'N/A' }}</li>
                        <li><strong>Price per Day:</strong> ${{ $latestOrder->plan?->price_per_day ?? 'N/A' }}</li>
                        <li><strong>Duration (Days):</strong> {{ $latestOrder->days ?? 'N/A' }}</li>
                        <li><strong>Total Price:</strong> ${{ $latestOrder->total_price ?? 'N/A' }}</li>
                        <li><strong>Payment Status:</strong>
                            <span class="badge 
                        @if($latestOrder->payment?->status === 'success') bg-success
                        @elseif($latestOrder->payment?->status === 'pending') bg-warning
                        @else bg-danger
                        @endif">
                                {{ $latestOrder->payment?->status ?? 'pending' }}
                            </span>
                        </li>
                        <li><strong>Approval Status:</strong>
                            @if($land->is_approved)
                            <span class="badge bg-success">Approved</span>
                            @else
                            <span class="badge bg-secondary">Pending</span>
                            @endif
                        </li>
                    </ul>

                    @if($latestOrder->payment?->status === 'success' && !$land->is_approved)
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#propertyApproveModal{{ $land->id }}">
                        Approve Property
                    </button>
                    @endif
                    @else
                    <p class="text-muted">No plan orders found for this property.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($latestOrder->payment?->status === 'success' && !$land->is_approved)

<!-- Approve Modal -->
<!-- Property Approve Modal -->
<div class="modal fade" id="propertyApproveModal{{ $land->id }}" tabindex="-1" aria-labelledby="propertyApproveModalLabel{{ $land->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.properties.lands.approve', $land) }}" class="modal-content">
            @csrf
            @method('POST')
            <div class="modal-header">
                <h5 class="modal-title" id="propertyApproveModalLabel{{ $land->id }}">Approve Property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this property?</p>
                <p><strong>{{ $land->title }}</strong> by <strong>{{ $land->user->name }}</strong></p>
                <p>This action will make the property visible to the public.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Approve</button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection