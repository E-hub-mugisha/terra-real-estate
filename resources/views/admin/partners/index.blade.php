@extends('layouts.app')
@section('title', 'Partners')
@section('content')

<style>
    :root{--accent:#c9a96e;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--emerald:#059669;--emerald-lt:#10b981;}
    .pt-page{padding:1.75rem 0 3rem;max-width:980px;margin:0 auto;}
    .pt-topbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.75rem;}
    .pt-topbar h4{font-size:1.2rem;font-weight:700;color:var(--text);margin:0;}
    .pt-topbar p{font-size:.82rem;color:var(--muted);margin:.15rem 0 0;}
    /* Buttons */
    .pt-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.6rem 1.2rem;border-radius:8px;font-size:.84rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .pt-btn-primary{background:var(--emerald);color:#fff;}.pt-btn-primary:hover{background:var(--emerald-lt);color:#fff;transform:translateY(-1px);}
    .pt-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.pt-btn-ghost:hover{border-color:var(--emerald);color:var(--emerald);}
    .pt-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}.pt-btn-danger:hover{background:#fef2f2;}
    .pt-btn-sm{padding:.38rem .85rem;font-size:.78rem;}
    /* Alerts */
    .pt-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:center;margin-bottom:1.25rem;}
    .pt-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .pt-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    /* Stats */
    .pt-stats{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;margin-bottom:1.5rem;}
    .pt-stat{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:.9rem 1.1rem;position:relative;overflow:hidden;}
    .pt-stat::before{content:'';position:absolute;top:0;left:0;width:3px;height:100%;background:var(--bc,var(--emerald));}
    .pt-stat-val{font-size:1.5rem;font-weight:700;color:var(--bc,var(--emerald));line-height:1;}
    .pt-stat-label{font-size:.7rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-top:.3rem;}
    /* Card */
    .pt-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .pt-card-toolbar{display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.4rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .pt-card-title{display:flex;align-items:center;gap:.5rem;font-size:.86rem;font-weight:600;color:var(--text);}
    /* Search */
    .pt-search-wrap{position:relative;width:210px;}
    .pt-search-wrap svg{position:absolute;left:.75rem;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none;}
    .pt-search{width:100%;padding:.48rem .75rem .48rem 2.15rem;border:1.5px solid var(--border);border-radius:8px;font-size:.82rem;color:var(--text);background:var(--surface);outline:none;font-family:inherit;}
    .pt-search:focus{border-color:var(--emerald);}
    /* Table */
    .pt-table{width:100%;border-collapse:collapse;font-size:.84rem;}
    .pt-table thead{background:var(--surface);}
    .pt-table th{padding:.75rem 1.1rem;text-align:left;font-size:.7rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);border-bottom:1px solid var(--border);white-space:nowrap;}
    .pt-table td{padding:.85rem 1.1rem;border-bottom:1px solid var(--border);vertical-align:middle;}
    .pt-table tr:last-child td{border-bottom:none;}
    .pt-table tbody tr{transition:background .15s;}
    .pt-table tbody tr:hover{background:#fafafa;}
    /* Partner cell */
    .pt-partner-cell{display:flex;align-items:center;gap:.75rem;}
    .pt-logo{width:52px;height:36px;border-radius:6px;object-fit:contain;border:1px solid var(--border);background:#fff;padding:2px;flex-shrink:0;}
    .pt-logo-placeholder{width:52px;height:36px;border-radius:6px;border:1px solid var(--border);background:linear-gradient(135deg,#d1fae5,#a7f3d0);display:flex;align-items:center;justify-content:center;color:var(--emerald);flex-shrink:0;}
    .pt-partner-name{font-weight:600;color:var(--text);font-size:.87rem;}
    /* Link cell */
    .pt-link{display:inline-flex;align-items:center;gap:.3rem;font-size:.8rem;color:var(--emerald);text-decoration:none;max-width:240px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
    .pt-link:hover{text-decoration:underline;}
    .pt-no-link{font-size:.8rem;color:var(--muted);font-style:italic;}
    /* Row index */
    .pt-idx{width:30px;height:30px;border-radius:6px;background:var(--surface);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:600;color:var(--muted);}
    /* Actions */
    .pt-actions{display:flex;align-items:center;gap:.35rem;justify-content:flex-end;}
    .pt-icon-btn{width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-dim);transition:all .15s;}
    .pt-icon-btn:hover{border-color:var(--emerald);color:var(--emerald);background:#d1fae508;}
    .pt-icon-btn.danger:hover{border-color:#fecaca;color:var(--danger);background:#fef2f2;}
    /* Empty */
    .pt-empty{text-align:center;padding:3.5rem 2rem;}
    .pt-empty-icon{width:48px;height:48px;border-radius:12px;background:#d1fae5;border:1px solid #a7f3d0;display:flex;align-items:center;justify-content:center;margin:0 auto .85rem;color:var(--emerald);}
    .pt-empty h5{font-size:.92rem;font-weight:600;color:var(--text);margin:0 0 .35rem;}
    .pt-empty p{font-size:.81rem;color:var(--muted);margin:0 0 1rem;}
    /* Modals */
    .pt-modal .modal-content{border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 8px 32px rgba(0,0,0,.12);overflow:hidden;}
    .pt-modal .modal-header{background:var(--surface);border-bottom:1px solid var(--border);padding:1rem 1.4rem;display:flex;align-items:center;gap:.75rem;}
    .pt-modal-icon{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .pt-modal-icon.green{background:#d1fae5;color:var(--emerald);}
    .pt-modal-icon.danger{background:#fef2f2;color:var(--danger);}
    .pt-modal .modal-title{font-size:.92rem;font-weight:700;color:var(--text);margin:0;}
    .pt-modal .modal-body{padding:1.4rem;display:flex;flex-direction:column;gap:1rem;}
    .pt-modal .modal-footer{padding:.85rem 1.4rem;border-top:1px solid var(--border);gap:.5rem;}
    /* Form */
    .pt-label{display:block;font-size:.77rem;font-weight:600;letter-spacing:.03em;color:var(--text-dim);text-transform:uppercase;margin-bottom:.45rem;}
    .pt-label .req{color:var(--danger);margin-left:.2rem;}
    .pt-input{width:100%;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.875rem;color:var(--text);background:#fff;outline:none;font-family:inherit;transition:border-color .2s,box-shadow .2s;}
    .pt-input:focus{border-color:var(--emerald);box-shadow:0 0 0 3px rgba(5,150,105,.1);}
    /* File upload */
    .pt-file-zone{border:2px dashed var(--border);border-radius:8px;padding:1.1rem;text-align:center;cursor:pointer;transition:border-color .2s,background .2s;position:relative;background:var(--surface);}
    .pt-file-zone:hover{border-color:var(--emerald);background:#d1fae508;}
    .pt-file-zone input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
    .pt-file-zone p{font-size:.8rem;color:var(--muted);margin:0 0 .15rem;font-weight:500;color:var(--text-dim);}
    .pt-file-zone small{font-size:.72rem;color:var(--muted);}
    /* Current image preview */
    .pt-current-img{display:flex;align-items:center;gap:.75rem;padding:.75rem .9rem;border-radius:8px;border:1px solid var(--border);background:var(--surface);}
    .pt-current-img img{width:52px;height:36px;object-fit:contain;border-radius:4px;border:1px solid var(--border);background:#fff;padding:2px;}
    .pt-current-img-info strong{display:block;font-size:.83rem;color:var(--text);}
    .pt-current-img-info span{font-size:.73rem;color:var(--muted);}
    /* Delete box */
    .pt-delete-box{font-size:.87rem;color:var(--text-dim);line-height:1.6;padding:.85rem 1rem;border-radius:8px;border:1px solid #fecaca;background:#fef2f2;}
    .pt-delete-box strong{color:var(--text);}
    /* Footer */
    .pt-footer{padding:.75rem 1.4rem;border-top:1px solid var(--border);font-size:.78rem;color:var(--muted);}
    .pt-footer strong{color:var(--text-dim);}
</style>

<div class="pt-page">

    {{-- Top bar --}}
    <div class="pt-topbar">
        <div>
            <h4>Partners</h4>
            <p>Manage partner logos and website links.</p>
        </div>
        <button class="pt-btn pt-btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Add Partner
        </button>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="pt-alert pt-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="pt-alert pt-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="pt-stats">
        <div class="pt-stat">
            <div class="pt-stat-val">{{ $partners->count() }}</div>
            <div class="pt-stat-label">Total Partners</div>
        </div>
        <div class="pt-stat" style="--bc:var(--accent)">
            <div class="pt-stat-val">{{ $partners->filter(fn($p)=>$p->link)->count() }}</div>
            <div class="pt-stat-label">With Links</div>
        </div>
    </div>

    {{-- Table card --}}
    <div class="pt-card">
        <div class="pt-card-toolbar">
            <div class="pt-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--emerald)"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                All Partners
            </div>
            <div class="pt-search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" id="ptSearch" class="pt-search" placeholder="Search name…" oninput="filterPartners()">
            </div>
        </div>

        <div style="overflow-x:auto">
            <table class="pt-table">
                <thead>
                    <tr>
                        <th style="width:52px">#</th>
                        <th>Partner</th>
                        <th>Website Link</th>
                        <th style="width:90px;text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody id="ptBody">
                    @forelse($partners as $partner)
                        <tr data-name="{{ strtolower($partner->name) }}">
                            <td><div class="pt-idx">{{ $loop->iteration }}</div></td>
                            <td>
                                <div class="pt-partner-cell">
                                    @if($partner->image)
                                        <img src="{{ asset('image/partners/') }}/{{ $partner->image }}"
                                             alt="{{ $partner->name }}" class="pt-logo">
                                    @else
                                        <div class="pt-logo-placeholder">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                        </div>
                                    @endif
                                    <span class="pt-partner-name">{{ $partner->name }}</span>
                                </div>
                            </td>
                            <td>
                                @if($partner->link)
                                    <a href="{{ $partner->link }}" target="_blank" class="pt-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                                        {{ $partner->link }}
                                    </a>
                                @else
                                    <span class="pt-no-link">No link</span>
                                @endif
                            </td>
                            <td>
                                <div class="pt-actions">
                                    <button class="pt-icon-btn" title="Edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $partner->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <button class="pt-icon-btn danger" title="Delete"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $partner->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="pt-empty">
                                    <div class="pt-empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    </div>
                                    <h5>No partners yet</h5>
                                    <p>Add your first partner logo and link.</p>
                                    <button class="pt-btn pt-btn-primary pt-btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#createModal">
                                        Add Partner
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($partners->count())
            <div class="pt-footer">
                <span id="ptCount"><strong>{{ $partners->count() }}</strong> {{ Str::plural('partner', $partners->count()) }}</span>
            </div>
        @endif
    </div>
</div>

{{-- ══ CREATE MODAL ══ --}}
<div class="modal fade pt-modal" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.partners.store') }}" method="POST"
              enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <div class="pt-modal-icon green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h5 class="modal-title">Add Partner</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div>
                    <label class="pt-label">Name <span class="req">*</span></label>
                    <input type="text" name="name" class="pt-input"
                           placeholder="e.g. Rwanda Development Board" required autofocus>
                </div>
                <div>
                    <label class="pt-label">Website Link</label>
                    <input type="url" name="link" class="pt-input"
                           placeholder="https://partner-website.com">
                </div>
                <div>
                    <label class="pt-label">Logo / Image</label>
                    <div class="pt-file-zone" id="createDropZone">
                        <input type="file" name="image" id="createFileInput"
                               accept="image/*" onchange="showCreatePreview(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--emerald);margin-bottom:.4rem"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                        <p>Click to upload logo</p>
                        <small>PNG, JPG, WEBP — max 2MB</small>
                    </div>
                    <div id="createPreviewWrap" style="display:none;margin-top:.65rem;">
                        <img id="createPreviewImg" src="" alt="Preview"
                             style="width:80px;height:52px;object-fit:contain;border:1px solid var(--border);border-radius:6px;padding:3px;background:#fff;">
                        <button type="button" onclick="clearCreate()"
                                style="margin-left:.5rem;font-size:.73rem;color:var(--danger);background:none;border:none;cursor:pointer;">
                            Remove
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="pt-btn pt-btn-ghost pt-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="pt-btn pt-btn-primary pt-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Save Partner
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ EDIT & DELETE MODALS ══ --}}
@foreach($partners as $partner)

    {{-- Edit --}}
    <div class="modal fade pt-modal" id="editModal{{ $partner->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST"
                  enctype="multipart/form-data" class="modal-content">
                @csrf @method('PUT')
                <div class="modal-header">
                    <div class="pt-modal-icon green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </div>
                    <h5 class="modal-title">Edit Partner</h5>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label class="pt-label">Name <span class="req">*</span></label>
                        <input type="text" name="name" value="{{ $partner->name }}"
                               class="pt-input" required>
                    </div>
                    <div>
                        <label class="pt-label">Website Link</label>
                        <input type="url" name="link" value="{{ $partner->link }}"
                               class="pt-input" placeholder="https://partner-website.com">
                    </div>
                    <div>
                        <label class="pt-label">Logo / Image</label>
                        @if($partner->image)
                            <div class="pt-current-img" style="margin-bottom:.65rem">
                                <img src="{{ asset('image/partners/') }}/{{ $partner->image }}"
                                     alt="{{ $partner->name }}">
                                <div class="pt-current-img-info">
                                    <strong>Current logo</strong>
                                    <span>Upload below to replace</span>
                                </div>
                            </div>
                        @endif
                        <div class="pt-file-zone">
                            <input type="file" name="image" accept="image/*"
                                   onchange="showEditPreview(this,'editPreview{{ $partner->id }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--emerald);margin-bottom:.35rem"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            <p>{{ $partner->image ? 'Replace logo' : 'Upload logo' }}</p>
                            <small>PNG, JPG, WEBP — max 2MB</small>
                        </div>
                        <div id="editPreview{{ $partner->id }}" style="display:none;margin-top:.65rem;">
                            <img src="" alt="Preview"
                                 style="width:80px;height:52px;object-fit:contain;border:1px solid var(--border);border-radius:6px;padding:3px;background:#fff;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="pt-btn pt-btn-ghost pt-btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="pt-btn pt-btn-primary pt-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete --}}
    <div class="modal fade pt-modal" id="deleteModal{{ $partner->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST"
                  class="modal-content">
                @csrf @method('DELETE')
                <div class="modal-header">
                    <div class="pt-modal-icon danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                    </div>
                    <h5 class="modal-title" style="color:var(--danger)">Remove Partner</h5>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="pt-delete-box">
                        Remove <strong>{{ $partner->name }}</strong> from the partners list? Their logo will also be deleted from storage.
                        <br><br>
                        <span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="pt-btn pt-btn-ghost pt-btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="pt-btn pt-btn-danger pt-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        Remove
                    </button>
                </div>
            </form>
        </div>
    </div>

@endforeach

<script>
/* Live search */
function filterPartners(){
    const q=document.getElementById('ptSearch').value.toLowerCase();
    const rows=document.querySelectorAll('#ptBody tr[data-name]');
    let shown=0;
    rows.forEach(r=>{
        const ok=r.dataset.name.includes(q);
        r.style.display=ok?'':'none';
        if(ok)shown++;
    });
    const el=document.getElementById('ptCount');
    if(el)el.innerHTML='<strong>'+shown+'</strong> '+(shown===1?'partner':'partners');
}

/* Create modal image preview */
function showCreatePreview(input){
    const file=input.files[0];
    if(!file)return;
    const reader=new FileReader();
    reader.onload=e=>{
        document.getElementById('createPreviewImg').src=e.target.result;
        document.getElementById('createPreviewWrap').style.display='block';
    };reader.readAsDataURL(file);
}
function clearCreate(){
    document.getElementById('createFileInput').value='';
    document.getElementById('createPreviewWrap').style.display='none';
}

/* Edit modal image preview */
function showEditPreview(input, wrapId){
    const file=input.files[0];
    if(!file)return;
    const reader=new FileReader();
    reader.onload=e=>{
        const wrap=document.getElementById(wrapId);
        wrap.querySelector('img').src=e.target.result;
        wrap.style.display='block';
    };reader.readAsDataURL(file);
}
</script>

@endsection