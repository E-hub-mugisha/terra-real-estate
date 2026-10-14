<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = UserNotification::query()
            ->where('user_id', $request->user()->id)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->latest()
            ->paginate(20);

        $unreadCount = UserNotification::query()
            ->where('user_id', $request->user()->id)
            ->whereNull('read_at')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->count();

        return view('notifications.index', compact(
            'notifications',
            'unreadCount'
        ));
    }

    public function markAsRead(
        Request $request,
        UserNotification $notification
    ): RedirectResponse {
        abort_unless(
            $notification->user_id === $request->user()->id,
            404
        );

        $notification->update([
            'read_at' => $notification->read_at ?? now(),
        ]);

        if ($notification->action_url) {
            // Only permit relative, same-site paths.
            $path = parse_url($notification->action_url, PHP_URL_PATH);

            if (
                is_string($path) &&
                str_starts_with($path, '/') &&
                ! str_starts_with($path, '//')
            ) {
                return redirect($path);
            }
        }

        return redirect()
            ->route('notifications.index')
            ->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        UserNotification::query()
            ->where('user_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()
            ->route('notifications.index')
            ->with('success', 'All notifications marked as read.');
    }
}