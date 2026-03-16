<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Throwable;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        try {

            $result = $this->authService->register($request->validated());

            return response()->json([
                'message' => 'User registered successfully',
                'data' => $result
            ], 201);

        } catch (Throwable $e) {

            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function login(LoginRequest $request)
    {
        try {

            $result = $this->authService->login($request->validated());

            return response()->json([
                'message' => 'Login success',
                'data' => $result
            ]);

        } catch (Throwable $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 401);

        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $this->authService->logout($user);

        return response()->json([
            'message' => 'Logout success'
        ]);
    }
}