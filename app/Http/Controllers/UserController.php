<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class UserController extends Controller
{
    // Tampilkan semua kasir
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $filterStatus = $request->query('status', '');
        $databaseError = null;

        try {
            $allUsers = User::where('role', 'kasir')
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (Throwable $exception) {
            report($exception);

            $allUsers = collect();
            $databaseError = 'Data kasir belum bisa dimuat karena koneksi MongoDB/Atlas sedang timeout. Periksa koneksi internet/DNS atau status MongoDB Atlas, lalu coba lagi.';
        }

        $totalUsers = $allUsers->count();
        $totalActive = $allUsers->where('status', 'aktif')->count();
        $totalInactive = $allUsers->where('status', 'nonaktif')->count();

        $users = $allUsers
            ->when($search !== '', function ($users) use ($search) {
                $keyword = mb_strtolower($search);

                return $users->filter(function ($user) use ($keyword) {
                    return str_contains(mb_strtolower((string) ($user->name ?? '')), $keyword)
                        || str_contains(mb_strtolower((string) ($user->email ?? '')), $keyword);
                });
            })
            ->when(in_array($filterStatus, ['aktif', 'nonaktif'], true), function ($users) use ($filterStatus) {
                return $users->filter(fn ($user) => ($user->status ?? 'aktif') === $filterStatus);
            })
            ->values();

        return view('users.index', compact(
            'users',
            'totalUsers',
            'totalActive',
            'totalInactive',
            'search',
            'filterStatus',
            'databaseError'
        ));
    }

    // Simpan kasir baru
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
            ], [
                'name.required'      => 'Nama panggilan wajib diisi',
                'email.required'     => 'Email wajib diisi',
                'email.unique'       => 'Email sudah digunakan',
                'password.required'  => 'Password wajib diisi',
                'password.min'       => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
            ]);

            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'kasir',
                'status'   => 'aktif',
            ]);

            return redirect()->route('users.index')
                ->with('success', 'Akun kasir berhasil ditambahkan dan sudah bisa login di aplikasi mobile.');
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('users.index')
                ->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', 'Akun kasir belum bisa ditambahkan karena koneksi MongoDB/Atlas sedang timeout. Periksa internet/DNS atau status MongoDB Atlas, lalu coba lagi.');
        }
    }

    // Update data kasir
    public function update(Request $request, string $user)
    {
        try {
            $cashier = User::query()->whereKey($user)->firstOrFail();
            $this->ensureCashier($cashier);

            $wantsPasswordChange = $request->filled('password') || $request->filled('password_confirmation');

            $rules = [
                'name'  => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore((string) $cashier->getKey(), $cashier->getKeyName()),
                ],
            ];

            $messages = [
                'name.required'  => 'Nama panggilan wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.unique'   => 'Email sudah digunakan',
            ];

            if ($wantsPasswordChange) {
                $rules['password'] = 'required|min:8|confirmed';
                $messages['password.required'] = 'Password baru wajib diisi jika ingin mengganti password';
                $messages['password.min'] = 'Password minimal 8 karakter';
                $messages['password.confirmed'] = 'Konfirmasi password tidak cocok';
            }

            $request->validate($rules, $messages);

            $updateData = [
                'name'   => $request->name,
                'email'  => $request->email,
            ];

            // Update password hanya jika admin memang mengisi kolom password baru.
            if ($wantsPasswordChange) {
                $updateData['password'] = Hash::make($request->password);
            }

            $cashier->update($updateData);

            $passwordNotice = $wantsPasswordChange
                ? 'Password baru sudah aktif untuk login mobile.'
                : 'Password tidak diubah; kasir tetap menggunakan password lama untuk login mobile.';

            return redirect()->route('users.index')
                ->with('success', "Data kasir {$updateData['name']} berhasil diperbarui. Email login mobile sekarang {$updateData['email']}. {$passwordNotice}");
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (ModelNotFoundException | HttpExceptionInterface $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('users.index')
                ->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', 'Data kasir belum bisa diperbarui karena koneksi MongoDB/Atlas sedang timeout. Perubahan email/password belum tersimpan. Periksa internet/DNS atau status MongoDB Atlas, lalu coba lagi.');
        }
    }

    // Nonaktifkan / aktifkan kasir (toggle)
    public function updateStatus(string $user)
    {
        try {
            $cashier = User::query()->whereKey($user)->firstOrFail();
            $this->ensureCashier($cashier);

            if ((string) $cashier->getKey() === (string) auth()->id()) {
                return redirect()->route('users.index')
                    ->with('error', 'Tidak bisa menonaktifkan akun sendiri');
            }

            $newStatus = $cashier->status === 'aktif' ? 'nonaktif' : 'aktif';

            $updateData = [
                'status' => $newStatus,
            ];

            if ($newStatus === 'nonaktif') {
                $updateData['api_token'] = null;
            }

            $cashier->update($updateData);

            $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';

            return redirect()->route('users.index')
                ->with('success', "Akun kasir berhasil {$statusText}");
        } catch (ModelNotFoundException | HttpExceptionInterface $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('users.index')
                ->with('error', 'Status kasir belum bisa diubah karena koneksi MongoDB/Atlas sedang timeout. Coba lagi setelah koneksi database normal.');
        }
    }

    private function ensureCashier(User $user): void
    {
        abort_unless(($user->role ?? null) === 'kasir', 404);
    }
}
