@extends('layouts.app')

@section('title', $propertyRequest->reference_number)

@section('content')
<div class="page-header">
    <div>
        <h1>{{ $propertyRequest->reference_number }}</h1>
        <p class="subtitle">Submitted {{ $propertyRequest->created_at->format('M d, Y \a\t g:i A') }}</p>
    </div>
    <a href="{{ route('admin.property-requests.index') }}" class="btn-link">← Back to list</a>
</div>

<div class="show-grid">
    <div class="main-col">
        <div class="card">
            <h3>Client</h3>
            <dl>
                <dt>Name</dt>
                <dd>{{ $propertyRequest->full_name }}</dd>
                <dt>Email</dt>
                <dd>{{ $propertyRequest->email }}</dd>
                <dt>Phone</dt>
                <dd>{{ $propertyRequest->phone }}
                    @if ($propertyRequest->whatsapp_number)
                    <a href="https://wa.me/{{ $propertyRequest->whatsapp_number }}" target="_blank" class="wa-link">WhatsApp</a>
                    @endif
                </dd>
                <dt>Nationality</dt>
                <dd>{{ $propertyRequest->nationality ?: '—' }}</dd>
                <dt>Preferred Contact</dt>
                <dd>{{ \App\Models\PropertyRequest::CONTACT_METHODS[$propertyRequest->preferred_contact] ?? $propertyRequest->preferred_contact }}</dd>
            </dl>
        </div>

        <div class="card">
            <h3>Request</h3>
            <dl>
                <dt>Type</dt>
                <dd>{{ \App\Models\PropertyRequest::REQUEST_TYPES[$propertyRequest->request_type] ?? $propertyRequest->request_type }}</dd>
                <dt>Property Type</dt>
                <dd>{{ $propertyRequest->property_type_label }}</dd>
                <dt>Property Status</dt>
                <dd>{{ \App\Models\PropertyRequest::PROPERTY_STATUSES[$propertyRequest->property_status] ?? $propertyRequest->property_status }}</dd>
                <dt>Location</dt>
                <dd>{{ $propertyRequest->location_summary ?: '—' }}</dd>
                <dt>Location Notes</dt>
                <dd>{{ $propertyRequest->location_notes ?: '—' }}</dd>
                <dt>Budget</dt>
                <dd>{{ $propertyRequest->formatted_budget }}</dd>
                <dt>Timeline</dt>
                <dd>{{ \App\Models\PropertyRequest::TIMELINES[$propertyRequest->timeline] ?? $propertyRequest->timeline }}</dd>
                <dt>Financing Needed</dt>
                <dd>{{ $propertyRequest->financing_needed ? 'Yes' : 'No' }}</dd>
            </dl>
        </div>

        <div class="card">
            <h3>Requirements</h3>
            <dl>
                <dt>Min Bedrooms</dt>
                <dd>{{ $propertyRequest->bedrooms_min ?? '—' }}</dd>
                <dt>Min Bathrooms</dt>
                <dd>{{ $propertyRequest->bathrooms_min ?? '—' }}</dd>
                <dt>Land Size</dt>
                <dd>
                    @if ($propertyRequest->land_size_min || $propertyRequest->land_size_max)
                    {{ $propertyRequest->land_size_min ?? '?' }} – {{ $propertyRequest->land_size_max ?? '?' }} sqm
                    @else — @endif
                </dd>
                <dt>Amenities</dt>
                <dd>{{ $propertyRequest->amenities ? implode(', ', $propertyRequest->amenities) : '—' }}</dd>
                <dt>Must-Have</dt>
                <dd>{{ $propertyRequest->must_have_features ? implode(', ', $propertyRequest->must_have_features) : '—' }}</dd>
                <dt>Nice-to-Have</dt>
                <dd>{{ $propertyRequest->nice_to_have_features ? implode(', ', $propertyRequest->nice_to_have_features) : '—' }}</dd>
            </dl>
        </div>

        <div class="card">
            <h3>Additional</h3>
            <dl>
                <dt>Notes</dt>
                <dd>{{ $propertyRequest->additional_notes ?: '—' }}</dd>
                <dt>How They Heard</dt>
                <dd>{{ $propertyRequest->how_did_you_hear ?: '—' }}</dd>
                <dt>Newsletter</dt>
                <dd>{{ $propertyRequest->newsletter_opt_in ? 'Opted in' : 'No' }}</dd>
                <dt>Urgency</dt>
                <dd><span class="badge badge-{{ $propertyRequest->urgency_badge_color }}">{{ ucfirst($propertyRequest->urgency) }}</span></dd>
            </dl>
        </div>
    </div>

    <div class="side-col">
        <div class="card">
            <h3>Manage</h3>
            <form method="POST" action="{{ route('admin.property-requests.update-status', $propertyRequest->id) }}">
                @csrf
                @method('PATCH')

                <div class="field">
                    <label>Status</label>
                    <select name="status">
                        @foreach (\App\Models\PropertyRequest::STATUSES as $key => $label)
                        <option value="{{ $key }}" @selected($propertyRequest->status === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label>Assigned Agent</label>
                    <input type="text" name="assigned_agent" value="{{ $propertyRequest->assigned_agent }}">
                </div>

                <div class="field">
                    <label>Admin Notes</label>
                    <textarea name="admin_notes">{{ $propertyRequest->admin_notes }}</textarea>
                </div>

                <div class="field">
                    <label><input type="checkbox" name="is_public" value="1" @checked($propertyRequest->is_public)> Public (visible on site)</label>
                </div>

                <button type="submit" class="btn btn-gold btn-full">Save Changes</button>
            </form>
        </div>

        <div class="card danger-card">
            <h3>Danger Zone</h3>
            <form method="POST" action="{{ route('admin.property-requests.destroy', $propertyRequest->id) }}"
                onsubmit="return confirm('Delete this request? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-full">Delete Request</button>
            </form>
        </div>
    </div>
</div>

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
        font-family: monospace;
        color: var(--navy-dark);
        font-size: 1.8rem;
        margin: 0;
    }

    .subtitle {
        font-family: 'DM Sans', sans-serif;
        color: #6b7280;
        margin: .25rem 0 0;
    }

    .btn-link {
        color: var(--gold);
        font-weight: 600;
        text-decoration: none;
        font-family: 'DM Sans', sans-serif;
    }

    .show-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        align-items: start;
        font-family: 'DM Sans', sans-serif;
    }

    .card {
        background: #fff;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
        margin-bottom: 1.5rem;
    }

    .card h3 {
        font-family: 'Cormorant Garamond', serif;
        color: var(--navy-dark);
        margin: 0 0 1rem;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: .5rem;
    }

    dl {
        display: grid;
        grid-template-columns: 140px 1fr;
        row-gap: .6rem;
        margin: 0;
    }

    dt {
        color: #6b7280;
        font-size: .85rem;
    }

    dd {
        margin: 0;
        color: #1f2937;
    }

    .wa-link {
        margin-left: .5rem;
        color: #16a34a;
        font-size: .8rem;
        text-decoration: none;
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

    .field {
        display: flex;
        flex-direction: column;
        gap: .35rem;
        margin-bottom: 1rem;
    }

    .field label {
        font-size: .85rem;
        font-weight: 600;
        color: #374151;
    }

    .field input,
    .field select,
    .field textarea {
        padding: .55rem .7rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-family: 'DM Sans', sans-serif;
    }

    .field textarea {
        min-height: 70px;
        resize: vertical;
    }

    .btn {
        padding: .65rem 1.2rem;
        border-radius: 6px;
        border: none;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-full {
        width: 100%;
    }

    .btn-gold {
        background: var(--gold);
        color: #fff;
    }

    .btn-danger {
        background: #fee2e2;
        color: #b91c1c;
    }

    .danger-card h3 {
        color: #b91c1c;
    }
</style>
@endsection