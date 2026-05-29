<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
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
        $user = $request->user();
        $user->fill($request->validated());

        $emailChanged = $user->isDirty('email');

        if ($emailChanged && $user instanceof MustVerifyEmail) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($emailChanged && $user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();

            return Redirect::route('verification.notice')
                ->with('status', 'profile-updated-verification-sent');
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Send a password reset link to the signed-in user's email address.
     */
    public function sendPasswordResetLink(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user?->email) {
            return Redirect::route('profile.edit')
                ->with('error', 'Email akun belum tersedia. Tambahkan Gmail/email terlebih dahulu sebelum meminta link reset password.');
        }

        $status = Password::sendResetLink([
            'email' => $user->email,
        ]);

        return $status === Password::RESET_LINK_SENT
            ? Redirect::route('profile.edit')->with('status', 'password-reset-link-sent')
            : Redirect::route('profile.edit')->with('error', __($status));
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
