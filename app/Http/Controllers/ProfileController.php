<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $adminCount = User::where('role', 'admin')->count();
        $canDeleteAccount = ! (($user->role ?? null) === 'admin' && $adminCount <= 1);

        return view('profile.edit', [
            'user' => $user,
            'canDeleteAccount' => $canDeleteAccount,
            'accountDeleteBlockReason' => $canDeleteAccount
                ? null
                : 'Akun admin terakhir tidak bisa dihapus agar akses pengelolaan sistem tetap tersedia.',
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if (($request->user()->role ?? null) === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return Redirect::route('profile.edit')
                ->with('error', 'Akun admin terakhir tidak bisa dihapus. Tambahkan admin lain terlebih dahulu jika akun ini perlu dinonaktifkan.');
        }

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('login')
            ->with('status', 'Akun berhasil dihapus.');
    }
}
