<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\ServiceCategory;
use App\Models\User;
use App\Notifications\StaffCredentialsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConsultantController extends Controller
{
    public function index()
    {
        $consultants      = Consultant::with(['user', 'serviceCategories'])->latest()->get();
        $serviceCategories = ServiceCategory::orderBy('name')->get();

        return view('admin.consultants.index', compact('consultants', 'serviceCategories'));
    }

    public function create()
    {
        $serviceCategories = ServiceCategory::orderBy('name')->get();

        return view('admin.consultants.create', compact('serviceCategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:255',
            'title'               => 'required|string|max:255',
            'email'               => 'required|email|unique:users,email',
            'password'            => 'required|min:8|confirmed',
            'phone'               => 'required|string|max:20',
            'company'             => 'nullable|string|max:255',
            'photo'               => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio'                 => 'nullable|string',
            'service_categories'  => 'nullable|array',
            'service_categories.*'=> 'exists:service_categories,id',
            'send_welcome'        => 'nullable',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('consultants', 'public');
        }

        DB::transaction(function () use ($request, $data, $photoPath) {

            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
                'role'     => 'consultant',
            ]);

            $consultant = Consultant::create([
                'user_id' => $user->id,
                'name'    => $data['name'],
                'email'   => $data['email'],
                'phone'   => $data['phone'],
                'title'   => $data['title'],
                'company' => $data['company'] ?? null,
                'bio'     => $data['bio'] ?? null,
                'photo'   => $photoPath,
            ]);

            $consultant->serviceCategories()->sync($request->service_categories ?? []);

            // Send welcome email with credentials
            if ($request->boolean('send_welcome')) {
                try {
                    $user->notify(new StaffCredentialsNotification($data['password']));
                } catch (\Exception $e) {
                    // Non-blocking — consultant still created
                }
            }
        });

        return redirect()
            ->route('admin.consultants.index')
            ->with('success', '✅ Consultant created successfully.');
    }

    public function show(Consultant $consultant)
    {
        $consultant->load(['user', 'serviceCategories']);

        return view('admin.consultants.show', compact('consultant'));
    }

    public function edit(Consultant $consultant)
    {
        $consultant->load(['user', 'serviceCategories']);
        $serviceCategories = ServiceCategory::orderBy('name')->get();

        return view('admin.consultants.edit', compact('consultant', 'serviceCategories'));
    }

    public function update(Request $request, Consultant $consultant)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:255',
            'title'               => 'required|string|max:255',
            'email'               => 'required|email|unique:users,email,' . $consultant->user_id,
            'phone'               => 'required|string|max:20',
            'company'             => 'nullable|string|max:255',
            'photo'               => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio'                 => 'nullable|string',
            'service_categories'  => 'nullable|array',
            'service_categories.*'=> 'exists:service_categories,id',
        ]);

        if ($request->hasFile('photo')) {
            if ($consultant->photo) {
                Storage::disk('public')->delete($consultant->photo);
            }
            $data['photo'] = $request->file('photo')->store('consultants', 'public');
        }

        // Sync name + email to user account
        if ($consultant->user) {
            $consultant->user->update([
                'name'  => $data['name'],
                'email' => $data['email'],
            ]);
        }

        $consultant->update([
            'name'    => $data['name'],
            'email'   => $data['email'],
            'phone'   => $data['phone'],
            'title'   => $data['title'],
            'company' => $data['company'] ?? null,
            'bio'     => $data['bio'] ?? null,
            'photo'   => $data['photo'] ?? $consultant->photo,
        ]);

        $consultant->serviceCategories()->sync($request->service_categories ?? []);

        return back()->with('success', '✅ Consultant updated successfully.');
    }

    public function destroy(Consultant $consultant)
    {
        $name = $consultant->name;
        $user = $consultant->user;

        if ($consultant->photo) {
            Storage::disk('public')->delete($consultant->photo);
        }

        $consultant->serviceCategories()->detach();
        $consultant->delete();
        $user?->delete();

        return redirect()
            ->route('admin.consultants.index')
            ->with('success', "{$name} has been removed.");
    }

    public function resetPassword(Consultant $consultant)
    {
        $password = Str::password(12);

        $consultant->user->update([
            'password' => Hash::make($password),
        ]);

        try {
            $consultant->user->notify(new StaffCredentialsNotification($password));
        } catch (\Exception $e) {
            return back()->with('error', 'Password reset but email could not be sent.');
        }

        return back()->with('success', "Password reset. New credentials sent to {$consultant->email}.");
    }
}