<x-guest-layout>

<div class="w-full max-w-md">

    <!-- Icon -->
    <div class="flex justify-center mb-6">
        <div class="w-14 h-14 rounded-full bg-gradient-to-r from-pink-500 to-purple-600 flex items-center justify-center text-white text-xl shadow-lg">
            🌸
        </div>
    </div>

    <h2 class="text-3xl font-semibold text-center text-gray-800">
        Selamat Datang
    </h2>
    <p class="text-center text-gray-500 mb-8">
        Masuk ke akun Anda
    </p>

    <div class="bg-white rounded-2xl shadow-xl p-8">

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input type="email" name="email"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none"
                    required autofocus>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <input type="password" name="password"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none"
                    required>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember">
                    Ingat saya
                </label>

                <a href="{{ route('password.request') }}" class="text-pink-500 hover:underline">
                    Lupa password?
                </a>
            </div>

            <button type="submit"
                class="w-full py-2 rounded-lg text-white font-semibold bg-gradient-to-r from-pink-500 to-purple-600 hover:opacity-90 transition">
                Masuk
            </button>
        </form>

    </div>

</div>

</x-guest-layout>