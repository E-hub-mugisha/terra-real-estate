@extends('layouts.app')

@section('title', 'Testimonials')

@section('content')
<style>
    .t-admin { font-family: 'DM Sans', sans-serif; }

    /* ── Tab bar ── */
    .tab-bar { display:flex; gap:4px; margin-bottom:1.5rem; flex-wrap:wrap; }
    .tab-bar a {
        padding:7px 16px; border-radius:8px; font-size:13px; font-weight:500;
        text-decoration:none; color:#5f5e5a; border:0.5px solid transparent; transition:all .15s;
    }
    .tab-bar a:hover { background:#f1efe8; }
    .tab-bar a.active { background:#fff; border-color:#d3d1c7; color:#2c2c2a; }
    .tab-bar .badge-count {
        display:inline-flex; align-items:center; justify-content:center;
        background:#e8f4ed; color:#2d6a42; font-size:11px; font-weight:600;
        border-radius:20px; padding:1px 7px; margin-left:4px;
    }
    .tab-bar .badge-count.pending  { background:#faeeda; color:#854f0b; }
    .tab-bar .badge-count.rejected { background:#fcebeb; color:#a32d2d; }

    /* ── Table ── */
    .t-table { width:100%; border-collapse:collapse; font-size:13px; }
    .t-table th {
        text-align:left; padding:10px 12px; font-weight:500; font-size:12px;
        color:#888780; border-bottom:0.5px solid #d3d1c7; background:#f9f8f5;
    }
    .t-table td { padding:11px 12px; border-bottom:0.5px solid #eeecea; vertical-align:middle; }
    .t-table tr:hover td { background:#fafaf8; }

    /* ── Avatar ── */
    .av {
        width:34px; height:34px; border-radius:50%; display:inline-flex;
        align-items:center; justify-content:center; font-size:12px; font-weight:500; flex-shrink:0;
    }
    .av-green  { background:#e8f4ed; color:#2d6a42; }
    .av-blue   { background:#e6f1fb; color:#185fa5; }
    .av-amber  { background:#faeeda; color:#854f0b; }
    .av-purple { background:#eeedfe; color:#534ab7; }
    .av-pink   { background:#fbeaf0; color:#993556; }

    /* ── Badges ── */
    .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
    .badge-pending  { background:#faeeda; color:#854f0b; }
    .badge-approved { background:#e8f4ed; color:#2d6a42; }
    .badge-rejected { background:#fcebeb; color:#a32d2d; }
    .badge-featured { background:#eeedfe; color:#534ab7; }

    /* ── Stars ── */
    .stars { display:inline-flex; gap:2px; }
    .star {
        width:11px; height:11px; background:#e8a020;
        clip-path:polygon(50% 0%,61% 35%,98% 35%,68% 57%,79% 91%,50% 70%,21% 91%,32% 57%,2% 35%,39% 35%);
    }
    .star.off { background:#d3d1c7; }

    /* ── Action buttons ── */
    .btn-icon {
        width:30px; height:30px; border-radius:6px; border:0.5px solid #d3d1c7;
        background:#fff; cursor:pointer; display:inline-flex; align-items:center;
        justify-content:center; font-size:13px; transition:all .15s;
        text-decoration:none; color:#5f5e5a; line-height:1;
    }
    .btn-icon:hover         { background:#f1efe8; border-color:#b4b2a9; }
    .btn-icon.approve:hover { background:#e8f4ed; border-color:#4a7c59; color:#2d6a42; }
    .btn-icon.reject:hover  { background:#fcebeb; border-color:#a32d2d; color:#a32d2d; }
    .btn-icon.edit:hover    { background:#e6f1fb; border-color:#185fa5; color:#185fa5; }
    .btn-icon.delete:hover  { background:#fcebeb; border-color:#a32d2d; color:#a32d2d; }
    .btn-icon.feature:hover { background:#eeedfe; border-color:#534ab7; color:#534ab7; }

    /* ── Primary button ── */
    .btn-primary {
        display:inline-flex; align-items:center; gap:6px; background:#4a7c59;
        color:#fff; border:none; padding:9px 18px; border-radius:8px;
        font-size:13px; font-weight:500; cursor:pointer; text-decoration:none; transition:background .15s;
    }
    .btn-primary:hover { background:#3a6347; color:#fff; }

    /* ── Override Bootstrap modal chrome to match design system ── */
    .modal-content {
        border-radius: 16px;
        border: 0.5px solid #d3d1c7;
        box-shadow: 0 4px 6px rgba(0,0,0,.07), 0 16px 48px rgba(0,0,0,.16);
        font-family: 'DM Sans', sans-serif;
    }
    .modal-header {
        padding: 1.25rem 1.75rem 0;
        border-bottom: none;
    }
    .modal-title {
        font-size: 17px;
        font-weight: 500;
        color: #2c2c2a;
    }
    .modal-body {
        padding: 1rem 1.75rem;
    }
    .modal-footer {
        padding: 1rem 1.75rem 1.5rem;
        border-top: 0.5px solid #eeecea;
        gap: 8px;
    }
    .btn-close {
        opacity: .5;
    }
    .btn-close:hover { opacity: 1; }

    /* ── Form fields ── */
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    .form-group { display:flex; flex-direction:column; gap:4px; }
    .form-group.full { grid-column:1/-1; }
    .form-label { font-size:12px; font-weight:500; color:#5f5e5a; }
    .form-control {
        padding:8px 10px; border-radius:8px; border:0.5px solid #d3d1c7;
        font-size:13px; color:#2c2c2a; outline:none; transition:border-color .15s;
        font-family:inherit; background:#fff; width:100%; box-sizing:border-box;
    }
    .form-control:focus { border-color:#4a7c59; box-shadow:none; }
    textarea.form-control { min-height:90px; resize:vertical; }
    .form-check { display:flex; align-items:center; gap:8px; font-size:13px; color:#2c2c2a; }

    /* ── Star picker ── */
    .star-picker { display:flex; gap:6px; }
    .star-picker-label {
        width:22px; height:22px; cursor:pointer; display:block; background:#d3d1c7;
        clip-path:polygon(50% 0%,61% 35%,98% 35%,68% 57%,79% 91%,50% 70%,21% 91%,32% 57%,2% 35%,39% 35%);
        transition:background .12s;
    }

    /* ── Modal action buttons ── */
    .btn-cancel {
        flex:1; padding:9px; border-radius:8px; border:0.5px solid #d3d1c7;
        background:#fff; font-size:13px; cursor:pointer; font-family:inherit;
        color:#5f5e5a; transition:background .15s;
    }
    .btn-cancel:hover { background:#f1efe8; }
    .btn-submit {
        flex:2; padding:9px; border-radius:8px; border:none; background:#4a7c59;
        color:#fff; font-size:13px; font-weight:500; cursor:pointer;
        font-family:inherit; transition:background .15s;
    }
    .btn-submit:hover { background:#3a6347; }
    .btn-danger {
        flex:1; padding:9px; border-radius:8px; border:none; background:#a32d2d;
        color:#fff; font-size:13px; font-weight:500; cursor:pointer;
        font-family:inherit; transition:background .15s;
    }
    .btn-danger:hover { background:#7d1f1f; }

    /* ── Alerts ── */
    .alert { padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:1rem; transition:opacity .4s; }
    .alert-success { background:#e8f4ed; color:#2d6a42; border:0.5px solid #9fe1cb; }
    .alert-danger  { background:#fcebeb; color:#a32d2d; border:0.5px solid #f7c1c1; }

    .empty-state    { text-align:center; padding:3rem 1rem; color:#888780; font-size:14px; }
    .pagination-wrap{ margin-top:1rem; }
</style>

<div class="t-admin">

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem; flex-wrap:wrap; gap:.75rem;">
        <div>
            <h1 style="font-size:1.35rem; font-weight:500; margin:0; color:#2c2c2a;">Testimonials</h1>
            <p style="font-size:13px; color:#888780; margin:3px 0 0;">Manage client reviews. Pending submissions require approval before going live.</p>
        </div>
        <button class="btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                <path d="M8 1v14M1 8h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            Add testimonial
        </button>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success" id="flashMsg">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" id="flashMsg">{{ session('error') }}</div>
    @endif

    {{-- Tab bar --}}
    <div class="tab-bar">
        @foreach(['all' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $key => $label)
            <a href="{{ route('admin.testimonials.index', ['status' => $key]) }}"
               class="{{ $status === $key ? 'active' : '' }}">
                {{ $label }}
                <span class="badge-count {{ $key }}">{{ $counts[$key] }}</span>
            </a>
        @endforeach
    </div>

    {{-- Table --}}
    <div style="background:#fff; border-radius:12px; border:0.5px solid #d3d1c7; overflow:hidden;">
        @if($testimonials->isEmpty())
            <div class="empty-state">No testimonials found for this filter.</div>
        @else
        <table class="t-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Review</th>
                    <th>Rating</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($testimonials as $t)
                @php
                    $avatarColors = ['av-green','av-blue','av-amber','av-purple','av-pink'];
                    $color = $avatarColors[$t->id % count($avatarColors)];
                @endphp
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div class="av {{ $color }}">{{ $t->avatar_initials }}</div>
                            <div>
                                <div style="font-weight:500; color:#2c2c2a; font-size:13px;">{{ $t->name }}</div>
                                @if($t->location)
                                    <div style="font-size:11px; color:#888780;">{{ $t->location }}</div>
                                @endif
                                @if($t->featured)
                                    <span class="badge badge-featured" style="margin-top:2px;">★ Featured</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="max-width:260px;">
                        <div style="color:#5f5e5a; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;">
                            {{ $t->review }}
                        </div>
                    </td>
                    <td>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="star {{ $i <= $t->rating ? '' : 'off' }}"></div>
                            @endfor
                        </div>
                    </td>
                    <td style="font-size:12px; color:#5f5e5a; white-space:nowrap;">{{ $t->transaction_label }}</td>
                    <td>
                        <span class="badge {{ $t->status_badge_class }}">{{ ucfirst($t->status) }}</span>
                    </td>
                    <td style="font-size:12px; color:#888780; white-space:nowrap;">
                        {{ $t->created_at->format('d M Y') }}
                        <div style="font-size:11px;">{{ $t->source === 'admin' ? 'Admin' : 'Website' }}</div>
                    </td>
                    <td>
                        <div style="display:flex; gap:4px; justify-content:flex-end; flex-wrap:wrap;">
                            @if($t->status !== 'approved')
                            <form method="POST" action="{{ route('admin.testimonials.approve', $t) }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-icon approve" title="Approve">✓</button>
                            </form>
                            @endif

                            @if($t->status !== 'rejected')
                            <button type="button" class="btn-icon reject" title="Reject"
                                    onclick="openRejectModal({{ $t->id }}, '{{ addslashes($t->name) }}')">✕</button>
                            @endif

                            <form method="POST" action="{{ route('admin.testimonials.toggleFeatured', $t) }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-icon feature"
                                        title="{{ $t->featured ? 'Unfeature' : 'Feature' }}">★</button>
                            </form>

                            <button type="button" class="btn-icon edit" title="Edit"
                                    onclick="openEditModal({{ $t->toJson() }})">✎</button>

                            <button type="button" class="btn-icon delete" title="Delete"
                                    onclick="openDeleteModal({{ $t->id }}, '{{ addslashes($t->name) }}')">🗑</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap" style="padding:12px 16px; border-top:0.5px solid #eeecea;">
            {{ $testimonials->links() }}
        </div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     MODALS — proper Bootstrap 5 structure:
       .modal > .modal-dialog.modal-dialog-centered
              > .modal-content
              > .modal-header + .modal-body + .modal-footer
══════════════════════════════════════════════════════ --}}

{{-- Create --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:580px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add testimonial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.testimonials.store') }}">
                @csrf
                <div class="modal-body">
                    @include('admin.testimonials._form', ['t' => null])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-submit">Create testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:580px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit testimonial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="editForm">
                @csrf @method('PUT')
                <input type="hidden" name="redirect_status" value="{{ $status }}">
                <div class="modal-body">
                    @include('admin.testimonials._form', ['t' => '__edit__'])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Reject --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject testimonial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="rejectForm">
                @csrf @method('PATCH')
                <div class="modal-body">
                    <p style="font-size:13px; color:#5f5e5a; margin:0 0 1rem;" id="rejectDesc"></p>
                    <div class="form-group">
                        <label class="form-label">Admin note (optional — visible to admins only)</label>
                        <textarea name="admin_note" class="form-control" placeholder="Reason for rejection..." rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-danger">Confirm reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete testimonial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="deleteForm">
                @csrf @method('DELETE')
                <div class="modal-body">
                    <p style="font-size:13px; color:#5f5e5a; margin:0;" id="deleteDesc"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-danger">Yes, delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// ── Helpers: use Bootstrap's JS API to show/hide modals ──────────────────
function openBsModal(id) {
    bootstrap.Modal.getOrCreateInstance(document.getElementById(id)).show();
}

// ── Edit modal ────────────────────────────────────────────────────────────
function openEditModal(t) {
    const form = document.getElementById('editForm');
    form.action = `/admin/testimonials/${t.id}`;

    const set = (name, val) => {
        const el = form.querySelector(`[name="${name}"]`);
        if (el) el.value = val ?? '';
    };

    set('name',             t.name);
    set('email',            t.email);
    set('location',         t.location);
    set('transaction_type', t.transaction_type);
    set('rating',           t.rating);
    set('review',           t.review);
    set('status',           t.status);
    set('admin_note',       t.admin_note);

    const feat = form.querySelector('[name="featured"]');
    if (feat) feat.checked = !!t.featured;

    updateStarPicker(form, t.rating);
    openBsModal('editModal');
}

function updateStarPicker(form, rating) {
    form.querySelectorAll('.star-picker-label').forEach(lbl => {
        lbl.style.background = parseInt(lbl.dataset.val) <= rating ? '#e8a020' : '#d3d1c7';
    });
}

// ── Reject modal ──────────────────────────────────────────────────────────
function openRejectModal(id, name) {
    document.getElementById('rejectForm').action = `/admin/testimonials/${id}/reject`;
    document.getElementById('rejectDesc').textContent =
        `You are about to reject "${name}". This will hide it from the site.`;
    openBsModal('rejectModal');
}

// ── Delete modal ──────────────────────────────────────────────────────────
function openDeleteModal(id, name) {
    document.getElementById('deleteForm').action = `/admin/testimonials/${id}`;
    document.getElementById('deleteDesc').textContent =
        `Are you sure you want to permanently delete the testimonial by "${name}"?`;
    openBsModal('deleteModal');
}

// ── Star pickers ──────────────────────────────────────────────────────────
document.querySelectorAll('.star-picker-label').forEach(lbl => {
    lbl.addEventListener('click', () => {
        const val  = parseInt(lbl.dataset.val);
        const form = lbl.closest('form');
        const inp  = form.querySelector('[name="rating"]');
        if (inp) inp.value = val;
        updateStarPicker(form, val);
    });
});

// ── Auto-fade flash ───────────────────────────────────────────────────────
const flash = document.getElementById('flashMsg');
if (flash) setTimeout(() => flash.style.opacity = '0', 4000);
</script>
@endsection