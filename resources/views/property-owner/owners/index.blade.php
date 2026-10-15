@extends('layouts.property-management.app')

@section('title', 'Property Owners')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Property Owners</h1>
            <p class="text-muted mb-0">
                Manage owner profiles for the property management module.
            </p>
        </div>

        <a href="{{ route('admin.property-management.owners.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Property Owner
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Owner</th>
                            <th>Contact</th>
                            <th>Owner Type</th>
                            <th>Properties</th>
                            <th>Verification</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($owners as $owner)
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-semibold">
                                        {{ $owner->user?->name ?? 'User unavailable' }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ $owner->user?->email ?? '—' }}
                                    </div>
                                </td>

                                <td>
                                    {{ $owner->phone ?: '—' }}
                                </td>

                                <td>
                                    {{ ucfirst($owner->owner_type) }}
                                    @if ($owner->company_name)
                                        <div class="small text-muted">
                                            {{ $owner->company_name }}
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge text-bg-light">
                                        {{ $owner->properties_count }}
                                    </span>
                                </td>

                                <td>
                                    @php
                                        $badgeClass = match ($owner->verification_status) {
                                            'verified' => 'text-bg-success',
                                            'rejected' => 'text-bg-danger',
                                            default => 'text-bg-warning',
                                        };
                                    @endphp

                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($owner->verification_status) }}
                                    </span>
                                </td>

                                <td class="text-end pe-3">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.property-management.owners.show', $owner) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="View owner">
                                            View
                                        </a>

                                        <a href="{{ route('admin.property-management.owners.edit', $owner) }}"
                                           class="btn btn-sm btn-outline-secondary"
                                           title="Edit owner">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="mb-2 text-muted">
                                        <i class="bi bi-people fs-1"></i>
                                    </div>
                                    <h2 class="h6">No property owners yet</h2>
                                    <p class="text-muted mb-3">
                                        Create an owner profile for an existing user.
                                    </p>
                                    <a href="{{ route('admin.property-management.owners.create') }}"
                                       class="btn btn-primary btn-sm">
                                        Add Property Owner
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($owners->hasPages())
            <div class="card-footer bg-white">
                {{ $owners->links() }}
            </div>
        @endif
    </div>
</div>
@endsection