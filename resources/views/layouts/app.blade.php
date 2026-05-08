<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FloraPredict') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/flora.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --pk1: #E8185A;
            --pk2: #F04E8A;
            --pk3: #F87FB5;
            --pk4: #FDB8D4;
            --pk5: #FDE8F2;
            --pk6: #FFF2F8;
            --dark: #1A0A12;
            --sidebar-w: 230px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #FFF5FA;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ══ SIDEBAR ══ */
        .fp-sidebar {
            width: var(--sidebar-w);
            min-width: var(--sidebar-w);
            height: 100vh;
            background: linear-gradient(160deg, #E8185A 0%, #EF4080 30%, #F472A8 60%, #F9A8CC 85%, #FBCEDE 100%);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
        }

        .fp-sidebar-plant {
            position: absolute;
            bottom: 140px;
            left: -10px;
            width: 200px;
            height: 260px;
            pointer-events: none;
            opacity: 0.18;
        }

        .fp-sparkles {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }
        .fp-sparkle {
            position: absolute;
            fill: white;
            opacity: 0.2;
        }

        .fp-sidebar-brand {
            padding: 24px 20px 16px;
            position: relative;
            z-index: 1;
        }
        .fp-brand-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .fp-brand-logo {
            width: 42px;
            height: 42px;
            background: rgba(255,255,255,0.28);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            backdrop-filter: blur(4px);
            border: 1.5px solid rgba(255,255,255,0.4);
        }
        .fp-brand-name {
            font-size: 19px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.3px;
            line-height: 1.1;
        }
        .fp-brand-role {
            font-size: 9.5px;
            color: rgba(255,255,255,0.72);
            margin-top: 3px;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .fp-nav {
            padding: 10px 14px;
            flex: 1;
            position: relative;
            z-index: 1;
        }
        .fp-nav-label {
            font-size: 0.6rem;
            font-weight: 700;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.18em;
            text-transform: uppercase;
            padding: 10px 10px 6px;
        }
        .fp-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            font-size: 14px;
            font-weight: 600;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 14px;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }
        .fp-nav-item:hover {
            background: rgba(255,255,255,0.18);
            color: #fff;
        }
        .fp-nav-item.active {
            background: rgba(255,255,255,0.25);
            color: #fff;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        .fp-nav-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            background: rgba(255,255,255,0.18);
            flex-shrink: 0;
            transition: all 0.2s;
        }
        .fp-nav-item.active .fp-nav-icon {
            background: rgba(255,255,255,0.32);
        }

        .fp-sidebar-footer {
            padding: 16px 14px 20px;
            position: relative;
            z-index: 1;
            border-top: 1px solid rgba(255,255,255,0.18);
        }
        .fp-user-link {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 14px;
            transition: background 0.2s;
            background: rgba(255,255,255,0.12);
        }
        .fp-user-link:hover { background: rgba(255,255,255,0.2); }
        .fp-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255,255,255,0.35);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 2px solid rgba(255,255,255,0.55);
        }
        .fp-user-name {
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .fp-user-role {
            font-size: 10px;
            color: rgba(255,255,255,0.65);
            margin-top: 1px;
            display: flex;
            align-items: center;
            gap: 3px;
        }
        .fp-logout-btn {
            width: 100%;
            padding: 10px 14px;
            border-radius: 12px;
            border: 1.5px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.14);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .fp-logout-btn:hover {
            background: rgba(255,255,255,0.24);
            border-color: rgba(255,255,255,0.5);
        }
        .fp-logout-icon {
            width: 18px;
            height: 18px;
            opacity: 0.9;
        }

        /* ══ MAIN WRAPPER ══ */
        .fp-main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* ══ TOPBAR ══ */
        .fp-topbar {
            height: 62px;
            min-height: 62px;
            background: #fff;
            border-bottom: 1px solid #FCE4EF;
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 16px;
            flex-shrink: 0;
        }
        .fp-topbar-title {
            flex: 1;
        }
        .fp-topbar-greeting {
            font-size: 15px;
            font-weight: 700;
            color: #1A0A12;
        }
        .fp-topbar-greeting span {
            color: var(--pk1);
        }

        .fp-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #FFF5FA;
            border: 1px solid #FCE4EF;
            border-radius: 10px;
            padding: 7px 14px;
            min-width: 210px;
        }
        .fp-search input {
            border: none;
            background: transparent;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            color: #1A0A12;
            outline: none;
            width: 150px;
        }
        .fp-search input::placeholder { color: #CCA8BA; }
        .fp-search-icon { color: #CCA8BA; font-size: 15px; }

        .fp-topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .fp-profile-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #FFF5FA;
            border: 1px solid #FCE4EF;
            border-radius: 10px;
            padding: 5px 10px 5px 5px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
        }
        .fp-profile-chip:hover { border-color: var(--pk4); background: var(--pk5); }
        .fp-profile-av {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--pk1), var(--pk2));
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .fp-profile-name {
            font-size: 12.5px;
            font-weight: 600;
            color: #1A0A12;
        }
        .fp-profile-role {
            font-size: 10px;
            color: #CCA8BA;
        }

        /* ══ CONTENT ══ */
        .fp-main {
            flex: 1;
            overflow-y: auto;
            background: #FFF5FA;
        }
        .fp-page {
            padding: 24px 28px 52px;
        }

        .fp-eyebrow {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--pk1);
            margin-bottom: 3px;
        }
        .fp-page-title {
            font-size: 22px;
            font-weight: 800;
            color: #1A0A12;
        }
    </style>
</head>
<body>

    <aside class="fp-sidebar">
        <div class="fp-sparkles">
            <svg class="fp-sparkle" style="top:55px;right:18px;width:22px;height:22px" viewBox="0 0 24 24"><path d="M12 2L13.09 9.26L20 12L13.09 14.74L12 22L10.91 14.74L4 12L10.91 9.26Z"/></svg>
            <svg class="fp-sparkle" style="top:80px;right:36px;width:12px;height:12px;opacity:0.12" viewBox="0 0 24 24"><path d="M12 2L13.09 9.26L20 12L13.09 14.74L12 22L10.91 14.74L4 12L10.91 9.26Z"/></svg>
            <svg class="fp-sparkle" style="top:200px;left:14px;width:18px;height:18px;opacity:0.14" viewBox="0 0 24 24"><path d="M12 2L13.09 9.26L20 12L13.09 14.74L12 22L10.91 14.74L4 12L10.91 9.26Z"/></svg>
            <svg class="fp-sparkle" style="top:160px;right:20px;width:8px;height:8px;opacity:0.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
            <svg class="fp-sparkle" style="top:340px;left:22px;width:10px;height:10px;opacity:0.15" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
        </div>

        <div class="fp-sidebar-plant">
            <svg viewBox="0 0 200 260" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 260 Q95 200 100 160 Q105 120 98 80" stroke="white" stroke-width="4" stroke-linecap="round" fill="none"/>
                <path d="M100 200 Q70 180 50 160" stroke="white" stroke-width="3" stroke-linecap="round" fill="none"/>
                <path d="M100 180 Q130 160 150 140" stroke="white" stroke-width="3" stroke-linecap="round" fill="none"/>
                <ellipse cx="45" cy="155" rx="28" ry="14" transform="rotate(-30 45 155)" fill="white" opacity="0.7"/>
                <ellipse cx="155" cy="135" rx="28" ry="14" transform="rotate(30 155 135)" fill="white" opacity="0.7"/>
                <ellipse cx="70" cy="90" rx="22" ry="11" transform="rotate(-45 70 90)" fill="white" opacity="0.6"/>
                <ellipse cx="128" cy="75" rx="22" ry="11" transform="rotate(20 128 75)" fill="white" opacity="0.6"/>
                <ellipse cx="98" cy="60" rx="16" ry="8" transform="rotate(-10 98 60)" fill="white" opacity="0.5"/>
                <circle cx="98" cy="40" r="8" fill="white" opacity="0.8"/>
                <ellipse cx="98" cy="20" rx="7" ry="13" fill="white" opacity="0.6"/>
                <ellipse cx="98" cy="60" rx="7" ry="13" fill="white" opacity="0.6"/>
                <ellipse cx="78" cy="40" rx="13" ry="7" fill="white" opacity="0.6"/>
                <ellipse cx="118" cy="40" rx="13" ry="7" fill="white" opacity="0.6"/>
                <circle cx="98" cy="40" r="5" fill="white" opacity="0.9"/>
            </svg>
        </div>

        <div class="fp-sidebar-brand">
            <div class="fp-brand-row">
                <div class="fp-brand-logo">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="3" fill="white"/>
                        <ellipse cx="12" cy="6" rx="3" ry="5" fill="white" opacity="0.85"/>
                        <ellipse cx="12" cy="18" rx="3" ry="5" fill="white" opacity="0.85"/>
                        <ellipse cx="6" cy="12" rx="5" ry="3" fill="white" opacity="0.85"/>
                        <ellipse cx="18" cy="12" rx="5" ry="3" fill="white" opacity="0.85"/>
                    </svg>
                </div>
                <div>
                    <div class="fp-brand-name">FloraPredict</div>
                    <div class="fp-brand-role">Web Admin</div>
                </div>
            </div>
        </div>

        <nav class="fp-nav">
            <div class="fp-nav-label">Menu</div>

            <a href="{{ route('dashboard') }}"
               class="fp-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="fp-nav-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </span>
                Dashboard
            </a>
            <a href="{{ route('sales') }}"
               class="fp-nav-item {{ request()->routeIs('sales') ? 'active' : '' }}">
                <span class="fp-nav-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>
                    </svg>
                </span>
                Data Penjualan
            </a>
            <a href="{{ route('products.index') }}"
               class="fp-nav-item {{ request()->routeIs('products*') ? 'active' : '' }}">
                <span class="fp-nav-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="white" opacity="0.9">
                        <circle cx="12" cy="12" r="2.5"/>
                        <ellipse cx="12" cy="5.5" rx="2" ry="3.5"/>
                        <ellipse cx="12" cy="18.5" rx="2" ry="3.5"/>
                        <ellipse cx="5.5" cy="12" rx="3.5" ry="2"/>
                        <ellipse cx="18.5" cy="12" rx="3.5" ry="2"/>
                    </svg>
                </span>
                Produk Bunga
            </a>
            <a href="{{ route('users.index') }}"
               class="fp-nav-item {{ request()->routeIs('users*') ? 'active' : '' }}">
                <span class="fp-nav-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </span>
                Manajemen Kasir
            </a>
        </nav>

        <div class="fp-sidebar-footer">
            <a href="{{ route('profile.edit') }}" class="fp-user-link">
                <div class="fp-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div style="overflow:hidden;flex:1">
                    <div class="fp-user-name">{{ Auth::user()->name }}</div>
                    <div class="fp-user-role">
                        Web Administrator
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.65)" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="fp-logout-btn" type="submit">
                    <svg class="fp-logout-icon" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="fp-main-wrapper">
        <!-- TOPBAR (notifikasi dihapus) -->
        <header class="fp-topbar">
            <div class="fp-topbar-title">
                <div class="fp-topbar-greeting">
                    Selamat datang kembali, <span>{{ Auth::user()->name }}!</span>
                </div>
            </div>

            <div class="fp-search">
                <span class="fp-search-icon">🔍</span>
                <input type="text" placeholder="Cari sesuatu...">
            </div>

            <div class="fp-topbar-actions">
                <a href="{{ route('profile.edit') }}" class="fp-profile-chip">
                    <div class="fp-profile-av">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div>
                        <div class="fp-profile-name">{{ Auth::user()->name }}</div>
                        <div class="fp-profile-role">Administrator</div>
                    </div>
                </a>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="fp-main">
            <div class="fp-page">
                {{ $slot }}
            </div>
        </div>
    </div>

</body>
</html>