<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Brick\Math\BigInteger;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {

            for ($i = 1; $i <= 10; $i++) {

                ActivityLog::create([
                    'id' => Str::uuid(),
                    'user_id' => $user->id,
                    'action' => 'VIEW_CITIZEN',
                    'description' => 'User melihat data citizen',
                    'subject_tytpe' => 'Citizen',
                    'subject_id' => BigInteger::of($i)->toString()
                ]);
            }

        }
    }
}
