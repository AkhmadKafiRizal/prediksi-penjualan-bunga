<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FloraPredict') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/flora.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8f5f6;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ══════════════════════════════
           SIDEBAR
        ══════════════════════════════ */
        .fp-sidebar {
            width: 210px;
            min-width: 210px;
            height: 100vh;
            background: #ffffff;
            border-right: 1px solid #f0e4e7;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            flex-shrink: 0;
        }

        /* Brand */
        .fp-sidebar-brand {
            padding: 20px 18px 16px;
            border-bottom: 1px solid #f0e4e7;
        }
        .fp-brand-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .fp-brand-logo {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #e85d75, #f4a0b0);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        .fp-brand-name {
            font-size: 15px;
            font-weight: 700;
            color: #e85d75;
            letter-spacing: -0.3px;
        }
        .fp-brand-role {
            font-size: 11px;
            color: #b0aabb;
            margin-top: 4px;
            padding-left: 38px;
        }

        /* Nav items */
        .fp-nav {
            padding: 12px 0;
            flex: 1;
        }
        .fp-nav-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 500;
            color: #8a8aa0;
            text-decoration: none;
            transition: all 0.15s ease;
            border-left: 3px solid transparent;
        }
        .fp-nav-item:hover {
            background: #fff5f7;
            color: #4a4a6a;
        }
        .fp-nav-item.active {
            background: #fff0f3;
            color: #c0253a;
            border-left-color: #e85d75;
            font-weight: 600;
        }
        .fp-nav-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #ddd8e0;
            flex-shrink: 0;
            transition: background 0.15s;
        }
        .fp-nav-item.active .fp-nav-dot {
            background: #e85d75;
        }

        /* ══════════════════════════════
           FOOTER SIDEBAR
           Klik nama/avatar → profile.edit
        ══════════════════════════════ */
        .fp-sidebar-footer {
            padding: 14px 18px;
            border-top: 1px solid #f0e4e7;
        }

        /* Baris avatar + nama — bisa diklik ke profil */
        .fp-user-link {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 10px;
            text-decoration: none;
            padding: 6px 8px;
            border-radius: 8px;
            transition: background 0.15s;
            margin-left: -8px;
            margin-right: -8px;
        }
        .fp-user-link:hover {
            background: #fff0f3;
        }
        .fp-user-link:hover .fp-user-name {
            color: #e85d75;
        }

        .fp-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e85d75, #f4a0b0);
            color: white;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .fp-user-name {
            font-size: 12px;
            font-weight: 600;
            color: #4a4a6a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: color 0.15s;
        }
        .fp-user-role {
            font-size: 10px;
            color: #b0aabb;
        }
        .fp-user-edit-hint {
            font-size: 10px;
            color: #d0b0bb;
            margin-top: 1px;
        }

        .fp-logout-btn {
            width: 100%;
            padding: 7px 12px;
            border-radius: 8px;
            border: 1px solid #f0e4e7;
            background: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: #9090aa;
            cursor: pointer;
            transition: all 0.15s;
        }
        .fp-logout-btn:hover {
            background: #fff0f3;
            color: #e85d75;
            border-color: #f4c0cb;
        }

        /* ══════════════════════════════
           MAIN CONTENT
        ══════════════════════════════ */
        .fp-main {
            flex: 1;
            overflow-y: auto;
        }
        .fp-page {
            padding: 28px 28px 48px;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="fp-sidebar">

        <!-- Brand -->
        <div class="fp-sidebar-brand">
            <div class="fp-brand-row">
                <div class="fp-brand-logo">🌸</div>
                <span class="fp-brand-name">FloraPredict</span>
            </div>
            <div class="fp-brand-role">Web Admin</div>
        </div>

        <!-- Navigation -->
        <nav class="fp-nav">
            <a href="{{ route('dashboard') }}"
               class="fp-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="fp-nav-dot"></span> Dashboard
            </a>

            <a href="{{ route('sales') }}"
               class="fp-nav-item {{ request()->routeIs('sales') ? 'active' : '' }}">
                <span class="fp-nav-dot"></span> Data Penjualan
            </a>
            <a href="{{ route('products.index') }}"
             class="fp-nav-item {{ request()->routeIs('products*') ? 'active' : '' }}">
            <span class="fp-nav-dot"></span> Produk Bunga
            </a>
            <a href="{{ route('users.index') }}"
   class="fp-nav-item {{ request()->routeIs('users*') ? 'active' : '' }}">
    <span class="fp-nav-dot"></span> Manajemen Kasir
</a>
        </nav>
            
        <!-- Footer: klik nama/avatar → profile, tombol logout -->
        <div class="fp-sidebar-footer">

            {{-- Klik area ini → ke halaman Pengaturan/Profile --}}
            <a href="{{ route('profile.edit') }}" class="fp-user-link">
                <div class="fp-avatar">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div style="overflow:hidden;">
                    <div class="fp-user-name">{{ Auth::user()->name }}</div>
                    <div class="fp-user-edit-hint">Klik untuk pengaturan →</div>
                </div>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="fp-logout-btn" type="submit">Logout</button>
            </form>
        </div>

    </aside>

    <!-- KONTEN UTAMA -->
    <div class="fp-main">
        <div class="fp-page">
            {{ $slot }}
        </div>
    </div>

</body>
</html>