<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Notifications\MobileResetPasswordOtp;
use Throwable;

class MobileAuthController extends Controller
{
    private const RESET_OTP_TTL_MINUTES = 5;

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
                'message' => 'Email atau kata sandi belum sesuai.',
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
                'message' => 'Akun admin hanya dapat digunakan melalui website. Silakan masuk sebagai kasir untuk menggunakan aplikasi mobile.',
            ], 403);
        }

        $token = Str::random(80);
        $user->api_token = hash('sha256', $token);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Masuk berhasil.',
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
        $token = $request->bearerToken() ?: $request->input('token');

        if ($token) {
            User::where('api_token', hash('sha256', $token))->update([
                'api_token' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Keluar berhasil.',
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        try {
            $email = $this->normalizeEmail($data['email']);
            $user = User::where('email', $email)->first();

            if (! $user || ($user->role ?? null) !== 'kasir') {
                throw ValidationException::withMessages([
                    'email' => ['Email kasir tidak terdaftar. Pastikan email sudah dibuat di Manajemen Kasir.'],
                ]);
            }

            if (($user->status ?? 'aktif') !== 'aktif') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun kasir sedang nonaktif. Silakan hubungi admin.',
                ], 403);
            }

            $otp = (string) random_int(100000, 999999);

            Cache::put($this->resetOtpKey($email), [
                'otp_hash' => Hash::make($otp),
                'email' => $email,
                'created_at' => now()->toIso8601String(),
            ], now()->addMinutes(self::RESET_OTP_TTL_MINUTES));

            $user->notify(new MobileResetPasswordOtp($otp, self::RESET_OTP_TTL_MINUTES));

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP atur ulang kata sandi sudah dikirim ke email kasir.',
            ]);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa terhubung ke server. Pastikan internet aktif atau hubungi admin.',
            ], 503);
        }
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus 6 digit.',
        ]);

        $this->ensureValidResetOtp($data['email'], $data['otp']);

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP valid. Silakan buat kata sandi baru.',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus 6 digit.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi belum sama.',
        ]);

        try {
            $email = $this->normalizeEmail($data['email']);
            $this->ensureValidResetOtp($email, $data['otp']);

            $user = User::where('email', $email)->first();

            if (! $user || ($user->role ?? null) !== 'kasir') {
                throw ValidationException::withMessages([
                    'email' => ['Email kasir tidak terdaftar.'],
                ]);
            }

            $user->update([
                'password' => Hash::make($data['password']),
                'api_token' => null,
            ]);

            Cache::forget($this->resetOtpKey($email));

            return response()->json([
                'success' => true,
                'message' => 'Kata sandi berhasil diubah. Silakan masuk dengan kata sandi baru.',
            ]);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa terhubung ke server. Pastikan internet aktif atau hubungi admin.',
            ], 503);
        }
    }

    private function ensureValidResetOtp(string $email, string $otp): void
    {
        $normalizedEmail = $this->normalizeEmail($email);
        $payload = Cache::get($this->resetOtpKey($normalizedEmail));

        if (! $payload || ! isset($payload['otp_hash']) || ! Hash::check($otp, $payload['otp_hash'])) {
            throw ValidationException::withMessages([
                'otp' => ['Kode OTP tidak valid atau sudah kedaluwarsa. Minta kode baru.'],
            ]);
        }
    }

    private function resetOtpKey(string $email): string
    {
        return 'mobile_password_reset_otp:' . sha1($this->normalizeEmail($email));
    }

    private function normalizeEmail(string $email): string
    {
        return mb_strtolower(trim($email));
    }
}
