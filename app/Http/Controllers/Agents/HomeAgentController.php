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
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone'    => 'required|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'bio'      => 'nullable|string',
            'service_categories' => 'array',
            'title' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('consultants', 'public');
        }

        DB::transaction(function () use ($request) {

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'consultant',
            ]);

            $consultant = Agent::create([
                'user_id' => $user->id,
                'phone'   => $request->phone,
                'bio'     => $request->bio,
                'name'     => $request->name,
                'email'    => $request->email,
                'title'   => $request->title,
                'company' => $request->company,
            ]);

            $consultant->serviceCategories()
                ->sync($request->service_categories ?? []);
        });

        return redirect()->route('home')
            ->with('success', 'Your consultant account is pending approval.');
    }
}
