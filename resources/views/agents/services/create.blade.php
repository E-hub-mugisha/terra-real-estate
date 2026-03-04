@extends('layouts.agents')
@section('title', 'Manage Services')

@section('content')
<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm" style="border-radius:16px;">
        <div class="card-body p-4">

            <h4 class="fw-bold mb-4">🛠 Manage Your Services</h4>

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('agents.services.update') }}">
                @csrf

                <div class="row">

                    @foreach($services->groupBy('category.name') as $category => $categoryServices)

                    <div class="col-md-6 mb-4">
                        <div class="border rounded p-3 h-100">

                            <h6 class="fw-bold mb-3 text-primary">
                                {{ $category }}
                            </h6>

                            @foreach($categoryServices as $service)
                            <div class="form-check mb-2">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="services[]"
                                    value="{{ $service->id }}"
                                    id="service{{ $service->id }}"
                                    {{ $agent->services->contains($service->id) ? 'checked' : '' }}>

                                <label class="form-check-label" for="service{{ $service->id }}">
                                    <strong>{{ $service->title }}</strong>

                                    @if($service->price)
                                    <span class="text-muted small">
                                        ({{ number_format($service->price) }} RWF)
                                    </span>
                                    @endif

                                    <div class="small text-muted">
                                        {{ $service->description }}
                                    </div>
                                </label>
                            </div>
                            @endforeach

                        </div>
                    </div>

                    @endforeach

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        💾 Save Services
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<style>
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .border:hover {
        background: #f8f9fa;
        transition: 0.2s ease;
    }
</style>

@endsection