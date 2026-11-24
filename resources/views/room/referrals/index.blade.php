@extends('layouts.agents')
@section('title', 'Leads & referrals')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Leads & referrals</h1>
        <p>Owners and clients you bring to Terra. You earn a reward when the Terra team confirms a conversion.</p>
    </div>
    <button type="button" class="tu-btn tu-btn-primary tu-btn-sm" data-modal-open="referralModal"><x-tu-icon name="plus" /> Add referral</button>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="tp-pipeline">
            @foreach (\App\Models\Referral::STATUSES as $s)
                <a href="{{ route('room.referrals.index', request('status') === $s ? [] : ['status' => $s]) }}" class="{{ request('status') === $s ? 'is-active' : '' }}"><strong>{{ (int) ($pipeline[$s] ?? 0) }}</strong><span>{{ ucfirst($s) }}</span></a>
            @endforeach
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-8">
        <div class="tp-toolbar" style="margin-bottom:12px">
            <nav class="tp-box-tabs" aria-label="Referral type">
                @foreach ([null => 'All', 'owner' => 'Owners', 'client' => 'Clients'] as $key => $label)
                    <a href="{{ route('room.referrals.index', array_filter(['type' => $key ?: null, 'status' => request('status')])) }}" class="{{ request('type') == $key ? 'is-active' : '' }}">{{ $label }}</a>
                @endforeach
            </nav>
        </div>
        @if ($referrals->isEmpty())
            @include('room._empty', ['icon' => 'users', 'title' => 'No referrals here', 'text' => 'Add someone who wants to sell, rent out, buy or rent a property.'])
        @else
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th>Person</th><th>Need</th><th>Status</th><th class="text-end">Update</th></tr></thead>
                        <tbody>
                            @foreach ($referrals as $r)
                                <tr>
                                    <td>
                                        <strong style="color:var(--tu-ink);display:block">{{ $r->name }}</strong>
                                        <span style="font-size:.78rem;color:var(--tu-muted)">{{ ucfirst($r->type) }} · {{ $r->phone ?: $r->email }}</span>
                                    </td>
                                    <td style="font-size:.84rem;max-width:240px">{{ $r->interest ?: '—' }}
                                        @if ($r->notes)<div style="font-size:.76rem;color:var(--tu-muted)">{{ \Illuminate\Support\Str::limit($r->notes, 70) }}</div>@endif
                                    </td>
                                    <td>@include('room._status', ['status' => $r->status])<div style="font-size:.72rem;color:var(--tu-subtle);margin-top:3px">{{ $r->created_at->format('j M Y') }}</div></td>
                                    <td class="text-end">
                                        @if (in_array($r->status, ['converted', 'lost'], true))
                                            <span style="font-size:.78rem;color:var(--tu-muted)">Closed</span>
                                        @else
                                            <form method="POST" action="{{ route('room.referrals.update', $r) }}" style="display:inline-flex;gap:6px">
                                                @csrf @method('PATCH')
                                                <label class="tu-sr" for="st{{ $r->id }}">Status</label>
                                                <select id="st{{ $r->id }}" name="status" class="tu-select" style="height:34px;padding:0 30px 0 10px;font-size:.8rem" onchange="this.form.submit()">
                                                    @foreach (['new', 'contacted', 'qualified', 'lost'] as $s)
                                                        <option value="{{ $s }}" @selected($r->status === $s)>{{ ucfirst($s) }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-3">{{ $referrals->links() }}</div>
        @endif
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header tp-card-head">Inquiries on my listings <a href="{{ route('room.inquiries.index') }}">Inbox</a></div>
            @if ($inquiryLeads->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="mail" /></div><strong>No inquiries yet</strong>Client questions on your listings are leads too.</div>
            @else
                <ul class="tp-list">
                    @foreach ($inquiryLeads as $i)
                        <li>
                            <span class="tu-avatar">{{ strtoupper(mb_substr($i->name, 0, 1)) }}</span>
                            <span class="tp-list-main">
                                <strong>{{ $i->name }}</strong>
                                <span>{{ \Illuminate\Support\Str::limit($i->listable->title ?? 'Listing', 34) }} · {{ $i->created_at->diffForHumans(null, true, true) }}</span>
                            </span>
                            @include('room._status', ['status' => $i->status])
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="card mt-3">
            <div class="card-body" style="font-size:.86rem;color:var(--tu-text);line-height:1.7">
                <strong style="color:var(--tu-ink);display:block;margin-bottom:6px">How rewards work</strong>
                Owner you refer pays a listing package → you earn {{ \App\Support\Settings::number(auth()->user()->isAgent() ? 'commission.agent_listing_pct' : 'commission.partner_listing_pct') }}% of it.<br>
                A deal closes on a listing you brought → {{ \App\Support\Settings::number(auth()->user()->isAgent() ? 'commission.agent_deal_pct' : 'commission.partner_deal_pct') }}% of the deal value.
                @if (auth()->user()->isPartner())<br>Confirmed referral → {{ number_format(\App\Support\Settings::number('commission.partner_referral_flat')) }} RWF.@endif
            </div>
        </div>
    </div>
</div>

@include('room.referrals._form')
@endsection
