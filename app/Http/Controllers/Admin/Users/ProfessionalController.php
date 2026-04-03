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
            'full_name'        => 'required|string|max:255',
            'email'            => 'required|email|unique:professionals,email',
            'phone'            => 'required|string|max:30',
            'profession'       => 'nullable|string|max:100',
            'license_number'   => 'nullable|string|max:100',
            'years_experience' => 'nullable|integer|min:0',
            'rating'           => 'nullable|numeric|min:0|max:5',
            'bio'              => 'nullable|string',
            'services'             => 'nullable|array',
            'services.*'           => 'exists:services,id',
            'service_categories'   => 'nullable|array',
            'service_categories.*' => 'exists:service_categories,id',

            'portfolio_url'    => 'nullable|url',
            'website'          => 'nullable|url',
            'credentials_doc'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'linkedin'         => 'nullable|url',
            'whatsapp'         => 'nullable|string|max:30',
            'office_location'  => 'nullable|string|max:255',
            'languages'        => 'nullable|string|max:255',
            'profile_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_verified'      => 'nullable',
            'send_credentials' => 'nullable',
            'custom_password'  => 'nullable|string|min:8',
        ]);

        // Handle file uploads
        $data['profile_image'] = null;
        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            $image    = $request->file('profile_image');
            $dir      = public_path('image/professionals');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $image->move($dir, $filename);
            $data['profile_image'] = 'image/professionals/' . $filename;
        }

        // ── Credentials document upload ────────────────────────────────
        $data['credentials_doc'] = null;
        if ($request->hasFile('credentials_doc') && $request->file('credentials_doc')->isValid()) {
            $doc      = $request->file('credentials_doc');
            $dir      = public_path('image/professionals/docs');
            $filename = time() . '_' . uniqid() . '.' . $doc->getClientOriginalExtension();
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $doc->move($dir, $filename);
            $data['credentials_doc'] = 'image/professionals/docs/' . $filename;
        }

        // Generate or use custom password
        $plainPassword = $request->boolean('auto_password') || !$request->filled('custom_password')
            ? Str::password(12)
            : $request->custom_password;

        // Create the user account
        $user = User::create([
            'name'              => $data['full_name'],
            'email'             => $data['email'],
            'password'          => Hash::make($plainPassword),
            'role'              => 'professional',
            'email_verified_at' => $request->boolean('is_verified') ? now() : null,
        ]);

        $data['user_id']     = $user->id;
        $data['is_verified'] = $request->boolean('is_verified');

        // Remove non-column keys
        unset($data['send_credentials'], $data['custom_password'], $data['auto_password']);

        $professional = Professional::create([
            'user_id'         => $user->id,
            'full_name'       => $data['full_name'],
            'email'           => $data['email'],
            'phone'           => $data['phone'],
            'whatsapp'        => $data['whatsapp']        ?? null,
            'office_location' => $data['office_location'] ?? null,
            'languages'       => $data['languages']       ?? null,
            'profession'      => $data['profession'],
            'license_number'  => $data['license_number']  ?? null,
            'bio'             => $data['bio'],
            'website'         => $data['website']         ?? null,
            'portfolio_url'   => $data['portfolio_url']   ?? null,
            'linkedin'        => $data['linkedin']        ?? null,
            'profile_image'   => $data['profile_image'],
            'credentials_doc' => $data['credentials_doc'],
            'is_verified'     => false,
        ]);

        $professional->serviceCategories()
            ->sync($request->service_categories ?? []);
        $professional->professionalServices()->sync($request->services ?? []);

        // Send credentials if toggled
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

        return view('admin.users.professionals.profile', compact('professional'));
    }

    public function edit(Professional $professional)
    {
        $professional->load([
            'user',
            'serviceCategories',
            'services'
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
            'full_name'        => 'required|string|max:255',
            'email'            => 'required|email|unique:professionals,email,' . $professional->id,
            'phone'            => 'required|string|max:30',
            'profession'       => 'nullable|string|max:100',
            'license_number'   => 'nullable|string|max:100',
            'years_experience' => 'nullable|integer|min:0',
            'rating'           => 'nullable|numeric|min:0|max:5',
            'bio'              => 'nullable|string',
            'services'         => 'nullable|string|max:500',
            'portfolio_url'    => 'nullable|url',
            'website'          => 'nullable|url',
            'credentials_doc'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'linkedin'         => 'nullable|url',
            'whatsapp'         => 'nullable|string|max:30',
            'office_location'  => 'nullable|string|max:255',
            'languages'        => 'nullable|string|max:255',
            'profile_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_verified'      => 'nullable',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($professional->profile_image) {
                Storage::disk('public')->delete($professional->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')
                ->store('professionals/photos', 'public');
        }

        if ($request->hasFile('credentials_doc')) {
            if ($professional->credentials_doc) {
                Storage::disk('public')->delete($professional->credentials_doc);
            }
            $data['credentials_doc'] = $request->file('credentials_doc')
                ->store('professionals/credentials', 'public');
        }

        $data['is_verified'] = $request->boolean('is_verified');

        // Sync name + email to linked user
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
