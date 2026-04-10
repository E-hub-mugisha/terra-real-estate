<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\ServiceCategory;
use App\Models\User;
use App\Notifications\StaffCredentialsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfessionalController extends Controller
{
    public function index()
    {
        $professionals = Professional::with('user')->latest()->get();

        return view('admin.users.professionals.index', compact('professionals'));
    }

    public function create()
    {
        $serviceCategories = ServiceCategory::with('services')->where('slug', 'professionals-marketplace')->orderBy('name')->get();
        return view('admin.users.professionals.create', compact('serviceCategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'            => 'required|string|max:255',
            'email'                => 'required|email|unique:professionals,email',
            'phone'                => 'required|string|max:30',
            'profession'           => 'nullable|string|max:100',
            'license_number'       => 'nullable|string|max:100',
            'years_experience'     => 'nullable|integer|min:0',
            'rating'               => 'nullable|numeric|min:0|max:5',
            'bio'                  => 'nullable|string',
            'services'             => 'nullable|array',
            'services.*'           => 'exists:services,id',
            'service_categories'   => 'nullable|array',
            'service_categories.*' => 'exists:service_categories,id',
            'portfolio_url'        => 'nullable|url',
            'website'              => 'nullable|url',
            'credentials_doc'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'linkedin'             => 'nullable|url',
            'whatsapp'             => 'nullable|string|max:30',
            'office_location'      => 'nullable|string|max:255',
            'languages'            => 'nullable|string|max:255',
            'profile_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_verified'          => 'nullable',
            'send_credentials'     => 'nullable',
            'custom_password'      => 'nullable|string|min:8',
        ]);

        if ($file = $request->file('profile_image')) {
            $dest     = public_path('image/professionals/');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            if (!file_exists($dest)) mkdir($dest, 0755, true);
            $file->move($dest, $filename);
            $data['profile_image'] = 'image/professionals/' . $filename;
        }

        if ($file = $request->file('credentials_doc')) {
            $dest     = public_path('image/professionals/docs/');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            if (!file_exists($dest)) mkdir($dest, 0755, true);
            $file->move($dest, $filename);
            $data['credentials_doc'] = 'image/professionals/docs/' . $filename;
        }

        $plainPassword = $request->boolean('auto_password') || !$request->filled('custom_password')
            ? Str::password(12)
            : $request->custom_password;

        $user = User::create([
            'name'              => $data['full_name'],
            'email'             => $data['email'],
            'password'          => Hash::make($plainPassword),
            'role'              => 'professional',
            'email_verified_at' => $request->boolean('is_verified') ? now() : null,
        ]);

        $professional = Professional::create([
            'user_id'          => $user->id,
            'full_name'        => $data['full_name'],
            'email'            => $data['email'],
            'phone'            => $data['phone'],
            'whatsapp'         => $data['whatsapp']         ?? null,
            'office_location'  => $data['office_location']  ?? null,
            'languages'        => $data['languages']        ?? null,
            'profession'       => $data['profession']       ?? null,
            'license_number'   => $data['license_number']   ?? null,
            'years_experience' => $data['years_experience'] ?? null,
            'rating'           => $data['rating']           ?? null,
            'bio'              => $data['bio']               ?? null,
            'website'          => $data['website']           ?? null,
            'portfolio_url'    => $data['portfolio_url']     ?? null,
            'linkedin'         => $data['linkedin']          ?? null,
            'profile_image'    => $data['profile_image']     ?? null,
            'credentials_doc'  => $data['credentials_doc']   ?? null,
            'is_verified'      => false,
        ]);

        $professional->serviceCategories()->sync($request->service_categories ?? []);
        $professional->professionalServices()->sync($request->services ?? []);

        if ($request->boolean('send_credentials')) {
            try {
                $user->notify(new StaffCredentialsNotification($plainPassword));
            } catch (\Exception $e) {
                return redirect()->route('admin.professionals.index')
                    ->with('warning', "Professional created but email failed. Password: {$plainPassword}");
            }
        }

        return redirect()
            ->route('admin.professionals.index')
            ->with('success', "{$user->name} added. Credentials sent to {$user->email}.");
    }

    public function show(Professional $professional)
    {
        $professional->load('user');

        $professional->recordView(request());

        $viewStats = [
            'total'       => $professional->views_count,
            'unique'      => $professional->unique_views_count,
            'today'       => $professional->viewsToday(),
            'this_week'   => $professional->viewsThisWeek(),
            'this_month'  => $professional->viewsThisMonth(),
            'daily_chart' => $professional->dailyViewsForPast(14),
        ];
        return view('admin.users.professionals.profile', compact('professional', 'viewStats'));
    }

    public function edit(Professional $professional)
    {
        $professional->load([
            'user',
            'serviceCategories',
            'professionalServices'
        ]);

        $serviceCategories = ServiceCategory::with('services')
            ->where('slug', 'professionals-marketplace')
            ->orderBy('name')
            ->get();

        return view('admin.users.professionals.edit', compact('professional', 'serviceCategories'));
    }

    public function update(Request $request, Professional $professional)
    {
        $data = $request->validate([
            'full_name'            => 'required|string|max:255',
            'email'                => 'required|email|unique:professionals,email,' . $professional->id,
            'phone'                => 'required|string|max:30',
            'profession'           => 'nullable|string|max:100',
            'license_number'       => 'nullable|string|max:100',
            'years_experience'     => 'nullable|integer|min:0',
            'rating'               => 'nullable|numeric|min:0|max:5',
            'bio'                  => 'nullable|string',
            'service_categories'   => 'nullable|array',
            'service_categories.*' => 'exists:service_categories,id',
            'services'             => 'nullable|array',
            'services.*'           => 'exists:services,id',
            'portfolio_url'        => 'nullable|url',
            'website'              => 'nullable|url',
            'credentials_doc'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'linkedin'             => 'nullable|url',
            'whatsapp'             => 'nullable|string|max:30',
            'office_location'      => 'nullable|string|max:255',
            'languages'            => 'nullable|string|max:255',
            'profile_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_verified'          => 'nullable',
        ]);

        if ($file = $request->file('profile_image')) {
            // Delete old file
            if ($professional->profile_image) {
                $old = public_path($professional->profile_image);
                if (file_exists($old)) unlink($old);
            }
            $dest     = public_path('image/professionals/');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            if (!file_exists($dest)) mkdir($dest, 0755, true);
            $file->move($dest, $filename);
            $data['profile_image'] = 'image/professionals/' . $filename;
        } else {
            unset($data['profile_image']); // don't overwrite existing with null
        }

        if ($file = $request->file('credentials_doc')) {
            if ($professional->credentials_doc) {
                $old = public_path($professional->credentials_doc);
                if (file_exists($old)) unlink($old);
            }
            $dest     = public_path('image/professionals/docs/');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            if (!file_exists($dest)) mkdir($dest, 0755, true);
            $file->move($dest, $filename);
            $data['credentials_doc'] = 'image/professionals/docs/' . $filename;
        } else {
            unset($data['credentials_doc']);
        }

        // Sync relationships then remove from data before update()
        $professional->serviceCategories()->sync($request->service_categories ?? []);
        $professional->professionalServices()->sync($request->services ?? []);
        unset($data['service_categories'], $data['services']);

        $data['is_verified'] = $request->boolean('is_verified');

        if ($professional->user) {
            $professional->user->update([
                'name'  => $data['full_name'],
                'email' => $data['email'],
            ]);
        }

        $professional->update($data);

        return back()->with('success', '✅ Professional updated successfully.');
    }

    public function destroy(Professional $professional)
    {
        $name = $professional->full_name;
        $user = $professional->user;

        if ($professional->profile_image) {
            Storage::disk('public')->delete($professional->profile_image);
        }
        if ($professional->credentials_doc) {
            Storage::disk('public')->delete($professional->credentials_doc);
        }

        $professional->delete();
        $user?->delete();

        return redirect()
            ->route('admin.professionals.index')
            ->with('success', "{$name} has been removed.");
    }

    public function resetPassword(Professional $professional)
    {
        $password = Str::password(12);

        $professional->user->update([
            'password' => Hash::make($password),
        ]);

        try {
            $professional->user->notify(new StaffCredentialsNotification($password));
        } catch (\Exception $e) {
            return back()->with('error', 'Password reset but email could not be sent.');
        }

        return back()->with('success', "Password reset. Credentials sent to {$professional->email}.");
    }

    public function toggleVerify(Professional $professional)
    {
        $professional->update([
            'is_verified' => !$professional->is_verified,
        ]);

        $status = $professional->is_verified ? 'verified' : 'unverified';

        return back()->with('success', "{$professional->full_name} has been {$status}.");
    }
}
