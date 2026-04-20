<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Tampilkan semua kasir
    public function index()
    {
        $users = User::where('role', 'kasir')->orderBy('created_at', 'desc')->get();
        return view('users.index', compact('users'));
    }

    // Simpan kasir baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required'      => 'Nama wajib diisi',
            'email.required'     => 'Email wajib diisi',
            'email.unique'       => 'Email sudah digunakan',
            'password.required'  => 'Password wajib diisi',
            'password.min'       => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'kasir',
            'is_active' => true,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Akun kasir berhasil ditambahkan');
    }

    // Update data kasir
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'name.required'  => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique'   => 'Email sudah digunakan',
        ]);

        $updateData = [
            'name'      => $request->name,
            'email'     => $request->email,
            'is_active' => $request->has('is_active') ? true : false,
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ], [
                'password.min'       => 'Password minimal 6 karakter',
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
        // Cegah admin nonaktifkan dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak bisa menonaktifkan akun sendiri');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('users.index')
            ->with('success', "Akun kasir berhasil {$status}");
    }
}