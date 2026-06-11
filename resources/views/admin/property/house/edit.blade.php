@extends('layouts.app')
@section('title', 'Edit House Property — ' . $house->title)
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2/dist/css/tom-select.min.css">

<style>
    :root {
        --accent:      #D05208;
        --accent-lt:   #dfc28f;
        --accent-dim:  #D0520818;
        --danger:      #dc3545;
        --success:     #198754;
        --border:      #e8e3db;
        --border-md:   #d5cec3;
        --surface:     #faf8f5;
        --surface-2:   #f3efe8;
        --muted:       #a89f92;
        --text:        #1e1a14;
        --text-dim:    #6b6259;
        --radius:      12px;
        --radius-sm:   8px;
        --shadow-card: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    }

    .hp-page { padding: 2rem 0 4rem; max-width: 1180px; margin: 0 auto; }

    /* ── Breadcrumb ── */
    .hp-breadcrumb { display:flex; align-items:center; gap:.4rem; font-size:.75rem; color:var(--muted); margin-bottom:1.5rem; }
    .hp-breadcrumb a { color:var(--muted); text-decoration:none; }
    .hp-breadcrumb a:hover { color:var(--accent); }
    .hp-breadcrumb-sep { font-size:.65rem; opacity:.5; }

    /* ── Heading ── */
    .hp-heading { display:flex; align-items:center; gap:1rem; margin-bottom:2rem; flex-wrap:wrap; }
    .hp-heading-icon {
        width:48px; height:48px; border-radius:var(--radius-sm); flex-shrink:0;
        background:linear-gradient(145deg,#D0520822,#D0520840); border:1px solid #D0520844;
        display:flex; align-items:center; justify-content:center; color:var(--accent);
    }
    .hp-heading h4 { font-size:1.25rem; font-weight:700; color:var(--text); margin:0; letter-spacing:-.01em; }
    .hp-heading p  { font-size:.82rem; color:var(--text-dim); margin:.2rem 0 0; }
    .hp-heading-meta { margin-left:auto; display:flex; align-items:center; gap:.6rem; }
    .hp-status-pill {
        display:inline-flex; align-items:center; gap:.4rem;
        padding:.3rem .85rem; border-radius:100px; font-size:.72rem; font-weight:600;
    }
    .hp-status-pill.available { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
    .hp-status-pill.reserved  { background:#fffbeb; color:#92400e; border:1px solid #fde68a; }
    .hp-status-pill.sold      { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    .hp-status-pill.rented    { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
    .hp-status-dot { width:7px; height:7px; border-radius:50%; background:currentColor; }

    /* ── Layout ── */
    .hp-layout { display:grid; grid-template-columns:1fr 300px; gap:1.25rem; align-items:start; }
    .hp-main { display:flex; flex-direction:column; gap:1.25rem; }
    .hp-side { display:flex; flex-direction:column; gap:1.25rem; position:sticky; top:80px; }

    /* ── Card ── */
    .hp-card {
        background:#fff; border:1px solid var(--border); border-radius:var(--radius);
        box-shadow:var(--shadow-card); overflow:hidden;
    }
    .hp-card-header {
        display:flex; align-items:center; gap:.8rem;
        padding:1rem 1.4rem; border-bottom:1px solid var(--border); background:var(--surface);
    }
    .hp-card-header-icon {
        width:30px; height:30px; border-radius:7px; background:#D0520818; border:1px solid #D0520828;
        display:flex; align-items:center; justify-content:center; color:var(--accent); flex-shrink:0;
    }
    .hp-card-header h6 { margin:0; font-size:.875rem; font-weight:600; color:var(--text); letter-spacing:-.005em; }
    .hp-card-body { padding:1.4rem; }

    /* ── Labels ── */
    .hp-label { display:block; font-size:.72rem; font-weight:600; letter-spacing:.06em; color:var(--text-dim); text-transform:uppercase; margin-bottom:.4rem; }
    .hp-label .req { color:var(--accent); margin-left:.15rem; }

    /* ── Controls ── */
    .hp-input, .hp-select, .hp-textarea {
        width:100%; padding:.62rem .9rem; border:1.5px solid var(--border-md); border-radius:var(--radius-sm);
        font-size:.875rem; color:var(--text); background:#fff;
        transition:border-color .18s, box-shadow .18s; outline:none; font-family:inherit;
        appearance:none; -webkit-appearance:none;
    }
    .hp-select {
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' fill='none' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23a89f92' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:right .8rem center; padding-right:2rem;
    }
    .hp-input:focus, .hp-select:focus, .hp-textarea:focus { border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-dim); }
    .hp-input.is-invalid, .hp-select.is-invalid, .hp-textarea.is-invalid { border-color:var(--danger); box-shadow:0 0 0 3px #dc354514; }
    .hp-textarea { resize:vertical; line-height:1.65; min-height:100px; }
    .hp-hint  { font-size:.73rem; color:var(--muted); margin-top:.35rem; line-height:1.5; }
    .hp-error { font-size:.73rem; color:var(--danger); margin-top:.35rem; display:flex; align-items:center; gap:.3rem; }

    /* ── Input group ── */
    .hp-input-group { display:flex; align-items:stretch; }
    .hp-input-addon {
        padding:.62rem .8rem; background:var(--surface-2); border:1.5px solid var(--border-md);
        font-size:.8rem; font-weight:600; color:var(--muted); display:flex; align-items:center; white-space:nowrap;
    }
    .hp-input-addon.prefix { border-right:none; border-radius:var(--radius-sm) 0 0 var(--radius-sm); }
    .hp-input-addon.suffix { border-left:none;  border-radius:0 var(--radius-sm) var(--radius-sm) 0; }
    .hp-input-group .hp-input.pfx { border-radius:0 var(--radius-sm) var(--radius-sm) 0; }
    .hp-input-group .hp-input.sfx { border-radius:var(--radius-sm) 0 0 var(--radius-sm); border-right:none; }

    /* ── Counter ── */
    .hp-counter {
        display:flex; align-items:center; border:1.5px solid var(--border-md);
        border-radius:var(--radius-sm); overflow:hidden; background:#fff;
        transition:border-color .18s, box-shadow .18s;
    }
    .hp-counter:focus-within { border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-dim); }
    .hp-counter-btn {
        width:38px; height:40px; border:none; background:var(--surface-2); cursor:pointer;
        display:flex; align-items:center; justify-content:center; color:var(--text-dim);
        font-size:1.15rem; flex-shrink:0; font-family:inherit; transition:background .15s, color .15s; user-select:none;
    }
    .hp-counter-btn:hover { background:#e4c99028; color:var(--accent); }
    .hp-counter input {
        flex:1; border:none; outline:none; text-align:center; font-size:.95rem;
        font-weight:700; color:var(--text); background:transparent; font-family:inherit; min-width:0; padding:0;
    }
    .hp-counter input::-webkit-inner-spin-button,
    .hp-counter input::-webkit-outer-spin-button { -webkit-appearance:none; }
    .hp-counter input[type=number] { -moz-appearance:textfield; }

    /* ── Type cards ── */
    .hp-type-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:.5rem; }
    .hp-type-radio { display:none; }
    .hp-type-label {
        display:flex; flex-direction:column; align-items:center; gap:.4rem;
        padding:.8rem .4rem; border:1.5px solid var(--border-md); border-radius:var(--radius-sm);
        cursor:pointer; transition:all .15s; font-size:.74rem; color:var(--text-dim); font-weight:500; text-align:center; background:#fff;
    }
    .hp-type-label svg { color:var(--muted); transition:color .15s; }
    .hp-type-radio:checked + .hp-type-label { border-color:var(--accent); background:#D052080d; color:#8a6830; }
    .hp-type-radio:checked + .hp-type-label svg { color:var(--accent); }

    /* ── Existing images ── */
    .hp-img-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:.6rem; margin-bottom:1rem; }
    .hp-img-item {
        position:relative; border-radius:8px; overflow:hidden; aspect-ratio:1;
        background:var(--border); transition:opacity .2s;
    }
    .hp-img-item img { width:100%; height:100%; object-fit:cover; display:block; }
    .hp-img-item.marked-delete { opacity:.3; }
    .hp-img-item.marked-delete .hp-img-del-label { opacity:1; }
    .hp-img-overlay {
        position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
        background:rgba(0,0,0,0); transition:background .2s;
    }
    .hp-img-item:hover .hp-img-overlay { background:rgba(0,0,0,.4); }
    .hp-img-del-btn {
        width:28px; height:28px; border-radius:50%; background:rgba(220,53,69,.9);
        border:none; color:#fff; cursor:pointer; display:flex; align-items:center;
        justify-content:center; opacity:0; transition:opacity .2s; font-size:11px;
    }
    .hp-img-item:hover .hp-img-del-btn { opacity:1; }
    .hp-img-item.marked-delete .hp-img-del-btn { opacity:1; background:rgba(100,116,139,.9); }
    .hp-img-cover-badge {
        position:absolute; top:4px; left:4px; background:var(--accent); color:#fff;
        font-size:.6rem; font-weight:700; padding:.15rem .5rem; border-radius:100px;
    }
    .hp-img-del-label {
        position:absolute; bottom:4px; left:50%; transform:translateX(-50%);
        background:var(--danger); color:#fff; font-size:.6rem; font-weight:700;
        padding:.15rem .5rem; border-radius:100px; white-space:nowrap; opacity:0; transition:opacity .2s;
    }

    /* ── Dropzone ── */
    .hp-dropzone {
        border:2px dashed var(--border-md); border-radius:var(--radius-sm); padding:1.6rem 1rem;
        text-align:center; cursor:pointer; transition:border-color .2s, background .2s;
        background:var(--surface); position:relative;
    }
    .hp-dropzone:hover, .hp-dropzone.dragover { border-color:var(--accent); background:#D0520807; }
    .hp-dropzone input { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
    .hp-dropzone-icon {
        width:40px; height:40px; border-radius:10px; background:#D0520818;
        display:flex; align-items:center; justify-content:center; margin:0 auto .6rem; color:var(--accent);
    }
    .hp-dropzone h6 { font-size:.84rem; font-weight:600; color:var(--text); margin:0 0 .2rem; }
    .hp-dropzone p  { font-size:.74rem; color:var(--muted); margin:0; }
    .hp-browse { color:var(--accent); font-weight:500; }
    .hp-previews { display:grid; grid-template-columns:repeat(3,1fr); gap:.45rem; margin-top:.8rem; }
    .hp-preview-item { position:relative; border-radius:var(--radius-sm); overflow:hidden; aspect-ratio:1; background:var(--border); }
    .hp-preview-item img { width:100%; height:100%; object-fit:cover; display:block; }
    .hp-preview-remove {
        position:absolute; top:3px; right:3px; width:20px; height:20px; border-radius:50%;
        background:rgba(0,0,0,.6); border:none; color:#fff; display:flex; align-items:center;
        justify-content:center; cursor:pointer; font-size:9px;
    }
    .hp-new-badge {
        position:absolute; bottom:4px; left:4px; background:#3b82f6; color:#fff;
        font-size:.58rem; font-weight:700; padding:.15rem .45rem; border-radius:100px;
    }
    .hp-preview-count { font-size:.72rem; color:var(--muted); text-align:center; margin-top:.45rem; }

    /* ── Facilities ── */
    .hp-facilities-grid { display:grid; grid-template-columns:1fr 1fr; gap:.45rem; }
    .hp-facility-item { display:none; }
    .hp-facility-label {
        display:flex; align-items:center; gap:.5rem; padding:.52rem .75rem;
        border:1.5px solid var(--border); border-radius:var(--radius-sm); font-size:.78rem;
        color:var(--text-dim); cursor:pointer; transition:all .15s; user-select:none; font-weight:400; background:#fff;
    }
    .hp-facility-label svg { color:var(--muted); flex-shrink:0; transition:color .15s; }
    .hp-facility-item:checked + .hp-facility-label { border-color:var(--accent); background:#D052080d; color:#8a6830; font-weight:500; }
    .hp-facility-item:checked + .hp-facility-label svg { color:var(--accent); }
    .hp-facility-check {
        width:16px; height:16px; border-radius:4px; border:1.5px solid var(--border-md);
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
        transition:all .15s; margin-left:auto; background:#fff;
    }
    .hp-facility-item:checked + .hp-facility-label .hp-facility-check { background:var(--accent); border-color:var(--accent); }

    /* ── Alerts ── */
    .hp-alert { border-radius:var(--radius-sm); padding:.9rem 1.1rem; font-size:.84rem; display:flex; gap:.6rem; align-items:flex-start; margin-bottom:1.25rem; }
    .hp-alert-danger  { background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; }
    .hp-alert-success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }
    .hp-alert ul { margin:.35rem 0 0 1rem; padding:0; }
    .hp-alert li { margin-bottom:.2rem; }

    /* ── Listing package ── */
    .hp-pkg-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }

    /* ── Submit bar ── */
    .hp-submit-bar {
        display:flex; align-items:center; justify-content:space-between; gap:.6rem;
        padding:1rem 1.4rem; background:#fff; border:1px solid var(--border);
        border-radius:var(--radius); box-shadow:var(--shadow-card);
    }
    .hp-submit-bar-left { font-size:.78rem; color:var(--muted); display:flex; align-items:center; gap:.4rem; }
    .hp-submit-bar-right { display:flex; gap:.6rem; }

    /* ── Buttons ── */
    .hp-btn {
        display:inline-flex; align-items:center; gap:.45rem; padding:.62rem 1.35rem;
        border-radius:var(--radius-sm); font-size:.84rem; font-weight:600; border:none;
        cursor:pointer; transition:all .18s; text-decoration:none; font-family:inherit; letter-spacing:-.005em;
    }
    .hp-btn-primary { background:var(--accent); color:#fff; }
    .hp-btn-primary:hover { background:#b8943e; color:#fff; transform:translateY(-1px); box-shadow:0 4px 12px #D0520844; }
    .hp-btn-ghost { background:none; border:1.5px solid var(--border-md); color:var(--text-dim); }
    .hp-btn-ghost:hover { border-color:var(--accent); color:var(--accent); background:var(--accent-dim); }

    /* ── Client preview card ── */
    .client-preview {
        display:none; margin-top:.8rem; padding:.9rem 1rem;
        background:#fdf8f0; border:1.5px solid #e4c99055; border-radius:var(--radius-sm);
        gap:.85rem; align-items:flex-start;
    }
    .client-preview.visible { display:flex; }
    .cp-avatar {
        width:38px; height:38px; border-radius:50%; flex-shrink:0;
        background:linear-gradient(135deg, var(--accent), var(--accent-lt));
        color:#fff; font-size:.9rem; font-weight:800;
        display:flex; align-items:center; justify-content:center; text-transform:uppercase;
    }
    .cp-body { flex:1; min-width:0; }
    .cp-name { font-size:.88rem; font-weight:700; color:var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .cp-meta { font-size:.75rem; color:var(--text-dim); margin-top:3px; line-height:1.5; }
    .cp-type-badge { display:inline-block; padding:2px 8px; border-radius:999px; font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; margin-top:5px; }
    .cp-btn-clear { background:none; border:1.5px solid var(--border-md); border-radius:6px; padding:4px 10px; font-size:.73rem; font-weight:600; color:var(--text-dim); cursor:pointer; transition:all .15s; white-space:nowrap; flex-shrink:0; }
    .cp-btn-clear:hover { border-color:var(--danger); color:var(--danger); }
    .client-new-trigger { display:inline-flex; align-items:center; gap:.4rem; font-size:.77rem; font-weight:600; color:var(--accent); cursor:pointer; background:none; border:none; padding:0; margin-top:.65rem; font-family:inherit; transition:opacity .15s; }
    .client-new-trigger:hover { opacity:.7; }

    /* ── Quick-add modal ── */
    .qa-overlay { position:fixed; inset:0; z-index:10000; background:rgba(15,20,30,.45); backdrop-filter:blur(5px) saturate(.85); display:flex; align-items:center; justify-content:center; padding:1rem; opacity:0; pointer-events:none; transition:opacity .22s; }
    .qa-overlay.open { opacity:1; pointer-events:all; }
    .qa-modal { background:#fff; border-radius:14px; box-shadow:0 32px 80px rgba(0,0,0,.18),0 2px 8px rgba(0,0,0,.06); width:100%; max-width:520px; max-height:90dvh; overflow-y:auto; transform:translateY(18px) scale(.97); transition:transform .26s cubic-bezier(.22,1,.36,1); }
    .qa-overlay.open .qa-modal { transform:translateY(0) scale(1); }
    .qa-modal-head { display:flex; align-items:center; justify-content:space-between; padding:1.1rem 1.4rem .95rem; border-bottom:1px solid var(--border); position:sticky; top:0; background:#fff; z-index:2; }
    .qa-modal-head h5 { font-size:.92rem; font-weight:700; color:var(--text); margin:0; display:flex; align-items:center; gap:.5rem; }
    .qa-modal-head h5 .qa-icon { width:27px; height:27px; border-radius:7px; flex-shrink:0; background:linear-gradient(135deg,#D0520822,#D0520840); border:1px solid #D0520844; color:var(--accent); display:flex; align-items:center; justify-content:center; }
    .qa-close { width:28px; height:28px; border-radius:7px; border:1.5px solid var(--border-md); background:none; color:var(--text-dim); cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:.78rem; transition:all .15s; }
    .qa-close:hover { border-color:var(--danger); color:var(--danger); background:#fef2f2; }
    .qa-modal-body { padding:1.2rem 1.4rem 1rem; }
    .qa-modal-footer { display:flex; align-items:center; justify-content:flex-end; gap:.5rem; padding:.85rem 1.4rem 1.1rem; border-top:1px solid var(--border); position:sticky; bottom:0; background:#fff; z-index:2; }
    .qa-row { display:grid; grid-template-columns:1fr 1fr; gap:.85rem; margin-bottom:.85rem; }
    .qa-row.full { grid-template-columns:1fr; }
    .qa-field-error { font-size:.72rem; color:var(--danger); margin-top:.3rem; display:none; }
    .qa-field-error.show { display:block; }
    .qa-spinner { width:14px; height:14px; flex-shrink:0; border:2px solid rgba(255,255,255,.3); border-top-color:#fff; border-radius:50%; animation:qa-spin .6s linear infinite; display:none; }
    @keyframes qa-spin { to { transform:rotate(360deg); } }
    .qa-saving .qa-spinner  { display:block; }
    .qa-saving .qa-save-label { display:none; }

    /* ── Tom Select gold theme ── */
    .ts-wrapper.single .ts-control,
    .ts-wrapper .ts-control { border:1.5px solid var(--border-md) !important; border-radius:var(--radius-sm) !important; padding:.6rem .9rem !important; font-size:.875rem !important; color:var(--text) !important; background:#fff !important; box-shadow:none !important; min-height:unset !important; line-height:1.5 !important; }
    .ts-wrapper.focus .ts-control, .ts-wrapper.single.focus .ts-control { border-color:var(--accent) !important; box-shadow:0 0 0 3px var(--accent-dim) !important; outline:none !important; }
    .ts-wrapper .ts-control input { color:var(--text) !important; font-size:.875rem !important; line-height:1.5 !important; height:auto !important; }
    .ts-wrapper.single .ts-control::after { display:none !important; }
    .ts-wrapper .ts-dropdown { border:1.5px solid var(--border-md) !important; border-radius:var(--radius-sm) !important; box-shadow:0 8px 28px rgba(0,0,0,.1) !important; margin-top:4px !important; font-size:.875rem !important; overflow:hidden !important; }
    .ts-wrapper .ts-dropdown .ts-dropdown-content { max-height:220px; overflow-y:auto; }
    .ts-wrapper .ts-dropdown .option { padding:10px 14px !important; cursor:pointer; }
    .ts-wrapper .ts-dropdown .option.active,
    .ts-wrapper .ts-dropdown .option:hover { background:#D0520810 !important; color:var(--text) !important; }
    .ts-wrapper .ts-dropdown .option.selected { font-weight:600; }
    .ts-wrapper .ts-dropdown .create { color:var(--accent) !important; font-weight:600; }
    .ts-opt-name { font-weight:600; font-size:.84rem; color:var(--text); }
    .ts-opt-sub  { font-size:.74rem; color:var(--muted); margin-top:2px; }
    .ts-opt-badge { display:inline-block; padding:1px 7px; border-radius:999px; font-size:.66rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; margin-left:5px; vertical-align:middle; }
    .ts-no-results-row { padding:11px 14px; font-size:.82rem; color:var(--muted); display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
    .ts-register-link { background:none; border:none; color:var(--accent); font-weight:600; font-size:.82rem; cursor:pointer; padding:0; font-family:inherit; text-decoration:underline; text-decoration-style:dotted; }
    .ts-register-link:hover { color:var(--accent-lt); }

    /* ── Responsive ── */
    @media(max-width:960px) {
        .hp-layout { grid-template-columns:1fr; }
        .hp-side { position:static; }
        .hp-type-grid { grid-template-columns:repeat(4,1fr); }
    }
    @media(max-width:600px) {
        .hp-type-grid { grid-template-columns:repeat(2,1fr); }
        .hp-facilities-grid { grid-template-columns:1fr; }
        .hp-pkg-row { grid-template-columns:1fr; }
        .qa-row { grid-template-columns:1fr; }
    }
</style>

{{-- ── QUICK-ADD MODAL ── --}}
<div class="qa-overlay" id="qaOverlay">
    <div class="qa-modal" role="dialog" aria-modal="true" aria-labelledby="qaTitle">
        <div class="qa-modal-head">
            <h5 id="qaTitle">
                <span class="qa-icon">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </span>
                Register New Client
            </h5>
            <button class="qa-close" id="qaCloseBtn" aria-label="Close">✕</button>
        </div>
        <div class="qa-modal-body">
            <div id="qaServerError" class="hp-alert hp-alert-danger" style="display:none; margin-bottom:.9rem;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                <span id="qaServerErrorText"></span>
            </div>
            <div class="qa-row">
                <div>
                    <label class="hp-label">Full Name <span class="req">*</span></label>
                    <input type="text" id="qa_full_name" class="hp-input" placeholder="e.g. Jean Paul Nkurunziza" autocomplete="off">
                    <p class="qa-field-error" id="qaErr_full_name"></p>
                </div>
                <div>
                    <label class="hp-label">Client Type <span class="req">*</span></label>
                    <select id="qa_client_type" class="hp-select">
                        <option value="owner">Owner</option>
                        <option value="agent">Agent</option>
                        <option value="developer">Developer</option>
                        <option value="company">Company</option>
                    </select>
                </div>
            </div>
            <div class="qa-row">
                <div>
                    <label class="hp-label">Phone <span class="req">*</span></label>
                    <input type="tel" id="qa_phone" class="hp-input" placeholder="+250 7xx xxx xxx" autocomplete="off">
                    <p class="qa-field-error" id="qaErr_phone"></p>
                </div>
                <div>
                    <label class="hp-label">Email</label>
                    <input type="email" id="qa_email" class="hp-input" placeholder="optional" autocomplete="off">
                    <p class="qa-field-error" id="qaErr_email"></p>
                </div>
            </div>
            <div class="qa-row full" id="qaCompanyRow" style="display:none;">
                <div>
                    <label class="hp-label">Company / Organization</label>
                    <input type="text" id="qa_company_name" class="hp-input" placeholder="e.g. Kigali Developers Ltd" autocomplete="off">
                </div>
            </div>
            <div class="qa-row full" style="margin-bottom:0;">
                <div>
                    <label class="hp-label">National ID (NID)</label>
                    <input type="text" id="qa_national_id" class="hp-input" placeholder="16-digit Rwanda NID — optional" autocomplete="off">
                    <p class="qa-field-error" id="qaErr_national_id"></p>
                </div>
            </div>
        </div>
        <div class="qa-modal-footer">
            <button type="button" class="hp-btn hp-btn-ghost" id="qaCancelBtn">Cancel</button>
            <button type="button" class="hp-btn hp-btn-primary" id="qaSaveBtn">
                <span class="qa-spinner" id="qaSpinner"></span>
                <span class="qa-save-label">Save &amp; Select →</span>
            </button>
        </div>
    </div>
</div>

<div class="hp-page">

    {{-- ── Breadcrumb ── --}}
    <div class="hp-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="hp-breadcrumb-sep">›</span>
        <a href="{{ route('admin.properties.houses.index') }}">Houses</a>
        <span class="hp-breadcrumb-sep">›</span>
        <a href="{{ route('admin.properties.houses.show', $house->id) }}">{{ Str::limit($house->title, 40) }}</a>
        <span class="hp-breadcrumb-sep">›</span>
        <span>Edit</span>
    </div>

    {{-- ── Heading ── --}}
    <div class="hp-heading">
        <div class="hp-heading-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
        </div>
        <div>
            <h4>Edit House Property</h4>
            <p>{{ Str::limit($house->title, 55) }} &mdash; last updated {{ $house->updated_at->diffForHumans() }}</p>
        </div>
        <div class="hp-heading-meta">
            <span class="hp-status-pill {{ $house->status }}">
                <span class="hp-status-dot"></span>
                {{ ucfirst($house->status) }}
            </span>
            <a href="{{ route('admin.properties.houses.show', $house->id) }}" class="hp-btn hp-btn-ghost" style="padding:.4rem .9rem;font-size:.78rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Preview
            </a>
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if ($errors->any())
        <div class="hp-alert hp-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="hp-alert hp-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.properties.houses.update', $house->id) }}"
          enctype="multipart/form-data" id="houseEditForm">
        @csrf
        @method('PUT')

        <div class="hp-layout">

            {{-- ══ MAIN COLUMN ══ --}}
            <div class="hp-main">

                {{-- ── Property Details ── --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-header-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <h6>Property Details</h6>
                    </div>
                    <div class="hp-card-body">
                        <div class="row g-4">

                            <div class="col-md-7">
                                <label class="hp-label">Property Title <span class="req">*</span></label>
                                <input type="text" name="title"
                                       class="hp-input @error('title') is-invalid @enderror"
                                       value="{{ old('title', $house->title) }}"
                                       placeholder="e.g. Modern Family Home in Kigali Heights" required>
                                @error('title')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-5">
                                <label class="hp-label">Property UPI</label>
                                <input type="text" name="upi"
                                       class="hp-input @error('upi') is-invalid @enderror"
                                       value="{{ old('upi', $house->upi) }}"
                                       placeholder="e.g. 1/01/01/01/1234">
                                @error('upi')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            {{-- Property Type ── visual cards --}}
                            <div class="col-12">
                                <label class="hp-label">Property Type <span class="req">*</span></label>
                                <div class="hp-type-grid">
                                    @php
                                        $types = [
                                            'house'     => ['label' => 'House',     'icon' => '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>'],
                                            'apartment' => ['label' => 'Apartment', 'icon' => '<rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M12 6h.01M12 10h.01M8 10h.01M16 10h.01M12 14h.01M8 14h.01M16 14h.01"/>'],
                                            'villa'     => ['label' => 'Villa',     'icon' => '<path d="M2 20h20M4 20V10l8-6 8 6v10"/><path d="M10 20v-5h4v5"/>'],
                                            'townhouse' => ['label' => 'Townhouse', 'icon' => '<path d="M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z"/><path d="M9 21V12h6v9"/>'],
                                        ];
                                    @endphp
                                    @foreach($types as $val => $meta)
                                        <input type="radio" name="type" id="type_{{ $val }}" value="{{ $val }}"
                                               class="hp-type-radio"
                                               {{ old('type', $house->type) === $val ? 'checked' : '' }} required>
                                        <label for="type_{{ $val }}" class="hp-type-label">
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">{!! $meta['icon'] !!}</svg>
                                            {{ $meta['label'] }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('type')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-4">
                                <label class="hp-label">Condition <span class="req">*</span></label>
                                <select name="condition" class="hp-select @error('condition') is-invalid @enderror" required>
                                    <option value="">Select condition</option>
                                    <option value="for_sale" {{ old('condition', $house->condition) === 'for_sale' ? 'selected' : '' }}>For Sale</option>
                                    <option value="for_rent" {{ old('condition', $house->condition) === 'for_rent'  ? 'selected' : '' }}>For Rent</option>
                                </select>
                                @error('condition')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-4">
                                <label class="hp-label">Negotiable</label>
                                <select name="negotiable" class="hp-select @error('negotiable') is-invalid @enderror">
                                    <option value="">Select</option>
                                    <option value="negotiable"     {{ old('negotiable', $house->negotiable) === 'negotiable'     ? 'selected' : '' }}>Negotiable</option>
                                    <option value="non_negotiable" {{ old('negotiable', $house->negotiable) === 'non_negotiable' ? 'selected' : '' }}>Non Negotiable</option>
                                </select>
                                @error('negotiable')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-4">
                                <label class="hp-label">Area</label>
                                <div class="hp-input-group">
                                    <input type="number" name="area_sqft"
                                           class="hp-input sfx @error('area_sqft') is-invalid @enderror"
                                           value="{{ old('area_sqft', $house->area_sqft) }}"
                                           placeholder="0" min="1">
                                    <span class="hp-input-addon suffix">sq ft</span>
                                </div>
                                @error('area_sqft')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="hp-label">Price <span class="req">*</span></label>
                                <input type="number" name="price"
                                       class="hp-input @error('price') is-invalid @enderror"
                                       value="{{ old('price', $house->price) }}"
                                       placeholder="0" min="0" step="1" required>
                                @error('price')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="hp-label">Currency <span class="req">*</span></label>
                                <select name="currency" class="hp-select @error('currency') is-invalid @enderror" required>
                                    <option value="">Select currency</option>
                                    <option value="RWF" {{ old('currency', $house->currency) === 'RWF' ? 'selected' : '' }}>Rwandan Franc (RWF)</option>
                                    <option value="USD" {{ old('currency', $house->currency) === 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                                </select>
                                @error('currency')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-4">
                                <label class="hp-label">Bedrooms <span class="req">*</span></label>
                                <div class="hp-counter">
                                    <button type="button" class="hp-counter-btn" onclick="stepCounter('bedrooms',-1)">−</button>
                                    <input type="number" name="bedrooms" id="bedrooms" value="{{ old('bedrooms', $house->bedrooms) }}" min="0" max="20" required>
                                    <button type="button" class="hp-counter-btn" onclick="stepCounter('bedrooms',1)">+</button>
                                </div>
                                @error('bedrooms')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-4">
                                <label class="hp-label">Bathrooms <span class="req">*</span></label>
                                <div class="hp-counter">
                                    <button type="button" class="hp-counter-btn" onclick="stepCounter('bathrooms',-1)">−</button>
                                    <input type="number" name="bathrooms" id="bathrooms" value="{{ old('bathrooms', $house->bathrooms) }}" min="0" max="20" required>
                                    <button type="button" class="hp-counter-btn" onclick="stepCounter('bathrooms',1)">+</button>
                                </div>
                                @error('bathrooms')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-4">
                                <label class="hp-label">Garages</label>
                                <div class="hp-counter">
                                    <button type="button" class="hp-counter-btn" onclick="stepCounter('garages',-1)">−</button>
                                    <input type="number" name="garages" id="garages" value="{{ old('garages', $house->garages) }}" min="0" max="10">
                                    <button type="button" class="hp-counter-btn" onclick="stepCounter('garages',1)">+</button>
                                </div>
                                @error('garages')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="hp-label">Status <span class="req">*</span></label>
                                <select name="status" class="hp-select @error('status') is-invalid @enderror" required>
                                    <option value="available" {{ old('status', $house->status) === 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="sold"      {{ old('status', $house->status) === 'sold'      ? 'selected' : '' }}>Sold</option>
                                    <option value="reserved"  {{ old('status', $house->status) === 'reserved'  ? 'selected' : '' }}>Reserved</option>
                                    <option value="rented"    {{ old('status', $house->status) === 'rented'    ? 'selected' : '' }}>Rented</option>
                                </select>
                                @error('status')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-12">
                                <label class="hp-label">Description</label>
                                <textarea name="description" rows="4"
                                          class="hp-textarea @error('description') is-invalid @enderror"
                                          placeholder="Describe the property — finishes, views, nearby amenities…">{{ old('description', $house->description) }}</textarea>
                                @error('description')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── Location ── --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-header-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <h6>Location Details</h6>
                    </div>
                    <div class="hp-card-body">
                        @include('includes.form')
                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="hp-label">Latitude</label>
                                <input type="text" name="latitude"
                                       class="hp-input @error('latitude') is-invalid @enderror"
                                       value="{{ old('latitude', $house->latitude) }}" placeholder="-1.9706">
                                @error('latitude')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="hp-label">Longitude</label>
                                <input type="text" name="longitude"
                                       class="hp-input @error('longitude') is-invalid @enderror"
                                       value="{{ old('longitude', $house->longitude) }}" placeholder="30.1044">
                                @error('longitude')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Listing Package ── --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-header-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="20" height="14" x="2" y="5" rx="2"/><path d="M2 10h20"/>
                            </svg>
                        </div>
                        <h6>Listing Package</h6>
                    </div>
                    <div class="hp-card-body">
                        <div class="hp-pkg-row">
                            <div>
                                <label class="hp-label">Package <span class="req">*</span></label>
                                <select name="listing_package_id"
                                        class="hp-select @error('listing_package_id') is-invalid @enderror"
                                        onchange="recalcFee()" required>
                                    <option value="">Select a package</option>
                                    @foreach($packages as $pkg)
                                    <option value="{{ $pkg->id }}"
                                        data-price="{{ $pkg->price_per_day }}"
                                        data-agent-pct="{{ $pkg->agent_commission_pct }}"
                                        data-terra-pct="{{ $pkg->terra_share_pct }}"
                                        {{ old('listing_package_id', $house->listing_package_id) == $pkg->id ? 'selected' : '' }}>
                                        {{ $pkg->listing_type }} – {{ ucfirst($pkg->package_tier) }}
                                        · RWF {{ number_format($pkg->price_per_day) }}/day
                                        (you earn {{ $pkg->agent_commission_pct }}%)
                                    </option>
                                    @endforeach
                                </select>
                                @error('listing_package_id')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="hp-label">Duration (days) <span class="req">*</span></label>
                                <input type="number" name="listing_days"
                                       class="hp-input @error('listing_days') is-invalid @enderror"
                                       value="{{ old('listing_days', $house->listing_days ?? 30) }}"
                                       min="1" oninput="recalcFee()" required>
                                <p class="hp-hint">31–59 days: 10% off · 61–89 days: 15% off · 90+ days: 20% off</p>
                                @error('listing_days')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Property Owner ── --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-header-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <h6>Property Owner</h6>
                    </div>
                    <div class="hp-card-body">
                        <input type="hidden" name="client_id" id="clientIdField" value="{{ old('client_id', $house->client_id) }}">

                        <label class="hp-label">Search Client <span class="req">*</span></label>
                        <p class="hp-hint" style="margin-bottom:.6rem;">Type a name, phone, or email to find a registered client.</p>

                        <select id="clientSearch" autocomplete="off"></select>

                        @error('client_id')
                        <p class="hp-error" style="margin-top:.45rem;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                            {{ $message }}
                        </p>
                        @enderror

                        <div class="client-preview" id="clientPreview">
                            <div class="cp-avatar" id="cpAvatar">?</div>
                            <div class="cp-body">
                                <div class="cp-name" id="cpName"></div>
                                <div class="cp-meta" id="cpMeta"></div>
                                <span class="cp-type-badge" id="cpBadge"></span>
                            </div>
                            <button type="button" class="cp-btn-clear" id="cpClearBtn">✕ Clear</button>
                        </div>

                        <button type="button" class="client-new-trigger" id="openQaBtn">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/>
                            </svg>
                            Client not found? Register new client
                        </button>
                    </div>
                </div>

                {{-- ── Submit bar ── --}}
                <div class="hp-submit-bar">
                    <div class="hp-submit-bar-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Last saved {{ $house->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                    <div class="hp-submit-bar-right">
                        <a href="{{ route('admin.properties.houses.show', $house->id) }}" class="hp-btn hp-btn-ghost">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                            Cancel
                        </a>
                        <button type="submit" class="hp-btn hp-btn-primary">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>

            </div>{{-- /.hp-main --}}

            {{-- ══ SIDEBAR ══ --}}
            <div class="hp-side">

                {{-- ── Photos ── --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-header-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="18" height="18" x="3" y="3" rx="2"/>
                                <circle cx="9" cy="9" r="2"/>
                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                            </svg>
                        </div>
                        <h6>Photos</h6>
                    </div>
                    <div class="hp-card-body">

                        {{-- Existing images --}}
                        @if($house->images && $house->images->count())
                            <p style="font-size:.73rem;font-weight:600;letter-spacing:.04em;text-transform:uppercase;color:var(--muted);margin-bottom:.6rem;">
                                Current ({{ $house->images->count() }})
                            </p>
                            <div class="hp-img-grid" id="existingGrid">
                                @foreach($house->images as $i => $image)
                                    <div class="hp-img-item" id="img-item-{{ $image->id }}">
                                        <img src="{{ asset('image/houses/' . $image->image_path) }}" alt="Photo {{ $i + 1 }}">
                                        @if($i === 0)
                                            <span class="hp-img-cover-badge">Cover</span>
                                        @endif
                                        <span class="hp-img-del-label">Remove</span>
                                        <div class="hp-img-overlay">
                                            <button type="button" class="hp-img-del-btn"
                                                    onclick="toggleDelImg({{ $image->id }}, this)"
                                                    title="Mark for removal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                        <input type="checkbox" name="delete_images[]"
                                               value="{{ $image->id }}" id="del-{{ $image->id }}"
                                               style="display:none">
                                    </div>
                                @endforeach
                            </div>
                            <p class="hp-hint" style="margin-bottom:1rem;">Click × to mark a photo for removal.</p>
                        @else
                            <div style="text-align:center;padding:1rem;border:1px dashed var(--border);border-radius:8px;color:var(--muted);font-size:.8rem;margin-bottom:1rem;">
                                No photos yet.
                            </div>
                        @endif

                        {{-- Add new --}}
                        <p style="font-size:.73rem;font-weight:600;letter-spacing:.04em;text-transform:uppercase;color:var(--muted);margin-bottom:.6rem;">
                            Add New
                        </p>
                        <div class="hp-dropzone" id="imgDropzone">
                            <input type="file" name="images[]" id="imgInput" accept="image/*" multiple>
                            <div class="hp-dropzone-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" x2="12" y1="3" y2="15"/>
                                </svg>
                            </div>
                            <h6>Drop photos here</h6>
                            <p>or <span class="hp-browse">browse</span> — JPG, PNG, WEBP</p>
                        </div>
                        <div class="hp-previews" id="imgPreviews"></div>
                        <p class="hp-preview-count" id="imgCount"></p>
                        @error('images.*')<p class="hp-error">{{ $message }}</p>@enderror

                    </div>
                </div>

                {{-- ── Video URL ── --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-header-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="5 3 19 12 5 21 5 3"/>
                            </svg>
                        </div>
                        <h6>Video URL</h6>
                    </div>
                    <div class="hp-card-body">
                        <input type="url" name="video_url"
                               class="hp-input @error('video_url') is-invalid @enderror"
                               placeholder="https://youtube.com/watch?v=…"
                               value="{{ old('video_url', $house->video_url) }}">
                        @error('video_url')<p class="hp-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Facilities ── --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-header-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/>
                                <path d="M7 7h.01"/>
                            </svg>
                        </div>
                        <h6>Facilities</h6>
                    </div>
                    <div class="hp-card-body" style="padding-top:1rem;">
                        @php
                            $currentFacilities = old('facilities', $house->facilities->pluck('id')->toArray());
                        @endphp
                        <div class="hp-facilities-grid">
                            @foreach($facilities as $facility)
                                <input type="checkbox" name="facilities[]"
                                       id="fac_{{ $facility->id }}" value="{{ $facility->id }}"
                                       class="hp-facility-item"
                                       {{ in_array($facility->id, $currentFacilities) ? 'checked' : '' }}>
                                <label for="fac_{{ $facility->id }}" class="hp-facility-label">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
                                    {{ $facility->name }}
                                    <span class="hp-facility-check">
                                        <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('facilities')<p class="hp-error" style="margin-top:.75rem">{{ $message }}</p>@enderror
                    </div>
                </div>

            </div>{{-- /.hp-side --}}

        </div>{{-- /.hp-layout --}}
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2/dist/js/tom-select.complete.min.js"></script>

<script>
(function () {
    'use strict';

    /* ── Counter ── */
    window.stepCounter = function (id, delta) {
        const el = document.getElementById(id);
        const min = parseInt(el.min ?? 0);
        const max = parseInt(el.max ?? 999);
        el.value = Math.min(max, Math.max(min, (parseInt(el.value) || 0) + delta));
    };

    /* ── Image previews ── */
    const imgInput    = document.getElementById('imgInput');
    const imgPreviews = document.getElementById('imgPreviews');
    const imgDropzone = document.getElementById('imgDropzone');
    const imgCount    = document.getElementById('imgCount');
    let selectedFiles = [];

    imgInput.addEventListener('change', () => addFiles(imgInput.files));
    imgDropzone.addEventListener('dragover',  e => { e.preventDefault(); imgDropzone.classList.add('dragover'); });
    imgDropzone.addEventListener('dragleave', ()  => imgDropzone.classList.remove('dragover'));
    imgDropzone.addEventListener('drop', e => {
        e.preventDefault();
        imgDropzone.classList.remove('dragover');
        addFiles(e.dataTransfer.files);
    });

    function addFiles(files) {
        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            selectedFiles.push(file);
            const r = new FileReader();
            r.onload = e => renderPreview(e.target.result, selectedFiles.length - 1);
            r.readAsDataURL(file);
        });
        syncInput();
    }

    function renderPreview(src, idx) {
        const d = document.createElement('div');
        d.className = 'hp-preview-item';
        d.dataset.idx = idx;
        d.innerHTML = `<img src="${src}" alt=""><button type="button" class="hp-preview-remove" onclick="removePreview(${idx})">✕</button><span class="hp-new-badge">New</span>`;
        imgPreviews.appendChild(d);
        updateCount();
    }

    window.removePreview = function (idx) {
        selectedFiles[idx] = null;
        document.querySelector(`.hp-preview-item[data-idx="${idx}"]`)?.remove();
        syncInput();
        updateCount();
    };

    function syncInput() {
        const dt = new DataTransfer();
        selectedFiles.filter(Boolean).forEach(f => dt.items.add(f));
        imgInput.files = dt.files;
    }

    function updateCount() {
        const n = selectedFiles.filter(Boolean).length;
        imgCount.textContent = n ? `${n} new photo${n > 1 ? 's' : ''} queued` : '';
    }

    /* ── Mark existing image for deletion ── */
    window.toggleDelImg = function (id, btn) {
        const item     = document.getElementById('img-item-' + id);
        const checkbox = document.getElementById('del-' + id);
        const marked   = item.classList.toggle('marked-delete');
        checkbox.checked = marked;
        btn.title = marked ? 'Undo removal' : 'Mark for removal';
    };

    /* ── Type colours for client badges ── */
    const TYPE_COLORS = {
        owner:     { bg: '#d1fae5', color: '#065f46' },
        agent:     { bg: '#dbeafe', color: '#1e40af' },
        developer: { bg: '#ede9fe', color: '#5b21b6' },
        company:   { bg: '#fef3c7', color: '#92400e' },
    };
    function ucFirst(s) { return s ? s.charAt(0).toUpperCase() + s.slice(1) : ''; }

    /* ── Client preview ── */
    function showPreview(c) {
        document.getElementById('clientIdField').value = c.id;
        document.getElementById('cpAvatar').textContent = c.full_name.charAt(0).toUpperCase();
        document.getElementById('cpName').textContent   = c.full_name;
        const parts = [];
        if (c.phone)    parts.push('📞 ' + c.phone);
        if (c.email)    parts.push('✉️ '  + c.email);
        if (c.district) parts.push('📍 '  + c.district);
        document.getElementById('cpMeta').textContent = parts.join('  ·  ');
        const tc = TYPE_COLORS[c.client_type] || { bg: '#f3f4f6', color: '#374151' };
        const badge = document.getElementById('cpBadge');
        badge.textContent       = ucFirst(c.client_type);
        badge.style.background  = tc.bg;
        badge.style.color       = tc.color;
        document.getElementById('clientPreview').classList.add('visible');
    }

    function clearClient() {
        document.getElementById('clientIdField').value = '';
        document.getElementById('clientPreview').classList.remove('visible');
        tomSelect.clear(true);
        tomSelect.focus();
    }

    /* ── Tom Select ── */
    if (window.__houseEditTS) {
        try { window.__houseEditTS.destroy(); } catch (_) {}
    }

    window.__houseEditTS = new TomSelect('#clientSearch', {
        valueField:  'id',
        labelField:  'full_name',
        searchField: ['full_name', 'phone', 'email'],
        placeholder: 'Type a name, phone, or email…',
        maxOptions:  15,
        preload:     false,
        shouldLoad:  q => q.length >= 2,

        load(query, callback) {
            fetch(`{{ route('admin.clients.search') }}?q=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => callback(data))
            .catch(() => callback());
        },

        render: {
            option(data, escape) {
                const tc = TYPE_COLORS[data.client_type] || { bg: '#f3f4f6', color: '#374151' };
                const badge = `<span class="ts-opt-badge" style="background:${tc.bg};color:${tc.color}">${ucFirst(data.client_type)}</span>`;
                const sub   = data.phone
                    ? `<div class="ts-opt-sub">${escape(data.phone)}${data.email ? ' · '+escape(data.email) : ''}</div>`
                    : '';
                return `<div><div class="ts-opt-name">${escape(data.full_name)}${badge}</div>${sub}</div>`;
            },
            item(data, escape) {
                return `<span>${escape(data.full_name)}</span>`;
            },
            no_results() {
                return `<div class="ts-no-results-row">No client found. <button type="button" class="ts-register-link" data-action="openQA">+ Register new client</button></div>`;
            },
        },

        onChange(id) {
            if (!id) { clearClient(); return; }
            const item = window.__houseEditTS.options[id];
            if (item) showPreview(item);
        },
    });

    const tomSelect = window.__houseEditTS;

    /* Delegated click for "Register new client" inside dropdown */
    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-action="openQA"]')) openQAModal();
    });

    /* Pre-load existing client on edit page load */
    (function restoreExistingClient() {
        const existingId = {!! json_encode(old('client_id', $house->client_id)) !!};
        if (!existingId) return;
        fetch(`{{ route('admin.clients.search') }}?id=${encodeURIComponent(existingId)}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (!data.length) return;
            tomSelect.addOption(data[0]);
            tomSelect.setValue(data[0].id, true);
            showPreview(data[0]);
        });
    }());

    document.getElementById('cpClearBtn').addEventListener('click', clearClient);

    /* ── Quick-add modal ── */
    const qaOverlay = document.getElementById('qaOverlay');

    function openQAModal() {
        const typed = tomSelect.lastQuery || '';
        document.getElementById('qa_full_name').value = typed;
        clearQAErrors();
        hideQAServerError();
        qaOverlay.classList.add('open');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('qa_full_name').focus(), 80);
    }

    function closeQAModal() {
        qaOverlay.classList.remove('open');
        document.body.style.overflow = '';
        const btn = document.getElementById('qaSaveBtn');
        btn.classList.remove('qa-saving');
        btn.disabled = false;
    }

    document.getElementById('openQaBtn').addEventListener('click', openQAModal);
    document.getElementById('qaCloseBtn').addEventListener('click', closeQAModal);
    document.getElementById('qaCancelBtn').addEventListener('click', closeQAModal);
    qaOverlay.addEventListener('click', e => { if (e.target === qaOverlay) closeQAModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && qaOverlay.classList.contains('open')) closeQAModal(); });

    document.getElementById('qa_client_type').addEventListener('change', function () {
        const show = this.value === 'company' || this.value === 'developer';
        document.getElementById('qaCompanyRow').style.display = show ? '' : 'none';
    });

    function clearQAErrors() {
        document.querySelectorAll('.qa-field-error').forEach(el => { el.textContent = ''; el.classList.remove('show'); });
        document.querySelectorAll('#qaOverlay .hp-input').forEach(el => el.classList.remove('is-invalid'));
    }
    function showQAFieldError(inputId, errSuffix, msg) {
        const input = document.getElementById(inputId);
        const err   = document.getElementById('qaErr_' + errSuffix);
        if (input) input.classList.add('is-invalid');
        if (err)   { err.textContent = msg; err.classList.add('show'); }
    }
    function hideQAServerError() { document.getElementById('qaServerError').style.display = 'none'; }
    function showQAServerError(msg) {
        document.getElementById('qaServerErrorText').textContent = msg;
        document.getElementById('qaServerError').style.display  = 'flex';
    }

    function validateQA() {
        clearQAErrors();
        let ok = true;
        const name  = document.getElementById('qa_full_name').value.trim();
        const phone = document.getElementById('qa_phone').value.trim();
        const email = document.getElementById('qa_email').value.trim();
        if (!name)  { showQAFieldError('qa_full_name', 'full_name', 'Full name is required.'); ok = false; }
        if (!phone) { showQAFieldError('qa_phone', 'phone', 'Phone number is required.'); ok = false; }
        else if (!/^[+\d\s\-()\/.]{7,20}$/.test(phone)) { showQAFieldError('qa_phone', 'phone', 'Enter a valid phone number.'); ok = false; }
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showQAFieldError('qa_email', 'email', 'Enter a valid email address.'); ok = false; }
        return ok;
    }

    document.getElementById('qaSaveBtn').addEventListener('click', function () {
        if (!validateQA()) return;
        this.classList.add('qa-saving');
        this.disabled = true;

        const payload = {
            full_name:    document.getElementById('qa_full_name').value.trim(),
            phone:        document.getElementById('qa_phone').value.trim(),
            email:        document.getElementById('qa_email').value.trim() || null,
            client_type:  document.getElementById('qa_client_type').value,
            company_name: document.getElementById('qa_company_name')?.value.trim() || null,
            national_id:  document.getElementById('qa_national_id').value.trim() || null,
        };

        fetch("{{ route('admin.clients.quick-add') }}", {
            method: 'POST',
            headers: {
                'Content-Type':     'application/json',
                'Accept':           'application/json',
                'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(payload),
        })
        .then(r => r.json().then(data => ({ ok: r.ok, data })))
        .then(({ ok, data }) => {
            document.getElementById('qaSaveBtn').classList.remove('qa-saving');
            document.getElementById('qaSaveBtn').disabled = false;
            if (!ok) {
                if (data.errors) {
                    const map = { full_name:'full_name', phone:'phone', email:'email', national_id:'national_id' };
                    Object.entries(data.errors).forEach(([field, msgs]) => {
                        const suffix = map[field];
                        if (suffix) showQAFieldError('qa_' + field, suffix, msgs[0]);
                        else showQAServerError(msgs[0]);
                    });
                } else {
                    showQAServerError(data.message || 'Something went wrong. Please try again.');
                }
                return;
            }
            tomSelect.addOption(data);
            tomSelect.setValue(data.id, true);
            showPreview(data);
            closeQAModal();
            ['qa_full_name','qa_phone','qa_email','qa_company_name','qa_national_id'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
            document.getElementById('qa_client_type').value = 'owner';
            document.getElementById('qaCompanyRow').style.display = 'none';
        })
        .catch(() => {
            document.getElementById('qaSaveBtn').classList.remove('qa-saving');
            document.getElementById('qaSaveBtn').disabled = false;
            showQAServerError('Network error. Check your connection and try again.');
        });
    });

}());
</script>

@endsection