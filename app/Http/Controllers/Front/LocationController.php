<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cell;
use App\Models\District;
use App\Models\Sector;
use App\Models\Village;

/**
 * JSON endpoints for the cascading Province → District → Sector → Cell → Village
 * dropdowns used by the house, land and agent forms.
 */
class LocationController extends Controller
{
    public function getDistricts($provinceId)
    {
        return response()->json(District::where('province_id', $provinceId)->get());
    }

    public function getSectors($districtId)
    {
        return response()->json(Sector::where('district_id', $districtId)->get());
    }

    public function getCells($sectorId)
    {
        return response()->json(Cell::where('sector_id', $sectorId)->get());
    }

    public function getVillages($cellId)
    {
        return response()->json(Village::where('cell_id', $cellId)->get());
    }
}
