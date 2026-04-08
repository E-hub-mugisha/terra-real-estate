<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
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
            'houses'         => House::where('user_id', $user->id)->count(),
            'lands'          => Land::where('user_id', $user->id)->count(),
            'designs'        => ArchitecturalDesign::where('user_id', $user->id)->count(),
            'advertisements' => Advertisement::where('user_id', $user->id)->count(),
        ];

        $recentHouses = House::where('user_id', $user->id)
            ->latest()->limit(5)->get();

        $recentAds = Advertisement::where('user_id', $user->id)
            ->latest()->limit(5)->get();

        return view('profile.show', compact('stats', 'recentHouses', 'recentAds'));
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
            'phone'    => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
        ]);

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

        // Delete advertisement images from disk
        Advertisement::where('user_id', $user->id)->each(function ($ad) {
            foreach ($ad->images ?? [] as $path) {
                $full = public_path($path);
                if (file_exists($full)) @unlink($full);
            }
        });

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}