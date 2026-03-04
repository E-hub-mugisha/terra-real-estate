<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $profile = Agent::where('user_id', $user->id)->firstOrFail();

        return view('agents.profile.index', compact('profile'));
    }

    public function indexServices()
    {
        $agent = auth()->user()->agent;
        // Services agent already selected
        $services = $agent->services()
        ->with(['category', 'subcategory'])
        ->get();

        return view('agents.services.index', compact('agent', 'services'));
    }

    public function editServices()
    {
        $agent = auth()->user()->agent;

        // Services agent already selected
        $agentServices = $agent->services()->pluck('service_id')->toArray();

        // All active services
        $services = Service::with(['category', 'subcategory'])
            ->where('is_active', true)
            ->get();

        $categories = ServiceCategory::all();
        $subcategories = ServiceSubCategory::all();

        return view('agents.services.create', compact('agent', 'services', 'categories', 'subcategories', 'agentServices'));
    }

    public function updateServices(Request $request)
    {
        $agent = auth()->user()->agent;

        $agent->services()->sync($request->services ?? []);

        return back()->with('success', 'Services updated successfully.');
    }
}
