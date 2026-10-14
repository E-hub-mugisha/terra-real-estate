@extends('layouts.property-management.app')

@section('title', 'Edit Tenant')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4">
        <a href="{{ route('admin.property-management.tenants.show', $tenant) }}"
           class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Back to Tenant
        </a>

        <h1 class="h3 fw-bold mt-2 mb-1">Edit Tenant</h1>
        <p class="text-muted mb-0">
            Update {{ $tenant->first_name }} {{ $tenant->last_name }}'s profile.
        </p>
    </div>

    <form action="{{ route('admin.property-management.tenants.update', $tenant) }}"
          method="POST">
        @csrf
        @method('PUT')
        @include('admin.property-management.tenants._form')
    </form>
</div>
@endsection