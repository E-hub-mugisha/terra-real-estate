<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\HouseImage;
use Illuminate\Database\Seeder;

class HouseImageSeeder extends Seeder
{
    public function run(): void
    {
        $houseImages = [

            // 1 — Modern Villa in Kiyovu
            'Modern Villa in Kiyovu' => [
                'houses/kiyovu-villa/exterior-front.jpg',
                'houses/kiyovu-villa/exterior-garden.jpg',
                'houses/kiyovu-villa/living-room.jpg',
                'houses/kiyovu-villa/kitchen.jpg',
                'houses/kiyovu-villa/master-bedroom.jpg',
                'houses/kiyovu-villa/master-bathroom.jpg',
                'houses/kiyovu-villa/bedroom-2.jpg',
                'houses/kiyovu-villa/swimming-pool.jpg',
                'houses/kiyovu-villa/garage.jpg',
                'houses/kiyovu-villa/city-view.jpg',
            ],

            // 2 — Furnished Apartment in Kimihurura
            'Furnished Apartment in Kimihurura' => [
                'houses/kimihurura-apt/exterior.jpg',
                'houses/kimihurura-apt/living-room.jpg',
                'houses/kimihurura-apt/dining-area.jpg',
                'houses/kimihurura-apt/kitchen.jpg',
                'houses/kimihurura-apt/master-bedroom.jpg',
                'houses/kimihurura-apt/bathroom.jpg',
                'houses/kimihurura-apt/rooftop-terrace.jpg',
                'houses/kimihurura-apt/kigali-skyline-view.jpg',
            ],

            // 3 — Family Home in Remera
            'Family Home in Remera' => [
                'houses/remera-home/exterior-front.jpg',
                'houses/remera-home/compound-garden.jpg',
                'houses/remera-home/living-room.jpg',
                'houses/remera-home/kitchen.jpg',
                'houses/remera-home/master-bedroom.jpg',
                'houses/remera-home/bedroom-2.jpg',
                'houses/remera-home/bathroom.jpg',
                'houses/remera-home/solar-panels.jpg',
                'houses/remera-home/garage.jpg',
            ],

            // 4 — Studio Apartment in Nyamirambo
            'Studio Apartment in Nyamirambo' => [
                'houses/nyamirambo-studio/exterior.jpg',
                'houses/nyamirambo-studio/living-sleeping-area.jpg',
                'houses/nyamirambo-studio/kitchenette.jpg',
                'houses/nyamirambo-studio/bathroom.jpg',
                'houses/nyamirambo-studio/street-view.jpg',
            ],

            // 5 — Luxury Penthouse in Nyarutarama
            'Luxury Penthouse in Nyarutarama' => [
                'houses/nyarutarama-penthouse/exterior-building.jpg',
                'houses/nyarutarama-penthouse/rooftop-pool.jpg',
                'houses/nyarutarama-penthouse/open-plan-living.jpg',
                'houses/nyarutarama-penthouse/chefs-kitchen.jpg',
                'houses/nyarutarama-penthouse/master-suite.jpg',
                'houses/nyarutarama-penthouse/master-ensuite.jpg',
                'houses/nyarutarama-penthouse/bedroom-3.jpg',
                'houses/nyarutarama-penthouse/cinema-room.jpg',
                'houses/nyarutarama-penthouse/wrap-around-terrace.jpg',
                'houses/nyarutarama-penthouse/golf-course-view.jpg',
                'houses/nyarutarama-penthouse/smart-home-panel.jpg',
                'houses/nyarutarama-penthouse/garage.jpg',
            ],

            // 6 — Townhouse in Kacyiru
            'Townhouse in Kacyiru' => [
                'houses/kacyiru-townhouse/exterior-front.jpg',
                'houses/kacyiru-townhouse/gated-community.jpg',
                'houses/kacyiru-townhouse/living-room.jpg',
                'houses/kacyiru-townhouse/kitchen.jpg',
                'houses/kacyiru-townhouse/master-bedroom.jpg',
                'houses/kacyiru-townhouse/bathroom.jpg',
                'houses/kacyiru-townhouse/shared-pool.jpg',
                'houses/kacyiru-townhouse/childrens-play-area.jpg',
                'houses/kacyiru-townhouse/parking.jpg',
            ],

            // 7 — Commercial Building in Downtown Kigali
            'Commercial Building in Downtown Kigali' => [
                'houses/kigali-cbd-commercial/exterior-facade.jpg',
                'houses/kigali-cbd-commercial/ground-floor-retail.jpg',
                'houses/kigali-cbd-commercial/open-plan-office.jpg',
                'houses/kigali-cbd-commercial/rooftop-conference.jpg',
                'houses/kigali-cbd-commercial/lobby.jpg',
                'houses/kigali-cbd-commercial/parking-basement.jpg',
                'houses/kigali-cbd-commercial/kcc-view.jpg',
            ],

            // 8 — Bungalow in Butare (Huye)
            'Bungalow in Butare (Huye)' => [
                'houses/huye-bungalow/exterior-front.jpg',
                'houses/huye-bungalow/garden.jpg',
                'houses/huye-bungalow/living-room.jpg',
                'houses/huye-bungalow/kitchen.jpg',
                'houses/huye-bungalow/master-bedroom.jpg',
                'houses/huye-bungalow/bathroom.jpg',
                'houses/huye-bungalow/compound.jpg',
            ],

            // 9 — Lakeside Cottage in Gisenyi
            'Lakeside Cottage in Gisenyi' => [
                'houses/gisenyi-cottage/exterior-lakeside.jpg',
                'houses/gisenyi-cottage/beach-access.jpg',
                'houses/gisenyi-cottage/living-room.jpg',
                'houses/gisenyi-cottage/kitchen.jpg',
                'houses/gisenyi-cottage/master-bedroom.jpg',
                'houses/gisenyi-cottage/lake-kivu-view.jpg',
                'houses/gisenyi-cottage/drc-mountain-view.jpg',
                'houses/gisenyi-cottage/garden.jpg',
            ],

            // 10 — Gated Residence in Musanze
            'Gated Residence in Musanze (Ruhengeri)' => [
                'houses/musanze-residence/exterior-front.jpg',
                'houses/musanze-residence/gate-entrance.jpg',
                'houses/musanze-residence/living-room-fireplace.jpg',
                'houses/musanze-residence/kitchen.jpg',
                'houses/musanze-residence/master-bedroom.jpg',
                'houses/musanze-residence/bathroom.jpg',
                'houses/musanze-residence/garden.jpg',
                'houses/musanze-residence/virunga-volcano-view.jpg',
                'houses/musanze-residence/parking.jpg',
            ],
        ];

        foreach ($houseImages as $houseTitle => $imagePaths) {
            $house = House::where('title', $houseTitle)->first();

            if (! $house) {
                continue;
            }

            foreach ($imagePaths as $path) {
                HouseImage::firstOrCreate(
                    [
                        'house_id'   => $house->id,
                        'image_path' => $path,
                    ]
                );
            }
        }
    }
}