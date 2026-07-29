<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentReviewSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('agent_reviews')->insert([
            [
                'id'         => 1,
                'agent_id'   => 1, // Marie-Claire
                'user_id'    => 4, // Diane
                'rating'     => 5,
                'comment'    => 'Marie-Claire was exceptional! She helped me find the perfect property in Kacyiru within just two weeks. Her knowledge of the Gasabo market is unmatched, and she handled all the paperwork professionally. Highly recommended for anyone looking to buy in Kigali.',
                'created_at' => now()->subDays(20),
                'updated_at' => now(),
            ],
            [
                'id'         => 2,
                'agent_id'   => 2, // Eric
                'user_id'    => 5, // another user
                'rating'     => 4,
                'comment'    => 'Eric is very knowledgeable about land values in Kigali. He helped me verify the UPI and title deed for my Nyagatovu plot. The only reason for 4 stars instead of 5 is that communication was sometimes slow, but overall I am satisfied with his service.',
                'created_at' => now()->subDays(15),
                'updated_at' => now(),
            ],
            [
                'id'         => 3,
                'agent_id'   => 4, // Robert
                'user_id'    => 2, // Marie-Claire
                'rating'     => 5,
                'comment'    => 'Robert is the most experienced agent I have worked with in Rwanda. His understanding of luxury property valuation and the Kigali high-end market is remarkable. He sold my apartment in Kimihurura within 3 weeks at above asking price. A true professional.',
                'created_at' => now()->subDays(30),
                'updated_at' => now(),
            ],
            [
                'id'         => 4,
                'agent_id'   => 5, // Anitha
                'user_id'    => 4, // Diane
                'rating'     => 4,
                'comment'    => 'As a diaspora client, I was worried about buying property remotely. Anitha made the process smooth by providing video tours and handling the RLMUA paperwork on my behalf. She found me a beautiful lakefront plot in Rubavu. Very trustworthy agent.',
                'created_at' => now()->subDays(10),
                'updated_at' => now(),
            ],
            [
                'id'         => 5,
                'agent_id'   => 1, // Marie-Claire
                'user_id'    => 1, // Jean-Pierre
                'rating'     => 5,
                'comment'    => 'Marie-Claire helped our family find a commercial plot on KN 3 Road. Her negotiation skills saved us over 15 million RWF on the purchase price. She also connected us with a great lawyer for the title transfer. We will definitely use her services again.',
                'created_at' => now()->subDays(5),
                'updated_at' => now(),
            ],
        ]);
    }
}