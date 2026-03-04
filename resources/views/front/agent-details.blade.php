@extends('layouts.guest')
@section('title', $agent->full_name)

@section('content')
<div class="container py-5">

    <div class="row g-5">

        {{-- ================= LEFT SIDE (STICKY CARD) ================= --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-lg " style="top:100px; border-radius:18px;">
                <div class="card-body text-center p-4">

                    {{-- Profile Image --}}
                    <img
                        src="{{ $agent->profile_image 
                            ? asset('storage/'.$agent->profile_image) 
                            : asset('front/assets/img/avatar.png') }}"
                        class="rounded-circle mb-3 shadow"
                        width="160"
                        height="160"
                        style="object-fit:cover; border:4px solid #f8f9fa;"
                        alt="{{ $agent->full_name }}">

                    {{-- Name --}}
                    <h4 class="fw-bold mb-1">
                        {{ $agent->full_name }}
                        @if($agent->is_verified)
                        <span class="badge bg-success">✔ Verified</span>
                        @endif
                    </h4>

                    <p class="text-muted mb-2">
                        Real Estate Agent
                    </p>

                    <p class="small text-muted mb-1">
                        📍 {{ $agent->office_location ?? 'Kigali, Rwanda' }}
                    </p>

                    <p class="small text-muted">
                        {{ $agent->years_experience }}+ Years Experience
                    </p>

                    <hr>

                    {{-- Quick Stats --}}
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <h6 class="fw-bold mb-0">{{ $agent->advertisements->count() }}</h6>
                            <small class="text-muted">Listings</small>
                        </div>
                        <div class="col-6">
                            <h6 class="fw-bold mb-0">{{ $averageRating ?? 0 }}</h6>
                            <small class="text-muted">Rating</small>
                        </div>
                    </div>

                    <hr>

                    {{-- Contact Buttons --}}
                    <div class="d-grid gap-2">
                        <a href="tel:{{ $agent->phone }}" class="btn btn-outline-primary">
                            📞 Call Agent
                        </a>

                        @if($agent->whatsapp)
                        <a href="https://wa.me/{{ $agent->whatsapp }}" target="_blank" class="btn btn-success">
                            💬 WhatsApp
                        </a>
                        @endif

                        <a href="mailto:{{ $agent->email }}" class="btn btn-dark">
                            ✉ Send Email
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- ================= RIGHT SIDE CONTENT ================= --}}
        <div class="col-lg-8">

            {{-- ABOUT --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius:16px; margin-top: 60px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">About {{ $agent->full_name }}</h5>
                    <p class="text-muted">
                        {{ $agent->bio ?? 'No biography provided yet.' }}
                    </p>

                    {{-- Languages --}}
                    @if($agent->languages)
                    <p class="mt-3">
                        <strong>Languages:</strong>
                        <span class="text-muted">{{ $agent->languages }}</span>
                    </p>
                    @endif
                </div>
            </div>

            @if($lands->count())
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">🌍 Lands by {{ $agent->full_name }}</h5>

                    <div class="row">
                        @foreach($lands as $land)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <img src="{{ asset('storage/'.$land->main_image) }}"
                                    class="card-img-top"
                                    style="height:220px; object-fit:cover;">

                                <div class="card-body">
                                    <h6 class="fw-bold">{{ $land->title }}</h6>
                                    <p class="small text-muted mb-1">
                                        📍 {{ $land->address }}
                                    </p>
                                    <h6 class="text-primary fw-bold">
                                        {{ number_format($land->price) }} RWF
                                    </h6>
                                    <a href="{{ route('front.buy.land.details', $land) }}"
                                        class="btn btn-outline-dark btn-sm w-100 mt-2">
                                        View Land
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- ALL PROPERTIES --}}
            @if($houses->count())
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">🏠 Houses by {{ $agent->full_name }}</h5>

                    <div class="row">
                        @foreach($houses as $home)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <img src="{{ asset('storage/'.$home->main_image) }}"
                                    class="card-img-top"
                                    style="height:220px; object-fit:cover;">

                                <div class="card-body">
                                    <h6 class="fw-bold">{{ $home->title }}</h6>
                                    <p class="small text-muted mb-1">
                                        📍 {{ $home->address }}
                                    </p>
                                    <h6 class="text-primary fw-bold">
                                        {{ number_format($home->price) }} RWF
                                    </h6>
                                    <a href="{{ route('front.buy.home.details', $home) }}"
                                        class="btn btn-outline-dark btn-sm w-100 mt-2">
                                        View House
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- REVIEWS --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">⭐ Client Reviews</h5>

                    <div class="mb-3">
                        <span class="badge bg-warning text-dark">
                            {{ $averageRating ?? 0 }} / 5
                        </span>
                        <small class="text-muted">
                            ({{ $reviews->count() }} reviews)
                        </small>
                    </div>

                    @foreach($reviews as $review)
                    <div class="border rounded p-3 mb-3">
                        <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                        <div class="text-warning">
                            @for($i=1;$i<=5;$i++)
                                {{ $i <= $review->rating ? '★' : '☆' }}
                                @endfor
                                </div>
                                <p class="mb-0 text-muted">{{ $review->comment }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- MAP --}}
                @if($agent->office_location)
                <div class="card border-0 shadow-sm" style="border-radius:16px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">📍 Office Location</h5>

                        <iframe
                            width="100%"
                            height="300"
                            frameborder="0"
                            style="border-radius:12px;"
                            loading="lazy"
                            allowfullscreen
                            src="https://www.google.com/maps?q={{ urlencode($agent->office_location) }}&output=embed">
                        </iframe>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

    <style>
        .card:hover {
            transform: translateY(-4px);
            transition: all 0.3s ease;
        }
    </style>

    @endsection