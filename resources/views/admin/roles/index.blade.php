@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Roles & Permissions</h4>
            <small class="text-muted">Create roles, define permissions and control system access</small>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1"
                    data-bs-toggle="modal" data-bs-target="#createPermissionModal">
                <i class="bi bi-key"></i> New Permission
            </button>
            <button class="btn btn-primary btn-sm d-flex align-items-center gap-1"
                    data-bs-toggle="modal" data-bs-target="#createRoleModal">
                <i class="bi bi-shield-plus"></i> New Role
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card text-center py-3">
                <div class="card-body p-1">
                    <div class="fw-bold text-primary" style="font-size:26px">{{ $stats['roles'] }}</div>
                    <small class="text-muted">Total Roles</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center py-3">
                <div class="card-body p-1">
                    <div class="fw-bold text-success" style="font-size:26px">{{ $stats['permissions'] }}</div>
                    <small class="text-muted">Total Permissions</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center py-3">
                <div class="card-body p-1">
                    <div class="fw-bold text-warning" style="font-size:26px">{{ $stats['modules'] }}</div>
                    <small class="text-muted">Modules</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center py-3">
                <div class="card-body p-1">
                    <div class="fw-bold text-info" style="font-size:26px">{{ $stats['assigned'] }}</div>
                    <small class="text-muted">Users with Roles</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- LEFT — Roles --}}
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-shield me-2 text-primary"></i>Roles
                    </h6>
                    <button class="btn btn-sm btn-outline-primary"
                            data-bs-toggle="modal" data-bs-target="#createRoleModal">
                        <i class="bi bi-plus-lg"></i> Add
                    </button>
                </div>
                <div class="card-body p-0">
                    @foreach($roles as $role)
                    <div class="p-3 border-bottom role-row">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white"
                                     style="width:36px;height:36px;font-size:13px;
                                     background:{{ $role->name === 'admin' ? '#534AB7' : '#378ADD' }}">
                                    {{ strtoupper(substr($role->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold text-capitalize">{{ $role->name }}</div>
                                    <small class="text-muted">
                                        {{ $role->permissions_count }} permissions
                                        &middot; {{ $role->users_count }} users
                                    </small>
                                </div>
                            </div>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary py-0 px-2"
                                        onclick="openEditRoleModal(
                                            {{ $role->id }},
                                            '{{ $role->name }}',
                                            {{ $role->permissions->pluck('name')->toJson() }}
                                        )">
                                    <i class="bi bi-pencil" style="font-size:11px"></i>
                                </button>
                                <form action="{{ route('admin.roles.destroy', $role) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete role \'{{ $role->name }}\'?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger py-0 px-2"
                                            {{ $role->users_count > 0 ? 'disabled title=Users assigned' : '' }}>
                                        <i class="bi bi-trash" style="font-size:11px"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Permission pills for this role --}}
                        <div class="d-flex flex-wrap gap-1 ps-1">
                            @foreach($role->permissions->take(8) as $perm)
                                <span class="badge fw-normal"
                                      style="font-size:10px;background:
                                      {{ $role->name === 'admin' ? '#EEEDFE' : '#E6F1FB' }};
                                      color:{{ $role->name === 'admin' ? '#3C3489' : '#0C447C' }}">
                                    {{ $perm->name }}
                                </span>
                            @endforeach
                            @if($role->permissions->count() > 8)
                                <span class="badge bg-secondary-subtle text-secondary fw-normal"
                                      style="font-size:10px">
                                    +{{ $role->permissions->count() - 8 }} more
                                </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RIGHT — Permissions by Module --}}
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-key me-2 text-primary"></i>Permissions by Module
                    </h6>
                    <button class="btn btn-sm btn-outline-primary"
                            data-bs-toggle="modal" data-bs-target="#createPermissionModal">
                        <i class="bi bi-plus-lg"></i> Add
                    </button>
                </div>
                <div class="card-body">
                    @foreach($permissions as $module => $perms)
                    <div class="mb-4">
                        {{-- Module header --}}
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="text-uppercase fw-bold"
                                  style="font-size:11px;color:var(--bs-secondary-color);letter-spacing:.5px">
                                {{ $module }}
                            </span>
                            <div class="flex-grow-1 border-bottom"></div>
                            <span class="badge bg-secondary-subtle text-secondary"
                                  style="font-size:10px">
                                {{ $perms->count() }}
                            </span>
                        </div>

                        {{-- Permission rows --}}
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($perms as $perm)
                            <div class="d-flex align-items-center gap-1 border rounded px-2 py-1"
                                 style="font-size:11px">
                                <i class="bi bi-check2 text-success" style="font-size:11px"></i>
                                <span>{{ explode('.', $perm->name)[1] }}</span>
                                <form action="{{ route('admin.roles.permissions.destroy', $perm) }}"
                                      method="POST" class="d-inline ms-1"
                                      onsubmit="return confirm('Delete permission \'{{ $perm->name }}\'?')">
                                    @csrf @method('DELETE')
                                    <button class="btn p-0 border-0 text-danger"
                                            style="font-size:11px;line-height:1"
                                            title="Delete permission">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     MODAL 1 — CREATE ROLE
════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-shield-plus me-2 text-primary"></i>Create New Role
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    @if($errors->any())
                        <div class="alert alert-danger py-2 small">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Role Name --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Role Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="e.g. manager"
                               oninput="this.value=this.value.toLowerCase().replace(/\s+/g,'_')">
                        <div class="form-text">
                            Lowercase only. Spaces auto-converted to underscores.
                        </div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Assign Permissions --}}
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-semibold mb-0">
                                Assign Permissions
                            </label>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2"
                                        onclick="toggleAllCreate(true)">
                                    Select all
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2"
                                        onclick="toggleAllCreate(false)">
                                    Clear all
                                </button>
                            </div>
                        </div>

                        @foreach($permissions as $module => $perms)
                        <div class="mb-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="text-uppercase fw-bold"
                                      style="font-size:10px;color:var(--bs-secondary-color);letter-spacing:.5px">
                                    {{ $module }}
                                </span>
                                <div class="flex-grow-1 border-bottom"></div>
                                <button type="button"
                                        class="btn btn-link btn-sm p-0 text-decoration-none"
                                        style="font-size:10px"
                                        onclick="toggleModuleCreate('{{ $module }}', true)">
                                    all
                                </button>
                                <span class="text-muted" style="font-size:10px">/</span>
                                <button type="button"
                                        class="btn btn-link btn-sm p-0 text-decoration-none"
                                        style="font-size:10px"
                                        onclick="toggleModuleCreate('{{ $module }}', false)">
                                    none
                                </button>
                            </div>
                            <div class="row g-1">
                                @foreach($perms as $perm)
                                <div class="col-md-3 col-6">
                                    <div class="form-check border rounded px-2 py-2 create-perm-item"
                                         data-module="{{ $module }}">
                                        <input class="form-check-input create-perm-cb"
                                               type="checkbox"
                                               name="permissions[]"
                                               id="create_{{ str_replace('.','_',$perm->name) }}"
                                               value="{{ $perm->name }}"
                                               data-module="{{ $module }}"
                                               {{ in_array($perm->name, old('permissions', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label w-100"
                                               for="create_{{ str_replace('.','_',$perm->name) }}"
                                               style="font-size:11px">
                                            <div class="fw-semibold">{{ explode('.', $perm->name)[1] }}</div>
                                            <div class="text-muted" style="font-size:9px">{{ $perm->name }}</div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>

                <div class="modal-footer border-top">
                    <div class="me-auto">
                        <small class="text-muted">
                            Selected: <strong id="createSelectedCount">0</strong> permissions
                        </small>
                    </div>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                        <i class="bi bi-shield-check"></i> Create Role
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     MODAL 2 — EDIT ROLE
════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-shield-lock me-2 text-primary"></i>Edit Role
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editRoleForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Role Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="editRoleName"
                               name="name"
                               class="form-control"
                               oninput="this.value=this.value.toLowerCase().replace(/\s+/g,'_')"
                               required>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-semibold mb-0">Permissions</label>
                            <div class="d-flex gap-2">
                                <button type="button"
                                        class="btn btn-sm btn-outline-secondary py-0 px-2"
                                        onclick="toggleAllEdit(true)">Select all</button>
                                <button type="button"
                                        class="btn btn-sm btn-outline-secondary py-0 px-2"
                                        onclick="toggleAllEdit(false)">Clear all</button>
                            </div>
                        </div>

                        @foreach($permissions as $module => $perms)
                        <div class="mb-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="text-uppercase fw-bold"
                                      style="font-size:10px;color:var(--bs-secondary-color);letter-spacing:.5px">
                                    {{ $module }}
                                </span>
                                <div class="flex-grow-1 border-bottom"></div>
                                <button type="button"
                                        class="btn btn-link btn-sm p-0 text-decoration-none"
                                        style="font-size:10px"
                                        onclick="toggleModuleEdit('{{ $module }}', true)">all</button>
                                <span class="text-muted" style="font-size:10px">/</span>
                                <button type="button"
                                        class="btn btn-link btn-sm p-0 text-decoration-none"
                                        style="font-size:10px"
                                        onclick="toggleModuleEdit('{{ $module }}', false)">none</button>
                            </div>
                            <div class="row g-1">
                                @foreach($perms as $perm)
                                <div class="col-md-3 col-6">
                                    <div class="form-check border rounded px-2 py-2"
                                         data-module="{{ $module }}">
                                        <input class="form-check-input edit-perm-cb"
                                               type="checkbox"
                                               name="permissions[]"
                                               id="edit_{{ str_replace('.','_',$perm->name) }}"
                                               value="{{ $perm->name }}"
                                               data-module="{{ $module }}">
                                        <label class="form-check-label w-100"
                                               for="edit_{{ str_replace('.','_',$perm->name) }}"
                                               style="font-size:11px">
                                            <div class="fw-semibold">{{ explode('.', $perm->name)[1] }}</div>
                                            <div class="text-muted" style="font-size:9px">{{ $perm->name }}</div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>

                <div class="modal-footer border-top">
                    <div class="me-auto">
                        <small class="text-muted">
                            Selected: <strong id="editSelectedCount">0</strong> permissions
                        </small>
                    </div>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                        <i class="bi bi-check-lg"></i> Save Role
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     MODAL 3 — CREATE PERMISSION
════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="createPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-key me-2 text-primary"></i>Create New Permission
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.roles.permissions.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <p class="text-muted small mb-4">
                        Permissions follow the format
                        <code>module.action</code> (e.g. <code>property.approve</code>).
                        Enter the module and action separately below.
                    </p>

                    {{-- Live preview --}}
                    <div class="alert py-2 text-center mb-4"
                         style="background:#E6F1FB;border:0.5px solid #85B7EB">
                        <small class="text-muted">Permission name preview</small>
                        <div class="fw-bold mt-1" style="font-size:15px;color:#0C447C;letter-spacing:.5px"
                             id="permPreview">
                            module.action
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Module <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-grid" style="font-size:13px"></i>
                                </span>
                                <input type="text"
                                       name="module"
                                       id="permModule"
                                       class="form-control @error('module') is-invalid @enderror"
                                       value="{{ old('module') }}"
                                       placeholder="e.g. property"
                                       list="moduleList"
                                       oninput="updatePermPreview()">
                                {{-- Datalist for existing modules --}}
                                <datalist id="moduleList">
                                    @foreach($modules as $mod)
                                        <option value="{{ $mod }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="form-text">Select existing or type a new module</div>
                            @error('module')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Action <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lightning" style="font-size:13px"></i>
                                </span>
                                <input type="text"
                                       name="action"
                                       id="permAction"
                                       class="form-control @error('action') is-invalid @enderror"
                                       value="{{ old('action') }}"
                                       placeholder="e.g. approve"
                                       list="actionList"
                                       oninput="updatePermPreview()">
                                <datalist id="actionList">
                                    <option value="view">
                                    <option value="create">
                                    <option value="edit">
                                    <option value="delete">
                                    <option value="approve">
                                    <option value="export">
                                    <option value="manage">
                                </datalist>
                            </div>
                            <div class="form-text">Common: view, create, edit, delete, approve</div>
                            @error('action')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                        <i class="bi bi-plus-lg"></i> Create Permission
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


<script>
// ── Permission preview ──────────────────────────────────────────
function updatePermPreview() {
    const mod    = document.getElementById('permModule').value.trim().toLowerCase() || 'module';
    const action = document.getElementById('permAction').value.trim().toLowerCase() || 'action';
    document.getElementById('permPreview').textContent = `${mod}.${action}`;
}

// ── Open Edit Role Modal ────────────────────────────────────────
function openEditRoleModal(id, name, assignedPermissions) {
    document.getElementById('editRoleForm').action = `/admin/roles/roles/${id}`;
    document.getElementById('editRoleName').value  = name;

    // Reset all checkboxes first
    document.querySelectorAll('.edit-perm-cb').forEach(cb => {
        cb.checked = assignedPermissions.includes(cb.value);
        styleEditItem(cb);
    });

    updateEditCount();
    new bootstrap.Modal(document.getElementById('editRoleModal')).show();
}

function styleEditItem(cb) {
    const item = cb.closest('.form-check');
    if (cb.checked) {
        item.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
    } else {
        item.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
    }
}

// ── Count helpers ───────────────────────────────────────────────
function updateCreateCount() {
    const count = document.querySelectorAll('.create-perm-cb:checked').length;
    document.getElementById('createSelectedCount').textContent = count;
}

function updateEditCount() {
    const count = document.querySelectorAll('.edit-perm-cb:checked').length;
    document.getElementById('editSelectedCount').textContent = count;
}

// ── Create modal — toggle helpers ──────────────────────────────
function toggleAllCreate(state) {
    document.querySelectorAll('.create-perm-cb').forEach(cb => {
        cb.checked = state;
        styleCreateItem(cb);
    });
    updateCreateCount();
}

function toggleModuleCreate(module, state) {
    document.querySelectorAll(`.create-perm-cb[data-module="${module}"]`).forEach(cb => {
        cb.checked = state;
        styleCreateItem(cb);
    });
    updateCreateCount();
}

function styleCreateItem(cb) {
    const item = cb.closest('.form-check');
    if (cb.checked) {
        item.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
    } else {
        item.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
    }
}

// ── Edit modal — toggle helpers ─────────────────────────────────
function toggleAllEdit(state) {
    document.querySelectorAll('.edit-perm-cb').forEach(cb => {
        cb.checked = state;
        styleEditItem(cb);
    });
    updateEditCount();
}

function toggleModuleEdit(module, state) {
    document.querySelectorAll(`.edit-perm-cb[data-module="${module}"]`).forEach(cb => {
        cb.checked = state;
        styleEditItem(cb);
    });
    updateEditCount();
}

// ── Wire up live checkbox styling ───────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    // Create modal checkboxes
    document.querySelectorAll('.create-perm-cb').forEach(cb => {
        styleCreateItem(cb);
        cb.addEventListener('change', () => {
            styleCreateItem(cb);
            updateCreateCount();
        });
    });

    // Edit modal checkboxes
    document.querySelectorAll('.edit-perm-cb').forEach(cb => {
        cb.addEventListener('change', () => {
            styleEditItem(cb);
            updateEditCount();
        });
    });

    updateCreateCount();
});
</script>

@endsection