<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@terrarealestate.rw',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'remember_token' => Str::random(10),
        ]);

        // AGENTS
        $agents = [
            [
                'name' => 'Jean Claude',
                'email' => 'jean.agent@terrarealestate.rw',
            ],
            [
                'name' => 'Diane Uwimana',
                'email' => 'diane.agent@terrarealestate.rw',
            ],
        ];

        foreach ($agents as $agent) {
            User::create([
                'name' => $agent['name'],
                'email' => $agent['email'],
                'role' => 'agent',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]);
        }

        // REGULAR USERS
        $users = [
            [
                'name' => 'Eric Mugisha',
                'email' => 'eric.user@terrarealestate.rw',
            ],
            [
                'name' => 'Claudine Mukamana',
                'email' => 'claudine.user@terrarealestate.rw',
            ],
            [
                'name' => 'Patrick Ndayishimiye',
                'email' => 'patrick.user@terrarealestate.rw',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => 'buyer',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
