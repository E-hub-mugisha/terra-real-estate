@extends('layouts.property-management.app')

@section('title', 'Edit Unit')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4">
        <a href="{{ route('admin.property-management.units.show', $unit) }}"
           class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Back to Unit
        </a>
        <h1 class="h3 fw-bold mt-2 mb-1">Edit Unit</h1>
        <p class="text-muted mb-0">Update unit {{ $unit->unit_number }}.</p>
    </div>

    <form action="{{ route('admin.property-management.units.update', $unit) }}"
          method="POST">
        @csrf
        @method('PUT')
        @include('admin.property-management.units._form')
    </form>
</div>
@endsection