<div class="dropdown-menu dropdown-menu-end dropdown-menu-lg p-0">
    <div class="d-flex align-items-center gap-2 p-5 pb-0">
        <h6 class="flex-grow-1 mb-0">Notification ({{ $notifications->count() }})</h6>
        <a href="#!" class="link link-custom-primary"><i data-lucide="settings" class="size-4"></i></a>
    </div>
    <div class="py-5">
        <div class="topbar-notification px-5" style="height: 360px;" data-simplebar>
            <div class="vstack gap-3">
                @foreach($notifications as $note)
                <a href="#!" class="notification-item position-relative d-flex gap-3 p-3 rounded {{ $loop->first ? 'unread' : '' }}">
                    <div class="position-relative">
                        <img src="{{ asset('assets/images/' . $note['image']) }}" loading="lazy"
                            alt="Profile picture" class="rounded-circle size-9 flex-shrink-0">
                        <span class="bg-info badge rounded-circle notification top-end">
                            @if($note['type'] == 'land') <i class="ri-map-pin-line"></i>
                            @elseif($note['type'] == 'house') <i class="ri-home-2-line"></i>
                            @elseif($note['type'] == 'design') <i class="ri-layout-3-line"></i>
                            @elseif($note['type'] == 'agent') <i class="ri-user-line"></i>
                            @elseif($note['type'] == 'consultant') <i class="ri-team-line"></i>
                            @endif
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-1 fs-14 text-muted">
                            <span class="text-body fw-medium">{{ $note['title'] }}</span> added a new {{ $note['type'] }}
                        </p>
                        <p class="fs-12 text-muted">{{ $note['created_at']->diffForHumans() }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>