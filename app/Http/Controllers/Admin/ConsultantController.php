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
        $serviceCategories = ServiceCategory::with('services')->orderBy('name')->get();

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
            'service_categories.*' => 'exists:service_categories,id',
            'send_welcome'        => 'nullable',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
        ]);

        if ($photo = $request->file('photo')) {
            $destinationPath = 'image/consultant/';
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();

            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move image to public folder
            $photo->move($destinationPath, $filename);

            // Save relative path in DB
            $data['photo'] = "$filename";
        }


        DB::transaction(function () use ($request, $data, $filename) {

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
                'photo'   => $filename,
            ]);

            $consultant->serviceCategories()->sync($request->service_categories ?? []);
            $consultant->services()->sync($request->services ?? []);
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

        $consultant->recordView(request());
        $viewStats = [
            'total'       => $consultant->views_count,
            'unique'      => $consultant->unique_views_count,
            'today'       => $consultant->viewsToday(),
            'this_week'   => $consultant->viewsThisWeek(),
            'this_month'  => $consultant->viewsThisMonth(),
            'daily_chart' => $consultant->dailyViewsForPast(14),
        ];
        return view('admin.consultants.show', compact('consultant', 'viewStats'));
    }

    public function edit(Consultant $consultant)
    {
        $serviceCategories = ServiceCategory::with('services')->get();

        return view('admin.consultants.edit', compact('consultant', 'serviceCategories'));
    }

    public function update(Request $request, Consultant $consultant)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'title'                 => 'required|string|max:255',
            // ✅ Ignore this consultant's own user_id when checking uniqueness
            'email'                 => 'required|email|unique:users,email,' . $consultant->user_id,
            // ✅ Password optional on edit
            'password'              => 'nullable|min:8|confirmed',
            'phone'                 => 'required|string|max:20',
            'company'               => 'nullable|string|max:255',
            'photo'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio'                   => 'nullable|string',
            'service_categories'    => 'nullable|array',
            'service_categories.*'  => 'exists:service_categories,id',
            'services'              => 'nullable|array',
            'services.*'            => 'exists:services,id',
        ]);

        if ($photo = $request->file('photo')) {
            $destinationPath = 'image/consultant/';
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();

            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move image to public folder
            $photo->move($destinationPath, $filename);

            // Save relative path in DB
            $data['photo'] = "$filename";
        }

        DB::transaction(function () use ($request, $data, $consultant) {

            // ✅ Sync name + email to the linked user account
            if ($consultant->user) {
                $userUpdate = [
                    'name'  => $data['name'],
                    'email' => $data['email'],
                ];

                // Only update password if a new one was provided
                if (!empty($data['password'])) {
                    $userUpdate['password'] = Hash::make($data['password']);
                }

                $consultant->user->update($userUpdate);
            }

            // ✅ Update consultant record
            $consultant->update([
                'name'    => $data['name'],
                'email'   => $data['email'],
                'phone'   => $data['phone'],
                'title'   => $data['title'],
                'company' => $data['company'] ?? null,
                'bio'     => $data['bio'] ?? null,
                'photo'   => $data['photo'] ?? $consultant->photo, // keep old if no new upload
            ]);

            // ✅ Sync both pivots
            $consultant->serviceCategories()->sync($request->service_categories ?? []);
            $consultant->services()->sync($request->services ?? []);
        });

        return redirect()
            ->route('admin.consultants.index')
            ->with('success', '✅ Consultant updated successfully.');
    }

    public function destroy(Consultant $consultant)
    {
        $name = $consultant->name;
        $user = $consultant->user;

        // Delete photo from public folder
        if ($consultant->photo && file_exists(public_path($consultant->photo))) {
            unlink(public_path($consultant->photo));
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

    public function activateConsultant(Consultant $consultant)
    {
        $consultant->update(['is_active' => true]);

        return back()->with('success', "✅ {$consultant->name} has been Activated.");
    }
}
