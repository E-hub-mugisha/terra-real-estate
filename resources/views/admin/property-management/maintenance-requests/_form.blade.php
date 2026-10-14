@php
    $isEdit = $maintenanceRequest->exists;
@endphp

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="mb-4">Request details</h5>

                <div class="mb-3">
                    <label for="title" class="form-label">Request title *</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $maintenanceRequest->title) }}"
                        maxlength="255"
                        required
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="managed_property_id" class="form-label">
                            Managed property *
                        </label>
                        <select
                            id="managed_property_id"
                            name="managed_property_id"
                            class="form-select @error('managed_property_id') is-invalid @enderror"
                            required
                        >
                            <option value="">Select property</option>
                            @foreach ($properties as $property)
                                <option
                                    value="{{ $property->id }}"
                                    @selected(old('managed_property_id', $maintenanceRequest->managed_property_id) == $property->id)
                                >
                                    {{ $property->name }}
                                    ({{ $property->property_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('managed_property_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="unit_id" class="form-label">Unit</label>
                        <select
                            id="unit_id"
                            name="unit_id"
                            class="form-select @error('unit_id') is-invalid @enderror"
                        >
                            <option value="">Property-wide / no specific unit</option>
                            @foreach ($units as $unit)
                                <option
                                    value="{{ $unit->id }}"
                                    data-property="{{ $unit->managed_property_id }}"
                                    @selected(old('unit_id', $maintenanceRequest->unit_id) == $unit->id)
                                >
                                    {{ $unit->unit_number }}
                                    — {{ $unit->managedProperty?->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tenant_id" class="form-label">Reporting tenant</label>
                        <select
                            id="tenant_id"
                            name="tenant_id"
                            class="form-select @error('tenant_id') is-invalid @enderror"
                        >
                            <option value="">Not linked to a tenant</option>
                            @foreach ($tenants as $tenant)
                                <option
                                    value="{{ $tenant->id }}"
                                    @selected(old('tenant_id', $maintenanceRequest->tenant_id) == $tenant->id)
                                >
                                    {{ $tenant->first_name }} {{ $tenant->last_name }}
                                    @if ($tenant->tenant_code)
                                        ({{ $tenant->tenant_code }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('tenant_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="category" class="form-label">Category *</label>
                        <select
                            id="category"
                            name="category"
                            class="form-select @error('category') is-invalid @enderror"
                            required
                        >
                            <option value="">Select category</option>
                            @foreach ([
                                'plumbing' => 'Plumbing',
                                'electrical' => 'Electrical',
                                'structural' => 'Structural',
                                'appliance' => 'Appliance',
                                'cleaning' => 'Cleaning',
                                'security' => 'Security',
                                'other' => 'Other',
                            ] as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    @selected(old('category', $maintenanceRequest->category) === $value)
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label for="description" class="form-label">Description *</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        class="form-control @error('description') is-invalid @enderror"
                        required
                    >{{ old('description', $maintenanceRequest->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body p-4">
                <h5 class="mb-4">Scheduling and resolution</h5>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="requested_date" class="form-label">Date reported *</label>
                        <input
                            type="date"
                            id="requested_date"
                            name="requested_date"
                            class="form-control @error('requested_date') is-invalid @enderror"
                            value="{{ old('requested_date', $maintenanceRequest->requested_date?->format('Y-m-d')) }}"
                            required
                        >
                        @error('requested_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="scheduled_date" class="form-label">Scheduled date</label>
                        <input
                            type="date"
                            id="scheduled_date"
                            name="scheduled_date"
                            class="form-control @error('scheduled_date') is-invalid @enderror"
                            value="{{ old('scheduled_date', $maintenanceRequest->scheduled_date?->format('Y-m-d')) }}"
                        >
                        @error('scheduled_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="completed_date" class="form-label">Completed date</label>
                        <input
                            type="date"
                            id="completed_date"
                            name="completed_date"
                            class="form-control @error('completed_date') is-invalid @enderror"
                            value="{{ old('completed_date', $maintenanceRequest->completed_date?->format('Y-m-d')) }}"
                        >
                        @error('completed_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label for="resolution_notes" class="form-label">Resolution notes</label>
                    <textarea
                        id="resolution_notes"
                        name="resolution_notes"
                        rows="4"
                        class="form-control @error('resolution_notes') is-invalid @enderror"
                    >{{ old('resolution_notes', $maintenanceRequest->resolution_notes) }}</textarea>
                    @error('resolution_notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="mb-4">Assignment and status</h5>

                <div class="mb-3">
                    <label for="priority" class="form-label">Priority *</label>
                    <select
                        id="priority"
                        name="priority"
                        class="form-select @error('priority') is-invalid @enderror"
                        required
                    >
                        @foreach ($priorities as $priority)
                            <option
                                value="{{ $priority }}"
                                @selected(old('priority', $maintenanceRequest->priority) === $priority)
                            >
                                {{ ucfirst(str_replace('_', ' ', $priority)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select
                        id="status"
                        name="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required
                    >
                        @foreach ($statuses as $status)
                            <option
                                value="{{ $status }}"
                                @selected(old('status', $maintenanceRequest->status) === $status)
                            >
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="assigned_to" class="form-label">Assigned to</label>
                    <select
                        id="assigned_to"
                        name="assigned_to"
                        class="form-select @error('assigned_to') is-invalid @enderror"
                    >
                        <option value="">Unassigned</option>
                        @foreach ($users as $user)
                            <option
                                value="{{ $user->id }}"
                                @selected(old('assigned_to', $maintenanceRequest->assigned_to) == $user->id)
                            >
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body p-4">
                <h5 class="mb-4">Cost estimate</h5>

                <div class="mb-3">
                    <label for="estimated_cost" class="form-label">Estimated cost</label>
                    <input
                        type="number"
                        id="estimated_cost"
                        name="estimated_cost"
                        min="0"
                        step="0.01"
                        class="form-control @error('estimated_cost') is-invalid @enderror"
                        value="{{ old('estimated_cost', $maintenanceRequest->estimated_cost) }}"
                    >
                    @error('estimated_cost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="actual_cost" class="form-label">Actual cost</label>
                    <input
                        type="number"
                        id="actual_cost"
                        name="actual_cost"
                        min="0"
                        step="0.01"
                        class="form-control @error('actual_cost') is-invalid @enderror"
                        value="{{ old('actual_cost', $maintenanceRequest->actual_cost) }}"
                    >
                    @error('actual_cost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="currency" class="form-label">Currency *</label>
                    <select
                        id="currency"
                        name="currency"
                        class="form-select @error('currency') is-invalid @enderror"
                        required
                    >
                        @foreach (['RWF', 'USD'] as $currency)
                            <option
                                value="{{ $currency }}"
                                @selected(old('currency', $maintenanceRequest->currency ?? 'RWF') === $currency)
                            >
                                {{ $currency }}
                            </option>
                        @endforeach
                    </select>
                    @error('currency')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a
        href="{{ $isEdit
            ? route('admin.property-management.maintenance-requests.show', $maintenanceRequest)
            : route('admin.property-management.maintenance-requests.index') }}"
        class="btn btn-light border"
    >
        Cancel
    </a>

    <button type="submit" class="btn btn-primary">
        {{ $isEdit ? 'Save changes' : 'Create request' }}
    </button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const propertySelect = document.getElementById('managed_property_id');
    const unitSelect = document.getElementById('unit_id');

    function filterUnits() {
        const propertyId = propertySelect.value;

        Array.from(unitSelect.options).forEach(function (option) {
            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden = propertyId !== '' &&
                option.dataset.property !== propertyId;
        });

        const selected = unitSelect.options[unitSelect.selectedIndex];

        if (selected && selected.value && selected.hidden) {
            unitSelect.value = '';
        }
    }

    propertySelect.addEventListener('change', filterUnits);
    filterUnits();
});
</script>
@endpush