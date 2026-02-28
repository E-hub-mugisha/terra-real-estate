<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Http\Request;
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
            'full_name'        => 'required|string|max:255',
            'email'            => 'required|email|unique:agents,email',
            'phone'            => 'required|string|max:30',
            'years_experience' => 'required|integer|min:0',
            'bio'              => 'nullable|string',

            'linkedin'         => 'nullable|url',
            'facebook'         => 'nullable|url',
            'instagram'        => 'nullable|url',
            'twitter'          => 'nullable|url',

            'profile_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'whatsapp'         => 'nullable|string|max:30',
            'office_location'  => 'nullable|string|max:255',
            'languages'        => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('agents', 'public');
        }

        // create user with default password and name from full_name field and email from email field
        $user = new \App\Models\User();
        $user->name = $data['full_name'];
        $user->email = $data['email'];
        $user->password = bcrypt('password'); // default password, should be changed by the agent
        $user->role = 'agent';
        $user->is_verified = true; // mark as verified by default
        $user->save();

        // associate the user with the agent record
        $data['user_id'] = $user->id;


        Agent::create($data);

        return redirect()->route('home')
            ->with('success', 'Your consultant account is pending approval.');
    }

    public function advertising()
    {
        return view('front.agents.advertising');
    }
}
