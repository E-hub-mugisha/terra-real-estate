<?php

namespace App\Http\Controllers\Users;

use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\TaskDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\TerraTask;
use App\Models\TerraTaskDocument;
use App\Models\TerraTaskSubmission;

class UserDashboardController extends   Controller
{
    /**
     * Main dashboard view.
     */
    public function index()
    {
        $user = Auth::user();

        // Tasks assigned to the logged-in user, paginated
        $tasks = TerraTask::where('assigned_to', $user->id)
            ->with('files')
            ->latest()
            ->paginate(15);

        // Only active/open tasks for the submit-task dropdown
        $activeTasks = TerraTask::where('assigned_to', $user->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderBy('deadline')
            ->get();

        // All documents the user has ever uploaded
        $documents = TerraTaskDocument::where('uploaded_by', $user->id)
            ->latest()
            ->get();

        return view('users.dashboard.index', compact('tasks', 'activeTasks', 'documents'));
    }

    /**
     * Handle task submission with optional file attachments.
     */
    public function submitTask(Request $request)
    {
        $request->validate([
            'task_id'         => ['required', 'exists:tasks,id'],
            'submission_type' => ['required', 'in:progress_update,final_delivery,additional_documents,revision'],
            'subject'         => ['required', 'string', 'max:120'],
            'notes'           => ['nullable', 'string', 'max:2000'],
            'files'           => ['nullable', 'array'],
            'files.*'         => ['file', 'max:20480', 'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,gif,webp,zip'],
        ]);

        $user = Auth::user();

        // Confirm this task actually belongs to the user
        $task = TerraTask::where('id', $request->task_id)
            ->where('assigned_to', $user->id)
            ->firstOrFail();

        // Create the submission record
        $submission = TerraTaskSubmission::create([
            'task_id'         => $task->id,
            'submitted_by'    => $user->id,
            'submission_type' => $request->submission_type,
            'subject'         => $request->subject,
            'notes'           => $request->notes,
            'status'          => 'under_review',
        ]);

        // Upload each attached file
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store("task-documents/{$task->id}", 'private');

                TerraTaskDocument::create([
                    'task_id'       => $task->id,
                    'submission_id' => $submission->id,
                    'uploaded_by'   => $user->id,
                    'original_name' => $file->getClientOriginalName(),
                    'path'          => $path,
                    'mime_type'     => $file->getMimeType(),
                    'size'          => $file->getSize(),
                ]);
            }
        }

        // Move task to under_review if it was pending/in_progress
        if (in_array($task->status, ['pending', 'in_progress'])) {
            $task->update(['status' => 'under_review']);
        }

        return redirect()->route('user.dashboard')
            ->with('success', 'Your submission was received and is now under review.');
    }

    /**
     * Force-download a document (private disk, user must own it).
     */
    public function downloadDocument(TerraTaskDocument $document)
    {
        $user = Auth::user();

        // Only allow owner or admin
        if ($document->uploaded_by !== $user->id && !$user->hasRole('admin')) {
            abort(403);
        }

        return response()->download(
            Storage::disk('private')->path($document->path),
            $document->original_name
        );
    }

    /**
     * Task detail page (optional).
     */
    public function showTask(TerraTask $task)
    {
        $task->load(['files', 'submissions.files', 'assignedBy']);

        return view('dashboard.task-detail', compact('task'));
    }
}
