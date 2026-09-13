@extends('layouts.app')

@section('title', 'Edit Property Request')

@section('content')

<div class="page-header">
    <div>
        <span class="page-eyebrow">PROPERTY REQUEST</span>
        <h1>Edit Property Request</h1>

        @if($propertyRequest->reference_number)
            <p class="reference">
                Reference:
                <strong>{{ $propertyRequest->reference_number }}</strong>
            </p>
        @endif
    </div>

    <a href="{{ route('admin.property-requests.show', $propertyRequest) }}"
       class="btn-link">
        ← Back to Request
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-error">
        <strong>Please correct the following errors:</strong>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST"
      action="{{ route('admin.property-requests.update', $propertyRequest) }}"
      class="form-card">

    @csrf
    @method('PUT')

    {{-- =========================================================
         CONTACT INFORMATION
    ========================================================== --}}
    <div class="section-header">
        <div class="section-number">01</div>
        <div>
            <h3>Contact Information</h3>
            <p>Basic information about the person making the request.</p>
        </div>
    </div>

    <div class="grid-2">

        <div class="field">
            <label for="full_name">
                Full Name <span>*</span>
            </label>

            <input
                type="text"
                id="full_name"
                name="full_name"
                value="{{ old('full_name', $propertyRequest->full_name) }}"
                required
            >
        </div>

        <div class="field">
            <label for="email">
                Email <span>*</span>
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $propertyRequest->email) }}"
                required
            >
        </div>

        <div class="field">
            <label for="phone">
                Phone (07XXXXXXXX) <span>*</span>
            </label>

            <input
                type="text"
                id="phone"
                name="phone"
                value="{{ old('phone', $propertyRequest->phone) }}"
                required
            >
        </div>

        <div class="field">
            <label for="nationality">
                Nationality
            </label>

            <input
                type="text"
                id="nationality"
                name="nationality"
                value="{{ old('nationality', $propertyRequest->nationality) }}"
            >
        </div>

        <div class="field">
            <label for="preferred_contact">
                Preferred Contact Method <span>*</span>
            </label>

            <select
                id="preferred_contact"
                name="preferred_contact"
                required
            >
                @foreach (\App\Models\PropertyRequest::CONTACT_METHODS as $key => $label)
                    <option
                        value="{{ $key }}"
                        @selected(old('preferred_contact', $propertyRequest->preferred_contact) === $key)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>


    {{-- =========================================================
         REQUEST DETAILS
    ========================================================== --}}
    <div class="section-header">
        <div class="section-number">02</div>
        <div>
            <h3>Request Details</h3>
            <p>What type of property is the client looking for?</p>
        </div>
    </div>

    <div class="grid-2">

        <div class="field">
            <label for="request_type">
                Request Type <span>*</span>
            </label>

            <select
                id="request_type"
                name="request_type"
                required
            >
                @foreach (\App\Models\PropertyRequest::REQUEST_TYPES as $key => $label)
                    <option
                        value="{{ $key }}"
                        @selected(old('request_type', $propertyRequest->request_type) === $key)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="property_type">
                Property Type <span>*</span>
            </label>

            <select
                id="property_type"
                name="property_type"
                required
            >
                @foreach (\App\Models\PropertyRequest::PROPERTY_TYPES as $key => $label)
                    <option
                        value="{{ $key }}"
                        @selected(old('property_type', $propertyRequest->property_type) === $key)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="property_status">
                Property Status <span>*</span>
            </label>

            <select
                id="property_status"
                name="property_status"
                required
            >
                @foreach (\App\Models\PropertyRequest::PROPERTY_STATUSES as $key => $label)
                    <option
                        value="{{ $key }}"
                        @selected(old('property_status', $propertyRequest->property_status) === $key)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>


    {{-- =========================================================
         LOCATION
    ========================================================== --}}
    <div class="section-header">
        <div class="section-number">03</div>
        <div>
            <h3>Location Preference</h3>
            <p>Preferred area where the property should be located.</p>
        </div>
    </div>

    <div class="grid-2">

        <div class="field">
            <label for="province-select">
                Province
            </label>

            <select
                name="preferred_province"
                id="province-select"
            >
                <option value="">Any Province</option>

                @foreach ($provinceDistricts as $province => $districts)
                    <option
                        value="{{ $province }}"
                        @selected(old('preferred_province', $propertyRequest->preferred_province) === $province)
                    >
                        {{ $province }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="district-select">
                District
            </label>

            <select
                name="preferred_district"
                id="district-select"
            >
                <option value="">Any District</option>
            </select>
        </div>

        <div class="field">
            <label for="preferred_sector">
                Sector
            </label>

            <input
                type="text"
                id="preferred_sector"
                name="preferred_sector"
                value="{{ old('preferred_sector', $propertyRequest->preferred_sector) }}"
            >
        </div>

        <div class="field full">
            <label for="location_notes">
                Location Notes
            </label>

            <textarea
                id="location_notes"
                name="location_notes"
            >{{ old('location_notes', $propertyRequest->location_notes) }}</textarea>
        </div>

    </div>


    {{-- =========================================================
         BUDGET & TIMELINE
    ========================================================== --}}
    <div class="section-header">
        <div class="section-number">04</div>
        <div>
            <h3>Budget & Timeline</h3>
            <p>Financial requirements and expected purchase or rental timeline.</p>
        </div>
    </div>

    <div class="grid-2">

        <div class="field">
            <label for="currency">
                Currency <span>*</span>
            </label>

            <select
                id="currency"
                name="currency"
                required
            >
                @foreach (\App\Models\PropertyRequest::CURRENCIES as $key => $label)
                    <option
                        value="{{ $key }}"
                        @selected(old('currency', $propertyRequest->currency) === $key)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="timeline">
                Timeline <span>*</span>
            </label>

            <select
                id="timeline"
                name="timeline"
                required
            >
                @foreach (\App\Models\PropertyRequest::TIMELINES as $key => $label)
                    <option
                        value="{{ $key }}"
                        @selected(old('timeline', $propertyRequest->timeline) === $key)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="budget_min">
                Minimum Budget
            </label>

            <input
                type="number"
                step="0.01"
                min="0"
                id="budget_min"
                name="budget_min"
                value="{{ old('budget_min', $propertyRequest->budget_min) }}"
            >
        </div>

        <div class="field">
            <label for="budget_max">
                Maximum Budget
            </label>

            <input
                type="number"
                step="0.01"
                min="0"
                id="budget_max"
                name="budget_max"
                value="{{ old('budget_max', $propertyRequest->budget_max) }}"
            >
        </div>

        <div class="field checkbox-field">
            <label>
                <input
                    type="checkbox"
                    name="financing_needed"
                    value="1"
                    @checked(old(
                        'financing_needed',
                        $propertyRequest->financing_needed
                    ))
                >

                <span>Client needs financing</span>
            </label>
        </div>

    </div>


    {{-- =========================================================
         PROPERTY REQUIREMENTS
    ========================================================== --}}
    <div class="section-header">
        <div class="section-number">05</div>
        <div>
            <h3>Property Requirements</h3>
            <p>Minimum physical requirements for the requested property.</p>
        </div>
    </div>

    <div class="grid-2">

        <div class="field">
            <label for="bedrooms_min">
                Minimum Bedrooms
            </label>

            <input
                type="number"
                min="0"
                max="20"
                id="bedrooms_min"
                name="bedrooms_min"
                value="{{ old('bedrooms_min', $propertyRequest->bedrooms_min) }}"
            >
        </div>

        <div class="field">
            <label for="bathrooms_min">
                Minimum Bathrooms
            </label>

            <input
                type="number"
                min="0"
                max="20"
                id="bathrooms_min"
                name="bathrooms_min"
                value="{{ old('bathrooms_min', $propertyRequest->bathrooms_min) }}"
            >
        </div>

        <div class="field">
            <label for="land_size_min">
                Minimum Land Size (sqm)
            </label>

            <input
                type="number"
                step="0.01"
                min="0"
                id="land_size_min"
                name="land_size_min"
                value="{{ old('land_size_min', $propertyRequest->land_size_min) }}"
            >
        </div>

        <div class="field">
            <label for="land_size_max">
                Maximum Land Size (sqm)
            </label>

            <input
                type="number"
                step="0.01"
                min="0"
                id="land_size_max"
                name="land_size_max"
                value="{{ old('land_size_max', $propertyRequest->land_size_max) }}"
            >
        </div>

    </div>


    {{-- =========================================================
         ADDITIONAL INFORMATION
    ========================================================== --}}
    <div class="section-header">
        <div class="section-number">06</div>
        <div>
            <h3>Additional Information</h3>
            <p>Extra information provided by the requester.</p>
        </div>
    </div>

    <div class="grid-2">

        <div class="field">
            <label for="urgency">
                Urgency <span>*</span>
            </label>

            <select
                id="urgency"
                name="urgency"
                required
            >
                @foreach (\App\Models\PropertyRequest::URGENCIES as $key => $label)
                    <option
                        value="{{ $key }}"
                        @selected(old('urgency', $propertyRequest->urgency) === $key)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="how_did_you_hear">
                How Did You Hear About Us?
            </label>

            <input
                type="text"
                id="how_did_you_hear"
                name="how_did_you_hear"
                value="{{ old('how_did_you_hear', $propertyRequest->how_did_you_hear) }}"
            >
        </div>

        <div class="field full">
            <label for="additional_notes">
                Additional Notes
            </label>

            <textarea
                id="additional_notes"
                name="additional_notes"
            >{{ old('additional_notes', $propertyRequest->additional_notes) }}</textarea>
        </div>

        <div class="field checkbox-field">
            <label>
                <input
                    type="checkbox"
                    name="newsletter_opt_in"
                    value="1"
                    @checked(old(
                        'newsletter_opt_in',
                        $propertyRequest->newsletter_opt_in
                    ))
                >

                <span>Newsletter opt-in</span>
            </label>
        </div>

    </div>


    {{-- =========================================================
         INTERNAL ADMIN
    ========================================================== --}}
    <div class="admin-section">

        <div class="section-header">
            <div class="section-number admin-number">07</div>

            <div>
                <h3>Internal Admin</h3>
                <p>Internal information used by Terra administrators.</p>
            </div>
        </div>

        <div class="grid-2">

            <div class="field">
                <label for="status">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                >
                    @foreach (\App\Models\PropertyRequest::STATUSES as $key => $label)
                        <option
                            value="{{ $key }}"
                            @selected(old(
                                'status',
                                $propertyRequest->status ?? 'new'
                            ) === $key)
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
                    value="{{ old(
                        'assigned_agent',
                        $propertyRequest->assigned_agent
                    ) }}"
                >
            </div>

            <div class="field full">
                <label for="admin_notes">
                    Admin Notes
                </label>

                <textarea
                    id="admin_notes"
                    name="admin_notes"
                >{{ old('admin_notes', $propertyRequest->admin_notes) }}</textarea>
            </div>

            <div class="field checkbox-field">
                <label>
                    <input
                        type="checkbox"
                        name="is_public"
                        value="1"
                        @checked(old(
                            'is_public',
                            $propertyRequest->is_public
                        ))
                    >

                    <span>Make this request public</span>
                </label>
            </div>

        </div>

    </div>


    {{-- =========================================================
         ACTIONS
    ========================================================== --}}
    <div class="form-actions">

        <a
            href="{{ route('admin.property-requests.show', $propertyRequest) }}"
            class="btn btn-secondary"
        >
            Cancel
        </a>

        <button
            type="submit"
            class="btn btn-gold"
        >
            Save Changes
        </button>

    </div>

</form>


<script>
    const provinceDistricts = @json($provinceDistricts);

    const provinceSelect = document.getElementById('province-select');
    const districtSelect = document.getElementById('district-select');

    const currentDistrict =
        @json(old('preferred_district', $propertyRequest->preferred_district));

    function populateDistricts(province, selected = '') {

        districtSelect.innerHTML =
            '<option value="">Any District</option>';

        if (!province || !provinceDistricts[province]) {
            return;
        }

        provinceDistricts[province].forEach(function (district) {

            const option = document.createElement('option');

            option.value = district;
            option.textContent = district;

            if (district === selected) {
                option.selected = true;
            }

            districtSelect.appendChild(option);
        });
    }

    provinceSelect.addEventListener('change', function () {
        populateDistricts(this.value);
    });

    // Populate districts when editing an existing request
    if (provinceSelect.value) {
        populateDistricts(
            provinceSelect.value,
            currentDistrict
        );
    }
</script>


<style>

    :root {
        --navy: #19265d;
        --navy-dark: #111a45;
        --gold: #D05208;
        --gold-dark: #a94105;
        --border: #e5e7eb;
        --muted: #6b7280;
        --background: #f7f7f8;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .page-eyebrow {
        display: block;
        margin-bottom: .25rem;
        color: var(--gold);
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .12em;
        font-family: 'DM Sans', sans-serif;
    }

    .page-header h1 {
        margin: 0;
        color: var(--navy-dark);
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.25rem;
        line-height: 1.1;
    }

    .reference {
        margin: .45rem 0 0;
        color: var(--muted);
        font-size: .88rem;
        font-family: 'DM Sans', sans-serif;
    }

    .reference strong {
        color: var(--navy);
    }

    .btn-link {
        color: var(--gold);
        font-weight: 600;
        text-decoration: none;
        font-family: 'DM Sans', sans-serif;
        white-space: nowrap;
        margin-top: .5rem;
    }

    .btn-link:hover {
        color: var(--gold-dark);
    }

    .alert-error {
        background: #fff1f2;
        color: #b91c1c;
        border: 1px solid #fecdd3;
        padding: 1rem 1.15rem;
        border-radius: 8px;
        margin-bottom: 1.25rem;
        font-family: 'DM Sans', sans-serif;
    }

    .alert-error ul {
        margin: .5rem 0 0;
        padding-left: 1.2rem;
    }

    .form-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
        font-family: 'DM Sans', sans-serif;
    }

    .section-header {
        display: flex;
        align-items: flex-start;
        gap: .85rem;
        padding-bottom: .9rem;
        margin-bottom: 1.2rem;
        border-bottom: 1px solid var(--border);
    }

    .section-header:not(:first-child) {
        margin-top: 2.25rem;
    }

    .section-number {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 34px;
        height: 34px;
        border-radius: 8px;
        background: rgba(208, 82, 8, .10);
        color: var(--gold);
        font-size: .75rem;
        font-weight: 800;
    }

    .section-header h3 {
        margin: 0;
        color: var(--navy-dark);
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.45rem;
        line-height: 1.1;
    }

    .section-header p {
        margin: .25rem 0 0;
        color: var(--muted);
        font-size: .8rem;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem 1.5rem;
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: .4rem;
    }

    .field.full {
        grid-column: 1 / -1;
    }

    .field label {
        color: #374151;
        font-size: .83rem;
        font-weight: 600;
    }

    .field label span {
        color: var(--gold);
    }

    .field input[type=text],
    .field input[type=email],
    .field input[type=number],
    .field select,
    .field textarea {
        width: 100%;
        box-sizing: border-box;
        padding: .7rem .8rem;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        background: #fff;
        color: #111827;
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        transition: border-color .15s, box-shadow .15s;
    }

    .field input:focus,
    .field select:focus,
    .field textarea:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(208, 82, 8, .10);
    }

    .field textarea {
        min-height: 95px;
        resize: vertical;
    }

    .checkbox-field {
        justify-content: flex-end;
    }

    .checkbox-field label {
        display: flex;
        align-items: center;
        gap: .65rem;
        min-height: 42px;
        cursor: pointer;
    }

    .checkbox-field input {
        width: 17px;
        height: 17px;
        accent-color: var(--gold);
    }

    .admin-section {
        margin-top: 2.5rem;
        padding: 1.35rem;
        border: 1px solid #eadfd8;
        border-radius: 10px;
        background: #fffaf7;
    }

    .admin-section .section-header {
        margin-top: 0;
    }

    .admin-number {
        background: rgba(25, 38, 93, .08);
        color: var(--navy);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: .75rem;
        margin-top: 2rem;
        padding-top: 1.25rem;
        border-top: 1px solid var(--border);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .72rem 1.4rem;
        border-radius: 7px;
        border: none;
        font-family: 'DM Sans', sans-serif;
        font-size: .88rem;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all .15s ease;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #e5e7eb;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    .btn-gold {
        background: var(--gold);
        color: #fff;
    }

    .btn-gold:hover {
        background: var(--gold-dark);
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {

        .page-header {
            flex-direction: column;
        }

        .form-card {
            padding: 1.25rem;
        }

        .grid-2 {
            grid-template-columns: 1fr;
        }

        .field.full {
            grid-column: auto;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn {
            width: 100%;
        }
    }

</style>

@endsection