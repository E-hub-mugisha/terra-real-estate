@extends('layouts.agents')
@section('title', 'Partner dashboard')

@section('content')
@php $first = \Illuminate\Support\Str::before($user->name, ' ') ?: $user->name; @endphp

<div class="tp-page-head">
    <div>
        <h1>Hello, {{ $first }}</h1>
        <p>{{ $profile?->company_name ?: 'Independent partner' }} · refer owners and clients, earn on every deal.</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <button type="button" class="tu-btn tu-btn-primary tu-btn-sm" data-modal-open="referralModal"><x-tu-icon name="plus" /> Add referral</button>
        <a href="{{ route('agent.properties.houses.create') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="home" /> Submit property</a>
    </div>
</div>

@if ($profile && $profile->status !== 'active')
    <div class="tu-alert {{ $profile->status === 'suspended' ? 'tu-alert-danger' : '' }}" style="margin-bottom:20px;display:flex;gap:12px;align-items:flex-start">
        <x-tu-icon name="{{ $profile->status === 'suspended' ? 'lock' : 'clock' }}" />
        <div>
            <strong>{{ $profile->status === 'suspended' ? 'Your partnership is suspended.' : 'Your partner application is under review.' }}</strong>
            <div style="font-size:.86rem">{{ $profile->status === 'suspended' ? 'Contact the Terra team to reactivate your account.' : 'You can already add referrals and properties — commissions are paid once your account is active.' }}</div>
        </div>
    </div>
@endif

<div class="tp-stats">
    @foreach ([
        ['Referrals', $stats['referrals'], 'users', route('room.referrals.index')],
        ['Converted', $stats['converted'], 'check', route('room.referrals.index', ['status' => 'converted'])],
        ['Submitted properties', $stats['listings'], 'layers', route('room.listings.index')],
        ['Assigned to me', $stats['assigned'], 'briefcase', route('room.assigned')],
        ['Earned (RWF)', $stats['earned'], 'credit', route('room.earnings')],
        ['Pending (RWF)', $stats['pending'], 'clock', route('room.earnings', ['status' => 'pending'])],
    ] as [$label, $value, $icon, $url])
        <a href="{{ $url }}" class="tp-stat">
            <div class="tp-stat-top"><span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span></div>
            <div><div class="tp-stat-val">{{ number_format($value) }}</div><div class="tp-stat-label">{{ $label }}</div></div>
        </a>
    @endforeach
</div>

<div class="card mb-3">
    <div class="card-header tp-card-head">Lead pipeline <a href="{{ route('room.referrals.index') }}">Manage leads</a></div>
    <div class="card-body">
        <div class="tp-pipeline">
            @foreach (\App\Models\Referral::STATUSES as $s)
                <a href="{{ route('room.referrals.index', ['status' => $s]) }}"><strong>{{ (int) ($pipeline[$s] ?? 0) }}</strong><span>{{ ucfirst($s) }}</span></a>
            @endforeach
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-6">
        <div class="card h-100">
            <div class="card-header tp-card-head">Recent referrals <a href="{{ route('room.referrals.index') }}">All</a></div>
            @if ($referrals->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="users" /></div><strong>No referrals yet</strong>Know someone selling land or looking for a house? Add them.</div>
            @else
                <ul class="tp-list">
                    @foreach ($referrals as $r)
                        <li>
                            <span class="tu-avatar">{{ strtoupper(mb_substr($r->name, 0, 1)) }}</span>
                            <span class="tp-list-main">
                                <strong>{{ $r->name }} <span class="tu-badge" style="margin-left:4px">{{ ucfirst($r->type) }}</span></strong>
                                <span>{{ $r->interest ?: ($r->phone ?: $r->email) }}</span>
                            </span>
                            @include('room._status', ['status' => $r->status])
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card h-100">
            <div class="card-header tp-card-head">Latest earnings <a href="{{ route('room.earnings') }}">Earnings</a></div>
            @if ($commissions->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="credit" /></div><strong>No earnings yet</strong>You earn when a referred owner pays for a listing or a deal closes.</div>
            @else
                <ul class="tp-list">
                    @foreach ($commissions as $c)
                        <li>
                            <span class="tp-list-main">
                                <strong>{{ number_format($c->amount) }} {{ $c->currency }}</strong>
                                <span>{{ $c->typeLabel() }} · {{ \Illuminate\Support\Str::limit($c->listable->title ?? 'Referral', 30) }}</span>
                            </span>
                            @include('room._status', ['status' => $c->status])
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header tp-card-head">Submitted properties <a href="{{ route('room.listings.index') }}">Manage</a></div>
            @if ($listings->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="home" /></div><strong>No properties submitted</strong>List a property on behalf of an owner you work with.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th>Listing</th><th>Status</th><th class="text-end">Inquiries</th><th class="text-end">Saves</th></tr></thead>
                        <tbody>
                            @foreach ($listings as $l)
                                <tr>
                                    <td>@include('room._listing', ['listing' => $l])</td>
                                    <td>@include('room._status', ['status' => $l->reviewState()])</td>
                                    <td class="text-end" style="font-weight:700">{{ $l->inquiries_count }}</td>
                                    <td class="text-end" style="font-weight:700">{{ $l->saves_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@include('room.referrals._form')
@endsection
