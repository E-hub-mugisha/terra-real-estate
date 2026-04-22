<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.users.index', compact('users'));
    }
    public function create()
    {
        return view('admin.users.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'            => 'required|email|unique:agents,email',
            'is_verified'      => 'nullable',
        ]);

        // Generate or use custom password
        $plainPassword = $request->boolean('auto_password') || !$request->filled('custom_password')
            ? \Illuminate\Support\Str::password(12)
            : $request->custom_password;

        // Create the user account
        $user = \App\Models\User::create([
            'name'              => $data['full_name'],
            'email'             => $data['email'],
            'password'          => \Illuminate\Support\Facades\Hash::make($plainPassword),
            'role'              => 'user',
            'email_verified_at' => $request->boolean('is_verified') ? now() : null,
        ]);


        // Send credentials if toggled on
        if ($request->boolean('send_credentials')) {
            try {
                $user->notify(new \App\Notifications\StaffCredentialsNotification($plainPassword));
            } catch (\Exception $e) {
                return redirect()->route('admin.users.index')
                    ->with('warning', "User created but credentials email failed. Password: {$plainPassword}");
            }
        }

        return redirect()->route('admin.users.index')
            ->with('success', "✅ User created successfully. Credentials sent to {$user->email}.");
    }
    public function show(User $user)
    {
        $houses = collect();
        $lands = collect();

        if ($user->user) {
            $houses = $user->user->houses()
                ->where('is_approved', true)
                ->where('status', 'available')
                ->latest()
                ->get();

            $lands = $user->user->lands()
                ->where('is_approved', true)
                ->where('status', 'available')
                ->latest()
                ->get();
        }

        $listings = $houses->merge($lands);
        return view('admin.users.users.profile', compact('user', 'houses', 'lands', 'listings'));
    }

    public function approve(Request $request, User $user)
    {
        $user->update([
            'is_verified' => true,
        ]);

        return back()->with('success', 'user approved successfully.');
    }

    public function verifyAgent(User $user)
    {
        $user->update(['is_verified' => true]);

        return back()->with('success', "user has been verified.");
    }

    public function reject(Request $request, User $user)
    {
        $user->update([
            'is_verified' => false,
        ]);

        return back()->with('success', 'user rejected successfully.');
    }
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $user->id,

        ]);

        $user->update($data);

        return back()->with('success', 'user updated successfully.');
    }

    public function resetPassword(User $user)
    {
        $password = \Illuminate\Support\Str::password(12);
        $user->update(['password' => \Illuminate\Support\Facades\Hash::make($password)]);

        try {
            $user->notify(new \App\Notifications\StaffCredentialsNotification($password));
        } catch (\Exception $e) {
            return back()->with('error', 'Password reset but email failed.');
        }

        return back()->with('success', "Password reset. New credentials sent to {$user->email}.");
    }
    public function edit(User $user)
    {

        return view('admin.users.users.edit', compact('user'));
    }

    public function destroy(User $user)
    {
        // Prevent admin from deleting their own account
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
