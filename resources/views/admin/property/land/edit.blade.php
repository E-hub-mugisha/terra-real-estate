@extends('layouts.app')
@section('title', 'Edit Land Property — ' . $land->title)
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2/dist/css/tom-select.min.css">

<style>
    :root {
        --accent: #D05208;
        --accent-lt: #e4c990;
        --danger: #dc3545;
        --success: #198754;
        --warning: #f59e0b;
        --border: #e2e8f0;
        --surface: #f8fafc;
        --muted: #94a3b8;
        --text: #1e293b;
        --text-dim: #64748b;
        --radius: 10px;
    }

    .lp-page {
        padding: 1.75rem 0 3rem;
        max-width: 1100px;
        margin: 0 auto;
    }

    /* ── Page heading ── */
    .lp-heading {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .lp-heading-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: linear-gradient(135deg, #D0520822, #D0520844);
        border: 1px solid #D0520855;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        flex-shrink: 0;
    }

    .lp-heading h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .lp-heading p {
        font-size: .82rem;
        color: var(--text-dim);
        margin: .15rem 0 0;
    }

    .lp-heading-badge {
        margin-left: auto;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .35rem .85rem;
        border-radius: 20px;
        font-size: .75rem;
        font-weight: 600;
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
        flex-shrink: 0;
    }

    /* ── Step pills ── */
    .lp-steps {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 2rem;
        overflow-x: auto;
        padding-bottom: .25rem;
    }

    .lp-step {
        display: flex;
        align-items: center;
        gap: .55rem;
        padding: .55rem 1.1rem;
        font-size: .78rem;
        font-weight: 500;
        color: var(--muted);
        white-space: nowrap;
    }

    .lp-step.active { color: var(--accent); }
    .lp-step.done   { color: var(--success); }

    .lp-step-num {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 1.5px solid currentColor;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .7rem;
        flex-shrink: 0;
    }

    .lp-step.active .lp-step-num {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }

    .lp-step.done .lp-step-num {
        background: var(--success);
        border-color: var(--success);
        color: #fff;
    }

    .lp-step-sep {
        flex: 1;
        height: 1px;
        min-width: 24px;
        background: var(--border);
    }

    /* ── Section card ── */
    .lp-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        margin-bottom: 1.25rem;
        overflow: hidden;
    }

    .lp-card-header {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        background: var(--surface);
    }

    .lp-card-header-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #D0520818;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        flex-shrink: 0;
    }

    .lp-card-header h6 {
        margin: 0;
        font-size: .88rem;
        font-weight: 600;
        color: var(--text);
    }

    .lp-card-header span {
        margin-left: auto;
        font-size: .73rem;
        color: var(--muted);
    }

    .lp-card-body { padding: 1.5rem; }

    /* ── Form controls ── */
    .lp-label {
        display: block;
        font-size: .77rem;
        font-weight: 600;
        letter-spacing: .03em;
        color: var(--text-dim);
        text-transform: uppercase;
        margin-bottom: .45rem;
    }

    .lp-label .req { color: var(--danger); margin-left: .2rem; }

    .lp-input,
    .lp-select,
    .lp-textarea {
        width: 100%;
        padding: .65rem .9rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .875rem;
        color: var(--text);
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
        font-family: inherit;
    }

    .lp-input:focus,
    .lp-select:focus,
    .lp-textarea:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px #D0520818;
    }

    .lp-input.is-invalid,
    .lp-select.is-invalid,
    .lp-textarea.is-invalid { border-color: var(--danger); }

    .lp-textarea { resize: vertical; line-height: 1.6; }

    .lp-hint { font-size: .73rem; color: var(--muted); margin-top: .35rem; }

    .lp-error {
        font-size: .73rem;
        color: var(--danger);
        margin-top: .35rem;
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    /* ── Price input ── */
    .lp-input-group {
        position: relative;
        display: flex;
        align-items: stretch;
    }

    .lp-input-group-text {
        padding: .65rem .85rem;
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-right: none;
        border-radius: 8px 0 0 8px;
        font-size: .82rem;
        font-weight: 600;
        color: var(--muted);
        display: flex;
        align-items: center;
    }

    .lp-input-group .lp-input { border-radius: 0 8px 8px 0; flex: 1; }

    /* ── Image upload zone ── */
    .lp-dropzone {
        border: 2px dashed var(--border);
        border-radius: 10px;
        padding: 2rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        background: var(--surface);
        position: relative;
    }

    .lp-dropzone:hover,
    .lp-dropzone.dragover {
        border-color: var(--accent);
        background: #D0520808;
    }

    .lp-dropzone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .lp-dropzone-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #D0520818;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto .75rem;
        color: var(--accent);
    }

    .lp-dropzone h6 { font-size: .88rem; font-weight: 600; color: var(--text); margin: 0 0 .25rem; }
    .lp-dropzone p  { font-size: .78rem; color: var(--muted); margin: 0; }
    .lp-dropzone .lp-browse { color: var(--accent); font-weight: 500; }

    /* ── Existing + new image previews ── */
    .lp-existing-images {
        margin-bottom: 1rem;
    }

    .lp-existing-label {
        font-size: .73rem;
        font-weight: 600;
        color: var(--text-dim);
        text-transform: uppercase;
        letter-spacing: .03em;
        margin-bottom: .6rem;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .lp-existing-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .lp-previews {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
        gap: .6rem;
        margin-top: .5rem;
    }

    .lp-preview-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 1;
        background: var(--border);
    }

    .lp-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .lp-preview-remove {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: rgba(0,0,0,.6);
        border: none;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 10px;
        line-height: 1;
        transition: background .15s;
    }

    .lp-preview-remove:hover { background: var(--danger); }

    .lp-preview-item.marked-delete img { opacity: .35; filter: grayscale(1); }

    .lp-preview-item.marked-delete::after {
        content: 'Will be deleted';
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .6rem;
        font-weight: 700;
        color: var(--danger);
        text-align: center;
        padding: .25rem;
        pointer-events: none;
    }

    .lp-preview-undo {
        position: absolute;
        bottom: 4px;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 4px;
        font-size: .6rem;
        font-weight: 600;
        color: var(--text-dim);
        padding: 1px 5px;
        cursor: pointer;
        white-space: nowrap;
        display: none;
    }

    .lp-preview-item.marked-delete .lp-preview-undo { display: block; }

    /* ── Doc upload ── */
    .lp-file-btn {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .75rem 1rem;
        border: 1.5px dashed var(--border);
        border-radius: 8px;
        background: var(--surface);
        cursor: pointer;
        transition: border-color .2s;
        position: relative;
    }

    .lp-file-btn:hover { border-color: var(--accent); }

    .lp-file-btn input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .lp-file-btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #D0520818;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        flex-shrink: 0;
    }

    .lp-file-btn-text { font-size: .82rem; color: var(--text-dim); }
    .lp-file-btn-text strong { display: block; color: var(--text); font-size: .85rem; margin-bottom: .1rem; }

    /* Existing doc row */
    .lp-existing-doc {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .65rem 1rem;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        margin-bottom: .6rem;
        font-size: .82rem;
        color: #166534;
    }

    .lp-existing-doc a { color: inherit; font-weight: 600; }
    .lp-existing-doc a:hover { color: var(--accent); }

    .lp-replace-toggle {
        margin-left: auto;
        font-size: .73rem;
        font-weight: 600;
        color: var(--accent);
        cursor: pointer;
        text-decoration: underline;
        background: none;
        border: none;
        padding: 0;
        font-family: inherit;
    }

    /* ── Zoning badge grid ── */
    .lp-zone-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: .5rem;
    }

    .lp-zone-item { display: none; }

    .lp-zone-label {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .6rem .85rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .8rem;
        color: var(--text-dim);
        cursor: pointer;
        transition: all .15s;
        user-select: none;
    }

    .lp-zone-item:checked + .lp-zone-label {
        border-color: var(--accent);
        background: #D0520810;
        color: var(--accent);
        font-weight: 500;
    }

    .lp-zone-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        border: 2px solid currentColor;
        flex-shrink: 0;
    }

    .lp-zone-item:checked + .lp-zone-label .lp-zone-dot {
        background: var(--accent);
        border-color: var(--accent);
    }

    /* ── Submit bar ── */
    .lp-submit-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: .75rem;
        padding: 1.25rem 1.5rem;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        margin-top: 1.25rem;
    }

    .lp-submit-bar-info {
        margin-right: auto;
        font-size: .78rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .lp-btn {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .65rem 1.5rem;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
        font-family: inherit;
    }

    .lp-btn-primary { background: var(--accent); color: #fff; }
    .lp-btn-primary:hover { background: var(--accent-lt); color: #fff; transform: translateY(-1px); }

    .lp-btn-ghost {
        background: none;
        border: 1.5px solid var(--border);
        color: var(--text-dim);
    }

    .lp-btn-ghost:hover { border-color: var(--accent); color: var(--accent); }

    .lp-btn-danger {
        background: none;
        border: 1.5px solid #fecaca;
        color: var(--danger);
    }

    .lp-btn-danger:hover { background: #fef2f2; border-color: var(--danger); }

    /* ── Alerts ── */
    .lp-alert {
        border-radius: 8px;
        padding: .85rem 1.1rem;
        font-size: .84rem;
        display: flex;
        gap: .6rem;
        align-items: flex-start;
        margin-bottom: 1.25rem;
    }

    .lp-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .lp-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .lp-alert-warning { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }

    .lp-alert ul { margin: .35rem 0 0 1rem; padding: 0; }
    .lp-alert li { margin-bottom: .2rem; }

    /* ── Status pill ── */
    .lp-status-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .3rem .75rem;
        border-radius: 20px;
        font-size: .73rem;
        font-weight: 600;
    }

    .lp-status-pill.pending  { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .lp-status-pill.approved { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .lp-status-pill.rejected { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

    .lp-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* ═══════════════════════════════════════════════
       hp- form control aliases + client-search / quick-add
       modal styling — brought in from the create view so
       the edit view's Property Owner section matches it.
       ═══════════════════════════════════════════════ */

    .hp-label {
        display: block;
        font-size: .77rem;
        font-weight: 600;
        letter-spacing: .03em;
        color: var(--text-dim);
        text-transform: uppercase;
        margin-bottom: .45rem;
    }

    .hp-label .req { color: var(--danger); margin-left: .2rem; }

    .hp-input,
    .hp-select {
        width: 100%;
        padding: .65rem .9rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .875rem;
        color: var(--text);
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
        font-family: inherit;
    }

    .hp-input:focus,
    .hp-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px #D0520818;
    }

    .hp-input.is-invalid,
    .hp-select.is-invalid { border-color: var(--danger); }

    .hp-hint { font-size: .73rem; color: var(--muted); margin-top: .35rem; }

    .hp-error {
        font-size: .73rem;
        color: var(--danger);
        margin-top: .35rem;
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    .hp-btn {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .6rem 1.35rem;
        border-radius: 8px;
        font-size: .83rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all .2s;
        font-family: inherit;
    }

    .hp-btn-primary { background: var(--accent); color: #fff; }
    .hp-btn-primary:hover { background: var(--accent-lt); }

    .hp-btn-ghost {
        background: none;
        border: 1.5px solid var(--border);
        color: var(--text-dim);
    }

    .hp-btn-ghost:hover { border-color: var(--accent); color: var(--accent); }

    .hp-alert {
        border-radius: 8px;
        padding: .75rem 1rem;
        font-size: .82rem;
        display: flex;
        gap: .55rem;
        align-items: flex-start;
    }

    .hp-alert-danger { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }

    /* ── Client preview card (Property Owner section) ── */
    .client-preview {
        display: none;
        align-items: center;
        gap: .85rem;
        margin-top: .9rem;
        padding: .85rem 1rem;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        background: var(--surface);
    }

    .client-preview.visible { display: flex; }

    .cp-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--accent);
        color: #fff;
        font-weight: 700;
        font-size: .95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .cp-body { flex: 1; min-width: 0; }
    .cp-name { font-size: .88rem; font-weight: 600; color: var(--text); }
    .cp-meta { font-size: .76rem; color: var(--text-dim); margin-top: .1rem; }

    .cp-type-badge {
        display: inline-block;
        margin-top: .35rem;
        padding: .15rem .55rem;
        border-radius: 999px;
        font-size: .68rem;
        font-weight: 600;
    }

    .cp-btn-clear {
        background: none;
        border: none;
        color: var(--text-dim);
        font-size: .76rem;
        cursor: pointer;
        flex-shrink: 0;
        padding: .3rem .5rem;
    }

    .cp-btn-clear:hover { color: var(--danger); }

    .client-new-trigger {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        margin-top: .85rem;
        background: none;
        border: none;
        color: var(--accent);
        font-size: .8rem;
        font-weight: 500;
        cursor: pointer;
        padding: 0;
    }

    .client-new-trigger:hover { text-decoration: underline; }

    /* ── Tom Select dropdown option rendering ── */
    .ts-opt-name {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .85rem;
        color: var(--text);
    }

    .ts-opt-sub { font-size: .74rem; color: var(--muted); margin-top: .1rem; }

    .ts-opt-badge {
        font-size: .65rem;
        font-weight: 600;
        padding: .1rem .5rem;
        border-radius: 999px;
    }

    .ts-no-results-row {
        padding: .5rem .25rem;
        font-size: .82rem;
        color: var(--text-dim);
    }

    .ts-register-link {
        display: block;
        margin-top: .4rem;
        background: none;
        border: none;
        color: var(--accent);
        font-weight: 500;
        font-size: .8rem;
        cursor: pointer;
        padding: 0;
    }

    .ts-register-link:hover { text-decoration: underline; }

    /* ── Quick-add modal ── */
    .qa-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, .55);
        align-items: center;
        justify-content: center;
        z-index: 1080;
        padding: 1rem;
    }

    .qa-overlay.open { display: flex; }

    .qa-modal {
        background: #fff;
        border-radius: 12px;
        width: 100%;
        max-width: 560px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
    }

    .qa-modal-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid var(--border);
    }

    .qa-modal-head h5 {
        display: flex;
        align-items: center;
        gap: .55rem;
        font-size: .95rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .qa-icon {
        width: 26px;
        height: 26px;
        border-radius: 7px;
        background: #D0520818;
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .qa-close {
        background: none;
        border: none;
        color: var(--muted);
        font-size: 1rem;
        cursor: pointer;
        line-height: 1;
        padding: .25rem;
    }

    .qa-close:hover { color: var(--danger); }

    .qa-modal-body { padding: 1.5rem; }

    .qa-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .qa-row.full { grid-template-columns: 1fr; }

    .qa-field-error {
        font-size: .72rem;
        color: var(--danger);
        margin: .35rem 0 0;
        display: none;
    }

    .qa-field-error.show { display: block; }

    .qa-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: .75rem;
        padding: 1.1rem 1.5rem;
        border-top: 1px solid var(--border);
    }

    .qa-spinner {
        display: none;
        width: 14px;
        height: 14px;
        border: 2px solid rgba(255, 255, 255, .4);
        border-top-color: #fff;
        border-radius: 50%;
        animation: qa-spin .6s linear infinite;
    }

    .qa-saving .qa-spinner { display: inline-block; }
    .qa-saving .qa-save-label { display: none; }

    @keyframes qa-spin { to { transform: rotate(360deg); } }

    @media (max-width: 560px) {
        .qa-row { grid-template-columns: 1fr; }
    }
</style>

{{-- ── QUICK-ADD MODAL (matches create view) ── --}}
<div class="qa-overlay" id="qaOverlay">
    <div class="qa-modal" role="dialog" aria-modal="true" aria-labelledby="qaTitle">
        <div class="qa-modal-head">
            <h5 id="qaTitle">
                <span class="qa-icon">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </span>
                Register New Client
            </h5>
            <button class="qa-close" id="qaCloseBtn" aria-label="Close">✕</button>
        </div>

        <div class="qa-modal-body">
            <div id="qaServerError" class="hp-alert hp-alert-danger" style="display:none; margin-bottom:.9rem;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4m0 4h.01" />
                </svg>
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

<div class="lp-page">

    {{-- ── Page heading ── --}}
    <div class="lp-heading">
        <div class="lp-heading-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
            </svg>
        </div>
        <div>
            <h4>Edit Land Property</h4>
            <p>Editing: <strong>{{ $land->title }}</strong> &mdash; Last updated {{ $land->updated_at->diffForHumans() }}</p>
        </div>
        <div class="lp-heading-badge" style="margin-left:auto">
            <span class="lp-status-dot"></span>
            @php
                $statusMap = ['pending'=>'Pending Review','approved'=>'Approved','rejected'=>'Rejected'];
            @endphp
            {{ $statusMap[$land->status] ?? ucfirst($land->status) }}
        </div>
    </div>

    {{-- ── Steps ── --}}
    <div class="lp-steps">
        <div class="lp-step done">
            <span class="lp-step-num">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
            </span> Property Info
        </div>
        <div class="lp-step-sep"></div>
        <div class="lp-step done">
            <span class="lp-step-num">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
            </span> Location
        </div>
        <div class="lp-step-sep"></div>
        <div class="lp-step done">
            <span class="lp-step-num">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
            </span> Media
        </div>
        <div class="lp-step-sep"></div>
        <div class="lp-step active">
            <span class="lp-step-num">4</span> Review
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if ($errors->any())
    <div class="lp-alert lp-alert-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem">
            <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
        </svg>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    </div>
    @endif

    @if (session('success'))
    <div class="lp-alert lp-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <path d="M20 6 9 17l-5-5"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($land->status === 'rejected' && $land->rejection_reason)
    <div class="lp-alert lp-alert-warning">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem">
            <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><path d="M12 9v4m0 4h.01"/>
        </svg>
        <div>
            <strong>This listing was rejected.</strong> Reason: {{ $land->rejection_reason }}
            <br><small>Update the details below and resubmit for review.</small>
        </div>
    </div>
    @endif

    <form method="POST"
          action="{{ route('admin.properties.lands.update', $land) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ══ SECTION 1 — Property Details ══ --}}
        <div class="lp-card">
            <div class="lp-card-header">
                <div class="lp-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <h6>Property Details</h6>
                <span>Step 1 of 4</span>
            </div>
            <div class="lp-card-body">
                <div class="row g-4">

                    {{-- Title --}}
                    <div class="col-md-6">
                        <label class="lp-label">Property Title <span class="req">*</span></label>
                        <input type="text" name="title"
                            class="lp-input @error('title') is-invalid @enderror"
                            placeholder="e.g. Prime Residential Plot in Kicukiro"
                            value="{{ old('title', $land->title) }}" required>
                        @error('title')<p class="lp-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                            {{ $message }}
                        </p>@enderror
                    </div>

                    {{-- UPI --}}
                    <div class="col-md-6">
                        <label class="lp-label">Land UPI</label>
                        <input type="text" name="upi"
                            class="lp-input @error('upi') is-invalid @enderror"
                            placeholder="e.g. 1/01/01/01/1234"
                            value="{{ old('upi', $land->upi) }}">
                        <p class="lp-hint">Unique Parcel Identifier from RLMUA.</p>
                        @error('upi')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Price --}}
                    <div class="col-md-4">
                        <label class="lp-label">Price <span class="req">*</span></label>
                        <div class="lp-input-group">
                            <span class="lp-input-group-text">$</span>
                            <input type="number" name="price"
                                class="lp-input @error('price') is-invalid @enderror"
                                placeholder="0.00" min="0" step="0.01"
                                value="{{ old('price', $land->price) }}" required>
                        </div>
                        @error('price')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Negotiable --}}
                    <div class="col-md-4">
                        <label class="lp-label">Negotiable <span class="req">*</span></label>
                        <select name="negotiable" class="lp-select @error('negotiable') is-invalid @enderror" required>
                            <option value="negotiable" {{ old('negotiable', $land->negotiable) === 'negotiable' ? 'selected' : '' }}>Negotiable</option>
                            <option value="non_negotiable" {{ old('negotiable', $land->negotiable) === 'non_negotiable' ? 'selected' : '' }}>Non Negotiable</option>
                        </select>
                        @error('negotiable')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    <!-- Currency -->
                    <div class="col-md-4">
                        <label class="lp-label">Currency <span class="req">*</span></label>
                        <select name="currency" class="lp-select @error('currency') is-invalid @enderror" required>
                            <option value="RWF" {{ old('currency', $land->currency) === 'RWF' ? 'selected' : '' }}>Rwandan Franc (RWF)</option>
                            <option value="USD" {{ old('currency', $land->currency) === 'USD'  ? 'selected' : '' }}>US Dollar (USD)</option>
                            <option value="EUR" {{ old('currency', $land->currency) === 'EUR'  ? 'selected' : '' }}>Euro (EUR)</option>
                            <!-- Add more currencies as needed -->
                        </select>
                        @error('currency')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Area --}}
                    <div class="col-md-4">
                        <label class="lp-label">Area <span class="req">*</span></label>
                        <div class="lp-input-group">
                            <input type="number" name="size_sqm"
                                class="lp-input @error('size_sqm') is-invalid @enderror"
                                placeholder="0" min="1"
                                value="{{ old('size_sqm', $land->size_sqm) }}" required
                                style="border-radius:8px 0 0 8px;border-right:none;">
                            <span class="lp-input-group-text" style="border-left:none;border-radius:0 8px 8px 0;">sqm</span>
                        </div>
                        @error('size_sqm')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Condition --}}
                    <div class="col-md-4">
                        <label class="lp-label">Condition <span class="req">*</span></label>
                        <select name="condition" class="lp-select @error('condition') is-invalid @enderror" required>
                            <option value="for_rent"  {{ old('condition', $land->condition) === 'for_rent'  ? 'selected' : '' }}>For Rent</option>
                            <option value="for_sale"  {{ old('condition', $land->condition) === 'for_sale'  ? 'selected' : '' }}>For Sale</option>
                        </select>
                        @error('condition')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-md-4">
                                <label class="hp-label">Category <span class="req">*</span></label>
                                <select name="service_id" class="hp-select @error('service_id') is-invalid @enderror" required>
                                    <option value="">Select category</option>
                                    @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id', $land->service_id) == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                                    @endforeach
                                </select>
                                @error('service_id')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                    {{-- Land Use --}}
                    <div class="col-md-6">
                        <label class="lp-label">Land Use <span class="req">*</span></label>
                        <select name="land_use" class="lp-select @error('land_use') is-invalid @enderror" required>
                            <option value="">Select land use</option>
                            @foreach([
                                'Residential'         => 'Residential',
                                'Commercial'          => 'Commercial',
                                'Industrial'          => 'Industrial',
                                'Agricultural'        => 'Agricultural',
                                'Mixed-use'           => 'Mixed-use',
                                'Institutional'       => 'Institutional',
                                'Recreational'        => 'Recreational',
                                'Conservation'        => 'Conservation',
                                'Transportation'      => 'Transportation',
                                'Hospitality & Tourism' => 'Hospitality & Tourism',
                            ] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('land_use', $land->land_use) === $val ? 'selected' : '' }}>
                                {{ $lbl }}
                            </option>
                            @endforeach
                        </select>
                        @error('land_use')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Zoning --}}
                    <div class="col-md-6">
                        <label class="lp-label">Zoning Type <span class="req">*</span></label>
                        <div class="lp-zone-grid">
                            @php
                            $zones = [
                                'R1'           => 'R1 Low density',
                                'R2'           => 'R2 Medium density',
                                'R3'           => 'R3 High density',
                                'R4'           => 'R4 High density',
                                'Commercial'   => 'Commercial',
                                'Industrial'   => 'Industrial',
                                'Agricultural' => 'Agricultural',
                            ];
                            @endphp
                            @foreach($zones as $val => $lbl)
                            <input type="radio" name="zoning" id="zone_{{ $val }}"
                                value="{{ $val }}" class="lp-zone-item"
                                {{ old('zoning', $land->zoning) === $val ? 'checked' : '' }}>
                            <label for="zone_{{ $val }}" class="lp-zone-label">
                                <span class="lp-zone-dot"></span>{{ $lbl }}
                            </label>
                            @endforeach
                        </div>
                        @error('zoning')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label class="lp-label">Description</label>
                        <textarea name="description"
                            class="lp-textarea @error('description') is-invalid @enderror"
                            rows="4"
                            placeholder="Describe the land — access roads, utilities, surrounding amenities…">{{ old('description', $land->description) }}</textarea>
                        @error('description')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ══ SECTION 2 — Location ══ --}}
        <div class="lp-card">
            <div class="lp-card-header">
                <div class="lp-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <h6>Location Details</h6>
                <span>Step 2 of 4</span>
            </div>
            <div class="lp-card-body">
                {{-- Pass $land to the shared form include so it can pre-fill location fields --}}
                @include('includes.form', ['model' => $land])

                <!-- Location Details Form longitude and latitude Fields -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="lp-label">Latitude</label>
                        <input type="text" name="latitude"
                               class="lp-input @error('latitude') is-invalid @enderror"
                               value="{{ old('latitude', $land->latitude) }}"
                               placeholder="-1.970579">
                        @error('latitude')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="lp-label">Longitude</label>
                        <input type="text" name="longitude"
                               class="lp-input @error('longitude') is-invalid @enderror"
                               value="{{ old('longitude', $land->longitude) }}"
                               placeholder="30.104429">
                        @error('longitude')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ SECTION 3 — Media ══ --}}
        <div class="lp-card">
            <div class="lp-card-header">
                <div class="lp-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="18" height="18" x="3" y="3" rx="2"/>
                        <circle cx="9" cy="9" r="2"/>
                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                    </svg>
                </div>
                <h6>Photos &amp; Documents</h6>
                <span>Step 3 of 4</span>
            </div>
            <div class="lp-card-body">
                <div class="row g-4">

                    {{-- ── Images ── --}}
                    <div class="col-12">
                        <label class="lp-label">Property Photos</label>

                        {{-- Existing images --}}
                        @if($land->images && $land->images->count())
                        <div class="lp-existing-images">
                            <div class="lp-existing-label">{{ $land->images->count() }} existing photo{{ $land->images->count() > 1 ? 's' : '' }}</div>
                            <div class="lp-previews" id="existingImageGrid">
                                @foreach($land->images as $img)
                                <div class="lp-preview-item" id="existing-{{ $img->id }}">
                                    <img src="{{ asset('image/lands/' . $img->image_path) }}" alt="Property photo">
                                    {{-- Hidden input: initially NOT checked (= keep) --}}
                                    <input type="checkbox" name="delete_images[]"
                                        value="{{ $img->id }}"
                                        id="del_img_{{ $img->id }}"
                                        style="display:none">
                                    <button type="button" class="lp-preview-remove"
                                        onclick="toggleDeleteImage({{ $img->id }})"
                                        title="Mark for deletion">✕</button>
                                    <button type="button" class="lp-preview-undo"
                                        onclick="toggleDeleteImage({{ $img->id }})">Undo</button>
                                </div>
                                @endforeach
                            </div>
                            <p class="lp-hint" style="margin-top:.6rem">Click ✕ on a photo to mark it for removal. Changes apply on save.</p>
                        </div>
                        @endif

                        {{-- New image upload --}}
                        <div class="lp-dropzone" id="imageDropzone">
                            <input type="file" name="images[]" id="imageInput" accept="image/*" multiple>
                            <div class="lp-dropzone-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" x2="12" y1="3" y2="15"/>
                                </svg>
                            </div>
                            <h6>Add more photos</h6>
                            <p>Drag &amp; drop or <span class="lp-browse">browse files</span> — JPG, PNG, WEBP, up to 5MB each</p>
                        </div>
                        <div class="lp-previews" id="imagePreviews"></div>
                        @error('images.*')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- ── Video URL ── --}}
                    <div class="col-12">
                        <label class="lp-label">Video URL</label>
                        <input type="text" name="video_url" class="lp-input @error('video_url') is-invalid @enderror" placeholder="Enter video URL" value="{{ old('video_url', $land->video_url) }}">
                        @error('video_url')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- ── Title Deed ── --}}
                    <div class="col-12">
                        <label class="lp-label">Title Deed / Document</label>

                        @if($land->title_doc)
                        <div class="lp-existing-doc" id="existingDocRow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                            <span>Current document:&nbsp;
                                <a href="{{ Storage::url($land->title_doc) }}" target="_blank">
                                    {{ basename($land->title_doc) }}
                                </a>
                            </span>
                            <button type="button" class="lp-replace-toggle" onclick="showDocReplace()">Replace</button>
                        </div>
                        <input type="hidden" name="keep_title_doc" value="1" id="keepTitleDoc">
                        <div id="docReplaceArea" style="display:none">
                        @endif

                            <div class="lp-file-btn" id="titleDocBtn">
                                <input type="file" name="title_doc" id="titleDocInput"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                <div class="lp-file-btn-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                    </svg>
                                </div>
                                <div class="lp-file-btn-text">
                                    <strong id="titleDocName">
                                        {{ $land->title_doc ? 'Choose replacement file' : 'Click to upload title deed' }}
                                    </strong>
                                    PDF, JPG, PNG — max 4MB
                                </div>
                            </div>

                            @if($land->title_doc)
                            <button type="button" onclick="cancelDocReplace()" style="margin-top:.5rem;font-size:.75rem;color:var(--muted);background:none;border:none;cursor:pointer;padding:0;">
                                ← Keep existing document
                            </button>
                            </div>{{-- #docReplaceArea --}}
                            @endif

                        <p class="lp-hint">Optional. Upload the official land title or ownership document.</p>
                        @error('title_doc')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ── Listing Package ── --}}
        <div class="lp-card">
            <div class="lp-card-header">
                <div class="lp-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="20" height="14" x="2" y="5" rx="2" />
                        <line x1="2" x2="22" y1="10" y2="10" />
                    </svg>
                </div>
                <h6>Listing Package</h6>
            </div>
            <div class="lp-card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="lp-label">Listing Package <span class="req">*</span></label>
                        <select name="listing_package_id" id="listingPackageSelect" class="lp-select @error('listing_package_id') is-invalid @enderror" onchange="recalcFee()" required>
                            <option value="">Select a package</option>
                            @foreach($packages as $pkg)
                            <option value="{{ $pkg->id }}"
                                data-price="{{ $pkg->price_per_day }}"
                                data-agent-pct="{{ $pkg->agent_commission_pct }}"
                                data-terra-pct="{{ $pkg->terra_share_pct }}"
                                {{ old('listing_package_id', $land->listing_package_id) == $pkg->id ? 'selected' : '' }}>
                               {{ $pkg->listing_type }} - {{ ucfirst($pkg->package_tier) }}
                                — RWF {{ number_format($pkg->price_per_day) }}/day
                                (you earn {{ $pkg->agent_commission_pct }}%)
                            </option>
                            @endforeach
                        </select>
                        @error('listing_package_id')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="lp-label">Listing Duration (days) <span class="req">*</span></label>
                        <input type="number" name="listing_days" id="listingDaysInput" class="lp-input @error('listing_days') is-invalid @enderror"
                            value="{{ old('listing_days', $land->listing_days ?? 30) }}"
                            min="1" oninput="recalcFee()" required>
                        <p class="lp-hint">31-59 days: 10% off &nbsp;·&nbsp; 60-89 days: 15% off &nbsp;·&nbsp; 90+ days: 20% off</p>
                        @error('listing_days')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Fee breakdown --}}
                    <div class="col-12" id="feeBreakdown" style="display:none;">
                        <div class="lp-alert" style="background:var(--surface); border:1px solid var(--border); color:var(--text); margin-bottom:0;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;color:var(--accent)">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 16v-4m0-4h.01" />
                            </svg>
                            <div style="width:100%;">
                                <div style="display:flex; justify-content:space-between; font-size:.82rem; margin-bottom:.3rem;">
                                    <span>Base fee (before discount)</span>
                                    <strong id="feeBase">RWF 0</strong>
                                </div>
                                <div style="display:flex; justify-content:space-between; font-size:.82rem; margin-bottom:.3rem;">
                                    <span id="feeDiscountLabel">Discount</span>
                                    <strong id="feeDiscount">RWF 0</strong>
                                </div>
                                <div style="display:flex; justify-content:space-between; font-size:.88rem; margin-bottom:.3rem; padding-top:.4rem; border-top:1px dashed var(--border);">
                                    <span><strong>Total listing fee</strong></span>
                                    <strong id="feeTotal" style="color:var(--accent);">RWF 0</strong>
                                </div>
                                <div style="display:flex; justify-content:space-between; font-size:.78rem; color:var(--text-dim);">
                                    <span>Your commission</span>
                                    <span id="feeAgentShare">RWF 0</span>
                                </div>
                                <div style="display:flex; justify-content:space-between; font-size:.78rem; color:var(--text-dim);">
                                    <span>Terra share</span>
                                    <span id="feeTerraShare">RWF 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Property Owner (client search — aligned with create view) ── --}}
        <div class="lp-card">
            <div class="lp-card-header">
                <div class="lp-card-header-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <h6>Property Owner</h6>
            </div>
            <div class="lp-card-body">

                <input type="hidden" name="client_id" id="clientIdField" value="{{ old('client_id', $land->client_id ?? '') }}">

                <label class="lp-label">Search Client <span class="req">*</span></label>
                <p class="lp-hint" style="margin-bottom:.6rem;">Type a name, phone, or email to find a registered client.</p>

                <select id="clientSearch" autocomplete="off"></select>

                @error('client_id')
                <p class="lp-error" style="margin-top:.45rem;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8v4m0 4h.01" />
                    </svg>
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
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 8v8M8 12h8" />
                    </svg>
                    Client not found? Register new client
                </button>

            </div>
        </div>

        {{-- ══ Submit bar ══ --}}
        <div class="lp-submit-bar">
            <span class="lp-submit-bar-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
                </svg>
                Changes will be saved and re-submitted for review.
            </span>
            <a href="{{ route('admin.properties.lands.index') }}" class="lp-btn lp-btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Cancel
            </a>
            <a href="{{ route('admin.properties.lands.show', $land) }}" class="lp-btn lp-btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>
                </svg>
                View Listing
            </a>
            <button type="submit" class="lp-btn lp-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                </svg>
                Save Changes
            </button>
        </div>

    </form>
</div>

<script>
(function () {
    'use strict';

    /* Whole script lives inside one IIFE so re-rendering this page via
       SPA-style navigation (Turbo/Livewire wire:navigate) can't throw
       "Identifier has already been declared" and kill the script the
       second time it runs. */

    /* ── New image previews ── */
    const imageInput    = document.getElementById('imageInput');
    const imagePreviews = document.getElementById('imagePreviews');
    const imageDropzone = document.getElementById('imageDropzone');
    let selectedFiles   = [];

    imageInput.addEventListener('change', () => addFiles(imageInput.files));

    imageDropzone.addEventListener('dragover', e => {
        e.preventDefault();
        imageDropzone.classList.add('dragover');
    });
    imageDropzone.addEventListener('dragleave', () => imageDropzone.classList.remove('dragover'));
    imageDropzone.addEventListener('drop', e => {
        e.preventDefault();
        imageDropzone.classList.remove('dragover');
        addFiles(e.dataTransfer.files);
    });

    function addFiles(files) {
        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            selectedFiles.push(file);
            const reader = new FileReader();
            reader.onload = e => renderPreview(e.target.result, selectedFiles.length - 1);
            reader.readAsDataURL(file);
        });
        syncInput();
    }

    function renderPreview(src, idx) {
        const div = document.createElement('div');
        div.className = 'lp-preview-item';
        div.dataset.idx = idx;
        div.innerHTML = `<img src="${src}" alt="preview">
            <button type="button" class="lp-preview-remove" onclick="removePreview(${idx})">✕</button>`;
        imagePreviews.appendChild(div);
    }

    function removePreview(idx) {
        selectedFiles[idx] = null;
        document.querySelector(`.lp-preview-item[data-idx="${idx}"]`)?.remove();
        syncInput();
    }
    /* Referenced from an inline onclick="" attribute above — must stay global. */
    window.removePreview = removePreview;

    function syncInput() {
        const dt = new DataTransfer();
        selectedFiles.filter(Boolean).forEach(f => dt.items.add(f));
        imageInput.files = dt.files;
    }

    /* ── Toggle delete existing images ── */
    function toggleDeleteImage(id) {
        const item     = document.getElementById(`existing-${id}`);
        const checkbox = document.getElementById(`del_img_${id}`);
        const isMarked = item.classList.toggle('marked-delete');
        checkbox.checked = isMarked;
    }
    /* Referenced from inline onclick="" attributes on existing photos — must stay global. */
    window.toggleDeleteImage = toggleDeleteImage;

    /* ── Title doc replace toggle ── */
    function showDocReplace() {
        document.getElementById('docReplaceArea').style.display = 'block';
        document.getElementById('existingDocRow').style.opacity = '.4';
        document.getElementById('existingDocRow').style.pointerEvents = 'none';
        document.getElementById('keepTitleDoc').value = '0';
    }

    function cancelDocReplace() {
        document.getElementById('docReplaceArea').style.display = 'none';
        document.getElementById('existingDocRow').style.opacity = '1';
        document.getElementById('existingDocRow').style.pointerEvents = '';
        document.getElementById('keepTitleDoc').value = '1';
        document.getElementById('titleDocInput').value = '';
        document.getElementById('titleDocName').textContent = 'Choose replacement file';
    }
    /* Referenced from inline onclick="" attributes above — must stay global. */
    window.showDocReplace = showDocReplace;
    window.cancelDocReplace = cancelDocReplace;

    /* ── New title doc filename ── */
    document.getElementById('titleDocInput').addEventListener('change', function () {
        document.getElementById('titleDocName').textContent =
            this.files[0] ? this.files[0].name : 'Choose replacement file';
    });

    /* ── Listing fee calculator (same logic/markup as the create form) ── */
    function recalcFee() {
        const select = document.getElementById('listingPackageSelect');
        const daysInput = document.getElementById('listingDaysInput');
        const breakdown = document.getElementById('feeBreakdown');
        const opt = select.options[select.selectedIndex];

        const pricePerDay = parseFloat(opt?.dataset.price);
        const agentPct = parseFloat(opt?.dataset.agentPct);
        const terraPct = parseFloat(opt?.dataset.terraPct);
        const days = parseInt(daysInput.value, 10);

        if (!opt || !opt.value || isNaN(pricePerDay) || !days || days < 1) {
            breakdown.style.display = 'none';
            return;
        }

        let discountPct = 0;
        if (days >= 90) discountPct = 20;
        else if (days >= 60) discountPct = 15;
        else if (days >= 31) discountPct = 10;

        const base = pricePerDay * days;
        const discountAmount = base * (discountPct / 100);
        const total = base - discountAmount;
        const agentShare = total * ((agentPct || 0) / 100);
        const terraShare = total * ((terraPct || 0) / 100);

        const fmt = n => 'RWF ' + Math.round(n).toLocaleString('en-US');

        document.getElementById('feeBase').textContent = fmt(base);
        document.getElementById('feeDiscountLabel').textContent =
            discountPct > 0 ? `Discount (${discountPct}%)` : 'Discount';
        document.getElementById('feeDiscount').textContent = '-' + fmt(discountAmount);
        document.getElementById('feeTotal').textContent = fmt(total);
        document.getElementById('feeAgentShare').textContent = fmt(agentShare);
        document.getElementById('feeTerraShare').textContent = fmt(terraShare);

        breakdown.style.display = '';
    }
    /* Referenced from inline onchange="" / oninput="" attributes above — must stay global. */
    window.recalcFee = recalcFee;

    /* Run immediately: this script sits at the bottom of the page, so the
       DOM is already parsed and 'DOMContentLoaded' has already fired by
       the time we get here — a listener for it would never run. Calling
       directly ensures the pre-selected package/duration show their fee
       breakdown right away instead of only after the user touches a field. */
    recalcFee();

    /* ── Type colours for client badges ── */
    const TYPE_COLORS = {
        owner:     { bg: '#d1fae5', color: '#065f46' },
        agent:     { bg: '#dbeafe', color: '#1e40af' },
        developer: { bg: '#ede9fe', color: '#5b21b6' },
        company:   { bg: '#fef3c7', color: '#92400e' },
    };

    function ucFirst(s) {
        return s ? s.charAt(0).toUpperCase() + s.slice(1) : '';
    }

    /* ── Client preview ── */
    function showPreview(c) {
        document.getElementById('clientIdField').value = c.id;
        document.getElementById('cpAvatar').textContent = c.full_name.charAt(0).toUpperCase();
        document.getElementById('cpName').textContent = c.full_name;

        const parts = [];
        if (c.phone) parts.push('📞 ' + c.phone);
        if (c.email) parts.push('✉️ ' + c.email);
        if (c.district) parts.push('📍 ' + c.district);
        document.getElementById('cpMeta').textContent = parts.join('  ·  ');

        const tc = TYPE_COLORS[c.client_type] || { bg: '#f3f4f6', color: '#374151' };
        const badge = document.getElementById('cpBadge');
        badge.textContent = ucFirst(c.client_type);
        badge.style.background = tc.bg;
        badge.style.color = tc.color;

        document.getElementById('clientPreview').classList.add('visible');
    }

    /* Mutable reference to the Tom Select instance. Stays null if init below
       fails or the library never loaded — every place that uses it guards
       against that instead of assuming it always exists. */
    let tomSelect = null;

    function clearClient() {
        document.getElementById('clientIdField').value = '';
        document.getElementById('clientPreview').classList.remove('visible');
        if (tomSelect) {
            tomSelect.clear(true);
            tomSelect.focus();
        }
    }

    document.getElementById('cpClearBtn').addEventListener('click', clearClient);

    /* ── Quick-add modal (wired up unconditionally, independent of Tom Select) ── */
    const qaOverlay = document.getElementById('qaOverlay');

    function openQAModal() {
        const typed = tomSelect?.lastQuery || '';
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
    qaOverlay.addEventListener('click', e => {
        if (e.target === qaOverlay) closeQAModal();
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && qaOverlay.classList.contains('open')) closeQAModal();
    });

    /* Delegated click for "Register new client" (used both by the Tom Select
       no_results row and by the plain-input fallback rendered if Tom Select
       never initializes). */
    document.addEventListener('click', function(e) {
        if (e.target.closest('[data-action="openQA"]')) openQAModal();
    });

    /* Company field toggle */
    document.getElementById('qa_client_type').addEventListener('change', function() {
        const show = this.value === 'company' || this.value === 'developer';
        document.getElementById('qaCompanyRow').style.display = show ? '' : 'none';
    });

    /* ── Validation helpers ── */
    function clearQAErrors() {
        document.querySelectorAll('.qa-field-error').forEach(el => {
            el.textContent = '';
            el.classList.remove('show');
        });
        document.querySelectorAll('#qaOverlay .hp-input').forEach(el => el.classList.remove('is-invalid'));
    }

    function showQAFieldError(inputId, errSuffix, msg) {
        const input = document.getElementById(inputId);
        const err = document.getElementById('qaErr_' + errSuffix);
        if (input) input.classList.add('is-invalid');
        if (err) {
            err.textContent = msg;
            err.classList.add('show');
        }
    }

    function hideQAServerError() {
        document.getElementById('qaServerError').style.display = 'none';
    }

    function showQAServerError(msg) {
        document.getElementById('qaServerErrorText').textContent = msg;
        document.getElementById('qaServerError').style.display = 'flex';
    }

    function validateQA() {
        clearQAErrors();
        let ok = true;
        const name = document.getElementById('qa_full_name').value.trim();
        const phone = document.getElementById('qa_phone').value.trim();
        const email = document.getElementById('qa_email').value.trim();

        if (!name) {
            showQAFieldError('qa_full_name', 'full_name', 'Full name is required.');
            ok = false;
        }
        if (!phone) {
            showQAFieldError('qa_phone', 'phone', 'Phone number is required.');
            ok = false;
        } else if (!/^[+\d\s\-()\/.]{7,20}$/.test(phone)) {
            showQAFieldError('qa_phone', 'phone', 'Enter a valid phone number.');
            ok = false;
        }
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showQAFieldError('qa_email', 'email', 'Enter a valid email address.');
            ok = false;
        }
        return ok;
    }

    /* ── Save new client ── */
    document.getElementById('qaSaveBtn').addEventListener('click', function() {
        if (!validateQA()) return;

        this.classList.add('qa-saving');
        this.disabled = true;

        const payload = {
            full_name: document.getElementById('qa_full_name').value.trim(),
            phone: document.getElementById('qa_phone').value.trim(),
            email: document.getElementById('qa_email').value.trim() || null,
            client_type: document.getElementById('qa_client_type').value,
            company_name: document.getElementById('qa_company_name')?.value.trim() || null,
            national_id: document.getElementById('qa_national_id').value.trim() || null,
        };

        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        if (!csrfMeta) {
            console.error('[lands-edit] Missing <meta name="csrf-token"> in <head> — cannot save client. Add it to layouts.app.');
            document.getElementById('qaSaveBtn').classList.remove('qa-saving');
            document.getElementById('qaSaveBtn').disabled = false;
            showQAServerError('Page is missing its CSRF token meta tag. Please contact support.');
            return;
        }

        fetch("{{ route('admin.clients.quick-add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfMeta.content,
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
                        const map = {
                            full_name: 'full_name',
                            phone: 'phone',
                            email: 'email',
                            national_id: 'national_id'
                        };
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

                if (tomSelect) {
                    tomSelect.addOption(data);
                    tomSelect.setValue(data.id, true);
                } else {
                    document.getElementById('clientIdField').value = data.id;
                }
                showPreview(data);
                closeQAModal();

                ['qa_full_name', 'qa_phone', 'qa_email', 'qa_company_name', 'qa_national_id'].forEach(id => {
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

    /* ── Tom Select client search ──
       Isolated in its own try/catch so that if TomSelect never loaded
       (CDN blocked, offline, slow network) this degrades to a plain
       text input instead of throwing and breaking everything below it. */
    try {
        if (typeof TomSelect === 'undefined') {
            throw new Error('TomSelect library is not loaded (check network/CDN access to jsdelivr.net).');
        }

        /* Destroy any stale instance (Turbo / Livewire SPA navigation) */
        if (window.__houseFormTS) {
            try { window.__houseFormTS.destroy(); } catch (_) {}
        }

        window.__houseFormTS = new TomSelect('#clientSearch', {
            valueField: 'id',
            labelField: 'full_name',
            searchField: ['full_name', 'phone', 'email'],
            placeholder: 'Type a name, phone, or email…',
            maxOptions: 15,
            preload: false,
            shouldLoad: q => q.length >= 2,

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
                    const sub = data.phone ?
                        `<div class="ts-opt-sub">${escape(data.phone)}${data.email ? ' · '+escape(data.email) : ''}</div>` :
                        '';
                    return `<div><div class="ts-opt-name">${escape(data.full_name)}${badge}</div>${sub}</div>`;
                },
                item(data, escape) {
                    return `<span>${escape(data.full_name)}</span>`;
                },
                no_results() {
                    return `<div class="ts-no-results-row">
                        No client found.
                        <button type="button" class="ts-register-link" data-action="openQA">+ Register new client</button>
                    </div>`;
                },
            },

            onChange(id) {
                if (!id) {
                    clearClient();
                    return;
                }
                const item = window.__houseFormTS.options[id];
                if (item) showPreview(item);
            },
        });

        tomSelect = window.__houseFormTS;

        /* Prefill the search box with the land's current owner/client, whether
           it comes from an old() validation redirect or the land record itself. */
        (function restoreCurrentClient() {
            const currentId = {!! json_encode(old('client_id', $land->client_id ?? null)) !!};
            if (!currentId) return;
            fetch(`{{ route('admin.clients.search') }}?id=${encodeURIComponent(currentId)}`, {
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

    } catch (err) {
        console.error('[lands-edit] Client search widget failed to initialize, falling back to a plain input:', err);

        /* Fallback: turn #clientSearch into a plain text box wired to the
           existing quick-add flow, so the form is still usable even when
           Tom Select can't load. Search-by-typing is lost, but "Register
           new client" (and everything else on the page) keeps working. */
        const fallbackSelect = document.getElementById('clientSearch');
        if (fallbackSelect) {
            const fallbackInput = document.createElement('input');
            fallbackInput.type = 'text';
            fallbackInput.className = 'hp-input';
            fallbackInput.placeholder = 'Client search is unavailable right now — use "Register new client" below.';
            fallbackInput.disabled = true;
            fallbackSelect.replaceWith(fallbackInput);
        }

        /* Prefill even without Tom Select, so we don't silently drop the
           land's existing owner/client on a validation redirect. */
        (function restoreCurrentClientFallback() {
            const currentId = {!! json_encode(old('client_id', $land->client_id ?? null)) !!};
            if (!currentId) return;
            fetch(`{{ route('admin.clients.search') }}?id=${encodeURIComponent(currentId)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(data => {
                    if (!data.length) return;
                    document.getElementById('clientIdField').value = data[0].id;
                    showPreview(data[0]);
                })
                .catch(() => {});
        }());
    }

})();
</script>

@endsection