@extends('layouts.app')
@section('title', 'Leads & referrals')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Leads & referrals</h1>
        <p>Owners and clients brought in by agents and partners. Marking a lead “converted” rewards the partner.</p>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="tp-pipeline">
            @foreach (\App\Models\Referral::STATUSES as $s)
                <a href="{{ route('admin.marketplace.referrals', request('status') === $s ? [] : ['status' => $s]) }}" class="{{ request('status') === $s ? 'is-active' : '' }}"><strong>{{ (int) ($pipeline[$s] ?? 0) }}</strong><span>{{ ucfirst($s) }}</span></a>
            @endforeach
        </div>
    </div>
</div>

@if ($referrals->isEmpty())
    @include('room._empty', ['icon' => 'users', 'title' => 'No referrals', 'text' => 'Nothing matches this filter.'])
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Person</th><th>Need</th><th>Referred by</th><th>Status</th><th class="text-end">Update</th></tr></thead>
                <tbody>
                    @foreach ($referrals as $r)
                        <tr>
                            <td><strong style="color:var(--tu-ink);display:block">{{ $r->name }}</strong><span style="font-size:.76rem;color:var(--tu-muted)">{{ ucfirst($r->type) }} · {{ $r->phone }} {{ $r->email }}</span></td>
                            <td style="font-size:.84rem;max-width:260px">{{ $r->interest ?: '—' }}@if ($r->notes)<div style="font-size:.74rem;color:var(--tu-muted)">{{ \Illuminate\Support\Str::limit($r->notes, 90) }}</div>@endif</td>
                            <td style="font-size:.84rem">{{ $r->referrer->name ?? '—' }}<div style="font-size:.74rem;color:var(--tu-muted)">{{ $r->referrer?->roleLabel() }} · {{ $r->created_at->format('j M Y') }}</div></td>
                            <td>@include('room._status', ['status' => $r->status])</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('room.referrals.update', $r) }}" style="display:inline-flex;gap:6px">
                                    @csrf @method('PATCH')
                                    <label class="tu-sr" for="rs{{ $r->id }}">Status</label>
                                    <select id="rs{{ $r->id }}" name="status" class="tu-select" style="height:34px;padding:0 30px 0 10px;font-size:.8rem" onchange="if (this.value !== 'converted' || confirm('Confirm conversion? This creates the partner reward.')) this.form.submit(); else this.value = '{{ $r->status }}';">
                                        @foreach (\App\Models\Referral::STATUSES as $s)
                                            <option value="{{ $s }}" @selected($r->status === $s)>{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $referrals->links() }}</div>
@endif
@endsection
