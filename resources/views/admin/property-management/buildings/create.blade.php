@extends('layouts.property-management.app')

@section('title', 'Add Building')
@section('breadcrumb', 'Property Management / Buildings / Create')

@section('content')
<div class="container-fluid px-0">

    <div class="mb-4">
        <a href="{{ route('admin.property-management.buildings.index') }}"
           class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Back to Buildings
        </a>
        <h4 class="fw-bold mt-2 mb-1">Add Building</h4>
        <p class="text-muted mb-0">Register a building under a managed property.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST"
                  action="{{ route('admin.property-management.buildings.store') }}">
                @include('admin.property-management.buildings._form')

                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Save Building
                    </button>
                    <a href="{{ route('admin.property-management.buildings.index') }}"
                       class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection