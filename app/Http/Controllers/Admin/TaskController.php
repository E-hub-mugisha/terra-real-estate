<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TerraTask;
use App\Models\TerraTaskSubmission;
use App\Models\TerraTaskDocument;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{

    // ═══════════════════════════════════════════════════════════
    //  INDEX — task list with filters, search, stats
    // ═══════════════════════════════════════════════════════════

    public function index(Request $request)
    {
        $query = TerraTask::with(['assignee', 'submissions'])
            ->withCount('submissions');

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'overdue') {
                $query->where('status', '!=', 'completed')->where('deadline', '<', now());
            } else {
                $query->where('status', $request->status);
            }
        }

        // Priority filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Role filter (filter by assignee role)
        if ($request->filled('role')) {
            $query->whereHas('assignee', fn($q) => $q->where('role', $request->role));
        }

        // Search
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhereHas(
                        'assignee',
                        fn($r) =>
                        $r->where('first_name', 'like', "%{$q}%")
                            ->orWhere('last_name',  'like', "%{$q}%")
                            ->orWhere('email',       'like', "%{$q}%")
                    );
            });
        }

        $tasks = $query->latest()->paginate(20);

        $stats = [
            'total'        => TerraTask::count(),
            'pending'      => TerraTask::where('status', 'pending')->count(),
            'in_progress'  => TerraTask::where('status', 'in_progress')->count(),
            'under_review' => TerraTask::where('status', 'under_review')->count(),
            'completed'    => TerraTask::where('status', 'completed')->count(),
        ];

        $pendingSubmissions = TerraTaskSubmission::where('status', 'under_review')->count();

        return view('admin.tasks.index', compact('tasks', 'stats', 'pendingSubmissions'));
    }

    // ═══════════════════════════════════════════════════════════
    //  CREATE / STORE
    // ══════════════════════════════════════

    public function create()
{
    $assignableUsers = User::whereIn('role', ['professional', 'consultant', 'user'])
        ->orderBy('name')
        ->get();

    $task = new TerraTask();

    $assignableUsersJson = $assignableUsers->map(function ($u) {
        $parts = array_slice(explode(' ', $u->name), 0, 2);
        $init  = strtoupper(implode('', array_map(fn($w) => $w[0], $parts)));
        return [
            'id'    => $u->id,
            'name'  => $u->name,
            'email' => $u->email,
            'role'  => $u->role,
            'init'  => $init,
        ];
    })->values()->toArray();

    return view('admin.tasks.create-edit', compact('task', 'assignableUsers', 'assignableUsersJson'));
}

public function edit(TerraTask $task)
{
    $assignableUsers = User::whereIn('role', ['professional', 'consultant', 'user'])
        ->orderBy('name')
        ->get();

    $assignableUsersJson = $assignableUsers->map(function ($u) {
        $parts = array_slice(explode(' ', $u->name), 0, 2);
        $init  = strtoupper(implode('', array_map(fn($w) => $w[0], $parts)));
        return [
            'id'    => $u->id,
            'name'  => $u->name,
            'email' => $u->email,
            'role'  => $u->role,
            'init'  => $init,
        ];
    })->values()->toArray();

    return view('admin.tasks.create-edit', compact('task', 'assignableUsers', 'assignableUsersJson'));
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:5000'],
            'assigned_to' => ['required', 'exists:users,id'],
            'priority'    => ['required', 'in:low,medium,high'],
            'deadline'    => ['required', 'date', 'after_or_equal:today'],
            'category'    => ['nullable', 'string', 'max:80'],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
            'attachments'    => ['nullable', 'array'],
            'attachments.*'  => ['file', 'max:20480', 'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,gif,webp,zip'],
        ]);

        $task = TerraTask::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'assigned_to' => $data['assigned_to'],
            'assigned_by' => Auth::id(),
            'priority'    => $data['priority'],
            'deadline'    => $data['deadline'],
            'category'    => $data['category'] ?? null,
            'admin_notes' => $data['admin_notes'] ?? null,
            'status'      => 'pending',
        ]);

        $this->uploadAttachments($request, $task);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task assigned to ' . $task->assignee->full_name . ' successfully.');
    }

    public function update(Request $request, TerraTask $task)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:120'],
            'description'  => ['nullable', 'string', 'max:5000'],
            'assigned_to'  => ['required', 'exists:users,id'],
            'priority'     => ['required', 'in:low,medium,high'],
            'status'       => ['required', 'in:pending,in_progress,under_review,completed,overdue'],
            'deadline'     => ['required', 'date'],
            'category'     => ['nullable', 'string', 'max:80'],
            'admin_notes'  => ['nullable', 'string', 'max:2000'],
            'delete_files' => ['nullable', 'array'],
            'delete_files.*' => ['exists:task_documents,id'],
            'attachments'    => ['nullable', 'array'],
            'attachments.*'  => ['file', 'max:20480', 'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,gif,webp,zip'],
        ]);

        $task->update([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'assigned_to' => $data['assigned_to'],
            'priority'    => $data['priority'],
            'status'      => $data['status'],
            'deadline'    => $data['deadline'],
            'category'    => $data['category'] ?? null,
            'admin_notes' => $data['admin_notes'] ?? null,
        ]);

        // Remove flagged files
        if (!empty($data['delete_files'])) {
            TerraTaskDocument::whereIn('id', $data['delete_files'])
                ->where('task_id', $task->id)
                ->each(fn($doc) => $doc->delete()); // triggers booted() hook
        }

        $this->uploadAttachments($request, $task);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    // ═══════════════════════════════════════════════════════════
    //  SHOW (detail)
    // ═══════════════════════════════════════════════════════════

    public function show(TerraTask $task)
    {
        $task->load(['assignee', 'assignedBy', 'files', 'submissions.files', 'submissions.submitter']);
        return view('admin.tasks.show', compact('task'));
    }

    // ═══════════════════════════════════════════════════════════
    //  DESTROY
    // ═══════════════════════════════════════════════════════════

    public function destroy(TerraTask $task)
    {
        // Files deleted via TaskDocument::booted()
        $task->files->each(fn($f) => $f->delete());
        $task->delete();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task deleted.');
    }

    // ═══════════════════════════════════════════════════════════
    //  SUBMISSIONS — list for a task
    // ═══════════════════════════════════════════════════════════

    public function submissions(TerraTask $task)
    {
        $task->load([
            'assignee',
            'assignedBy',
            'files',
            'submissions' => fn($q) => $q->with('files', 'submitter')->latest()
        ]);

        return view('admin.tasks.submissions', compact('task'));
    }

    /**
     * All pending submissions across all tasks — global review page.
     */
    public function allSubmissions(Request $request)
    {
        $submissions = TerraTaskSubmission::with(['task.assignee', 'files', 'submitter'])
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return view('admin.tasks.all-submissions', compact('submissions'));
    }

    // ═══════════════════════════════════════════════════════════
    //  APPROVE / REJECT submission
    // ═══════════════════════════════════════════════════════════

    public function approveSubmission(Request $request, TerraTaskSubmission $submission)
    {
        $request->validate([
            'reviewer_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $submission->update([
            'status'         => 'approved',
            'reviewer_notes' => $request->reviewer_notes,
            'reviewed_by'    => Auth::id(),
            'reviewed_at'    => now(),
        ]);

        // Auto-complete the task if this is a final delivery
        if ($submission->submission_type === 'final_delivery') {
            $submission->task->update(['status' => 'completed']);
        }

        return redirect()->back()->with('success', 'Submission approved.');
    }

    public function rejectSubmission(Request $request, TerraTaskSubmission $submission)
    {
        $request->validate([
            'reviewer_notes' => ['required', 'string', 'max:1000'],
        ]);

        $submission->update([
            'status'         => 'rejected',
            'reviewer_notes' => $request->reviewer_notes,
            'reviewed_by'    => Auth::id(),
            'reviewed_at'    => now(),
        ]);

        // Revert task to in_progress so the user can resubmit
        if ($submission->task->status === 'under_review') {
            $submission->task->update(['status' => 'in_progress']);
        }

        return redirect()->back()->with('success', 'Submission rejected. The assignee can now resubmit.');
    }

    // ═══════════════════════════════════════════════════════════
    //  QUICK STATUS UPDATE (from submissions page strip)
    // ═══════════════════════════════════════════════════════════

    public function updateStatus(Request $request, TerraTask $task)
    {
        $request->validate(['status' => ['required', 'in:pending,in_progress,under_review,completed,overdue']]);
        $task->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Task status updated.');
    }

    // ═══════════════════════════════════════════════════════════
    //  BULK ACTIONS
    // ═══════════════════════════════════════════════════════════

    public function bulk(Request $request)
    {
        $request->validate([
            'action' => ['required', 'in:mark_complete,mark_overdue,delete'],
            'ids'    => ['required', 'string'],
        ]);

        $ids = array_filter(explode(',', $request->ids), 'is_numeric');

        if (empty($ids)) {
            return redirect()->back()->with('error', 'No tasks selected.');
        }

        $tasks = TerraTask::whereIn('id', $ids)->get();

        match ($request->action) {
            'mark_complete' => $tasks->each(fn($t) => $t->update(['status' => 'completed'])),
            'mark_overdue'  => $tasks->each(fn($t) => $t->update(['status' => 'overdue'])),
            'delete'        => $tasks->each(function ($t) {
                $t->files->each(fn($f) => $f->delete());
                $t->delete();
            }),
        };

        $label = match ($request->action) {
            'mark_complete' => 'marked as complete',
            'mark_overdue'  => 'marked as overdue',
            'delete'        => 'deleted',
        };

        return redirect()->route('admin.tasks.index')
            ->with('success', count($ids) . ' task(s) ' . $label . '.');
    }

    // ═══════════════════════════════════════════════════════════
    //  DOCUMENT DOWNLOAD (admin)
    // ═══════════════════════════════════════════════════════════

    public function downloadDocument(TerraTaskDocument $document)
    {
        return Storage::disk('private')->download($document->path, $document->original_name);
    }

    // ═══════════════════════════════════════════════════════════
    //  PRIVATE HELPERS
    // ═══════════════════════════════════════════════════════════

    private function uploadAttachments(Request $request, TerraTask $task): void
    {
        if (!$request->hasFile('attachments')) return;

        foreach ($request->file('attachments') as $file) {
            $path = $file->store("task-documents/{$task->id}", 'private');

            TerraTaskDocument::create([
                'task_id'       => $task->id,
                'submission_id' => null,
                'uploaded_by'   => Auth::id(),
                'original_name' => $file->getClientOriginalName(),
                'path'          => $path,
                'mime_type'     => $file->getMimeType(),
                'size'          => $file->getSize(),
            ]);
        }
    }
}
