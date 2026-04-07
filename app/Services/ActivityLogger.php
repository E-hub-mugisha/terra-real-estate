<?php
// app/Services/ActivityLogger.php
namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(
        string $action,
        string $module,
        string $description,
        ?object $subject = null,
        array $properties = []
    ): void {
        try {
            ActivityLog::create([
                'user_id'      => Auth::id(),
                'action'       => $action,
                'module'       => $module,
                'description'  => $description,
                'subject_type' => $subject ? get_class($subject) : null,
                'subject_id'   => $subject?->id,
                'properties'   => $properties ?: null,
                'ip_address'   => Request::ip(),
                'user_agent'   => Request::userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Never let logging break the app
            Log::error('ActivityLogger failed: ' . $e->getMessage());
        }
    }

    // Shorthand helpers for common actions
    public static function created(string $module, string $description, ?object $subject = null, array $props = []): void
    {
        static::log('created', $module, $description, $subject, $props);
    }

    public static function updated(string $module, string $description, ?object $subject = null, array $props = []): void
    {
        static::log('updated', $module, $description, $subject, $props);
    }

    public static function deleted(string $module, string $description, ?object $subject = null, array $props = []): void
    {
        static::log('deleted', $module, $description, $subject, $props);
    }

    public static function viewed(string $module, string $description, ?object $subject = null): void
    {
        static::log('viewed', $module, $description, $subject);
    }

    public static function exported(string $module, string $description, array $props = []): void
    {
        static::log('exported', $module, $description, null, $props);
    }

    public static function login(): void
    {
        static::log('login', 'Auth', 'User logged in');
    }

    public static function logout(): void
    {
        static::log('logout', 'Auth', 'User logged out');
    }
}