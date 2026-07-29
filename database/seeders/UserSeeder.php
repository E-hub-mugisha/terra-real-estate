<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id'           => 1,
                'name'         => 'Jean-Pierre Habimana',
                'email'        => 'jeanpierre@terra.rw',
                'password'     => Hash::make('password'),
                'role'         => 'admin',
                'phone'        => '+250788123456',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id'           => 2,
                'name'         => 'Marie-Claire Uwimana',
                'email'        => 'marieclaire@terra.rw',
                'password'     => Hash::make('password'),
                'role'         => 'agent',
                'phone'        => '+250788234567',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id'           => 3,
                'name'         => 'Patrick Mugisha',
                'email'        => 'patrick@terra.rw',
                'password'     => Hash::make('password'),
                'role'         => 'consultant',
                'phone'        => '+250788345678',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id'           => 4,
                'name'         => 'Diane Ishimwe',
                'email'        => 'diane@terra.rw',
                'password'     => Hash::make('password'),
                'role'         => 'admin',
                'phone'        => '+250788456789',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id'           => 5,
                'name'         => 'Eric Niyonzima',
                'email'        => 'eric@terra.rw',
                'password'     => Hash::make('password'),
                'role'         => 'agent',
                'phone'        => '+250788567890',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}