<?php

namespace App\Http\Controllers\PropertyOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $owner = $request->user()
            ->propertyOwner()
            ->firstOrFail();

        $properties = $owner->properties()
            ->latest()
            ->get();

        return view('property-owner.dashboard', [
            'owner' => $owner,
            'properties' => $properties,
            'totalProperties' => $properties->count(),
        ]);
    }
}