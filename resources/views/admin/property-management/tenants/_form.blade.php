@if ($errors->any())
    <div class="alert alert-danger">
        <div class="fw-semibold mb-1">Please correct the following errors:</div>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h2 class="h5 fw-bold mb-3">Personal Information</h2>

        @if ($tenant->exists)
            <div class="alert alert-light border">
                <span class="text-muted">Tenant reference:</span>
                <strong>{{ $tenant->tenant_code }}</strong>
            </div>
        @else
            <p class="small text-muted">
                A tenant reference will be generated automatically after registration.
            </p>
        @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label for="first_name" class="form-label">
                    First Name <span class="text-danger">*</span>
                </label>
                <input type="text" name="first_name" id="first_name"
                       class="form-control @error('first_name') is-invalid @enderror"
                       value="{{ old('first_name', $tenant->first_name) }}" required>
                @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="last_name" class="form-label">
                    Last Name <span class="text-danger">*</span>
                </label>
                <input type="text" name="last_name" id="last_name"
                       class="form-control @error('last_name') is-invalid @enderror"
                       value="{{ old('last_name', $tenant->last_name) }}" required>
                @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">
                    Email Address <span class="text-danger">*</span>
                </label>
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $tenant->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="phone" class="form-label">
                    Phone Number <span class="text-danger">*</span>
                </label>
                <input type="text" name="phone" id="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $tenant->phone) }}" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="alternate_phone" class="form-label">Alternate Phone</label>
                <input type="text" name="alternate_phone" id="alternate_phone"
                       class="form-control @error('alternate_phone') is-invalid @enderror"
                       value="{{ old('alternate_phone', $tenant->alternate_phone) }}">
                @error('alternate_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="national_id" class="form-label">National ID</label>
                <input type="text" name="national_id" id="national_id"
                       class="form-control @error('national_id') is-invalid @enderror"
                       value="{{ old('national_id', $tenant->national_id) }}">
                @error('national_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth"
                       class="form-control @error('date_of_birth') is-invalid @enderror"
                       value="{{ old('date_of_birth', $tenant->date_of_birth?->format('Y-m-d')) }}">
                @error('date_of_birth')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender"
                        class="form-select @error('gender') is-invalid @enderror">
                    <option value="">Select gender</option>
                    @foreach ([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                        'prefer_not_to_say' => 'Prefer not to say',
                    ] as $value => $label)
                        <option value="{{ $value }}"
                            @selected(old('gender', $tenant->gender) === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="status" class="form-label">
                    Status <span class="text-danger">*</span>
                </label>
                <select name="status" id="status"
                        class="form-select @error('status') is-invalid @enderror" required>
                    <option value="active"
                        @selected(old('status', $tenant->status ?? 'active') === 'active')>
                        Active
                    </option>
                    <option value="inactive"
                        @selected(old('status', $tenant->status ?? 'active') === 'inactive')>
                        Inactive
                    </option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <hr class="my-4">

        <h2 class="h5 fw-bold mb-3">Employment Information</h2>

        <div class="row g-3">
            <div class="col-md-6">
                <label for="occupation" class="form-label">Occupation</label>
                <input type="text" name="occupation" id="occupation"
                       class="form-control @error('occupation') is-invalid @enderror"
                       value="{{ old('occupation', $tenant->occupation) }}">
                @error('occupation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="employer" class="form-label">Employer</label>
                <input type="text" name="employer" id="employer"
                       class="form-control @error('employer') is-invalid @enderror"
                       value="{{ old('employer', $tenant->employer) }}">
                @error('employer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <hr class="my-4">

        <h2 class="h5 fw-bold mb-3">Emergency Contact</h2>

        <div class="row g-3">
            <div class="col-md-6">
                <label for="emergency_contact_name" class="form-label">Contact Name</label>
                <input type="text" name="emergency_contact_name"
                       id="emergency_contact_name"
                       class="form-control @error('emergency_contact_name') is-invalid @enderror"
                       value="{{ old('emergency_contact_name', $tenant->emergency_contact_name) }}">
                @error('emergency_contact_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="emergency_contact_phone" class="form-label">Contact Phone</label>
                <input type="text" name="emergency_contact_phone"
                       id="emergency_contact_phone"
                       class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                       value="{{ old('emergency_contact_phone', $tenant->emergency_contact_phone) }}">
                @error('emergency_contact_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="address" class="form-label">Residential Address</label>
                <textarea name="address" id="address" rows="3"
                          class="form-control @error('address') is-invalid @enderror">{{ old('address', $tenant->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <hr class="my-4">

        <h2 class="h5 fw-bold mb-2">Terra User Account</h2>
        <p class="small text-muted">
            Optionally link this tenant profile to an existing user. This does not create or change login credentials.
        </p>

        <div class="mb-3">
            <label for="user_id" class="form-label">Existing User</label>
            <select name="user_id" id="user_id"
                    class="form-select @error('user_id') is-invalid @enderror">
                <option value="">No account linked</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}"
                        @selected((string) old('user_id', $tenant->user_id) === (string) $user->id)>
                        {{ $user->name }} — {{ $user->email }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Internal Notes</label>
            <textarea name="notes" id="notes" rows="4"
                      class="form-control @error('notes') is-invalid @enderror"
                      placeholder="Optional notes for property management staff">{{ old('notes', $tenant->notes) }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="card-footer bg-white p-3 d-flex justify-content-between">
        <a href="{{ route('admin.property-management.tenants.index') }}"
           class="btn btn-outline-secondary">Cancel</a>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1"></i>
            {{ $tenant->exists ? 'Save Changes' : 'Register Tenant' }}
        </button>
    </div>
</div>