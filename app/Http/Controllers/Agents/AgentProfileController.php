<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent;
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
}
