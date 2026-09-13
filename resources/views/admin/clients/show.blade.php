@extends('layouts.app')

@section('title', $client->full_name . ' – Client Detail – Terra Admin')

@section('content')

@php

    $typeColors = [
        'owner'     => ['bg' => '#d1fae5', 'color' => '#065f46'],
        'agent'     => ['bg' => '#dbeafe', 'color' => '#1e40af'],
        'developer' => ['bg' => '#ede9fe', 'color' => '#5b21b6'],
        'company'   => ['bg' => '#fef3c7', 'color' => '#92400e'],
    ];

    $tc = $typeColors[$client->client_type] ?? [
        'bg' => '#f3f4f6',
        'color' => '#374151'
    ];

    $allProperties = $client->houses->map(fn($h) => (object)[
        'id'        => $h->id,
        'title'     => $h->title,
        'type'      => 'House',
        'condition' => $h->condition ?? null,
        'status'    => $h->status ?? 'available',
        'price'     => $h->price ?? 0,
        'district'  => $h->district ?? null,
        'sector'    => $h->sector ?? null,
        'thumbnail' => $h->thumbnail ?? $h->image ?? null,
        'created_at'=> $h->created_at,
        'route'     => route('admin.properties.houses.show', $h->id),
    ])->concat(

        $client->lands->map(fn($l) => (object)[
            'id'        => $l->id,
            'title'     => $l->title,
            'type'      => 'Land',
            'condition' => $l->condition ?? null,
            'status'    => $l->status ?? 'available',
            'price'     => $l->price ?? 0,
            'district'  => $l->district ?? null,
            'sector'    => $l->sector ?? null,
            'thumbnail' => $l->thumbnail ?? $l->image ?? null,
            'created_at'=> $l->created_at,
            'route'     => route('admin.properties.lands.show', $l->id),
        ])

    )->sortByDesc('created_at');

@endphp

<style>

    :root {
        --terra-orange: #D05208;
        --terra-orange-dark: #a94106;
        --terra-navy: #19265d;
        --terra-navy-dark: #111a45;

        --terra-light: #f0faf5;
        --terra-border-green: #c3e6d3;

        --terra-text: #1a1a2e;
        --terra-muted: #6b7280;

        --terra-border: #e5e7eb;
        --terra-bg: #f8fafc;
        --terra-white: #ffffff;

        --terra-danger: #dc2626;

        --terra-radius: 12px;
        --terra-shadow: 0 2px 12px rgba(0, 0, 0, .06);
        --terra-shadow-lg: 0 12px 35px rgba(0, 0, 0, .12);
    }

    /* =========================================================
       GLOBAL
    ========================================================= */

    .client-detail-page {
        width: 100%;
        max-width: 1600px;
        margin: 0 auto;
    }

    .client-detail-page *,
    .client-detail-page *::before,
    .client-detail-page *::after {
        box-sizing: border-box;
    }

    .svg-icon {
        width: 18px;
        height: 18px;
        display: inline-block;
        flex-shrink: 0;
        stroke: currentColor;
    }

    .svg-icon-sm {
        width: 15px;
        height: 15px;
    }

    .svg-icon-lg {
        width: 22px;
        height: 22px;
    }

    .svg-icon-xl {
        width: 32px;
        height: 32px;
    }

    /* =========================================================
       BREADCRUMB
    ========================================================= */

    .detail-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;

        margin-bottom: 22px;

        color: var(--terra-muted);
        font-size: 13px;
    }

    .detail-breadcrumb a {
        display: inline-flex;
        align-items: center;
        gap: 5px;

        color: var(--terra-orange);
        text-decoration: none;
        font-weight: 600;
    }

    .detail-breadcrumb a:hover {
        color: var(--terra-orange-dark);
    }

    .detail-breadcrumb .separator {
        color: #cbd5e1;
    }

    /* =========================================================
       HERO
    ========================================================= */

    .client-hero {
        position: relative;
        overflow: hidden;

        display: flex;
        align-items: center;
        gap: 20px;

        padding: 28px 30px;
        margin-bottom: 24px;

        border-radius: var(--terra-radius);

        background:
            linear-gradient(
                135deg,
                var(--terra-orange) 0%,
                #b84707 38%,
                var(--terra-navy) 100%
            );

        color: #fff;

        box-shadow: var(--terra-shadow);
    }

    .client-hero::before {
        content: "";
        position: absolute;

        width: 260px;
        height: 260px;

        right: -90px;
        top: -120px;

        border-radius: 50%;

        border: 1px solid rgba(255,255,255,.12);
        box-shadow:
            0 0 0 35px rgba(255,255,255,.025),
            0 0 0 70px rgba(255,255,255,.02);

        pointer-events: none;
    }

    .client-hero::after {
        content: "";

        position: absolute;

        width: 180px;
        height: 180px;

        right: 100px;
        bottom: -130px;

        border-radius: 50%;

        background: rgba(255,255,255,.04);

        pointer-events: none;
    }

    .hero-avatar {
        position: relative;
        z-index: 1;

        width: 76px;
        height: 76px;

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        background: rgba(255,255,255,.15);

        border: 3px solid rgba(255,255,255,.35);

        color: #fff;

        font-size: 28px;
        font-weight: 800;

        flex-shrink: 0;
    }

    .hero-body {
        position: relative;
        z-index: 1;

        flex: 1;
        min-width: 0;
    }

    .hero-name {
        margin: 0 0 7px;

        color: #fff;

        font-size: clamp(1.25rem, 2vw, 1.65rem);
        line-height: 1.25;
        font-weight: 800;

        word-break: break-word;
    }

    .hero-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px 16px;

        color: rgba(255,255,255,.86);

        font-size: 13px;
    }

    .hero-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        min-width: 0;
    }

    .hero-meta svg {
        opacity: .85;
    }

    .hero-side {
        position: relative;
        z-index: 1;

        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;

        flex-shrink: 0;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;

        padding: 5px 13px;

        border-radius: 999px;

        font-size: 11px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-hero {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        min-height: 38px;
        padding: 8px 15px;

        border-radius: 8px;

        font-size: 13px;
        font-weight: 700;

        cursor: pointer;
        text-decoration: none;

        transition:
            background .2s ease,
            border-color .2s ease,
            transform .2s ease;
    }

    .btn-hero:hover {
        transform: translateY(-1px);
    }

    .btn-hero-edit {
        color: #fff;

        background: rgba(255,255,255,.13);

        border: 1px solid rgba(255,255,255,.35);
    }

    .btn-hero-edit:hover {
        color: #fff;
        background: rgba(255,255,255,.23);
    }

    .btn-hero-delete {
        color: #fff;

        background: rgba(220,38,38,.25);

        border: 1px solid rgba(255,255,255,.18);
    }

    .btn-hero-delete:hover {
        color: #fff;
        background: rgba(220,38,38,.42);
    }

    /* =========================================================
       MAIN LAYOUT
    ========================================================= */

    .detail-layout {
        display: grid;
        grid-template-columns: minmax(280px, 320px) minmax(0, 1fr);

        gap: 24px;

        align-items: start;
    }

    .detail-sidebar,
    .detail-main {
        min-width: 0;

        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .detail-main {
        gap: 26px;
    }

    /* =========================================================
       INFORMATION CARDS
    ========================================================= */

    .info-card {
        overflow: hidden;

        background: var(--terra-white);

        border: 1px solid var(--terra-border);
        border-radius: var(--terra-radius);

        box-shadow: var(--terra-shadow);
    }

    .info-card-header {
        display: flex;
        align-items: center;
        gap: 9px;

        padding: 14px 18px;

        background: var(--terra-bg);

        border-bottom: 1px solid var(--terra-border);

        color: var(--terra-muted);

        font-size: 11px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .075em;
    }

    .info-card-header svg {
        color: var(--terra-orange);
    }

    .info-row {
        display: flex;
        align-items: flex-start;

        gap: 14px;

        padding: 13px 18px;

        border-bottom: 1px solid var(--terra-border);

        font-size: 14px;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        width: 100px;

        flex-shrink: 0;

        padding-top: 1px;

        color: var(--terra-muted);

        font-size: 12px;
        font-weight: 600;
    }

    .info-value {
        min-width: 0;

        color: var(--terra-text);

        font-size: 13px;
        font-weight: 600;

        word-break: break-word;
    }

    .info-value a {
        color: var(--terra-orange);
        text-decoration: none;
    }

    .info-value a:hover {
        text-decoration: underline;
    }

    /* =========================================================
       PILLS
    ========================================================= */

    .pill {
        display: inline-flex;
        align-items: center;

        padding: 4px 10px;

        border-radius: 999px;

        font-size: 10px;
        line-height: 1.3;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .045em;
    }

    .pill-active {
        background: #d1fae5;
        color: #065f46;
    }

    .pill-inactive {
        background: #f3f4f6;
        color: #6b7280;
    }

    /* =========================================================
       NOTES
    ========================================================= */

    .notes-content {
        padding: 16px 18px;
    }

    .notes-box {
        display: flex;
        align-items: flex-start;
        gap: 10px;

        padding: 13px 14px;

        background: #fffbeb;

        border: 1px solid #fde68a;
        border-radius: 9px;

        color: #78350f;

        font-size: 13px;
        line-height: 1.65;
    }

    .notes-box svg {
        margin-top: 2px;
        flex-shrink: 0;
    }

    /* =========================================================
       QUICK ACTIONS
    ========================================================= */

    .quick-actions {
        display: flex;
        flex-direction: column;
        gap: 9px;

        padding: 14px 18px;
    }

    .quick-action {
        display: flex;
        align-items: center;
        gap: 10px;

        width: 100%;

        padding: 11px 13px;

        border-radius: 8px;

        font-size: 13px;
        font-weight: 700;

        text-decoration: none;

        transition:
            transform .2s ease,
            box-shadow .2s ease,
            background .2s ease;
    }

    .quick-action:hover {
        transform: translateY(-1px);
    }

    .quick-action-call {
        color: var(--terra-orange);

        background: #fff7f2;

        border: 1px solid #f8d8c5;
    }

    .quick-action-call:hover {
        color: var(--terra-orange-dark);
        background: #fff2eb;
    }

    .quick-action-whatsapp {
        color: #047857;

        background: #ecfdf5;

        border: 1px solid #a7f3d0;
    }

    .quick-action-whatsapp:hover {
        color: #065f46;
        background: #dff9ed;
    }

    .quick-action-email {
        color: #1d4ed8;

        background: #eff6ff;

        border: 1px solid #bfdbfe;
    }

    .quick-action-email:hover {
        color: #1e40af;
        background: #e7f0ff;
    }

    /* =========================================================
       SECTION HEADER
    ========================================================= */

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        margin-bottom: 13px;
    }

    .section-title-wrap {
        display: flex;
        align-items: center;
        gap: 9px;

        min-width: 0;
    }

    .section-title-icon {
        width: 34px;
        height: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        color: var(--terra-orange);

        background: #fff7f2;

        border: 1px solid #f8d8c5;

        border-radius: 8px;
    }

    .section-title {
        color: var(--terra-text);

        font-size: 16px;
        font-weight: 800;
    }

    .section-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-width: 27px;
        height: 24px;

        padding: 0 8px;

        background: var(--terra-bg);

        border: 1px solid var(--terra-border);
        border-radius: 999px;

        color: var(--terra-muted);

        font-size: 11px;
        font-weight: 800;
    }

    /* =========================================================
       PROPERTY TABLE
    ========================================================= */

    .prop-table-wrap {
        width: 100%;

        overflow-x: auto;

        background: var(--terra-white);

        border: 1px solid var(--terra-border);
        border-radius: var(--terra-radius);

        box-shadow: var(--terra-shadow);

        -webkit-overflow-scrolling: touch;
    }

    .prop-table {
        width: 100%;

        min-width: 850px;

        border-collapse: collapse;
    }

    .prop-table thead tr {
        background: var(--terra-bg);

        border-bottom: 1px solid var(--terra-border);
    }

    .prop-table th {
        padding: 12px 14px;

        color: var(--terra-muted);

        font-size: 10px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .065em;

        white-space: nowrap;
    }

    .prop-table td {
        padding: 12px 14px;

        color: var(--terra-text);

        font-size: 13px;

        vertical-align: middle;

        border-bottom: 1px solid var(--terra-border);
    }

    .prop-table tbody tr:last-child td {
        border-bottom: none;
    }

    .prop-table tbody tr {
        transition: background .15s ease;
    }

    .prop-table tbody tr:hover {
        background: #fafcfb;
    }

    /* =========================================================
       PROPERTY CELL
    ========================================================= */

    .prop-title-cell {
        display: flex;
        align-items: center;
        gap: 11px;

        min-width: 250px;
    }

    .prop-thumb,
    .prop-thumb-placeholder {
        width: 54px;
        height: 42px;

        flex-shrink: 0;

        border-radius: 7px;
    }

    .prop-thumb {
        object-fit: cover;

        background: var(--terra-bg);

        border: 1px solid var(--terra-border);
    }

    .prop-thumb-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;

        color: var(--terra-orange);

        background: #fff7f2;

        border: 1px solid #f8d8c5;
    }

    .prop-title-content {
        min-width: 0;
    }

    .prop-title {
        overflow: hidden;

        color: var(--terra-text);

        font-weight: 700;

        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .prop-location {
        display: flex;
        align-items: center;
        gap: 4px;

        margin-top: 3px;

        color: var(--terra-muted);

        font-size: 11px;
    }

    .prop-location svg {
        width: 12px;
        height: 12px;

        flex-shrink: 0;
    }

    /* =========================================================
       BADGES
    ========================================================= */

    .cond-badge {
        display: inline-flex;
        align-items: center;

        padding: 4px 9px;

        border-radius: 999px;

        font-size: 10px;
        font-weight: 800;

        white-space: nowrap;
    }

    .cond-for_sale {
        background: #dbeafe;
        color: #1e40af;
    }

    .cond-for_rent {
        background: #d1fae5;
        color: #065f46;
    }

    .status-available {
        background: #d1fae5;
        color: #065f46;
    }

    .status-sold {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-reserved {
        background: #fef3c7;
        color: #92400e;
    }

    .status-rented {
        background: #ede9fe;
        color: #5b21b6;
    }

    .price-value {
        color: var(--terra-orange);

        font-size: 13px;
        font-weight: 800;

        white-space: nowrap;
    }

    .property-view-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;

        color: var(--terra-orange);

        font-size: 12px;
        font-weight: 700;

        text-decoration: none;
        white-space: nowrap;
    }

    .property-view-link:hover {
        color: var(--terra-orange-dark);
        text-decoration: underline;
    }

    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .prop-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        min-height: 220px;

        padding: 35px 20px;

        text-align: center;

        color: var(--terra-muted);
    }

    .prop-empty-icon {
        width: 56px;
        height: 56px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 12px;

        color: var(--terra-orange);

        background: #fff7f2;

        border: 1px solid #f8d8c5;

        border-radius: 14px;
    }

    .prop-empty-title {
        color: var(--terra-text);

        font-size: 14px;
        font-weight: 700;
    }

    .prop-empty-text {
        margin-top: 4px;

        font-size: 12px;
    }

    /* =========================================================
       TIMELINE
    ========================================================= */

    .timeline {
        list-style: none;

        margin: 0;
        padding: 0;
    }

    .timeline-item {
        position: relative;

        display: flex;
        gap: 13px;

        padding: 14px 18px;

        border-bottom: 1px solid var(--terra-border);
    }

    .timeline-item:last-child {
        border-bottom: none;
    }

    .timeline-dot {
        width: 34px;
        height: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 50%;
    }

    .dot-green {
        color: #047857;
        background: #d1fae5;
    }

    .dot-blue {
        color: #1d4ed8;
        background: #dbeafe;
    }

    .dot-amber {
        color: #b45309;
        background: #fef3c7;
    }

    .timeline-body {
        min-width: 0;
    }

    .tl-title {
        color: var(--terra-text);

        font-size: 13px;
        font-weight: 700;

        line-height: 1.45;
    }

    .tl-time {
        margin-top: 3px;

        color: var(--terra-muted);

        font-size: 11px;
    }

    /* =========================================================
       MODALS
    ========================================================= */

    .client-detail-page + .modal,
    .modal {
        --bs-modal-border-radius: 14px;
    }

    .modal-content {
        overflow: hidden;

        border: none;
        border-radius: 14px;

        box-shadow: var(--terra-shadow-lg);
    }

    .modal-header {
        display: flex;
        align-items: center;
        gap: 10px;

        padding: 17px 22px;

        background:
            linear-gradient(
                135deg,
                var(--terra-orange),
                var(--terra-navy)
            );

        border-bottom: none;
    }

    .modal-header .modal-title {
        display: flex;
        align-items: center;
        gap: 8px;

        color: #fff;

        font-size: 16px;
        font-weight: 800;
    }

    .modal-header .btn-close {
        margin-left: auto;

        filter: invert(1);

        opacity: .8;
    }

    .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 22px;

        background: #fff;
    }

    .modal-footer {
        padding: 14px 22px;

        background: var(--terra-bg);

        border-top: 1px solid var(--terra-border);
    }

    /* =========================================================
       FORM
    ========================================================= */

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 7px;

        margin: 18px 0 13px;
        padding-bottom: 8px;

        color: var(--terra-muted);

        border-bottom: 1px solid var(--terra-border);

        font-size: 10px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .form-section-title:first-child {
        margin-top: 0;
    }

    .form-grid-2 {
        display: grid;

        grid-template-columns: repeat(2, minmax(0, 1fr));

        gap: 14px;
    }

    .form-group-terra {
        min-width: 0;
    }

    .form-label-terra {
        display: block;

        margin-bottom: 6px;

        color: var(--terra-muted);

        font-size: 11px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .055em;
    }

    .form-control-terra,
    .form-select-terra {
        display: block;

        width: 100%;

        min-height: 42px;

        padding: 9px 12px;

        color: var(--terra-text);

        background: #fff;

        border: 1.5px solid var(--terra-border);
        border-radius: 8px;

        outline: none;

        font-family: inherit;
        font-size: 13px;

        transition:
            border-color .2s ease,
            box-shadow .2s ease;
    }

    .form-control-terra:focus,
    .form-select-terra:focus {
        border-color: var(--terra-orange);

        box-shadow:
            0 0 0 3px rgba(208,80,8,.08);
    }

    .form-control-terra.is-invalid {
        border-color: var(--terra-danger);
    }

    .btn-terra,
    .btn-cancel,
    .btn-confirm-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        min-height: 40px;

        padding: 9px 17px;

        border-radius: 8px;

        font-size: 13px;
        font-weight: 700;

        cursor: pointer;

        transition:
            background .2s ease,
            border-color .2s ease,
            transform .2s ease;
    }

    .btn-terra {
        color: #fff;

        background: var(--terra-orange);

        border: 1px solid var(--terra-orange);
    }

    .btn-terra:hover {
        color: #fff;

        background: var(--terra-orange-dark);

        border-color: var(--terra-orange-dark);

        transform: translateY(-1px);
    }

    .btn-cancel {
        color: var(--terra-text);

        background: #fff;

        border: 1.5px solid var(--terra-border);
    }

    .btn-cancel:hover {
        color: var(--terra-orange);

        border-color: var(--terra-orange);

        background: #fffaf7;
    }

    /* =========================================================
       DELETE MODAL
    ========================================================= */

    .delete-modal .modal-header {
        background:
            linear-gradient(
                135deg,
                #dc2626,
                #991b1b
            );
    }

    .delete-warning {
        display: flex;
        align-items: flex-start;
        gap: 10px;

        padding: 14px 15px;
        margin-bottom: 16px;

        background: #fef2f2;

        border: 1px solid #fecaca;
        border-radius: 9px;

        color: #7f1d1d;

        font-size: 13px;
        line-height: 1.55;
    }

    .delete-warning svg {
        flex-shrink: 0;
        margin-top: 1px;
    }

    .delete-client-preview {
        display: flex;
        align-items: center;
        gap: 12px;

        padding: 13px 15px;

        background: var(--terra-bg);

        border: 1px solid var(--terra-border);
        border-radius: 9px;
    }

    .delete-avatar {
        width: 43px;
        height: 43px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 50%;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--terra-orange),
                var(--terra-navy)
            );

        font-size: 16px;
        font-weight: 800;
    }

    .delete-client-name {
        color: var(--terra-text);

        font-size: 14px;
        font-weight: 800;
    }

    .delete-client-phone {
        margin-top: 2px;

        color: var(--terra-muted);

        font-size: 12px;
    }

    .btn-confirm-delete {
        color: #fff;

        background: var(--terra-danger);

        border: 1px solid var(--terra-danger);
    }

    .btn-confirm-delete:hover {
        color: #fff;

        background: #b91c1c;

        border-color: #b91c1c;

        transform: translateY(-1px);
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1100px) {

        .detail-layout {
            grid-template-columns: 280px minmax(0, 1fr);
            gap: 18px;
        }

        .client-hero {
            padding: 24px;
        }

        .hero-meta {
            gap: 8px 12px;
        }

    }

    @media (max-width: 900px) {

        .detail-layout {
            grid-template-columns: 1fr;
        }

        .detail-sidebar {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            align-items: start;
        }

        .detail-sidebar > .info-card:last-child {
            grid-column: 1 / -1;
        }

        .client-hero {
            align-items: flex-start;
        }

    }

    @media (max-width: 700px) {

        .client-hero {
            display: grid;

            grid-template-columns: auto minmax(0, 1fr);

            gap: 15px;

            padding: 20px;
        }

        .hero-avatar {
            width: 62px;
            height: 62px;

            font-size: 23px;
        }

        .hero-side {
            grid-column: 1 / -1;

            width: 100%;

            align-items: stretch;
        }

        .hero-badge {
            align-self: flex-start;
        }

        .hero-actions {
            width: 100%;
        }

        .btn-hero {
            flex: 1;
        }

        .detail-sidebar {
            grid-template-columns: 1fr;
        }

        .detail-sidebar > .info-card:last-child {
            grid-column: auto;
        }

    }

    @media (max-width: 576px) {

        .client-detail-page {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .detail-breadcrumb {
            margin-bottom: 15px;

            font-size: 12px;
        }

        .client-hero {
            margin-bottom: 18px;

            border-radius: 10px;

            padding: 18px;
        }

        .hero-name {
            font-size: 1.15rem;
        }

        .hero-meta {
            display: grid;
            grid-template-columns: 1fr;

            gap: 5px;

            font-size: 12px;
        }

        .hero-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .btn-hero {
            width: 100%;

            padding-left: 10px;
            padding-right: 10px;
        }

        .info-card-header {
            padding: 13px 15px;
        }

        .info-row {
            gap: 9px;

            padding: 12px 15px;
        }

        .info-label {
            width: 82px;

            font-size: 11px;
        }

        .info-value {
            font-size: 12px;
        }

        .quick-actions {
            padding: 13px 15px;
        }

        .section-header {
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 14px;
        }

        .section-title-icon {
            width: 30px;
            height: 30px;
        }

        .modal-dialog {
            margin: .75rem;
        }

        .modal-body {
            padding: 17px;
        }

        .modal-footer {
            padding: 12px 17px;
        }

        .form-grid-2 {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .modal-footer {
            display: flex;
            gap: 8px;
        }

        .modal-footer > button {
            flex: 1;
        }

    }

    @media (max-width: 400px) {

        .client-hero {
            grid-template-columns: 1fr;
        }

        .hero-avatar {
            width: 58px;
            height: 58px;
        }

        .hero-side {
            grid-column: auto;
        }

        .hero-actions {
            grid-template-columns: 1fr;
        }

        .hero-badge {
            align-self: flex-start;
        }

        .info-row {
            display: block;
        }

        .info-label {
            display: block;

            width: auto;

            margin-bottom: 4px;
        }

    }

</style>


<div class="container-fluid px-4 py-4 client-detail-page">

    {{-- =========================================================
         BREADCRUMB
    ========================================================== --}}

    <div class="detail-breadcrumb">

        <a href="{{ route('admin.clients.index') }}">

            <svg class="svg-icon svg-icon-sm"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke-width="2">
                <path d="M15 18l-6-6 6-6"/>
            </svg>

            Clients

        </a>

        <span class="separator">/</span>

        <span>{{ $client->full_name }}</span>

    </div>


    {{-- =========================================================
         HERO
    ========================================================== --}}

    <div class="client-hero">

        <div class="hero-avatar">
            {{ strtoupper(substr($client->full_name, 0, 1)) }}
        </div>

        <div class="hero-body">

            <div class="hero-name">
                {{ $client->full_name }}
            </div>

            <div class="hero-meta">

                @if($client->phone)

                    <span>
                        <svg class="svg-icon svg-icon-sm"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                                     19.79 19.79 0 0 1-8.63-3.07
                                     19.5 19.5 0 0 1-6-6
                                     19.79 19.79 0 0 1-3.07-8.67
                                     A2 2 0 0 1 4.11 2h3
                                     a2 2 0 0 1 2 1.72
                                     12.84 12.84 0 0 0 .7 2.81
                                     2 2 0 0 1-.45 2.11L8.09 9.91
                                     a16 16 0 0 0 6 6l1.27-1.27
                                     a2 2 0 0 1 2.11-.45
                                     12.84 12.84 0 0 0 2.81.7
                                     A2 2 0 0 1 22 16.92z"/>
                        </svg>

                        {{ $client->phone }}
                    </span>

                @endif


                @if($client->email)

                    <span>

                        <svg class="svg-icon svg-icon-sm"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12
                                     c0 1.1-.9 2-2 2H4
                                     c-1.1 0-2-.9-2-2V6
                                     c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>

                        {{ $client->email }}

                    </span>

                @endif


                @if($client->district)

                    <span>

                        <svg class="svg-icon svg-icon-sm"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke-width="2">
                            <path d="M21 10c0 7-9 12-9 12S3 17 3 10
                                     a9 9 0 1 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>

                        {{ $client->district }}{{ $client->province ? ', '.$client->province : '' }}

                    </span>

                @endif


                <span>

                    <svg class="svg-icon svg-icon-sm"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke-width="2">
                        <path d="M3 21h18"/>
                        <path d="M5 21V9l7-5 7 5v12"/>
                        <path d="M9 21v-6h6v6"/>
                    </svg>

                    {{ $client->properties_count }}
                    {{ Str::plural('property', $client->properties_count) }}

                </span>

            </div>

        </div>


        <div class="hero-side">

            <span class="hero-badge"
                  style="background:{{ $tc['bg'] }}; color:{{ $tc['color'] }};">

                {{ ucfirst($client->client_type) }}

            </span>


            <div class="hero-actions">

                <button
                    type="button"
                    class="btn-hero btn-hero-edit"
                    onclick="openEditModal()">

                    <svg class="svg-icon svg-icon-sm"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke-width="2">
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3
                                 L7 19l-4 1 1-4L16.5 3.5z"/>
                    </svg>

                    Edit

                </button>


                <button
                    type="button"
                    class="btn-hero btn-hero-delete"
                    onclick="openDeleteModal()">

                    <svg class="svg-icon svg-icon-sm"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/>
                        <path d="M10 11v6"/>
                        <path d="M14 11v6"/>
                        <path d="M9 6V4h6v2"/>
                    </svg>

                    Delete

                </button>

            </div>

        </div>

    </div>


    {{-- =========================================================
         MAIN TWO COLUMN LAYOUT
    ========================================================== --}}

    <div class="detail-layout">


        {{-- =====================================================
             LEFT SIDEBAR
        ====================================================== --}}

        <div class="detail-sidebar">


            {{-- CONTACT INFORMATION --}}

            <div class="info-card">

                <div class="info-card-header">

                    <svg class="svg-icon svg-icon-sm"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8
                                 a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>

                    Contact Information

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Phone
                    </span>

                    <span class="info-value">

                        @if($client->phone)

                            <a href="tel:{{ $client->phone }}">
                                {{ $client->phone }}
                            </a>

                        @else

                            <span style="color:var(--terra-muted);">
                                Not provided
                            </span>

                        @endif

                    </span>

                </div>


                @if($client->email)

                    <div class="info-row">

                        <span class="info-label">
                            Email
                        </span>

                        <span class="info-value">

                            <a href="mailto:{{ $client->email }}">
                                {{ $client->email }}
                            </a>

                        </span>

                    </div>

                @endif


                @if($client->national_id)

                    <div class="info-row">

                        <span class="info-label">
                            National ID
                        </span>

                        <span class="info-value">
                            {{ $client->national_id }}
                        </span>

                    </div>

                @endif


                @if($client->company_name)

                    <div class="info-row">

                        <span class="info-label">
                            Company
                        </span>

                        <span class="info-value">
                            {{ $client->company_name }}
                        </span>

                    </div>

                @endif

            </div>


            {{-- LOCATION --}}

            <div class="info-card">

                <div class="info-card-header">

                    <svg class="svg-icon svg-icon-sm"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke-width="2">
                        <path d="M21 10c0 7-9 12-9 12S3 17 3 10
                                 a9 9 0 1 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>

                    Location

                </div>


                @if($client->province)

                    <div class="info-row">

                        <span class="info-label">
                            Province
                        </span>

                        <span class="info-value">
                            {{ $client->province }}
                        </span>

                    </div>

                @endif


                @if($client->district)

                    <div class="info-row">

                        <span class="info-label">
                            District
                        </span>

                        <span class="info-value">
                            {{ $client->district }}
                        </span>

                    </div>

                @endif


                @if($client->sector)

                    <div class="info-row">

                        <span class="info-label">
                            Sector
                        </span>

                        <span class="info-value">
                            {{ $client->sector }}
                        </span>

                    </div>

                @endif


                @if(!$client->province && !$client->district && !$client->sector)

                    <div class="info-row">

                        <span class="info-label">
                            Location
                        </span>

                        <span class="info-value"
                              style="color:var(--terra-muted);">

                            Not provided

                        </span>

                    </div>

                @endif

            </div>


            {{-- ACCOUNT DETAILS --}}

            <div class="info-card">

                <div class="info-card-header">

                    <svg class="svg-icon svg-icon-sm"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 16v-4"/>
                        <path d="M12 8h.01"/>
                    </svg>

                    Account Details

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Status
                    </span>

                    <span class="info-value">

                        <span class="pill {{ $client->is_active ? 'pill-active' : 'pill-inactive' }}">

                            {{ $client->is_active ? 'Active' : 'Inactive' }}

                        </span>

                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Type
                    </span>

                    <span class="info-value">

                        <span class="pill"
                              style="background:{{ $tc['bg'] }}; color:{{ $tc['color'] }};">

                            {{ ucfirst($client->client_type) }}

                        </span>

                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Registered
                    </span>

                    <span class="info-value">
                        {{ $client->created_at->format('d M Y') }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Added by
                    </span>

                    <span class="info-value">
                        {{ $client->createdBy->name ?? '—' }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Last update
                    </span>

                    <span class="info-value">
                        {{ $client->updated_at->diffForHumans() }}
                    </span>

                </div>

            </div>


            {{-- NOTES --}}

            @if($client->notes)

                <div class="info-card">

                    <div class="info-card-header">

                        <svg class="svg-icon svg-icon-sm"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke-width="2">
                            <path d="M21 15a4 4 0 0 1-4 4H8l-5 3
                                     V7a4 4 0 0 1 4-4h10
                                     a4 4 0 0 1 4 4z"/>
                        </svg>

                        Notes

                    </div>


                    <div class="notes-content">

                        <div class="notes-box">

                            <svg class="svg-icon svg-icon-sm"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke-width="2">
                                <path d="M12 9v4"/>
                                <path d="M12 17h.01"/>
                                <path d="M10.3 3.9L2.5 17
                                         a2 2 0 0 0 1.7 3h15.6
                                         a2 2 0 0 0 1.7-3L13.7 3.9
                                         a2 2 0 0 0-3.4 0z"/>
                            </svg>

                            <span>
                                {{ $client->notes }}
                            </span>

                        </div>

                    </div>

                </div>

            @endif


            {{-- QUICK ACTIONS --}}

            <div class="info-card">

                <div class="info-card-header">

                    <svg class="svg-icon svg-icon-sm"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke-width="2">
                        <path d="M13 2L3 14h9l-1 8
                                 10-12h-9l1-8z"/>
                    </svg>

                    Quick Actions

                </div>


                <div class="quick-actions">

                    @if($client->phone)

                        <a href="tel:{{ $client->phone }}"
                           class="quick-action quick-action-call">

                            <svg class="svg-icon"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                                         19.79 19.79 0 0 1-8.63-3.07
                                         19.5 19.5 0 0 1-6-6
                                         19.79 19.79 0 0 1-3.07-8.67
                                         A2 2 0 0 1 4.11 2h3
                                         a2 2 0 0 1 2 1.72
                                         12.84 12.84 0 0 0 .7 2.81
                                         2 2 0 0 1-.45 2.11L8.09 9.91
                                         a16 16 0 0 0 6 6l1.27-1.27
                                         a2 2 0 0 1 2.11-.45
                                         12.84 12.84 0 0 0 2.81.7
                                         A2 2 0 0 1 22 16.92z"/>
                            </svg>

                            Call Client

                        </a>


                        <a
                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $client->phone) }}?text={{ urlencode('Hello '.$client->full_name.', this is Terra Real Estate.') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="quick-action quick-action-whatsapp">

                            <svg class="svg-icon"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke-width="2">
                                <path d="M21 11.5a8.38 8.38 0 0 1-9
                                         8.5 8.44 8.44 0 0 1-4.1-1.05
                                         L3 20l1.1-4.6
                                         A8.38 8.38 0 1 1 21 11.5z"/>
                                <path d="M8.5 9.5c.2 2.4 2.6 4.8
                                         5 5l1.2-1.2"/>
                            </svg>

                            WhatsApp

                            <svg class="svg-icon svg-icon-sm"
                                 style="margin-left:auto;"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke-width="2">
                                <path d="M14 3h7v7"/>
                                <path d="M10 14L21 3"/>
                            </svg>

                        </a>

                    @endif


                    @if($client->email)

                        <a href="mailto:{{ $client->email }}"
                           class="quick-action quick-action-email">

                            <svg class="svg-icon"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12
                                         c0 1.1-.9 2-2 2H4
                                         c-1.1 0-2-.9-2-2V6
                                         c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>

                            Send Email

                        </a>

                    @endif

                </div>

            </div>

        </div>


        {{-- =====================================================
             RIGHT MAIN CONTENT
        ====================================================== --}}

        <div class="detail-main">


            {{-- =================================================
                 PROPERTIES
            ================================================== --}}

            <div>

                <div class="section-header">

                    <div class="section-title-wrap">

                        <div class="section-title-icon">

                            <svg class="svg-icon"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke-width="2">
                                <path d="M3 21h18"/>
                                <path d="M5 21V9l7-5 7 5v12"/>
                                <path d="M9 21v-6h6v6"/>
                            </svg>

                        </div>

                        <span class="section-title">
                            Properties
                        </span>

                        <span class="section-count">
                            {{ $client->properties_count }}
                        </span>

                    </div>

                </div>


                <div class="prop-table-wrap">

                    @if($client->properties_count > 0)

                        <table class="prop-table">

                            <thead>

                                <tr>
                                    <th>Property</th>
                                    <th>Type</th>
                                    <th>Condition</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Listed</th>
                                    <th></th>
                                </tr>

                            </thead>


                            <tbody>

                                @foreach($allProperties as $prop)

                                    <tr>

                                        <td>

                                            <div class="prop-title-cell">

                                                @if($prop->thumbnail)

                                                    <img
                                                        src="{{ asset('storage/'.$prop->thumbnail) }}"
                                                        alt="{{ $prop->title }}"
                                                        class="prop-thumb">

                                                @else

                                                    <div class="prop-thumb-placeholder">

                                                        @if($prop->type === 'Land')

                                                            <svg class="svg-icon"
                                                                 viewBox="0 0 24 24"
                                                                 fill="none"
                                                                 stroke-width="2">
                                                                <path d="M3 20h18"/>
                                                                <path d="M5 20V8l7-5 7 5v12"/>
                                                                <path d="M9 20v-6h6v6"/>
                                                            </svg>

                                                        @else

                                                            <svg class="svg-icon"
                                                                 viewBox="0 0 24 24"
                                                                 fill="none"
                                                                 stroke-width="2">
                                                                <path d="M3 21h18"/>
                                                                <path d="M5 21V9l7-5 7 5v12"/>
                                                                <path d="M9 21v-6h6v6"/>
                                                            </svg>

                                                        @endif

                                                    </div>

                                                @endif


                                                <div class="prop-title-content">

                                                    <div class="prop-title">
                                                        {{ $prop->title }}
                                                    </div>

                                                    <div class="prop-location">

                                                        <svg
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="2">
                                                            <path d="M21 10c0 7-9 12-9 12S3 17 3 10
                                                                     a9 9 0 1 1 18 0z"/>
                                                            <circle cx="12" cy="10" r="3"/>
                                                        </svg>

                                                        <span>
                                                            {{ $prop->sector ?? '' }}
                                                            {{ $prop->district ? ', '.$prop->district : '' }}
                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </td>


                                        <td style="color:var(--terra-muted);">
                                            {{ $prop->type }}
                                        </td>


                                        <td>

                                            <span class="cond-badge cond-{{ $prop->condition ?? 'for_sale' }}">

                                                {{ ucfirst(str_replace('_', ' ', $prop->condition ?? 'For Sale')) }}

                                            </span>

                                        </td>


                                        <td>

                                            <span class="price-value">

                                                RWF {{ number_format($prop->price) }}

                                            </span>

                                        </td>


                                        <td>

                                            <span class="cond-badge status-{{ $prop->status }}">

                                                {{ ucfirst($prop->status) }}

                                            </span>

                                        </td>


                                        <td style="color:var(--terra-muted); white-space:nowrap;">

                                            {{ $prop->created_at->format('d M Y') }}

                                        </td>


                                        <td>

                                            <a
                                                href="{{ $prop->route }}"
                                                class="property-view-link">

                                                View

                                                <svg
                                                    class="svg-icon svg-icon-sm"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke-width="2">
                                                    <path d="M7 17L17 7"/>
                                                    <path d="M7 7h10v10"/>
                                                </svg>

                                            </a>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    @else

                        <div class="prop-empty">

                            <div class="prop-empty-icon">

                                <svg class="svg-icon-xl"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke-width="1.7">
                                    <path d="M3 21h18"/>
                                    <path d="M5 21V9l7-5 7 5v12"/>
                                    <path d="M9 21v-6h6v6"/>
                                </svg>

                            </div>

                            <div class="prop-empty-title">
                                No properties listed yet
                            </div>

                            <div class="prop-empty-text">
                                Properties associated with this client will appear here.
                            </div>

                        </div>

                    @endif

                </div>

            </div>


            {{-- =================================================
                 ACTIVITY TIMELINE
            ================================================== --}}

            <div>

                <div class="section-header">

                    <div class="section-title-wrap">

                        <div class="section-title-icon">

                            <svg class="svg-icon"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke-width="2">
                                <circle cx="12" cy="12" r="9"/>
                                <polyline points="12 7 12 12 15 14"/>
                            </svg>

                        </div>

                        <span class="section-title">
                            Activity Timeline
                        </span>

                    </div>

                </div>


                <div class="info-card">

                    <ul class="timeline">


                        {{-- CLIENT CREATED --}}

                        <li class="timeline-item">

                            <div class="timeline-dot dot-green">

                                <svg class="svg-icon svg-icon-sm"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>

                            </div>


                            <div class="timeline-body">

                                <div class="tl-title">
                                    Client registered on Terra
                                </div>

                                <div class="tl-time">

                                    {{ $client->created_at->format('d M Y, H:i') }}

                                    — by

                                    {{ $client->createdBy->name ?? 'Admin' }}

                                </div>

                            </div>

                        </li>


                        {{-- PROPERTY ACTIVITIES --}}

                        @foreach($allProperties->sortByDesc('created_at') as $prop)

                            <li class="timeline-item">

                                <div class="timeline-dot dot-blue">

                                    @if($prop->type === 'Land')

                                        <svg class="svg-icon svg-icon-sm"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke-width="2">
                                            <path d="M3 20h18"/>
                                            <path d="M5 20V8l7-5 7 5v12"/>
                                            <path d="M9 20v-6h6v6"/>
                                        </svg>

                                    @else

                                        <svg class="svg-icon svg-icon-sm"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke-width="2">
                                            <path d="M3 21h18"/>
                                            <path d="M5 21V9l7-5 7 5v12"/>
                                            <path d="M9 21v-6h6v6"/>
                                        </svg>

                                    @endif

                                </div>


                                <div class="timeline-body">

                                    <div class="tl-title">

                                        {{ $prop->type }} listed:
                                        {{ $prop->title }}

                                    </div>

                                    <div class="tl-time">

                                        {{ $prop->created_at->format('d M Y, H:i') }}

                                    </div>

                                </div>

                            </li>

                        @endforeach


                        {{-- PROFILE UPDATED --}}

                        @if($client->updated_at->ne($client->created_at))

                            <li class="timeline-item">

                                <div class="timeline-dot dot-amber">

                                    <svg class="svg-icon svg-icon-sm"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke-width="2">
                                        <path d="M12 20h9"/>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3
                                                 L7 19l-4 1 1-4L16.5 3.5z"/>
                                    </svg>

                                </div>


                                <div class="timeline-body">

                                    <div class="tl-title">
                                        Client profile last updated
                                    </div>

                                    <div class="tl-time">
                                        {{ $client->updated_at->format('d M Y, H:i') }}
                                    </div>

                                </div>

                            </li>

                        @endif


                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     EDIT CLIENT MODAL
============================================================== --}}

<div class="modal fade"
     id="editClientModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    <svg class="svg-icon"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke-width="2">
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3
                                 L7 19l-4 1 1-4L16.5 3.5z"/>
                    </svg>

                    Edit Client

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>


            <form
                method="POST"
                action="{{ route('admin.clients.update', $client->id) }}"
                id="editForm">

                @csrf
                @method('PUT')


                <div class="modal-body">


                    {{-- PERSONAL INFORMATION --}}

                    <div class="form-section-title">

                        <svg class="svg-icon svg-icon-sm"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke-width="2">
                            <circle cx="12" cy="7" r="4"/>
                            <path d="M5.5 21a6.5 6.5 0 0 1 13 0"/>
                        </svg>

                        Personal Information

                    </div>


                    <div class="form-grid-2">

                        <div class="form-group-terra">

                            <label class="form-label-terra">
                                Full Name *
                            </label>

                            <input
                                type="text"
                                name="full_name"
                                class="form-control-terra"
                                value="{{ old('full_name', $client->full_name) }}"
                                required>

                        </div>


                        <div class="form-group-terra">

                            <label class="form-label-terra">
                                National ID
                            </label>

                            <input
                                type="text"
                                name="national_id"
                                class="form-control-terra"
                                value="{{ old('national_id', $client->national_id) }}">

                        </div>


                        <div class="form-group-terra">

                            <label class="form-label-terra">
                                Phone *
                            </label>

                            <input
                                type="tel"
                                name="phone"
                                class="form-control-terra"
                                value="{{ old('phone', $client->phone) }}"
                                required>

                        </div>


                        <div class="form-group-terra">

                            <label class="form-label-terra">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control-terra"
                                value="{{ old('email', $client->email) }}">

                        </div>

                    </div>


                    {{-- CLASSIFICATION --}}

                    <div class="form-section-title">

                        <svg class="svg-icon svg-icon-sm"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8
                                     a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>

                        Client Classification

                    </div>


                    <div class="form-grid-2">

                        <div class="form-group-terra">

                            <label class="form-label-terra">
                                Client Type *
                            </label>

                            <select
                                name="client_type"
                                id="show_client_type"
                                class="form-select-terra"
                                onchange="toggleShowCompany()">

                                @foreach(['owner','agent','developer','company'] as $t)

                                    <option
                                        value="{{ $t }}"
                                        {{ old('client_type', $client->client_type) == $t ? 'selected' : '' }}>

                                        {{ ucfirst($t) }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div
                            id="show_company_wrap"
                            class="form-group-terra">

                            <label class="form-label-terra">
                                Company Name
                            </label>

                            <input
                                type="text"
                                name="company_name"
                                class="form-control-terra"
                                value="{{ old('company_name', $client->company_name) }}">

                        </div>

                    </div>


                    {{-- LOCATION --}}

                    <div class="form-section-title">

                        <svg class="svg-icon svg-icon-sm"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke-width="2">
                            <path d="M21 10c0 7-9 12-9 12S3 17 3 10
                                     a9 9 0 1 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>

                        Location

                    </div>


                    <div class="form-grid-2">

                        <div class="form-group-terra">

                            <label class="form-label-terra">
                                Province
                            </label>

                            <select
                                name="province"
                                class="form-select-terra">

                                <option value="">
                                    Select province
                                </option>

                                @foreach([
                                    'Kigali City',
                                    'Northern',
                                    'Southern',
                                    'Eastern',
                                    'Western'
                                ] as $p)

                                    <option
                                        value="{{ $p }}"
                                        {{ old('province', $client->province) == $p ? 'selected' : '' }}>

                                        {{ $p }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="form-group-terra">

                            <label class="form-label-terra">
                                District
                            </label>

                            <select
                                name="district"
                                class="form-select-terra">

                                <option value="">
                                    Select district
                                </option>

                                @foreach([
                                    'Gasabo',
                                    'Kicukiro',
                                    'Nyarugenge',
                                    'Bugesera',
                                    'Gatsibo',
                                    'Kayonza',
                                    'Kirehe',
                                    'Ngoma',
                                    'Rwamagana',
                                    'Burera',
                                    'Gakenke',
                                    'Gicumbi',
                                    'Musanze',
                                    'Rulindo',
                                    'Gisagara',
                                    'Huye',
                                    'Kamonyi',
                                    'Muhanga',
                                    'Nyamagabe',
                                    'Nyanza',
                                    'Nyaruguru',
                                    'Ruhango',
                                    'Karongi',
                                    'Ngororero',
                                    'Nyabihu',
                                    'Nyamasheke',
                                    'Rubavu',
                                    'Rusizi',
                                    'Rutsiro',
                                    'Nyagatare'
                                ] as $d)

                                    <option
                                        value="{{ $d }}"
                                        {{ old('district', $client->district) == $d ? 'selected' : '' }}>

                                        {{ $d }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="form-group-terra">

                            <label class="form-label-terra">
                                Sector
                            </label>

                            <input
                                type="text"
                                name="sector"
                                class="form-control-terra"
                                value="{{ old('sector', $client->sector) }}">

                        </div>

                    </div>


                    {{-- ADDITIONAL --}}

                    <div class="form-section-title">

                        <svg class="svg-icon svg-icon-sm"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 16v-4"/>
                            <path d="M12 8h.01"/>
                        </svg>

                        Additional

                    </div>


                    <div class="form-grid-2">

                        <div class="form-group-terra">

                            <label class="form-label-terra">
                                Status
                            </label>

                            <select
                                name="is_active"
                                class="form-select-terra">

                                <option
                                    value="1"
                                    {{ old('is_active', $client->is_active) ? 'selected' : '' }}>

                                    Active

                                </option>

                                <option
                                    value="0"
                                    {{ !old('is_active', $client->is_active) ? 'selected' : '' }}>

                                    Inactive

                                </option>

                            </select>

                        </div>

                    </div>


                    <div style="margin-top:14px;">

                        <label class="form-label-terra">
                            Notes
                        </label>

                        <textarea
                            name="notes"
                            class="form-control-terra"
                            rows="3"
                            style="resize:vertical;">{{ old('notes', $client->notes) }}</textarea>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn-cancel"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn-terra">

                        <svg class="svg-icon svg-icon-sm"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5
                                     a2 2 0 0 1 2-2h11l5 5v11
                                     a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>

                        Save Changes

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =============================================================
     DELETE MODAL
============================================================== --}}

<div
    class="modal fade delete-modal"
    id="deleteClientModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    <svg class="svg-icon"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/>
                        <path d="M10 11v6"/>
                        <path d="M14 11v6"/>
                        <path d="M9 6V4h6v2"/>
                    </svg>

                    Delete Client

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>


            <form
                method="POST"
                action="{{ route('admin.clients.destroy', $client->id) }}">

                @csrf
                @method('DELETE')


                <div class="modal-body">


                    <div class="delete-warning">

                        <svg class="svg-icon svg-icon-lg"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke-width="2">
                            <path d="M12 9v4"/>
                            <path d="M12 17h.01"/>
                            <path d="M10.3 3.9L2.5 17
                                     a2 2 0 0 0 1.7 3h15.6
                                     a2 2 0 0 0 1.7-3L13.7 3.9
                                     a2 2 0 0 0-3.4 0z"/>
                        </svg>


                        <div>

                            This will permanently delete

                            <strong>
                                {{ $client->full_name }}
                            </strong>.

                            @if($client->properties_count > 0)

                                Their

                                <strong>
                                    {{ $client->properties_count }}
                                    {{ Str::plural('property', $client->properties_count) }}
                                </strong>

                                will remain on Terra but will no longer be linked to a client.

                            @endif

                        </div>

                    </div>


                    <div class="delete-client-preview">

                        <div class="delete-avatar">

                            {{ strtoupper(substr($client->full_name, 0, 1)) }}

                        </div>


                        <div>

                            <div class="delete-client-name">
                                {{ $client->full_name }}
                            </div>

                            <div class="delete-client-phone">
                                {{ $client->phone }}
                            </div>

                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn-cancel"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn-confirm-delete">

                        <svg class="svg-icon svg-icon-sm"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14H6L5 6"/>
                            <path d="M10 11v6"/>
                            <path d="M14 11v6"/>
                            <path d="M9 6V4h6v2"/>
                        </svg>

                        Yes, Delete

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>

    function openEditModal() {

        const modalElement =
            document.getElementById('editClientModal');

        if (!modalElement) return;

        const modal =
            bootstrap.Modal.getOrCreateInstance(modalElement);

        modal.show();
    }


    function openDeleteModal() {

        const modalElement =
            document.getElementById('deleteClientModal');

        if (!modalElement) return;

        const modal =
            bootstrap.Modal.getOrCreateInstance(modalElement);

        modal.show();
    }


    function toggleShowCompany() {

        const typeElement =
            document.getElementById('show_client_type');

        const companyWrap =
            document.getElementById('show_company_wrap');

        if (!typeElement || !companyWrap) return;

        const type = typeElement.value;

        companyWrap.style.display =
            (type === 'company' || type === 'developer')
                ? ''
                : 'none';
    }


    document.addEventListener('DOMContentLoaded', function () {

        toggleShowCompany();

        @if($errors->any())

            const editModalElement =
                document.getElementById('editClientModal');

            if (editModalElement) {

                bootstrap.Modal
                    .getOrCreateInstance(editModalElement)
                    .show();

            }

        @endif

    });

</script>

@endsection