@extends('layouts.property-management.app')

@section('title', 'Expense Details')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="{{ route('admin.property-management.expenses.index') }}"
               class="small text-muted text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> All Expenses
            </a>
            <h1 class="h3 fw-bold mt-2 mb-1">{{ $expense->expense_reference }}</h1>
            <p class="text-muted mb-0">Property expense details and supporting documents.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.property-management.expenses.edit', $expense) }}"
               class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit Expense
            </a>

            <form method="POST"
                  action="{{ route('admin.property-management.expenses.destroy', $expense) }}"
                  onsubmit="return confirm('Permanently delete this expense record?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="text-muted small mb-1">Recorded Expense Amount</div>
                    <div class="display-5 fw-bold mb-3">
                        {{ $expense->currency }}
                        {{ number_format((float) $expense->amount, 2) }}
                    </div>

                    <span class="badge text-bg-secondary mb-4">
                        {{ ucfirst($expense->status) }}
                    </span>

                    <hr>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-muted small">Expense Date</div>
                            <div class="fw-semibold">
                                {{ $expense->expense_date?->format('d F Y') ?? '—' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Category</div>
                            <div class="fw-semibold">{{ $expense->category }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Vendor / Supplier</div>
                            <div class="fw-semibold">{{ $expense->vendor_name ?: '—' }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Recorded By</div>
                            <div class="fw-semibold">
                                {{ $expense->recorder?->name ?? 'System' }}
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold">Description</h6>
                    <p class="mb-0" style="white-space: pre-line">{{ $expense->description }}</p>

                    @if($expense->notes)
                        <hr class="my-4">
                        <h6 class="fw-bold">Internal Notes</h6>
                        <p class="mb-0" style="white-space: pre-line">{{ $expense->notes }}</p>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Supporting Document</h5>

                    @if($expense->receipt_path)
                        <p class="text-muted">
                            A supporting document has been attached to this expense.
                        </p>

                        <a href="{{ route('admin.property-management.expenses.receipt', $expense) }}"
                           class="btn btn-light border" target="_blank" rel="noopener">
                            <i class="bi bi-file-earmark-text me-1"></i> View Receipt
                        </a>
                    @else
                        <p class="text-muted mb-0">
                            No receipt or supporting document was uploaded.
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Managed Property</h5>

                    <div class="fw-semibold fs-5">
                        {{ $expense->managedProperty?->name ?? '—' }}
                    </div>

                    <div class="text-muted small mb-3">
                        {{ $expense->managedProperty?->property_code }}
                    </div>

                    <hr>

                    <div class="text-muted small">Property Type</div>
                    <div class="mb-3">
                        {{ ucfirst(str_replace('_', ' ', $expense->managedProperty?->property_type ?? '—')) }}
                    </div>

                    <div class="text-muted small">Location</div>
                    <div>
                        {{ collect([
                            $expense->managedProperty?->district,
                            $expense->managedProperty?->province,
                        ])->filter()->implode(', ') ?: '—' }}
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Unit</h5>

                    @if($expense->unit)
                        <div class="fw-semibold">
                            Unit {{ $expense->unit->unit_number }}
                        </div>
                        <div class="text-muted small">
                            {{ ucfirst(str_replace('_', ' ', $expense->unit->unit_type ?? '—')) }}
                        </div>
                    @else
                        <p class="text-muted mb-0">
                            This is a property-wide expense rather than a unit-specific cost.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection