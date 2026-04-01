<?php

namespace App\Http\Controllers\Professionals;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\ServiceCategory;
use App\Models\User;
use App\Notifications\StaffCredentialsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HomeProfessionalController extends Controller
{
    public function index()
    {
        $professionals = Professional::where('is_verified', true)->get();
        return view('front.professionals.index', compact('professionals'));
    }

    public function show(Professional $professional)
    {
        abort_if(!$professional->is_verified, 404);
        $reviews = $professional->reviews()->latest()->get();
        $averageRating = round($professional->reviews()->avg('rating'), 1);
        return view('front.professionals.show', compact('professional', 'reviews', 'averageRating'));
    }

    public function professionalBecame()
    {
        return view('front.professionals.became');
    }

    public function create()
    {
        $serviceCategories = ServiceCategory::with('services')->where('slug', 'professionals-marketplace')->orderBy('name')->get();
        return view('front.professionals.register', compact('serviceCategories'));
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
            'services'              => 'nullable|array',
            'services.*'            => 'exists:services,id',
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
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')
                ->store('professionals/photos', 'public');
        }

        if ($request->hasFile('credentials_doc')) {
            $data['credentials_doc'] = $request->file('credentials_doc')
                ->store('professionals/credentials', 'public');
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
        $data['is_verified'] = false;

        // Remove non-column keys
        unset($data['send_credentials'], $data['custom_password'], $data['auto_password']);

        $professional = Professional::create($data);

        // Send credentials if toggled
        if ($request->boolean('send_credentials')) {
            try {
                $user->notify(new StaffCredentialsNotification($plainPassword));
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('warning', "Professional created but email failed. Password: {$plainPassword}");
            }
        }

        return redirect()->route(auth()->user()->redirectRoute())
            ->with('success', 'Your Consultant account created and waiting for Admin pending approval.');
    }
}
