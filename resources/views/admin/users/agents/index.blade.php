@extends('layouts.app')
@section('title', 'Agents Lists')
@section('content')

<div class="gap-2 page-heading mb-3 flex-column flex-md-row">
    <h6 class="flex-grow-1 mb-0">List View</h6>
    <ul class="breadcrumb flex-shrink-0 mb-0">
        <li class="breadcrumb-item"><a href="#!">Agents</a></li>
        <li class="breadcrumb-item active">List View</li>
    </ul>
</div>
<div class="d-flex flex-wrap gap-5 justify-content-between align-items-center mb-5">
    <div>
        <label for="searchAgentInput" class="form-label d-none">Search</label>
        <div class="position-relative">
            <input type="text" class="form-control ps-9" id="searchAgentInput"
                placeholder="Search for agents...">
            <i
                class="ri-search-line size-4 text-muted position-absolute top-50 start-0 ms-3 translate-middle-y"></i>
        </div>
    </div>
    <a href="{{ route('admin.agents.create') }}" class="btn btn-primary d-flex align-items-center gap-1"><i
            data-lucide="plus" class="size-4 me-1"></i>Add Agents</a>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-5 g-4">
    @foreach ($agents as $agent)
    <div class="card">
        <div class="card-header d-flex gap-4 align-items-center">
            <div class="flex-grow-1">
                <button type="button" class="btn btn-secondary btn-icon size-8 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="${t.properties} Properties">
                    <i data-lucide="house" class="size-4"></i>
                </button>
            </div>
            <div class="dropdown flex-shrink-0">
                <a href="#!" class="link link-custom-primary" aria-label="dropdown link" data-bs-toggle="dropdown" aria-expanded="false">
                    <i data-lucide="ellipsis-vertical" class="size-4"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('admin.agents.show', $agent->id) }}">View Profile</a></li>
                    <li><a class="dropdown-item" href="#!">View Performance</a></li>
                    <li><a class="dropdown-item" href="#!">View Listings</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body pt-4 position-relative">
            <span class="bg-warning-subtle lh-sm text-warning py-2 px-4 position-absolute top-0 rounded-1 rounded-start-0 start-0 mt-10 fs-12 fw-semibold">
                <i class="bi bi-star-fill me-1 fs-11"></i> {{ $agent->rating }}
            </span>
            <div class="text-center">
                <div class="profile-avatar position-relative d-inline-block">
                    <img src="{{ asset('dashboard/assets/images/user.jfif') }}" loading="lazy" alt="Agent Name" class="rounded-circle flex-shrink-0 size-16">
                    <div class="status-indicator bg-success rounded-circle size-3"></div>
                </div>
                <div class="mt-5">
                    <a href="#!" class="fs-16 text-reset fw-medium d-block mb-1">{{ $agent->full_name }}</a>
                    <p class="text-muted fs-sm">{{ $agent->role }}</p>
                </div>
            </div>
            <div class="row text-center mt-6">
                <div class="col-4">
                    <h6 class="mb-1">12</h6>
                    <p class="mb-0 fs-13 text-muted">Sales</p>
                </div>
                <div class="col-4">
                    <h6 class="mb-1">24</h6>
                    <p class="mb-0 fs-13 text-muted">Clients</p>
                </div>
                <div class="col-4">
                    <h6 class="mb-1">{{ $agent->years_experience }}</h6>
                    <p class="mb-0 fs-13 text-muted">Years Exp.</p>
                </div>
            </div>
            <div class="d-flex gap-3 mt-7">
                <button type="button" class="btn btn-outline-light w-100"><i data-lucide="mail" class="me-1 size-4"></i> Email</button>
                <button type="button" class="btn btn-sub-primary w-100"><i data-lucide="phone-outgoing" class="me-1 size-4"></i> Call</button>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row align-items-center g-3 mb-5">
    <div class="col-md-6">
        <p class="text-muted text-center text-md-start mb-0" id="showingResults">Showing <b
                class="me-1">1-10</b> of <b class="ms-1">16</b> Results</p>
    </div>
    <div class="col-md-6">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center justify-content-md-end mb-0"></ul>
        </nav>
    </div>
</div>

@endsection