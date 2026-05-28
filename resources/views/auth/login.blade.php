<x-guest-layout>

{{-- ✅ SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.fp-card {
    background: rgba(255, 248, 252, 0.85);
    backdrop-filter: blur(20px) saturate(1.4);
    -webkit-backdrop-filter: blur(20px) saturate(1.4);
    border-radius: 24px;
    padding: 36px 36px 28px;
    border: 1px solid rgba(255,255,255,0.7);
    box-shadow: 0 20px 60px rgba(180,60,100,0.18), 0 4px 20px rgba(0,0,0,0.08);
    width: 420px;
    max-width: 90vw;
}

/* Header tengah */
.fp-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin-bottom: 26px;
}
.fp-login-brand {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-bottom: 18px;
}
.fp-login-logo {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #E8185A, #F04E8A);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 18px rgba(232,24,90,0.35);
    border: 1.5px solid rgba(255,255,255,0.85);
}
.fp-login-brand-text {
    text-align: left;
}
.fp-login-brand-name {
    font-size: 20px;
    font-weight: 800;
    color: #1A0A12;
    letter-spacing: -0.35px;
    line-height: 1.1;
}
.fp-login-brand-role {
    font-size: 10px;
    color: #E8185A;
    margin-top: 3px;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
}
.fp-title {
    font-size: 24px;
    font-weight: 800;
    color: #1A0A12;
    letter-spacing: -0.3px;
    margin-bottom: 5px;
}
.fp-subtitle {
    font-size: 13px;
    color: #B08090;
}
.fp-subtitle span {
    color: #E8185A;
    font-weight: 700;
}

/* Fields */
.fp-field { margin-bottom: 16px; }
.fp-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #7A3A55;
    margin-bottom: 6px;
    letter-spacing: 0.02em;
}
.fp-input-wrap { position: relative; }
.fp-input-wrap.has-action .fp-input { padding-right: 46px; }
.fp-input-icon {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #D4A0B8;
    pointer-events: none;
    display: flex;
    align-items: center;
}
.fp-input {
    width: 100%;
    padding: 11px 14px 11px 38px;
    border: 1.5px solid #FCE4EF;
    border-radius: 11px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px;
    color: #1A0A12;
    background: rgba(255,255,255,0.85);
    outline: none;
    transition: all 0.15s;
}
.fp-input:focus {
    border-color: #E8185A;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(232,24,90,0.1);
}
.fp-input::placeholder { color: #D4A0B8; }
.fp-password-toggle {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 9px;
    background: transparent;
    color: #D4A0B8;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.15s, color 0.15s;
}
.fp-password-toggle:hover,
.fp-password-toggle.is-visible {
    background: #FDE8F2;
    color: #E8185A;
}
.fp-password-toggle:focus-visible {
    outline: 2px solid rgba(232,24,90,0.35);
    outline-offset: 2px;
}

/* Row */
.fp-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}
.fp-remember {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 12.5px;
    color: #9A6070;
    cursor: pointer;
    font-weight: 500;
}
.fp-remember input[type=checkbox] {
    accent-color: #E8185A;
    width: 14px;
    height: 14px;
}
.fp-forgot {
    font-size: 12.5px;
    font-weight: 700;
    color: #E8185A;
    text-decoration: none;
    transition: opacity 0.15s;
}
.fp-forgot:hover { opacity: 0.7; }

/* Button */
.fp-submit {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, #E8185A, #F04E8A);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 5px 20px rgba(232,24,90,0.35);
    letter-spacing: 0.02em;
}
.fp-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 26px rgba(232,24,90,0.45);
}
.fp-submit:active { transform: translateY(0); }

/* Error */
.fp-error-box {
    background: #FFF0F3;
    border: 1px solid #FBCEDE;
    border-radius: 11px;
    padding: 11px 14px;
    margin-bottom: 18px;
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 12.5px;
    font-weight: 600;
    color: #E8185A;
    animation: shake .3s ease;
}

/* Footer */
.fp-footer {
    text-align: center;
    margin-top: 18px;
    font-size: 11.5px;
    color: #CCA8BA;
    letter-spacing: 0.02em;
}

@keyframes shake {
    0%,100% { transform: translateX(0); }
    25% { transform: translateX(-4px); }
    75% { transform: translateX(4px); }
}

/* ✅ Custom style SweetAlert2 tema FloraPredict */
.swal-flora-popup {
    border-radius: 20px !important;
    border: 1px solid #FCE4EF !important;
    box-shadow: 0 20px 60px rgba(180,60,100,0.18) !important;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
}
.swal-flora-title {
    font-weight: 800 !important;
    font-size: 18px !important;
    color: #1A0A12 !important;
}
.swal-flora-bar {
    background: #E8185A !important;
}
</style>

<div class="fp-card">

    {{-- Header tengah --}}
    <div class="fp-header">
        <div class="fp-login-brand">
            <div class="fp-login-logo">
                <svg width="26" height="26" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="24" y1="46" x2="24" y2="28" stroke="rgba(255,255,255,0.7)" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M24 38 Q17 33 16 28 Q21 30 24 38Z" fill="rgba(255,255,255,0.6)"/>
                    <ellipse cx="24" cy="15" rx="5" ry="9" fill="rgba(255,255,255,0.95)"/>
                    <ellipse cx="32.8" cy="19.5" rx="5" ry="9" transform="rotate(60 32.8 19.5)" fill="rgba(255,255,255,0.85)"/>
                    <ellipse cx="32.8" cy="28.5" rx="5" ry="9" transform="rotate(120 32.8 28.5)" fill="rgba(255,255,255,0.75)"/>
                    <ellipse cx="24" cy="33" rx="5" ry="9" transform="rotate(180 24 33)" fill="rgba(255,255,255,0.85)"/>
                    <ellipse cx="15.2" cy="28.5" rx="5" ry="9" transform="rotate(240 15.2 28.5)" fill="rgba(255,255,255,0.75)"/>
                    <ellipse cx="15.2" cy="19.5" rx="5" ry="9" transform="rotate(300 15.2 19.5)" fill="rgba(255,255,255,0.85)"/>
                    <ellipse cx="24" cy="17" rx="3.5" ry="6.5" fill="rgba(255,220,235,0.6)"/>
                    <ellipse cx="30.5" cy="20.5" rx="3.5" ry="6.5" transform="rotate(60 30.5 20.5)" fill="rgba(255,220,235,0.5)"/>
                    <ellipse cx="30.5" cy="27.5" rx="3.5" ry="6.5" transform="rotate(120 30.5 27.5)" fill="rgba(255,220,235,0.5)"/>
                    <ellipse cx="24" cy="31" rx="3.5" ry="6.5" transform="rotate(180 24 31)" fill="rgba(255,220,235,0.6)"/>
                    <ellipse cx="17.5" cy="27.5" rx="3.5" ry="6.5" transform="rotate(240 17.5 27.5)" fill="rgba(255,220,235,0.5)"/>
                    <ellipse cx="17.5" cy="20.5" rx="3.5" ry="6.5" transform="rotate(300 17.5 20.5)" fill="rgba(255,220,235,0.6)"/>
                    <circle cx="24" cy="24" r="6" fill="rgba(255,255,255,0.25)" stroke="rgba(255,255,255,0.7)" stroke-width="1.5"/>
                    <circle cx="24" cy="24" r="3.5" fill="rgba(255,255,255,0.9)"/>
                    <circle cx="24" cy="19.5" r="1.1" fill="rgba(255,180,210,0.95)"/>
                    <circle cx="27.7" cy="21.7" r="1.1" fill="rgba(255,180,210,0.95)"/>
                    <circle cx="27.7" cy="26.3" r="1.1" fill="rgba(255,180,210,0.95)"/>
                    <circle cx="24" cy="28.5" r="1.1" fill="rgba(255,180,210,0.95)"/>
                    <circle cx="20.3" cy="26.3" r="1.1" fill="rgba(255,180,210,0.95)"/>
                    <circle cx="20.3" cy="21.7" r="1.1" fill="rgba(255,180,210,0.95)"/>
                </svg>
            </div>
            <div class="fp-login-brand-text">
                <div class="fp-login-brand-name">FloraPredict</div>
                <div class="fp-login-brand-role">Web Admin</div>
            </div>
        </div>
        <div class="fp-title">Selamat Datang</div>
        <div class="fp-subtitle">Masuk ke dashboard <span>FloraPredict</span></div>
    </div>

    {{-- Error --}}
    @if (session('error') || $errors->any())
        <div class="fp-error-box">
            <svg class="shrink-0" style="width:15px;height:15px;margin-top:1px" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span>
                @if ((session('error') ?? $errors->first()) === 'Akun Anda sedang nonaktif. Silakan hubungi admin.')
                    Akun Anda sedang nonaktif.<br>Silakan hubungi admin.
                @else
                    {{ session('error') ?? $errors->first() }}
                @endif
            </span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="fp-field">
            <label class="fp-label">Alamat Email</label>
            <div class="fp-input-wrap">
                <span class="fp-input-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </span>
                <input type="email" name="email" class="fp-input"
                       value="{{ old('email') }}"
                       placeholder="nama@email.com"
                       required autofocus>
            </div>
        </div>

        {{-- Password --}}
        <div class="fp-field">
            <label class="fp-label">Kata Sandi</label>
            <div class="fp-input-wrap has-action">
                <span class="fp-input-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                </span>
                <input type="password" name="password" id="password-input" class="fp-input"
                       placeholder="••••••••"
                       required>
                <button type="button" class="fp-password-toggle" id="password-toggle" aria-label="Lihat kata sandi sebentar" aria-pressed="false">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Remember & Forgot --}}
        <div class="fp-row">
            <label class="fp-remember">
                <input type="checkbox" name="remember">
                Ingat saya
            </label>
            @if (Route::has('password.request'))
                <a class="fp-forgot" href="{{ route('password.request') }}">Lupa password?</a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit" class="fp-submit">Masuk Sekarang</button>
    </form>

    <div class="fp-footer">FloraPredict · Sistem Prediksi Penjualan Bunga</div>
</div>

{{-- ✅ Notifikasi SweetAlert2 setelah logout berhasil --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password-input');
    const passwordToggle = document.getElementById('password-toggle');
    let hidePasswordTimer;

    if (!passwordInput || !passwordToggle) return;

    function hidePassword() {
        passwordInput.type = 'password';
        passwordToggle.classList.remove('is-visible');
        passwordToggle.setAttribute('aria-pressed', 'false');
        passwordToggle.setAttribute('aria-label', 'Lihat kata sandi sebentar');
    }

    passwordToggle.addEventListener('click', function () {
        clearTimeout(hidePasswordTimer);
        passwordInput.type = 'text';
        passwordToggle.classList.add('is-visible');
        passwordToggle.setAttribute('aria-pressed', 'true');
        passwordToggle.setAttribute('aria-label', 'Kata sandi sedang terlihat');
        passwordInput.focus({ preventScroll: true });

        hidePasswordTimer = setTimeout(hidePassword, 1800);
    });
});
</script>

@if(session('logout_success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Logout Berhasil! 👋',
            text: 'Sampai jumpa lagi di FloraPredict.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#FFF8FC',
            color: '#1A0A12',
            iconColor: '#E8185A',
            customClass: {
                popup: 'swal-flora-popup',
                title: 'swal-flora-title',
                timerProgressBar: 'swal-flora-bar'
            }
        });
    });
</script>
@endif

</x-guest-layout>
