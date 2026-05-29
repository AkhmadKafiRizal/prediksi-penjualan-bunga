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

        <div class="fp-card-title">Lupa Password?</div>
        <div class="fp-card-sub">Masukkan email akun untuk menerima link reset password</div>

        @if (session('status'))
            <div class="fp-status">
                Jika email terdaftar, link reset password sudah kami kirim. Silakan cek inbox atau folder spam.
            </div>
        @endif

        @if ($errors->any())
            <ul class="fp-errors" role="alert">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

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
                           value="{{ old('email') }}" placeholder="nama@email.com"
                           required autocomplete="email">
                </div>
            </div>

            <button type="submit" class="fp-submit">Kirim Link Reset Password</button>
        </form>

        <a href="{{ route('login') }}" class="fp-auth-return" aria-label="Kembali ke halaman login">
            <span>Ingat password?</span>
            <strong>Kembali ke login</strong>
        </a>
    </div>
</x-guest-layout>
