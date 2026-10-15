@extends('layouts.property-management.app')

@section('title', 'Edit Tenant Application')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4">
        <a href="{{ route('admin.property-management.applications.show', $application) }}"
           class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Back to Application
        </a>

        <h1 class="h3 fw-bold mt-2 mb-1">Edit Application</h1>
        <p class="text-muted mb-0">
            Update {{ $application->application_number }}.
        </p>
    </div>

    <form action="{{ route('admin.property-management.applications.update', $application) }}"
          method="POST">
        @csrf
        @method('PUT')
        @include('admin.property-management.applications._form')
    </form>
</div>
@endsection