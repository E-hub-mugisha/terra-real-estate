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
        PAGE HEADER
    ========================================================== --}}
    <div class="page-header">

        <div class="page-heading">

            <a href="{{ route('admin.property-requests.index') }}"
               class="back-link">
                <span class="back-icon">←</span>
                <span>Property Requests</span>
            </a>

            <div class="heading-content">

                <div class="eyebrow">
                    PROPERTY REQUEST
                </div>

                <div class="title-line">

                    <h1>
                        {{ $propertyRequest->reference_number }}
                    </h1>

                    <span class="status-badge {{ $statusClass }}">
                        <span class="status-dot"></span>
                        {{ $statusLabel }}
                    </span>

                </div>

                <p class="subtitle">
                    Submitted
                    {{ $propertyRequest->created_at->format('M d, Y \a\t g:i A') }}
                </p>

            </div>

        </div>

        <div class="header-actions">

            <a href="{{ route('admin.property-requests.edit', $propertyRequest->id) }}"
               class="btn btn-outline">
                <span class="btn-symbol">✎</span>
                Edit Request
            </a>

        </div>

    </div>


    {{-- =========================================================
        SUMMARY
    ========================================================== --}}
    <div class="summary-grid">

        <div class="summary-card">

            <div class="summary-icon client-icon">
                <span>01</span>
            </div>

            <div class="summary-content">

                <span class="summary-label">
                    CLIENT
                </span>

                <strong>
                    {{ $propertyRequest->full_name }}
                </strong>

                <small>
                    {{ $propertyRequest->phone }}
                </small>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon property-icon">
                <span>02</span>
            </div>

            <div class="summary-content">

                <span class="summary-label">
                    PROPERTY
                </span>

                <strong>
                    {{ $propertyRequest->property_type_label }}
                </strong>

                <small>
                    {{ $requestType }}
                </small>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon budget-icon">
                <span>03</span>
            </div>

            <div class="summary-content">

                <span class="summary-label">
                    BUDGET
                </span>

                <strong>
                    {{ $propertyRequest->formatted_budget }}
                </strong>

                <small>
                    {{ $timeline }}
                </small>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon urgency-icon">
                <span>04</span>
            </div>

            <div class="summary-content">

                <span class="summary-label">
                    URGENCY
                </span>

                <strong class="{{ $urgencyClass }}">
                    {{ ucfirst($propertyRequest->urgency) }}
                </strong>

                <small>
                    {{ $propertyRequest->financing_needed
                        ? 'Financing required'
                        : 'No financing required' }}
                </small>

            </div>

        </div>

    </div>


    {{-- =========================================================
        MAIN LAYOUT
    ========================================================== --}}
    <div class="content-grid">

        {{-- =====================================================
            MAIN CONTENT
        ====================================================== --}}
        <main class="main-column">


            {{-- =================================================
                CLIENT INFORMATION
            ================================================= --}}
            <section class="card">

                <div class="card-header">

                    <div class="card-heading">

                        <div class="card-icon">
                            <span>01</span>
                        </div>

                        <div>
                            <h2>Client Information</h2>
                            <p>Contact details for this request</p>
                        </div>

                    </div>

                </div>


                <div class="info-grid">

                    <div class="info-item">

                        <span class="info-label">
                            FULL NAME
                        </span>

                        <span class="info-value">
                            {{ $propertyRequest->full_name }}
                        </span>

                    </div>


                    <div class="info-item">

                        <span class="info-label">
                            NATIONALITY
                        </span>

                        <span class="info-value">
                            {{ $propertyRequest->nationality ?: 'Not provided' }}
                        </span>

                    </div>


                    <div class="info-item">

                        <span class="info-label">
                            EMAIL
                        </span>

                        @if($propertyRequest->email)
                            <a href="mailto:{{ $propertyRequest->email }}"
                               class="info-link">
                                {{ $propertyRequest->email }}
                            </a>
                        @else
                            <span class="empty-text">
                                Not provided
                            </span>
                        @endif

                    </div>


                    <div class="info-item">

                        <span class="info-label">
                            PHONE
                        </span>

                        <div class="phone-value">

                            <a href="tel:{{ $propertyRequest->phone }}"
                               class="info-link">
                                {{ $propertyRequest->phone }}
                            </a>

                            @if($propertyRequest->whatsapp_number)

                                <a href="https://wa.me/{{ $propertyRequest->whatsapp_number }}"
                                   target="_blank"
                                   rel="noopener"
                                   class="whatsapp-link">
                                    WhatsApp
                                </a>

                            @endif

                        </div>

                    </div>


                    <div class="info-item">

                        <span class="info-label">
                            PREFERRED CONTACT
                        </span>

                        <span class="info-value">
                            {{ $contactMethod }}
                        </span>

                    </div>

                </div>

            </section>


            {{-- =================================================
                PROPERTY REQUEST
            ================================================= --}}
            <section class="card">

                <div class="card-header">

                    <div class="card-heading">

                        <div class="card-icon">
                            <span>02</span>
                        </div>

                        <div>
                            <h2>Property Request</h2>
                            <p>What the client is looking for</p>
                        </div>

                    </div>

                </div>


                <div class="request-highlight">

                    <div class="highlight-item">

                        <span class="info-label">
                            PROPERTY TYPE
                        </span>

                        <strong>
                            {{ $propertyRequest->property_type_label }}
                        </strong>

                    </div>


                    <div class="highlight-item">

                        <span class="info-label">
                            REQUEST TYPE
                        </span>

                        <strong>
                            {{ $requestType }}
                        </strong>

                    </div>


                    <div class="highlight-item">

                        <span class="info-label">
                            PROPERTY STATUS
                        </span>

                        <strong>
                            {{ $propertyStatus }}
                        </strong>

                    </div>

                </div>


                <div class="info-grid">

                    <div class="info-item full-width">

                        <span class="info-label">
                            PREFERRED LOCATION
                        </span>

                        <span class="info-value location-value">
                            <span class="location-marker">⌖</span>

                            {{ $propertyRequest->location_summary ?: 'Any location' }}
                        </span>

                    </div>


                    <div class="info-item full-width">

                        <span class="info-label">
                            LOCATION NOTES
                        </span>

                        <span class="info-value multiline">
                            {{ $propertyRequest->location_notes ?: 'No location notes provided.' }}
                        </span>

                    </div>

                </div>

            </section>


            {{-- =================================================
                BUDGET & TIMELINE
            ================================================= --}}
            <section class="card">

                <div class="card-header">

                    <div class="card-heading">

                        <div class="card-icon">
                            <span>03</span>
                        </div>

                        <div>
                            <h2>Budget & Timeline</h2>
                            <p>Financial expectations and timeline</p>
                        </div>

                    </div>

                </div>


                <div class="budget-box">

                    <div class="budget-item budget-primary">

                        <span class="info-label">
                            BUDGET RANGE
                        </span>

                        <strong>
                            {{ $propertyRequest->formatted_budget }}
                        </strong>

                    </div>


                    <div class="budget-item">

                        <span class="info-label">
                            TIMELINE
                        </span>

                        <strong>
                            {{ $timeline }}
                        </strong>

                    </div>


                    <div class="budget-item">

                        <span class="info-label">
                            FINANCING
                        </span>

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

            </section>


            {{-- =================================================
                REQUIREMENTS
            ================================================= --}}
            <section class="card">

                <div class="card-header">

                    <div class="card-heading">

                        <div class="card-icon">
                            <span>04</span>
                        </div>

                        <div>
                            <h2>Property Requirements</h2>
                            <p>Specific requirements from the client</p>
                        </div>

                    </div>

                </div>


                <div class="requirements-grid">

                    <div class="requirement-item">

                        <div class="requirement-number">
                            A
                        </div>

                        <div>

                            <span class="info-label">
                                BEDROOMS
                            </span>

                            <strong>
                                {{ $propertyRequest->bedrooms_min ?? 'Any' }}
                            </strong>

                        </div>

                    </div>


                    <div class="requirement-item">

                        <div class="requirement-number">
                            B
                        </div>

                        <div>

                            <span class="info-label">
                                BATHROOMS
                            </span>

                            <strong>
                                {{ $propertyRequest->bathrooms_min ?? 'Any' }}
                            </strong>

                        </div>

                    </div>


                    <div class="requirement-item">

                        <div class="requirement-number">
                            C
                        </div>

                        <div>

                            <span class="info-label">
                                LAND SIZE
                            </span>

                            <strong>

                                @if($propertyRequest->land_size_min || $propertyRequest->land_size_max)

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

                        <span class="info-label">
                            AMENITIES
                        </span>

                        @if($propertyRequest->amenities)

                            <div class="tag-list">

                                @foreach($propertyRequest->amenities as $amenity)

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

                        <span class="info-label">
                            MUST-HAVE FEATURES
                        </span>

                        @if($propertyRequest->must_have_features)

                            <div class="tag-list">

                                @foreach($propertyRequest->must_have_features as $feature)

                                    <span class="tag tag-important">
                                        <span>✓</span>
                                        {{ $feature }}
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

                        <span class="info-label">
                            NICE-TO-HAVE FEATURES
                        </span>

                        @if($propertyRequest->nice_to_have_features)

                            <div class="tag-list">

                                @foreach($propertyRequest->nice_to_have_features as $feature)

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

            </section>


            {{-- =================================================
                ADDITIONAL INFORMATION
            ================================================= --}}
            <section class="card">

                <div class="card-header">

                    <div class="card-heading">

                        <div class="card-icon">
                            <span>05</span>
                        </div>

                        <div>
                            <h2>Additional Information</h2>
                            <p>Other information provided by the client</p>
                        </div>

                    </div>

                </div>


                <div class="additional-grid">

                    <div class="additional-item">

                        <span class="info-label">
                            URGENCY
                        </span>

                        <span class="urgency-badge {{ $urgencyClass }}">
                            {{ ucfirst($propertyRequest->urgency) }}
                        </span>

                    </div>


                    <div class="additional-item">

                        <span class="info-label">
                            HOW THEY HEARD ABOUT US
                        </span>

                        <span class="info-value">
                            {{ $propertyRequest->how_did_you_hear ?: 'Not provided' }}
                        </span>

                    </div>


                    <div class="additional-item">

                        <span class="info-label">
                            NEWSLETTER
                        </span>

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

                        <span class="info-label">
                            CLIENT NOTES
                        </span>

                        <div class="notes-box">
                            {{ $propertyRequest->additional_notes ?: 'No additional notes were provided.' }}
                        </div>

                    </div>

                </div>

            </section>

        </main>


        {{-- =====================================================
            SIDEBAR
        ====================================================== --}}
        <aside class="sidebar">

            {{-- MANAGEMENT --}}
            <section class="card management-card">

                <div class="card-header">

                    <div class="card-heading">

                        <div class="card-icon management-icon">
                            ⚙
                        </div>

                        <div>
                            <h2>Manage Request</h2>
                            <p>Update internal request details</p>
                        </div>

                    </div>

                </div>


                <form method="POST"
                      action="{{ route('admin.property-requests.update-status', $propertyRequest->id) }}">

                    @csrf
                    @method('PATCH')


                    <div class="field">

                        <label for="status">
                            Request Status
                        </label>

                        <select id="status"
                                name="status"
                                class="form-control">

                            @foreach(\App\Models\PropertyRequest::STATUSES as $key => $label)

                                <option value="{{ $key }}"
                                    @selected($propertyRequest->status === $key)>
                                    {{ $label }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="field">

                        <label for="assigned_agent">
                            Assigned Agent
                        </label>

                        <input type="text"
                               id="assigned_agent"
                               name="assigned_agent"
                               class="form-control"
                               value="{{ $propertyRequest->assigned_agent }}"
                               placeholder="Enter agent name">

                    </div>


                    <div class="field">

                        <label for="admin_notes">
                            Internal Notes
                        </label>

                        <textarea id="admin_notes"
                                  name="admin_notes"
                                  class="form-control"
                                  placeholder="Add internal notes...">{{ $propertyRequest->admin_notes }}</textarea>

                    </div>


                    <label class="public-toggle">

                        <input type="checkbox"
                               name="is_public"
                               value="1"
                               @checked($propertyRequest->is_public)>

                        <span class="toggle-box"></span>

                        <span class="toggle-content">

                            <strong>
                                Public Request
                            </strong>

                            <small>
                                Visible on the public website
                            </small>

                        </span>

                    </label>


                    <button type="submit"
                            class="btn btn-primary btn-full">
                        Save Management Changes
                    </button>

                </form>

            </section>


            {{-- QUICK ACTIONS --}}
            <section class="card">

                <div class="card-header compact-header">

                    <div class="card-heading">

                        <div class="card-icon">
                            ⚡
                        </div>

                        <div>
                            <h2>Quick Actions</h2>
                        </div>

                    </div>

                </div>


                <div class="quick-actions">

                    @if($propertyRequest->email)

                        <a href="mailto:{{ $propertyRequest->email }}"
                           class="quick-action">

                            <span class="action-icon">
                                ✉
                            </span>

                            <span>
                                Email Client
                            </span>

                        </a>

                    @endif


                    @if($propertyRequest->phone)

                        <a href="tel:{{ $propertyRequest->phone }}"
                           class="quick-action">

                            <span class="action-icon">
                                ☎
                            </span>

                            <span>
                                Call Client
                            </span>

                        </a>

                    @endif


                    @if($propertyRequest->whatsapp_number)

                        <a href="https://wa.me/{{ $propertyRequest->whatsapp_number }}"
                           target="_blank"
                           rel="noopener"
                           class="quick-action">

                            <span class="action-icon">
                                ◉
                            </span>

                            <span>
                                WhatsApp
                            </span>

                        </a>

                    @endif


                    <a href="{{ route('admin.property-requests.edit', $propertyRequest->id) }}"
                       class="quick-action">

                        <span class="action-icon">
                            ✎
                        </span>

                        <span>
                            Edit Request
                        </span>

                    </a>

                </div>

            </section>


            {{-- REQUEST DETAILS --}}
            <section class="card">

                <div class="card-header compact-header">

                    <div class="card-heading">

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

                        <span>
                            Reference
                        </span>

                        <strong>
                            {{ $propertyRequest->reference_number }}
                        </strong>

                    </div>


                    <div class="meta-row">

                        <span>
                            Submitted
                        </span>

                        <strong>
                            {{ $propertyRequest->created_at->format('M d, Y') }}
                        </strong>

                    </div>


                    <div class="meta-row">

                        <span>
                            Last Updated
                        </span>

                        <strong>
                            {{ $propertyRequest->updated_at->format('M d, Y') }}
                        </strong>

                    </div>


                    <div class="meta-row">

                        <span>
                            Visibility
                        </span>

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

            </section>


            {{-- DANGER ZONE --}}
            <section class="danger-card">

                <div class="danger-header">

                    <div>

                        <strong>
                            Danger Zone
                        </strong>

                        <p>
                            Permanently delete this request.
                        </p>

                    </div>

                    <span>
                        !
                    </span>

                </div>


                <form method="POST"
                      action="{{ route('admin.property-requests.destroy', $propertyRequest->id) }}"
                      onsubmit="return confirm('Delete this property request? This action cannot be undone.');">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="delete-btn">
                        Delete Request
                    </button>

                </form>

            </section>

        </aside>

    </div>

</div>


<style>

/* =========================================================
   VARIABLES
========================================================= */

:root {
    --terra-navy: #19265d;
    --terra-navy-dark: #111a45;

    --terra-orange: #D05208;
    --terra-orange-dark: #a94105;

    --text: #1f2937;
    --muted: #6b7280;
    --light-muted: #9ca3af;

    --border: #e5e7eb;
    --border-light: #eef0f3;

    --background: #f5f6f8;
    --white: #ffffff;

    --success: #15803d;
    --success-bg: #dcfce7;

    --warning: #a16207;
    --warning-bg: #fef3c7;

    --danger: #b91c1c;
    --danger-bg: #fee2e2;

    --blue: #2563eb;
    --blue-bg: #dbeafe;
}


/* =========================================================
   PAGE
========================================================= */

.request-page {
    width: 100%;
    max-width: 1480px;
    margin: 0 auto;
    padding: 1.5rem 1.25rem 3rem;

    box-sizing: border-box;

    color: var(--text);
    font-family: 'DM Sans', sans-serif;
}


/* =========================================================
   HEADER
========================================================= */

.page-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;

    gap: 2rem;

    margin-bottom: 1.5rem;
}

.page-heading {
    min-width: 0;
}

.back-link {
    display: inline-flex;
    align-items: center;

    gap: .5rem;

    margin-bottom: .85rem;

    color: var(--muted);

    font-size: .78rem;
    font-weight: 700;

    text-decoration: none;
}

.back-link:hover {
    color: var(--terra-orange);
}

.back-icon {
    font-size: 1rem;
}

.eyebrow {
    margin-bottom: .35rem;

    color: var(--terra-orange);

    font-size: .62rem;
    font-weight: 800;

    letter-spacing: .16em;
}

.title-line {
    display: flex;
    align-items: center;
    flex-wrap: wrap;

    gap: .75rem;
}

.page-header h1 {
    margin: 0;

    color: var(--terra-navy-dark);

    /* font-family: 'Cormorant Garamond', serif; */

    font-size: clamp(1rem, 1vw, 2.55rem);
    line-height: 1;
}

.subtitle {
    margin: .5rem 0 0;

    color: var(--muted);

    font-size: .76rem;
}

.header-actions {
    flex-shrink: 0;
}


/* =========================================================
   BUTTONS
========================================================= */

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: .45rem;

    min-height: 40px;

    padding: .65rem 1rem;

    border: 1px solid transparent;
    border-radius: 7px;

    font-family: inherit;
    font-size: .76rem;
    font-weight: 700;

    text-decoration: none;

    cursor: pointer;

    transition:
        background .15s ease,
        border-color .15s ease,
        color .15s ease,
        transform .15s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.btn-outline {
    background: var(--white);
    border-color: var(--border);

    color: var(--terra-navy);
}

.btn-outline:hover {
    border-color: var(--terra-orange);
    color: var(--terra-orange);
}

.btn-primary {
    background: var(--terra-orange);
    color: #fff;
}

.btn-primary:hover {
    background: var(--terra-orange-dark);
}

.btn-full {
    width: 100%;
}

.btn-symbol {
    font-size: .9rem;
}


/* =========================================================
   STATUS
========================================================= */

.status-badge {
    display: inline-flex;
    align-items: center;

    gap: .4rem;

    padding: .38rem .65rem;

    border-radius: 999px;

    font-size: .65rem;
    font-weight: 800;

    white-space: nowrap;
}

.status-dot {
    width: 6px;
    height: 6px;

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

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: .9rem;

    margin-bottom: 1.4rem;
}

.summary-card {
    display: flex;
    align-items: center;

    gap: .8rem;

    min-width: 0;

    padding: 1rem;

    background: var(--white);

    border: 1px solid var(--border);
    border-radius: 10px;

    box-shadow: 0 1px 2px rgba(15, 23, 42, .025);
}

.summary-icon {
    display: flex;
    align-items: center;
    justify-content: center;

    flex: 0 0 40px;

    width: 40px;
    height: 40px;

    border-radius: 8px;

    font-size: .62rem;
    font-weight: 900;
}

.summary-icon span {
    opacity: .85;
}

.client-icon {
    color: #4338ca;
    background: #eef2ff;
}

.property-icon {
    color: #15803d;
    background: #f0fdf4;
}

.budget-icon {
    color: var(--terra-orange);
    background: #fff7ed;
}

.urgency-icon {
    color: var(--danger);
    background: #fef2f2;
}

.summary-content {
    min-width: 0;
}

.summary-label {
    display: block;

    margin-bottom: .18rem;

    color: var(--light-muted);

    font-size: .58rem;
    font-weight: 800;

    letter-spacing: .1em;
}

.summary-card strong {
    display: block;

    overflow: hidden;

    color: var(--terra-navy-dark);

    font-size: .82rem;

    white-space: nowrap;
    text-overflow: ellipsis;
}

.summary-card small {
    display: block;

    margin-top: .15rem;

    overflow: hidden;

    color: var(--muted);

    font-size: .68rem;

    white-space: nowrap;
    text-overflow: ellipsis;
}


/* =========================================================
   CONTENT GRID
========================================================= */

.content-grid {
    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        340px;

    align-items: start;

    gap: 1.4rem;

    width: 100%;
}

.main-column,
.sidebar {
    min-width: 0;
}


/*
|--------------------------------------------------------------------------
| IMPORTANT SCROLL FIX
|--------------------------------------------------------------------------
|
| The previous version used:
|
| .manage-card {
|     position: sticky;
|     top: 1rem;
| }
|
| That can overlap a fixed/sticky admin navbar.
|
| The sidebar is intentionally NOT sticky.
|
*/

.sidebar {
    position: static;
}

.management-card {
    position: static;
}


/* =========================================================
   CARD
========================================================= */

.card {
    width: 100%;

    box-sizing: border-box;

    margin-bottom: 1.15rem;

    padding: 1.25rem;

    background: var(--white);

    border: 1px solid var(--border);
    border-radius: 11px;

    box-shadow:
        0 1px 2px rgba(15, 23, 42, .025);
}

.card:last-child {
    margin-bottom: 0;
}

.card-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;

    gap: 1rem;

    padding-bottom: .95rem;
    margin-bottom: 1rem;

    border-bottom: 1px solid var(--border-light);
}

.compact-header {
    margin-bottom: .65rem;
}

.card-heading {
    display: flex;
    align-items: center;

    gap: .7rem;

    min-width: 0;
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

    font-size: .62rem;
    font-weight: 900;
}

.card-heading h2 {
    margin: 0;

    color: var(--terra-navy-dark);

    font-family: 'Cormorant Garamond', serif;

    font-size: 1.35rem;
    line-height: 1;
}

.card-heading p {
    margin: .25rem 0 0;

    color: var(--muted);

    font-size: .67rem;
}


/* =========================================================
   INFORMATION
========================================================= */

.info-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 1rem 2rem;
}

.info-item {
    display: flex;
    flex-direction: column;

    min-width: 0;

    gap: .28rem;
}

.full-width {
    grid-column: 1 / -1;
}

.info-label {
    display: block;

    color: var(--light-muted);

    font-size: .58rem;
    font-weight: 800;

    letter-spacing: .09em;
}

.info-value {
    color: var(--text);

    font-size: .82rem;
    font-weight: 500;

    overflow-wrap: anywhere;
}

.info-link {
    color: var(--terra-navy);

    font-size: .82rem;
    font-weight: 600;

    text-decoration: none;

    overflow-wrap: anywhere;
}

.info-link:hover {
    color: var(--terra-orange);
}

.phone-value {
    display: flex;
    align-items: center;

    flex-wrap: wrap;

    gap: .5rem;
}

.whatsapp-link {
    display: inline-flex;
    align-items: center;

    padding: .2rem .5rem;

    border-radius: 5px;

    background: #f0fdf4;

    color: #15803d;

    font-size: .62rem;
    font-weight: 800;

    text-decoration: none;
}

.multiline {
    line-height: 1.65;

    color: #4b5563;

    white-space: pre-wrap;
}

.location-value {
    display: flex;
    align-items: flex-start;

    gap: .4rem;
}

.location-marker {
    flex-shrink: 0;

    color: var(--terra-orange);

    font-size: 1rem;
}


/* =========================================================
   REQUEST HIGHLIGHT
========================================================= */

.request-highlight {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: .7rem;

    margin-bottom: 1.15rem;
}

.highlight-item {
    min-width: 0;

    padding: .85rem;

    background: #f8f9fb;

    border: 1px solid #f0f1f3;

    border-radius: 8px;
}

.highlight-item strong {
    display: block;

    margin-top: .25rem;

    color: var(--terra-navy-dark);

    font-size: .78rem;

    overflow-wrap: anywhere;
}


/* =========================================================
   BUDGET
========================================================= */

.budget-box {
    display: grid;

    grid-template-columns:
        1.5fr
        1fr
        1fr;

    gap: 0;

    overflow: hidden;

    background: #fafafa;

    border: 1px solid #f0f1f3;
    border-radius: 9px;
}

.budget-item {
    min-width: 0;

    padding: 1rem;

    border-right: 1px solid var(--border);
}

.budget-item:last-child {
    border-right: 0;
}

.budget-primary {
    background: #fffaf6;
}

.budget-primary strong {
    display: block;

    margin-top: .2rem;

    color: var(--terra-orange);

    font-size: 1.1rem;

    overflow-wrap: anywhere;
}

.budget-item > strong {
    display: block;

    margin-top: .25rem;

    color: var(--terra-navy-dark);

    font-size: .78rem;

    overflow-wrap: anywhere;
}

.finance-badge {
    display: inline-flex;

    margin-top: .3rem;

    padding: .25rem .5rem;

    border-radius: 999px;

    font-size: .6rem;
    font-weight: 800;
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

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: .7rem;

    margin-bottom: 1.3rem;
}

.requirement-item {
    display: flex;
    align-items: center;

    gap: .65rem;

    min-width: 0;

    padding: .8rem;

    border: 1px solid var(--border);
    border-radius: 8px;
}

.requirement-number {
    display: flex;
    align-items: center;
    justify-content: center;

    flex: 0 0 30px;

    width: 30px;
    height: 30px;

    border-radius: 7px;

    background: #f4f5f8;

    color: var(--terra-navy);

    font-size: .6rem;
    font-weight: 900;
}

.requirement-item strong {
    display: block;

    margin-top: .2rem;

    color: var(--terra-navy-dark);

    font-size: .78rem;

    overflow-wrap: anywhere;
}

.feature-sections {
    display: flex;
    flex-direction: column;

    gap: 1rem;
}

.feature-block {
    padding-top: .95rem;

    border-top: 1px solid #f0f1f3;
}

.tag-list {
    display: flex;

    flex-wrap: wrap;

    gap: .4rem;

    margin-top: .5rem;
}

.tag {
    display: inline-flex;
    align-items: center;

    gap: .25rem;

    max-width: 100%;

    padding: .3rem .55rem;

    background: #f3f4f6;

    color: #4b5563;

    border-radius: 5px;

    font-size: .63rem;
    font-weight: 600;

    overflow-wrap: anywhere;
}

.tag-important {
    background: #fff7ed;

    color: var(--terra-orange);
}


/* =========================================================
   ADDITIONAL
========================================================= */

.additional-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 1rem 2rem;
}

.additional-item {
    display: flex;
    flex-direction: column;

    min-width: 0;

    gap: .3rem;
}

.urgency-badge {
    width: fit-content;

    padding: .3rem .6rem;

    border-radius: 999px;

    font-size: .62rem;
    font-weight: 800;
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

.urgency-badge.urgency-high {
    background: var(--danger-bg);
}

.urgency-badge.urgency-medium {
    background: var(--warning-bg);
}

.urgency-badge.urgency-low {
    background: var(--success-bg);
}

.newsletter-yes {
    color: var(--success);

    font-size: .75rem;
    font-weight: 700;
}

.notes-box {
    margin-top: .15rem;

    padding: .85rem;

    background: #f8f9fb;

    border: 1px solid #f0f1f3;
    border-radius: 7px;

    color: #4b5563;

    font-size: .76rem;
    line-height: 1.65;

    white-space: pre-wrap;
    overflow-wrap: anywhere;
}

.empty-text {
    color: var(--light-muted);

    font-size: .72rem;

    font-style: italic;
}


/* =========================================================
   MANAGEMENT
========================================================= */

.management-icon {
    background: #fff7ed;

    color: var(--terra-orange);
}

.field {
    display: flex;
    flex-direction: column;

    gap: .35rem;

    margin-bottom: .9rem;
}

.field label {
    color: #374151;

    font-size: .7rem;
    font-weight: 700;
}

.form-control {
    display: block;

    width: 100%;

    box-sizing: border-box;

    padding: .65rem .7rem;

    background: #fff;

    border: 1px solid #d1d5db;
    border-radius: 7px;

    color: #1f2937;

    font-family: inherit;
    font-size: .76rem;

    transition:
        border-color .15s ease,
        box-shadow .15s ease;
}

.form-control:focus {
    outline: none;

    border-color: var(--terra-orange);

    box-shadow:
        0 0 0 3px rgba(208, 82, 8, .08);
}

textarea.form-control {
    min-height: 105px;

    resize: vertical;
}


/* =========================================================
   PUBLIC TOGGLE
========================================================= */

.public-toggle {
    display: flex;
    align-items: center;

    gap: .65rem;

    padding: .75rem;

    margin-bottom: .9rem;

    background: #f8f9fb;

    border: 1px solid var(--border);

    border-radius: 8px;

    cursor: pointer;
}

.public-toggle input {
    position: absolute;

    width: 1px;
    height: 1px;

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

    gap: .08rem;

    min-width: 0;
}

.toggle-content strong {
    color: var(--text);

    font-size: .72rem;
}

.toggle-content small {
    color: var(--muted);

    font-size: .61rem;
}


/* =========================================================
   QUICK ACTIONS
========================================================= */

.quick-actions {
    display: flex;
    flex-direction: column;
}

.quick-action {
    display: flex;
    align-items: center;

    gap: .65rem;

    padding: .6rem .15rem;

    border-bottom: 1px solid #f0f1f3;

    color: #374151;

    font-size: .73rem;
    font-weight: 600;

    text-decoration: none;
}

.quick-action:last-child {
    border-bottom: 0;
}

.action-icon {
    display: flex;
    align-items: center;
    justify-content: center;

    flex: 0 0 28px;

    width: 28px;
    height: 28px;

    border-radius: 6px;

    background: #f5f6f8;

    color: var(--terra-navy);

    font-size: .72rem;
}

.quick-action:hover {
    color: var(--terra-orange);
}

.quick-action:hover .action-icon {
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
    align-items: center;
    justify-content: space-between;

    gap: .8rem;

    padding: .65rem 0;

    border-bottom: 1px solid #f0f1f3;
}

.meta-row:last-child {
    border-bottom: 0;
}

.meta-row > span:first-child {
    color: var(--muted);

    font-size: .67rem;
}

.meta-row strong {
    max-width: 60%;

    color: var(--terra-navy-dark);

    font-size: .67rem;

    text-align: right;

    overflow-wrap: anywhere;
}

.visibility {
    padding: .25rem .5rem;

    border-radius: 999px;

    font-size: .59rem !important;
    font-weight: 800;
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
    align-items: flex-start;
    justify-content: space-between;

    gap: .7rem;

    margin-bottom: .8rem;
}

.danger-header strong {
    color: #991b1b;

    font-size: .75rem;
}

.danger-header p {
    margin: .2rem 0 0;

    color: #9f1239;

    font-size: .62rem;
}

.danger-header > span {
    display: flex;
    align-items: center;
    justify-content: center;

    flex: 0 0 25px;

    width: 25px;
    height: 25px;

    border-radius: 6px;

    background: #fee2e2;

    color: #b91c1c;

    font-size: .75rem;
    font-weight: 800;
}

.delete-btn {
    width: 100%;

    padding: .62rem;

    background: #fff;

    border: 1px solid #fca5a5;
    border-radius: 6px;

    color: #b91c1c;

    font-family: inherit;

    font-size: .69rem;
    font-weight: 700;

    cursor: pointer;

    transition: .15s ease;
}

.delete-btn:hover {
    background: #fee2e2;

    border-color: #f87171;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1150px) {

    .summary-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .content-grid {
        grid-template-columns:
            minmax(0, 1fr)
            310px;
    }

}


/* =========================================================
   SMALL TABLET
========================================================= */

@media (max-width: 900px) {

    .page-header {
        align-items: flex-start;

        flex-direction: column;

        gap: 1rem;
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

    /*
     * Explicitly keep sidebar in normal document flow.
     */
    .sidebar {
        position: static;
    }

    .management-card {
        position: static;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 650px) {

    .request-page {
        padding:
            1rem
            .75rem
            2rem;
    }

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .title-line {
        align-items: flex-start;

        flex-direction: column;

        gap: .55rem;
    }

    .page-header h1 {
        font-size: 2rem;
    }

    .card {
        padding: 1rem;

        border-radius: 9px;
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

    .budget-item {
        border-right: 0;

        border-bottom: 1px solid var(--border);
    }

    .budget-item:last-child {
        border-bottom: 0;
    }

}


/* =========================================================
   VERY SMALL DEVICES
========================================================= */

@media (max-width: 420px) {

    .request-page {
        padding-left: .6rem;
        padding-right: .6rem;
    }

    .summary-card {
        padding: .8rem;
    }

    .card-header {
        gap: .6rem;
    }

    .card-heading h2 {
        font-size: 1.2rem;
    }

    .card-heading p {
        font-size: .62rem;
    }

    .meta-row {
        align-items: flex-start;

        flex-direction: column;

        gap: .2rem;
    }

    .meta-row strong {
        max-width: 100%;

        text-align: left;
    }

}

</style>

@endsection