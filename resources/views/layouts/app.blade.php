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
            background: #fdf6f0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ══ SIDEBAR ══ */
        .fp-sidebar {
            width: 220px;
            min-width: 220px;
            height: 100vh;
            background: linear-gradient(180deg, #fff5f7 0%, #fff 60%);
            border-right: 1px solid #f5dde4;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            flex-shrink: 0;
            box-shadow: 2px 0 16px rgba(232,93,117,0.06);
        }

        /* Brand */
        .fp-sidebar-brand {
            padding: 22px 18px 18px;
            border-bottom: 1px solid #f5dde4;
            background: linear-gradient(135deg, #fff0f3, #fff5f7);
        }
        .fp-brand-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .fp-brand-logo {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, #e85d75, #f4a0b0, #fbc4d0);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(232,93,117,0.35);
        }
        .fp-brand-name {
            font-size: 16px;
            font-weight: 700;
            background: linear-gradient(135deg, #c0253a, #e85d75);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.3px;
        }
        .fp-brand-role {
            font-size: 10px;
            color: #c9a0ab;
            margin-top: 5px;
            padding-left: 44px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* Nav */
        .fp-nav {
            padding: 14px 10px;
            flex: 1;
        }
        .fp-nav-label {
            font-size: 0.62rem;
            font-weight: 700;
            color: #c9a0ab;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 8px 10px 4px;
        }
        .fp-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            font-size: 13px;
            font-weight: 500;
            color: #9080a0;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 2px;
            transition: all 0.15s ease;
            border-left: 3px solid transparent;
        }
        .fp-nav-item:hover {
            background: linear-gradient(135deg, #fff0f3, #fdf5f7);
            color: #c0253a;
        }
        .fp-nav-item.active {
            background: linear-gradient(135deg, #fde8ec, #fff0f3);
            color: #c0253a;
            font-weight: 600;
            border-left-color: #e85d75;
            box-shadow: 0 2px 8px rgba(232,93,117,0.12);
        }
        .fp-nav-icon {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            background: #f5eef0;
            flex-shrink: 0;
            transition: all 0.15s;
        }
        .fp-nav-item.active .fp-nav-icon {
            background: linear-gradient(135deg, #e85d75, #f4a0b0);
            box-shadow: 0 3px 8px rgba(232,93,117,0.3);
        }

        /* Footer */
        .fp-sidebar-footer {
            padding: 14px 12px;
            border-top: 1px solid #f5dde4;
            background: linear-gradient(135deg, #fff5f7, #fff);
        }
        .fp-user-link {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            text-decoration: none;
            padding: 8px 10px;
            border-radius: 10px;
            transition: background 0.15s;
        }
        .fp-user-link:hover { background: #fde8ec; }
        .fp-user-link:hover .fp-user-name { color: #e85d75; }
        .fp-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e85d75, #f4a0b0);
            color: white;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 3px 8px rgba(232,93,117,0.3);
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
        .fp-user-edit-hint {
            font-size: 10px;
            color: #c9a0ab;
            margin-top: 1px;
        }
        .fp-logout-btn {
            width: 100%;
            padding: 8px 12px;
            border-radius: 9px;
            border: 1px solid #f5dde4;
            background: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: #9090aa;
            cursor: pointer;
            transition: all 0.15s;
        }
        .fp-logout-btn:hover {
            background: linear-gradient(135deg, #fde8ec, #fff0f3);
            color: #e85d75;
            border-color: #f4c0cb;
        }

        /* ══ MAIN ══ */
        .fp-main {
            flex: 1;
            overflow-y: auto;
            background: #fdf6f0;
        }
        .fp-page {
            padding: 30px 32px 52px;
        }
    </style>
</head>
<body>

    <aside class="fp-sidebar">
        <div class="fp-sidebar-brand">
            <div class="fp-brand-row">
                <div class="fp-brand-logo">🌸</div>
                <span class="fp-brand-name">FloraPredict</span>
            </div>
            <div class="fp-brand-role">Web Admin</div>
        </div>

        <nav class="fp-nav">
            <div class="fp-nav-label">Menu</div>

            <a href="{{ route('dashboard') }}"
               class="fp-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="fp-nav-icon">📊</span> Dashboard
            </a>
            <a href="{{ route('sales') }}"
               class="fp-nav-item {{ request()->routeIs('sales') ? 'active' : '' }}">
                <span class="fp-nav-icon">📈</span> Data Penjualan
            </a>
            <a href="{{ route('products.index') }}"
               class="fp-nav-item {{ request()->routeIs('products*') ? 'active' : '' }}">
                <span class="fp-nav-icon">🌺</span> Produk Bunga
            </a>
            <a href="{{ route('users.index') }}"
               class="fp-nav-item {{ request()->routeIs('users*') ? 'active' : '' }}">
                <span class="fp-nav-icon">👤</span> Manajemen Kasir
            </a>
        </nav>

        <div class="fp-sidebar-footer">
            <a href="{{ route('profile.edit') }}" class="fp-user-link">
                <div class="fp-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
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

    <div class="fp-main">
        <div class="fp-page">
            {{ $slot }}
        </div>
    </div>

</body>
</html>