<x-guest-layout>
<div class="w-full">
    
    <!-- Header Section -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-16 h-16 mb-6 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full shadow-soft-xl transition-all duration-300 hover:scale-110 text-3xl text-white">
            🌸
        </div>
        <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">
            Selamat Datang
        </h2>
        <p class="text-gray-500 font-medium">
            Akses dashboard prediksi penjualan Anda
        </p>
    </div>

    <!-- Login Card -->
    <div class="bg-white/70 backdrop-blur-xl border border-white/50 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] p-10 relative overflow-hidden">
        
        {{-- 🔴 ERROR MESSAGE --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-sm font-semibold flex items-center gap-3 animate-shake">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Input -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 ml-1">
                    Alamat Gmail
                </label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-pink-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                        </svg>
                    </div>
                    <input type="email" name="email"
                        class="w-full pl-11 pr-4 py-3.5 bg-gray-50/50 border-gray-100 border-2 rounded-2xl focus:ring-4 focus:ring-pink-100 focus:border-pink-400 focus:bg-white outline-none transition-all duration-300 font-medium"
                        required autofocus>
                </div>
            </div>

            <!-- Password Input -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 ml-1">
                    Kata Sandi
                </label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-pink-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" name="password"
                        class="w-full pl-11 pr-4 py-3.5 bg-gray-50/50 border-gray-100 border-2 rounded-2xl focus:ring-4 focus:ring-pink-100 focus:border-pink-400 focus:bg-white outline-none transition-all duration-300 font-medium"
                        required>
                </div>
            </div>

            <!-- Options -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="remember" class="peer hidden">
                        <div class="w-5 h-5 border-2 border-gray-200 rounded-md peer-checked:bg-pink-500 peer-checked:border-pink-500 transition-all"></div>
                        <svg class="absolute top-0.5 left-0.5 h-4 w-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-gray-600 font-semibold group-hover:text-gray-900 transition-colors">Ingat saya</span>
                </label>

                <a href="{{ route('password.request') }}" class="text-pink-600 font-bold hover:text-pink-700 hover:underline underline-offset-4 transition-all">
                    Lupa password?
                </a>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 rounded-2xl text-white font-bold text-lg bg-gradient-to-br from-pink-500 via-pink-600 to-purple-600 shadow-[0_10px_20px_-5px_rgba(236,72,153,0.4)] hover:shadow-[0_15px_30px_-5px_rgba(236,72,153,0.5)] hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300">
                Masuk Sekarang
            </button>
        </form>

    </div>
</div>

<style>
    .shadow-soft-xl {
        box-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05);
    }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .animate-shake {
        animation: shake 0.3s ease-in-out;
    }
</style>
</x-guest-layout>