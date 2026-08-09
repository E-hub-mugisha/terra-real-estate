@extends('layouts.app')

@section('title', 'Property Requests')

@section('content')

<style>
    :root {
        --navy: #19265d;
        --navy-dark: #111a45;
        --gold: #D05208;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .page-header h1 {
        font-family: 'Cormorant Garamond', serif;
        color: var(--navy-dark);
        font-size: 2rem;
        margin: 0;
    }

    .subtitle {
        font-family: 'DM Sans', sans-serif;
        color: #6b7280;
        margin: .25rem 0 0;
    }

    .btn {
        font-family: 'DM Sans', sans-serif;
        padding: .6rem 1.2rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        border: none;
        cursor: pointer;
    }

    .btn-gold {
        background: var(--gold);
        color: #fff;
    }

    .btn-navy {
        background: var(--navy);
        color: #fff;
    }

    .status-tabs {
        display: flex;
        gap: .5rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .tab {
        font-family: 'DM Sans', sans-serif;
        padding: .6rem 1rem;
        text-decoration: none;
        color: #6b7280;
        border-bottom: 2px solid transparent;
    }

    .tab.active {
        color: var(--navy-dark);
        border-color: var(--gold);
        font-weight: 600;
    }

    .tab .count {
        color: #9ca3af;
        font-size: .85em;
    }

    .filters-bar {
        display: flex;
        gap: .5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .filters-bar input,
    .filters-bar select {
        font-family: 'DM Sans', sans-serif;
        padding: .5rem .75rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
    }

    .table-wrap {
        background: #fff;
        border-radius: 8px;
        overflow-x: auto;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'DM Sans', sans-serif;
    }

    .admin-table th {
        text-align: left;
        padding: .75rem 1rem;
        background: #f9fafb;
        color: #6b7280;
        font-size: .8rem;
        text-transform: uppercase;
    }

    .admin-table td {
        padding: .75rem 1rem;
        border-top: 1px solid #f3f4f6;
    }

    .ref {
        font-family: monospace;
        color: var(--navy);
    }

    .client-name {
        font-weight: 600;
        color: var(--navy-dark);
    }

    .client-sub {
        font-size: .8rem;
        color: #9ca3af;
    }

    .badge {
        padding: .2rem .6rem;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 600;
    }

    .badge-red {
        background: #fee2e2;
        color: #b91c1c;
    }

    .badge-yellow {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-green {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-status-new {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge-status-in_review {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-status-matched {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-status-closed {
        background: #f3f4f6;
        color: #6b7280;
    }

    .badge-status-unmatched {
        background: #fee2e2;
        color: #b91c1c;
    }

    .empty {
        text-align: center;
        padding: 2rem;
        color: #9ca3af;
    }

    .btn-link {
        color: var(--gold);
        font-weight: 600;
        text-decoration: none;
    }

    .pr-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(17, 26, 69, .5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .pr-modal-overlay.open {
        display: flex;
    }

    .pr-modal {
        background: #fff;
        border-radius: 10px;
        width: min(420px, 92vw);
        box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
        font-family: 'DM Sans', sans-serif;
    }

    .pr-modal-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.1rem 1.4rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .pr-modal-head h3 {
        margin: 0;
        font-size: 1.05rem;
        color: var(--navy-dark);
    }

    .pr-modal-close {
        border: none;
        background: none;
        cursor: pointer;
        color: #9ca3af;
        font-size: 1.2rem;
        line-height: 1;
    }

    .pr-modal-body {
        padding: 1.2rem 1.4rem;
    }

    .pr-modal-body p {
        color: #6b7280;
        font-size: .85rem;
        margin: 0 0 1rem;
    }

    .pr-format-options {
        display: flex;
        gap: .7rem;
        margin-bottom: 1.2rem;
    }

    .pr-format-option {
        flex: 1;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        padding: 1rem .8rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .15s, background .15s;
    }

    .pr-format-option input {
        display: none;
    }

    .pr-format-option.active {
        border-color: var(--gold);
        background: rgba(208, 82, 8, .05);
    }

    .pr-format-option .icon {
        font-size: 1.4rem;
        margin-bottom: .3rem;
    }

    .pr-format-option .label {
        font-weight: 600;
        font-size: .85rem;
        color: var(--navy-dark);
    }

    .pr-filter-summary {
        background: #f9fafb;
        border-radius: 8px;
        padding: .7rem .9rem;
        font-size: .78rem;
        color: #6b7280;
        margin-bottom: 1.2rem;
    }

    .pr-filter-summary strong {
        color: var(--navy-dark);
    }

    .pr-modal-foot {
        padding: 1rem 1.4rem;
        border-top: 1px solid #f3f4f6;
        display: flex;
        justify-content: flex-end;
        gap: .6rem;
    }

    .btn-outline {
        background: #fff;
        border: 1px solid #d1d5db;
        color: #374151;
    }

    .pr-field {
        flex: 1;
        margin-bottom: .9rem;
    }

    .pr-field label {
        display: block;
        font-size: .78rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: .3rem;
    }

    .pr-field input,
    .pr-field select {
        width: 100%;
        font-family: 'DM Sans', sans-serif;
        font-size: .85rem;
        padding: .55rem .7rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
    }

    .pr-field-row {
        display: flex;
        gap: .8rem;
    }

    .pr-field-row .pr-field {
        margin-bottom: .9rem;
    }
</style>

<div class="page-header">
    <div>
        <h1>Property Requests</h1>
        <p class="subtitle">Buyer & renter intake submissions</p>
    </div>
    <div style="display:flex; gap:.5rem;">
        <button type="button" class="btn btn-navy" onclick="openExportModal()">Export</button>
        <a href="{{ route('admin.property-requests.create') }}" class="btn btn-gold">+ New Request</a>
    </div>
</div>

<div class="status-tabs">
    <a href="{{ route('admin.property-requests.index') }}" class="tab {{ !request('status') ? 'active' : '' }}">
        All <span class="count">{{ $counts['all'] }}</span>
    </a>
    @foreach (\App\Models\PropertyRequest::STATUSES as $key => $label)
    <a href="{{ route('admin.property-requests.index', ['status' => $key]) }}"
        class="tab {{ request('status') === $key ? 'active' : '' }}">
        {{ $label }} <span class="count">{{ $counts[$key] ?? 0 }}</span>
    </a>
    @endforeach
</div>

<form method="GET" class="filters-bar">
    @if (request('status'))
    <input type="hidden" name="status" value="{{ request('status') }}">
    @endif

    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name, phone, email, ref #">

    <select name="request_type">
        <option value="">All Types</option>
        @foreach (\App\Models\PropertyRequest::REQUEST_TYPES as $key => $label)
        <option value="{{ $key }}" @selected(request('request_type')===$key)>{{ $label }}</option>
        @endforeach
    </select>

    <select name="property_type">
        <option value="">All Properties</option>
        @foreach (\App\Models\PropertyRequest::PROPERTY_TYPES as $key => $label)
        <option value="{{ $key }}" @selected(request('property_type')===$key)>{{ $label }}</option>
        @endforeach
    </select>

    <select name="is_public">
        <option value="">All Visibility</option>
        <option value="1" @selected(request('is_public')==='1' )>Public</option>
        <option value="0" @selected(request('is_public')==='0' )>Private</option>
    </select>

    <button type="submit" class="btn btn-navy">Filter</button>
</form>

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Client</th>
                <th>Type</th>
                <th>Budget</th>
                <th>Urgency</th>
                <th>Status</th>
                <th>Public</th>
                <th>Submitted</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requests as $r)
            <tr>
                <td class="ref">{{ $r->reference_number }}</td>
                <td>
                    <div class="client-name">{{ $r->full_name }}</div>
                    <div class="client-sub">{{ $r->phone }}</div>
                </td>
                <td>
                    {{ \App\Models\PropertyRequest::REQUEST_TYPES[$r->request_type] ?? $r->request_type }}
                    <div class="client-sub">{{ $r->property_type_label }}</div>
                </td>
                <td>{{ $r->formatted_budget }}</td>
                <td><span class="badge badge-{{ $r->urgency_badge_color }}">{{ ucfirst($r->urgency) }}</span></td>
                <td>
                    <span class="badge badge-status-{{ $r->status }}">
                        {{ \App\Models\PropertyRequest::STATUSES[$r->status] ?? $r->status }}
                    </span>
                </td>
                <td>{{ $r->is_public ? 'Yes' : 'No' }}</td>
                <td>{{ $r->created_at->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('admin.property-requests.show', $r->id) }}" class="btn-link">View</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="empty">No property requests found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-wrap">
    {{ $requests->links() }}
</div>

<div class="pr-modal-overlay" id="pr-export-overlay">
    <div class="pr-modal">
        <div class="pr-modal-head">
            <h3>Export Property Requests</h3>
            <button type="button" class="pr-modal-close" onclick="closeExportModal()">&times;</button>
        </div>

        <form id="pr-export-form" method="GET" action="{{ route('admin.property-requests.export') }}">
            <div class="pr-modal-body">
                <p>Choose which requests to include, then pick a format.</p>

                <div class="pr-field">
                    <label>Status</label>
                    <select name="status">
                        <option value="">All Statuses</option>
                        @foreach (\App\Models\PropertyRequest::STATUSES as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="pr-field">
                    <label>Search</label>
                    <input type="text" name="q" placeholder="Name, phone, email, ref #">
                </div>

                <div class="pr-field-row">
                    <div class="pr-field">
                        <label>Request Type</label>
                        <select name="request_type">
                            <option value="">All Types</option>
                            @foreach (\App\Models\PropertyRequest::REQUEST_TYPES as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pr-field">
                        <label>Property Type</label>
                        <select name="property_type">
                            <option value="">All Properties</option>
                            @foreach (\App\Models\PropertyRequest::PROPERTY_TYPES as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="pr-field-row">
                    <div class="pr-field">
                        <label>Visibility</label>
                        <select name="is_public">
                            <option value="">All Visibility</option>
                            <option value="1">Public</option>
                            <option value="0">Private</option>
                        </select>
                    </div>

                    <div class="pr-field">
                        <label>Date Range</label>
                        <select name="date_range" id="pr-date-range" onchange="toggleCustomDates()">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="7_days">Last 7 Days</option>
                            <option value="30_days">Last 30 Days</option>
                            <option value="this_month">This Month</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                </div>

                <div class="pr-field-row" id="pr-custom-dates" style="display:none;">
                    <div class="pr-field">
                        <label>From</label>
                        <input type="date" name="date_from">
                    </div>
                    <div class="pr-field">
                        <label>To</label>
                        <input type="date" name="date_to">
                    </div>
                </div>

                <label class="pr-field-label" style="margin-top:1rem;display:block;">Format</label>
                <div class="pr-format-options">
                    <label class="pr-format-option active" id="opt-excel">
                        <input type="radio" name="format" value="excel" checked onclick="selectFormat('excel')">
                        <div class="icon">📊</div>
                        <div class="label">Excel (.xlsx)</div>
                    </label>
                    <label class="pr-format-option" id="opt-pdf">
                        <input type="radio" name="format" value="pdf" onclick="selectFormat('pdf')">
                        <div class="icon">📄</div>
                        <div class="label">PDF</div>
                    </label>
                </div>
            </div>

            <div class="pr-modal-foot">
                <button type="button" class="btn btn-outline" onclick="resetExportForm()">Reset</button>
                <button type="button" class="btn btn-outline" onclick="closeExportModal()">Cancel</button>
                <button type="submit" class="btn btn-gold">Download</button>
            </div>
        </form>
    </div>
</div>

<script>
    function selectFormat(format) {
        document.getElementById('opt-excel').classList.toggle('active', format === 'excel');
        document.getElementById('opt-pdf').classList.toggle('active', format === 'pdf');
    }

    function toggleCustomDates() {
        const isCustom = document.getElementById('pr-date-range').value === 'custom';
        document.getElementById('pr-custom-dates').style.display = isCustom ? 'flex' : 'none';
    }

    function openExportModal() {
        document.getElementById('pr-export-overlay').classList.add('open');
    }

    function closeExportModal() {
        document.getElementById('pr-export-overlay').classList.remove('open');
    }

    function resetExportForm() {
        document.getElementById('pr-export-form').reset();
        selectFormat('excel');
        toggleCustomDates();
    }
</script>

@endsection