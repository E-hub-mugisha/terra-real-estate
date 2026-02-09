<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    public function index()
    {
        $professionals = Professional::latest()->paginate(10);
        return view('admin.users.professionals.index', compact('professionals'));
    }
    public function create()
    {
        return view('admin.users.professionals.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'        => 'required|string|max:255',
            'email'            => 'required|email|unique:professionals,email',
            'phone'            => 'required|string|max:30',
            'profession'       => 'required|in:architect,engineer,valuer,surveyor',
            'license_number'   => 'nullable|string|max:100',
            'years_experience' => 'required|integer|min:0',
            'rating'           => 'nullable|numeric|min:0|max:5',
            'bio'              => 'nullable|string',

            'services'         => 'nullable|string|max:255',
            'portfolio_url'    => 'nullable|url',
            'credentials_doc'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',

            'linkedin'         => 'nullable|url',
            'website'          => 'nullable|url',
            'whatsapp'         => 'nullable|string|max:30',
            'office_location'  => 'nullable|string|max:255',
            'languages'        => 'nullable|string|max:255',

            'profile_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('professionals', 'public');
        }

        if ($request->hasFile('credentials_doc')) {
            $data['credentials_doc'] = $request->file('credentials_doc')->store('professional_credentials', 'public');
        }

        // create user with default password and name from full_name field and email from email field
        $user = new \App\Models\User();
        $user->name = $data['full_name'];
        $user->email = $data['email'];
        $user->password = bcrypt('password'); // default password, should be changed by the agent
        $user->role = 'professional';
        $user->is_verified = true; // mark as verified by default
        $user->save();

        // associate the user with the professional record
        $data['user_id'] = $user->id;

        Professional::create($data);

        return redirect()->route('admin.professionals.index')->with('success', '✅ Professional profile created and sent for verification.');
    }

    public function show(Professional $professional)
    {
        return view('admin.users.professionals.profile', compact('professional'));
    }
}
