<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    /**
     * Mendaftarkan user baru
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $validated['role'] = 'user';

        $user = User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diregistrasi.',
            'data' => $user
        ], 201);
    }

    /**
     * Proses Login dan Generate Token Sanctum
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan tidak cocok dengan data kami.'],
            ]);
        }

        auth()->setUser($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        $this->activityLogService->logActivity(
            'LOGIN',
            "User {$user->name} berhasil login ke dalam sistem",
            User::class,
            $user->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ]
            ]
        ]);
    }

    /**
     * Proses Logout dan Hapus Token
     */
    public function logout(Request $request): JsonResponse
    {
        // Ambil data user yang sedang login dari token yang dikirim via Header Authorization
        $user = $request->user();

        // --- CATAT LOG AKTIVITAS LOGOUT ---
        // WAJIB dilakukan sebelum token dihapus agar sistem masih mengenali user-nya
        $this->activityLogService->logActivity(
            'LOGOUT',
            "User {$user->name} berhasil logout dari sistem",
            User::class,
            $user->id
        );

        // Hapus token akses saat ini (Logout dari device/browser ini saja)
        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout dengan aman.'
        ]);
    }
}