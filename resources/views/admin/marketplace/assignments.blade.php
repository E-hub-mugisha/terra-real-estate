@extends('layouts.app')
@section('title', 'Listing assignments')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Listing assignments</h1>
        <p>Ask agents and partners to help promote a listing and find clients for it. They see it under “Assigned listings”.</p>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">Assign a listing</div>
            <form method="POST" action="{{ route('admin.marketplace.assignments.store') }}" class="card-body tu-stack" style="gap:14px">
                @csrf
                <div class="tu-field">
                    <label for="asListing">Listing</label>
                    <select id="asListing" name="listing" class="tu-select" required>
                        <option value="">Choose a live listing…</option>
                        @foreach ($listings as $l)
                            @php $ref = \App\Support\ListingRef::type($l) . '-' . $l->id; @endphp
                            <option value="{{ $ref }}" @selected(old('listing') === $ref)>[{{ \App\Support\ListingRef::label($l) }}] {{ \Illuminate\Support\Str::limit($l->title, 60) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="tu-field">
                    <label for="asUser">Agent or partner</label>
                    <select id="asUser" name="user_id" class="tu-select" required>
                        <option value="">Choose…</option>
                        @foreach ($helpers->groupBy('role') as $role => $people)
                            <optgroup label="{{ ucfirst($role) }}s">
                                @foreach ($people as $h)<option value="{{ $h->id }}" @selected(old('user_id') == $h->id)>{{ $h->name }}</option>@endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="tu-field">
                    <label for="asNote">Note <span class="tu-hint">(optional)</span></label>
                    <textarea id="asNote" name="note" maxlength="500" rows="3" placeholder="e.g. Owner wants a buyer before March, open to offers">{{ old('note') }}</textarea>
                </div>
                <button class="tu-btn tu-btn-primary">Assign</button>
            </form>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">Current assignments ({{ $assignments->total() }})</div>
            @if ($assignments->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="briefcase" /></div><strong>No assignments yet</strong>Assign a listing to get help selling or renting it.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th>Listing</th><th>Assigned to</th><th>Note</th><th class="text-end"></th></tr></thead>
                        <tbody>
                            @foreach ($assignments as $a)
                                <tr>
                                    <td>@include('room._listing', ['listing' => $a->listable])</td>
                                    <td style="font-size:.84rem"><strong style="color:var(--tu-ink)">{{ $a->user->name ?? '—' }}</strong><div style="font-size:.74rem;color:var(--tu-muted)">{{ $a->user?->roleLabel() }} · {{ $a->created_at->format('j M Y') }}{{ $a->assigner ? ' by ' . $a->assigner->name : '' }}</div></td>
                                    <td style="font-size:.82rem;max-width:240px">{{ $a->note ?: '—' }}</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('admin.marketplace.assignments.destroy', $a) }}" onsubmit="return confirm('Remove this assignment?')">@csrf @method('DELETE')<button class="tu-btn tu-btn-sm tu-btn-icon" aria-label="Remove assignment"><x-tu-icon name="x" /></button></form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="mt-3">{{ $assignments->links() }}</div>
    </div>
</div>
@endsection
