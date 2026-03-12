@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="bi bi-shield-lock me-2 text-warning"></i>
                Permission Assignment
            </h4>
            <small class="text-muted">
                Assigning permissions for
                <strong>{{ $staff->user->name }}</strong>
                &mdash; {{ $staff->employee_id }}
            </small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('staff.show', $staff) }}"
               class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
                <i class="bi bi-person"></i> View Profile
            </a>
            <a href="{{ route('staff.index') }}"
               class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i> Back to Staff
            </a>
        </div>
    </div>

    <form action="{{ route('staff.permissions.save', $staff) }}" method="POST" id="permissionForm">
        @csrf

        <div class="row g-4">

            {{-- LEFT — Role + Summary --}}
            <div class="col-lg-4">

                {{-- Staff Mini Profile --}}
                <div class="card mb-4">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center fw-bold text-white rounded-circle"
                                 style="width:48px;height:48px;background:#378ADD;font-size:16px;flex-shrink:0">
                                {{ strtoupper(substr($staff->user->name,0,1)) }}{{ strtoupper(substr(strstr($staff->user->name,' '),1,1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $staff->user->name }}</div>
                                <small class="text-muted">{{ $staff->position }} &mdash; {{ $staff->department?->name }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Step 1 — Role Selector --}}
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-circle"
                                  style="width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;font-size:11px">1</span>
                            Select Role
                        </h6>
                        <small class="text-muted">Role sets the base permissions</small>
                    </div>
                    <div class="card-body">

                        @php $currentRole = $staff->user->roles->first()?->name @endphp

                        @error('role')
                            <div class="alert alert-danger py-2 small mb-3">{{ $message }}</div>
                        @enderror

                        @foreach($roles as $role)
                            <div class="form-check border rounded p-3 mb-2 role-option
                                {{ old('role', $currentRole) === $role->name ? 'border-primary bg-primary bg-opacity-10' : '' }}"
                                 id="role_card_{{ $role->name }}">
                                <input class="form-check-input"
                                       type="radio"
                                       name="role"
                                       id="role_{{ $role->name }}"
                                       value="{{ $role->name }}"
                                       data-perms="{{ json_encode($rolePermissionMap[$role->name] ?? []) }}"
                                       data-original="{{ $currentRole }}"
                                       {{ old('role', $currentRole) === $role->name ? 'checked' : '' }}>
                                <label class="form-check-label w-100" for="role_{{ $role->name }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-semibold text-capitalize">{{ $role->name }}</span>
                                        <span class="badge"
                                              style="{{ $role->name === 'admin' ? 'background:#EEEDFE;color:#3C3489' : 'background:#E6F1FB;color:#0C447C' }};font-size:10px">
                                            {{ $role->permissions->count() }} perms
                                        </span>
                                    </div>
                                    <small class="text-muted">
                                        {{ $role->name === 'admin' ? 'Full system access' : 'Standard operational access' }}
                                    </small>
                                </label>
                            </div>
                        @endforeach

                        <div class="alert alert-warning py-2 small mt-2 d-none" id="roleChangeAlert">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Role changed. Direct overrides will be cleared on save.
                        </div>
                    </div>
                </div>

                {{-- Live Counter --}}
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-circle"
                                  style="width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;font-size:11px">2</span>
                            Permission Summary
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 text-center">
                            <div class="col-6">
                                <div class="p-2 rounded" style="background:var(--bs-success-bg-subtle,#EAF3DE)">
                                    <div class="fw-bold" style="color:#27500A;font-size:18px" id="countViaRole">
                                        {{ count($effective['via_role']) }}
                                    </div>
                                    <small style="color:#3B6D11">Via role</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 rounded" style="background:#FAEEDA">
                                    <div class="fw-bold" style="color:#633806;font-size:18px" id="countDirect">
                                        {{ count($effective['direct']) }}
                                    </div>
                                    <small style="color:#854F0B">Direct grants</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-2 rounded" style="background:var(--bs-info-bg-subtle,#E6F1FB)">
                                    <div class="fw-bold" style="color:#0C447C;font-size:18px" id="countTotal">
                                        {{ count($effective['all']) }}
                                    </div>
                                    <small style="color:#185FA5">Total effective permissions</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Reset Button --}}
                @can('staff.manage')
                <div class="card border-danger-subtle">
                    <div class="card-body py-3">
                        <p class="small text-muted mb-2">
                            Clear all direct overrides and fall back to role defaults only.
                        </p>
                        <form action="{{ route('staff.permissions.reset', $staff) }}"
                              method="POST"
                              onsubmit="return confirm('Reset all direct permissions to role defaults?')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                Reset to Role Defaults
                            </button>
                        </form>
                    </div>
                </div>
                @endcan

            </div>

            {{-- RIGHT — Permission Checkboxes --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-circle"
                                  style="width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;font-size:11px">3</span>
                            Additional Direct Permissions
                        </h6>
                        <div class="d-flex gap-2">
                            {{-- Legend --}}
                            <span class="badge d-flex align-items-center gap-1"
                                  style="background:#EAF3DE;color:#27500A;font-size:10px;font-weight:400">
                                <i class="bi bi-circle-fill" style="font-size:6px"></i> Via role
                            </span>
                            <span class="badge d-flex align-items-center gap-1"
                                  style="background:#FAEEDA;color:#633806;font-size:10px;font-weight:400">
                                <i class="bi bi-circle-fill" style="font-size:6px"></i> Direct grant
                            </span>
                        </div>
                    </div>

                    {{-- Select All / None toolbar --}}
                    <div class="px-3 py-2 border-bottom d-flex align-items-center gap-3"
                         style="background:var(--bs-light,#f8f9fa)">
                        <small class="text-muted">Quick select:</small>
                        <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2"
                                onclick="toggleAllDirect(true)">
                            Check all direct
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2"
                                onclick="toggleAllDirect(false)">
                            Uncheck all direct
                        </button>
                    </div>

                    <div class="card-body">
                        <p class="text-muted small mb-4">
                            Permissions already included in the selected role are shown with a
                            <span class="badge" style="background:#EAF3DE;color:#27500A;font-size:10px">via role</span>
                            badge and cannot be unchecked — they are inherited automatically.
                            Check additional permissions below to grant them directly on top of the role.
                        </p>

                        @foreach($permissions as $module => $perms)
                        <div class="mb-4 module-block" data-module="{{ $module }}">

                            {{-- Module header with select all for module --}}
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="text-uppercase fw-bold"
                                      style="font-size:11px;color:var(--bs-secondary-color);letter-spacing:.5px">
                                    {{ $module }}
                                </span>
                                <div class="flex-grow-1 border-bottom"></div>
                                <button type="button"
                                        class="btn btn-sm btn-outline-secondary py-0 px-2"
                                        style="font-size:10px"
                                        onclick="toggleModule('{{ $module }}', true)">
                                    All
                                </button>
                                <button type="button"
                                        class="btn btn-sm btn-outline-secondary py-0 px-2"
                                        style="font-size:10px"
                                        onclick="toggleModule('{{ $module }}', false)">
                                    None
                                </button>
                            </div>

                            {{-- Permission checkboxes --}}
                            <div class="row g-2">
                                @foreach($perms as $perm)
                                    @php
                                        $isViaRole = in_array($perm['name'], $effective['via_role']);
                                        $isDirect  = in_array($perm['name'], $effective['direct']);
                                    @endphp
                                    <div class="col-md-4 col-6">
                                        <label class="d-flex align-items-center gap-2 p-2 rounded border perm-item
                                            {{ $isViaRole ? 'border-success-subtle' : ($isDirect ? 'border-warning-subtle' : '') }}"
                                               style="cursor:{{ $isViaRole ? 'default' : 'pointer' }};
                                                      {{ $isViaRole ? 'background:#EAF3DE' : ($isDirect ? 'background:#FAEEDA' : 'background:var(--bs-body-bg)') }}"
                                               data-module="{{ $module }}"
                                               for="perm_{{ str_replace('.', '_', $perm['name']) }}">

                                            <input type="checkbox"
                                                   class="form-check-input mt-0 direct-perm-checkbox"
                                                   id="perm_{{ str_replace('.', '_', $perm['name']) }}"
                                                   name="permissions[]"
                                                   value="{{ $perm['name'] }}"
                                                   data-module="{{ $module }}"
                                                   {{ $isDirect  ? 'checked' : '' }}
                                                   {{ $isViaRole ? 'disabled checked' : '' }}
                                                   onchange="updateCounters()">

                                            <div class="flex-grow-1" style="min-width:0">
                                                <div class="small fw-semibold text-truncate">
                                                    {{ $perm['action'] }}
                                                </div>
                                                @if($isViaRole)
                                                    <div style="font-size:9px;color:#3B6D11">via role</div>
                                                @elseif($isDirect)
                                                    <div style="font-size:9px;color:#854F0B">direct grant</div>
                                                @else
                                                    <div style="font-size:9px;color:var(--bs-secondary-color)">not assigned</div>
                                                @endif
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Save Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-3 mb-5">
                    <a href="{{ route('staff.show', $staff) }}"
                       class="btn btn-outline-secondary px-4">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary px-5 d-flex align-items-center gap-2">
                        <i class="bi bi-shield-check"></i>
                        Save Permissions
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
const rolePermissionMap  = @json($rolePermissionMap);
const originalRole       = "{{ $staff->user->roles->first()?->name }}";
const directPermissions  = @json($effective['direct']);

function highlightRoleCard(roleName) {
    document.querySelectorAll('.role-option').forEach(card => {
        card.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
    });
    const card = document.getElementById('role_card_' + roleName);
    if (card) card.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
}

function applyRolePermissions(roleName) {
    const rolePerms = rolePermissionMap[roleName] || [];

    document.querySelectorAll('.perm-item').forEach(label => {
        const checkbox = label.querySelector('input[type=checkbox]');
        const permName = checkbox.value;
        const subLabel = label.querySelector('div:last-child');

        if (rolePerms.includes(permName)) {
            checkbox.checked  = true;
            checkbox.disabled = true;
            label.style.background = '#EAF3DE';
            label.style.borderColor = '';
            label.classList.add('border-success-subtle');
            label.classList.remove('border-warning-subtle');
            if (subLabel) { subLabel.textContent = 'via role'; subLabel.style.color = '#3B6D11'; }
        } else {
            checkbox.disabled = false;
            const wasDirect = directPermissions.includes(permName);
            if (!wasDirect) checkbox.checked = false;
            label.style.background = wasDirect ? '#FAEEDA' : '';
            label.classList.toggle('border-warning-subtle', wasDirect);
            label.classList.remove('border-success-subtle');
            if (subLabel) {
                subLabel.textContent = wasDirect ? 'direct grant' : 'not assigned';
                subLabel.style.color = wasDirect ? '#854F0B' : '';
            }
        }
    });

    updateCounters();
}

function updateCounters() {
    const allChecked     = document.querySelectorAll('.perm-item input:checked');
    const viaRoleChecked = document.querySelectorAll('.perm-item input:checked:disabled');
    const directChecked  = document.querySelectorAll('.perm-item input:checked:not(:disabled)');

    document.getElementById('countTotal').textContent   = allChecked.length;
    document.getElementById('countViaRole').textContent = viaRoleChecked.length;
    document.getElementById('countDirect').textContent  = directChecked.length;
}

function toggleAllDirect(state) {
    document.querySelectorAll('.direct-perm-checkbox:not(:disabled)').forEach(cb => {
        cb.checked = state;
        const label  = cb.closest('.perm-item');
        const sub    = label.querySelector('div:last-child');
        label.style.background = state ? '#FAEEDA' : '';
        label.classList.toggle('border-warning-subtle', state);
        if (sub) { sub.textContent = state ? 'direct grant' : 'not assigned'; sub.style.color = state ? '#854F0B' : ''; }
    });
    updateCounters();
}

function toggleModule(module, state) {
    document.querySelectorAll(`.direct-perm-checkbox[data-module="${module}"]:not(:disabled)`).forEach(cb => {
        cb.checked = state;
        const label = cb.closest('.perm-item');
        const sub   = label.querySelector('div:last-child');
        label.style.background = state ? '#FAEEDA' : '';
        label.classList.toggle('border-warning-subtle', state);
        if (sub) { sub.textContent = state ? 'direct grant' : 'not assigned'; sub.style.color = state ? '#854F0B' : ''; }
    });
    updateCounters();
}

// Wire up role radio buttons
document.querySelectorAll('input[name="role"]').forEach(radio => {
    radio.addEventListener('change', function () {
        highlightRoleCard(this.value);
        applyRolePermissions(this.value);
        const alert = document.getElementById('roleChangeAlert');
        alert.classList.toggle('d-none', this.value === originalRole);
    });
});

// Init counters on load
updateCounters();
</script>
@endsection