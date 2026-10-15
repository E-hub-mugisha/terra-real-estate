@extends('layouts.property-management.app')

@section('title', 'Create Lease')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Create Lease</h1>
            <p class="text-muted mb-0">Prepare a new property lease agreement.</p>
        </div>

        <a href="{{ route('admin.property-management.leases.index') }}"
           class="btn btn-light border">Back to Leases</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @include('admin.property-management.leases._form')
        </div>
    </div>
</div>
@endsection