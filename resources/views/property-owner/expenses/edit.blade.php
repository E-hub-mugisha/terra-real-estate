@extends('layouts.property-management.app')

@section('title', 'Edit Property Expense')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Edit Property Expense</h1>
        <p class="text-muted mb-0">{{ $expense->expense_reference }}</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @include('admin.property-management.expenses._form')
        </div>
    </div>
</div>
@endsection