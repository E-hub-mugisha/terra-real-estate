<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultantPortfolioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('consultant_portfolios')->insert([
            [
                'id'             => 1,
                'consultant_id'  => 1, // Patrick - Surveyor
                'title'          => 'Cadastral Survey of 120-Plot Subdivision — Nyamata, Bugesera',
                'location'       => 'Nyamata, Bugesera, Eastern Province',
                'year'           => 2025,
                'image'          => 'consultants/portfolio/bugesera-subdivision-survey.jpg',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id'             => 2,
                'consultant_id'  => 2, // Aimable - Attorney
                'title'          => 'Title Deed Transfer — Multi-Parcel Estate in Kiyovu',
                'location'       => 'Kiyovu, Nyarugenge, Kigali',
                'year'           => 2025,
                'image'          => 'consultants/portfolio/kiyovu-title-transfer.jpg',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id'             => 3,
                'consultant_id'  => 3, // Grace - Architect
                'title'          => 'Modern Eco-Villa Design — Kigali Hillside Residence',
                'location'       => 'Kacyiru, Gasabo, Kigali',
                'year'           => 2026,
                'image'          => 'consultants/portfolio/kacyiru-eco-villa-design.jpg',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id'             => 4,
                'consultant_id'  => 4, // Théogène - Engineer
                'title'          => 'Structural Assessment — 6-Storey Commercial Building in Kigali CBD',
                'location'       => 'Nyarugenge, Kigali',
                'year'           => 2024,
                'image'          => 'consultants/portfolio/cbd-structural-assessment.jpg',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id'             => 5,
                'consultant_id'  => 1, // Patrick - Surveyor
                'title'          => 'Boundary Demarcation — Lake Kivu Waterfront Properties',
                'location'       => 'Rubavu, Western Province',
                'year'           => 2026,
                'image'          => 'consultants/portfolio/rubavu-boundary-demarcation.jpg',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}