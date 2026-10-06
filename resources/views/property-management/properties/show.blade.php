@extends('layouts.property-management')

@section('title', $property->title . ' - Property Management')
@section('page-title', $property->title)
@section('page-subtitle', collect([$property->sector, $property->district])->filter()->implode(', ') ?: 'Property details')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('property-management.properties.index') }}">Properties</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($property->title, 40) }}</li>
@endsection

{{-- ==========================================================
     TOP-RIGHT ACTIONS
=========================================================== --}}
@section('page-actions')

    @if(!$property->is_managed)

        <form method="POST" action="{{ route('property-management.properties.activate', $property) }}">
            @csrf
            <button type="submit" class="btn btn-terra-navy">
                <i class="bi bi-shield-check me-1"></i> Activate Management
            </button>
        </form>

    @else

        <form method="POST"
              action="{{ route('property-management.properties.deactivate', $property) }}"
              onsubmit="return confirm('Disable property management for this property?')">
            @csrf
            <button type="submit" class="btn btn-outline-secondary">
                <i class="bi bi-slash-circle me-1"></i> Disable Management
            </button>
        </form>

    @endif

    <button type="button" class="btn btn-terra" data-bs-toggle="modal" data-bs-target="#addBuildingModal">
        <i class="bi bi-plus-lg me-1"></i> Add Building
    </button>

@endsection


@push('styles')
<style>
    .terra-page-actions { flex-wrap: wrap; }

    /* ---------- Property information ---------- */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px 28px;
    }

    .info-label {
        color: var(--terra-muted);
        font-size: 12.5px;
        font-weight: 500;
        margin-bottom: 4px;
    }

    .info-value {
        color: var(--terra-navy);
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .location-line {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 11px 0;
        border-bottom: 1px dashed var(--terra-border);
    }

    .location-line:last-child { border-bottom: 0; padding-bottom: 0; }
    .location-line:first-child { padding-top: 0; }

    .location-line i { color: var(--terra-orange); margin-top: 2px; }

    /* ---------- Buildings ---------- */
    .building-block {
        border: 1px solid var(--terra-border);
        border-radius: var(--radius-lg);
        background: #fff;
        overflow: hidden;
    }

    .building-block + .building-block { margin-top: 20px; }

    .building-head {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 20px;
        background: var(--terra-surface-2);
        border-bottom: 1px solid var(--terra-border);
    }

    .building-toggle {
        display: flex;
        align-items: center;
        gap: 14px;
        background: transparent;
        border: 0;
        padding: 0;
        text-align: left;
        flex: 1;
        min-width: 240px;
        color: inherit;
    }

    .building-icon {
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        border-radius: 11px;
        background: var(--terra-navy);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .building-name {
        font-family: var(--font-display);
        font-size: 21px;
        font-weight: 700;
        color: var(--terra-navy);
        line-height: 1.15;
    }

    .building-meta { font-size: 12.5px; color: var(--terra-muted); }

    .building-toggle .chevron { transition: transform .2s ease; color: var(--terra-muted); }
    .building-toggle[aria-expanded="false"] .chevron { transform: rotate(-90deg); }

    .building-occupancy { min-width: 150px; }

    .building-occupancy .label {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: var(--terra-muted);
        margin-bottom: 5px;
    }

    .building-occupancy .label strong { color: var(--terra-navy); }

    /* ---------- Floors ---------- */
    .floor-row { padding: 18px 20px; }
    .floor-row + .floor-row { border-top: 1px solid var(--terra-border); }

    .floor-head {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
    }

    .floor-name { font-weight: 700; color: var(--terra-navy); margin: 0; }
    .floor-sub { font-size: 12.5px; color: var(--terra-muted); }

    .unit-wrap {
        border: 1px solid var(--terra-border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .unit-table { margin-bottom: 0; --bs-table-hover-bg: var(--terra-surface-2); }

    .unit-table thead th {
        background: var(--terra-surface-2);
        color: var(--terra-muted);
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        padding: 11px 14px;
        border-bottom: 1px solid var(--terra-border);
    }

    .unit-table td {
        vertical-align: middle;
        padding: 12px 14px;
        font-size: 13.5px;
        border-color: var(--terra-border);
    }

    .unit-table tbody tr:last-child td { border-bottom: 0; }

    .unit-number { font-weight: 700; color: var(--terra-navy); }

    .badge-neutral {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #eef0f4;
        color: #4b5563;
    }

    .badge-neutral::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .icon-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 1px solid var(--terra-border);
        background: #fff;
        color: var(--terra-navy);
        font-size: 14px;
        transition: all .2s ease;
    }

    .icon-btn:hover { border-color: var(--terra-orange); color: var(--terra-orange); }
    .icon-btn.danger:hover { border-color: var(--terra-danger); color: var(--terra-danger); background: #fef4f4; }

    .empty-inline {
        text-align: center;
        padding: 26px 16px;
        border: 1px dashed var(--terra-border-strong);
        border-radius: var(--radius);
        background: var(--terra-surface-2);
        color: var(--terra-muted);
    }

    /* ---------- Modals ---------- */
    .modal-content { border: 0; border-radius: var(--radius-lg); overflow: hidden; }
    .modal-header { background: var(--terra-surface-2); border-bottom: 1px solid var(--terra-border); padding: 18px 22px; }
    .modal-title { font-family: var(--font-display); font-size: 23px; font-weight: 700; color: var(--terra-navy); }
    .modal-body { padding: 22px; }
    .modal-footer { border-top: 1px solid var(--terra-border); background: var(--terra-surface-2); padding: 14px 22px; }

    @media (max-width: 991.98px) {
        .info-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 575.98px) {
        .info-grid { grid-template-columns: 1fr; gap: 16px; }
        .building-head, .floor-row { padding-left: 14px; padding-right: 14px; }
    }
</style>
@endpush


@section('content')

@php
    $buildings = $property->buildings;

    $allFloors = $buildings->flatMap(fn ($b) => $b->floors);
    $allUnits  = $allFloors->flatMap(fn ($f) => $f->units);

    $unitTotal      = $allUnits->count();
    $unitOccupied   = $allUnits->where('occupancy_status', 'occupied')->count();
    $unitMaint      = $allUnits->where('occupancy_status', 'under_maintenance')->count();
    $unitVacant     = $unitTotal - $unitOccupied - $unitMaint;
    $occupancyRate  = $unitTotal ? round(($unitOccupied / $unitTotal) * 100) : 0;

    $rentRoll       = $allUnits->where('occupancy_status', 'occupied')->sum('rent');
    $rentPotential  = $allUnits->sum('rent');

    $isRent = $property->isForRent();

    $occupancyBadge = [
        'occupied'          => ['badge-active', 'Occupied'],
        'under_maintenance' => ['badge-danger-soft', 'Maintenance'],
    ];

    $availabilityBadge = [
        'available'   => ['badge-active', 'Available'],
        'reserved'    => ['badge-pending', 'Reserved'],
    ];

    $expired = $property->expires_at && $property->expires_at->isPast();
@endphp


{{-- ==========================================================
     SUMMARY
=========================================================== --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-xl-3">
        <div class="terra-stat-card">
            <div class="terra-stat-label">Buildings</div>
            <div class="terra-stat-value">{{ $buildings->count() }}</div>
            <div class="terra-stat-icon is-navy"><i class="bi bi-buildings"></i></div>
            <div class="terra-stat-meta">{{ $allFloors->count() }} {{ Str::plural('floor', $allFloors->count()) }} in total</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="terra-stat-card">
            <div class="terra-stat-label">Units</div>
            <div class="terra-stat-value">{{ number_format($unitTotal) }}</div>
            <div class="terra-stat-icon is-info"><i class="bi bi-door-closed"></i></div>
            <div class="terra-stat-meta">{{ $unitVacant }} vacant &middot; {{ $unitMaint }} in maintenance</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="terra-stat-card">
            <div class="terra-stat-label">Occupancy rate</div>
            <div class="terra-stat-value">{{ $occupancyRate }}%</div>
            <div class="terra-stat-icon is-success"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="terra-stat-meta">
                <div class="terra-progress mb-2"><span style="width: {{ $occupancyRate }}%"></span></div>
                {{ $unitOccupied }} of {{ $unitTotal }} units occupied
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="terra-stat-card">
            <div class="terra-stat-label">Monthly rent roll</div>
            <div class="terra-stat-value">RWF {{ number_format($rentRoll) }}</div>
            <div class="terra-stat-icon"><i class="bi bi-cash-stack"></i></div>
            <div class="terra-stat-meta">Potential: RWF {{ number_format($rentPotential) }}</div>
        </div>
    </div>

</div>


{{-- ==========================================================
     PROPERTY INFORMATION + LOCATION
=========================================================== --}}
<div class="row g-4 mb-4">

    <div class="col-lg-8">
        <div class="terra-card h-100">

            <div class="terra-card-header">
                <h5>Property information</h5>

                @if($property->is_managed)
                    <span class="badge badge-active">Management active</span>
                @else
                    <span class="badge badge-pending">Not managed</span>
                @endif
            </div>

            <div class="terra-card-body">
                <div class="info-grid">

                    <div>
                        <div class="info-label">Property type</div>
                        <div class="info-value">{{ ucfirst($property->property_category ?? $property->type ?? '—') }}</div>
                    </div>

                    <div>
                        <div class="info-label">Listing type</div>
                        <div class="info-value">
                            {{ $property->listing_type ? ucfirst(str_replace('_', ' ', $property->listing_type)) : '—' }}
                        </div>
                    </div>

                    <div>
                        <div class="info-label">Property status</div>
                        <div class="info-value">{{ ucfirst(str_replace('_', ' ', $property->status ?? '—')) }}</div>
                    </div>

                    <div>
                        <div class="info-label">Price</div>
                        <div class="info-value">
                            @if($property->price)
                                RWF {{ number_format($property->price) }}{{ $isRent ? ' / month' : '' }}
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="info-label">UPI / property reference</div>
                        <div class="info-value">{{ $property->upi_reference ?: '—' }}</div>
                    </div>

                    <div>
                        <div class="info-label">Zoning</div>
                        <div class="info-value">{{ $property->zoning ?: '—' }}</div>
                    </div>

                    <div>
                        <div class="info-label">Management status</div>
                        <div class="info-value">
                            {{ $property->management_status ? ucfirst(str_replace('_', ' ', $property->management_status)) : ($property->is_managed ? 'Active' : 'Not managed') }}
                        </div>
                    </div>

                    <div>
                        <div class="info-label">Approval</div>
                        <div>
                            @if($property->is_approved)
                                <span class="badge badge-active">Approved</span>
                            @else
                                <span class="badge badge-pending">Awaiting approval</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="info-label">Listing expires</div>
                        <div class="info-value {{ $expired ? 'text-danger' : '' }}">
                            @if($property->expires_at)
                                {{ $property->expires_at->format('d M Y') }}{{ $expired ? ' (expired)' : '' }}
                            @else
                                —
                            @endif
                        </div>
                    </div>

                </div>

                @if($property->description)
                    <hr class="my-4">
                    <div class="info-label">Description</div>
                    <p class="mb-0" style="max-width: 75ch;">{{ $property->description }}</p>
                @endif
            </div>

        </div>
    </div>


    <div class="col-lg-4">
        <div class="terra-card h-100">

            <div class="terra-card-header">
                <h5>Location</h5>
            </div>

            <div class="terra-card-body">

                <div class="location-line">
                    <i class="bi bi-geo-alt-fill"></i>
                    <div>
                        <div class="info-label mb-0">District</div>
                        <div class="info-value">{{ $property->district ?: 'Not specified' }}</div>
                    </div>
                </div>

                <div class="location-line">
                    <i class="bi bi-signpost-split"></i>
                    <div>
                        <div class="info-label mb-0">Sector, cell and village</div>
                        <div class="info-value">
                            {{ collect([$property->sector, $property->cell, $property->village])->filter()->implode(' · ') ?: '—' }}
                        </div>
                    </div>
                </div>

                @if($property->address)
                    <div class="location-line">
                        <i class="bi bi-house-door"></i>
                        <div>
                            <div class="info-label mb-0">Address</div>
                            <div class="info-value">{{ $property->address }}</div>
                        </div>
                    </div>
                @endif

                @if($property->latitude && $property->longitude)
                    <div class="location-line">
                        <i class="bi bi-compass"></i>
                        <div>
                            <div class="info-label mb-0">Coordinates</div>
                            <div class="info-value">{{ $property->latitude }}, {{ $property->longitude }}</div>
                            <a href="https://www.google.com/maps?q={{ $property->latitude }},{{ $property->longitude }}"
                               target="_blank" rel="noopener" class="small" style="color: var(--terra-orange);">
                                Open in Google Maps <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>

</div>


{{-- ==========================================================
     BUILDINGS
=========================================================== --}}
<div class="terra-card">

    <div class="terra-card-header">
        <div>
            <h5>Buildings</h5>
            <div class="text-muted small mt-1">Buildings, floors and rental units in this property.</div>
        </div>

        <button type="button" class="btn btn-terra btn-sm" data-bs-toggle="modal" data-bs-target="#addBuildingModal">
            <i class="bi bi-plus-lg me-1"></i> Add Building
        </button>
    </div>

    <div class="terra-card-body">

        @forelse($buildings as $building)

            @php
                $bUnits    = $building->floors->flatMap(fn ($f) => $f->units);
                $bTotal    = $bUnits->count();
                $bOccupied = $bUnits->where('occupancy_status', 'occupied')->count();
                $bRate     = $bTotal ? round(($bOccupied / $bTotal) * 100) : 0;
            @endphp

            <section class="building-block">

                <div class="building-head">

                    <button type="button" class="building-toggle"
                            data-bs-toggle="collapse"
                            data-bs-target="#building{{ $building->id }}"
                            aria-expanded="true"
                            aria-controls="building{{ $building->id }}">

                        <span class="building-icon"><i class="bi bi-building"></i></span>

                        <span>
                            <span class="building-name d-block">{{ $building->name }}</span>
                            <span class="building-meta d-block">
                                @if($building->reference) Ref {{ $building->reference }} &middot; @endif
                                {{ $building->number_of_floors }} {{ Str::plural('floor', $building->number_of_floors) }}
                                &middot; {{ $bTotal }} {{ Str::plural('unit', $bTotal) }}
                            </span>
                        </span>

                        <i class="bi bi-chevron-down chevron ms-2"></i>
                    </button>

                    <div class="building-occupancy">
                        <div class="label"><span>Occupancy</span><strong>{{ $bRate }}%</strong></div>
                        <div class="terra-progress"><span style="width: {{ $bRate }}%"></span></div>
                    </div>

                    <div class="d-flex align-items-center gap-2">

                        <span class="badge {{ in_array(strtolower((string) $building->status), ['active', 'available', 'operational']) ? 'badge-active' : 'badge-neutral' }}">
                            {{ ucfirst($building->status) }}
                        </span>

                        <a href="{{ route('property-management.buildings.edit', $building) }}"
                           class="icon-btn" title="Edit building" aria-label="Edit building">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form method="POST"
                              action="{{ route('property-management.buildings.destroy', $building) }}"
                              onsubmit="return confirm('Delete this building and all its floors and units?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-btn danger" title="Delete building" aria-label="Delete building">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>

                    </div>

                </div>


                <div class="collapse show" id="building{{ $building->id }}">

                    @forelse($building->floors as $floor)

                        <div class="floor-row">

                            <div class="floor-head">

                                <div>
                                    <h6 class="floor-name">{{ $floor->name }}</h6>
                                    <div class="floor-sub">
                                        Floor {{ $floor->floor_number }}
                                        &middot; {{ $floor->units->count() }} {{ Str::plural('unit', $floor->units->count()) }}
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2">

                                    <button type="button" class="btn btn-sm btn-terra-outline"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addUnitModal{{ $floor->id }}">
                                        <i class="bi bi-plus-lg me-1"></i> Add Unit
                                    </button>

                                    <a href="{{ route('property-management.floors.edit', $floor) }}"
                                       class="icon-btn" title="Edit floor" aria-label="Edit floor">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form method="POST"
                                          action="{{ route('property-management.floors.destroy', $floor) }}"
                                          onsubmit="return confirm('Delete this floor and all its units?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn danger" title="Delete floor" aria-label="Delete floor">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>

                            </div>


                            @if($floor->units->count())

                                <div class="unit-wrap">
                                    <div class="table-responsive">
                                        <table class="table unit-table table-hover">

                                            <thead>
                                                <tr>
                                                    <th>Unit</th>
                                                    <th>Type</th>
                                                    <th>Size</th>
                                                    <th>Rooms</th>
                                                    <th>Rent</th>
                                                    <th>Occupancy</th>
                                                    <th>Availability</th>
                                                    <th class="text-end">Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($floor->units as $unit)

                                                @php
                                                    [$occClass, $occLabel] = $occupancyBadge[$unit->occupancy_status] ?? ['badge-pending', 'Vacant'];
                                                    [$avClass, $avLabel]   = $availabilityBadge[$unit->availability] ?? ['badge-neutral', 'Unavailable'];
                                                @endphp

                                                <tr>
                                                    <td><span class="unit-number">{{ $unit->unit_number }}</span></td>

                                                    <td>{{ $unit->unit_type ?: '—' }}</td>

                                                    <td class="text-nowrap">
                                                        {{ $unit->size ? number_format($unit->size, 2) . ' m²' : '—' }}
                                                    </td>

                                                    <td class="text-nowrap">
                                                        @if(!is_null($unit->bedrooms) || !is_null($unit->bathrooms ?? null))
                                                            {{ $unit->bedrooms ?? 0 }} bd
                                                            @if(!is_null($unit->bathrooms ?? null))
                                                                &middot; {{ $unit->bathrooms }} ba
                                                            @endif
                                                        @else
                                                            —
                                                        @endif
                                                    </td>

                                                    <td class="text-nowrap fw-semibold">
                                                        {{ $unit->rent ? 'RWF ' . number_format($unit->rent) : '—' }}
                                                    </td>

                                                    <td><span class="badge {{ $occClass }}">{{ $occLabel }}</span></td>

                                                    <td><span class="badge {{ $avClass }}">{{ $avLabel }}</span></td>

                                                    <td class="text-end">
                                                        <div class="d-flex justify-content-end gap-1">

                                                            <a href="{{ route('property-management.units.edit', $unit) }}"
                                                               class="icon-btn" title="Edit unit" aria-label="Edit unit">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>

                                                            <form method="POST"
                                                                  action="{{ route('property-management.units.destroy', $unit) }}"
                                                                  onsubmit="return confirm('Delete this unit?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="icon-btn danger" title="Delete unit" aria-label="Delete unit">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>

                                                        </div>
                                                    </td>
                                                </tr>

                                            @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                            @else

                                <div class="empty-inline">
                                    <div class="small mb-2">No units have been registered on this floor yet.</div>
                                    <button type="button" class="btn btn-sm btn-terra-outline"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addUnitModal{{ $floor->id }}">
                                        Add first unit
                                    </button>
                                </div>

                            @endif

                        </div>

                    @empty

                        <div class="floor-row">
                            <div class="empty-inline">
                                <div class="fw-semibold mb-1">No floors yet</div>
                                <div class="small">Add a floor to this building before registering units.</div>
                            </div>
                        </div>

                    @endforelse

                </div>

            </section>

        @empty

            <div class="terra-empty">
                <i class="bi bi-buildings"></i>
                <h6>No buildings yet</h6>
                <p class="mb-3">Start by adding the first building to this property.</p>
                <button type="button" class="btn btn-terra" data-bs-toggle="modal" data-bs-target="#addBuildingModal">
                    <i class="bi bi-plus-lg me-1"></i> Add first building
                </button>
            </div>

        @endforelse

    </div>

</div>


{{-- ==========================================================
     ADD UNIT MODALS (one per floor, kept outside the cards)
=========================================================== --}}
@foreach($buildings as $building)
    @foreach($building->floors as $floor)

        @php
            $modalId = 'addUnitModal' . $floor->id;
            $isThis  = old('_modal') === $modalId;
            $o       = fn ($key, $default = null) => $isThis ? old($key, $default) : $default;
        @endphp

        <div class="modal fade" id="{{ $modalId }}" tabindex="-1"
             aria-labelledby="addUnitLabel{{ $floor->id }}" aria-hidden="true">

            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">

                    <form method="POST" action="{{ route('property-management.units.store', $floor) }}">
                        @csrf
                        <input type="hidden" name="_modal" value="{{ $modalId }}">

                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title" id="addUnitLabel{{ $floor->id }}">Add unit</h5>
                                <small class="text-muted">{{ $building->name }} &middot; {{ $floor->name }}</small>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Unit number <span class="text-danger">*</span></label>
                                    <input type="text" name="unit_number" class="form-control"
                                           placeholder="e.g. A-101" value="{{ $o('unit_number') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Unit type</label>
                                    <select name="unit_type" class="form-select">
                                        <option value="">Select type</option>
                                        @foreach(['Apartment', 'House', 'Office', 'Shop', 'Room', 'Studio', 'Other'] as $type)
                                            <option value="{{ $type }}" @selected($o('unit_type') === $type)>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Size (m²)</label>
                                    <input type="number" name="size" class="form-control" min="0" step="0.01" value="{{ $o('size') }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Bedrooms</label>
                                    <input type="number" name="bedrooms" class="form-control" min="0" value="{{ $o('bedrooms') }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Bathrooms</label>
                                    <input type="number" name="bathrooms" class="form-control" min="0" value="{{ $o('bathrooms') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Monthly rent (RWF)</label>
                                    <input type="number" name="rent" class="form-control" min="0" step="0.01" value="{{ $o('rent') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Deposit (RWF)</label>
                                    <input type="number" name="deposit" class="form-control" min="0" step="0.01" value="{{ $o('deposit') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Availability <span class="text-danger">*</span></label>
                                    <select name="availability" class="form-select" required>
                                        @foreach(['available' => 'Available', 'reserved' => 'Reserved', 'unavailable' => 'Unavailable'] as $value => $label)
                                            <option value="{{ $value }}" @selected($o('availability', 'available') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Occupancy status <span class="text-danger">*</span></label>
                                    <select name="occupancy_status" class="form-select" required>
                                        @foreach(['vacant' => 'Vacant', 'occupied' => 'Occupied', 'under_maintenance' => 'Under maintenance'] as $value => $label)
                                            <option value="{{ $value }}" @selected($o('occupancy_status', 'vacant') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Utility meter</label>
                                    <input type="text" name="utility_meter" class="form-control"
                                           placeholder="Meter number" value="{{ $o('utility_meter') }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3"
                                              placeholder="Optional unit description">{{ $o('description') }}</textarea>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-terra">Save unit</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    @endforeach
@endforeach


{{-- ==========================================================
     ADD BUILDING MODAL
=========================================================== --}}
@php
    $buildingOpen = old('_modal') === 'addBuildingModal';
    $ob = fn ($key, $default = null) => $buildingOpen ? old($key, $default) : $default;
@endphp

<div class="modal fade" id="addBuildingModal" tabindex="-1" aria-labelledby="addBuildingLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-scrollable">

        <form method="POST" action="{{ route('property-management.buildings.store', $property) }}" class="modal-content">
            @csrf
            <input type="hidden" name="_modal" value="addBuildingModal">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="addBuildingLabel">Add building</h5>
                    <small class="text-muted">{{ $property->title }}</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Building name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Building A"
                           value="{{ $ob('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Reference</label>
                    <input type="text" name="reference" class="form-control"
                           placeholder="Optional building reference" value="{{ $ob('reference') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Number of floors <span class="text-danger">*</span></label>
                    <input type="number" name="number_of_floors" class="form-control" min="1" max="100"
                           value="{{ $ob('number_of_floors', 1) }}" required>
                    <small class="text-muted">Floors will be created automatically.</small>
                </div>

                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"
                              placeholder="Optional building description">{{ $ob('description') }}</textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-terra">Add building</button>
            </div>

        </form>

    </div>

</div>

{{-- Reopen whichever modal was submitted when validation fails --}}
@if($errors->any() && old('_modal'))
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById(@json(old('_modal')));

        if (el && typeof bootstrap !== 'undefined') {
            new bootstrap.Modal(el).show();
        }
    });
</script>
@endpush
@endif

@endsection