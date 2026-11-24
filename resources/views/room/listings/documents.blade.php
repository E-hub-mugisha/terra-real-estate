@extends('layouts.agents')
@section('title', 'Listing documents')

@section('content')
<div class="tp-page-head">
    <div>
        <a href="{{ route('room.listings.index') }}" class="tu-link-arrow" style="font-size:.82rem"><x-tu-icon name="arrow-left" size="14" /> My listings</a>
        <h1 style="margin-top:6px">Property documents</h1>
        <p>Upload the title deed, permits or plans. Terra verifies them; verified documents marked public can be downloaded by clients.</p>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">@include('room._listing', ['listing' => $listing])</div>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">Upload a document</div>
            <form method="POST" action="{{ route('room.listings.documents.store', [$type, $listing->id]) }}" enctype="multipart/form-data" class="card-body tu-stack" style="gap:14px">
                @csrf
                <div class="tu-field">
                    <label for="docTitle">Title</label>
                    <input id="docTitle" class="tu-input" name="title" value="{{ old('title') }}" required maxlength="150" placeholder="e.g. Title deed — UPI 1/02/03/04/1234">
                    @error('title')<div class="tu-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="tu-field">
                    <label for="docType">Type</label>
                    <select id="docType" class="tu-select" name="type" required>
                        @foreach (\App\Models\ListingDocument::TYPES as $key => $label)
                            <option value="{{ $key }}" @selected(old('type') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="tu-field">
                    <label for="docFile">File <span class="tu-hint">PDF, image or Word · max 10 MB</span></label>
                    <input id="docFile" class="tu-input" type="file" name="file" required accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx" style="padding:9px">
                    @error('file')<div class="tu-field-error">{{ $message }}</div>@enderror
                </div>
                <label class="tu-check">
                    <input type="checkbox" name="is_public" value="1" @checked(old('is_public'))>
                    <span>Let clients download it once verified</span>
                </label>
                <button type="submit" class="tu-btn tu-btn-primary"><x-tu-icon name="arrow-up" /> Upload</button>
            </form>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">Uploaded ({{ $documents->count() }})</div>
            @if ($documents->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="file" /></div><strong>No documents yet</strong>Verified documents build trust with buyers.</div>
            @else
                <ul class="tp-list">
                    @foreach ($documents as $doc)
                        <li>
                            <span class="tp-stat-ico" style="width:38px;height:38px"><x-tu-icon name="file" /></span>
                            <span class="tp-list-main">
                                <strong>{{ $doc->title }}</strong>
                                <span>{{ $doc->typeLabel() }} · {{ $doc->size ? number_format($doc->size / 1024) . ' KB' : '' }} · {{ $doc->is_public ? 'Public when verified' : 'Private' }}</span>
                            </span>
                            @include('room._status', ['status' => $doc->status])
                            <a href="{{ route('room.documents.download', $doc) }}" class="tu-btn tu-btn-sm tu-btn-icon" aria-label="Download {{ $doc->title }}"><x-tu-icon name="download" /></a>
                            <form method="POST" action="{{ route('room.documents.destroy', $doc) }}" onsubmit="return confirm('Remove this document?')">
                                @csrf @method('DELETE')
                                <button class="tu-btn tu-btn-sm tu-btn-icon" aria-label="Remove {{ $doc->title }}" style="color:var(--tu-danger)"><x-tu-icon name="x" /></button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
