<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function create()
    {
        return view('agents.create');
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

            'properties_count'=> 'required|integer|min:0',
            'top_property'     => 'nullable|string|max:255',

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

        $data['user_id'] = auth()->id();

        Agent::create($data);

        return redirect()->route('agents.create')->with('success', '✅ Agent created successfully!');
    }
}
