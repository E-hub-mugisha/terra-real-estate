@extends('layouts.app')
@section('title', 'Roles & Permissions')

@section('content')

<style>
    .perm-chip {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 20px;
        font-size: .68rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
    }
    .perm-review  { background: rgba(25,38,93,.08);   color: #19265d; }
    .perm-add     { background: rgba(30,122,90,.08);  color: #1E7A5A; }
    .perm-edit    { background: rgba(20,110,180,.08); color: #1464B4; }
    .perm-update  { background: rgba(100,83,9,.08);   color: #6B5309; }
    .perm-delete  { background: rgba(220,38,38,.08);  color: #DC2626; }
    .perm-approve { background: rgba(124,58,237,.08); color: #7C3AED; }

    .role-card {
        background: #fff;
        border: 1px solid #E8E3DC;
        border-radius: 12px;
        overflow: hidden;
        transition: box-shadow .2s, transform .2s;
    }
    .role-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,.08); transform: translateY(-2px); }

    .role-card-accent { height: 4px; }

    .perm-toggle {
        display: none;
    }

    .perm-label {
        display: flex; align-items: center; gap: 8px;
        padding: 8px 10px;
        border: 1.5px solid #E8E3DC;
        border-radius: 8px;
        cursor: pointer;
        font-size: .78rem;
        font-weight: 600;
        color: #7A736B;
        transition: all .18s;
        user-select: none;
    }

    .perm-toggle:checked + .perm-label {
        border-color: currentColor;
        background: rgba(0,0,0,.04);
    }

    .perm-toggle:checked + .perm-label .perm-dot {
        opacity: 1;
    }

    .perm-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: currentColor;
        opacity: .25;
        flex-shrink: 0;
        transition: opacity .18s;
    }
</style>

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h5 class="fw-bold mb-1" style="color:var(--terra-navy)">Roles & Permissions</h5>
            <p class="text-muted mb-0" style="font-size:.82rem">Manage department access levels across the platform</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.roles.users') }}" class="btn btn-outline-secondary btn-sm">
                👥 Manage Users
            </a>
            <button class="btn btn-sm text-white" style="background:var(--terra-navy);border:none"
                data-bs-toggle="modal" data-bs-target="#createRoleModal">
                + New Role
            </button>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" style="font-size:.84rem">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" style="font-size:.84rem">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Permission Legend --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3 px-4">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <span style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#7A736B">Permissions:</span>
                @foreach(['review','add','edit','update','delete','approve'] as $p)
                <span class="perm-chip perm-{{ $p }}">{{ ucfirst($p) }}</span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Role Cards --}}
    <div class="row g-3 mb-4">
        @foreach($roles as $role)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="role-card h-100">
                <div class="role-card-accent" style="background:{{ $role->color }}"></div>
                <div class="p-4">

                    {{-- Header --}}
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <h6 class="fw-bold mb-1" style="color:var(--terra-navy)">{{ $role->label }}</h6>
                            <span style="font-size:.72rem;color:#7A736B">{{ $role->department }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            @if($role->is_active)
                            <span style="width:7px;height:7px;border-radius:50%;background:#1E7A5A;display:inline-block" title="Active"></span>
                            @else
                            <span style="width:7px;height:7px;border-radius:50%;background:#DC2626;display:inline-block" title="Inactive"></span>
                            @endif
                            <span style="font-size:.62rem;color:#7A736B">{{ $role->users_count }} user{{ $role->users_count !== 1 ? 's' : '' }}</span>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if($role->description)
                    <p style="font-size:.78rem;color:#7A736B;line-height:1.6;margin-bottom:14px">{{ $role->description }}</p>
                    @endif

                    {{-- Permission chips --}}
                    <div class="d-flex flex-wrap gap-1 mb-4">
                        @foreach(['review','add','edit','update','delete','approve'] as $perm)
                            @if($role->permissions->where('name', $perm)->count())
                            <span class="perm-chip perm-{{ $perm }}">{{ ucfirst($perm) }}</span>
                            @else
                            <span class="perm-chip" style="background:#F5F3F0;color:#C5BDB5;text-decoration:line-through">{{ ucfirst($perm) }}</span>
                            @endif
                        @endforeach
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-secondary flex-fill"
                            onclick="openEditRole({{ $role->id }}, '{{ addslashes($role->label) }}', '{{ addslashes($role->department) }}', '{{ $role->color }}', '{{ addslashes($role->description ?? '') }}', {{ $role->is_active ? 'true' : 'false' }}, {{ $role->permissions->pluck('id')->toJson() }})">
                            ✎ Edit
                        </button>
                        @if($role->name !== 'administrator')
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Delete role {{ $role->label }}? Users with this role will lose access.')">
                                ✕
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Permission Matrix Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold mb-0" style="color:var(--terra-navy);font-size:.88rem">Permission Matrix</h6>
            <p class="text-muted mb-0" style="font-size:.75rem">Full overview of all roles and their access levels</p>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:.83rem">
                    <thead>
                        <tr style="background:#F7F5F2;border-bottom:2px solid #E8E3DC">
                            <th class="px-4 py-3 fw-semibold" style="color:var(--terra-navy)">Department / Role</th>
                            @foreach(['review','add','edit','update','delete','approve'] as $p)
                            <th class="py-3 text-center fw-semibold" style="color:var(--terra-navy)">{{ ucfirst($p) }}</th>
                            @endforeach
                            <th class="py-3 fw-semibold" style="color:var(--terra-navy)">Users</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span style="width:10px;height:10px;border-radius:50%;background:{{ $role->color }};flex-shrink:0;display:inline-block"></span>
                                    <div>
                                        <div class="fw-semibold" style="color:var(--terra-navy)">{{ $role->label }}</div>
                                        <div style="font-size:.72rem;color:#7A736B">{{ $role->department }}</div>
                                    </div>
                                </div>
                            </td>
                            @foreach(['review','add','edit','update','delete','approve'] as $perm)
                            <td class="py-3 text-center">
                                @if($role->permissions->where('name', $perm)->count())
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#1E7A5A">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#E8E3DC">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                </svg>
                                @endif
                            </td>
                            @endforeach
                            <td class="py-3">
                                <span style="font-size:.8rem;color:#7A736B">{{ $role->users_count }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ══ CREATE ROLE MODAL ══ --}}
<div class="modal fade" id="createRoleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="color:var(--terra-navy)">Create New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf
                <div class="modal-body pt-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="font-size:.8rem">Role Key <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-sm"
                                placeholder="e.g. marketing (lowercase, underscores only)" required
                                pattern="[a-z_]+" title="Lowercase letters and underscores only">
                            <div class="form-text">Used in code. Cannot be changed later.</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="font-size:.8rem">Display Label <span class="text-danger">*</span></label>
                            <input type="text" name="label" class="form-control form-control-sm" placeholder="e.g. Marketing Team" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="font-size:.8rem">Department <span class="text-danger">*</span></label>
                            <input type="text" name="department" class="form-control form-control-sm" placeholder="e.g. Marketing & IT" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" style="font-size:.8rem">Badge Color</label>
                            <input type="color" name="color" class="form-control form-control-sm form-control-color" value="#19265d">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label fw-semibold" style="font-size:.8rem">Description</label>
                            <input type="text" name="description" class="form-control form-control-sm" placeholder="Brief description of this role's responsibilities">
                        </div>

                        {{-- Permissions --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold d-block" style="font-size:.8rem">Permissions <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($permissions->flatten() as $permission)
                                <div>
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                        id="cp_{{ $permission->name }}" class="perm-toggle">
                                    <label for="cp_{{ $permission->name }}" class="perm-label perm-{{ $permission->name }}">
                                        <span class="perm-dot" style="color:inherit"></span>
                                        {{ $permission->label }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm text-white px-4" style="background:var(--terra-navy);border:none">Create Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══ EDIT ROLE MODAL ══ --}}
<div class="modal fade" id="editRoleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="color:var(--terra-navy)">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="edit-role-form">
                @csrf @method('PUT')
                <div class="modal-body pt-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.8rem">Display Label <span class="text-danger">*</span></label>
                            <input type="text" name="label" id="er_label" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.8rem">Department <span class="text-danger">*</span></label>
                            <input type="text" name="department" id="er_department" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" style="font-size:.8rem">Badge Color</label>
                            <input type="color" name="color" id="er_color" class="form-control form-control-sm form-control-color">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.8rem">Description</label>
                            <input type="text" name="description" id="er_description" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold d-block" style="font-size:.8rem">Status</label>
                            <div class="form-check form-switch mt-1">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="er_active" style="cursor:pointer">
                                <label class="form-check-label" for="er_active" style="font-size:.82rem">Active</label>
                            </div>
                        </div>

                        {{-- Permissions --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold d-block" style="font-size:.8rem">Permissions</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($permissions->flatten() as $permission)
                                <div>
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                        id="ep_{{ $permission->name }}" class="perm-toggle er-perm"
                                        data-perm-id="{{ $permission->id }}">
                                    <label for="ep_{{ $permission->name }}" class="perm-label perm-{{ $permission->name }}">
                                        <span class="perm-dot"></span>
                                        {{ $permission->label }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm text-white px-4" style="background:var(--terra-orange,#D05208);border:none">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditRole(id, label, department, color, description, isActive, permissionIds) {
    document.getElementById('edit-role-form').action = `/admin/roles/${id}`;
    document.getElementById('er_label').value       = label;
    document.getElementById('er_department').value  = department;
    document.getElementById('er_color').value       = color;
    document.getElementById('er_description').value = description;
    document.getElementById('er_active').checked    = isActive;

    // Reset all permission checkboxes
    document.querySelectorAll('.er-perm').forEach(cb => {
        cb.checked = permissionIds.includes(parseInt(cb.dataset.permId));
    });

    new bootstrap.Modal(document.getElementById('editRoleModal')).show();
}
</script>

@endsection