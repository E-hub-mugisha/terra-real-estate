@extends('layouts.guest')
@section('title', $design->title)
@section('content')

<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $design->title }}</h1>
            <p><strong>Category:</strong> {{ $design->category?->name }}</p>
            <p>{{ $design->description }}</p>
            <p><strong>Price:</strong> 
                @if($design->is_free)
                    Free
                @else
                    ${{ number_format($design->price,2) }}
                @endif
            </p>

            @if($design->is_free)
                <a href="{{ route('front.buy.design.purchase', $design->slug) }}" class="btn btn-success">
                    Download Now
                </a>
            @else
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inquiryModal">
                    Send Inquiry to Buy
                </button>
            @endif
        </div>

        <div class="col-md-4">
            <img src="{{ asset('storage/' . $design->preview_image) }}" class="img-fluid" alt="Preview">
        </div>
    </div>
</div>

<!-- Inquiry Modal -->
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('front.buy.design.inquiry') }}" method="POST" class="modal-content">
        @csrf
        <input type="hidden" name="design_id" value="{{ $design->id }}">
        <div class="modal-header">
            <h5 class="modal-title" id="inquiryModalLabel">Send Inquiry for {{ $design->title }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>Your Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Your Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Message</label>
                <textarea name="message" class="form-control" rows="4" required>Hi, I am interested in purchasing your design: {{ $design->title }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Send Inquiry</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
  </div>
</div>

@endsection
