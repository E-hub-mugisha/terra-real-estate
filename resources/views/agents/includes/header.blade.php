<header class="main-topbar gap-md-2" id="main-topbar">
    <div class="navbar-brand">
        <div class="logos">
            <a href="{{ route('agent.dashboard.index') }}" aria-label="Topbar Logo" class="t-logo">{{ config('app.name') }}</a>
        </div>
        <button type="button" id="toggleSidebar" class="sidebar-toggle btn p-0" aria-label="Toggle sidebar">
            <i data-lucide="panel-right-open" class="size-4"></i>
        </button>
    </div>


    <div class="d-flex align-items-center gap-2 gap-md-3 ms-auto">

        {{-- Notifications --}}
        <div class="dropdown">
            <button class="btn topbar-link" type="button" aria-label="Notifications" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="position-relative">
                    <i class="ri-notification-4-line fs-lg"></i>
                    <span class="notification-animate bg-danger rounded-circle"></span>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg p-0">
                <div class="d-flex align-items-center gap-2 p-4 pb-3 border-bottom">
                    <h6 class="flex-grow-1 mb-0">Notifications</h6>
                    <span class="badge bg-primary-subtle text-primary">4 new</span>
                </div>
                <div class="py-3">
                    <div class="topbar-notification px-4" style="max-height: 360px; overflow-y: auto;">
                        <div class="vstack gap-1">
                            @forelse($notifications ?? [] as $n)
                                <a href="#!" class="notification-item d-flex gap-3 p-3 rounded {{ $n->read_at ? '' : 'unread' }}">
                                    <span class="avatar-icon bg-primary-subtle text-primary"><i class="ri-chat-3-line"></i></span>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 fs-14 text-body">{{ $n->message }}</p>
                                        <p class="fs-12 text-muted mb-0">{{ $n->created_at->diffForHumans() }}</p>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center text-muted py-5 fs-14">No notifications yet</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Messages --}}
        <div class="dropdown d-none d-md-block">
            <button class="btn topbar-link" type="button" aria-label="Messages" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="position-relative">
                    <i class="ri-message-3-line fs-lg"></i>
                    <span class="notification-animate bg-primary rounded-circle"></span>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg p-0">
                <div class="d-flex align-items-center gap-2 p-4 pb-3 border-bottom">
                    <h6 class="flex-grow-1 mb-0">Messages</h6>
                    <a href="#!" class="link link-primary small">View All <i class="ri-arrow-right-s-line"></i></a>
                </div>
                <div class="topbar-messages p-4">
                    <div class="vstack gap-3">
                        @forelse($recentInquiries ?? [] as $msg)
                            <a href="#!" class="d-flex gap-3 py-1 rounded">
                                <img src="{{ $msg->avatar ?? asset('dashboard/assets/images/user.jfif') }}" alt="{{ $msg->name }}" class="rounded-circle size-9 flex-shrink-0 object-fit-cover">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1 fw-medium text-body">{{ $msg->name }}</h6>
                                        <span class="fs-12 text-muted">{{ $msg->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="mb-1 fs-14 text-muted text-truncate">{{ $msg->excerpt }}</p>
                                    <span class="badge bg-primary-subtle text-primary fs-11">{{ $msg->type }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center text-muted py-4 fs-14">No new messages</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile --}}
        <div class="dropdown profile-dropdown">
            <button class="btn px-0 d-flex align-items-center text-body dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('dashboard/assets/images/user.jfif') }}"
                     loading="lazy" alt="{{ Auth::user()->name }}" class="object-fit-cover rounded-3 size-9">
                <span class="text-start ms-3 d-none d-xl-block">
                    <span class="d-block fw-medium pr-name fs-sm">{{ Auth::user()->name }}</span>
                    <small class="text-muted pr-desc">{{ Auth::user()->role ?? 'Agent' }}</small>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-md p-4 profile-dropdown-menu">
                <ul class="list-unstyled mb-0">
                    <li>
                        <a class="profile-link" href="{{ route('agent.profile.view') }}">
                            <i class="ri-user-3-line d-inline-block me-2 fs-17"></i>
                            My Profile <span class="text-primary"></span>
                        </a>
                    </li>
                    <li><a class="profile-link" href="#!"><i class="ri-settings-3-line d-inline-block me-2 fs-17"></i> Account Settings</a></li>
                    <li><a class="profile-link" href="#!"><i class="ri-customer-service-line d-inline-block me-2 fs-17"></i> Help Center</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <a href="#" class="profile-link pb-0 text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ri-logout-circle-r-line me-2 fs-17"></i> Log Out
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>


<style>
    .main-topbar { background: #fff; border-bottom: 1px solid #eef1ef; }
    .t-logo { font-weight: 700; color: #0f1b16; }
    .navbar-search { background: #f5f7f6; border-radius: 10px; padding: 0 10px; }
    .navbar-search .form-control { background: transparent; padding-left: 30px; }
    .navbar-search .icon { position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: #8a948f; }
    .topbar-link { color: #4b5563; position: relative; }
    .topbar-link:hover { color: #00a667; }
    .notification-animate { position: absolute; top: 2px; right: 0; width: 7px; height: 7px; }
    .avatar-icon { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .notification-item.unread { background: #f5fbf8; }
    .notification-item:hover { background: #f5f7f6; }
</style>
