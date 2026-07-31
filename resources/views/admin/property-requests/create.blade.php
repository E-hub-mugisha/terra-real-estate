@extends('layouts.app')

@section('title', 'New Property Request')

@section('content')
<div class="page-header">
    <h1>New Property Request</h1>
    <a href="{{ route('admin.property-requests.index') }}" class="btn-link">← Back to list</a>
</div>

@if ($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.property-requests.store') }}" class="form-card">
    @csrf

    <h3>Contact Info</h3>
    <div class="grid-2">
        <div class="field">
            <label>Full Name</label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" required>
        </div>
        <div class="field">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="field">
            <label>Phone (07XXXXXXXX)</label>
            <input type="text" name="phone" value="{{ old('phone') }}" required>
        </div>
        <div class="field">
            <label>Nationality</label>
            <input type="text" name="nationality" value="{{ old('nationality') }}">
        </div>
        <div class="field">
            <label>Preferred Contact Method</label>
            <select name="preferred_contact" required>
                @foreach (\App\Models\PropertyRequest::CONTACT_METHODS as $key => $label)
                    <option value="{{ $key }}" @selected(old('preferred_contact') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <h3>Request Details</h3>
    <div class="grid-2">
        <div class="field">
            <label>Request Type</label>
            <select name="request_type" required>
                @foreach (\App\Models\PropertyRequest::REQUEST_TYPES as $key => $label)
                    <option value="{{ $key }}" @selected(old('request_type') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label>Property Type</label>
            <select name="property_type" required>
                @foreach (\App\Models\PropertyRequest::PROPERTY_TYPES as $key => $label)
                    <option value="{{ $key }}" @selected(old('property_type') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label>Property Status</label>
            <select name="property_status" required>
                @foreach (\App\Models\PropertyRequest::PROPERTY_STATUSES as $key => $label)
                    <option value="{{ $key }}" @selected(old('property_status') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <h3>Location Preference</h3>
    <div class="grid-2">
        <div class="field">
            <label>Province</label>
            <select name="preferred_province" id="province-select">
                <option value="">Any</option>
                @foreach ($provinceDistricts as $province => $districts)
                    <option value="{{ $province }}" @selected(old('preferred_province') === $province)>{{ $province }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label>District</label>
            <select name="preferred_district" id="district-select">
                <option value="">Any</option>
            </select>
        </div>
        <div class="field">
            <label>Sector</label>
            <input type="text" name="preferred_sector" value="{{ old('preferred_sector') }}">
        </div>
        <div class="field full">
            <label>Location Notes</label>
            <textarea name="location_notes">{{ old('location_notes') }}</textarea>
        </div>
    </div>

    <h3>Budget & Timeline</h3>
    <div class="grid-2">
        <div class="field">
            <label>Currency</label>
            <select name="currency" required>
                @foreach (\App\Models\PropertyRequest::CURRENCIES as $key => $label)
                    <option value="{{ $key }}" @selected(old('currency') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label>Timeline</label>
            <select name="timeline" required>
                @foreach (\App\Models\PropertyRequest::TIMELINES as $key => $label)
                    <option value="{{ $key }}" @selected(old('timeline') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label>Min Budget</label>
            <input type="number" step="0.01" name="budget_min" value="{{ old('budget_min') }}">
        </div>
        <div class="field">
            <label>Max Budget</label>
            <input type="number" step="0.01" name="budget_max" value="{{ old('budget_max') }}">
        </div>
        <div class="field">
            <label><input type="checkbox" name="financing_needed" value="1" @checked(old('financing_needed'))> Needs Financing</label>
        </div>
    </div>

    <h3>Property Requirements</h3>
    <div class="grid-2">
        <div class="field">
            <label>Min Bedrooms</label>
            <input type="number" name="bedrooms_min" value="{{ old('bedrooms_min') }}">
        </div>
        <div class="field">
            <label>Min Bathrooms</label>
            <input type="number" name="bathrooms_min" value="{{ old('bathrooms_min') }}">
        </div>
        <div class="field">
            <label>Min Land Size (sqm)</label>
            <input type="number" step="0.01" name="land_size_min" value="{{ old('land_size_min') }}">
        </div>
        <div class="field">
            <label>Max Land Size (sqm)</label>
            <input type="number" step="0.01" name="land_size_max" value="{{ old('land_size_max') }}">
        </div>
    </div>

    <h3>Additional Info</h3>
    <div class="grid-2">
        <div class="field">
            <label>Urgency</label>
            <select name="urgency" required>
                @foreach (\App\Models\PropertyRequest::URGENCIES as $key => $label)
                    <option value="{{ $key }}" @selected(old('urgency') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label>How Did You Hear About Us</label>
            <input type="text" name="how_did_you_hear" value="{{ old('how_did_you_hear') }}">
        </div>
        <div class="field full">
            <label>Additional Notes</label>
            <textarea name="additional_notes">{{ old('additional_notes') }}</textarea>
        </div>
        <div class="field">
            <label><input type="checkbox" name="newsletter_opt_in" value="1" @checked(old('newsletter_opt_in'))> Newsletter Opt-in</label>
        </div>
    </div>

    <h3>Internal (Admin)</h3>
    <div class="grid-2">
        <div class="field">
            <label>Status</label>
            <select name="status">
                @foreach (\App\Models\PropertyRequest::STATUSES as $key => $label)
                    <option value="{{ $key }}" @selected(old('status', 'new') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label>Assigned Agent</label>
            <input type="text" name="assigned_agent" value="{{ old('assigned_agent') }}">
        </div>
        <div class="field full">
            <label>Admin Notes</label>
            <textarea name="admin_notes">{{ old('admin_notes') }}</textarea>
        </div>
        <div class="field">
            <label><input type="checkbox" name="is_public" value="1" @checked(old('is_public'))> Make Public</label>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-gold">Create Request</button>
    </div>
</form>

<script>
    const provinceDistricts = @json($provinceDistricts);
    const provinceSelect = document.getElementById('province-select');
    const districtSelect = document.getElementById('district-select');

    function populateDistricts(province, selected = '') {
        districtSelect.innerHTML = '<option value="">Any</option>';
        (provinceDistricts[province] || []).forEach(d => {
            const opt = document.createElement('option');
            opt.value = d;
            opt.textContent = d;
            if (d === selected) opt.selected = true;
            districtSelect.appendChild(opt);
        });
    }

    provinceSelect.addEventListener('change', () => populateDistricts(provinceSelect.value));

    if (provinceSelect.value) {
        populateDistricts(provinceSelect.value, "{{ old('preferred_district') }}");
    }
</script>

<style>
    :root { --navy: #19265d; --navy-dark: #111a45; --gold: #D05208; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .page-header h1 { font-family: 'Cormorant Garamond', serif; color: var(--navy-dark); font-size: 2rem; margin: 0; }
    .btn-link { color: var(--gold); font-weight: 600; text-decoration: none; font-family: 'DM Sans', sans-serif; }
    .alert-error { background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 6px; margin-bottom: 1rem; font-family: 'DM Sans', sans-serif; }
    .form-card { background: #fff; border-radius: 8px; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,.08); font-family: 'DM Sans', sans-serif; }
    .form-card h3 { font-family: 'Cormorant Garamond', serif; color: var(--navy-dark); border-bottom: 1px solid #e5e7eb; padding-bottom: .5rem; margin: 2rem 0 1rem; }
    .form-card h3:first-of-type { margin-top: 0; }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem 1.5rem; }
    .field { display: flex; flex-direction: column; gap: .35rem; }
    .field.full { grid-column: 1 / -1; }
    .field label { font-size: .85rem; color: #374151; font-weight: 600; }
    .field input[type=text], .field input[type=email], .field input[type=number],
    .field select, .field textarea {
        padding: .6rem .75rem; border: 1px solid #d1d5db; border-radius: 6px; font-family: 'DM Sans', sans-serif;
    }
    .field textarea { min-height: 80px; resize: vertical; }
    .form-actions { margin-top: 2rem; text-align: right; }
    .btn { padding: .7rem 1.5rem; border-radius: 6px; border: none; font-weight: 600; cursor: pointer; }
    .btn-gold { background: var(--gold); color: #fff; }
</style>
@endsection