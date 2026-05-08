<x-guest-layout>
<div class="w-full">

    <!-- Header -->
    <div class="text-center mb-7">
        <div class="inline-flex items-center justify-center w-12 h-12 mb-4 rounded-2xl shadow-lg text-xl" style="background: linear-gradient(135deg, #E8185A, #F04E8A);">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="3" fill="white"/>
                <ellipse cx="12" cy="6" rx="3" ry="5" fill="white" opacity="0.85"/>
                <ellipse cx="12" cy="18" rx="3" ry="5" fill="white" opacity="0.85"/>
                <ellipse cx="6" cy="12" rx="5" ry="3" fill="white" opacity="0.85"/>
                <ellipse cx="18" cy="12" rx="5" ry="3" fill="white" opacity="0.85"/>
            </svg>
        </div>
        <h2 class="text-2xl font-extrabold tracking-tight mb-1" style="color:#1A0A12;letter-spacing:-0.3px">
            Selamat Datang
        </h2>
        <p class="text-xs font-medium" style="color:#B08090">
            Masuk ke dashboard <span style="color:#E8185A;font-weight:700">FloraPredict</span>
        </p>
    </div>

    <!-- Card -->
    <div class="rounded-2xl p-7 relative overflow-hidden" style="background:rgba(255,248,252,0.82);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.7);box-shadow:0 16px 48px rgba(180,60,100,0.16),0 4px 16px rgba(0,0,0,0.06);">

        {{-- Error --}}
        @if (session('error') || $errors->any())
            <div class="mb-5 px-4 py-3 rounded-xl text-xs font-semibold flex items-start gap-2" style="background:#FFF0F3;border:1px solid #FBCEDE;color:#E8185A;animation:shake .3s ease">
                <svg class="w-4 h-4 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
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

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-xs font-bold mb-1.5" style="color:#7A3A55">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4" style="color:#D4A0B8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline stroke-linecap="round" stroke-linejoin="round" points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <input type="email" name="email"
                        class="w-full pl-9 pr-3 py-2.5 text-sm rounded-xl outline-none transition-all font-medium fp-input"
                        placeholder="nama@email.com"
                        required autofocus>
                </div>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-xs font-bold mb-1.5" style="color:#7A3A55">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4" style="color:#D4A0B8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                    </div>
                    <input type="password" name="password"
                        class="w-full pl-9 pr-3 py-2.5 text-sm rounded-xl outline-none transition-all font-medium fp-input"
                        placeholder="••••••••"
                        required>
                </div>
            </div>

            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between pt-0.5">
                <label class="flex items-center gap-2 cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" name="remember" class="peer hidden">
                        <div class="w-4 h-4 rounded border-2 transition-all fp-checkbox"></div>
                        <svg class="absolute top-0.5 left-0.5 h-3 w-3 opacity-0 peer-checked:opacity-100 transition-opacity" style="color:#E8185A" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold" style="color:#9A6070">Ingat saya</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-xs font-bold hover:opacity-70 transition-opacity" style="color:#E8185A">
                    Lupa password?
                </a>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full py-3 rounded-xl text-white text-sm font-bold transition-all duration-200 hover:-translate-y-0.5 active:scale-95"
                style="background:linear-gradient(135deg,#E8185A,#F04E8A);box-shadow:0 6px 20px rgba(232,24,90,0.35);letter-spacing:0.02em">
                Masuk Sekarang
            </button>
        </form>

        <div class="text-center mt-5 text-xs" style="color:#CCA8BA;letter-spacing:0.02em">
            FloraPredict · Sistem Prediksi Penjualan Bunga
        </div>
    </div>
</div>

<style>
    .fp-input {
        background: rgba(255,255,255,0.85);
        border: 1.5px solid #FCE4EF;
        color: #1A0A12;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .fp-input::placeholder { color: #D4A0B8; }
    .fp-input:focus {
        border-color: #E8185A;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(232,24,90,0.1);
    }
    .fp-checkbox {
        border-color: #FCE4EF;
        background: rgba(255,255,255,0.85);
    }
    input[type=checkbox].peer:checked ~ .fp-checkbox {
        border-color: #E8185A;
        background: #E8185A;
    }
    @keyframes shake {
        0%,100% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        75% { transform: translateX(4px); }
    }
</style>
</x-guest-layout>