<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::latest()->paginate(10);
        return view('admin.users.agents.index', compact('agents'));
    }
    public function create()
    {
        return view('admin.users.agents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'        => 'required|string|max:255',
            'email'            => 'required|email|unique:agents,email',
            'phone'            => 'required|string|max:30',
            'role'             => 'required|string|max:100',
            'years_experience' => 'required|integer|min:0',
            'rating'           => 'required|numeric|min:0|max:5',
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

        return redirect()->route('admin.agents.create')->with('success', '✅ Agent created successfully!');
    }

    public function show(Agent $agent)
    {
        return view('admin.users.agents.profile', compact('agent'));
    }
}
