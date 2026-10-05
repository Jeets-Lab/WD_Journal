<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Admin::Create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'username' => 'Jeet',
            'password' => Hash::make('password'),
            'name' => 'Jeet Patel',
            'email' => 'Jeet@example.com',
            'mobile' => '1234567890',
            'city' => 'Surat',
            'profile_image' => null,
            'block' => false,
        ]);
        User::create([
            'username' => 'Vishva',
            'password' => Hash::make('password'),
            'name' => 'Vishva Patel',
            'email' => 'Vishva@example.com',
            'mobile' => '1234567890',
            'city' => 'Surat',
            'profile_image' => null,
            'block' => false,
        ]);
    }
}
