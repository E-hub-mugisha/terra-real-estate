@extends('layouts.property-management')

@section('title', 'Rent Ledger')

@section('page-title', 'Rent Ledger')

@section('page-subtitle', 'View tenant invoices, payments and account balances.')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <form method="GET"
              action="{{ route('property-management.ledger.index') }}"
              class="row g-3 mb-4">

            <div class="col-md-4">

                <label class="form-label">
                    Search
                </label>

                <input type="text"
                       name="search"
                       class="form-control"
                       value="{{ request('search') }}"
                       placeholder="Invoice, payment or tenant">

            </div>

            <div class="col-md-3">

                <label class="form-label">
                    Tenant
                </label>

                <select name="tenant_id"
                        class="form-select">

                    <option value="">
                        All tenants
                    </option>

                    @foreach($tenants as $tenant)

                        <option value="{{ $tenant->id }}"
                            @selected(request('tenant_id') == $tenant->id)>

                            {{ trim(($tenant->first_name ?? '') . ' ' . ($tenant->last_name ?? '')) }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-3">

                <label class="form-label">
                    Entry Type
                </label>

                <select name="entry_type"
                        class="form-select">

                    <option value="">
                        All entries
                    </option>

                    <option value="invoice"
                        @selected(request('entry_type') === 'invoice')>
                        Invoice
                    </option>

                    <option value="payment"
                        @selected(request('entry_type') === 'payment')>
                        Payment
                    </option>

                    <option value="deposit"
                        @selected(request('entry_type') === 'deposit')>
                        Deposit
                    </option>

                    <option value="adjustment"
                        @selected(request('entry_type') === 'adjustment')>
                        Adjustment
                    </option>

                    <option value="refund"
                        @selected(request('entry_type') === 'refund')>
                        Refund
                    </option>

                </select>

            </div>

            <div class="col-md-2 d-flex align-items-end">

                <button type="submit"
                        class="btn btn-terra w-100">

                    Filter

                </button>

            </div>

        </form>


        <div class="table-responsive">

            <table class="table align-middle">

                <thead class="table-light">

                    <tr>

                        <th>Date</th>

                        <th>Tenant</th>

                        <th>Type</th>

                        <th>Description</th>

                        <th class="text-end">
                            Debit
                        </th>

                        <th class="text-end">
                            Credit
                        </th>

                        <th class="text-end">
                            Balance
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($entries as $entry)

                        <tr>

                            <td>
                                {{ $entry->entry_date?->format('d M Y') }}
                            </td>

                            <td>

                                <div class="fw-semibold">

                                    {{ trim(
                                        ($entry->tenant->first_name ?? '') .
                                        ' ' .
                                        ($entry->tenant->last_name ?? '')
                                    ) }}

                                </div>

                            </td>

                            <td>

                                <span class="badge bg-light text-dark">

                                    {{ ucfirst($entry->entry_type) }}

                                </span>

                            </td>

                            <td>

                                {{ $entry->description }}

                            </td>

                            <td class="text-end">

                                @if((float) $entry->debit > 0)

                                    {{ number_format($entry->debit, 0) }}
                                    RWF

                                @else
                                    —
                                @endif

                            </td>

                            <td class="text-end">

                                @if((float) $entry->credit > 0)

                                    {{ number_format($entry->credit, 0) }}
                                    RWF

                                @else
                                    —
                                @endif

                            </td>

                            <td class="text-end fw-semibold">

                                {{ number_format($entry->balance, 0) }}
                                RWF

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center text-muted py-5">

                                No ledger entries found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <div class="mt-4">

            {{ $entries->links() }}

        </div>

    </div>

</div>

@endsection