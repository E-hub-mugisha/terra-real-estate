@extends('layouts.property-management.app')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid py-3">

    <div class="d-flex flex-wrap justify-content-between
                align-items-center gap-3 mb-4">
        <div>
            <h1 class="h4 mb-1">Notifications</h1>
            <p class="text-muted mb-0">
                Updates about rent, leases, maintenance and applications.
            </p>
        </div>

        @if ($unreadCount > 0)
            <form method="POST"
                  action="{{ route('notifications.read-all') }}">
                @csrf
                @method('PATCH')

                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-check2-all me-1"></i>
                    Mark all as read
                </button>
            </form>
        @endif
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            @forelse ($notifications as $notification)
                <div class="d-flex gap-3 align-items-start
                            p-3 border-bottom
                            {{ $notification->read_at ? '' : 'bg-light' }}">

                    <div class="rounded-circle bg-white border
                                d-flex align-items-center justify-content-center"
                         style="width: 42px; height: 42px; flex-shrink: 0;">
                        <i class="bi bi-bell text-secondary fs-5"></i>
                    </div>

                    <div class="flex-grow-1">
                        <div class="d-flex flex-wrap
                                    justify-content-between gap-2">
                            <h2 class="h6 mb-1">
                                {{ $notification->title }}

                                @if (! $notification->read_at)
                                    <span class="badge text-bg-primary ms-1">
                                        New
                                    </span>
                                @endif
                            </h2>

                            <small class="text-muted">
                                {{ $notification->created_at->diffForHumans() }}
                            </small>
                        </div>

                        <p class="text-muted mb-2">
                            {{ $notification->message }}
                        </p>

                        @if ($notification->priority === 'high'
                            || $notification->priority === 'urgent')
                            <span class="badge text-bg-warning mb-2">
                                {{ ucfirst($notification->priority) }} priority
                            </span>
                        @endif

                        @if ($notification->action_url)
                            <form method="POST"
                                  action="{{ route('notifications.read', $notification) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="btn btn-sm btn-outline-primary">
                                    View details
                                </button>
                            </form>
                        @elseif (! $notification->read_at)
                            <form method="POST"
                                  action="{{ route('notifications.read', $notification) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="btn btn-sm btn-outline-secondary">
                                    Mark as read
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5 px-3">
                    <i class="bi bi-bell-slash fs-1 text-muted"></i>
                    <h2 class="h6 mt-3">You're all caught up</h2>
                    <p class="text-muted mb-0">
                        New property-management updates will appear here.
                    </p>
                </div>
            @endforelse

        </div>
    </div>

    <div class="mt-3">
        {{ $notifications->links() }}
    </div>

</div>
@endsection