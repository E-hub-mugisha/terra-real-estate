@extends('layouts.property-management.app')

@section('title', 'Property Expenses')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Property Expenses</h1>
            <p class="text-muted mb-0">Track property operating and maintenance costs.</p>
        </div>

        <a href="{{ route('admin.property-management.expenses.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Record Expense
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-lg-4">
                    <input type="search" name="search" class="form-control"
                           value="{{ request('search') }}"
                           placeholder="Search reference, property, vendor...">
                </div>

                <div class="col-lg-2">
                    <select name="property_id" class="form-select">
                        <option value="">All properties</option>
                        @foreach($properties as $property)
                            <option value="{{ $property->id }}"
                                @selected(request('property_id') == $property->id)>
                                {{ $property->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2">
                    <select name="category" class="form-select">
                        <option value="">All categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}"
                                @selected(request('category') === $category)>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2">
                    <input type="date" name="from" class="form-control"
                           aria-label="From date" value="{{ request('from') }}">
                </div>

                <div class="col-lg-2">
                    <input type="date" name="to" class="form-control"
                           aria-label="To date" value="{{ request('to') }}">
                </div>

                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('admin.property-management.expenses.index') }}"
                       class="btn btn-light border">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Reference</th>
                        <th>Property / Unit</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Vendor</th>
                        <th class="text-end">Amount</th>
                        <th>Receipt</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($expenses as $expense)
                        <tr>
                            <td>
                                <a href="{{ route('admin.property-management.expenses.show', $expense) }}"
                                   class="fw-semibold text-decoration-none">
                                    {{ $expense->expense_reference }}
                                </a>
                                <div class="small text-muted">
                                    {{ ucfirst($expense->status) }}
                                </div>
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $expense->managedProperty?->name }}
                                </div>
                                <div class="small text-muted">
                                    {{ $expense->unit
                                        ? 'Unit ' . $expense->unit->unit_number
                                        : 'Property-wide' }}
                                </div>
                            </td>

                            <td>{{ $expense->category }}</td>
                            <td>{{ $expense->expense_date?->format('d M Y') }}</td>
                            <td>{{ $expense->vendor_name ?: '—' }}</td>

                            <td class="text-end text-nowrap fw-semibold">
                                {{ $expense->currency }}
                                {{ number_format((float) $expense->amount, 2) }}
                            </td>

                            <td>
                                @if($expense->receipt_path)
                                    <span class="text-success">
                                        <i class="bi bi-paperclip"></i> Attached
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.property-management.expenses.show', $expense) }}"
                                   class="btn btn-sm btn-light border" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('admin.property-management.expenses.edit', $expense) }}"
                                   class="btn btn-sm btn-light border" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-wallet2 fs-2 text-muted"></i>
                                <p class="fw-semibold mt-2 mb-1">No expenses found</p>
                                <p class="text-muted small mb-3">
                                    Start tracking costs for your managed properties.
                                </p>
                                <a href="{{ route('admin.property-management.expenses.create') }}"
                                   class="btn btn-primary btn-sm">Record Expense</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($expenses->hasPages())
            <div class="card-footer bg-white">
                {{ $expenses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection