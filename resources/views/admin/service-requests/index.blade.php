{{-- resources/views/admin/service-requests/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Service Requests')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/dist/tabler-icons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .sra-page {
        --navy: #19265d;
        --navy-dark: #111a45;
        --gold: #D05208;
        --gold-light: #fdf1e8;
        --ink: #16203f;
        --muted: #6b7280;
        --line: #e7e9f2;
        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
        max-width: 1180px;
        margin: 0 auto;
        padding: 1.75rem 0 3rem;
    }

    .sra-heading { display: flex; align-items: center; gap: .8rem; margin-bottom: 1.5rem; }
    .sra-heading-icon {
        width: 46px; height: 46px; border-radius: 12px;
        background: linear-gradient(135deg, var(--navy), var(--navy-dark));
        color: var(--gold); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
    }
    .sra-heading h4 { font-family: 'Cormorant Garamond', serif; font-weight: 700; font-size: 1.5rem; margin: 0; color: var(--navy); }
    .sra-heading p { font-size: .82rem; color: var(--muted); margin: .1rem 0 0; }

    .sra-alert-success {
        background: #eafaf1; border: 1px solid #b9e9cd; color: #146c43;
        border-radius: 12px; padding: .85rem 1.1rem; margin-bottom: 1.25rem; font-size: .88rem;
        display: flex; align-items: center; gap: .5rem;
    }

    .sra-card { background: #fff; border: 1px solid var(--line); border-radius: 14px; overflow: hidden; }

    .sra-table { width: 100%; border-collapse: collapse; font-size: .84rem; }
    .sra-table thead th {
        text-align: left; padding: .8rem 1.25rem; font-size: .7rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .03em; color: var(--muted);
        background: #f8fafc; border-bottom: 1px solid var(--line); white-space: nowrap;
    }
    .sra-table tbody td { padding: .9rem 1.25rem; border-bottom: 1px solid var(--line); vertical-align: middle; }
    .sra-table tbody tr:last-child td { border-bottom: none; }
    .sra-table tbody tr:hover { background: #fffaf5; }

    .sra-client-sub { font-size: .74rem; color: var(--muted); }

    .sra-pill {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .3rem .75rem; border-radius: 20px; font-size: .72rem; font-weight: 600;
    }
    .sra-pill.new       { background: var(--gold-light); color: #8a4306; border: 1px solid #f0d3b8; }
    .sra-pill.assigned  { background: #eef0f8; color: var(--navy); border: 1px solid #d3d8ee; }
    .sra-pill.completed { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .sra-pill.cancelled { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .sra-pill-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    .sra-assign-form { display: flex; gap: .4rem; align-items: center; }
    .sra-select {
        border: 1.5px solid var(--line); border-radius: 8px; padding: .4rem .6rem;
        font-size: .8rem; background: #fbfbfd; min-width: 150px;
    }
    .sra-select:focus { border-color: var(--gold); outline: none; }

    .sra-btn-assign {
        background: var(--gold); color: #fff; border: none; border-radius: 8px;
        padding: .42rem .9rem; font-size: .78rem; font-weight: 600; white-space: nowrap;
        transition: background .15s ease;
    }
    .sra-btn-assign:hover { background: #b84706; color: #fff; }

    .sra-consultant-name { font-weight: 600; font-size: .84rem; }
    .sra-empty { text-align: center; color: var(--muted); padding: 3rem 1rem; font-size: .88rem; }
</style>

<div class="sra-page">

    <div class="sra-heading">
        <div class="sra-heading-icon"><i class="ti ti-clipboard-list"></i></div>
        <div>
            <h4>Service Requests</h4>
            <p>Review incoming client requests and assign them to a consultant.</p>
        </div>
    </div>

    @if (session('success'))
    <div class="sra-alert-success">
        <i class="ti ti-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    <div class="sra-card">
        <div class="table-responsive">
            <table class="sra-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Preferred Date/Time</th>
                        <th>Status</th>
                        <th>Consultant</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($requests as $req)
                    <tr>
                        <td>
                            {{ $req->full_name }}
                            <div class="sra-client-sub">{{ $req->phone }} &middot; {{ $req->location }}</div>
                        </td>
                        <td>{{ $req->service->title }}</td>
                        <td>
                            {{ $req->preferred_date->format('d M Y') }}
                            <div class="sra-client-sub">{{ $req->preferred_time }}</div>
                        </td>
                        <td>
                            <span class="sra-pill {{ $req->status }}">
                                <span class="sra-pill-dot"></span>
                                {{ ucfirst($req->status) }}
                            </span>
                        </td>
                        <td>
                            @if ($req->consultant)
                                <span class="sra-consultant-name">{{ $req->consultant->user->name ?? $req->consultant->name }}</span>
                            @else
                                <span class="sra-client-sub">Unassigned</span>
                            @endif
                        </td>
                        <td>
                            @if ($req->status === 'new')
                                <form method="POST" action="{{ route('admin.service-requests.assign', $req->id) }}" class="sra-assign-form">
                                    @csrf
                                    <select name="consultant_id" class="sra-select" required>
                                        <option value="">Assign to...</option>
                                        @foreach ($consultants as $consultant)
                                            <option value="{{ $consultant->id }}">
                                                {{ $consultant->user->name ?? $consultant->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="sra-btn-assign">Assign</button>
                                </form>
                            @elseif ($req->status === 'assigned')
                                <form method="POST" action="{{ route('admin.service-requests.cancel', $req->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="sra-empty">No service requests yet.</div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
        <div class="p-3 border-top">
            {{ $requests->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
