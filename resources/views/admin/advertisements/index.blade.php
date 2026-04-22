@extends('layouts.app')

@section('title', 'Advertisements')


@section('content')
<style>
    /* ── Terra Ads Admin – Index ──────────────────────────────── */
    :root {
        --navy:   #19265d;
        --gold:   #C8873A;
        --gold-lt:#e0a55e;
        --cream:  #f9f6f1;
        --ink:    #1a1a2e;
        --muted:  #6b7280;
        --border: rgba(200,135,58,.18);
        --card-bg:#ffffff;
        --shadow: 0 2px 16px rgba(25,38,93,.08);
    }

    .ads-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 2rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .ads-header-title {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 2rem;
        font-weight: 600;
        color: var(--navy);
        line-height: 1;
    }

    .ads-header-title span {
        display: block;
        font-family: 'DM Sans', sans-serif;
        font-size: .72rem;
        font-weight: 500;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: .25rem;
    }

    /* Stat strip */
    .stat-strip {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: .75rem;
        margin-bottom: 1.75rem;
    }

    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 1rem 1.25rem;
        display: flex;
        flex-direction: column;
        gap: .25rem;
        box-shadow: var(--shadow);
        transition: border-color .2s;
    }

    .stat-card:hover { border-color: var(--gold); }

    .stat-card .stat-label {
        font-family: 'DM Sans', sans-serif;
        font-size: .68rem;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--muted);
    }

    .stat-card .stat-value {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--navy);
        line-height: 1;
    }

    .stat-card .stat-value.gold { color: var(--gold); }

    /* Filters */
    .filter-bar {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 1rem 1.25rem;
        display: flex;
        gap: .75rem;
        flex-wrap: wrap;
        align-items: center;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow);
    }

    .filter-bar select,
    .filter-bar input[type="text"] {
        font-family: 'DM Sans', sans-serif;
        font-size: .85rem;
        color: var(--ink);
        border: 1px solid rgba(25,38,93,.15);
        border-radius: 6px;
        padding: .45rem .75rem;
        background: var(--cream);
        outline: none;
        transition: border-color .2s;
    }

    .filter-bar select:focus,
    .filter-bar input[type="text"]:focus {
        border-color: var(--gold);
    }

    .filter-bar .btn-filter {
        font-family: 'DM Sans', sans-serif;
        font-size: .8rem;
        letter-spacing: .06em;
        padding: .45rem 1.1rem;
        border-radius: 6px;
        border: 1px solid var(--navy);
        background: var(--navy);
        color: #fff;
        cursor: pointer;
        transition: background .2s;
    }

    .filter-bar .btn-filter:hover { background: var(--gold); border-color: var(--gold); }

    .filter-bar .btn-reset {
        font-family: 'DM Sans', sans-serif;
        font-size: .8rem;
        color: var(--muted);
        background: none;
        border: 1px solid rgba(107,114,128,.3);
        border-radius: 6px;
        padding: .45rem .9rem;
        cursor: pointer;
        transition: color .2s, border-color .2s;
    }

    .filter-bar .btn-reset:hover { color: var(--gold); border-color: var(--gold); }

    /* Table card */
    .table-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .table-card table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-card thead {
        background: var(--navy);
    }

    .table-card thead th {
        font-family: 'DM Sans', sans-serif;
        font-size: .68rem;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: rgba(255,255,255,.65);
        padding: .85rem 1rem;
        font-weight: 500;
        text-align: left;
    }

    .table-card thead th:first-child { padding-left: 1.5rem; }
    .table-card thead th:last-child  { padding-right: 1.5rem; text-align: right; }

    .table-card tbody tr {
        border-bottom: 1px solid rgba(200,135,58,.08);
        transition: background .15s;
    }

    .table-card tbody tr:last-child { border-bottom: none; }
    .table-card tbody tr:hover { background: rgba(200,135,58,.04); }

    .table-card tbody td {
        font-family: 'DM Sans', sans-serif;
        font-size: .875rem;
        color: var(--ink);
        padding: .85rem 1rem;
        vertical-align: middle;
    }

    .table-card tbody td:first-child { padding-left: 1.5rem; }
    .table-card tbody td:last-child  { padding-right: 1.5rem; text-align: right; }

    /* Ad thumb */
    .ad-thumb {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .ad-thumb img {
        width: 44px;
        height: 44px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid var(--border);
        flex-shrink: 0;
    }

    .ad-thumb .ad-no-img {
        width: 44px;
        height: 44px;
        border-radius: 6px;
        background: var(--cream);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: var(--muted);
        font-size: .75rem;
    }

    .ad-thumb .ad-title {
        font-weight: 600;
        color: var(--navy);
        line-height: 1.2;
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ad-thumb .ad-sub {
        font-size: .75rem;
        color: var(--muted);
        margin-top: .1rem;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        padding: .28rem .65rem;
        border-radius: 30px;
        white-space: nowrap;
    }

    .badge::before {
        content: '';
        width: 5px; height: 5px;
        border-radius: 50%;
        background: currentColor;
        display: inline-block;
    }

    .badge-success  { background: #d1fae5; color: #065f46; }
    .badge-warning  { background: #fef3c7; color: #92400e; }
    .badge-danger   { background: #fee2e2; color: #991b1b; }
    .badge-secondary{ background: #f3f4f6; color: #374151; }
    .badge-info     { background: #dbeafe; color: #1e40af; }
    .badge-dark     { background: #1f2937; color: #d1d5db; }

    /* Actions */
    .action-btns {
        display: flex;
        justify-content: flex-end;
        gap: .5rem;
        align-items: center;
    }

    .btn-icon {
        width: 32px; height: 32px;
        border-radius: 6px;
        border: 1px solid var(--border);
        background: var(--cream);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--navy);
        cursor: pointer;
        transition: all .18s;
        text-decoration: none;
        font-size: .85rem;
    }

    .btn-icon:hover { background: var(--navy); color: #fff; border-color: var(--navy); }
    .btn-icon.danger:hover { background: #dc2626; border-color: #dc2626; color: #fff; }

    /* Btn primary */
    .btn-primary-terra {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        letter-spacing: .06em;
        font-weight: 600;
        padding: .6rem 1.4rem;
        border-radius: 8px;
        background: var(--gold);
        color: #fff;
        border: none;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s, transform .1s;
    }

    .btn-primary-terra:hover { background: #b5752e; color: #fff; transform: translateY(-1px); }

    /* Pagination override */
    .pagination-wrap { margin-top: 1.25rem; }

    /* Checkbox */
    .cb-select {
        accent-color: var(--gold);
        width: 15px; height: 15px;
        cursor: pointer;
    }

    /* Empty state */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state .empty-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--muted);
    }

    .empty-state p {
        font-family: 'DM Sans', sans-serif;
        color: var(--muted);
        font-size: .9rem;
    }

    .bulk-bar {
        display: none;
        align-items: center;
        gap: 1rem;
        background: var(--navy);
        color: #fff;
        padding: .6rem 1.5rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .bulk-bar.visible { display: flex; }

    .bulk-bar select {
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 5px;
        color: #fff;
        padding: .3rem .6rem;
        font-size: .8rem;
    }

    .bulk-bar button {
        background: var(--gold);
        border: none;
        border-radius: 5px;
        color: #fff;
        padding: .35rem .9rem;
        font-size: .8rem;
        cursor: pointer;
    }
</style>


<div class="container-fluid py-4 px-4">

    {{-- Header --}}
    <div class="ads-header">
        <h1 class="ads-header-title">
            <span>Terra Real Estate</span>
            Advertisements
        </h1>
        <a href="{{ route('admin.advertisements.create') }}" class="btn-primary-terra">
            <i class="bi bi-plus-lg"></i> New Advertisement
        </a>
    </div>

    {{-- Session flash --}}
    @if(session('success'))
        <div class="alert alert-success mb-3" style="font-family:'DM Sans',sans-serif;font-size:.85rem;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats strip --}}
    <div class="stat-strip">
        <div class="stat-card">
            <span class="stat-label">Total</span>
            <span class="stat-value">{{ $stats['total'] ?? 0 }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Active</span>
            <span class="stat-value gold">{{ $stats['active'] ?? 0 }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Pending Review</span>
            <span class="stat-value">{{ $stats['pending_review'] ?? 0 }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Expired</span>
            <span class="stat-value">{{ $stats['expired'] ?? 0 }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Total Impressions</span>
            <span class="stat-value">{{ number_format($stats['impressions'] ?? 0) }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Total Clicks</span>
            <span class="stat-value">{{ number_format($stats['clicks'] ?? 0) }}</span>
        </div>
    </div>

    {{-- Filter bar --}}
    <form method="GET" action="{{ route('admin.advertisements.index') }}">
        <div class="filter-bar">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search title, email, phone…"
                style="min-width:220px;"
            >

            <select name="status">
                <option value="">All Statuses</option>
                @foreach(['draft','pending_review','active','paused','expired','rejected'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>
                        {{ ucfirst(str_replace('_', ' ', $s)) }}
                    </option>
                @endforeach
            </select>

            <select name="payment_status">
                <option value="">All Payments</option>
                @foreach(['pending','confirmed','rejected'] as $p)
                    <option value="{{ $p }}" @selected(request('payment_status') === $p)>
                        {{ ucfirst($p) }}
                    </option>
                @endforeach
            </select>

            <select name="package_id">
                <option value="">All Packages</option>
                @foreach($packages as $pkg)
                    <option value="{{ $pkg->id }}" @selected(request('package_id') == $pkg->id)>
                        {{ $pkg->name }}
                    </option>
                @endforeach
            </select>

            <select name="sort">
                <option value="latest"   @selected(request('sort','latest') === 'latest')>Latest</option>
                <option value="oldest"   @selected(request('sort') === 'oldest')>Oldest</option>
                <option value="expires"  @selected(request('sort') === 'expires')>Expires Soon</option>
                <option value="clicks"   @selected(request('sort') === 'clicks')>Most Clicks</option>
            </select>

            <button type="submit" class="btn-filter">Filter</button>
            <a href="{{ route('admin.advertisements.index') }}" class="btn-reset">Reset</a>
        </div>
    </form>

    {{-- Bulk action bar --}}
    <form id="bulk-form" method="POST" action="{{ route('admin.advertisements.index') }}">
        @csrf
        <div class="bulk-bar" id="bulk-bar">
            <span id="bulk-count">0 selected</span>
            <select name="bulk_action">
                <option value="">Choose action…</option>
                <option value="approve">Approve</option>
                <option value="reject">Reject</option>
                <option value="expire">Mark Expired</option>
                <option value="delete">Delete</option>
            </select>
            <button type="submit">Apply</button>
            <button type="button" onclick="clearSelection()" style="background:rgba(255,255,255,.15);border:none;border-radius:5px;color:#fff;padding:.35rem .9rem;font-size:.8rem;cursor:pointer;">
                Clear
            </button>
        </div>

        {{-- Table --}}
        <div class="table-card">
            @if($advertisements->count())
                <table>
                    <thead>
                        <tr>
                            <th style="width:36px;">
                                <input type="checkbox" class="cb-select" id="select-all">
                            </th>
                            <th>Advertisement</th>
                            <th>Package</th>
                            <th>Owner</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Expires</th>
                            <th>Perf.</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($advertisements as $ad)
                        <tr>
                            <td>
                                <input
                                    type="checkbox"
                                    class="cb-select row-cb"
                                    name="selected[]"
                                    value="{{ $ad->id }}"
                                >
                            </td>
                            <td>
                                <div class="ad-thumb">
                                    @if(!empty($ad->images[0]))
                                        <img src="{{ asset($ad->images[0]) }}" alt="">
                                    @else
                                        <div class="ad-no-img">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="ad-title">{{ $ad->title }}</div>
                                        <div class="ad-sub">{{ $ad->location }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-size:.82rem;">
                                    {{ $ad->listingPackage?->name ?? '—' }}
                                </span>
                                <div style="font-size:.72rem;color:var(--muted);">
                                    {{ $ad->listing_days }}d · {{ $ad->formatted_total }}
                                </div>
                            </td>
                            <td>
                                <span style="font-size:.82rem;font-weight:500;">
                                    {{ $ad->user?->name ?? '—' }}
                                </span>
                                <div style="font-size:.72rem;color:var(--muted);">{{ $ad->contact_phone }}</div>
                            </td>
                            <td>
                                @php $sb = $ad->status_badge; @endphp
                                <span class="badge {{ $sb['class'] }}">{{ $sb['label'] }}</span>
                            </td>
                            <td>
                                @php $pb = $ad->payment_badge; @endphp
                                <span class="badge {{ $pb['class'] }}">{{ $pb['label'] }}</span>
                            </td>
                            <td style="font-size:.8rem;color:var(--muted);">
                                @if($ad->expires_at)
                                    {{ $ad->expires_at->format('d M Y') }}
                                    @if($ad->isExpired())
                                        <div style="color:#dc2626;font-size:.7rem;">Expired</div>
                                    @else
                                        <div style="color:#059669;font-size:.7rem;">
                                            in {{ $ad->expires_at->diffForHumans(null, true) }}
                                        </div>
                                    @endif
                                @else
                                    <span style="color:var(--muted);">—</span>
                                @endif
                            </td>
                            <td style="font-size:.78rem;white-space:nowrap;">
                                <span title="Impressions">👁 {{ number_format($ad->impressions) }}</span>
                                &nbsp;
                                <span title="Clicks">🖱 {{ number_format($ad->clicks) }}</span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.advertisements.show', $ad) }}"
                                       class="btn-icon" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.advertisements.edit', $ad) }}"
                                       class="btn-icon" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST"
                                          action="{{ route('admin.advertisements.destroy', $ad) }}"
                                          onsubmit="return confirm('Delete this advertisement?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-icon">📢</div>
                    <p>No advertisements found matching your filters.</p>
                </div>
            @endif
        </div>
    </form>

    {{-- Pagination --}}
    @if($advertisements->hasPages())
        <div class="pagination-wrap d-flex justify-content-end mt-3">
            {{ $advertisements->withQueryString()->links() }}
        </div>
    @endif

</div>

<script>
    // Select all
    document.getElementById('select-all')?.addEventListener('change', function () {
        document.querySelectorAll('.row-cb').forEach(cb => cb.checked = this.checked);
        updateBulkBar();
    });

    document.querySelectorAll('.row-cb').forEach(cb => {
        cb.addEventListener('change', updateBulkBar);
    });

    function updateBulkBar() {
        const checked = document.querySelectorAll('.row-cb:checked').length;
        const bar = document.getElementById('bulk-bar');
        document.getElementById('bulk-count').textContent = checked + ' selected';
        bar.classList.toggle('visible', checked > 0);
    }

    function clearSelection() {
        document.querySelectorAll('.row-cb, #select-all').forEach(cb => cb.checked = false);
        document.getElementById('bulk-bar').classList.remove('visible');
    }
</script>
@endsection