@extends('layouts.app')

@section('title', $client->full_name . ' – Client Detail – Terra Admin')

@section('content')

@php
$typeColors = [
'owner' => ['bg'=>'#d1fae5','color'=>'#065f46'],
'agent' => ['bg'=>'#dbeafe','color'=>'#1e40af'],
'developer' => ['bg'=>'#ede9fe','color'=>'#5b21b6'],
'company' => ['bg'=>'#fef3c7','color'=>'#92400e'],
];
$tc = $typeColors[$client->client_type] ?? ['bg'=>'#f3f4f6','color'=>'#374151'];
@endphp

<style>
    :root {
        --tp: #2c6e49;
        --tp-dk: #1e4d34;
        --tp-lt: #f0faf5;
        --tp-border: #c3e6d3;
        --accent: #f0a500;
        --text: #1a1a2e;
        --muted: #6b7280;
        --border: #e5e7eb;
        --bg: #f9fafb;
        --white: #ffffff;
        --radius: 10px;
        --shadow: 0 2px 12px rgba(0, 0, 0, .07);
        --shadow-lg: 0 8px 32px rgba(0, 0, 0, .11);
        --danger: #dc2626;
    }

    /* ─── Breadcrumb ──────────────────────────────────────────── */
    .detail-breadcrumb {
        font-size: 13px;
        color: var(--muted);
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .detail-breadcrumb a {
        color: var(--tp);
        text-decoration: none;
        font-weight: 500;
    }

    .detail-breadcrumb a:hover {
        text-decoration: underline;
    }

    .detail-breadcrumb .sep {
        color: var(--border);
    }

    /* ─── Hero Card ───────────────────────────────────────────── */
    .client-hero {
        background: linear-gradient(135deg, var(--tp) 0%, var(--tp-dk) 100%);
        border-radius: var(--radius);
        padding: 28px 32px;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .client-hero::after {
        content: '👤';
        position: absolute;
        right: 24px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 80px;
        opacity: .07;
        pointer-events: none;
    }

    .hero-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .2);
        border: 3px solid rgba(255, 255, 255, .4);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 800;
        color: #fff;
        flex-shrink: 0;
    }

    .hero-body {
        flex: 1;
        min-width: 180px;
    }

    .hero-name {
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .hero-meta {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        font-size: 13px;
        opacity: .85;
    }

    .hero-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .hero-badge {
        padding: 4px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        align-self: flex-start;
        margin-top: 4px;
    }

    .hero-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-self: flex-start;
    }

    .btn-hero-edit {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(255, 255, 255, .18);
        color: #fff;
        border: 1.5px solid rgba(255, 255, 255, .4);
        padding: 9px 18px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }

    .btn-hero-edit:hover {
        background: rgba(255, 255, 255, .3);
        color: #fff;
    }

    .btn-hero-delete {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(220, 38, 38, .25);
        color: #fff;
        border: 1.5px solid rgba(220, 38, 38, .5);
        padding: 9px 18px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
    }

    .btn-hero-delete:hover {
        background: rgba(220, 38, 38, .5);
    }

    /* ─── Detail layout ───────────────────────────────────────── */
    .detail-layout {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 24px;
        align-items: start;
    }

    @media(max-width:900px) {
        .detail-layout {
            grid-template-columns: 1fr;
        }
    }

    /* ─── Info Card ───────────────────────────────────────────── */
    .info-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .info-card-header {
        padding: 14px 18px;
        background: var(--bg);
        border-bottom: 1px solid var(--border);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--muted);
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        padding: 13px 18px;
        border-bottom: 1px solid var(--border);
        font-size: 14px;
        gap: 12px;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-row .info-label {
        min-width: 110px;
        color: var(--muted);
        font-size: 13px;
        font-weight: 500;
        flex-shrink: 0;
        padding-top: 1px;
    }

    .info-row .info-value {
        color: var(--text);
        font-weight: 500;
        word-break: break-word;
    }

    .info-row .info-value a {
        color: var(--tp);
        text-decoration: none;
    }

    .info-row .info-value a:hover {
        text-decoration: underline;
    }

    /* Status pill */
    .pill {
        display: inline-block;
        padding: 3px 11px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .pill-active {
        background: #d1fae5;
        color: #065f46;
    }

    .pill-inactive {
        background: #f3f4f6;
        color: #6b7280;
    }

    /* Notes box */
    .notes-box {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 8px;
        padding: 12px 14px;
        font-size: 14px;
        color: #78350f;
        line-height: 1.6;
    }

    /* ─── Properties Section ──────────────────────────────────── */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text);
    }

    .section-count {
        font-size: 12px;
        color: var(--muted);
        font-weight: 600;
        background: var(--bg);
        padding: 3px 10px;
        border-radius: 999px;
        border: 1px solid var(--border);
        margin-left: 8px;
    }

    .btn-add-property {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--tp);
        color: var(--white);
        font-size: 13px;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 7px;
        text-decoration: none;
        transition: background .2s;
    }

    .btn-add-property:hover {
        background: var(--tp-dk);
        color: var(--white);
    }

    /* Properties table */
    .prop-table-wrap {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .prop-table {
        width: 100%;
        border-collapse: collapse;
    }

    .prop-table thead tr {
        background: var(--bg);
        border-bottom: 2px solid var(--border);
    }

    .prop-table thead th {
        padding: 11px 14px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--muted);
    }

    .prop-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }

    .prop-table tbody tr:last-child {
        border-bottom: none;
    }

    .prop-table tbody tr:hover {
        background: #fafcfb;
    }

    .prop-table td {
        padding: 12px 14px;
        font-size: 14px;
        vertical-align: middle;
    }

    .prop-thumb {
        width: 52px;
        height: 40px;
        border-radius: 6px;
        object-fit: cover;
        background: var(--bg);
        flex-shrink: 0;
    }

    .prop-thumb-placeholder {
        width: 52px;
        height: 40px;
        border-radius: 6px;
        background: var(--tp-lt);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .prop-title-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .prop-title {
        font-weight: 600;
        color: var(--text);
    }

    .prop-location {
        font-size: 12px;
        color: var(--muted);
        margin-top: 2px;
    }

    .cond-badge {
        display: inline-block;
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
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

    .prop-empty {
        text-align: center;
        padding: 44px;
        color: var(--muted);
        font-size: 14px;
    }

    .prop-empty .prop-empty-icon {
        font-size: 36px;
        margin-bottom: 10px;
    }

    /* ─── Activity Timeline ───────────────────────────────────── */
    .timeline {
        padding: 0;
        list-style: none;
        margin: 0;
    }

    .timeline-item {
        display: flex;
        gap: 14px;
        padding: 12px 18px;
        border-bottom: 1px solid var(--border);
    }

    .timeline-item:last-child {
        border-bottom: none;
    }

    .timeline-dot {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        margin-top: 2px;
    }

    .dot-green {
        background: #d1fae5;
    }

    .dot-blue {
        background: #dbeafe;
    }

    .dot-amber {
        background: #fef3c7;
    }

    .dot-red {
        background: #fee2e2;
    }

    .timeline-body .tl-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--text);
    }

    .timeline-body .tl-time {
        font-size: 12px;
        color: var(--muted);
        margin-top: 2px;
    }

    /* ─── Modals ──────────────────────────────────────────────── */
    .modal-content {
        border: none;
        border-radius: 14px;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--tp), var(--tp-dk));
        padding: 18px 22px;
        border-bottom: none;
    }

    .modal-header .modal-title {
        color: #fff;
        font-size: 16px;
        font-weight: 700;
    }

    .modal-header .btn-close {
        filter: invert(1);
        opacity: .8;
    }

    .modal-body {
        padding: 22px;
    }

    .modal-footer {
        padding: 14px 22px;
        border-top: 1px solid var(--border);
        background: var(--bg);
    }

    .form-label-terra {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--muted);
        margin-bottom: 6px;
        display: block;
    }

    .form-control-terra,
    .form-select-terra {
        width: 100%;
        padding: 9px 13px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: 14px;
        color: var(--text);
        background: var(--white);
        outline: none;
        transition: border-color .2s;
        font-family: inherit;
    }

    .form-control-terra:focus,
    .form-select-terra:focus {
        border-color: var(--tp);
        box-shadow: 0 0 0 3px rgba(44, 110, 73, .1);
    }

    .form-control-terra.is-invalid {
        border-color: var(--danger);
    }

    .field-error {
        font-size: 12px;
        color: var(--danger);
        margin-top: 4px;
        display: none;
    }

    .field-error.show {
        display: block;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media(max-width:576px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    .form-section-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--muted);
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border);
        margin: 18px 0 14px;
    }

    .btn-terra {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--tp);
        color: var(--white);
        font-size: 14px;
        font-weight: 600;
        padding: 9px 18px;
        border-radius: 7px;
        border: none;
        cursor: pointer;
        transition: background .2s;
    }

    .btn-terra:hover {
        background: var(--tp-dk);
        color: var(--white);
    }

    .btn-cancel {
        background: var(--white);
        color: var(--text);
        border: 1.5px solid var(--border);
        border-radius: 7px;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 20px;
        cursor: pointer;
        transition: all .2s;
    }

    .btn-cancel:hover {
        border-color: var(--tp);
        color: var(--tp);
    }

    .delete-modal .modal-header {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    .delete-warning {
        background: #fee2e2;
        border: 1px solid #fca5a5;
        border-radius: 8px;
        padding: 14px 16px;
        font-size: 14px;
        color: #7f1d1d;
        margin-bottom: 16px;
    }

    .btn-confirm-delete {
        background: var(--danger);
        color: #fff;
        border: none;
        border-radius: 7px;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 20px;
        cursor: pointer;
        transition: background .2s;
    }

    .btn-confirm-delete:hover {
        background: #b91c1c;
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- ── BREADCRUMB ──────────────────────────────────────── --}}
    <div class="detail-breadcrumb">
        <a href="{{ route('admin.clients.index') }}">Clients</a>
        <span class="sep">›</span>
        <span>{{ $client->full_name }}</span>
    </div>

    {{-- ── HERO ────────────────────────────────────────────── --}}
    <div class="client-hero">
        <div class="hero-avatar">
            {{ strtoupper(substr($client->full_name, 0, 1)) }}
        </div>
        <div class="hero-body">
            <div class="hero-name">{{ $client->full_name }}</div>
            <div class="hero-meta">
                <span>📞 {{ $client->phone }}</span>
                @if($client->email)
                <span>✉️ {{ $client->email }}</span>
                @endif
                @if($client->district)
                <span>📍 {{ $client->district }}{{ $client->province ? ', '.$client->province : '' }}</span>
                @endif
                <span>🏠 {{ $client->properties_count ?? $client->properties->count() }} {{ Str::plural('property', $client->properties_count ?? $client->properties->count()) }}</span>
            </div>
        </div>

        <div style="display:flex; flex-direction:column; gap:10px; align-items:flex-end;">
            <span class="hero-badge"
                style="background:{{ $tc['bg'] }}; color:{{ $tc['color'] }};">
                {{ ucfirst($client->client_type) }}
            </span>
            <div class="hero-actions">
                <button class="btn-hero-edit" onclick="openEditModal()">✏️ Edit</button>
                <button class="btn-hero-delete" onclick="openDeleteModal()">🗑 Delete</button>
            </div>
        </div>
    </div>

    {{-- ── TWO COLUMN ──────────────────────────────────────── --}}
    <div class="detail-layout">

        {{-- LEFT: Info sidebar --}}
        <div style="display:flex; flex-direction:column; gap:20px;">

            {{-- Contact Info --}}
            <div class="info-card">
                <div class="info-card-header">Contact Information</div>

                <div class="info-row">
                    <span class="info-label">Phone</span>
                    <span class="info-value">
                        <a href="tel:{{ $client->phone }}">{{ $client->phone }}</a>
                    </span>
                </div>
                @if($client->email)
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">
                        <a href="mailto:{{ $client->email }}">{{ $client->email }}</a>
                    </span>
                </div>
                @endif
                @if($client->national_id)
                <div class="info-row">
                    <span class="info-label">NID</span>
                    <span class="info-value">{{ $client->national_id }}</span>
                </div>
                @endif
                @if($client->company_name)
                <div class="info-row">
                    <span class="info-label">Company</span>
                    <span class="info-value">{{ $client->company_name }}</span>
                </div>
                @endif
            </div>

            {{-- Location --}}
            <div class="info-card">
                <div class="info-card-header">Location</div>
                @if($client->province)
                <div class="info-row">
                    <span class="info-label">Province</span>
                    <span class="info-value">{{ $client->province }}</span>
                </div>
                @endif
                @if($client->district)
                <div class="info-row">
                    <span class="info-label">District</span>
                    <span class="info-value">{{ $client->district }}</span>
                </div>
                @endif
                @if($client->sector)
                <div class="info-row">
                    <span class="info-label">Sector</span>
                    <span class="info-value">{{ $client->sector }}</span>
                </div>
                @endif
                @if(!$client->province && !$client->district && !$client->sector)
                <div class="info-row">
                    <span class="info-label">Location</span>
                    <span class="info-value" style="color:var(--muted);">Not provided</span>
                </div>
                @endif
            </div>

            {{-- Status & Meta --}}
            <div class="info-card">
                <div class="info-card-header">Account Details</div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        <span class="pill {{ $client->is_active ? 'pill-active' : 'pill-inactive' }}">
                            {{ $client->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Type</span>
                    <span class="info-value">
                        <span class="pill"
                            style="background:{{ $tc['bg'] }}; color:{{ $tc['color'] }};">
                            {{ ucfirst($client->client_type) }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Registered</span>
                    <span class="info-value">{{ $client->created_at->format('d M Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Added by</span>
                    <span class="info-value">{{ $client->createdBy->name ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Last update</span>
                    <span class="info-value">{{ $client->updated_at->diffForHumans() }}</span>
                </div>
            </div>

            {{-- Notes --}}
            @if($client->notes)
            <div class="info-card">
                <div class="info-card-header">Notes</div>
                <div style="padding:14px 18px;">
                    <div class="notes-box">{{ $client->notes }}</div>
                </div>
            </div>
            @endif

            {{-- Quick Actions --}}
            <div class="info-card">
                <div class="info-card-header">Quick Actions</div>
                <div style="padding:14px 18px; display:flex; flex-direction:column; gap:10px;">
                    @if($client->phone)
                    <a href="tel:{{ $client->phone }}"
                        style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:#f0faf5;border:1px solid var(--tp-border);border-radius:7px;font-size:14px;font-weight:600;color:var(--tp);text-decoration:none;">
                        📞 Call Client
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/','', $client->phone) }}?text=Hello+{{ urlencode($client->full_name) }}%2C+this+is+Terra+Real+Estate."
                        target="_blank"
                        style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:#d1fae5;border:1px solid #a7f3d0;border-radius:7px;font-size:14px;font-weight:600;color:#065f46;text-decoration:none;">
                        💬 WhatsApp
                    </a>
                    @endif
                    @if($client->email)
                    <a href="mailto:{{ $client->email }}"
                        style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:#dbeafe;border:1px solid #bfdbfe;border-radius:7px;font-size:14px;font-weight:600;color:#1e40af;text-decoration:none;">
                        ✉️ Send Email
                    </a>
                    @endif
                </div>
            </div>

        </div>

        {{-- RIGHT: Properties + Activity --}}
        <div style="display:flex; flex-direction:column; gap:24px;">

            {{-- Properties Table --}}
            <div>
                <div class="section-header">
                    <div>
                        <span class="section-title">Properties</span>
                        <span class="section-count">{{ $client->properties->count() }}</span>
                    </div>
                    <a href="{{ route('add.property.house') }}?client_id={{ $client->id }}"
                        class="btn-add-property">
                        + Add Property
                    </a>
                </div>

                <div class="prop-table-wrap">
                    @if($client->properties->count())
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
                            @foreach($client->properties as $prop)
                            <tr>
                                <td>
                                    <div class="prop-title-cell">
                                        @if($prop->thumbnail ?? $prop->image ?? null)
                                        <img src="{{ asset('storage/'.($prop->thumbnail ?? $prop->image)) }}"
                                            alt="{{ $prop->title }}" class="prop-thumb">
                                        @else
                                        <div class="prop-thumb-placeholder">🏠</div>
                                        @endif
                                        <div>
                                            <div class="prop-title">{{ $prop->title }}</div>
                                            <div class="prop-location">
                                                📍 {{ $prop->sector ?? '' }}{{ $prop->district ? ', '.$prop->district : '' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size:13px; color:var(--muted);">
                                    {{ ucfirst($prop->type ?? $prop->property_type ?? '—') }}
                                </td>
                                <td>
                                    <span class="cond-badge cond-{{ $prop->condition ?? 'for_sale' }}">
                                        {{ ucfirst(str_replace('_',' ',$prop->condition ?? 'For Sale')) }}
                                    </span>
                                </td>
                                <td style="font-weight:700; font-size:14px; color:var(--tp); white-space:nowrap;">
                                    RWF {{ number_format($prop->price) }}
                                </td>
                                <td>
                                    <span class="cond-badge status-{{ $prop->status ?? 'available' }}">
                                        {{ ucfirst($prop->status ?? 'Available') }}
                                    </span>
                                </td>
                                <td style="font-size:12px; color:var(--muted); white-space:nowrap;">
                                    {{ $prop->created_at->format('d M Y') }}
                                </td>
                                <td>
                                    <a href="#"
                                        style="font-size:12px; color:var(--tp); font-weight:600; text-decoration:none; white-space:nowrap;"
                                        target="_blank">
                                        View ↗
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="prop-empty">
                        <div class="prop-empty-icon">🏠</div>
                        <div>No properties listed yet.</div>
                        <a href="#"
                            style="color:var(--tp); font-weight:600; font-size:14px; text-decoration:none; display:inline-block; margin-top:10px;">
                            + Add First Property
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Activity Timeline --}}
            <div>
                <div class="section-header" style="margin-bottom:14px;">
                    <span class="section-title">Activity Timeline</span>
                </div>
                <div class="info-card">
                    <ul class="timeline">
                        <li class="timeline-item">
                            <div class="timeline-dot dot-green">✅</div>
                            <div class="timeline-body">
                                <div class="tl-title">Client registered on Terra</div>
                                <div class="tl-time">{{ $client->created_at->format('d M Y, H:i') }} — by {{ $client->createdBy->name ?? 'Admin' }}</div>
                            </div>
                        </li>
                        @foreach($client->properties->sortByDesc('created_at') as $prop)
                        <li class="timeline-item">
                            <div class="timeline-dot dot-blue">🏠</div>
                            <div class="timeline-body">
                                <div class="tl-title">Property listed: {{ $prop->title }}</div>
                                <div class="tl-time">{{ $prop->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </li>
                        @endforeach
                        @if($client->updated_at->ne($client->created_at))
                        <li class="timeline-item">
                            <div class="timeline-dot dot-amber">✏️</div>
                            <div class="timeline-body">
                                <div class="tl-title">Client profile last updated</div>
                                <div class="tl-time">{{ $client->updated_at->format('d M Y, H:i') }}</div>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>
    </div>

</div>{{-- /container --}}


{{-- ════════════════════════════════════════════════════════
     EDIT MODAL (pre-filled for this client)
     ════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="editClientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">✏️ Edit Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.clients.update', $client->id) }}" id="editForm">
                @csrf @method('PUT')
                <div class="modal-body">

                    <div class="form-section-title">Personal Information</div>
                    <div class="form-grid-2">
                        <div>
                            <label class="form-label-terra">Full Name *</label>
                            <input type="text" name="full_name" class="form-control-terra"
                                value="{{ old('full_name', $client->full_name) }}" required>
                        </div>
                        <div>
                            <label class="form-label-terra">National ID</label>
                            <input type="text" name="national_id" class="form-control-terra"
                                value="{{ old('national_id', $client->national_id) }}">
                        </div>
                        <div>
                            <label class="form-label-terra">Phone *</label>
                            <input type="tel" name="phone" class="form-control-terra"
                                value="{{ old('phone', $client->phone) }}" required>
                        </div>
                        <div>
                            <label class="form-label-terra">Email</label>
                            <input type="email" name="email" class="form-control-terra"
                                value="{{ old('email', $client->email) }}">
                        </div>
                    </div>

                    <div class="form-section-title">Client Classification</div>
                    <div class="form-grid-2">
                        <div>
                            <label class="form-label-terra">Client Type *</label>
                            <select name="client_type" id="show_client_type" class="form-select-terra"
                                onchange="toggleShowCompany()">
                                @foreach(['owner','agent','developer','company'] as $t)
                                <option value="{{ $t }}" {{ old('client_type',$client->client_type)==$t ?'selected':'' }}>
                                    {{ ucfirst($t) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="show_company_wrap">
                            <label class="form-label-terra">Company Name</label>
                            <input type="text" name="company_name" class="form-control-terra"
                                value="{{ old('company_name', $client->company_name) }}">
                        </div>
                    </div>

                    <div class="form-section-title">Location</div>
                    <div class="form-grid-2">
                        <div>
                            <label class="form-label-terra">Province</label>
                            <select name="province" class="form-select-terra">
                                <option value="">Select province</option>
                                @foreach(['Kigali City','Northern','Southern','Eastern','Western'] as $p)
                                <option value="{{ $p }}" {{ old('province',$client->province)==$p ?'selected':'' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label-terra">District</label>
                            <select name="district" class="form-select-terra">
                                <option value="">Select district</option>
                                @foreach(['Gasabo','Kicukiro','Nyarugenge','Bugesera','Gatsibo','Kayonza','Kirehe',
                                'Ngoma','Rwamagana','Burera','Gakenke','Gicumbi','Musanze','Rulindo',
                                'Gisagara','Huye','Kamonyi','Muhanga','Nyamagabe','Nyanza','Nyaruguru',
                                'Ruhango','Karongi','Ngororero','Nyabihu','Nyamasheke','Rubavu','Rusizi',
                                'Rutsiro','Nyagatare'] as $d)
                                <option value="{{ $d }}" {{ old('district',$client->district)==$d ?'selected':'' }}>{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label-terra">Sector</label>
                            <input type="text" name="sector" class="form-control-terra"
                                value="{{ old('sector', $client->sector) }}">
                        </div>
                    </div>

                    <div class="form-section-title">Additional</div>
                    <div class="form-grid-2">
                        <div>
                            <label class="form-label-terra">Status</label>
                            <select name="is_active" class="form-select-terra">
                                <option value="1" {{ old('is_active',$client->is_active) ? 'selected':'' }}>Active</option>
                                <option value="0" {{ !old('is_active',$client->is_active) ? 'selected':'' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-top:14px;">
                        <label class="form-label-terra">Notes</label>
                        <textarea name="notes" class="form-control-terra" rows="3"
                            style="resize:vertical;">{{ old('notes', $client->notes) }}</textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-terra">Save Changes →</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     DELETE MODAL
     ════════════════════════════════════════════════════════ --}}
<div class="modal fade delete-modal" id="deleteClientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🗑️ Delete Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.clients.destroy', $client->id) }}">
                @csrf @method('DELETE')
                <div class="modal-body">
                    <div class="delete-warning">
                        ⚠️ This will permanently delete <strong>{{ $client->full_name }}</strong>.
                        @if($client->properties->count() > 0)
                        Their <strong>{{ $client->properties->count() }} {{ Str::plural('property', $client->properties->count()) }}</strong>
                        will remain on Terra but will no longer be linked to a client.
                        @endif
                    </div>
                    <div style="background:var(--bg); border:1px solid var(--border); border-radius:8px; padding:14px 16px; display:flex; gap:12px; align-items:center;">
                        <div style="width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,var(--tp),var(--tp-dk));color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:17px;flex-shrink:0;">
                            {{ strtoupper(substr($client->full_name,0,1)) }}
                        </div>
                        <div>
                            <div style="font-weight:700;font-size:15px;color:var(--text);">{{ $client->full_name }}</div>
                            <div style="font-size:13px;color:var(--muted);">{{ $client->phone }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-confirm-delete">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function openEditModal() {
        new bootstrap.Modal(document.getElementById('editClientModal')).show();
    }

    function openDeleteModal() {
        new bootstrap.Modal(document.getElementById('deleteClientModal')).show();
    }

    function toggleShowCompany() {
        const type = document.getElementById('show_client_type').value;
        document.getElementById('show_company_wrap').style.display =
            (type === 'company' || type === 'developer') ? 'block' : 'none';
    }
    document.addEventListener('DOMContentLoaded', function() {
        toggleShowCompany();
        // Auto-open edit modal if there are validation errors (page reloaded after failed submit)
        @if($errors->any())
        new bootstrap.Modal(document.getElementById('editClientModal')).show();
        @endif
    });
</script>

@endsection