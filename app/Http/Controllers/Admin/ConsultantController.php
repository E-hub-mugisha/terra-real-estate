<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConsultantController extends Controller
{
    public function index()
    {
        $consultants = Consultant::latest()->paginate(10);
        return view('admin.consultants.index', compact('consultants'));
    }

    public function create()
    {
        $serviceCategories = ServiceCategory::where('is_active', true)->get();
        return view('admin.consultants.create', compact('serviceCategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:2048',
            'bio'   => 'nullable|string',
            'is_active' => 'boolean',
            'service_categories' => 'array'
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('consultants', 'public');
        }

        $consultant = Consultant::create($data);
        $consultant->serviceCategories()
            ->sync($request->service_categories ?? []);
        return redirect()->route('admin.consultants.index')
            ->with('success', 'Consultant created successfully');
    }

    public function edit(Consultant $consultant)
    {
        $serviceCategories = ServiceCategory::where('is_active', true)->get();
        return view('admin.consultants.edit', compact('consultant', 'serviceCategories'));
    }

    public function update(Request $request, Consultant $consultant)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:2048',
            'bio'   => 'nullable|string',
            'is_active' => 'boolean',
            'service_categories' => 'array'
        ]);

        if ($request->hasFile('photo')) {
            if ($consultant->photo) {
                Storage::disk('public')->delete($consultant->photo);
            }
            $data['photo'] = $request->file('photo')->store('consultants', 'public');
        }

        $consultant->update($data);

        $consultant->serviceCategories()
            ->sync($request->service_categories ?? []);

        return redirect()->route('admin.consultants.index')
            ->with('success', 'Consultant updated successfully');
    }

    public function destroy(Consultant $consultant)
    {
        if ($consultant->photo) {
            Storage::disk('public')->delete($consultant->photo);
        }

        $consultant->delete();

        return back()->with('success', 'Consultant deleted');
    }
}
