@extends('layouts.agents')
@section('title', 'Profile')
@section('content')

<div class="position-relative mb-8">
    <div class="position-relative overflow-hidden rounded h-52 profile-widget">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-25"></div>
    </div>
    <div class="ps-8 d-flex flex-wrap align-items-center gap-5">
        <div class="position-relative d-inline-block profile-avatar">
            <div class="profile-avatar-wrapper mt-n14">
                <img src="{{ $profile->profile_image 
                            ? asset('storage/'.$profile->profile_image) 
                            : asset('front/assets/img/avatar.png') }}" loading="lazy" alt="user-45"
                    class="mx-auto profile-avatar-img size-32">
            </div>
        </div>
        <div class="flex-grow-1 mb-2">
            <div class="avatar justify-content-start gap-1">
                <h5 class="mt-2 mb-3">{{ $profile->full_name }}</h5>
                <i data-lucide="badge-check" class="size-5 icon-primary"></i>
            </div>
            <ul class="text-muted avatar gap-2 justify-content-start ps-0 mb-0 flex-wrap">
                <li class="d-flex align-items-center gap-2">
                    <i data-lucide="building-2" class="size-4"></i>
                    <span>Real Estate {{ $profile->user->role }}</span>
                </li>
                <li class="d-flex align-items-center gap-2">
                    <i data-lucide="map-pin" class="size-4"></i>
                    <span>{{ $profile->office_location }}</span>
                </li>
                <li class="d-flex align-items-center gap-2">
                    <i data-lucide="calendar-days" class="size-4"></i>
                    <span>{{ $profile->created_at->format('d F, Y') }}</span>
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
                Services
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="pages-user-followers.html">
                <i data-lucide="user-round" class="size-4 me-1"></i>
                Lands
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="pages-user-documents.html">
                <i data-lucide="file-text" class="size-4 me-1"></i>
                Homes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="pages-user-notes.html">
                <i data-lucide="list" class="size-4 me-1"></i>
                Reviews
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
            <div class="card-header">
                <h6 class="card-title mb-0">Introductions</h6>
            </div>
            <div class="card-body">
                <p class="mb-4 text-uppercase fs-sm fw-medium text-muted">About</p>
                <div class="mb-3">
                    <h6 class="d-flex align-items-center mb-4 fw-medium">
                        <i data-lucide="monitor" class="size-4 text-muted me-3"></i>
                        <span>{{ $profile->full_name }}</span>
                    </h6>
                    <h6 class="d-flex align-items-center mb-4 fw-medium">
                        <i data-lucide="briefcase-business" class="size-4 text-muted me-3"></i>
                        <span>Real Estate Agent</span>
                    </h6>
                    <h6 class="d-flex align-items-center mb-4 fw-medium">
                        <i data-lucide="map-pin" class="size-4 text-muted me-3"></i>
                        <span>{{ $profile->office_location }}</span>
                    </h6>
                </div>

                <div class="pt-4 mt-4 border-top">
                    <h6 class="d-flex align-items-center mb-4 fw-medium">
                        <i data-lucide="mail" class="size-4 text-muted me-3"></i>
                        <a href="#!" class="text-body">{{ $profile->user->email }}</a>
                    </h6>
                    <h6 class="d-flex align-items-center mb-4 fw-medium">
                        <i data-lucide="phone" class="size-4 text-muted me-3"></i>
                        <a href="#!" class="text-body">{{ $profile->phone }}</a>
                    </h6>
                </div>

                <p class="pt-4 mb-3 border-top text-uppercase fs-sm fw-medium text-muted">Fluent In</p>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge border text-muted">{{ $profile->languages }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-8">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2">Overview</h6>
                <p class="mb-2 text-muted">
                    {{ $profile->bio }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection