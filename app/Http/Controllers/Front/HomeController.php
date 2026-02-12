<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\House;
use App\Models\Land;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('front.index');
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function agents()
    {
        $agents = Agent::where('is_verified', true)->get();

        return view('front.agents', compact('agents'));
    }

    public function agentDetails(Agent $agent)
    {
        return view('front.agent-details', compact('agent'));
    }

    public function homes()
    {
        $homes = House::where('type', 'house')->where('is_approved', true)->where('status', 'available')->get();
        return view('front.buy.homes', compact('homes'));
    }

    public function homeDetails(House $home)
    {
        return view('front.buy.home-details', compact('home'));
    }

    public function lands()
    {
        $lands = Land::where('type', 'land')->where('is_approved', true)->where('status', 'available')->get();
        return view('front.buy.lands', compact('lands'));
    }

    public function landDetails(Land $land)
    {
        return view('front.buy.land-details', compact('land'));
    }
}
