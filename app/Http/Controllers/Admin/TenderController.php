<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TenderController extends Controller
{
    public function index()
    {
        $tenders = Tender::with('user')->latest()->get();

        $stats = [
            'total'  => $tenders->count(),
            'open'   => $tenders->where('is_open', true)->count(),
            'closed' => $tenders->where('is_open', false)->count(),
            'expiring_soon' => $tenders->where('is_open', true)
                ->filter(fn($t) => $t->submission_deadline >= now() && $t->submission_deadline <= now()->addDays(7))
                ->count(),
        ];

        return view('admin.tenders.index', compact('tenders', 'stats'));
    }

    public function create()
    {
        return view('admin.tenders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'required|string',
            'reference_no'        => 'nullable|string|max:100|unique:tenders,reference_no',
            'budget'              => 'nullable|numeric|min:0',
            'submission_deadline' => 'required|date|after:today',
            'location'            => 'nullable|string|max:255',
            'document_path'       => 'nullable|file|mimes:pdf|max:10240',
            'is_open'             => 'nullable',
        ]);

        if ($request->hasFile('document_path')) {
            $data['document_path'] = $request->file('document_path')
                ->store('tenders/documents', 'public');
        }

        // Auto-generate reference if not provided
        if (empty($data['reference_no'])) {
            $data['reference_no'] = 'TDR-' . strtoupper(Str::random(8)) . '-' . now()->year;
        }

        $data['user_id']  = Auth::id();
        $data['is_open']  = $request->boolean('is_open', true);

        Tender::create($data);

        return redirect()
            ->route('admin.tenders.index')
            ->with('success', '✅ Tender published successfully.');
    }

    public function show(Tender $tender)
    {
        $tender->load('user');

        $tender->recordView(request());

        $viewStats = [
            'total'       => $tender->views,
            'today'       => $tender->viewsToday(),
            'this_week'   => $tender->viewsThisWeek(),
            'this_month'  => $tender->viewsThisMonth(),
            'daily_chart' => $tender->dailyViewsForPast(14),
        ];

        return view('admin.tenders.show', compact('tender', 'viewStats'));
    }

    public function edit(Tender $tender)
    {
        return view('admin.tenders.edit', compact('tender'));
    }

    public function update(Request $request, Tender $tender)
    {
        $data = $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'required|string',
            'reference_no'        => 'nullable|string|max:100|unique:tenders,reference_no,' . $tender->id,
            'budget'              => 'nullable|numeric|min:0',
            'submission_deadline' => 'required|date',
            'location'            => 'nullable|string|max:255',
            'document_path'       => 'nullable|file|mimes:pdf|max:10240',
            'is_open'             => 'nullable',
        ]);

        if ($request->hasFile('document_path')) {
            if ($tender->document_path) {
                Storage::disk('public')->delete($tender->document_path);
            }
            $data['document_path'] = $request->file('document_path')
                ->store('tenders/documents', 'public');
        }

        $data['is_open'] = $request->boolean('is_open');

        $tender->update($data);

        return back()->with('success', '✅ Tender updated successfully.');
    }

    public function destroy(Tender $tender)
    {
        $title = $tender->title;

        if ($tender->document_path) {
            Storage::disk('public')->delete($tender->document_path);
        }

        $tender->delete();

        return redirect()
            ->route('admin.tenders.index')
            ->with('success', "Tender \"{$title}\" has been deleted.");
    }

    public function toggleStatus(Tender $tender)
    {
        $tender->update(['is_open' => !$tender->is_open]);

        $label = $tender->is_open ? 'reopened' : 'closed';

        return back()->with('success', "Tender \"{$tender->title}\" has been {$label}.");
    }
}
