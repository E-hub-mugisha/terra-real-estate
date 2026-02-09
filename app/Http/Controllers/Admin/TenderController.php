<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    public function index()
    {
        $tenders = Tender::latest()->paginate(10);
        return view('admin.tenders.index', compact('tenders'));
    }

    public function create()
    {
        return view('admin.tenders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'reference_no' => 'nullable|string|max:100|unique:tenders,reference_no',
            'budget' => 'nullable|numeric|min:0',
            'submission_deadline' => 'required|date|after:today',
            'location' => 'nullable|string|max:100',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('document')) {
            $data['document_path'] = $request->file('document')->store('tenders', 'public');
        }

        $data['user_id'] = auth()->id();

        Tender::create($data);

        return redirect()->route('admin.tenders.index')->with('success', '✅ Tender posted successfully.');
    }
}
