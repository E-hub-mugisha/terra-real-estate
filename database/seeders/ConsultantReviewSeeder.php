<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultantReviewSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('consultant_reviews')->insert([
            [
                'id'             => 1,
                'consultant_id'  => 1, // Patrick - Surveyor
                'user_id'        => 4, // Diane
                'rating'         => 5,
                'comment'        => 'Patrick conducted a thorough cadastral survey of my land in Nyagatovu. He was punctual, professional, and submitted the UPI documentation to RLMUA within the promised timeline. His fees are very reasonable for the quality of work.',
                'created_at'     => now()->subDays(25),
                'updated_at'     => now(),
            ],
            [
                'id'             => 2,
                'consultant_id'  => 2, // Aimable - Attorney
                'user_id'        => 5, // Eric
                'rating'         => 5,
                'comment'        => 'Me. Hakizimana handled my title deed transfer flawlessly. There was a boundary dispute with the neighbor, and he resolved it professionally through mediation. His knowledge of Rwandan property law is excellent. I highly recommend him for any property legal matter.',
                'created_at'     => now()->subDays(20),
                'updated_at'     => now(),
            ],
            [
                'id'             => 3,
                'consultant_id'  => 3, // Grace - Architect
                'user_id'        => 2, // Marie-Claire
                'rating'         => 4,
                'comment'        => 'Arch. Iribagiza designed a beautiful house plan for my client. The design was creative and compliant with the Rwanda Building Code. The only minor issue was a delay in the 3D rendering, but the final result was worth the wait. I will work with her again.',
                'created_at'     => now()->subDays(12),
                'updated_at'     => now(),
            ],
            [
                'id'             => 4,
                'consultant_id'  => 4, // Théogène - Engineer
                'user_id'        => 1, // Jean-Pierre
                'rating'         => 5,
                'comment'        => 'Eng. Nsengiyumva conducted a structural assessment of a property I was considering purchasing in Huye. He identified foundation issues that saved me from a bad investment. His report was detailed and professional. I am very grateful for his expertise.',
                'created_at'     => now()->subDays(8),
                'updated_at'     => now(),
            ],
            [
                'id'             => 5,
                'consultant_id'  => 1, // Patrick - Surveyor
                'user_id'        => 2, // Marie-Claire
                'rating'         => 4,
                'comment'        => 'Patrick surveyed a large agricultural plot in Huye for one of my clients. He was thorough in his boundary demarcation and provided accurate GPS coordinates. Communication was good, though I wish the turnaround time was slightly faster. Overall a solid professional.',
                'created_at'     => now()->subDays(3),
                'updated_at'     => now(),
            ],
        ]);
    }
}