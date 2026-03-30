<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::where('user_id', auth()->id())
            ->when($request->module, fn($q) => $q->where('module', $request->module))
            ->when($request->action, fn($q) => $q->where('action', $request->action))
            ->when($request->search, fn($q) => $q->where('description', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(20);

        $modules = ActivityLog::where('user_id', auth()->id())
            ->distinct()
            ->pluck('module');

        return view('admin.activity-logs.index', compact('logs', 'modules'));
    }
}
