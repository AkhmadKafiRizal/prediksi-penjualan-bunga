<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FloraPredict') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
   @vite(['resources/css/flora.css', 'resources/js/app.js'])
</head>
<body>

    {{-- ══════════════════════ --}}
    {{-- NAVBAR - selalu di atas --}}
    {{-- ══════════════════════ --}}
    <nav>
    <a href="{{ route('dashboard') }}" class="nav-brand">
        <div class="logo-icon">🌸</div>
        FloraPredict
    </a>

    <div class="nav-links">
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
           Dashboard
        </a>

        <a href="{{ route('sales') }}"
           class="nav-link {{ request()->routeIs('sales') ? 'active' : '' }}">
           Data Penjualan
        </a>
    </div>

    <div class="nav-right">
        <div class="nav-user">
            <div class="avatar">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <span>{{ Auth::user()->name }}</span>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn-logout">Logout</button>
        </form>
    </div>
</nav>


    {{-- Page header (judul halaman) --}}
    @isset($header)
    <div class="flora-page-header">
        <div class="flora-page-header-inner">
            {{ $header }}
        </div>
    </div>
    @endisset

    {{-- Konten halaman --}}
    <main>
        {{ $slot }}
    </main>

</body>
</html>