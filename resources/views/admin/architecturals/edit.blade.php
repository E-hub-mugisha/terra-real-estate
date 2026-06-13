@extends('layouts.app')
@section('title', 'Edit Architectural Design')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=DM+Serif+Display&display=swap');

:root {
    --brand:       #C94E07;
    --brand-dark:  #a33e05;
    --brand-glow:  #C94E0718;
    --brand-mid:   #C94E0730;
    --ink:         #111827;
    --ink-2:       #374151;
    --ink-3:       #6B7280;
    --ink-4:       #9CA3AF;
    --line:        #E5E7EB;
    --line-strong: #D1D5DB;
    --bg:          #F9FAFB;
    --surface:     #FFFFFF;
    --danger:      #DC2626;
    --danger-bg:   #FEF2F2;
    --success:     #16A34A;
    --success-bg:  #F0FDF4;
    --r-sm:        6px;
    --r-md:        10px;
    --r-lg:        14px;
    --shadow-sm:   0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.04);
}

*, *::before, *::after { box-sizing: border-box; }

.adp-root {
    font-family: 'Inter', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    padding: 2rem 1.25rem 4rem;
    color: var(--ink);
}

/* ── Page header ── */
.adp-page-header {
    max-width: 1120px;
    margin: 0 auto 2rem;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
}

.adp-breadcrumb {
    display: flex;
    align-items: center;
    gap: .4rem;
    font-size: .72rem;
    font-weight: 500;
    color: var(--ink-3);
    margin-bottom: .5rem;
    letter-spacing: .02em;
    text-transform: uppercase;
}

.adp-breadcrumb a { color: var(--ink-3); text-decoration: none; transition: color .15s; }
.adp-breadcrumb a:hover { color: var(--brand); }
.adp-breadcrumb-sep { width: 3px; height: 3px; border-radius: 50%; background: var(--ink-4); }

.adp-page-title {
    font-family: 'DM Serif Display', serif;
    font-size: 1.7rem;
    font-weight: 400;
    color: var(--ink);
    line-height: 1.2;
    margin: 0;
}

.adp-page-sub { font-size: .82rem; color: var(--ink-3); margin: .35rem 0 0; }

.adp-header-actions { display: flex; gap: .5rem; flex-shrink: 0; padding-top: .15rem; }

/* Edit-mode badge */
.adp-edit-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .71rem;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
    padding: .25rem .7rem;
    border-radius: 100px;
    background: #FEF3C7;
    color: #92400E;
    border: 1px solid #FDE68A;
    margin-bottom: .55rem;
    width: fit-content;
}

.adp-edit-badge-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #F59E0B;
}

/* ── Layout ── */
.adp-layout {
    max-width: 1120px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 288px;
    gap: 1.25rem;
    align-items: start;
}

.adp-main { display: flex; flex-direction: column; gap: 1.25rem; }

.adp-side {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    position: sticky;
    top: 88px;
}

/* ── Card ── */
.adp-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--r-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.adp-card-head {
    display: flex;
    align-items: center;
    gap: .7rem;
    padding: .95rem 1.4rem;
    border-bottom: 1px solid var(--line);
}

.adp-card-head-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--brand); flex-shrink: 0; }

.adp-card-head h6 { margin: 0; font-size: .84rem; font-weight: 650; color: var(--ink); letter-spacing: -.01em; }

.adp-card-head-pill {
    margin-left: auto;
    background: var(--brand-glow);
    color: var(--brand);
    font-size: .67rem;
    font-weight: 700;
    padding: .18rem .55rem;
    border-radius: 100px;
    display: none;
    letter-spacing: .02em;
}

.adp-card-head-pill.show { display: inline-block; }

.adp-card-body { padding: 1.4rem; }

/* ── Alerts ── */
.adp-alert {
    max-width: 1120px;
    margin: 0 auto 1.25rem;
    border-radius: var(--r-md);
    padding: .9rem 1.2rem;
    font-size: .83rem;
    display: flex;
    gap: .65rem;
    align-items: flex-start;
}

.adp-alert-err { background: var(--danger-bg); border: 1px solid #FECACA; color: #991B1B; }
.adp-alert-ok  { background: var(--success-bg); border: 1px solid #BBF7D0; color: #14532D; }
.adp-alert ul  { margin: .3rem 0 0 1rem; padding: 0; }
.adp-alert li  { margin-bottom: .2rem; }
.adp-alert-icon{ flex-shrink: 0; margin-top: .1rem; }

/* ── Grid ── */
.adp-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem; }

/* ── Form elements ── */
.adp-field { display: flex; flex-direction: column; }

.adp-lbl {
    font-size: .71rem;
    font-weight: 600;
    letter-spacing: .05em;
    text-transform: uppercase;
    color: var(--ink-3);
    margin-bottom: .45rem;
}

.adp-lbl .req { color: var(--danger); margin-left: .15rem; }

.adp-input,
.adp-select,
.adp-textarea {
    width: 100%;
    padding: .62rem .9rem;
    border: 1.5px solid var(--line-strong);
    border-radius: var(--r-sm);
    font-size: .875rem;
    color: var(--ink);
    background: var(--surface);
    font-family: inherit;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
    appearance: none;
}

.adp-input:focus, .adp-select:focus, .adp-textarea:focus {
    border-color: var(--brand);
    box-shadow: 0 0 0 3px var(--brand-glow);
}

.adp-input.err, .adp-select.err, .adp-textarea.err {
    border-color: var(--danger);
    box-shadow: 0 0 0 3px #DC262612;
}

.adp-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2.5'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .8rem center;
    padding-right: 2.2rem;
}

.adp-textarea { resize: vertical; line-height: 1.65; }

.adp-hint { font-size: .72rem; color: var(--ink-4); margin-top: .35rem; line-height: 1.5; }

.adp-err-msg {
    font-size: .72rem;
    color: var(--danger);
    margin-top: .35rem;
    display: flex;
    align-items: center;
    gap: .3rem;
}

/* ── Input prefix/suffix ── */
.adp-input-wrap { display: flex; align-items: stretch; }

.adp-addon {
    padding: .62rem .85rem;
    background: var(--bg);
    border: 1.5px solid var(--line-strong);
    font-size: .8rem;
    font-weight: 600;
    color: var(--ink-3);
    display: flex;
    align-items: center;
    white-space: nowrap;
    flex-shrink: 0;
}

.adp-addon.left  { border-right: none; border-radius: var(--r-sm) 0 0 var(--r-sm); }
.adp-addon.right { border-left:  none; border-radius: 0 var(--r-sm) var(--r-sm) 0; }

.adp-input-wrap .adp-input.with-l { border-radius: 0 var(--r-sm) var(--r-sm) 0; }
.adp-input-wrap .adp-input.with-r { border-radius: var(--r-sm) 0 0 var(--r-sm); border-right: none; }

/* ── Spec grid ── */
.adp-spec-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }

/* ── Existing file card ── */
.adp-existing-file {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .85rem 1rem;
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--r-md);
    margin-bottom: 1rem;
}

.adp-existing-file-icon {
    width: 38px; height: 38px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .62rem;
    font-weight: 800;
    letter-spacing: .04em;
    flex-shrink: 0;
}

.adp-existing-file-icon.pdf { background: #FEF2F2; color: #B91C1C; }
.adp-existing-file-icon.zip { background: #FFFBEB; color: #92400E; }
.adp-existing-file-icon.dwg { background: #EFF6FF; color: #1D4ED8; }

.adp-existing-file-info { flex: 1; min-width: 0; }
.adp-existing-file-info b    { display: block; font-size: .82rem; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.adp-existing-file-info span { font-size: .72rem; color: var(--ink-4); }

.adp-existing-file-actions { display: flex; gap: .4rem; flex-shrink: 0; }

.adp-existing-file-btn {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .3rem .65rem;
    border-radius: 5px;
    font-size: .73rem;
    font-weight: 600;
    border: 1.5px solid var(--line-strong);
    background: var(--surface);
    color: var(--ink-2);
    cursor: pointer;
    text-decoration: none;
    transition: all .15s;
}

.adp-existing-file-btn:hover { border-color: var(--brand); color: var(--brand); }
.adp-existing-file-btn.danger:hover { border-color: var(--danger); color: var(--danger); }

.adp-replace-notice {
    padding: .55rem .85rem;
    background: #FEF3C7;
    border: 1px solid #FDE68A;
    border-radius: var(--r-sm);
    font-size: .75rem;
    color: #92400E;
    margin-bottom: .85rem;
    display: none;
    align-items: center;
    gap: .4rem;
}

.adp-replace-notice.show { display: flex; }

/* ── Dropzone ── */
.adp-dropzone {
    border: 2px dashed var(--line-strong);
    border-radius: var(--r-md);
    padding: 2rem 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    background: var(--bg);
    position: relative;
}

.adp-dropzone:hover, .adp-dropzone.over {
    border-color: var(--brand);
    background: var(--brand-glow);
}

.adp-dropzone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%; height: 100%;
}

.adp-dropzone-icon {
    width: 44px; height: 44px;
    border-radius: var(--r-md);
    background: var(--brand-glow);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto .85rem;
    color: var(--brand);
}

.adp-dropzone h6 { font-size: .875rem; font-weight: 600; color: var(--ink-2); margin: 0 0 .3rem; }
.adp-dropzone p  { font-size: .76rem; color: var(--ink-4); margin: 0; line-height: 1.5; }
.adp-dropzone-browse { color: var(--brand); font-weight: 600; }

/* ── New file row ── */
.adp-file-row {
    display: none;
    align-items: center;
    gap: .75rem;
    padding: .8rem 1rem;
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--r-md);
    margin-top: .75rem;
}

.adp-file-row.show { display: flex; }

.adp-file-ext {
    width: 38px; height: 38px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .62rem;
    font-weight: 800;
    letter-spacing: .04em;
    flex-shrink: 0;
}

.adp-file-ext.pdf { background: #FEF2F2; color: #B91C1C; }
.adp-file-ext.zip { background: #FFFBEB; color: #92400E; }
.adp-file-ext.dwg { background: #EFF6FF; color: #1D4ED8; }

.adp-file-info      { flex: 1; min-width: 0; }
.adp-file-info b    { display: block; font-size: .82rem; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.adp-file-info span { font-size: .72rem; color: var(--ink-4); }

.adp-file-clear {
    background: none;
    border: none;
    color: var(--ink-4);
    cursor: pointer;
    padding: .3rem;
    border-radius: 4px;
    transition: color .15s;
    display: flex;
    align-items: center;
}

.adp-file-clear:hover { color: var(--danger); }

/* ── Existing image grid ── */
.adp-img-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(108px, 1fr));
    gap: .65rem;
    margin-top: .9rem;
}

/* Existing image (server-side) */
.adp-existing-thumb {
    position: relative;
    aspect-ratio: 1;
    border-radius: var(--r-md);
    overflow: hidden;
    background: var(--bg);
    border: 1.5px solid var(--line);
    transition: border-color .15s, box-shadow .15s;
}

.adp-existing-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }

.adp-existing-thumb.primary { border-color: var(--brand); box-shadow: 0 0 0 2px var(--brand-mid); }

.adp-thumb-cover-badge {
    position: absolute;
    top: 6px; left: 6px;
    background: var(--brand);
    color: #fff;
    font-size: .58rem;
    font-weight: 700;
    padding: .1rem .4rem;
    border-radius: 100px;
    letter-spacing: .03em;
    pointer-events: none;
}

.adp-thumb-num-badge {
    position: absolute;
    top: 6px; left: 6px;
    background: rgba(0,0,0,.5);
    color: #fff;
    font-size: .58rem;
    font-weight: 700;
    padding: .1rem .35rem;
    border-radius: 100px;
    pointer-events: none;
}

.adp-existing-thumb.primary .adp-thumb-num-badge { display: none; }

.adp-thumb-delete-mark {
    position: absolute;
    inset: 0;
    background: rgba(220,38,38,.35);
    display: none;
    align-items: center;
    justify-content: center;
    font-size: .68rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: .04em;
}

.adp-existing-thumb.marked-delete .adp-thumb-delete-mark { display: flex; }
.adp-existing-thumb.marked-delete { border-color: var(--danger); opacity: .65; }

.adp-existing-thumb-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.4);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .35rem;
    opacity: 0;
    transition: opacity .15s;
}

.adp-existing-thumb:hover .adp-existing-thumb-overlay { opacity: 1; }

.adp-thumb-btn {
    width: 30px; height: 30px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    transition: transform .1s;
    font-weight: 700;
}

.adp-thumb-btn:hover { transform: scale(1.1); }
.adp-thumb-btn.star  { background: var(--brand); color: #fff; }
.adp-thumb-btn.del   { background: rgba(255,255,255,.92); color: var(--danger); }
.adp-thumb-btn.undo  { background: rgba(255,255,255,.92); color: var(--success); }

/* New image thumbs */
.adp-new-thumb {
    position: relative;
    aspect-ratio: 1;
    border-radius: var(--r-md);
    overflow: hidden;
    background: var(--bg);
    border: 1.5px dashed var(--brand-mid);
    transition: border-color .15s;
}

.adp-new-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }

.adp-new-badge {
    position: absolute;
    top: 6px; right: 6px;
    background: var(--brand);
    color: #fff;
    font-size: .58rem;
    font-weight: 700;
    padding: .1rem .35rem;
    border-radius: 100px;
    letter-spacing: .03em;
    pointer-events: none;
}

.adp-new-thumb-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.4);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity .15s;
}

.adp-new-thumb:hover .adp-new-thumb-overlay { opacity: 1; }

.adp-add-tile {
    aspect-ratio: 1;
    border: 2px dashed var(--line-strong);
    border-radius: var(--r-md);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: .3rem;
    cursor: pointer;
    color: var(--ink-4);
    font-size: .71rem;
    font-weight: 600;
    transition: border-color .15s, color .15s, background .15s;
    position: relative;
}

.adp-add-tile input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%; height: 100%;
}

.adp-add-tile:hover { border-color: var(--brand); color: var(--brand); background: var(--brand-glow); }

.adp-img-strip {
    display: none;
    align-items: center;
    justify-content: space-between;
    margin-top: .9rem;
    padding: .6rem .9rem;
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--r-sm);
    font-size: .77rem;
    color: var(--ink-3);
}

.adp-img-strip.show { display: flex; }
.adp-img-strip strong { color: var(--ink); }
.adp-img-strip button { background: none; border: none; font-size: .72rem; color: var(--ink-4); cursor: pointer; padding: 0; transition: color .15s; }
.adp-img-strip button:hover { color: var(--danger); }

/* ── Toggles ── */
.adp-toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .85rem 0;
    border-bottom: 1px solid var(--line);
}

.adp-toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
.adp-toggle-lbl  { font-size: .84rem; font-weight: 500; color: var(--ink); }
.adp-toggle-desc { font-size: .72rem; color: var(--ink-4); margin-top: .1rem; }

.adp-switch { position: relative; width: 38px; height: 22px; flex-shrink: 0; }
.adp-switch input { opacity: 0; width: 0; height: 0; }

.adp-switch-track {
    position: absolute;
    inset: 0;
    background: var(--line-strong);
    border-radius: 100px;
    cursor: pointer;
    transition: background .2s;
}

.adp-switch-track::before {
    content: '';
    position: absolute;
    width: 16px; height: 16px;
    border-radius: 50%;
    background: #fff;
    top: 3px; left: 3px;
    transition: transform .2s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}

.adp-switch input:checked + .adp-switch-track { background: var(--brand); }
.adp-switch input:checked + .adp-switch-track::before { transform: translateX(16px); }

/* ── Status ── */
.adp-status-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: .5rem; }

.adp-status-radio { display: none; }

.adp-status-chip {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .35rem;
    padding: .75rem .5rem;
    border: 1.5px solid var(--line);
    border-radius: var(--r-sm);
    cursor: pointer;
    font-size: .73rem;
    font-weight: 600;
    color: var(--ink-3);
    text-align: center;
    transition: all .15s;
    background: var(--surface);
}

.adp-status-chip:hover { border-color: var(--line-strong); }
.adp-status-dot { width: 9px; height: 9px; border-radius: 50%; }

.adp-status-radio[value="pending"]:checked  + .adp-status-chip { border-color: #F59E0B; background: #FFFBEB; color: #92400E; }
.adp-status-radio[value="approved"]:checked + .adp-status-chip { border-color: #22C55E; background: #F0FDF4; color: #14532D; }
.adp-status-radio[value="rejected"]:checked + .adp-status-chip { border-color: #EF4444; background: #FEF2F2; color: #991B1B; }

/* ── Price preview ── */
.adp-price-preview {
    margin-top: 1rem;
    padding: .8rem 1rem;
    background: var(--brand-glow);
    border: 1px solid var(--brand-mid);
    border-radius: var(--r-sm);
    font-size: .78rem;
    color: var(--brand-dark);
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: .5rem;
}

/* ── Fee preview ── */
.adp-fee-preview {
    margin-top: .9rem;
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--r-sm);
    overflow: hidden;
}

.adp-fee-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .55rem .9rem;
    font-size: .78rem;
    border-bottom: 1px solid var(--line);
}

.adp-fee-row:last-child { border-bottom: none; }
.adp-fee-row .lbl { color: var(--ink-3); }
.adp-fee-row .val { font-weight: 600; color: var(--ink); }
.adp-fee-row.total .lbl { font-weight: 600; color: var(--ink-2); }
.adp-fee-row.total .val { color: var(--brand); font-size: .88rem; }

/* ── Buttons ── */
.adp-btn {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .62rem 1.35rem;
    border-radius: var(--r-sm);
    font-size: .84rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all .2s;
    text-decoration: none;
    font-family: inherit;
    white-space: nowrap;
}

.adp-btn-primary {
    background: var(--brand);
    color: #fff;
    box-shadow: 0 1px 3px rgba(201,78,7,.35);
}

.adp-btn-primary:hover {
    background: var(--brand-dark);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(201,78,7,.3);
}

.adp-btn-ghost {
    background: var(--surface);
    border: 1.5px solid var(--line-strong);
    color: var(--ink-2);
}

.adp-btn-ghost:hover { border-color: var(--brand); color: var(--brand); background: var(--brand-glow); }

.adp-btn-danger {
    background: var(--surface);
    border: 1.5px solid #FECACA;
    color: var(--danger);
}

.adp-btn-danger:hover { background: var(--danger-bg); border-color: var(--danger); }

/* ── Submit bar ── */
.adp-submit-bar {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: .6rem;
    padding: 1.1rem 1.4rem;
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--r-lg);
    box-shadow: var(--shadow-sm);
}

.adp-submit-hint { margin-right: auto; font-size: .75rem; color: var(--ink-4); }

/* ── Changes summary ── */
.adp-changes-note {
    padding: .6rem .9rem;
    background: #EFF6FF;
    border: 1px solid #BFDBFE;
    border-radius: var(--r-sm);
    font-size: .75rem;
    color: #1E40AF;
    display: none;
}

.adp-changes-note.show { display: block; }

@media (max-width: 900px) {
    .adp-layout { grid-template-columns: 1fr; }
    .adp-side { position: static; }
    .adp-grid-2 { grid-template-columns: 1fr; }
    .adp-spec-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 560px) {
    .adp-spec-grid { grid-template-columns: 1fr; }
    .adp-page-header { flex-direction: column; gap: .75rem; }
    .adp-header-actions { width: 100%; justify-content: flex-end; }
}
</style>

<div class="adp-root">

    {{-- ── Page header ── --}}
    <div class="adp-page-header">
        <div>
            <nav class="adp-breadcrumb">
                <a href="{{ route('admin.architectural-designs.index') }}">Designs</a>
                <span class="adp-breadcrumb-sep"></span>
                <a href="{{ route('admin.properties.architectural-designs.show', $architecturalDesign) }}">{{ Str::limit($architecturalDesign->title, 32) }}</a>
                <span class="adp-breadcrumb-sep"></span>
                <span>Edit</span>
            </nav>
            <div class="adp-edit-badge">
                <span class="adp-edit-badge-dot"></span>
                Editing
            </div>
            <h1 class="adp-page-title">Edit Design</h1>
            <p class="adp-page-sub">Last updated {{ $architecturalDesign->updated_at->diffForHumans() }} · Ref <code style="font-size:.78rem;background:var(--bg);padding:.1rem .35rem;border-radius:4px">#{{ $architecturalDesign->id }}</code></p>
        </div>
        <div class="adp-header-actions">
            <a href="{{ route('admin.properties.architectural-designs.show', $architecturalDesign) }}" class="adp-btn adp-btn-ghost">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                View
            </a>
            <a href="{{ route('admin.architectural-designs.index') }}" class="adp-btn adp-btn-ghost">All Designs</a>
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if ($errors->any())
    <div class="adp-alert adp-alert-err">
        <svg class="adp-alert-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
        </svg>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul>@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
    </div>
    @endif

    @if (session('success'))
    <div class="adp-alert adp-alert-ok">
        <svg class="adp-alert-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 6 9 17l-5-5"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ══════════════════════════════════════════
         MAIN UPDATE FORM
         The delete form is SEPARATE (below .adp-root)
         to avoid invalid nested <form> elements.
    ══════════════════════════════════════════ --}}
    <form method="POST"
          action="{{ route('admin.architectural-designs.update', $architecturalDesign->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Tracks which existing images to delete (comma-separated IDs) --}}
        <input type="hidden" name="delete_image_ids" id="deleteImageIds" value="">
        <input type="hidden" name="primary_image_id" id="primaryImageId" value="{{ $architecturalDesign->primaryImage?->id ?? ($architecturalDesign->images->first()?->id ?? '') }}">
        <input type="hidden" name="primary_new_image_index" id="primaryNewImageIndex" value="">

        <div class="adp-layout">

            {{-- ══════════ MAIN ══════════ --}}
            <div class="adp-main">

                {{-- ── Basic Info ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Design Information</h6>
                    </div>
                    <div class="adp-card-body">

                        <div class="adp-field" style="margin-bottom:1.1rem">
                            <label class="adp-lbl">Title <span class="req">*</span></label>
                            <input type="text" name="title"
                                class="adp-input @error('title') err @enderror"
                                value="{{ old('title', $architecturalDesign->title) }}" required>
                            @error('title')<p class="adp-err-msg">{{ $message }}</p>@enderror
                        </div>

                        <div class="adp-grid-2" style="margin-bottom:1.1rem">
                            <div class="adp-field">
                                <label class="adp-lbl">Category <span class="req">*</span></label>
                                <select name="category_id"
                                    class="adp-select @error('category_id') err @enderror" required>
                                    <option value="">Select category…</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $architecturalDesign->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>

                            <div class="adp-field">
                                <label class="adp-lbl">Assign to User</label>
                                <select name="user_id"
                                    class="adp-select @error('user_id') err @enderror">
                                    <option value="">— Admin account —</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id', $architecturalDesign->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('user_id')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="adp-field">
                            <label class="adp-lbl">Description</label>
                            <textarea name="description" rows="4"
                                class="adp-textarea @error('description') err @enderror">{{ old('description', $architecturalDesign->description) }}</textarea>
                            @error('description')<p class="adp-err-msg">{{ $message }}</p>@enderror
                        </div>

                    </div>
                </div>

                {{-- ── Specifications ── --}}
                <!-- <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Specifications</h6>
                    </div>
                    <div class="adp-card-body">
                        <div class="adp-spec-grid">
                            <div class="adp-field">
                                <label class="adp-lbl">Bedrooms</label>
                                <input type="number" name="bedrooms" min="0"
                                    class="adp-input @error('bedrooms') err @enderror"
                                    value="{{ old('bedrooms', $architecturalDesign->bedrooms) }}">
                            </div>
                            <div class="adp-field">
                                <label class="adp-lbl">Bathrooms</label>
                                <input type="number" name="bathrooms" min="0"
                                    class="adp-input @error('bathrooms') err @enderror"
                                    value="{{ old('bathrooms', $architecturalDesign->bathrooms) }}">
                            </div>
                            <div class="adp-field">
                                <label class="adp-lbl">Floors</label>
                                <input type="number" name="floors" min="1"
                                    class="adp-input @error('floors') err @enderror"
                                    value="{{ old('floors', $architecturalDesign->floors) }}">
                            </div>
                            <div class="adp-field">
                                <label class="adp-lbl">Total Area (m²)</label>
                                <input type="number" name="total_area" min="0" step="0.01"
                                    class="adp-input @error('total_area') err @enderror"
                                    value="{{ old('total_area', $architecturalDesign->total_area) }}">
                            </div>
                            <div class="adp-field">
                                <label class="adp-lbl">Plot Size (m²)</label>
                                <input type="number" name="plot_size" min="0" step="0.01"
                                    class="adp-input @error('plot_size') err @enderror"
                                    value="{{ old('plot_size', $architecturalDesign->plot_size) }}">
                            </div>
                            <div class="adp-field">
                                <label class="adp-lbl">Style</label>
                                <select name="style" class="adp-select @error('style') err @enderror">
                                    <option value="">Select…</option>
                                    @foreach(['Modern','Contemporary','Colonial','Traditional','Minimalist','Tropical','Industrial','Ranch'] as $st)
                                    <option value="{{ $st }}" {{ old('style', $architecturalDesign->style) == $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div> -->

                {{-- ── Design File ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Design File</h6>
                    </div>
                    <div class="adp-card-body">

                        @if($architecturalDesign->design_file_path)
                        @php
                            $existingExt = pathinfo($architecturalDesign->design_file_path, PATHINFO_EXTENSION);
                            $existingName = basename($architecturalDesign->design_file_path);
                        @endphp
                        <div class="adp-existing-file" id="existingFileRow">
                            <div class="adp-existing-file-icon {{ strtolower($existingExt) }}">{{ strtoupper($existingExt) }}</div>
                            <div class="adp-existing-file-info">
                                <b>{{ $existingName }}</b>
                                <span>Current file · uploaded {{ $architecturalDesign->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="adp-existing-file-actions">
                                <a href="{{ Storage::url($architecturalDesign->design_file_path) }}"
                                   target="_blank" class="adp-existing-file-btn">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    Download
                                </a>
                                <button type="button" class="adp-existing-file-btn danger" onclick="toggleReplaceFile()">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    Replace
                                </button>
                            </div>
                        </div>
                        @endif

                        <div class="adp-replace-notice" id="replaceNotice">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M12 9v4m0 4h.01"/><circle cx="12" cy="12" r="10"/></svg>
                            New file will replace the existing one after saving.
                        </div>

                        <div id="newFileZone" style="{{ $architecturalDesign->design_file_path ? 'display:none' : '' }}">
                            <div class="adp-dropzone" id="dznDesign">
                                <input type="file" name="design_file" id="designFileInput" accept=".pdf,.zip,.dwg">
                                <div class="adp-dropzone-icon">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                        <line x1="12" x2="12" y1="11" y2="17"/>
                                        <line x1="9" x2="15" y1="14" y2="14"/>
                                    </svg>
                                </div>
                                <h6>Drop replacement file here</h6>
                                <p>or <span class="adp-dropzone-browse">browse</span> — PDF · ZIP · DWG · max 20 MB</p>
                            </div>

                            <div class="adp-file-row" id="designFileRow">
                                <div class="adp-file-ext" id="designFileExt">PDF</div>
                                <div class="adp-file-info">
                                    <b id="designFileName">—</b>
                                    <span id="designFileSize">—</span>
                                </div>
                                <button type="button" class="adp-file-clear" onclick="clearDesignFile()">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>

                        @error('design_file')<p class="adp-err-msg" style="margin-top:.6rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Preview Images ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Preview Images</h6>
                        <span class="adp-card-head-pill" id="imgBadge">
                            {{ $architecturalDesign->images->count() }} {{ $architecturalDesign->images->count() === 1 ? 'photo' : 'photos' }}
                        </span>
                    </div>
                    <div class="adp-card-body">

                        <div class="adp-changes-note" id="imgChangesNote"></div>

                        <div class="adp-img-strip show" id="imgStrip" style="{{ $architecturalDesign->images->isEmpty() ? 'display:none!important' : '' }}">
                            <span id="imgStripText">
                                <strong id="imgStripCount">{{ $architecturalDesign->images->count() }} {{ $architecturalDesign->images->count() === 1 ? 'image' : 'images' }}</strong>
                                — first is the cover
                            </span>
                        </div>

                        <div class="adp-img-grid" id="existingImgGrid">
                            @foreach($architecturalDesign->images->sortByDesc('is_primary') as $img)
                            @php $isPrimary = $architecturalDesign->primaryImage?->id === $img->id; @endphp
                            <div class="adp-existing-thumb {{ $isPrimary ? 'primary' : '' }}"
                                 id="existingThumb_{{ $img->id }}"
                                 data-id="{{ $img->id }}">
                                <img src="{{ asset('image/architectural_designs/images/' . $img->image_path) }}" alt="Preview">
                                @if($isPrimary)
                                <span class="adp-thumb-cover-badge">Cover</span>
                                @else
                                <span class="adp-thumb-num-badge">{{ $loop->iteration }}</span>
                                @endif
                                <div class="adp-thumb-delete-mark">REMOVE</div>
                                <div class="adp-existing-thumb-overlay">
                                    @if(!$isPrimary)
                                    <button type="button" class="adp-thumb-btn star"
                                        title="Set as cover"
                                        onclick="setExistingPrimary({{ $img->id }})">★</button>
                                    @endif
                                    <button type="button" class="adp-thumb-btn del"
                                        title="Mark for removal"
                                        onclick="toggleDeleteExisting({{ $img->id }})">✕</button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="adp-img-grid" id="newImgGrid" style="margin-top:.5rem"></div>
                        <div id="newImgInputsContainer" style="display:none"></div>

                        <div class="adp-dropzone" id="dznImages"
                             style="margin-top:.9rem;{{ $architecturalDesign->images->count() >= 10 ? 'display:none' : '' }}">
                            <input type="file" name="new_images[]" id="newImagesInput" accept="image/*" multiple>
                            <div class="adp-dropzone-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect width="18" height="18" x="3" y="3" rx="2"/>
                                    <circle cx="9" cy="9" r="2"/>
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                                </svg>
                            </div>
                            <h6>Add more preview images</h6>
                            <p>or <span class="adp-dropzone-browse">browse</span> — JPG · PNG · WEBP · 4 MB each</p>
                        </div>

                        @error('new_images')<p class="adp-err-msg" style="margin-top:.6rem">{{ $message }}</p>@enderror
                        @error('new_images.*')<p class="adp-err-msg" style="margin-top:.4rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Listing Package ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Listing Package</h6>
                    </div>
                    <div class="adp-card-body">
                        <div class="adp-grid-2">
                            <div class="adp-field">
                                <label class="adp-lbl">Package <span class="req">*</span></label>
                                <select name="listing_package_id"
                                    class="adp-select @error('listing_package_id') err @enderror"
                                    onchange="recalcFee()" required>
                                    <option value="">Select a package…</option>
                                    @foreach($packages as $pkg)
                                    <option value="{{ $pkg->id }}"
                                        data-price="{{ $pkg->price_per_day }}"
                                        data-agent-pct="{{ $pkg->agent_commission_pct }}"
                                        data-terra-pct="{{ $pkg->terra_share_pct }}"
                                        {{ old('listing_package_id', $architecturalDesign->listing_package_id) == $pkg->id ? 'selected' : '' }}>
                                        {{ ucfirst($pkg->package_tier) }} — RWF {{ number_format($pkg->price_per_day) }}/day
                                        (you earn {{ $pkg->agent_commission_pct }}%)
                                    </option>
                                    @endforeach
                                </select>
                                @error('listing_package_id')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>

                            <div class="adp-field">
                                <label class="adp-lbl">Duration (days) <span class="req">*</span></label>
                                <input type="number" name="listing_days"
                                    class="adp-input @error('listing_days') err @enderror"
                                    value="{{ old('listing_days', $architecturalDesign->listing_days ?? 30) }}"
                                    min="1" oninput="recalcFee()" required>
                                <p class="adp-hint">31–59 days: 10% off · 61–89 days: 15% off · 90+ days: 20% off</p>
                                @error('listing_days')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="adp-fee-preview" id="feePreview" style="display:none">
                            <div class="adp-fee-row">
                                <span class="lbl">Base rate</span>
                                <span class="val" id="feeBase">—</span>
                            </div>
                            <div class="adp-fee-row">
                                <span class="lbl">Duration discount</span>
                                <span class="val" id="feeDiscount">—</span>
                            </div>
                            <div class="adp-fee-row total">
                                <span class="lbl">Listing fee</span>
                                <span class="val" id="feeTotal">—</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Submit bar ── --}}
                <div class="adp-submit-bar">
                    <span class="adp-submit-hint">Changes are saved immediately on submit.</span>
                    <a href="{{ route('admin.properties.architectural-designs.show', $architecturalDesign) }}" class="adp-btn adp-btn-ghost">Discard</a>
                    <button type="submit" class="adp-btn adp-btn-primary">
                        Save Changes
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                    </button>
                </div>

            </div>{{-- /.adp-main --}}

            {{-- ══════════ SIDEBAR ══════════ --}}
            <div class="adp-side">

                {{-- ── Pricing ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Pricing</h6>
                    </div>
                    <div class="adp-card-body">

                        <div class="adp-field" style="margin-bottom:.9rem">
                            <label class="adp-lbl">Sale Price</label>
                            <div class="adp-input-wrap">
                                <span class="adp-addon left" id="priceCurrencyAddon">{{ old('currency', $architecturalDesign->currency ?? 'RWF') }}</span>
                                <input type="number" name="price" id="priceInput"
                                    class="adp-input with-l @error('price') err @enderror"
                                    placeholder="0" min="0" step="0.01"
                                    value="{{ old('price', $architecturalDesign->price ?? 0) }}"
                                    oninput="updatePricePreview()">
                            </div>
                            @error('price')<p class="adp-err-msg">{{ $message }}</p>@enderror
                        </div>

                        <div class="adp-field" style="margin-bottom:.75rem">
                            <label class="adp-lbl">Currency</label>
                            <select name="currency" id="currencyInput"
                                class="adp-select @error('currency') err @enderror"
                                onchange="updatePricePreview()">
                                <option value="RWF" {{ old('currency', $architecturalDesign->currency) == 'RWF' ? 'selected' : '' }}>Rwandan Franc (RWF)</option>
                                <option value="USD" {{ old('currency', $architecturalDesign->currency) == 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                            </select>
                            @error('currency')<p class="adp-err-msg">{{ $message }}</p>@enderror
                        </div>

                        <div class="adp-price-preview" id="pricePreview">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                            <span id="pricePreviewText">…</span>
                        </div>
                    </div>
                </div>

                {{-- ── Status ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Status</h6>
                    </div>
                    <div class="adp-card-body">
                        <div class="adp-status-grid">
                            @foreach(['pending' => ['label'=>'Pending','color'=>'#F59E0B'], 'approved' => ['label'=>'Approved','color'=>'#22C55E'], 'rejected' => ['label'=>'Rejected','color'=>'#EF4444']] as $val => $meta)
                            <input type="radio" name="status" id="status_{{ $val }}"
                                value="{{ $val }}" class="adp-status-radio"
                                {{ old('status', $architecturalDesign->status) === $val ? 'checked' : '' }} required>
                            <label for="status_{{ $val }}" class="adp-status-chip">
                                <span class="adp-status-dot" style="background:{{ $meta['color'] }}"></span>
                                {{ $meta['label'] }}
                            </label>
                            @endforeach
                        </div>
                        @error('status')<p class="adp-err-msg" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Options ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Options</h6>
                    </div>
                    <div class="adp-card-body">
                        <div class="adp-toggle-row">
                            <div>
                                <div class="adp-toggle-lbl">Featured</div>
                                <div class="adp-toggle-desc">Show on homepage spotlight</div>
                            </div>
                            <label class="adp-switch">
                                <input type="checkbox" name="featured" value="1"
                                    {{ old('featured', $architecturalDesign->featured) ? 'checked' : '' }}>
                                <span class="adp-switch-track"></span>
                            </label>
                        </div>
                        <div class="adp-toggle-row">
                            <div>
                                <div class="adp-toggle-lbl">Downloadable</div>
                                <div class="adp-toggle-desc">Allow buyers to download</div>
                            </div>
                            <label class="adp-switch">
                                <input type="checkbox" name="is_downloadable" value="1"
                                    {{ old('is_downloadable', $architecturalDesign->is_downloadable ?? true) ? 'checked' : '' }}>
                                <span class="adp-switch-track"></span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- ── Danger zone ── --}}
                {{--
                    NOTE: The actual delete <form> lives OUTSIDE .adp-root entirely
                    (at the bottom of this file) to prevent invalid HTML nesting.
                    This button triggers it via JS.
                --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot" style="background:var(--danger)"></span>
                        <h6 style="color:var(--danger)">Danger Zone</h6>
                    </div>
                    <div class="adp-card-body">
                        <p style="font-size:.78rem;color:var(--ink-3);margin:0 0 .85rem">Permanently delete this design and all associated files. This cannot be undone.</p>
                        <button type="button"
                                onclick="confirmDelete()"
                                class="adp-btn adp-btn-danger"
                                style="width:100%;justify-content:center">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg>
                            Delete Design
                        </button>
                    </div>
                </div>

            </div>{{-- /.adp-side --}}

        </div>{{-- /.adp-layout --}}
    </form>{{-- END main update form --}}

</div>{{-- /.adp-root --}}

{{-- ══════════════════════════════════════════
     STANDALONE DELETE FORM
     Placed outside every other form to prevent
     invalid HTML nesting (browsers silently drop
     nested <form> tags, causing _method spoofing
     to bleed into the outer form).
══════════════════════════════════════════ --}}
<form id="deleteDesignForm"
      method="POST"
      action="{{ route('admin.architectural-designs.destroy', $architecturalDesign->id) }}"
      style="display:none">
    @csrf
    @method('DELETE')
</form>

<script>
/* ═══════════════════════════════════
   Delete confirmation — triggers the
   standalone form outside .adp-root
═══════════════════════════════════ */
function confirmDelete() {
    if (confirm('Delete this design permanently? This cannot be undone.')) {
        document.getElementById('deleteDesignForm').submit();
    }
}

/* ═══════════════════════════════════
   Design file — replace toggle
═══════════════════════════════════ */
let fileZoneVisible = {{ $architecturalDesign->design_file_path ? 'false' : 'true' }};

function toggleReplaceFile() {
    fileZoneVisible = !fileZoneVisible;
    document.getElementById('newFileZone').style.display = fileZoneVisible ? '' : 'none';
    document.getElementById('replaceNotice').classList.toggle('show', fileZoneVisible);
}

const designInput = document.getElementById('designFileInput');
const designRow   = document.getElementById('designFileRow');
const dznDesign   = document.getElementById('dznDesign');

if (designInput) {
    designInput.addEventListener('change', () => showDesignFile(designInput.files[0]));

    ['dragover','dragleave','drop'].forEach(ev => {
        dznDesign.addEventListener(ev, e => {
            e.preventDefault();
            dznDesign.classList.toggle('over', ev === 'dragover');
            if (ev === 'drop' && e.dataTransfer.files[0]) {
                const dt = new DataTransfer();
                dt.items.add(e.dataTransfer.files[0]);
                designInput.files = dt.files;
                showDesignFile(e.dataTransfer.files[0]);
            }
        });
    });
}

function showDesignFile(file) {
    if (!file) return;
    const ext = file.name.split('.').pop().toLowerCase();
    document.getElementById('designFileName').textContent = file.name;
    document.getElementById('designFileSize').textContent = fmtBytes(file.size);
    const extEl = document.getElementById('designFileExt');
    extEl.textContent = ext.toUpperCase();
    extEl.className   = 'adp-file-ext ' + (ext === 'pdf' ? 'pdf' : ext === 'zip' ? 'zip' : 'dwg');
    designRow.classList.add('show');
    document.getElementById('replaceNotice').classList.add('show');
}

function clearDesignFile() {
    if (designInput) designInput.value = '';
    if (designRow) designRow.classList.remove('show');
    document.getElementById('replaceNotice').classList.remove('show');
}

/* ═══════════════════════════════════
   Existing image management
═══════════════════════════════════ */
const deleteIds  = new Set();
let primaryImgId = parseInt(document.getElementById('primaryImageId').value) || null;

function setExistingPrimary(id) {
    document.querySelectorAll('.adp-existing-thumb.primary').forEach(el => {
        el.classList.remove('primary');
        const numBadge = el.querySelector('.adp-thumb-num-badge');
        if (numBadge) numBadge.style.display = '';
        const coverBadge = el.querySelector('.adp-thumb-cover-badge');
        if (coverBadge) coverBadge.remove();
        const overlay = el.querySelector('.adp-existing-thumb-overlay');
        if (overlay && !overlay.querySelector('.star')) {
            const btn = document.createElement('button');
            btn.type      = 'button';
            btn.className = 'adp-thumb-btn star';
            btn.title     = 'Set as cover';
            btn.textContent = '★';
            btn.setAttribute('onclick', `setExistingPrimary(${el.dataset.id})`);
            overlay.insertBefore(btn, overlay.firstChild);
        }
    });

    const el = document.getElementById('existingThumb_' + id);
    if (!el) return;

    el.classList.add('primary');

    const numBadge = el.querySelector('.adp-thumb-num-badge');
    if (numBadge) numBadge.style.display = 'none';

    if (!el.querySelector('.adp-thumb-cover-badge')) {
        const cb = document.createElement('span');
        cb.className   = 'adp-thumb-cover-badge';
        cb.textContent = 'Cover';
        el.insertBefore(cb, el.querySelector('.adp-thumb-delete-mark'));
    }

    const starBtn = el.querySelector('.adp-existing-thumb-overlay .star');
    if (starBtn) starBtn.remove();

    primaryImgId = id;
    document.getElementById('primaryImageId').value = id;
    document.getElementById('primaryNewImageIndex').value = '';
    updateChangesNote();
}

function toggleDeleteExisting(id) {
    const el = document.getElementById('existingThumb_' + id);
    if (!el) return;

    if (deleteIds.has(id)) {
        deleteIds.delete(id);
        el.classList.remove('marked-delete');
        const overlay = el.querySelector('.adp-existing-thumb-overlay');
        const undoBtn = overlay.querySelector('.undo');
        if (undoBtn) undoBtn.remove();
        const delBtn = document.createElement('button');
        delBtn.type      = 'button';
        delBtn.className = 'adp-thumb-btn del';
        delBtn.title     = 'Mark for removal';
        delBtn.textContent = '✕';
        delBtn.setAttribute('onclick', `toggleDeleteExisting(${id})`);
        overlay.appendChild(delBtn);
    } else {
        deleteIds.add(id);
        el.classList.add('marked-delete');
        if (primaryImgId === id) {
            primaryImgId = null;
            document.getElementById('primaryImageId').value = '';
        }
        const delBtn = el.querySelector('.adp-existing-thumb-overlay .del');
        if (delBtn) delBtn.remove();
        const overlay = el.querySelector('.adp-existing-thumb-overlay');
        const undoBtn = document.createElement('button');
        undoBtn.type      = 'button';
        undoBtn.className = 'adp-thumb-btn undo';
        undoBtn.title     = 'Undo removal';
        undoBtn.textContent = '↩';
        undoBtn.setAttribute('onclick', `toggleDeleteExisting(${id})`);
        overlay.appendChild(undoBtn);
    }

    document.getElementById('deleteImageIds').value = Array.from(deleteIds).join(',');
    updateChangesNote();
}

/* ═══════════════════════════════════
   New image uploads
═══════════════════════════════════ */
const MAX_IMGS  = 10;
let newImgItems = [];
const existingCount = () => document.querySelectorAll('.adp-existing-thumb:not(.marked-delete)').length;

const dznImages = document.getElementById('dznImages');

document.getElementById('newImagesInput').addEventListener('change', function () {
    addNewImgFiles(Array.from(this.files));
    this.value = '';
});

['dragover','dragleave','drop'].forEach(ev => {
    dznImages.addEventListener(ev, e => {
        e.preventDefault();
        dznImages.classList.toggle('over', ev === 'dragover');
        if (ev === 'drop') {
            const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
            addNewImgFiles(files);
        }
    });
});

function addNewImgFiles(files) {
    const room = MAX_IMGS - existingCount() - newImgItems.length;
    files = files.slice(0, room);
    if (!files.length) return;
    let done = 0;
    files.forEach(file => {
        const r = new FileReader();
        r.onload = ev => {
            newImgItems.push({ file, dataUrl: ev.target.result });
            if (++done === files.length) renderNewImgGrid();
        };
        r.readAsDataURL(file);
    });
}

function renderNewImgGrid() {
    const grid = document.getElementById('newImgGrid');
    grid.innerHTML = '';

    newImgItems.forEach((item, i) => {
        const t = document.createElement('div');
        t.className = 'adp-new-thumb';
        t.innerHTML = `
            <img src="${item.dataUrl}" alt="New ${i+1}">
            <span class="adp-new-badge">NEW</span>
            <div class="adp-new-thumb-overlay">
                <button type="button" class="adp-thumb-btn del" onclick="removeNewImg(${i})">✕</button>
            </div>`;
        grid.appendChild(t);
    });

    updateNewImgUI();
}

function removeNewImg(i) { newImgItems.splice(i, 1); renderNewImgGrid(); }

function updateNewImgUI() {
    const total = existingCount() + newImgItems.length;
    const badge = document.getElementById('imgBadge');
    badge.textContent = total + (total === 1 ? ' photo' : ' photos');
    badge.classList.toggle('show', total > 0);
    document.getElementById('imgStripCount').textContent = total + (total === 1 ? ' image' : ' images');
    dznImages.style.display = total >= MAX_IMGS ? 'none' : '';
    syncNewImgInputs();
    updateChangesNote();
}

function syncNewImgInputs() {
    const con = document.getElementById('newImgInputsContainer');
    con.innerHTML = '';
    if (!newImgItems.length) return;
    const dt = new DataTransfer();
    newImgItems.forEach(item => dt.items.add(item.file));
    const inp = document.createElement('input');
    inp.type = 'file'; inp.name = 'new_images[]'; inp.multiple = true; inp.style.display = 'none';
    try { inp.files = dt.files; } catch(e) {
        newImgItems.forEach(item => {
            const d2 = new DataTransfer(); d2.items.add(item.file);
            const i2 = document.createElement('input');
            i2.type = 'file'; i2.name = 'new_images[]'; i2.style.display = 'none';
            try { i2.files = d2.files; } catch(e2) {}
            con.appendChild(i2);
        });
        return;
    }
    con.appendChild(inp);
}

function updateChangesNote() {
    const note = document.getElementById('imgChangesNote');
    const parts = [];
    if (deleteIds.size)     parts.push(`${deleteIds.size} image${deleteIds.size > 1 ? 's' : ''} marked for removal`);
    if (newImgItems.length) parts.push(`${newImgItems.length} new image${newImgItems.length > 1 ? 's' : ''} to upload`);
    if (parts.length) {
        note.textContent = '⚠ Pending changes: ' + parts.join(' · ');
        note.classList.add('show');
    } else {
        note.classList.remove('show');
    }
}

/* ═══════════════════════════════════
   Price preview
═══════════════════════════════════ */
function updatePricePreview() {
    const v    = parseFloat(document.getElementById('priceInput').value) || 0;
    const cur  = document.getElementById('currencyInput').value;
    document.getElementById('priceCurrencyAddon').textContent = cur;
    document.getElementById('pricePreviewText').textContent = v === 0
        ? 'This design will be listed as Free'
        : `Listed at ${cur} ${v.toLocaleString('en', {minimumFractionDigits: cur === 'USD' ? 2 : 0})}`;
}

updatePricePreview();

/* ═══════════════════════════════════
   Listing fee calculator
═══════════════════════════════════ */
function recalcFee() {
    const pkgEl  = document.querySelector('select[name="listing_package_id"]');
    const days   = parseInt(document.querySelector('input[name="listing_days"]').value) || 0;
    const preview= document.getElementById('feePreview');
    if (!pkgEl.value || !days) { preview.style.display = 'none'; return; }
    const opt      = pkgEl.options[pkgEl.selectedIndex];
    const ppd      = parseFloat(opt.dataset.price) || 0;
    const base     = ppd * days;
    const discount = days >= 90 ? .20 : days >= 61 ? .15 : days >= 31 ? .10 : 0;
    const total    = base * (1 - discount);
    document.getElementById('feeBase').textContent     = 'RWF ' + fmtNum(base);
    document.getElementById('feeDiscount').textContent = discount ? `−${discount*100}%` : '—';
    document.getElementById('feeTotal').textContent    = 'RWF ' + fmtNum(total);
    preview.style.display = '';
}

recalcFee();

/* ═══════════════════════════════════
   Helpers
═══════════════════════════════════ */
function fmtBytes(b) {
    if (b < 1024)    return b + ' B';
    if (b < 1048576) return (b/1024).toFixed(1) + ' KB';
    return (b/1048576).toFixed(1) + ' MB';
}

function fmtNum(n) { return Math.round(n).toLocaleString('en'); }
</script>

@endsection