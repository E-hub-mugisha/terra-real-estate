<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\House;
use App\Models\User;
use App\Models\Facility;

class HouseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'agent')->first() ?? User::first();

        if (!$user) {
            $this->command->warn('No users found. Seed users first.');
            return;
        }

        $facilityIds = Facility::pluck('id')->toArray();

        if (empty($facilityIds)) {
            $this->command->warn('No facilities found. Seed facilities first.');
            return;
        }

        $houses = [
            [
                'title' => 'Modern 3 Bedroom House in Nyarutarama',
                'type' => 'House',
                'price' => 180000000,
                'area_sqft' => 2400,
                'status' => 'available',
                'condition' => 'for_sale',
                'bedrooms' => 3,
                'bathrooms' => 3,
                'garages' => 2,
                'description' => 'Luxury modern house located in Nyarutarama with beautiful city view.',
                'city' => 'Kigali',
                'state' => 'Gasabo',
                'zip_code' => '00000',
                'country' => 'Rwanda',
                'address' => 'Nyarutarama, Kigali'
            ],
            [
                'title' => 'Executive Apartment in Kacyiru',
                'type' => 'Apartment',
                'price' => 800000,
                'area_sqft' => 1500,
                'status' => 'available',
                'condition' => 'for_sale',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'garages' => 1,
                'description' => 'Fully furnished executive apartment close to offices.',
                'city' => 'Kigali',
                'state' => 'Gasabo',
                'zip_code' => '00000',
                'country' => 'Rwanda',
                'address' => 'Kacyiru, Kigali'
            ],
            [
                'title' => 'Luxury Villa in Rebero',
                'type' => 'Villa',
                'price' => 300000000,
                'area_sqft' => 3500,
                'status' => 'available',
                'condition' => 'for_sale',
                'bedrooms' => 5,
                'bathrooms' => 4,
                'garages' => 2,
                'description' => 'High-end villa with panoramic Kigali city views.',
                'city' => 'Kigali',
                'state' => 'Kicukiro',
                'zip_code' => '00000',
                'country' => 'Rwanda',
                'address' => 'Rebero, Kigali'
            ],
            [
                'title' => 'Lake View Villa in Gisenyi',
                'type' => 'Villa',
                'price' => 250000000,
                'area_sqft' => 3200,
                'status' => 'available',
                'condition' => 'for_sale',
                'bedrooms' => 4,
                'bathrooms' => 4,
                'garages' => 2,
                'description' => 'Beautiful villa overlooking Lake Kivu.',
                'city' => 'Rubavu',
                'state' => 'Western Province',
                'zip_code' => '00000',
                'country' => 'Rwanda',
                'address' => 'Gisenyi, Rubavu'
            ],
            [
                'title' => 'Family House in Kicukiro',
                'type' => 'House',
                'price' => 95000000,
                'area_sqft' => 1800,
                'status' => 'available',
                'condition' => 'for_sale',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'garages' => 1,
                'description' => 'Spacious family home in a quiet neighborhood.',
                'city' => 'Kigali',
                'state' => 'Kicukiro',
                'zip_code' => '00000',
                'country' => 'Rwanda',
                'address' => 'Kicukiro, Kigali'
            ],
            [
                'title' => 'Affordable Apartment in Kimironko',
                'type' => 'Apartment',
                'price' => 450000,
                'area_sqft' => 1200,
                'status' => 'available',
                'condition' => 'for_rent',
                'bedrooms' => 2,
                'bathrooms' => 2,
                'garages' => 1,
                'description' => 'Clean apartment near Kimironko market.',
                'city' => 'Kigali',
                'state' => 'Gasabo',
                'zip_code' => '00000',
                'country' => 'Rwanda',
                'address' => 'Kimironko, Kigali'
            ],
            [
                'title' => 'Countryside House in Musanze',
                'type' => 'House',
                'price' => 70000000,
                'area_sqft' => 2000,
                'status' => 'available',
                'condition' => 'for_rent',
                'bedrooms' => 4,
                'bathrooms' => 2,
                'garages' => 1,
                'description' => 'Peaceful countryside home with large compound.',
                'city' => 'Musanze',
                'state' => 'Northern Province',
                'zip_code' => '00000',
                'country' => 'Rwanda',
                'address' => 'Musanze Town'
            ],
            [
                'title' => 'Student Apartment in Huye',
                'type' => 'Apartment',
                'price' => 250000,
                'area_sqft' => 800,
                'status' => 'available',
                'condition' => 'for_rent',
                'bedrooms' => 1,
                'bathrooms' => 1,
                'garages' => 0,
                'description' => 'Affordable apartment ideal for students.',
                'city' => 'Huye',
                'state' => 'Southern Province',
                'zip_code' => '00000',
                'country' => 'Rwanda',
                'address' => 'Near University of Rwanda'
            ],
            [
                'title' => 'Modern House in Gisozi',
                'type' => 'House',
                'price' => 120000000,
                'area_sqft' => 2200,
                'status' => 'available',
                'condition' => 'for_rent',
                'bedrooms' => 3,
                'bathrooms' => 3,
                'garages' => 1,
                'description' => 'Modern design house in central Kigali.',
                'city' => 'Kigali',
                'state' => 'Gasabo',
                'zip_code' => '00000',
                'country' => 'Rwanda',
                'address' => 'Gisozi, Kigali'
            ],
            [
                'title' => 'Beachside Property in Rusizi',
                'type' => 'Villa',
                'price' => 150000000,
                'area_sqft' => 2600,
                'status' => 'available',
                'condition' => 'for_rent',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'garages' => 2,
                'description' => 'Beautiful property near Lake Kivu beach.',
                'city' => 'Rusizi',
                'state' => 'Western Province',
                'zip_code' => '00000',
                'country' => 'Rwanda',
                'address' => 'Rusizi District'
            ],
        ];

        foreach ($houses as $houseData) {

            $house = House::create(array_merge($houseData, [
                'user_id' => $user->id
            ]));

            // Attach 2–5 random facilities
            $randomFacilities = collect($facilityIds)
                ->shuffle()
                ->take(rand(2, min(5, count($facilityIds))))
                ->toArray();

            $house->facilities()->attach($randomFacilities);
        }
    }
}

