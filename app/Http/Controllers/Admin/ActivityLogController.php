<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    // app/Http/Controllers/Admin/ActivityLogController.php

    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($search = $request->search) {
            $query->where('description', 'like', "%{$search}%")
                ->orWhere('module', 'like', "%{$search}%");
        }

        if ($module = $request->module)    $query->where('module', $module);
        if ($action = $request->action)    $query->where('action', $action);
        if ($userId = $request->user_id)   $query->where('user_id', $userId);
        if ($from   = $request->date_from) $query->whereDate('created_at', '>=', $from);
        if ($to     = $request->date_to)   $query->whereDate('created_at', '<=', $to);

        $logs = $query->paginate(25);

        return view('admin.activity-logs.index', [
            'logs'         => $logs,
            'modules'      => ActivityLog::distinct()->pluck('module'),
            'users'        => \App\Models\User::orderBy('name')->get(['id', 'name', 'email']),
            'totalCount'   => ActivityLog::count(),
            'todayCount'   => ActivityLog::whereDate('created_at', today())->count(),
            'deletedCount' => ActivityLog::where('action', 'deleted')
                ->where('created_at', '>=', now()->subDays(30))->count(),
            'activeUsers'  => ActivityLog::where('created_at', '>=', now()->subDays(7))
                ->distinct('user_id')->count('user_id'),
        ]);
    }

    public function export(Request $request)
    {
        $logs = ActivityLog::with('user')
            ->when($request->module,    fn($q) => $q->where('module', $request->module))
            ->when($request->action,    fn($q) => $q->where('action', $request->action))
            ->when($request->user_id,   fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->date_from, fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to,   fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->latest()
            ->get();

        $filename = 'activity-logs-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($logs) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID', 'User', 'Email', 'Action', 'Module', 'Description', 'Subject Type', 'Subject ID', 'IP Address', 'Date']);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->id,
                    $log->user?->name,
                    $log->user?->email,
                    $log->action,
                    $log->module,
                    $log->description,
                    $log->subject_type ? class_basename($log->subject_type) : null,
                    $log->subject_id,
                    $log->ip_address,
                    $log->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
