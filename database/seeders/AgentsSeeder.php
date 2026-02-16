<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class AgentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Realistic Rwandan names (first + last)
        $rwandanNames = [
            ['first' => 'Eric', 'last' => 'Mugisha'],
            ['first' => 'Aline', 'last' => 'Uwimana'],
            ['first' => 'Jean', 'last' => 'Kamanzi'],
            ['first' => 'Sandrine', 'last' => 'Mukamana'],
            ['first' => 'Patrick', 'last' => 'Niyonzima'],
        ];

        foreach ($rwandanNames as $name) {

            // Create user account
            $email = strtolower($name['first'] . '.' . $name['last'] . '@example.com');

            $userId = DB::table('users')->insertGetId([
                'name' => $name['first'] . ' ' . $name['last'],
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // default password
                'remember_token' => Str::random(10),
                'role' => 'agent',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create agent linked to the user
            DB::table('agents')->insert([
                'user_id' => $userId,
                'full_name' => $name['first'] . ' ' . $name['last'],
                'email' => $email, // same as user email
                'phone' => $faker->numerify('0788######'),
                'years_experience' => $faker->numberBetween(1, 15),
                'bio' => $faker->paragraph,
                'linkedin' => 'https://linkedin.com/in/' . strtolower($name['first'] . $name['last']),
                'facebook' => 'https://facebook.com/' . strtolower($name['first'] . $name['last']),
                'instagram' => 'https://instagram.com/' . strtolower($name['first'] . $name['last']),
                'twitter' => 'https://twitter.com/' . strtolower($name['first'] . $name['last']),
                'profile_image' => 'agents/' . strtolower($name['first'] . $name['last']) . '.jpg',
                'whatsapp' => $faker->numerify('0788######'),
                'office_location' => $faker->city . ', Rwanda',
                'languages' => 'Kinyarwanda,English',
                'is_verified' => $faker->boolean(70),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
