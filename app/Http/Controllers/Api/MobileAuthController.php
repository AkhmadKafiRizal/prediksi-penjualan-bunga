<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MobileAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        if (($user->status ?? 'aktif') !== 'aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda sedang nonaktif. Silakan hubungi admin.',
            ], 403);
        }

        if (($user->role ?? null) !== 'kasir') {
            return response()->json([
                'success' => false,
                'message' => 'Akun admin hanya dapat digunakan melalui website. Silakan login sebagai kasir untuk menggunakan aplikasi mobile.',
            ], 403);
        }

        $token = Str::random(80);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => (string) ($user->_id ?? $user->id),
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'status' => $user->status,
                    'avatar_url' => null,
                ],
            ],
        ]);
    }

    public function logout(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }
}