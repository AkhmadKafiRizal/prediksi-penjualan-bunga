<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>🌸 Login - FloraPredict</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('florapredict-favicon.svg') }}?v=20260528">
    <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('florapredict-favicon.svg') }}?v=20260528">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden;
        }

        /* ── Falling stars (unchanged) ── */
        .star {
            position: absolute;
            width: 3px;
            height: 3px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #fff;
            animation: fall linear infinite;
        }
        .star::after {
            content: '';
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 1px;
            background: linear-gradient(90deg, #fff, transparent);
            left: 100%;
        }
        @keyframes fall {
            0%   { transform: translate(0, -10px) rotate(-45deg); opacity: 0; }
            10%  { opacity: 1; }
            80%  { opacity: 1; }
            100% { transform: translate(-500px, 500px) rotate(-45deg); opacity: 0; }
        }

        /* ── Float animation (unchanged) ── */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        /* ── Fade in ── */
        .fade-in {
            animation: fadeIn 0.9s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Left side branding ── */
        .fp-left-brand {
            font-family: 'Cormorant Garamond', Georgia, serif;
            position: relative;
            z-index: 1;
        }
        .fp-left-title {
            font-size: clamp(2.8rem, 5vw, 4.2rem);
            font-weight: 600;
            line-height: 1.1;
            color: #fff;
            text-shadow: 0 3px 8px rgba(0,0,0,0.42), 0 16px 34px rgba(0,0,0,0.45);
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        .fp-left-title em {
            font-style: italic;
            color: #FFE4F0;
            text-shadow: 0 3px 8px rgba(0,0,0,0.42), 0 14px 30px rgba(0,0,0,0.42);
        }
        .fp-left-sub {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: rgba(255,255,255,0.95);
            letter-spacing: 0.02em;
            line-height: 1.6;
            text-shadow: 0 2px 8px rgba(0,0,0,0.45), 0 10px 28px rgba(0,0,0,0.35);
        }
        .fp-left-pills {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .fp-left-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(20,10,16,0.34);
            border: 1px solid rgba(255,255,255,0.55);
            border-radius: 20px;
            padding: 5px 13px;
            font-size: 11.5px;
            font-weight: 600;
            color: #fff;
            backdrop-filter: blur(8px);
            box-shadow: 0 8px 22px rgba(0,0,0,0.22);
            text-shadow: 0 1px 5px rgba(0,0,0,0.45);
            letter-spacing: 0.02em;
        }

        .fp-bg-readability {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(20,10,16,0.62) 0%, rgba(20,10,16,0.42) 34%, rgba(20,10,16,0.12) 64%, rgba(20,10,16,0.12) 100%),
                linear-gradient(0deg, rgba(20,10,16,0.28) 0%, rgba(20,10,16,0.04) 52%);
        }

        /* ── Form card ── */
        .fp-card {
            background: rgba(255, 248, 252, 0.82);
            backdrop-filter: blur(20px) saturate(1.4);
            -webkit-backdrop-filter: blur(20px) saturate(1.4);
            border-radius: 24px;
            padding: 32px 32px 28px;
            border: 1px solid rgba(255,255,255,0.7);
            box-shadow: 0 20px 60px rgba(180, 60, 100, 0.18), 0 4px 20px rgba(0,0,0,0.08);
            width: 420px;
            max-width: 90vw;
        }

        /* ── Card header ── */
        .fp-card-logo {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #E8185A, #F04E8A);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            box-shadow: 0 4px 14px rgba(232,24,90,0.35);
        }
        .fp-card-title {
            font-size: 24px;
            font-weight: 800;
            color: #1A0A12;
            margin-bottom: 4px;
            letter-spacing: -0.3px;
            text-align: center;
        }
        .fp-card-sub {
            font-size: 12.5px;
            color: #B08090;
            margin-bottom: 24px;
            text-align: center;
        }

        /* ── Fields ── */
        .fp-field {
            margin-bottom: 14px;
        }
        .fp-label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            color: #7A3A55;
            margin-bottom: 5px;
            letter-spacing: 0.02em;
        }
        .fp-input-wrap {
            position: relative;
        }
        .fp-input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #D4A0B8;
            font-size: 14px;
            pointer-events: none;
        }
        .fp-input {
            width: 100%;
            padding: 10px 12px 10px 36px;
            border: 1.5px solid #FCE4EF;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
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

        /* ── Row between ── */
        .fp-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .fp-remember {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #9A6070;
            cursor: pointer;
        }
        .fp-remember input[type=checkbox] {
            accent-color: #E8185A;
            width: 13px;
            height: 13px;
        }
        .fp-forgot {
            font-size: 12px;
            font-weight: 600;
            color: #E8185A;
            text-decoration: none;
            transition: opacity 0.15s;
        }
        .fp-forgot:hover { opacity: 0.7; }

        /* ── Submit button ── */
        .fp-submit {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #E8185A 0%, #F04E8A 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 18px rgba(232,24,90,0.35);
            letter-spacing: 0.02em;
        }
        .fp-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(232,24,90,0.45);
        }
        .fp-submit:active { transform: translateY(0); }

        /* ── Error messages ── */
        .fp-errors {
            background: #FFF0F3;
            border: 1px solid #FBCEDE;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 16px;
        }
        .fp-errors li {
            font-size: 12px;
            color: #E8185A;
            font-weight: 600;
            list-style: none;
        }
        .fp-errors li + li { margin-top: 3px; }

        /* ── Session status ── */
        .fp-status {
            background: #ECFDF5;
            border: 1px solid #6EE7B7;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 16px;
            font-size: 12px;
            color: #065F46;
            font-weight: 600;
        }

        /* ── Divider footer ── */
        .fp-footer-txt {
            text-align: center;
            margin-top: 16px;
            font-size: 11px;
            color: #B08090;
        }
    </style>
</head>

<body class="antialiased">

    <!-- Background fullscreen -->
    <div class="fixed inset-0 z-0">
        <img src="{{ asset('images/login_new.png') }}"
             class="object-cover w-full h-full"
             alt="Background Floral">
        <div class="fp-bg-readability"></div>

        <!-- Stars container (unchanged) -->
        <div id="stars-container" class="absolute inset-0 overflow-hidden pointer-events-none"></div>
    </div>

    <div class="relative z-10 flex h-screen w-full">

        <!-- LEFT: Branding -->
        <div class="hidden lg:flex lg:w-[55%] flex-col justify-end p-16 pb-24">
            <div class="animate-float max-w-lg fp-left-brand">
                <div class="fp-left-title">
                    Flora<em>Predict</em>
                </div>
                <div class="fp-left-sub">
                    Prediksi kebutuhan bunga dengan kecerdasan data.<br>
                    Kelola stok lebih efisien, bisnis lebih berkembang.
                </div>
                <div class="fp-left-pills">
                    <span class="fp-left-pill">🌸 Prediksi Akurat</span>
                    <span class="fp-left-pill">📊 Machine Learning</span>
                    <span class="fp-left-pill">✦ Real-time Dashboard</span>
                </div>
            </div>
        </div>

        <!-- RIGHT: Form -->
        <div class="flex w-full lg:w-[45%] items-center justify-center p-8">
            <div class="fade-in">
                {{ $slot }}
            </div>
        </div>

    </div>

    <!-- Falling stars script (unchanged) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('stars-container');
            const numStars = 15;
            for (let i = 0; i < numStars; i++) {
                let star = document.createElement('div');
                star.className = 'star';
                star.style.left = Math.floor(Math.random() * 150) + '%';
                star.style.top = Math.floor(Math.random() * -50) + '%';
                let duration = Math.random() * 3 + 2;
                star.style.animationDuration = duration + 's';
                star.style.animationDelay = Math.random() * 5 + 's';
                container.appendChild(star);
            }
        });
    </script>
</body>
</html>
