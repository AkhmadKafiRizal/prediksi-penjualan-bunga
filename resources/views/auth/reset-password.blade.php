<x-guest-layout>
    <div class="fp-card">
        <div class="fp-auth-brand">
            <div class="fp-auth-logo">
                <svg width="26" height="26" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <line x1="24" y1="46" x2="24" y2="28" stroke="rgba(255,255,255,0.7)" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M24 38 Q17 33 16 28 Q21 30 24 38Z" fill="rgba(255,255,255,0.6)"/>
                    <ellipse cx="24" cy="15" rx="5" ry="9" fill="rgba(255,255,255,0.95)"/>
                    <ellipse cx="32.8" cy="19.5" rx="5" ry="9" transform="rotate(60 32.8 19.5)" fill="rgba(255,255,255,0.85)"/>
                    <ellipse cx="32.8" cy="28.5" rx="5" ry="9" transform="rotate(120 32.8 28.5)" fill="rgba(255,255,255,0.75)"/>
                    <ellipse cx="24" cy="33" rx="5" ry="9" transform="rotate(180 24 33)" fill="rgba(255,255,255,0.85)"/>
                    <ellipse cx="15.2" cy="28.5" rx="5" ry="9" transform="rotate(240 15.2 28.5)" fill="rgba(255,255,255,0.75)"/>
                    <ellipse cx="15.2" cy="19.5" rx="5" ry="9" transform="rotate(300 15.2 19.5)" fill="rgba(255,255,255,0.85)"/>
                    <circle cx="24" cy="24" r="6" fill="rgba(255,255,255,0.25)" stroke="rgba(255,255,255,0.7)" stroke-width="1.5"/>
                    <circle cx="24" cy="24" r="3.5" fill="rgba(255,255,255,0.9)"/>
                </svg>
            </div>
            <div class="fp-auth-brand-text">
                <div class="fp-auth-brand-name">FloraPredict</div>
                <div class="fp-auth-brand-role">Web Admin</div>
            </div>
        </div>

        <div class="fp-card-title">Buat Password Baru</div>
        <div class="fp-card-sub">Gunakan password yang aman untuk melindungi akun kamu</div>

        @if ($errors->any())
            <ul class="fp-errors" role="alert">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="fp-field">
                <label class="fp-label" for="email">Alamat Email</label>
                <div class="fp-input-wrap">
                    <span class="fp-input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <path d="m22 6-10 7L2 6"/>
                        </svg>
                    </span>
                    <input id="email" class="fp-input" type="email" name="email"
                           value="{{ old('email', $request->email) }}" placeholder="nama@email.com"
                           required autocomplete="username">
                </div>
            </div>

            <div class="fp-field">
                <label class="fp-label" for="password">Password Baru</label>
                <div class="fp-input-wrap">
                    <span class="fp-input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                    <input id="password" class="fp-input" type="password" name="password"
                           placeholder="Minimal 8 karakter" required autocomplete="new-password">
                </div>
            </div>

            <div class="fp-field">
                <label class="fp-label" for="password_confirmation">Konfirmasi Password Baru</label>
                <div class="fp-input-wrap">
                    <span class="fp-input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                    </span>
                    <input id="password_confirmation" class="fp-input" type="password"
                           name="password_confirmation" placeholder="Ulangi password baru"
                           required autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="fp-submit">Simpan Password Baru</button>
        </form>

        <a href="{{ route('login') }}" class="fp-auth-return" aria-label="Masuk ke akun lewat halaman login">
            <span>Sudah berhasil mengganti password?</span>
            <strong>Masuk ke akun</strong>
        </a>
    </div>
</x-guest-layout>
