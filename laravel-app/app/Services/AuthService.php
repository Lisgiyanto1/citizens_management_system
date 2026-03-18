<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class AuthService
{
    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {

            $data['id'] = Str::uuid()->toString();
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            if (!$user) {
                throw new Exception('User creation failed');
            }

            $token = $user->createToken('api-token')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token
            ];
        });
    }


    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            throw new Exception('User not found');
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw new Exception('Invalid email or password');
        }

        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }


    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }
}