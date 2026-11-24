@extends('layouts.app')
@section('title', 'Property documents')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Property documents</h1>
        <p>Verify title deeds, permits and plans uploaded by owners, agents and partners.</p>
    </div>
</div>

<div class="tp-toolbar">
    @include('admin.marketplace._tabs', ['param' => 'status', 'current' => request('status', 'pending'), 'options' => ['pending' => 'Pending', 'verified' => 'Verified', 'rejected' => 'Rejected', 'all' => 'All']])
</div>

@if ($documents->isEmpty())
    @include('room._empty', ['icon' => 'file', 'title' => 'No documents', 'text' => 'Nothing matches this filter.'])
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Document</th><th>Listing</th><th>Uploaded by</th><th>Visibility</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @foreach ($documents as $doc)
                        <tr>
                            <td><strong style="color:var(--tu-ink);display:block">{{ $doc->title }}</strong><span style="font-size:.76rem;color:var(--tu-muted)">{{ $doc->typeLabel() }} · {{ $doc->original_name }}</span></td>
                            <td>@include('room._listing', ['listing' => $doc->listable])</td>
                            <td style="font-size:.84rem">{{ $doc->user->name ?? '—' }}<div style="font-size:.74rem;color:var(--tu-muted)">{{ $doc->created_at->diffForHumans() }}</div></td>
                            <td><span class="tu-badge">{{ $doc->is_public ? 'Public' : 'Private' }}</span></td>
                            <td>@include('room._status', ['status' => $doc->status])</td>
                            <td class="text-end">
                                <div class="tp-item-actions" style="flex-wrap:nowrap">
                                    <a href="{{ route('room.documents.download', $doc) }}" class="tu-btn tu-btn-sm tu-btn-icon" aria-label="Download"><x-tu-icon name="download" /></a>
                                    @if ($doc->status !== 'verified')
                                        <form method="POST" action="{{ route('admin.marketplace.documents.review', $doc) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="verified"><button class="tu-btn tu-btn-primary tu-btn-sm">Verify</button></form>
                                    @endif
                                    @if ($doc->status !== 'rejected')
                                        <form method="POST" action="{{ route('admin.marketplace.documents.review', $doc) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="rejected"><button class="tu-btn tu-btn-sm">Reject</button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $documents->links() }}</div>
@endif
@endsection
