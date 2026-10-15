<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FloorSeeder extends Seeder
{
    public function run(): void
    {
        $buildings = DB::table('buildings')
            ->select('id', 'name', 'number_of_floors')
            ->get();

        if ($buildings->isEmpty()) {
            throw new \RuntimeException('No buildings found. Run BuildingSeeder first.');
        }

        DB::transaction(function () use ($buildings) {
            foreach ($buildings as $building) {
                $count = max(1, (int) $building->number_of_floors);

                // Floor 0 = ground floor, so a building with 4 floors gets 0, 1, 2, 3
                for ($number = 0; $number < $count; $number++) {
                    DB::table('floors')->updateOrInsert(
                        [
                            'building_id'  => $building->id,
                            'floor_number' => $number,
                        ],
                        [
                            'name'        => $this->floorName($number),
                            'description' => $this->floorName($number) . ' of ' . $building->name . '.',
                            'created_at'  => now(),
                            'updated_at'  => now(),
                        ]
                    );
                }
            }
        });
    }

    private function floorName(int $number): string
    {
        if ($number === 0) {
            return 'Ground Floor';
        }

        $suffix = match (true) {
            $number % 100 >= 11 && $number % 100 <= 13 => 'th',
            $number % 10 === 1 => 'st',
            $number % 10 === 2 => 'nd',
            $number % 10 === 3 => 'rd',
            default            => 'th',
        };

        return $number . $suffix . ' Floor';
    }
}
