@extends('layouts.property-management.app')

@section('title', 'Create Maintenance Request')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Create maintenance request</h1>
            <p class="text-muted mb-0">Record a repair, service issue, or property maintenance task.</p>
        </div>

        <a href="{{ route('admin.property-management.maintenance-requests.index') }}"
           class="btn btn-light border">
            <i class="bi bi-arrow-left me-1"></i> Back to requests
        </a>
    </div>

    <form method="POST"
          action="{{ route('admin.property-management.maintenance-requests.store') }}">
        @csrf
        @include('admin.property-management.maintenance-requests._form')
    </form>
</div>
@endsection