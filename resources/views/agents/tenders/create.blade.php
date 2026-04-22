@extends('layouts.app')
@section('title', 'Create Tender')
@section('content')

<form method="POST" action="{{ route('admin.tenders.store') }}" enctype="multipart/form-data">
    @csrf

    <input name="title" class="form-control mb-2" placeholder="Tender title" required>
    <textarea name="description" class="form-control mb-2" placeholder="Tender description" required></textarea>

    <input name="reference_no" class="form-control mb-2" placeholder="Reference No (optional)">
    <input name="budget" type="number" class="form-control mb-2" placeholder="Budget (RWF)">

    <input name="location" class="form-control mb-2" placeholder="Location (Kigali, Huye, Musanze)">
    <input name="submission_deadline" type="date" class="form-control mb-2" required>

    <input type="file" name="document" class="form-control mb-3">

    <button class="btn btn-primary w-100">Publish Tender</button>
</form>

@endsection