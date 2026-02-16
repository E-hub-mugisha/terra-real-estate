<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\House;
use App\Models\Land;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $houses = House::where('is_approved', true)
            ->where('status', 'available')
            ->get();

        $lands = Land::where('is_approved', true)
            ->where('status', 'available')
            ->get();

        $forRentHouses = House::where('condition', 'for_rent')
            ->where('is_approved', true)
            ->where('status', 'available')
            ->get();

        $forSellHouses = House::where('condition', 'for_sale')
            ->where('is_approved', true)
            ->where('status', 'available')
            ->get();

        // GROUP HOUSES
        $groupHouses = House::where('is_approved', true)
            ->where('status', 'available')
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->pluck('total', 'city');

        // GROUP LANDS
        $groupLands = Land::where('is_approved', true)
            ->where('status', 'available')
            ->select('district', DB::raw('count(*) as total'))
            ->groupBy('district')
            ->pluck('total', 'district');

        // Merge districts
        $allDistricts = $groupHouses->keys()
            ->merge($groupLands->keys())
            ->unique();

        $districts = $allDistricts->mapWithKeys(function ($district) use ($groupHouses, $groupLands) {
            return [
                $district => [
                    'houses' => $groupHouses[$district] ?? 0,
                    'lands'  => $groupLands[$district] ?? 0,
                    'total'  => ($groupHouses[$district] ?? 0) + ($groupLands[$district] ?? 0),
                ]
            ];
        });

        $agents = Agent::where('is_verified', true)->get();

        return view('front.index', compact(
            'houses',
            'lands',
            'forRentHouses',
            'forSellHouses',
            'districts',
            'agents'
        ));
    }

    public function about()
    {
        return view('front.about');
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
