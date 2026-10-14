@extends('layouts.property-management.app')

@section('title', 'Record Property Expense')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Record Property Expense</h1>
        <p class="text-muted mb-0">Record a cost against a managed property or unit.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @include('admin.property-management.expenses._form')
        </div>
    </div>
</div>
@endsection