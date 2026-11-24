@extends('layouts.app')
@section('title', 'Partners')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Independent partners</h1>
        <p>Approve applications, follow each partner's referrals and earnings, or suspend an account.</p>
    </div>
    <a href="{{ route('front.partners.apply') }}" target="_blank" rel="noopener" class="tu-btn tu-btn-sm"><x-tu-icon name="external" /> Application page</a>
</div>

<div class="tp-toolbar">
    @include('admin.marketplace._tabs', ['param' => 'status', 'current' => request('status', ''), 'options' => ['' => 'All', 'pending' => 'Pending', 'active' => 'Active', 'suspended' => 'Suspended']])
</div>

@if ($partners->isEmpty())
    @include('room._empty', ['icon' => 'briefcase', 'title' => 'No partners', 'text' => 'Partner applications appear here.'])
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Partner</th><th>Areas</th><th class="text-end">Referrals</th><th class="text-end">Converted</th><th class="text-end">Earned</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @foreach ($partners as $p)
                        @php $s = $stats[$p->user_id] ?? null; @endphp
                        <tr>
                            <td>
                                <strong style="color:var(--tu-ink);display:block">{{ $p->user->name ?? '—' }}</strong>
                                <span style="font-size:.76rem;color:var(--tu-muted)">{{ $p->company_name ? $p->company_name . ' · ' : '' }}{{ $p->user->email ?? '' }} · {{ $p->phone }}</span>
                                @if ($p->bio)<div style="font-size:.76rem;color:var(--tu-text);max-width:320px">{{ \Illuminate\Support\Str::limit($p->bio, 90) }}</div>@endif
                            </td>
                            <td style="font-size:.84rem">{{ $p->areas ?: '—' }}</td>
                            <td class="text-end">{{ $s->referrals_count ?? 0 }}</td>
                            <td class="text-end">{{ $s->converted_count ?? 0 }}</td>
                            <td class="text-end" style="font-weight:700;white-space:nowrap">{{ number_format($s->earned ?? 0) }} <small>RWF</small></td>
                            <td>@include('room._status', ['status' => $p->status])<div style="font-size:.72rem;color:var(--tu-subtle)">Since {{ $p->created_at->format('j M Y') }}</div></td>
                            <td class="text-end">
                                <div class="tp-item-actions" style="flex-wrap:nowrap">
                                    @php
                                        $actions = match ($p->status) {
                                            'pending' => [['active', 'Approve', 'tu-btn-primary'], ['suspended', 'Decline', '']],
                                            'active' => [['suspended', 'Suspend', '']],
                                            default => [['active', 'Reactivate', 'tu-btn-primary']],
                                        };
                                    @endphp
                                    @foreach ($actions as [$to, $label, $cls])
                                        <form method="POST" action="{{ route('admin.marketplace.partners.update', $p) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="{{ $to }}"><button class="tu-btn tu-btn-sm {{ $cls }}">{{ $label }}</button></form>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $partners->links() }}</div>
@endif
@endsection
