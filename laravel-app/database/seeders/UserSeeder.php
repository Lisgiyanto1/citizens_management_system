<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(([
            'id' => Str::uuid(),
            'name' => 'JohnAdmin',
            'email' => 'johnadmin@exmaple.com',
            'role' => 'admin',
            'password' => Hash::make('j0hnadmin123')
        ]));

        User::create([
            'id' => Str::uuid(),
            'name' => 'JohnUser',
            'email' => 'johnuser@example.com',
            'role' => 'user',
            'password' => Hash::make('j0hnuser123')
        ]);
    }
}
