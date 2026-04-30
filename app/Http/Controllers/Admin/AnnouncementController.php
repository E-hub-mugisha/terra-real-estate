<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('creator')->latest()->get();

        $stats = [
            'total'    => $announcements->count(),
            'active'   => $announcements->where('status', 'active')->count(),
            'paid'     => $announcements->where('status', 'paid')->count(),
            'pending'  => $announcements->where('status', 'pending')->count(),
            'expired'  => $announcements->where('status', 'expired')->count(),
        ];

        return view('admin.announcements.index', compact('announcements', 'stats'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'slug'       => 'nullable|string|max:255|unique:announcements,slug',
            'content'    => 'nullable|string',
            'status'     => 'required|in:pending,paid,expired,active,inactive',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $data['slug']       = $data['slug']
            ? Str::slug($data['slug'])
            : Str::slug($data['title']) . '-' . Str::random(5);
        $data['created_by'] = Auth::id();

        Announcement::create($data);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', '✅ Announcement created successfully.');
    }

    public function show(Announcement $announcement, Request $request)
    {
        $announcement->load('creator');

        $announcement->recordView($request);

        $viewStats = [
            'total'       => $announcement->views,
             'today'       => $announcement->viewsToday(),
             'this_week'   => $announcement->viewsThisWeek(),
             'this_month'  => $announcement->viewsThisMonth(),
             'daily_chart' => $announcement->dailyViewsForPast(14),
         ];

        return view('admin.announcements.show', compact('announcement', 'viewStats'));
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'slug'       => 'nullable|string|max:255|unique:announcements,slug,' . $announcement->id,
            'content'    => 'nullable|string',
            'status'     => 'required|in:pending,paid,expired,active,inactive',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $data['slug'] = $data['slug']
            ? Str::slug($data['slug'])
            : $announcement->slug;

        $announcement->update($data);

        return back()->with('success', '✅ Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $title = $announcement->title;
        $announcement->delete(); // soft delete

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', "Announcement \"{$title}\" has been deleted.");
    }

    public function updateStatus(Request $request, Announcement $announcement)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,expired,active,inactive',
        ]);

        $announcement->update(['status' => $request->status]);

        return back()->with('success', "Status updated to " . ucfirst($request->status) . ".");
    }

    public function trashed()
    {
        $trashed = Announcement::onlyTrashed()->with('creator')->latest()->get();

        return view('admin.announcements.trashed', compact('trashed'));
    }

    public function restore($id)
    {
        $announcement = Announcement::onlyTrashed()->findOrFail($id);
        $announcement->restore();

        return back()->with('success', "Announcement \"{$announcement->title}\" has been restored.");
    }

    public function forceDelete($id)
    {
        $announcement = Announcement::onlyTrashed()->findOrFail($id);
        $title = $announcement->title;
        $announcement->forceDelete();

        return back()->with('success', "Announcement \"{$title}\" permanently deleted.");
    }
}