@extends('layouts.property-management.app')

@section('title', 'Register Tenant')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4">
        <a href="{{ route('admin.property-management.tenants.index') }}"
           class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Back to Tenants
        </a>

        <h1 class="h3 fw-bold mt-2 mb-1">Register Tenant</h1>
        <p class="text-muted mb-0">Create a tenant profile for property management.</p>
    </div>

    <form action="{{ route('admin.property-management.tenants.store') }}"
          method="POST">
        @csrf
        @include('admin.property-management.tenants._form')
    </form>
</div>
@endsection