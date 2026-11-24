<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PartnerProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * Independent partners apply here. The account is created straight away with a
 * "pending" partner profile; admin activates it from Admin → Partners.
 */
class PartnerApplicationController extends Controller
{
    public function create()
    {
        return view('front.partners.apply');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:150',
            'email'        => 'required|email|max:150|unique:users,email',
            'phone'        => 'required|string|max:30',
            'whatsapp'     => 'nullable|string|max:30',
            'company_name' => 'nullable|string|max:150',
            'areas'        => 'required|string|max:255',
            'bio'          => 'nullable|string|max:1000',
            'password'     => ['required', 'confirmed', Password::defaults()],
            'terms'        => 'accepted',
        ], ['terms.accepted' => 'Please accept the partner terms to continue.']);

        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'partner',
                'phone' => $data['phone'],
                'whatsapp' => $data['whatsapp'] ?? null,
            ]);
            PartnerProfile::create([
                'user_id' => $user->id,
                'company_name' => $data['company_name'] ?? null,
                'phone' => $data['phone'],
                'whatsapp' => $data['whatsapp'] ?? null,
                'areas' => $data['areas'],
                'bio' => $data['bio'] ?? null,
                'status' => 'pending',
            ]);

            return $user;
        });

        event(new Registered($user));
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('partner.dashboard')
            ->with('success', 'Welcome to Terra! Your partner account is under review — you can already add referrals and properties.');
    }
}
