@extends('layouts.property-management.app')

@section('title', 'Add Unit')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4">
        <a href="{{ route('admin.property-management.units.index') }}"
           class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Back to Units
        </a>
        <h1 class="h3 fw-bold mt-2 mb-1">Add Unit</h1>
        <p class="text-muted mb-0">Register a rental unit under a managed property.</p>
    </div>

    <form action="{{ route('admin.property-management.units.store') }}" method="POST">
        @csrf
        @include('admin.property-management.units._form')
    </form>
</div>
@endsection