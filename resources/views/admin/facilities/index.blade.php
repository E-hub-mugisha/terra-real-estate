@extends('layouts.app')
@section('title', 'Facilities')
@section('content')

<style>
    :root {
        --accent:   #c9a96e;
        --accent-lt:#e4c990;
        --danger:   #dc3545;
        --border:   #e2e8f0;
        --surface:  #f8fafc;
        --muted:    #94a3b8;
        --text:     #1e293b;
        --text-dim: #64748b;
        --radius:   10px;
    }

    .fc-page { padding: 1.75rem 0 3rem; max-width: 860px; margin: 0 auto; }

    /* ── Top bar ── */
    .fc-topbar {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem; margin-bottom: 1.75rem;
    }
    .fc-topbar h4 { font-size: 1.2rem; font-weight: 700; color: var(--text); margin: 0; }
    .fc-topbar p  { font-size: .82rem; color: var(--muted); margin: .15rem 0 0; }

    .fc-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .6rem 1.2rem; border-radius: 8px; font-size: .84rem; font-weight: 600;
        border: none; cursor: pointer; transition: all .2s; text-decoration: none; font-family: inherit;
    }
    .fc-btn-primary { background: var(--accent); color: #fff; }
    .fc-btn-primary:hover { background: var(--accent-lt); color: #fff; transform: translateY(-1px); }
    .fc-btn-ghost { background: none; border: 1.5px solid var(--border); color: var(--text-dim); }
    .fc-btn-ghost:hover { border-color: var(--accent); color: var(--accent); }
    .fc-btn-danger-ghost { background: none; border: 1.5px solid #fecaca; color: var(--danger); }
    .fc-btn-danger-ghost:hover { background: #fef2f2; }
    .fc-btn-sm { padding: .38rem .85rem; font-size: .78rem; }

    /* ── Alerts ── */
    .fc-alert {
        border-radius: 8px; padding: .85rem 1.1rem; font-size: .84rem;
        display: flex; gap: .6rem; align-items: center; margin-bottom: 1.25rem;
    }
    .fc-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .fc-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }

    /* ── Stats strip ── */
    .fc-stat-strip {
        display: flex; align-items: center; gap: 1.5rem;
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        padding: .9rem 1.4rem; margin-bottom: 1.25rem; flex-wrap: wrap;
    }
    .fc-stat { display: flex; flex-direction: column; gap: .1rem; }
    .fc-stat-val   { font-size: 1.5rem; font-weight: 700; color: var(--accent); line-height: 1; }
    .fc-stat-label { font-size: .7rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); }
    .fc-stat-sep   { width: 1px; height: 32px; background: var(--border); }

    /* ── Search ── */
    .fc-search-wrap { position: relative; max-width: 320px; }
    .fc-search-wrap svg { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
    .fc-search-input {
        width: 100%; padding: .56rem .85rem .56rem 2.3rem;
        border: 1.5px solid var(--border); border-radius: 8px; font-size: .84rem;
        color: var(--text); background: var(--surface); outline: none; font-family: inherit;
        transition: border-color .2s;
    }
    .fc-search-input:focus { border-color: var(--accent); }

    /* ── Table card ── */
    .fc-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .fc-table-toolbar {
        display: flex; align-items: center; justify-content: space-between; gap: .75rem;
        padding: 1rem 1.4rem; border-bottom: 1px solid var(--border); background: var(--surface);
        flex-wrap: wrap;
    }
    .fc-table-toolbar-left { display: flex; align-items: center; gap: .5rem; }
    .fc-table-toolbar-title { font-size: .86rem; font-weight: 600; color: var(--text); }

    .fc-table { width: 100%; border-collapse: collapse; font-size: .84rem; }
    .fc-table thead { background: var(--surface); }
    .fc-table th {
        padding: .75rem 1.2rem; text-align: left; font-size: .7rem; font-weight: 700;
        letter-spacing: .08em; text-transform: uppercase; color: var(--muted);
        border-bottom: 1px solid var(--border);
    }
    .fc-table td { padding: .9rem 1.2rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
    .fc-table tr:last-child td { border-bottom: none; }
    .fc-table tbody tr { transition: background .15s; }
    .fc-table tbody tr:hover { background: #fafafa; }

    /* ── Facility icon badge ── */
    .fc-icon-badge {
        width: 34px; height: 34px; border-radius: 8px; background: #c9a96e12;
        border: 1px solid #c9a96e28; display: flex; align-items: center; justify-content: center;
        color: var(--accent); flex-shrink: 0;
    }
    .fc-name-cell { display: flex; align-items: center; gap: .75rem; }
    .fc-name-text { font-weight: 600; color: var(--text); font-size: .88rem; }

    /* ── Slug pill ── */
    .fc-slug {
        display: inline-block; padding: .2rem .65rem; border-radius: 6px;
        background: var(--surface); border: 1px solid var(--border);
        font-family: monospace; font-size: .76rem; color: var(--text-dim);
    }

    /* ── Index badge ── */
    .fc-index {
        display: inline-flex; align-items: center; justify-content: center;
        width: 24px; height: 24px; border-radius: 6px; background: var(--surface);
        border: 1px solid var(--border); font-size: .74rem; font-weight: 600; color: var(--muted);
    }

    /* ── Actions ── */
    .fc-actions { display: flex; align-items: center; gap: .4rem; }
    .fc-icon-btn {
        width: 32px; height: 32px; border-radius: 7px; border: 1px solid var(--border);
        background: none; cursor: pointer; display: flex; align-items: center; justify-content: center;
        color: var(--text-dim); transition: all .15s; text-decoration: none;
    }
    .fc-icon-btn:hover       { border-color: var(--accent); color: var(--accent); background: #c9a96e08; }
    .fc-icon-btn.danger:hover { border-color: #fecaca; color: var(--danger); background: #fef2f2; }

    /* ── Empty state ── */
    .fc-empty { text-align: center; padding: 4rem 2rem; }
    .fc-empty-icon {
        width: 56px; height: 56px; border-radius: 12px; background: #c9a96e12;
        border: 1px solid #c9a96e28; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.1rem; color: var(--accent);
    }
    .fc-empty h5 { font-size: .96rem; font-weight: 600; color: var(--text); margin: 0 0 .4rem; }
    .fc-empty p  { font-size: .82rem; color: var(--muted); margin: 0 0 1.1rem; }

    /* ── Modal ── */
    .fc-modal .modal-content {
        border: 1px solid var(--border); border-radius: var(--radius);
        box-shadow: 0 8px 32px rgba(0,0,0,.12); overflow: hidden;
    }
    .fc-modal .modal-header {
        background: var(--surface); border-bottom: 1px solid var(--border);
        padding: 1rem 1.4rem; display: flex; align-items: center; gap: .75rem;
    }
    .fc-modal .modal-header .fc-modal-icon {
        width: 30px; height: 30px; border-radius: 7px; background: #c9a96e18;
        display: flex; align-items: center; justify-content: center; color: var(--accent); flex-shrink: 0;
    }
    .fc-modal .modal-header .fc-modal-icon.danger { background: #fef2f2; color: var(--danger); }
    .fc-modal .modal-title { font-size: .92rem; font-weight: 700; color: var(--text); margin: 0; }
    .fc-modal .modal-body  { padding: 1.4rem; }
    .fc-modal .modal-footer { padding: .85rem 1.4rem; border-top: 1px solid var(--border); gap: .5rem; }

    .fc-label {
        display: block; font-size: .75rem; font-weight: 600; letter-spacing: .05em;
        text-transform: uppercase; color: var(--text-dim); margin-bottom: .45rem;
    }
    .fc-input {
        width: 100%; padding: .65rem .9rem; border: 1.5px solid var(--border); border-radius: 8px;
        font-size: .875rem; color: var(--text); background: #fff; outline: none; font-family: inherit;
        transition: border-color .2s, box-shadow .2s;
    }
    .fc-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px #c9a96e18; }

    .fc-delete-msg {
        font-size: .88rem; color: var(--text-dim); line-height: 1.6;
        padding: .75rem 1rem; border-radius: 8px; border: 1px solid #fecaca; background: #fef2f2;
    }
    .fc-delete-msg strong { color: var(--text); }

    /* ── Pagination ── */
    .fc-pagination {
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem;
        padding: .9rem 1.2rem; border-top: 1px solid var(--border);
    }
    .fc-pagination-info { font-size: .78rem; color: var(--muted); }
    .fc-pagination-info strong { color: var(--text-dim); }
    .fc-pages { display: flex; gap: .3rem; }
    .fc-page-btn {
        min-width: 32px; height: 32px; border-radius: 6px; border: 1px solid var(--border);
        background: none; color: var(--text-dim); font-size: .78rem; cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
        text-decoration: none; font-family: inherit; transition: all .15s; padding: 0 .4rem;
    }
    .fc-page-btn:hover { border-color: var(--accent); color: var(--accent); }
    .fc-page-btn.current { background: var(--accent); color: #fff; border-color: var(--accent); font-weight: 600; }
    .fc-page-btn.disabled { opacity: .35; pointer-events: none; }
</style>

<div class="fc-page">

    {{-- ── Top bar ── --}}
    <div class="fc-topbar">
        <div>
            <h4>Facilities</h4>
            <p>Manage amenities attached to house listings.</p>
        </div>
        <button class="fc-btn fc-btn-primary" data-bs-toggle="modal" data-bs-target="#createFacility">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Add Facility
        </button>
    </div>

    {{-- ── Alerts ── --}}
    @if(session('success'))
        <div class="fc-alert fc-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="fc-alert fc-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Stats strip ── --}}
    <div class="fc-stat-strip">
        <div class="fc-stat">
            <span class="fc-stat-val">{{ $facilities->total() ?? count($facilities) }}</span>
            <span class="fc-stat-label">Total</span>
        </div>
        <div class="fc-stat-sep"></div>
        <div class="fc-stat" style="flex:1">
            <div class="fc-search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" class="fc-search-input" id="fcSearch" placeholder="Filter facilities…" oninput="filterTable()">
            </div>
        </div>
    </div>

    {{-- ── Table card ── --}}
    <div class="fc-card">
        <div class="fc-table-toolbar">
            <div class="fc-table-toolbar-left">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--accent)"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>
                <span class="fc-table-toolbar-title">All Facilities</span>
            </div>
            <span id="fcCount" style="font-size:.75rem;color:var(--muted)">
                {{ count($facilities) }} facilit{{ count($facilities) === 1 ? 'y' : 'ies' }}
            </span>
        </div>

        <div style="overflow-x:auto">
            <table class="fc-table" id="fcTable">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Facility</th>
                        <th>Slug</th>
                        <th style="width:100px">Actions</th>
                    </tr>
                </thead>
                <tbody id="fcTableBody">
                    @forelse($facilities as $facility)
                        <tr data-name="{{ strtolower($facility->name) }}">
                            <td><span class="fc-index">{{ $loop->iteration }}</span></td>
                            <td>
                                <div class="fc-name-cell">
                                    <div class="fc-icon-badge">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
                                    </div>
                                    <span class="fc-name-text">{{ $facility->name }}</span>
                                </div>
                            </td>
                            <td><span class="fc-slug">{{ $facility->slug }}</span></td>
                            <td>
                                <div class="fc-actions">
                                    <button class="fc-icon-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editFacility{{ $facility->id }}"
                                            title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <button class="fc-icon-btn danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteFacility{{ $facility->id }}"
                                            title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="fc-empty">
                                    <div class="fc-empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>
                                    </div>
                                    <h5>No facilities yet</h5>
                                    <p>Add your first facility to attach it to house listings.</p>
                                    <button class="fc-btn fc-btn-primary fc-btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#createFacility">
                                        Add First Facility
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(method_exists($facilities, 'hasPages') && $facilities->hasPages())
            <div class="fc-pagination">
                <p class="fc-pagination-info">
                    Showing <strong>{{ $facilities->firstItem() }}</strong>–<strong>{{ $facilities->lastItem() }}</strong>
                    of <strong>{{ $facilities->total() }}</strong>
                </p>
                <div class="fc-pages">
                    @if($facilities->onFirstPage())
                        <span class="fc-page-btn disabled">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                        </span>
                    @else
                        <a href="{{ $facilities->previousPageUrl() }}" class="fc-page-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                        </a>
                    @endif
                    @foreach($facilities->getUrlRange(max(1,$facilities->currentPage()-2), min($facilities->lastPage(),$facilities->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}" class="fc-page-btn {{ $page == $facilities->currentPage() ? 'current' : '' }}">{{ $page }}</a>
                    @endforeach
                    @if($facilities->hasMorePages())
                        <a href="{{ $facilities->nextPageUrl() }}" class="fc-page-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    @else
                        <span class="fc-page-btn disabled">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ══ CREATE MODAL ══ --}}
<div class="modal fade fc-modal" id="createFacility" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.facilities.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <div class="fc-modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </div>
                <h5 class="modal-title">Add Facility</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="fc-label">Facility Name <span style="color:var(--danger)">*</span></label>
                <input type="text" name="name" class="fc-input"
                       placeholder="e.g. Swimming Pool, Gym, Parking"
                       autofocus required>
                <p style="font-size:.73rem;color:var(--muted);margin-top:.4rem">
                    A URL slug will be generated automatically.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="fc-btn fc-btn-ghost fc-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="fc-btn fc-btn-primary fc-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                    Create Facility
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ EDIT + DELETE MODALS ══ --}}
@foreach($facilities as $facility)

    {{-- Edit Modal --}}
    <div class="modal fade fc-modal" id="editFacility{{ $facility->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST"
                  action="{{ route('admin.facilities.update', $facility->id) }}"
                  class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <div class="fc-modal-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </div>
                    <h5 class="modal-title">Edit Facility</h5>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="fc-label">Facility Name <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="name"
                           value="{{ $facility->name }}"
                           class="fc-input" required>
                    <div style="margin-top:.65rem;padding:.45rem .8rem;background:var(--surface);border:1px solid var(--border);border-radius:6px;font-size:.75rem;color:var(--text-dim);">
                        <span style="color:var(--muted)">Current slug: </span>
                        <span style="font-family:monospace">{{ $facility->slug }}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="fc-btn fc-btn-ghost fc-btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="fc-btn fc-btn-primary fc-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div class="modal fade fc-modal" id="deleteFacility{{ $facility->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST"
                  action="{{ route('admin.facilities.destroy', $facility->id) }}"
                  class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <div class="fc-modal-icon danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                    </div>
                    <h5 class="modal-title" style="color:var(--danger)">Delete Facility</h5>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="fc-delete-msg">
                        Are you sure you want to delete <strong>{{ $facility->name }}</strong>?
                        This will remove it from all house listings it is currently attached to.
                        <br><br>
                        <span style="font-size:.8rem;color:var(--danger)">⚠ This action cannot be undone.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="fc-btn fc-btn-ghost fc-btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="fc-btn fc-btn-sm fc-btn-danger-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

@endforeach

<script>
/* ── Live client-side filter ── */
function filterTable() {
    const q    = document.getElementById('fcSearch').value.toLowerCase();
    const rows = document.querySelectorAll('#fcTableBody tr[data-name]');
    let   shown = 0;
    rows.forEach(row => {
        const match = row.dataset.name.includes(q);
        row.style.display = match ? '' : 'none';
        if (match) shown++;
    });
    document.getElementById('fcCount').textContent =
        shown + ' facilit' + (shown === 1 ? 'y' : 'ies');
}
</script>

@endsection