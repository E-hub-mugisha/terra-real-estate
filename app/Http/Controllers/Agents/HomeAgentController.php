<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\District;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeAgentController extends Controller
{
    public function create()
    {
        $serviceCategories = ServiceCategory::where('is_active', true)->get();
        return view('front.agents.register', compact('serviceCategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'       => 'required|string|max:255',
            'email'           => 'required|email|unique:agents,email|unique:users,email',
            'phone'           => 'required|string|max:30',
            'bio'             => 'nullable|string',
            'linkedin'        => 'nullable|url',
            'facebook'        => 'nullable|url',
            'instagram'       => 'nullable|url',
            'twitter'         => 'nullable|url',
            'profile_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'whatsapp'        => 'nullable|string|max:30',
            'office_location' => 'nullable|string|max:255',
            'languages'       => 'nullable|string|max:255',
        ], [
            'email.unique' => 'This email is already registered.',
        ]);

        try {
            DB::beginTransaction();

            // Image upload
            if ($profile_image = $request->file('profile_image')) {
                $destinationPath = public_path('image/agents/');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $filename = time() . '_' . uniqid() . '.' . $profile_image->getClientOriginalExtension();
                $profile_image->move($destinationPath, $filename);

                $data['profile_image'] = $filename;
            }

            // Create user
            $user = new \App\Models\User();
            $user->name     = $data['full_name'];
            $user->email    = $data['email'];
            $user->password = bcrypt('password');
            $user->role     = 'agent';
            $user->is_verified = false;
            $user->save();

            // Link agent
            $data['user_id'] = $user->id;
            \App\Models\Agent::create($data);

            DB::commit();

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route(auth()->user()->redirectRoute())
                ->with('success', 'Account created and waiting approval.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function advertising()
    {
        return view('front.agents.advertising');
    }
}
