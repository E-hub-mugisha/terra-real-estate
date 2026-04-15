@extends('layouts.professional')

@section('title', 'My Designs — Terra Professional')
@section('page_title', 'My Designs')

@section('content')
<div class="page-header">
    <div>
        <h1>My Designs</h1>
        <p>Manage your architectural design portfolio</p>
    </div>
    <a href="{{ route('professional.designs.create') }}" class="btn-gold-lg">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        New Design
    </a>
</div>

{{-- Filter Bar --}}
<form method="GET" class="filter-bar">
    <input type="text" name="search" placeholder="Search designs…" value="{{ request('search') }}">
    <select name="status">
        <option value="">All Statuses</option>
        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
        <option value="draft"  {{ request('status') === 'draft'  ? 'selected' : '' }}>Draft</option>
    </select>
    <select name="category">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn-navy" style="padding:10px 18px;font-size:14px;">
        Filter
    </button>
    @if(request()->hasAny(['search','status','category']))
        <a href="{{ route('professional.designs.index') }}" class="btn-outline">Clear</a>
    @endif
    <span style="margin-left:auto;font-size:13px;color:var(--muted)">
        {{ $designs->total() }} design{{ $designs->total() !== 1 ? 's' : '' }}
    </span>
</form>

{{-- Grid --}}
@if($designs->isEmpty())
<div class="panel">
    <div class="empty-state">
        <div class="empty-state-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        </div>
        <h3>No designs yet</h3>
        <p>Start building your portfolio by adding your first architectural design.</p>
        <a href="{{ route('professional.designs.create') }}" class="btn-gold-lg">Add Your First Design</a>
    </div>
</div>
@else
<div class="design-grid">
    @foreach($designs as $design)
    <div class="design-card">
        <div class="design-thumb" style="background-image: url('{{ $design->cover_image_url }}')">
            <div class="design-thumb-overlay"></div>
            <div class="design-thumb-status">
                <span class="status-badge status-{{ $design->status }}">{{ $design->status }}</span>
            </div>
            <div class="design-thumb-actions">
                <a href="{{ route('professional.designs.edit', $design) }}" class="design-thumb-btn" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
                <a href="{{ route('professional.designs.show', $design) }}" class="design-thumb-btn" title="View">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
            </div>
        </div>
        <div class="design-card-body">
            <div class="design-card-category">{{ $design->category }}</div>
            <h3 class="design-card-title">{{ $design->title }}</h3>
            <div class="design-card-specs">
                @if($design->bedrooms !== null)
                <div class="design-spec">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                    {{ $design->bedrooms }} bed
                </div>
                @endif
                @if($design->bathrooms !== null)
                <div class="design-spec">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 12h16a1 1 0 011 1v3a4 4 0 01-4 4H7a4 4 0 01-4-4v-3a1 1 0 011-1z"/><path d="M6 12V5a2 2 0 012-2h3v2.25"/></svg>
                    {{ $design->bathrooms }} bath
                </div>
                @endif
                @if($design->total_area_sqft)
                <div class="design-spec">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                    {{ number_format($design->total_area_sqft) }} sqft
                </div>
                @endif
            </div>
            <div class="design-card-footer">
                <span class="design-price">{{ $design->formatted_price }}</span>
                <span class="design-orders-count">{{ $design->orders()->count() }} inquiries</span>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div style="margin-top:20px">{{ $designs->appends(request()->query())->links() }}</div>
@endif
@endsection
