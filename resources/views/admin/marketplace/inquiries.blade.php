@extends('layouts.app')
@section('title', 'Inquiries')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Inquiry monitor</h1>
        <p>Every question sent to owners, agents and partners across the marketplace.</p>
    </div>
    <a href="{{ route('admin.marketplace.export', 'inquiries') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="download" /> Export CSV</a>
</div>

@if ($unanswered)
    <div class="tu-alert" style="margin-bottom:16px"><x-tu-icon name="clock" /> <strong>{{ $unanswered }}</strong> {{ \Illuminate\Support\Str::plural('inquiry', $unanswered) }} unanswered for more than 2 days. Consider following up with the owner.</div>
@endif

<div class="tp-toolbar">
    @include('admin.marketplace._tabs', ['param' => 'status', 'current' => request('status', ''), 'options' => ['' => 'All', 'new' => 'New', 'replied' => 'Replied', 'closed' => 'Closed']])
    <form method="GET" style="display:flex;gap:8px">
        @if (request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
        <label class="tu-sr" for="q">Search</label>
        <input id="q" class="tu-input" name="q" value="{{ request('q') }}" placeholder="Name, email or text" style="height:38px;min-width:220px">
        <button class="tu-btn tu-btn-sm">Search</button>
    </form>
</div>

@if ($inquiries->isEmpty())
    @include('room._empty', ['icon' => 'mail', 'title' => 'No inquiries', 'text' => 'Nothing matches this filter.'])
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>From</th><th>Listing</th><th>To</th><th style="min-width:260px">Message</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach ($inquiries as $i)
                        <tr>
                            <td><strong style="color:var(--tu-ink);display:block">{{ $i->name }}</strong><span style="font-size:.76rem;color:var(--tu-muted)">{{ $i->email }}{{ $i->phone ? ' · ' . $i->phone : '' }}</span></td>
                            <td>@include('room._listing', ['listing' => $i->listable])</td>
                            <td style="font-size:.84rem">{{ $i->recipient->name ?? 'Terra team' }}</td>
                            <td style="font-size:.84rem">{{ \Illuminate\Support\Str::limit($i->message, 120) }}<div style="font-size:.72rem;color:var(--tu-subtle)">{{ $i->created_at->format('j M Y H:i') }}</div></td>
                            <td>@include('room._status', ['status' => $i->status])</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $inquiries->links() }}</div>
@endif
@endsection
