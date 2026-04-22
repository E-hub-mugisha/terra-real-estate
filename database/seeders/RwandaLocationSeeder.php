<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RwandaLocationSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('villages')->truncate();
        DB::table('cells')->truncate();
        DB::table('sectors')->truncate();
        DB::table('districts')->truncate();
        DB::table('provinces')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach (self::data() as $provinceData) {
            $provinceId = DB::table('provinces')->insertGetId(['name' => $provinceData['name']]);

            foreach ($provinceData['districts'] as $districtData) {
                $districtId = DB::table('districts')->insertGetId(['name' => $districtData['name'], 'province_id' => $provinceId]);

                foreach ($districtData['sectors'] as $sectorData) {
                    $sectorId = DB::table('sectors')->insertGetId(['name' => $sectorData['name'], 'district_id' => $districtId]);

                    foreach ($sectorData['cells'] as $cellData) {
                        $cellId = DB::table('cells')->insertGetId(['name' => $cellData['name'], 'sector_id' => $sectorId]);

                        $villages = array_map(fn($v) => ['name' => is_array($v) ? $v['name'] : $v, 'cell_id' => $cellId], $cellData['villages']);
                        DB::table('villages')->insert($villages);
                    }
                }
            }
        }
    }

    private static function data(): array
    {
        $json = json_decode(file_get_contents(__DIR__ . '/data/rwanda_nested.json'), true);
        return $json['provinces'];
    }
}