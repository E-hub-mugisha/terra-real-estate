@extends('layouts.guest')
@section('title', $tender->title)
@section('content')


<div class="blog-inner-section sp1">
    <div class="container">
        <div class="row">

            <div class="col-lg-8">

                <div class="card shadow-sm p-4">

                    <h2 class="mb-3">{{ $tender->title }}</h2>

                    <p class="text-muted">
                        Reference No: <strong>{{ $tender->reference_no }}</strong>
                    </p>

                    <hr>

                    <h5>Description</h5>
                    <p>
                        {{ $tender->description }}
                    </p>

                    <hr>

                    <div class="row">

                        <div class="col-md-6">
                            <p><strong>Budget:</strong> ${{ number_format($tender->budget,2) }}</p>
                        </div>

                        <div class="col-md-6">
                            <p><strong>Location:</strong> {{ $tender->location }}</p>
                        </div>

                        <div class="col-md-6">
                            <p>
                                <strong>Submission Deadline:</strong>
                                {{ \Carbon\Carbon::parse($tender->submission_deadline)->format('d M Y') }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <p>
                                <strong>Status:</strong>

                                @if($tender->is_open)
                                <span class="badge bg-success">Open</span>
                                @else
                                <span class="badge bg-danger">Closed</span>
                                @endif

                            </p>
                        </div>

                    </div>

                    @if($tender->document_path)
                    <hr>

                    <a href="{{ asset('storage/'.$tender->document_path) }}"
                        class="btn btn-primary"
                        target="_blank">
                        Download Tender Document
                    </a>
                    @endif

                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">

                <div class="card shadow-sm p-4">

                    <h5>Tender Owner</h5>

                    <p>
                        <strong>Posted by:</strong><br>
                        {{ $tender->user->name ?? 'N/A' }}
                    </p>

                    <p>
                        <strong>Posted On:</strong><br>
                        {{ $tender->created_at->format('d M Y') }}
                    </p>

                    <hr>

                    @if($tender->is_open)

                    <a href="#" class="btn btn-success w-100">
                        Apply for Tender
                    </a>

                    @else

                    <button class="btn btn-secondary w-100" disabled>
                        Tender Closed
                    </button>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>
@endsection