<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'id'       => (string) Str::uuid(),
            'name'     => 'John Admin',
            'email'    => 'johnadmin@example.com',
            'role'     => 'admin',
            'password' => Hash::make('j0hnadmin123'),
        ]);

        // User Biasa
        User::create([
            'id'       => (string) Str::uuid(),
            'name'     => 'John User',
            'email'    => 'johnuser@example.com',
            'role'     => 'user',
            'password' => Hash::make('j0hnuser123'),
        ]);
    }
}