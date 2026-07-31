<?php

namespace Database\Seeders;

use App\Models\PropertyRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PropertyRequestSeeder extends Seeder
{
    /**
     * Rwandan first/last names for realistic requester identities.
     */
    protected array $firstNames = [
        'Eric',
        'Aline',
        'Jean Paul',
        'Diane',
        'Patrick',
        'Claudine',
        'Emmanuel',
        'Immaculee',
        'Olivier',
        'Josiane',
        'Fabrice',
        'Solange',
        'Yves',
        'Chantal',
        'Innocent',
        'Divine',
        'Placide',
        'Grace',
        'Theogene',
        'Vestine',
        'Alexis',
        'Providence',
        'Bosco',
        'Marie Claire',
        'Christian',
        'Sandrine',
        'Elias',
        'Alice',
        'Sam',
        'Nadia',
        'Kevin',
        'Liliane',
        'Aimable',
        'Pacifique',
        'Vanessa',
        'Ndoli',
        'Uwera',
        'Gasana',
        'Mugisha',
        'Keza',
    ];

    protected array $lastNames = [
        'Uwimana',
        'Mugisha',
        'Habimana',
        'Niyonsaba',
        'Ndayishimiye',
        'Nkurunziza',
        'Uwase',
        'Ishimwe',
        'Iradukunda',
        'Nshimiyimana',
        'Mukamana',
        'Ntawuruhunga',
        'Twizeyimana',
        'Uwizeye',
        'Gashugi',
        'Rugamba',
        'Kamanzi',
        'Mucyo',
        'Byiringiro',
        'Nzeyimana',
        'Rwigema',
        'Bizimana',
        'Karenzi',
        'Munyaneza',
    ];

    /**
     * province => [districts...]
     */
    protected array $provinceDistricts = [
        'Kigali City' => ['Gasabo', 'Kicukiro', 'Nyarugenge'],
        'Northern Province' => ['Musanze', 'Gicumbi', 'Rulindo', 'Burera', 'Gakenke'],
        'Southern Province' => ['Huye', 'Nyanza', 'Muhanga', 'Kamonyi', 'Ruhango', 'Nyamagabe', 'Gisagara'],
        'Eastern Province' => ['Rwamagana', 'Nyagatare', 'Kayonza', 'Kirehe', 'Ngoma', 'Bugesera', 'Gatsibo'],
        'Western Province' => ['Rubavu', 'Rusizi', 'Karongi', 'Nyabihu', 'Ngororero', 'Rutsiro', 'Nyamasheke'],
    ];

    /**
     * A few real sector names per district, used only where available —
     * falls back to a generic sector label otherwise.
     */
    protected array $districtSectors = [
        'Gasabo' => ['Kimironko', 'Remera', 'Kacyiru', 'Nyarutarama', 'Gisozi', 'Kinyinya', 'Ndera'],
        'Kicukiro' => ['Niboye', 'Kagarama', 'Gatenga', 'Kanombe', 'Gikondo', 'Nyarugunga'],
        'Nyarugenge' => ['Nyamirambo', 'Kimisagara', 'Muhima', 'Nyakabanda', 'Rwezamenyo'],
        'Musanze' => ['Muhoza', 'Cyuve', 'Kinigi', 'Busogo'],
        'Huye' => ['Tumba', 'Ngoma', 'Mukura'],
        'Rubavu' => ['Gisenyi', 'Nyamyumba', 'Rugerero'],
        'Rwamagana' => ['Rwamagana', 'Kigabiro', 'Muhazi'],
    ];

    protected array $nationalities = [
        'Rwandan',
        'Rwandan',
        'Rwandan',
        'Rwandan',
        'Rwandan',
        'Rwandan', // weighted common
        'Ugandan',
        'Kenyan',
        'Congolese (DRC)',
        'Burundian',
        'American',
        'French',
        'Belgian',
        'British',
        'Canadian',
    ];

    protected array $propertyTypes = [
        'house',
        'apartment',
        'land',
        'commercial',
        'architectural_design',
    ];

    protected array $propertyStatuses = ['new', 'existing', 'any'];

    protected array $timelines = [
        'immediate',
        '1_3_months',
        '3_6_months',
        '6_12_months',
        'flexible',
    ];

    protected array $howHeard = [
        'Google Search',
        'Social Media',
        'Friend/Family Referral',
        'Terra Agent',
        'Radio Ad',
        'Billboard',
        'WhatsApp Group',
        'Newspaper',
    ];

    protected array $amenityPool = [
        'Parking',
        'Security / Guard',
        'Water Tank',
        'Solar Power',
        'Garden',
        'Swimming Pool',
        'Generator',
        'Borehole',
        'CCTV',
        'Fenced Compound',
        'Tarmac Access Road',
        'Servant Quarters',
        'Boys Quarters',
        'Electric Fence',
    ];

    protected array $notesPool = [
        'Prefers a quiet neighborhood, ideally close to a main road for easy access.',
        'Needs the property ready for immediate move-in, not under construction.',
        'Looking for something within walking distance of an international school.',
        'Would consider a slightly smaller plot if the location is right.',
        'Open to negotiation on price if the seller can move quickly.',
        'Relocating from abroad and would like video tour options before visiting in person.',
        'Buying as an investment, so rental yield potential matters more than personal taste.',
        'Family of five, so needs enough bedrooms and a secure compound for children.',
        'Looking to build going forward, so raw land with clean title is preferred.',
        null,
        null, // some requests have no extra notes
    ];

    public function run(): void
    {
        $agents = ['Jean de Dieu Habimana', 'Aline Uwamahoro', 'Eric Ndayisenga', null, null];

        $totalRequests = rand(45, 60);

        foreach (range(1, $totalRequests) as $i) {
            $province = array_rand($this->provinceDistricts);
            $district = $this->provinceDistricts[$province][array_rand($this->provinceDistricts[$province])];
            $sectors = $this->districtSectors[$district] ?? ["{$district} Sector"];
            $sector = $sectors[array_rand($sectors)];

            $firstName = $this->firstNames[array_rand($this->firstNames)];
            $lastName = $this->lastNames[array_rand($this->lastNames)];
            $fullName = "{$firstName} {$lastName}";

            $requestType = fake()->randomElement(['buy', 'buy', 'buy', 'rent', 'rent', 'invest']);
            $propertyType = fake()->randomElement($this->propertyTypes);
            $isLand = $propertyType === 'land';
            $hasBedrooms = in_array($propertyType, ['house', 'apartment']);

            $currency = fake()->randomElement(['RWF', 'RWF', 'RWF', 'RWF', 'USD']);

            [$budgetMin, $budgetMax] = $this->generateBudget($currency, $requestType, $isLand);

            $status = fake()->randomElement(['new', 'new', 'in_review', 'in_review', 'matched', 'closed']);
            $isReviewed = in_array($status, ['in_review', 'matched', 'closed']);
            $isPublic = in_array($status, ['new', 'in_review', 'matched']) ? fake()->boolean(65) : false;

            $amenities = fake()->randomElements($this->amenityPool, rand(2, 5));
            $mustHave = fake()->randomElements($amenities, min(count($amenities), rand(1, 3)));
            $niceToHave = array_values(array_diff(
                fake()->randomElements($this->amenityPool, rand(1, 3)),
                $mustHave
            ));

            PropertyRequest::create([
                'full_name' => $fullName,
                'email' => strtolower(str_replace(' ', '.', $firstName)) . '.' . strtolower($lastName) . '@' . fake()->randomElement(['gmail.com', 'yahoo.com', 'outlook.com']),
                'phone' => $this->generateRwandanPhone(),
                'nationality' => fake()->randomElement($this->nationalities),
                'preferred_contact' => fake()->randomElement(['phone', 'whatsapp', 'whatsapp', 'email']),

                'request_type' => $requestType,
                'property_type' => $propertyType,
                'property_status' => fake()->randomElement($this->propertyStatuses),

                'preferred_province' => $province,
                'preferred_district' => $district,
                'preferred_sector' => $sector,
                'location_notes' => fake()->boolean(30)
                    ? "Open to nearby sectors within {$district} as well."
                    : null,

                'currency' => $currency,
                'budget_min' => $budgetMin,
                'budget_max' => $budgetMax,
                'timeline' => fake()->randomElement($this->timelines),
                'financing_needed' => fake()->boolean(25),

                'bedrooms_min' => $hasBedrooms ? fake()->numberBetween(1, 6) : null,
                'bathrooms_min' => $hasBedrooms ? fake()->numberBetween(1, 4) : null,
                'land_size_min' => $isLand ? fake()->numberBetween(200, 800) : null,
                'land_size_max' => $isLand ? fake()->numberBetween(800, 2500) : null,

                'amenities' => $amenities,
                'must_have_features' => $mustHave,
                'nice_to_have_features' => $niceToHave,

                'additional_notes' => $this->notesPool[array_rand($this->notesPool)],
                'newsletter_opt_in' => fake()->boolean(40),
                'how_did_you_hear' => fake()->randomElement($this->howHeard),
                'urgency' => fake()->randomElement(['high', 'medium', 'medium', 'low']),

                'status' => $status,
                'assigned_agent' => $status === 'new' ? null : fake()->randomElement($agents),
                'admin_notes' => $isReviewed && fake()->boolean(50)
                    ? fake()->randomElement([
                        'Verified phone number, buyer is serious and pre-qualified.',
                        'Sent 3 matching listings via WhatsApp, awaiting feedback.',
                        'Budget seems tight for this area — flagged for follow-up.',
                        'Referred to consultant for site visits next week.',
                    ])
                    : null,
                'reviewed_at' => $isReviewed
                    ? Carbon::now()->subDays(rand(1, 45))->subHours(rand(0, 23))
                    : null,
                'is_public' => $isPublic,

                'created_at' => Carbon::now()->subDays(rand(0, 60))->subHours(rand(0, 23)),
            ]);
        }

        $this->command->info("Seeded {$totalRequests} property requests.");
    }

    /**
     * Rwandan mobile format: 07[2-9]\d{7} (matches Eric's existing validation pattern).
     */
    protected function generateRwandanPhone(): string
    {
        $secondDigit = rand(2, 9);
        $rest = str_pad((string) rand(0, 9999999), 7, '0', STR_PAD_LEFT);
        return "07{$secondDigit}{$rest}";
    }

    protected function generateBudget(string $currency, string $requestType, bool $isLand): array
    {
        if ($currency === 'USD') {
            $min = $requestType === 'rent' ? rand(300, 1500) : rand(20000, 150000);
            $max = $min + rand((int) ($min * 0.2), (int) ($min * 0.6));
            return [$min, $max];
        }

        // RWF
        if ($requestType === 'rent') {
            $min = rand(100, 800) * 1000; // 100k - 800k / month
            $max = $min + (rand(2, 8) * 50000);
            return [$min, $max];
        }

        if ($isLand) {
            $min = rand(5, 40) * 1_000_000;
            $max = $min + (rand(2, 20) * 1_000_000);
            return [$min, $max];
        }

        $min = rand(15, 200) * 1_000_000;
        $max = $min + (rand(5, 50) * 1_000_000);
        return [$min, $max];
    }
}
