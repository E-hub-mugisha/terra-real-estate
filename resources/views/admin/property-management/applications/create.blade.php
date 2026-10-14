@extends('layouts.property-management.app')

@section('title', 'New Tenant Application')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4">
        <a href="{{ route('admin.property-management.applications.index') }}"
           class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Back to Applications
        </a>

        <h1 class="h3 fw-bold mt-2 mb-1">New Tenant Application</h1>
        <p class="text-muted mb-0">Register a tenant's interest in renting a unit.</p>
    </div>

    <form action="{{ route('admin.property-management.applications.store') }}"
          method="POST">
        @csrf
        @include('admin.property-management.applications._form')
    </form>
</div>
@endsection