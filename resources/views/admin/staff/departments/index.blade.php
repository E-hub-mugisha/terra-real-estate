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

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Department Management</h4>
            <small class="text-muted">Manage departments and their assigned staff</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('staff.index') }}"
               class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                <i class="bi bi-people"></i> Staff List
            </a>
            <button type="button"
                    class="btn btn-primary btn-sm d-flex align-items-center gap-1"
                    data-bs-toggle="modal" data-bs-target="#createDeptModal">
                <i class="bi bi-plus-lg"></i> Add Department
            </button>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card text-center py-3">
                <div class="card-body p-1">
                    <div class="fw-bold text-primary" style="font-size:26px">{{ $stats['total'] }}</div>
                    <small class="text-muted">Total Departments</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center py-3">
                <div class="card-body p-1">
                    <div class="fw-bold text-success" style="font-size:26px">{{ $stats['active'] }}</div>
                    <small class="text-muted">Active</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center py-3">
                <div class="card-body p-1">
                    <div class="fw-bold text-secondary" style="font-size:26px">{{ $stats['inactive'] }}</div>
                    <small class="text-muted">Inactive</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center py-3">
                <div class="card-body p-1">
                    <div class="fw-bold text-warning" style="font-size:26px">{{ $stats['staff'] }}</div>
                    <small class="text-muted">Total Staff</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="Search by name or code..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Statuses</option>
                        <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active only</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive only</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button>
                    <a href="{{ route('staff.departments.index') }}"
                       class="btn btn-sm btn-link text-muted">Clear</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:50px">#</th>
                        <th>Department</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th class="text-center">Staff Count</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $dept)
                    <tr>
                        <td class="text-muted ps-3">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center justify-content-center rounded fw-bold text-white"
                                     style="width:34px;height:34px;font-size:11px;background:#378ADD;flex-shrink:0">
                                    {{ strtoupper(substr($dept->name, 0, 2)) }}
                                </div>
                                <span class="fw-semibold">{{ $dept->name }}</span>
                            </div>
                        </td>
                        <td>
                            <code class="badge bg-light text-dark border"
                                  style="font-size:11px;letter-spacing:.5px">
                                {{ $dept->code }}
                            </code>
                        </td>
                        <td>
                            <span class="text-muted small">
                                {{ $dept->description ? Str::limit($dept->description, 50) : '—' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill
                                {{ $dept->staff_count > 0 ? 'bg-primary' : 'bg-secondary' }}">
                                {{ $dept->staff_count }}
                            </span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('staff.departments.toggle', $dept) }}"
                                  method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="badge border-0 px-2 py-1
                                               {{ $dept->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}"
                                        style="cursor:pointer;font-size:11px"
                                        title="Click to toggle status">
                                    <i class="bi bi-circle-fill me-1" style="font-size:7px"></i>
                                    {{ $dept->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end gap-1">
                                {{-- Edit --}}
                                <button type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Edit"
                                        onclick="openEditModal(
                                            {{ $dept->id }},
                                            '{{ addslashes($dept->name) }}',
                                            '{{ $dept->code }}',
                                            '{{ addslashes($dept->description ?? '') }}',
                                            {{ $dept->is_active ? 'true' : 'false' }}
                                        )">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                {{-- Delete --}}
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        title="Delete"
                                        onclick="openDeleteModal(
                                            {{ $dept->id }},
                                            '{{ addslashes($dept->name) }}',
                                            {{ $dept->staff_count }}
                                        )">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-building fs-2 d-block mb-2"></i>
                            No departments found.
                            <a href="#" data-bs-toggle="modal" data-bs-target="#createDeptModal">
                                Create your first department
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Showing {{ $departments->firstItem() }}–{{ $departments->lastItem() }}
                of {{ $departments->total() }} departments
            </small>
            {{ $departments->links() }}
        </div>
    </div>

</div>


{{-- ═══════════════════════════════════════════════════════════
     MODAL 1 — CREATE DEPARTMENT
═══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="createDeptModal" tabindex="-1" aria-labelledby="createDeptLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="createDeptLabel">
                    <i class="bi bi-building-add me-2 text-primary"></i>
                    Add New Department
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('staff.departments.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    {{-- Validation errors (shown inside modal) --}}
                    @if($errors->any())
                        <div class="alert alert-danger py-2 small">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">
                                Department Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="e.g. Sales"
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Code <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="code"
                                   class="form-control text-uppercase @error('code') is-invalid @enderror"
                                   value="{{ old('code') }}"
                                   placeholder="e.g. SALES"
                                   maxlength="10"
                                   oninput="this.value=this.value.toUpperCase()">
                            <div class="form-text">Max 10 chars, letters &amp; numbers only</div>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description"
                                      class="form-control"
                                      rows="2"
                                      maxlength="500"
                                      placeholder="Brief description of this department's role...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                        <i class="bi bi-plus-lg"></i> Create Department
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- ═══════════════════════════════════════════════════════════
     MODAL 2 — EDIT DEPARTMENT
═══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="editDeptModal" tabindex="-1" aria-labelledby="editDeptLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="editDeptLabel">
                    <i class="bi bi-pencil-square me-2 text-primary"></i>
                    Edit Department
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editDeptForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">
                                Department Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="editName"
                                   name="name"
                                   class="form-control"
                                   placeholder="e.g. Sales"
                                   required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Code <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="editCode"
                                   name="code"
                                   class="form-control text-uppercase"
                                   maxlength="10"
                                   oninput="this.value=this.value.toUpperCase()"
                                   required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea id="editDescription"
                                      name="description"
                                      class="form-control"
                                      rows="2"
                                      maxlength="500"></textarea>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="editIsActive"
                                       name="is_active"
                                       value="1">
                                <label class="form-check-label fw-semibold" for="editIsActive">
                                    Active Department
                                </label>
                            </div>
                            <small class="text-muted">
                                Inactive departments are hidden from staff assignment dropdowns.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                        <i class="bi bi-check-lg"></i> Save Changes
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- ═══════════════════════════════════════════════════════════
     MODAL 3 — DELETE DEPARTMENT
═══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="deleteDeptModal" tabindex="-1" aria-labelledby="deleteDeptLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">

            <div class="modal-header border-bottom border-danger-subtle">
                <h5 class="modal-title fw-bold text-danger" id="deleteDeptLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Delete Department
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center py-4">
                <div class="mb-3" id="deleteWarningIcon">
                    <i class="bi bi-building text-danger" style="font-size:40px"></i>
                </div>
                <p class="mb-1">You are about to delete</p>
                <p class="fw-bold fs-6 mb-3" id="deleteDeptName">—</p>
                <div id="deleteBlockedMsg" class="alert alert-warning py-2 small d-none">
                    <i class="bi bi-people me-1"></i>
                    This department has <strong id="deleteStaffCount">0</strong> staff assigned.
                    Reassign them before deleting.
                </div>
                <p class="text-muted small mb-0" id="deleteConfirmMsg">
                    This action cannot be undone.
                </p>
            </div>

            <div class="modal-footer border-top">
                <button type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                    Cancel
                </button>
                <form id="deleteDeptForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            id="deleteConfirmBtn"
                            class="btn btn-danger d-flex align-items-center gap-2">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>


<script>
// ── Open Edit Modal — populate with row data ──────────────────
function openEditModal(id, name, code, description, isActive) {
    document.getElementById('editDeptForm').action =
        `/staff/departments/${id}`;
    document.getElementById('editName').value        = name;
    document.getElementById('editCode').value        = code;
    document.getElementById('editDescription').value = description;
    document.getElementById('editIsActive').checked  = isActive;

    new bootstrap.Modal(document.getElementById('editDeptModal')).show();
}

// ── Open Delete Modal — show warning if staff assigned ────────
function openDeleteModal(id, name, staffCount) {
    document.getElementById('deleteDeptForm').action =
        `/staff/departments/${id}`;
    document.getElementById('deleteDeptName').textContent = name;

    const blocked    = document.getElementById('deleteBlockedMsg');
    const confirmMsg = document.getElementById('deleteConfirmMsg');
    const confirmBtn = document.getElementById('deleteConfirmBtn');
    const countEl    = document.getElementById('deleteStaffCount');

    if (staffCount > 0) {
        // Block delete — show warning, disable confirm button
        countEl.textContent  = staffCount;
        blocked.classList.remove('d-none');
        confirmMsg.classList.add('d-none');
        confirmBtn.disabled  = true;
        confirmBtn.classList.replace('btn-danger', 'btn-secondary');
    } else {
        // Allow delete
        blocked.classList.add('d-none');
        confirmMsg.classList.remove('d-none');
        confirmBtn.disabled  = false;
        confirmBtn.classList.replace('btn-secondary', 'btn-danger');
    }

    new bootstrap.Modal(document.getElementById('deleteDeptModal')).show();
}

// ── Auto-open Create modal if validation failed ───────────────
@if($errors->any() && old('_from') === 'create')
    document.addEventListener('DOMContentLoaded', () => {
        new bootstrap.Modal(document.getElementById('createDeptModal')).show();
    });
@endif
</script>

@endsection