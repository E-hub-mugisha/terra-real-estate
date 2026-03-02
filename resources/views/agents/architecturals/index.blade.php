@extends('layouts.app')

@section('title','Architectural Designs')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Architectural Designs</h1>
        <a href="{{ route('admin.architectural-designs.create') }}" class="btn btn-primary">
            + Add Design
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Preview</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Downloads</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($designs as $design)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($design->preview_image)
                                    <img src="{{ asset('storage/'.$design->preview_image) }}" width="60">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $design->title }}</td>
                            <td>{{ $design->category->name }}</td>
                            <td>{{ $design->user->name ?? 'Admin' }}</td>
                            <td>
                                {{ $design->is_free ? 'Free' : '$'.$design->price }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $design->status == 'approved' ? 'success' : ($design->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($design->status) }}
                                </span>
                            </td>
                            <td>{{ $design->download_count }}</td>
                            <td>
                                <a href="{{ route('admin.architectural-designs.show',$design) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.architectural-designs.edit',$design) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.architectural-designs.destroy',$design) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Delete this design?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No designs found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $designs->links() }}
        </div>
    </div>
</div>
@endsection
