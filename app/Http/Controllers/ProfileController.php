<?php

namespace App\Http\Controllers;

use App\Models\ArchitecturalDesign;
use App\Models\House;
use App\Models\Land;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // Show
    // ─────────────────────────────────────────────────────────────────────────

    public function show()
    {
        $user = Auth::user();

        $stats = [
            'houses'         => House::managedBy($user)->count(),
            'lands'          => Land::managedBy($user)->count(),
            'designs'        => ArchitecturalDesign::managedBy($user)->count(),
        ];

        $recentHouses = House::managedBy($user)
            ->latest()->limit(5)->get();

        return view('profile.show', compact('stats', 'recentHouses'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Update profile info (name, email, phone, location)
    // ─────────────────────────────────────────────────────────────────────────

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:30',
            'whatsapp' => 'nullable|string|max:30',
            'province' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'bio'      => 'nullable|string|max:1000',
            'company_name' => 'nullable|string|max:150',
            'areas'    => 'nullable|string|max:255',
        ]);

        // Partner details live on the partner profile, not the user row.
        $partner = collect($validated)->only(['company_name', 'areas'])->all();
        unset($validated['company_name'], $validated['areas']);
        if ($user->isPartner()) {
            $user->partnerProfile()->updateOrCreate(['user_id' => $user->id], $partner + [
                'phone' => $validated['phone'] ?? $user->phone,
                'whatsapp' => $validated['whatsapp'] ?? null,
            ]);
        }

        // If email changed, re-trigger verification
        if ($validated['email'] !== $user->email) {
            $validated['email_verified_at'] = null;
        }

        $user->update($validated);

        // If email changed and you use MustVerifyEmail, send verification
        if (is_null($user->fresh()->email_verified_at)) {
            $user->sendEmailVerificationNotification();
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Update password
    // ─────────────────────────────────────────────────────────────────────────

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Delete account
    // ─────────────────────────────────────────────────────────────────────────

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}