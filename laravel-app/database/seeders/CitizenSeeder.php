<?php

namespace Database\Seeders;

use App\Models\Citizen;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitizenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            throw new \Exception("Admin user not found. Run UserSeeder first.");
        }

        for ($i = 1; $i <= 50; $i++) {

            Citizen::create([
                'id' => Str::uuid(),
                'nik' => fake()->numerify('337201########'),
                'name' => fake()->name(),
                'birth_date' => fake()->date(),
                'gender' => fake()->randomElement(['L', 'P']),
                'address' => fake()->address(),
                'photo' => 'https://api.dicebear.com/7.x/personas/svg?seed=' . $i,
                'created_by' => $admin->id
            ]);
        }
    }
}
