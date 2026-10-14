@extends('layouts.property-management.app')

@section('title', 'Edit Property')
@section('breadcrumb', 'Property Management / Properties / Edit')

@section('content')
<div class="container-fluid px-0">

    <div class="mb-4">
        <a href="{{ route('admin.property-management.properties.show', $property) }}"
           class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Back to Property
        </a>

        <h4 class="fw-bold mt-2 mb-1">Edit Property</h4>
        <p class="text-muted mb-0">
            Update the details for {{ $property->name }}.
        </p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">
                Please correct the following errors:
            </div>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.property-management.properties.update', $property) }}"
                  method="POST">
                @include('admin.property-management.properties._form')

                <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Update Property
                    </button>

                    <a href="{{ route('admin.property-management.properties.show', $property) }}"
                       class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection