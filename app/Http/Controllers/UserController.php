<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Tampilkan semua kasir
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $filterStatus = $request->query('status', '');

        $allUsers = User::where('role', 'kasir')
            ->orderBy('created_at', 'desc')
            ->get();

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
            'filterStatus'
        ));
    }

    // Simpan kasir baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required'      => 'Nama wajib diisi',
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
            ->with('success', 'Akun kasir berhasil ditambahkan');
    }

    // Update data kasir
    public function update(Request $request, User $user)
    {
        $this->ensureCashier($user);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'name.required'  => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique'   => 'Email sudah digunakan',
        ]);

        $updateData = [
            'name'   => $request->name,
            'email'  => $request->email,
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ], [
                'password.min'       => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
            ]);

            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('users.index')
            ->with('success', 'Data kasir berhasil diperbarui');
    }

    // Nonaktifkan / aktifkan kasir (toggle)
    public function destroy(User $user)
    {
        $this->ensureCashier($user);

        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak bisa menonaktifkan akun sendiri');
        }

        $newStatus = $user->status === 'aktif' ? 'nonaktif' : 'aktif';

        $updateData = [
            'status' => $newStatus,
        ];

        if ($newStatus === 'nonaktif') {
            $updateData['api_token'] = null;
        }

        $user->update($updateData);

        $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('users.index')
            ->with('success', "Akun kasir berhasil {$statusText}");
    }

    private function ensureCashier(User $user): void
    {
        abort_unless(($user->role ?? null) === 'kasir', 404);
    }
}
