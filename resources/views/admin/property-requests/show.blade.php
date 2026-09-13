@extends('layouts.app')

@section('title', $propertyRequest->reference_number)

@section('content')

@php
    $statusLabel = \App\Models\PropertyRequest::STATUSES[$propertyRequest->status]
        ?? ucfirst(str_replace('_', ' ', $propertyRequest->status));

    $requestType = \App\Models\PropertyRequest::REQUEST_TYPES[$propertyRequest->request_type]
        ?? $propertyRequest->request_type;

    $propertyStatus = \App\Models\PropertyRequest::PROPERTY_STATUSES[$propertyRequest->property_status]
        ?? $propertyRequest->property_status;

    $contactMethod = \App\Models\PropertyRequest::CONTACT_METHODS[$propertyRequest->preferred_contact]
        ?? $propertyRequest->preferred_contact;

    $timeline = \App\Models\PropertyRequest::TIMELINES[$propertyRequest->timeline]
        ?? $propertyRequest->timeline;

    $statusClass = match ($propertyRequest->status) {
        'new' => 'status-new',
        'in_review' => 'status-review',
        'matched' => 'status-matched',
        'closed' => 'status-closed',
        'unmatched' => 'status-unmatched',
        default => 'status-default',
    };

    $urgencyClass = match ($propertyRequest->urgency) {
        'high', 'urgent' => 'urgency-high',
        'medium' => 'urgency-medium',
        default => 'urgency-low',
    };
@endphp

<div class="request-page">

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div class="page-header">

        <div class="header-left">

            <a href="{{ route('admin.property-requests.index') }}"
               class="back-link">
                <span>←</span>
                Property Requests
            </a>

            <div class="title-row">

                <div>
                    <div class="eyebrow">PROPERTY REQUEST</div>

                    <h1>
                        {{ $propertyRequest->reference_number }}
                    </h1>

                    <p class="subtitle">
                        Submitted
                        {{ $propertyRequest->created_at->format('M d, Y \a\t g:i A') }}
                    </p>
                </div>

                <span class="status-badge {{ $statusClass }}">
                    <span class="status-dot"></span>
                    {{ $statusLabel }}
                </span>

            </div>

        </div>

        <div class="header-actions">

            <a href="{{ route('admin.property-requests.edit', $propertyRequest->id) }}"
               class="btn btn-outline">
                <span class="btn-icon">✎</span>
                Edit Request
            </a>

        </div>

    </div>


    {{-- =========================================================
         TOP SUMMARY
    ========================================================== --}}
    <div class="summary-grid">

        <div class="summary-card">
            <div class="summary-icon icon-client">
                👤
            </div>

            <div>
                <span class="summary-label">CLIENT</span>
                <strong>{{ $propertyRequest->full_name }}</strong>
                <small>{{ $propertyRequest->phone }}</small>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-icon icon-property">
                🏠
            </div>

            <div>
                <span class="summary-label">PROPERTY</span>
                <strong>{{ $propertyRequest->property_type_label }}</strong>
                <small>{{ $requestType }}</small>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-icon icon-budget">
                ₣
            </div>

            <div>
                <span class="summary-label">BUDGET</span>
                <strong>{{ $propertyRequest->formatted_budget }}</strong>
                <small>{{ $timeline }}</small>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-icon icon-urgency">
                !
            </div>

            <div>
                <span class="summary-label">URGENCY</span>

                <strong>
                    <span class="urgency-text {{ $urgencyClass }}">
                        {{ ucfirst($propertyRequest->urgency) }}
                    </span>
                </strong>

                <small>
                    {{ $propertyRequest->financing_needed ? 'Financing required' : 'No financing required' }}
                </small>
            </div>
        </div>

    </div>


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}
    <div class="content-grid">

        {{-- =====================================================
             LEFT COLUMN
        ====================================================== --}}
        <div class="main-column">


            {{-- CLIENT --}}
            <div class="card">

                <div class="card-header">

                    <div class="card-title">
                        <div class="card-icon">👤</div>

                        <div>
                            <h2>Client Information</h2>
                            <p>Contact details for this request</p>
                        </div>
                    </div>

                    <span class="section-number">01</span>

                </div>

                <div class="info-grid">

                    <div class="info-item">
                        <span class="info-label">FULL NAME</span>
                        <span class="info-value">
                            {{ $propertyRequest->full_name }}
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">NATIONALITY</span>
                        <span class="info-value">
                            {{ $propertyRequest->nationality ?: 'Not provided' }}
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">EMAIL</span>

                        <a href="mailto:{{ $propertyRequest->email }}"
                           class="info-link">
                            {{ $propertyRequest->email }}
                        </a>
                    </div>

                    <div class="info-item">
                        <span class="info-label">PHONE</span>

                        <div class="phone-value">

                            <a href="tel:{{ $propertyRequest->phone }}"
                               class="info-link">
                                {{ $propertyRequest->phone }}
                            </a>

                            @if ($propertyRequest->whatsapp_number)
                                <a
                                    href="https://wa.me/{{ $propertyRequest->whatsapp_number }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="whatsapp-link"
                                >
                                    WhatsApp
                                </a>
                            @endif

                        </div>
                    </div>

                    <div class="info-item">
                        <span class="info-label">PREFERRED CONTACT</span>
                        <span class="info-value">
                            {{ $contactMethod }}
                        </span>
                    </div>

                </div>

            </div>


            {{-- REQUEST --}}
            <div class="card">

                <div class="card-header">

                    <div class="card-title">
                        <div class="card-icon">⌂</div>

                        <div>
                            <h2>Property Request</h2>
                            <p>What the client is looking for</p>
                        </div>
                    </div>

                    <span class="section-number">02</span>

                </div>


                <div class="request-highlight">

                    <div>
                        <span class="info-label">PROPERTY TYPE</span>

                        <strong>
                            {{ $propertyRequest->property_type_label }}
                        </strong>
                    </div>

                    <div>
                        <span class="info-label">REQUEST TYPE</span>

                        <strong>
                            {{ $requestType }}
                        </strong>
                    </div>

                    <div>
                        <span class="info-label">PROPERTY STATUS</span>

                        <strong>
                            {{ $propertyStatus }}
                        </strong>
                    </div>

                </div>


                <div class="info-grid">

                    <div class="info-item full-width">
                        <span class="info-label">PREFERRED LOCATION</span>

                        <span class="info-value location-value">
                            <span class="location-icon">⌖</span>
                            {{ $propertyRequest->location_summary ?: 'Any location' }}
                        </span>
                    </div>

                    <div class="info-item full-width">

                        <span class="info-label">LOCATION NOTES</span>

                        <span class="info-value multiline">
                            {{ $propertyRequest->location_notes ?: 'No location notes provided.' }}
                        </span>

                    </div>

                </div>

            </div>


            {{-- BUDGET --}}
            <div class="card">

                <div class="card-header">

                    <div class="card-title">
                        <div class="card-icon">₣</div>

                        <div>
                            <h2>Budget & Timeline</h2>
                            <p>Financial expectations and timeline</p>
                        </div>
                    </div>

                    <span class="section-number">03</span>

                </div>


                <div class="budget-box">

                    <div class="budget-main">

                        <span class="info-label">BUDGET RANGE</span>

                        <strong>
                            {{ $propertyRequest->formatted_budget }}
                        </strong>

                    </div>

                    <div class="budget-divider"></div>

                    <div class="budget-detail">

                        <span class="info-label">TIMELINE</span>

                        <strong>{{ $timeline }}</strong>

                    </div>

                    <div class="budget-divider"></div>

                    <div class="budget-detail">

                        <span class="info-label">FINANCING</span>

                        @if($propertyRequest->financing_needed)
                            <span class="finance-badge finance-yes">
                                Required
                            </span>
                        @else
                            <span class="finance-badge finance-no">
                                Not required
                            </span>
                        @endif

                    </div>

                </div>

            </div>


            {{-- REQUIREMENTS --}}
            <div class="card">

                <div class="card-header">

                    <div class="card-title">
                        <div class="card-icon">✓</div>

                        <div>
                            <h2>Property Requirements</h2>
                            <p>Specific requirements from the client</p>
                        </div>
                    </div>

                    <span class="section-number">04</span>

                </div>


                <div class="requirements-grid">

                    <div class="requirement-item">

                        <span class="requirement-icon">🛏</span>

                        <div>
                            <span class="info-label">BEDROOMS</span>

                            <strong>
                                {{ $propertyRequest->bedrooms_min ?? 'Any' }}
                            </strong>
                        </div>

                    </div>


                    <div class="requirement-item">

                        <span class="requirement-icon">🚿</span>

                        <div>
                            <span class="info-label">BATHROOMS</span>

                            <strong>
                                {{ $propertyRequest->bathrooms_min ?? 'Any' }}
                            </strong>
                        </div>

                    </div>


                    <div class="requirement-item">

                        <span class="requirement-icon">▧</span>

                        <div>
                            <span class="info-label">LAND SIZE</span>

                            <strong>

                                @if ($propertyRequest->land_size_min || $propertyRequest->land_size_max)

                                    {{ $propertyRequest->land_size_min ?? '?' }}
                                    –
                                    {{ $propertyRequest->land_size_max ?? '?' }}
                                    sqm

                                @else
                                    Any
                                @endif

                            </strong>
                        </div>

                    </div>

                </div>


                <div class="feature-sections">

                    <div class="feature-block">

                        <span class="info-label">AMENITIES</span>

                        @if ($propertyRequest->amenities)

                            <div class="tag-list">

                                @foreach ($propertyRequest->amenities as $amenity)

                                    <span class="tag">
                                        {{ $amenity }}
                                    </span>

                                @endforeach

                            </div>

                        @else

                            <span class="empty-text">
                                No amenities specified
                            </span>

                        @endif

                    </div>


                    <div class="feature-block">

                        <span class="info-label">MUST-HAVE FEATURES</span>

                        @if ($propertyRequest->must_have_features)

                            <div class="tag-list">

                                @foreach ($propertyRequest->must_have_features as $feature)

                                    <span class="tag tag-important">
                                        ✓ {{ $feature }}
                                    </span>

                                @endforeach

                            </div>

                        @else

                            <span class="empty-text">
                                No must-have features specified
                            </span>

                        @endif

                    </div>


                    <div class="feature-block">

                        <span class="info-label">NICE-TO-HAVE FEATURES</span>

                        @if ($propertyRequest->nice_to_have_features)

                            <div class="tag-list">

                                @foreach ($propertyRequest->nice_to_have_features as $feature)

                                    <span class="tag">
                                        {{ $feature }}
                                    </span>

                                @endforeach

                            </div>

                        @else

                            <span class="empty-text">
                                No additional preferences
                            </span>

                        @endif

                    </div>

                </div>

            </div>


            {{-- ADDITIONAL --}}
            <div class="card">

                <div class="card-header">

                    <div class="card-title">
                        <div class="card-icon">⋯</div>

                        <div>
                            <h2>Additional Information</h2>
                            <p>Other information provided by the client</p>
                        </div>
                    </div>

                    <span class="section-number">05</span>

                </div>


                <div class="additional-grid">

                    <div class="additional-item">

                        <span class="info-label">URGENCY</span>

                        <span class="urgency-badge {{ $urgencyClass }}">
                            {{ ucfirst($propertyRequest->urgency) }}
                        </span>

                    </div>


                    <div class="additional-item">

                        <span class="info-label">HOW THEY HEARD ABOUT US</span>

                        <span class="info-value">
                            {{ $propertyRequest->how_did_you_hear ?: 'Not provided' }}
                        </span>

                    </div>


                    <div class="additional-item">

                        <span class="info-label">NEWSLETTER</span>

                        @if($propertyRequest->newsletter_opt_in)

                            <span class="newsletter-yes">
                                ✓ Subscribed
                            </span>

                        @else

                            <span class="empty-text">
                                Not subscribed
                            </span>

                        @endif

                    </div>


                    <div class="additional-item full-width">

                        <span class="info-label">CLIENT NOTES</span>

                        <div class="notes-box">
                            {{ $propertyRequest->additional_notes ?: 'No additional notes were provided.' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             RIGHT COLUMN
        ====================================================== --}}
        <aside class="sidebar">


            {{-- MANAGEMENT --}}
            <div class="card manage-card">

                <div class="card-header">

                    <div class="card-title">

                        <div class="card-icon manage-icon">
                            ⚙
                        </div>

                        <div>
                            <h2>Manage Request</h2>
                            <p>Update internal request details</p>
                        </div>

                    </div>

                </div>


                <form
                    method="POST"
                    action="{{ route('admin.property-requests.update-status', $propertyRequest->id) }}"
                >

                    @csrf
                    @method('PATCH')


                    <div class="field">

                        <label for="status">
                            Request Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-control"
                        >

                            @foreach (\App\Models\PropertyRequest::STATUSES as $key => $label)

                                <option
                                    value="{{ $key }}"
                                    @selected($propertyRequest->status === $key)
                                >
                                    {{ $label }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="field">

                        <label for="assigned_agent">
                            Assigned Agent
                        </label>

                        <input
                            type="text"
                            id="assigned_agent"
                            name="assigned_agent"
                            class="form-control"
                            value="{{ $propertyRequest->assigned_agent }}"
                            placeholder="Enter agent name"
                        >

                    </div>


                    <div class="field">

                        <label for="admin_notes">
                            Internal Notes
                        </label>

                        <textarea
                            id="admin_notes"
                            name="admin_notes"
                            class="form-control"
                            placeholder="Add internal notes..."
                        >{{ $propertyRequest->admin_notes }}</textarea>

                    </div>


                    <label class="public-toggle">

                        <input
                            type="checkbox"
                            name="is_public"
                            value="1"
                            @checked($propertyRequest->is_public)
                        >

                        <span class="toggle-box"></span>

                        <span class="toggle-content">

                            <strong>Public Request</strong>

                            <small>
                                Visible on the public website
                            </small>

                        </span>

                    </label>


                    <button
                        type="submit"
                        class="btn btn-gold btn-full"
                    >
                        Save Management Changes
                    </button>

                </form>

            </div>


            {{-- QUICK ACTIONS --}}
            <div class="card">

                <div class="card-header compact-header">

                    <div class="card-title">

                        <div class="card-icon">
                            ⚡
                        </div>

                        <div>
                            <h2>Quick Actions</h2>
                        </div>

                    </div>

                </div>


                <div class="quick-actions">

                    <a
                        href="mailto:{{ $propertyRequest->email }}"
                        class="quick-action"
                    >
                        <span>✉</span>
                        Email Client
                    </a>

                    <a
                        href="tel:{{ $propertyRequest->phone }}"
                        class="quick-action"
                    >
                        <span>☎</span>
                        Call Client
                    </a>

                    @if($propertyRequest->whatsapp_number)

                        <a
                            href="https://wa.me/{{ $propertyRequest->whatsapp_number }}"
                            target="_blank"
                            rel="noopener"
                            class="quick-action"
                        >
                            <span>◉</span>
                            WhatsApp
                        </a>

                    @endif

                    <a
                        href="{{ route('admin.property-requests.edit', $propertyRequest->id) }}"
                        class="quick-action"
                    >
                        <span>✎</span>
                        Edit Request
                    </a>

                </div>

            </div>


            {{-- REQUEST META --}}
            <div class="card meta-card">

                <div class="card-header compact-header">

                    <div class="card-title">

                        <div class="card-icon">
                            #
                        </div>

                        <div>
                            <h2>Request Details</h2>
                        </div>

                    </div>

                </div>


                <div class="meta-list">

                    <div class="meta-row">

                        <span>Reference</span>

                        <strong>
                            {{ $propertyRequest->reference_number }}
                        </strong>

                    </div>


                    <div class="meta-row">

                        <span>Submitted</span>

                        <strong>
                            {{ $propertyRequest->created_at->format('M d, Y') }}
                        </strong>

                    </div>


                    <div class="meta-row">

                        <span>Last Updated</span>

                        <strong>
                            {{ $propertyRequest->updated_at->format('M d, Y') }}
                        </strong>

                    </div>


                    <div class="meta-row">

                        <span>Visibility</span>

                        @if($propertyRequest->is_public)

                            <span class="visibility public">
                                Public
                            </span>

                        @else

                            <span class="visibility private">
                                Private
                            </span>

                        @endif

                    </div>

                </div>

            </div>


            {{-- DANGER --}}
            <div class="danger-card">

                <div class="danger-header">

                    <div>
                        <strong>Danger Zone</strong>

                        <p>
                            Permanently delete this request.
                        </p>
                    </div>

                    <span>!</span>

                </div>


                <form
                    method="POST"
                    action="{{ route('admin.property-requests.destroy', $propertyRequest->id) }}"
                    onsubmit="return confirm('Delete this property request? This action cannot be undone.');"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="delete-btn"
                    >
                        Delete Request
                    </button>

                </form>

            </div>

        </aside>

    </div>

</div>


<style>

:root {
    --terra-navy: #19265d;
    --terra-navy-dark: #111a45;
    --terra-orange: #D05208;
    --terra-orange-dark: #a94105;

    --text: #1f2937;
    --muted: #6b7280;
    --light-muted: #9ca3af;

    --border: #e5e7eb;
    --background: #f6f7f9;

    --success: #15803d;
    --success-bg: #dcfce7;

    --warning: #a16207;
    --warning-bg: #fef3c7;

    --danger: #b91c1c;
    --danger-bg: #fee2e2;

    --blue: #2563eb;
    --blue-bg: #eff6ff;
}


/* =========================================================
   PAGE
========================================================= */

.request-page {
    max-width: 1450px;
    margin: 0 auto;
    font-family: 'DM Sans', sans-serif;
    color: var(--text);
}


/* =========================================================
   HEADER
========================================================= */

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 2rem;
    margin-bottom: 1.75rem;
}

.header-left {
    flex: 1;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    color: var(--muted);
    text-decoration: none;
    font-size: .82rem;
    font-weight: 600;
    margin-bottom: .9rem;
}

.back-link:hover {
    color: var(--terra-orange);
}

.back-link span {
    font-size: 1rem;
}

.title-row {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.eyebrow {
    color: var(--terra-orange);
    font-size: .68rem;
    font-weight: 800;
    letter-spacing: .14em;
    margin-bottom: .25rem;
}

.page-header h1 {
    margin: 0;
    color: var(--terra-navy-dark);
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.35rem;
    line-height: 1;
}

.subtitle {
    margin: .45rem 0 0;
    color: var(--muted);
    font-size: .82rem;
}

.header-actions {
    display: flex;
    gap: .65rem;
}


/* =========================================================
   BUTTONS
========================================================= */

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .45rem;
    padding: .7rem 1.15rem;
    border-radius: 7px;
    border: 1px solid transparent;
    font-family: 'DM Sans', sans-serif;
    font-size: .82rem;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: .15s ease;
}

.btn-outline {
    background: #fff;
    color: var(--terra-navy);
    border-color: var(--border);
}

.btn-outline:hover {
    border-color: var(--terra-orange);
    color: var(--terra-orange);
}

.btn-gold {
    background: var(--terra-orange);
    color: #fff;
}

.btn-gold:hover {
    background: var(--terra-orange-dark);
}

.btn-full {
    width: 100%;
}

.btn-icon {
    font-size: 1rem;
}


/* =========================================================
   STATUS
========================================================= */

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .45rem .75rem;
    border-radius: 999px;
    font-size: .73rem;
    font-weight: 700;
    white-space: nowrap;
}

.status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: currentColor;
}

.status-new {
    color: #1d4ed8;
    background: #dbeafe;
}

.status-review {
    color: #92400e;
    background: #fef3c7;
}

.status-matched {
    color: #15803d;
    background: #dcfce7;
}

.status-closed {
    color: #4b5563;
    background: #f3f4f6;
}

.status-unmatched {
    color: #b91c1c;
    background: #fee2e2;
}

.status-default {
    color: var(--terra-navy);
    background: #eef0f7;
}


/* =========================================================
   SUMMARY
========================================================= */

.summary-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.summary-card {
    display: flex;
    align-items: center;
    gap: .85rem;
    padding: 1rem;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 10px;
}

.summary-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 42px;
    width: 42px;
    height: 42px;
    border-radius: 9px;
    font-size: 1rem;
    font-weight: 800;
}

.icon-client {
    background: #eef2ff;
}

.icon-property {
    background: #f0fdf4;
}

.icon-budget {
    background: #fff7ed;
    color: var(--terra-orange);
}

.icon-urgency {
    background: #fef2f2;
    color: var(--danger);
}

.summary-card > div:last-child {
    min-width: 0;
}

.summary-label {
    display: block;
    color: var(--light-muted);
    font-size: .62rem;
    font-weight: 800;
    letter-spacing: .08em;
    margin-bottom: .15rem;
}

.summary-card strong {
    display: block;
    color: var(--terra-navy-dark);
    font-size: .9rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.summary-card small {
    display: block;
    color: var(--muted);
    font-size: .72rem;
    margin-top: .1rem;
}

.urgency-high {
    color: var(--danger) !important;
}

.urgency-medium {
    color: var(--warning) !important;
}

.urgency-low {
    color: var(--success) !important;
}


/* =========================================================
   CONTENT
========================================================= */

.content-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 355px;
    gap: 1.5rem;
    align-items: start;
}

.main-column {
    min-width: 0;
}

.sidebar {
    min-width: 0;
}


/* =========================================================
   CARD
========================================================= */

.card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 11px;
    padding: 1.35rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .025);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
    padding-bottom: 1rem;
    margin-bottom: 1.1rem;
    border-bottom: 1px solid var(--border);
}

.card-title {
    display: flex;
    align-items: center;
    gap: .75rem;
}

.card-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 34px;
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #f4f5f8;
    color: var(--terra-navy);
    font-size: .9rem;
}

.card-title h2 {
    margin: 0;
    color: var(--terra-navy-dark);
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.4rem;
    line-height: 1;
}

.card-title p {
    margin: .2rem 0 0;
    color: var(--muted);
    font-size: .7rem;
}

.section-number {
    color: var(--light-muted);
    font-size: .65rem;
    font-weight: 800;
    letter-spacing: .08em;
}


/* =========================================================
   INFORMATION
========================================================= */

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.15rem 2rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: .25rem;
    min-width: 0;
}

.full-width {
    grid-column: 1 / -1;
}

.info-label {
    display: block;
    color: var(--light-muted);
    font-size: .62rem;
    font-weight: 800;
    letter-spacing: .08em;
}

.info-value {
    color: var(--text);
    font-size: .87rem;
    font-weight: 500;
}

.info-link {
    color: var(--terra-navy);
    font-size: .87rem;
    font-weight: 600;
    text-decoration: none;
    word-break: break-word;
}

.info-link:hover {
    color: var(--terra-orange);
}

.phone-value {
    display: flex;
    align-items: center;
    gap: .6rem;
    flex-wrap: wrap;
}

.whatsapp-link {
    color: #15803d;
    background: #f0fdf4;
    padding: .2rem .5rem;
    border-radius: 5px;
    font-size: .68rem;
    font-weight: 700;
    text-decoration: none;
}

.multiline {
    line-height: 1.6;
    color: #4b5563;
}

.location-value {
    display: flex;
    align-items: center;
    gap: .45rem;
}

.location-icon {
    color: var(--terra-orange);
    font-size: 1rem;
}


/* =========================================================
   REQUEST HIGHLIGHT
========================================================= */

.request-highlight {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .75rem;
    margin-bottom: 1.25rem;
}

.request-highlight > div {
    padding: .9rem;
    background: #f8f9fb;
    border-radius: 8px;
}

.request-highlight strong {
    display: block;
    margin-top: .3rem;
    color: var(--terra-navy-dark);
    font-size: .85rem;
}


/* =========================================================
   BUDGET
========================================================= */

.budget-box {
    display: grid;
    grid-template-columns: 1.5fr 1px 1fr 1px 1fr;
    align-items: center;
    gap: 1.2rem;
    padding: 1rem;
    background: #fafafa;
    border-radius: 9px;
}

.budget-main strong {
    display: block;
    margin-top: .2rem;
    color: var(--terra-orange);
    font-size: 1.25rem;
}

.budget-detail strong {
    display: block;
    margin-top: .25rem;
    color: var(--terra-navy-dark);
    font-size: .82rem;
}

.budget-divider {
    width: 1px;
    height: 38px;
    background: var(--border);
}

.finance-badge {
    display: inline-block;
    margin-top: .25rem;
    padding: .25rem .55rem;
    border-radius: 999px;
    font-size: .67rem;
    font-weight: 700;
}

.finance-yes {
    color: #92400e;
    background: #fef3c7;
}

.finance-no {
    color: #15803d;
    background: #dcfce7;
}


/* =========================================================
   REQUIREMENTS
========================================================= */

.requirements-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .75rem;
    margin-bottom: 1.35rem;
}

.requirement-item {
    display: flex;
    align-items: center;
    gap: .7rem;
    padding: .85rem;
    border: 1px solid var(--border);
    border-radius: 8px;
}

.requirement-icon {
    font-size: 1rem;
}

.requirement-item strong {
    display: block;
    margin-top: .2rem;
    color: var(--terra-navy-dark);
    font-size: .85rem;
}

.feature-sections {
    display: flex;
    flex-direction: column;
    gap: 1.15rem;
}

.feature-block {
    padding-top: 1rem;
    border-top: 1px solid #f0f1f3;
}

.tag-list {
    display: flex;
    flex-wrap: wrap;
    gap: .4rem;
    margin-top: .55rem;
}

.tag {
    padding: .3rem .6rem;
    background: #f3f4f6;
    color: #4b5563;
    border-radius: 5px;
    font-size: .68rem;
    font-weight: 600;
}

.tag-important {
    background: #fff7ed;
    color: var(--terra-orange);
}

.empty-text {
    color: var(--light-muted);
    font-size: .75rem;
    font-style: italic;
}


/* =========================================================
   ADDITIONAL
========================================================= */

.additional-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.1rem 2rem;
}

.additional-item {
    display: flex;
    flex-direction: column;
    gap: .35rem;
}

.urgency-badge {
    width: fit-content;
    padding: .3rem .6rem;
    border-radius: 999px;
    font-size: .68rem;
    font-weight: 700;
}

.urgency-badge.urgency-high {
    background: #fee2e2;
}

.urgency-badge.urgency-medium {
    background: #fef3c7;
}

.urgency-badge.urgency-low {
    background: #dcfce7;
}

.newsletter-yes {
    color: var(--success);
    font-size: .78rem;
    font-weight: 700;
}

.notes-box {
    margin-top: .25rem;
    padding: .85rem;
    background: #f8f9fb;
    border-radius: 7px;
    color: #4b5563;
    font-size: .8rem;
    line-height: 1.6;
}


/* =========================================================
   SIDEBAR MANAGEMENT
========================================================= */

.manage-card {
    position: sticky;
    top: 1rem;
}

.manage-icon {
    background: #fff7ed;
    color: var(--terra-orange);
}

.field {
    display: flex;
    flex-direction: column;
    gap: .35rem;
    margin-bottom: 1rem;
}

.field label {
    color: #374151;
    font-size: .73rem;
    font-weight: 700;
}

.form-control {
    width: 100%;
    box-sizing: border-box;
    padding: .68rem .75rem;
    background: #fff;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    color: #1f2937;
    font-family: 'DM Sans', sans-serif;
    font-size: .8rem;
    transition: .15s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--terra-orange);
    box-shadow: 0 0 0 3px rgba(208, 82, 8, .09);
}

textarea.form-control {
    min-height: 100px;
    resize: vertical;
}


/* =========================================================
   PUBLIC TOGGLE
========================================================= */

.public-toggle {
    display: flex;
    align-items: center;
    gap: .7rem;
    padding: .8rem;
    margin: .15rem 0 1rem;
    background: #f8f9fb;
    border: 1px solid var(--border);
    border-radius: 8px;
    cursor: pointer;
}

.public-toggle input {
    position: absolute;
    opacity: 0;
}

.toggle-box {
    position: relative;
    flex: 0 0 34px;
    width: 34px;
    height: 20px;
    border-radius: 999px;
    background: #d1d5db;
    transition: .2s;
}

.toggle-box::after {
    content: '';
    position: absolute;
    top: 3px;
    left: 3px;
    width: 14px;
    height: 14px;
    background: #fff;
    border-radius: 50%;
    transition: .2s;
}

.public-toggle input:checked + .toggle-box {
    background: var(--terra-orange);
}

.public-toggle input:checked + .toggle-box::after {
    transform: translateX(14px);
}

.toggle-content {
    display: flex;
    flex-direction: column;
    gap: .1rem;
}

.toggle-content strong {
    color: var(--text);
    font-size: .76rem;
}

.toggle-content small {
    color: var(--muted);
    font-size: .65rem;
}


/* =========================================================
   QUICK ACTIONS
========================================================= */

.compact-header {
    margin-bottom: .7rem;
}

.quick-actions {
    display: flex;
    flex-direction: column;
}

.quick-action {
    display: flex;
    align-items: center;
    gap: .7rem;
    padding: .65rem .25rem;
    border-bottom: 1px solid #f0f1f3;
    color: #374151;
    font-size: .77rem;
    font-weight: 600;
    text-decoration: none;
}

.quick-action:last-child {
    border-bottom: 0;
}

.quick-action span {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    background: #f5f6f8;
    border-radius: 6px;
    color: var(--terra-navy);
    font-size: .8rem;
}

.quick-action:hover {
    color: var(--terra-orange);
}

.quick-action:hover span {
    background: #fff7ed;
    color: var(--terra-orange);
}


/* =========================================================
   META
========================================================= */

.meta-list {
    display: flex;
    flex-direction: column;
}

.meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    padding: .7rem 0;
    border-bottom: 1px solid #f0f1f3;
}

.meta-row:last-child {
    border-bottom: 0;
}

.meta-row span:first-child {
    color: var(--muted);
    font-size: .7rem;
}

.meta-row strong {
    color: var(--terra-navy-dark);
    font-size: .7rem;
    text-align: right;
}

.visibility {
    padding: .25rem .5rem;
    border-radius: 999px;
    font-size: .63rem !important;
    font-weight: 700;
}

.visibility.public {
    background: #dcfce7;
    color: #15803d;
}

.visibility.private {
    background: #f3f4f6;
    color: #6b7280;
}


/* =========================================================
   DANGER
========================================================= */

.danger-card {
    padding: 1rem;
    background: #fffafa;
    border: 1px solid #fecaca;
    border-radius: 10px;
}

.danger-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: .75rem;
    margin-bottom: .85rem;
}

.danger-header strong {
    color: #991b1b;
    font-size: .78rem;
}

.danger-header p {
    margin: .2rem 0 0;
    color: #9f1239;
    font-size: .65rem;
}

.danger-header > span {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 25px;
    height: 25px;
    background: #fee2e2;
    color: #b91c1c;
    border-radius: 6px;
    font-weight: 800;
}

.delete-btn {
    width: 100%;
    padding: .65rem;
    background: #fff;
    border: 1px solid #fca5a5;
    border-radius: 6px;
    color: #b91c1c;
    font-family: 'DM Sans', sans-serif;
    font-size: .72rem;
    font-weight: 700;
    cursor: pointer;
}

.delete-btn:hover {
    background: #fee2e2;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1100px) {

    .summary-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .content-grid {
        grid-template-columns: minmax(0, 1fr) 310px;
    }

}

@media (max-width: 850px) {

    .page-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .header-actions {
        width: 100%;
    }

    .header-actions .btn {
        width: 100%;
    }

    .content-grid {
        grid-template-columns: 1fr;
    }

    .manage-card {
        position: static;
    }

}

@media (max-width: 650px) {

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .title-row {
        align-items: flex-start;
        flex-direction: column;
    }

    .info-grid,
    .additional-grid,
    .request-highlight,
    .requirements-grid {
        grid-template-columns: 1fr;
    }

    .full-width {
        grid-column: auto;
    }

    .budget-box {
        grid-template-columns: 1fr;
    }

    .budget-divider {
        width: 100%;
        height: 1px;
    }

    .card {
        padding: 1rem;
    }

}

</style>

@endsection