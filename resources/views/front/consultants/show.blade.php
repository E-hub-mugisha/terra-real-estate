@extends('layouts.guest')
@section('title', $consultant->name)

@section('content')
<div class="container py-5">

    <div class="row g-4">

        {{-- LEFT: PROFILE CARD --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">

                    {{-- Profile Image --}}
                    <img
                        src="{{ $consultant->profile_image 
                            ? asset('storage/'.$consultant->profile_image) 
                            : asset('front/assets/img/avatar.png') }}"
                        class="rounded-circle mb-3"
                        width="140"
                        height="140"
                        style="object-fit:cover;"
                        alt="{{ $consultant->name }}">

                    {{-- Name & Role --}}
                    <h4 class="mb-0">
                        {{ $consultant->name }}
                        @if($consultant->is_verified)
                        <span class="badge bg-success ms-1">Verified</span>
                        @endif
                    </h4>

                    <small class="text-muted text-uppercase">
                        {{ $consultant->role ?? 'Real Estate consultant' }}
                    </small>

                    {{-- Experience --}}
                    <div class="mt-3">
                        <span class="badge bg-primary">
                            {{ $consultant->years_experience }}+ Years Experience
                        </span>
                    </div>

                    {{-- Languages --}}
                    @if($consultant->languages)
                    <p class="mt-3 mb-1 fw-bold">Languages</p>
                    <p class="text-muted">{{ $consultant->languages }}</p>
                    @endif

                    {{-- Contact CTA --}}
                    <div class="d-grid gap-2 mt-4">
                        <a href="tel:{{ $consultant->phone }}" class="btn btn-outline-primary">
                            📞 Call consultant
                        </a>

                        @if($consultant->whatsapp)
                        <a href="https://wa.me/{{ $consultant->whatsapp }}" target="_blank" class="btn btn-success">
                            💬 WhatsApp
                        </a>
                        @endif

                        <button class="btn btn-primary mt-3"
                            data-bs-toggle="modal"
                            data-bs-target="#appointmentModal">
                            📆 Book Appointment
                        </button>

                        <div class="modal fade" id="appointmentModal">
                            <div class="modal-dialog">
                                <form method="POST"
                                    action="#"
                                    class="modal-content">
                                    @csrf
                                    <div class="modal-header">
                                        <h5>Book Appointment</h5>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <input class="form-control mb-2" name="name" placeholder="Your Name" required>
                                        <input class="form-control mb-2" name="email" placeholder="Email" required>
                                        <input type="date" class="form-control mb-2" name="date" required>
                                        <input type="time" class="form-control mb-2" name="time" required>
                                        <textarea class="form-control" name="message" placeholder="Message"></textarea>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- RIGHT: DETAILS --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    {{-- About --}}
                    <h5 class="mb-3">About {{ $consultant->name }}</h5>
                    <p class="text-muted">
                        {{ $consultant->bio ?? 'No biography provided.' }}
                    </p>

                    <hr>

                    {{-- Contact Information --}}
                    <h6 class="fw-bold mb-3">Contact Information</h6>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Email:</strong></p>
                            <p class="text-muted">{{ $consultant->email }}</p>
                        </div>

                        <div class="col-md-6">
                            <p class="mb-1"><strong>Phone:</strong></p>
                            <p class="text-muted">{{ $consultant->phone }}</p>
                        </div>
                    </div>

                    @if($consultant->office_location)
                    <div class="mb-3">
                        <p class="mb-1"><strong>Office Location:</strong></p>
                        <p class="text-muted">{{ $consultant->office_location }}</p>
                    </div>
                    @endif

                    <hr>

                    {{-- Social Links --}}
                    <h6 class="fw-bold mb-3">Connect with consultant</h6>

                    <div class="d-flex gap-3">
                        @if($consultant->linkedin)
                        <a href="{{ $consultant->linkedin }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                            LinkedIn
                        </a>
                        @endif

                        @if($consultant->facebook)
                        <a href="{{ $consultant->facebook }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                            Facebook
                        </a>
                        @endif

                        @if($consultant->instagram)
                        <a href="{{ $consultant->instagram }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                            Instagram
                        </a>
                        @endif

                        @if($consultant->twitter)
                        <a href="{{ $consultant->twitter }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                            Twitter
                        </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        <hr>
        <h5 class="mb-3">⭐ Client Reviews</h5>

        <div class="mb-3">
            <span class="badge bg-warning text-dark">
                {{ $averageRating }} / 5
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
        <hr>
        <h5 class="mb-3">📍 Office Location</h5>

        <iframe
            width="100%"
            height="300"
            frameborder="0"
            style="border:0"
            loading="lazy"
            allowfullscreen
            src="https://www.google.com/maps?q={{ urlencode($consultant->office_location) }}&output=embed">
        </iframe>
    </div>
    @endsection