@extends('layouts.app')
@section('title', 'Professional Profile')
@section('content')

<div class="position-relative mb-8">
    <div class="position-relative overflow-hidden rounded h-52 profile-widget">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-25"></div>
    </div>
    <div class="ps-8 d-flex flex-wrap align-items-center gap-5">
        <div class="position-relative d-inline-block profile-avatar">
            <div class="profile-avatar-wrapper mt-n14">
                <img src="{{ asset('dashboard/assets/images/user.jfif') }}" loading="lazy" alt="user-45"
                    class="mx-auto profile-avatar-img size-32">
            </div>
        </div>
        <div class="flex-grow-1 mb-2">
            <div class="avatar justify-content-start gap-1">
                <h5 class="mt-2 mb-3">{{ $professional->full_name }}</h5>
                <i data-lucide="badge-check" class="size-5 icon-primary"></i>
            </div>
            <ul class="text-muted avatar gap-2 justify-content-start ps-0 mb-0 flex-wrap">
                <li class="d-flex align-items-center gap-2">
                    <i data-lucide="building-2" class="size-4"></i>
                    <span>{{ $professional->profession }}</span>
                </li>
                <li class="d-flex align-items-center gap-2">
                    <i data-lucide="map-pin" class="size-4"></i>
                    <span>{{ $professional->office_location ?? 'N/A' }}</span>
                </li>
                <li class="d-flex align-items-center gap-2">
                    <i data-lucide="calendar-days" class="size-4"></i>
                    <span>{{ $professional->created_at->format('d M Y') }}</span>
                </li>
            </ul>
        </div>
    </div>
</div>
<div>
    <ul class="nav nav-underline border-bottom">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="pages-user.html">
                <i data-lucide="eye" class="size-4 me-1"></i>
                Overview
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="pages-user-activity.html">
                <i data-lucide="sparkles" class="size-4 me-1"></i>
                Activity
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="pages-user-followers.html">
                <i data-lucide="user-round" class="size-4 me-1"></i>
                Followers
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="pages-user-documents.html">
                <i data-lucide="file-text" class="size-4 me-1"></i>
                Documents
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="pages-user-notes.html">
                <i data-lucide="list" class="size-4 me-1"></i>
                Notes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="pages-user-projects.html">
                <i data-lucide="monitor" class="size-4 me-1"></i>
                Projects
            </a>
        </li>
    </ul>
</div>
<div class="row mt-5">
    <div class="col-12 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="row g-0 mb-4 text-center">
                    <div class="col border-end">
                        <h6 class="mb-1">2459</h6>
                        <p class="text-muted">Followers</p>
                    </div>
                    <div class="col">
                        <h6 class="mb-1">2459</h6>
                        <p class="text-muted">Following</p>
                    </div>
                </div>
                <button type="button" class="btn btn-info btn-icon-text toggle-button w-100">
                    <span class="btn-content d-block">
                        <span class="active-text"><i class="ri-user-add-line me-2"></i>Follow</span>
                        <span class="unactive-text" style="display: none;"><i
                                class="ri-user-add-line me-2"></i>Unfollow</span>
                        <span
                            class="spinner-border text-white text-opacity-75 size-4 ms-1 loading-spinner"
                            style="display: none;"></span>
                    </span>
                </button>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Introductions</h6>
            </div>
            <div class="card-body">
                <p class="mb-4 text-uppercase fs-sm fw-medium text-muted">About</p>
                <div class="mb-3">
                    <h6 class="d-flex align-items-center mb-4 fw-medium">
                        <i data-lucide="monitor" class="size-4 text-muted me-3"></i>
                        <span>{{ $professional->full_name }}</span>
                    </h6>
                    <h6 class="d-flex align-items-center mb-4 fw-medium">
                        <i data-lucide="briefcase-business" class="size-4 text-muted me-3"></i>
                        <span>{{ $professional->profession }}</span>
                    </h6>
                    <h6 class="d-flex align-items-center mb-4 fw-medium">
                        <i data-lucide="map-pin" class="size-4 text-muted me-3"></i>
                        <span>{{ $professional->office_location ?? 'N/A' }}</span>
                    </h6>
                    <h6 class="d-flex align-items-center mb-4 fw-medium">
                        <i data-lucide="cake" class="size-4 text-muted me-3"></i>
                        <span>{{ $professional->created_at->format('d M Y') }}</span>
                    </h6>
                </div>

                <div class="pt-4 mt-4 border-top">
                    <h6 class="d-flex align-items-center mb-4 fw-medium">
                        <i data-lucide="globe" class="size-4 text-muted me-3"></i>
                        <a href="#!" class="text-body">{{ $professional->website ?? 'N/A' }}</a>
                    </h6>
                    <h6 class="d-flex align-items-center mb-4 fw-medium">
                        <i data-lucide="mail" class="size-4 text-muted me-3"></i>
                        <a href="#!" class="text-body">{{ $professional->email }}</a>
                    </h6>
                    <h6 class="d-flex align-items-center mb-4 fw-medium">
                        <i data-lucide="phone" class="size-4 text-muted me-3"></i>
                        <a href="#!" class="text-body">{{ $professional->phone ?? 'N/A' }}</a>
                    </h6>
                    <h6 class="d-flex align-items-center mb-4 fw-medium">
                        <i data-lucide="twitter" class="size-4 text-muted me-3"></i>
                        <a href="#!" class="text-body">{{ $professional->twitter ?? 'N/A' }}</a>
                    </h6>
                </div>

                <p class="pt-4 mb-3 border-top text-uppercase fs-sm fw-medium text-muted">Fluent In</p>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge border text-muted">{{ $professional->languages ?? 'English' }}</span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Badges</h6>
            </div>
            <div class="card-body d-flex gap-3">
                <div data-bs-toggle="tooltip" data-bs-title="New User">
                    <img src="assets/images/new.png" loading="lazy" alt="New Users" class="size-7">
                </div>
                <div data-bs-toggle="tooltip" data-bs-title="Verified Badge">
                    <img src="assets/images/quality.png" loading="lazy" alt="Verified Badge"
                        class="size-7">
                </div>
                <div data-bs-toggle="tooltip" data-bs-title="High Quality">
                    <img src="assets/images/high-quality.png" loading="lazy" alt="High Quality"
                        class="size-7">
                </div>
                <div data-bs-toggle="tooltip" data-bs-title="Reward">
                    <img src="assets/images/reward.png" loading="lazy" alt="Reward" class="size-7">
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-8">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2">Overview</h6>
                <p class="mb-2 text-muted">Hello, I'm <strong class="fw-medium">Sophia
                        Martinez</strong>, a dedicated Real Estate Consultant committed to helping
                    clients find their dream properties. With extensive knowledge of the real estate
                    market and a personalized approach, I guide buyers and sellers to make informed
                    decisions and achieve their goals.</p>
                <p class="mb-3 text-muted">I value strong client relationships and strive to provide
                    exceptional service at every stage of the property journey. By understanding each
                    client's unique needs, I ensure a smooth, transparent, and satisfying real estate
                    experience.</p>

                <h6 class="mb-2">Experience</h6>
                <ul class="timeline-basic timeline-primary">
                    <li class="timeline-item active">
                        <span class="mb-1 fw-semibold d-block">Senior Real Estate Consultant - March
                            2019 - Present</span>
                        <p class="fs-sm mb-2 text-muted">Global Realty Group, San Francisco, CA</p>
                        <ul class="list-group-disc text-muted ps-5">
                            <li class="mb-2">
                                <p>Advised clients on buying, selling, and renting residential and
                                    commercial properties.</p>
                            </li>
                            <li class="mb-2">
                                <p>Conducted market research, property valuations, and investment
                                    analysis for clients.</p>
                            </li>
                            <li class="mb-2">
                                <p>Negotiated contracts and guided clients through legal and financial
                                    processes.</p>
                            </li>
                            <li class="mb-2">
                                <p>Maintained and grew client relationships through personalized service
                                    and follow-ups.</p>
                            </li>
                            <li class="mb-2">
                                <p>Prepared property listings, marketing materials, and virtual tours to
                                    showcase listings.</p>
                            </li>
                        </ul>
                    </li>
                    <li class="timeline-item active">
                        <span class="mb-1 fw-semibold d-block">Real Estate Associate</span>
                        <p class="fs-sm mb-2 text-muted">Urban Homes Realty, New York, NY</p>
                        <ul class="list-group-disc text-muted ps-5">
                            <li class="mb-2">
                                <p>Assisted clients in property searches, viewings, and negotiations.
                                </p>
                            </li>
                            <li class="mb-2">
                                <p>Prepared comparative market analysis reports and property
                                    documentation.</p>
                            </li>
                            <li class="mb-2">
                                <p>Supported senior consultants in marketing campaigns and open houses.
                                </p>
                            </li>
                            <li class="mb-2">
                                <p>Maintained client databases and managed property listings online.</p>
                            </li>
                        </ul>
                    </li>
                </ul>

                <h6 class="mb-3 mt-4">Portfolio Highlights</h6>
                <div class="row g-5">
                    <div class="col-md-6 col-lg-4 text-center">
                        <div class="overflow-hidden rounded-3">
                            <img src="assets/images/property-1.jpg" loading="lazy" alt=""
                                class="img-fluid img-scale-skew">
                        </div>
                        <h6 class="mt-2 mb-0"><a href="#!" class="text-body">Luxury Apartment
                                Listing</a></h6>
                    </div>

                    <div class="col-md-6 col-lg-4 text-center">
                        <div class="overflow-hidden rounded-3">
                            <img src="assets/images/property-2.jpg" loading="lazy" alt=""
                                class="img-fluid img-scale-skew">
                        </div>
                        <h6 class="mt-2 mb-0"><a href="#!" class="text-body">Modern Family Home</a></h6>
                    </div>

                    <div class="col-md-6 col-lg-4 text-center">
                        <div class="overflow-hidden rounded-3">
                            <img src="assets/images/property-5.jpg" loading="lazy" alt=""
                                class="img-fluid img-scale-skew">
                        </div>
                        <h6 class="mt-2 mb-0"><a href="#!" class="text-body">Commercial Office Space</a>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection